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
        ],
        'content' => [
            'about_us',
            'privacy_policy',
            'contact_page_text',
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
            'about_us' => 'nullable|string|max:50000',
            'privacy_policy' => 'nullable|string|max:50000',
            'contact_page_text' => 'nullable|string|max:2000',
            'facebook_url' => 'nullable|string|max:500',
            'instagram_url' => 'nullable|string|max:500',
            'twitter_url' => 'nullable|string|max:500',
            'youtube_url' => 'nullable|string|max:500',
            'pinterest_url' => 'nullable|string|max:500',
            'whatsapp_number' => 'nullable|string|max:20',
            'copyright_text' => 'nullable|string|max:500',
            'free_shipping_text' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
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
            Setting::set($key, $value ?? '');
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}
