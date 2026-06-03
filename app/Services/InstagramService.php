<?php

namespace App\Services;

use App\Models\InstagramReel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramService
{
    protected string $graphUrl;

    protected ?string $accessToken;

    protected ?string $userId;

    protected string $username;

    protected int $limit;

    public function __construct()
    {
        $config = config('services.instagram', []);
        $this->graphUrl = rtrim($config['graph_url'] ?? 'https://graph.facebook.com/v21.0', '/');
        $this->accessToken = $config['access_token'] ?? null;
        $this->userId = $config['user_id'] ?? null;
        $this->username = $config['username'] ?? 'perch.life';
        $this->limit = max(1, min(25, (int) ($config['reels_limit'] ?? 10)));
    }

    public function isConfigured(): bool
    {
        return ! empty($this->accessToken);
    }

    /**
     * @return Collection<int, array{url: string, media_id: string, timestamp: ?string}>
     */
    public function fetchReels(): Collection
    {
        if (! $this->isConfigured()) {
            return collect();
        }

        $igUserId = $this->resolveInstagramUserId();
        if ($igUserId === null) {
            Log::warning('Instagram: could not resolve business account ID');

            return collect();
        }

        $media = $this->fetchMedia($igUserId);

        return collect($media)
            ->filter(fn (array $item) => $this->isReel($item))
            ->take($this->limit)
            ->map(fn (array $item) => [
                'url' => $this->normalizeUrl($item['permalink'] ?? ''),
                'media_id' => (string) ($item['id'] ?? ''),
                'timestamp' => $item['timestamp'] ?? null,
            ])
            ->filter(fn (array $item) => $item['url'] !== '' && InstagramReel::urlToEmbedUrl($item['url']) !== null)
            ->values();
    }

    /**
     * @return array{added: int, skipped: int, total: int, error: ?string}
     */
    public function syncReelsToDatabase(): array
    {
        if (! $this->isConfigured()) {
            return [
                'added' => 0,
                'skipped' => 0,
                'total' => 0,
                'error' => 'Instagram API is not configured. Add INSTAGRAM_ACCESS_TOKEN to .env.',
            ];
        }

        try {
            $reels = $this->fetchReels();
        } catch (\Throwable $e) {
            Log::error('Instagram sync failed', ['message' => $e->getMessage()]);

            return [
                'added' => 0,
                'skipped' => 0,
                'total' => 0,
                'error' => $e->getMessage(),
            ];
        }

        if ($reels->isEmpty()) {
            return [
                'added' => 0,
                'skipped' => 0,
                'total' => 0,
                'error' => 'No reels returned from Instagram. Check token permissions and that @'.$this->username.' is a Business account.',
            ];
        }

        $added = 0;
        $skipped = 0;

        foreach ($reels->values() as $index => $reel) {
            $exists = InstagramReel::where('url', $reel['url'])->exists();
            if ($exists) {
                $skipped++;

                continue;
            }

            InstagramReel::create([
                'url' => $reel['url'],
                'sort_order' => $index,
            ]);
            $added++;
        }

        return [
            'added' => $added,
            'skipped' => $skipped,
            'total' => $reels->count(),
            'error' => null,
        ];
    }

    protected function resolveInstagramUserId(): ?string
    {
        if (! empty($this->userId)) {
            return $this->userId;
        }

        $response = $this->graphGet('me', [
            'fields' => 'instagram_business_account{id,username}',
        ]);

        $account = $response['instagram_business_account'] ?? null;
        if (is_array($account) && ! empty($account['id'])) {
            return (string) $account['id'];
        }

        $pages = $this->graphGet('me/accounts', [
            'fields' => 'instagram_business_account{id,username}',
            'limit' => 50,
        ]);

        foreach ($pages['data'] ?? [] as $page) {
            $ig = $page['instagram_business_account'] ?? null;
            if (! is_array($ig) || empty($ig['id'])) {
                continue;
            }

            $pageUsername = strtolower((string) ($ig['username'] ?? ''));
            if ($pageUsername === '' || $pageUsername === strtolower($this->username)) {
                return (string) $ig['id'];
            }
        }

        return null;
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function fetchMedia(string $igUserId): array
    {
        $response = $this->graphGet("{$igUserId}/media", [
            'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp',
            'limit' => min($this->limit * 4, 50),
        ]);

        return $response['data'] ?? [];
    }

    /**
     * @param  array<string, mixed>  $item
     */
    protected function isReel(array $item): bool
    {
        $permalink = strtolower((string) ($item['permalink'] ?? ''));

        if (str_contains($permalink, '/reel/') || str_contains($permalink, '/reels/')) {
            return true;
        }

        return ($item['media_type'] ?? '') === 'VIDEO' && str_contains($permalink, 'instagram.com');
    }

    protected function normalizeUrl(string $url): string
    {
        $url = trim($url);
        if ($url === '') {
            return '';
        }

        $url = rtrim($url, '/').'/';

        return $url;
    }

    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    protected function graphGet(string $path, array $query = []): array
    {
        $query['access_token'] = $this->accessToken;

        $response = Http::timeout(20)->get("{$this->graphUrl}/".ltrim($path, '/'), $query);

        if (! $response->successful()) {
            $body = $response->json();
            $message = $body['error']['message'] ?? $response->body();
            throw new \RuntimeException((string) $message);
        }

        return $response->json() ?? [];
    }
}
