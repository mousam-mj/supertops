<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\CustomizeConfigService;
use Illuminate\Http\Request;

class CustomizeSettingsController extends Controller
{
    public function index()
    {
        $rowCount = 12;

        $raw = CustomizeConfigService::getGlobalCustomizeConfig();
        $merged = CustomizeConfigService::mergedForAdminForm($raw);

        $paddedPalettes = [
            'bottle' => $this->padPalette($merged['bottle_colors'] ?? [], $rowCount),
            'cap' => $this->padPalette($merged['cap_colors'] ?? [], $rowCount),
            'strap' => $this->padPalette($merged['strap_colors'] ?? [], $rowCount),
            'handle' => $this->padPalette($merged['handle_colors'] ?? [], $rowCount),
            'boot' => $this->padPalette($merged['boot_colors'] ?? [], $rowCount),
        ];

        $sizesRows = $this->padSizes($merged['sizes'] ?? [], 5);

        $displayName = (string) ($raw['display_name'] ?? '');

        return view('admin.customize.index', [
            'paddedPalettes' => $paddedPalettes,
            'sizesRows' => $sizesRows,
            'displayName' => $displayName,
            'hasGlobalSaved' => CustomizeConfigService::getGlobalCustomizeConfig() !== [],
        ]);
    }

    /**
     * @param  array<int, array{name?: string, hex?: string}>  $colors
     * @return array<int, array{name: string, hex: string}>
     */
    private function padPalette(array $colors, int $targetRows): array
    {
        $out = [];
        foreach ($colors as $c) {
            if (!is_array($c)) {
                continue;
            }
            $name = trim((string) ($c['name'] ?? ''));
            $hex = trim((string) ($c['hex'] ?? '#888888'));
            if ($name === '') {
                continue;
            }
            if ($hex !== '' && !str_starts_with($hex, '#')) {
                $hex = '#'.$hex;
            }
            $out[] = ['name' => $name, 'hex' => $hex];
        }
        while (count($out) < $targetRows) {
            $out[] = ['name' => '', 'hex' => '#888888'];
        }

        return $out;
    }

    /**
     * @param  array<int, array{name?: string, desc?: string, price?: float|int|string}>  $sizes
     * @return array<int, array{name: string, desc: string, price: string}>
     */
    private function padSizes(array $sizes, int $targetRows): array
    {
        $out = [];
        foreach ($sizes as $s) {
            if (!is_array($s)) {
                continue;
            }
            $name = trim((string) ($s['name'] ?? ''));
            if ($name === '') {
                continue;
            }
            $out[] = [
                'name' => $name,
                'desc' => trim((string) ($s['desc'] ?? '')),
                'price' => (string) ($s['price'] ?? '0'),
            ];
        }
        while (count($out) < $targetRows) {
            $out[] = ['name' => '', 'desc' => '', 'price' => ''];
        }

        return $out;
    }

    public function update(Request $request)
    {
        $request->validate([
            'display_name' => 'nullable|string|max:255',
        ]);

        $cfg = CustomizeConfigService::getGlobalCustomizeConfig();

        $cfg['bottle_colors'] = $this->parsePalette($request->input('palette_bottle', []));
        $cfg['cap_colors'] = $this->parsePalette($request->input('palette_cap', []));
        $cfg['strap_colors'] = $this->parsePalette($request->input('palette_strap', []));
        $cfg['handle_colors'] = $this->parsePalette($request->input('palette_handle', []));
        $cfg['boot_colors'] = $this->parsePalette($request->input('palette_boot', []));

        $sizes = $this->parseSizes($request->input('sizes', []));
        if (empty($sizes)) {
            return redirect()->back()->withInput()->withErrors(['sizes' => 'Add at least one size with name and price.']);
        }
        $cfg['sizes'] = $sizes;

        unset($cfg['engraving_price'], $cfg['has_engraving']);

        if ($request->filled('display_name')) {
            $cfg['display_name'] = trim((string) $request->display_name);
        } else {
            unset($cfg['display_name']);
        }

        Setting::set(CustomizeConfigService::SETTING_GLOBAL, json_encode($cfg, JSON_UNESCAPED_UNICODE));

        return redirect()
            ->route('admin.customize.index')
            ->with('success', 'Customizer settings saved.');
    }

    /**
     * @param  array<int, mixed>  $rows
     * @return array<int, array{name: string, hex: string}>
     */
    private function parsePalette(array $rows): array
    {
        $out = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $name = trim((string) ($row['name'] ?? ''));
            if ($name === '') {
                continue;
            }
            $hex = trim((string) ($row['hex'] ?? '#888888'));
            if ($hex !== '' && !str_starts_with($hex, '#')) {
                $hex = '#'.$hex;
            }
            if (preg_match('/^#([0-9A-Fa-f]{3})$/', $hex, $m)) {
                $h = $m[1];
                $hex = '#'.$h[0].$h[0].$h[1].$h[1].$h[2].$h[2];
            }
            if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $hex)) {
                $hex = '#888888';
            }
            $out[] = ['name' => $name, 'hex' => strtolower($hex)];
        }

        return $out;
    }

    /**
     * @param  array<int, mixed>  $rows
     * @return array<int, array{name: string, desc: string, price: float}>
     */
    private function parseSizes(array $rows): array
    {
        $out = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $name = trim((string) ($row['name'] ?? ''));
            if ($name === '') {
                continue;
            }
            $out[] = [
                'name' => $name,
                'desc' => trim((string) ($row['desc'] ?? '')),
                'price' => max(0, (float) ($row['price'] ?? 0)),
            ];
        }

        return $out;
    }
}
