<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsSettings
{
    /** @return list<string> */
    public static function imageKeys(): array
    {
        return array_keys(AboutPageContent::imageDefaults());
    }

    /** @return list<string> */
    public static function textKeys(): array
    {
        return array_keys(AboutPageContent::settingsDefaults());
    }

    /** @return list<string> */
    public static function flagKeys(): array
    {
        return ['about_us_hero_show_text'];
    }

    /** @return array<string, string> */
    public static function validationRules(): array
    {
        $rules = [
            'about_us_banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'about_us_choose_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'about_us_growth_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'about_us_hero_text_color' => 'nullable|string|in:black,white',
            'about_us_hero_text_align' => 'nullable|string|in:left,center,right',
            'about_us_hero_show_text' => 'nullable|boolean',
        ];

        foreach (self::textKeys() as $key) {
            if (in_array($key, ['about_us_hero_text_color', 'about_us_hero_text_align'], true)) {
                continue;
            }
            $rules[$key] = 'nullable|string|max:5000';
        }

        return $rules;
    }

    public static function saveFromRequest(Request $request, array $validated = []): void
    {
        foreach (self::flagKeys() as $flagKey) {
            Setting::set($flagKey, $request->boolean($flagKey) ? '1' : '0');
        }

        foreach (self::imageKeys() as $imageKey) {
            if ($request->boolean('reset_'.$imageKey)) {
                $oldImage = Setting::get($imageKey);
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
                self::clearSetting($imageKey);

                continue;
            }

            if ($request->hasFile($imageKey)) {
                $oldImage = Setting::get($imageKey);
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
                Setting::set($imageKey, $request->file($imageKey)->store('settings/homepage', 'public'));
            }
        }

        $defaults = AboutPageContent::settingsDefaults();

        foreach (self::textKeys() as $key) {
            if ($key === 'about_us_hero_text_color') {
                $value = normalize_banner_text_color($request->input($key));
                if ($value === null) {
                    self::clearSetting($key);
                } else {
                    Setting::set($key, $value);
                }

                continue;
            }

            if ($key === 'about_us_hero_text_align') {
                $value = normalize_banner_text_align($request->input($key));
                Setting::set($key, $value);

                continue;
            }

            $value = $validated[$key] ?? $request->input($key, '');
            if (trim((string) $value) === '') {
                self::clearSetting($key);

                continue;
            }

            Setting::set($key, $value);
        }
    }

    public static function resetToDefaults(): void
    {
        foreach (self::imageKeys() as $imageKey) {
            $oldImage = Setting::get($imageKey);
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            self::clearSetting($imageKey);
        }

        foreach (self::textKeys() as $key) {
            self::clearSetting($key);
        }

        foreach (self::flagKeys() as $key) {
            self::clearSetting($key);
        }
    }

    private static function clearSetting(string $key): void
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            $setting->delete();
        }
    }
}
