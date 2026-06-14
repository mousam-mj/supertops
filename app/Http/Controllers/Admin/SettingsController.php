<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    protected array $settingKeys = [
        'general' => [
            'site_name',
            'site_logo',
            'contact_email',
            'contact_phone',
            'contact_address',
            'contact_address_line2',
            'contact_city',
            'contact_state',
            'contact_pincode',
            'helpline_number',
            'working_hours',
            'map_embed',
            'contact_location_heading',
            'currency',
            'currency_symbol',
        ],
        'content' => [
            'contact_page_text',
            'benefit_1_icon',
            'benefit_1_title',
            'benefit_1_text',
            'benefit_2_icon',
            'benefit_2_title',
            'benefit_2_text',
            'benefit_3_icon',
            'benefit_3_title',
            'benefit_3_text',
            'benefit_4_icon',
            'benefit_4_title',
            'benefit_4_text',
        ],
        'social' => [
            'facebook_url',
            'instagram_url',
            'twitter_url',
            'youtube_url',
            'pinterest_url',
            'whatsapp_number',
        ],
        'other' => [
            'copyright_text',
            'free_shipping_text',
            'meta_description',
            'product_feature_1_title',
            'product_feature_1_text',
            'product_feature_2_title',
            'product_feature_2_text',
            'product_feature_3_title',
            'product_feature_3_text',
            'product_feature_4_title',
            'product_feature_4_text',
        ],
    ];

    public function index()
    {
        $settings = Setting::allAsArray();
        return view('admin.settings.index', [
            'settings' => $settings,
            'settingKeys' => $this->settingKeys,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:500',
            'contact_address_line2' => 'nullable|string|max:255',
            'contact_city' => 'nullable|string|max:100',
            'contact_state' => 'nullable|string|max:100',
            'contact_pincode' => 'nullable|string|max:20',
            'helpline_number' => 'nullable|string|max:50',
            'working_hours' => 'nullable|string|max:1000',
            'map_embed' => 'nullable|string|max:3000',
            'contact_location_heading' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'contact_page_text' => 'nullable|string|max:2000',
            'benefit_1_icon' => 'nullable|string|max:100',
            'benefit_1_title' => 'nullable|string|max:255',
            'benefit_1_text' => 'nullable|string|max:1000',
            'benefit_2_icon' => 'nullable|string|max:100',
            'benefit_2_title' => 'nullable|string|max:255',
            'benefit_2_text' => 'nullable|string|max:1000',
            'benefit_3_icon' => 'nullable|string|max:100',
            'benefit_3_title' => 'nullable|string|max:255',
            'benefit_3_text' => 'nullable|string|max:1000',
            'benefit_4_icon' => 'nullable|string|max:100',
            'benefit_4_title' => 'nullable|string|max:255',
            'benefit_4_text' => 'nullable|string|max:1000',
            'facebook_url' => 'nullable|string|max:500',
            'instagram_url' => 'nullable|string|max:500',
            'twitter_url' => 'nullable|string|max:500',
            'youtube_url' => 'nullable|string|max:500',
            'pinterest_url' => 'nullable|string|max:500',
            'whatsapp_number' => 'nullable|string|max:20',
            'copyright_text' => 'nullable|string|max:500',
            'free_shipping_text' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'product_feature_1_title' => 'nullable|string|max:100',
            'product_feature_1_text' => 'nullable|string|max:500',
            'product_feature_2_title' => 'nullable|string|max:100',
            'product_feature_2_text' => 'nullable|string|max:500',
            'product_feature_3_title' => 'nullable|string|max:100',
            'product_feature_3_text' => 'nullable|string|max:500',
            'product_feature_4_title' => 'nullable|string|max:100',
            'product_feature_4_text' => 'nullable|string|max:500',
        ]);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $validated['site_logo'] = $request->file('site_logo')->store('settings', 'public');
        } else {
            $validated['site_logo'] = Setting::get('site_logo', '');
        }

        $allKeys = array_merge(
            $this->settingKeys['general'],
            $this->settingKeys['content'],
            $this->settingKeys['social'],
            $this->settingKeys['other']
        );

        foreach ($allKeys as $key) {
            $value = $validated[$key] ?? $request->input($key, '');
            if ($key === 'working_hours') {
                $value = $this->normalizeWorkingHours($value);
            }
            Setting::set($key, $value ?? '');
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }

    private function normalizeWorkingHours(?string $value): string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return '';
        }

        $lines = preg_split('/\r\n|\r|\n/', $value) ?: [];
        $out = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            if (preg_match('/^(.*?)(\s+Sunday\s*:.*)$/iu', $line, $m)) {
                $first = trim($m[1]);
                $second = trim($m[2]);
                if ($first !== '') {
                    $out[] = $first;
                }
                if ($second !== '') {
                    $out[] = $second;
                }

                continue;
            }

            $out[] = $line;
        }

        return implode("\n", $out);
    }
}
