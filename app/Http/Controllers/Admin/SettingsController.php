<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\AboutPageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    protected array $homepageImageKeys = [
        'home_lookbook_image_1',
        'home_lookbook_image_1_mobile',
        'home_lookbook_image_2',
        'home_lookbook_image_2_mobile',
        'home_best_sellers_banner_image',
        'home_best_sellers_banner_image_mobile',
        'about_us_banner_image',
        'about_us_banner_image_mobile',
        'about_us_choose_image',
        'about_us_choose_image_mobile',
        'about_us_growth_image',
        'about_us_growth_image_mobile',
        'home_flash_sale_image',
        'home_flash_sale_image_mobile',
        'home_flash_sale_bg_image',
        'home_flash_sale_bg_image_mobile',
    ];

    protected array $homepageImageDefaults = [
        'home_lookbook_image_1' => 'assets/images/banner/perch123(1).webp',
        'home_lookbook_image_2' => 'assets/images/banner/perch123(2).webp',
        'home_best_sellers_banner_image' => 'assets/images/banner/Blog-3.webp',
        'about_us_banner_image' => 'assets/images/banner/bg-feature-pet1.png',
        'about_us_choose_image' => 'assets/images/instagram/p1(1).webp',
        'about_us_growth_image' => 'assets/images/instagram/p1(3).webp',
        'home_flash_sale_image' => 'assets/images/image-flash-sale-organic.png',
        'home_flash_sale_bg_image' => 'assets/images/banner/bg-flash-sale-organic.png',
    ];

    /** Empty save = theme default (row removed so Setting::get falls back). */
    protected array $textSettingDefaults = [
        'home_lookbook_heading' => 'Discover the latest collection',
        'home_lookbook_button_text' => 'Shop Collection',
        'home_lookbook_button_url' => '/shop/collection',
        'home_best_sellers_heading' => 'Best Sellers',
        'home_best_sellers_button_text' => 'Shop Now',
        'home_best_sellers_button_url' => '/shop',
    ];

    protected array $flagSettingDefaults = [
        'home_section_best_sellers_banner_enabled' => '1',
        'home_section_best_sellers_tabs_enabled' => '1',
        'home_section_lookbook_enabled' => '1',
        'home_section_benefits_enabled' => '1',
        'home_section_instagram_enabled' => '1',
        'home_section_flash_sale_enabled' => '0',
        'home_best_sellers_show_text' => '0',
        'home_lookbook_show_text' => '1',
        'home_flash_sale_show_text' => '1',
        'about_us_hero_show_text' => '1',
        'banner_text_color_default' => 'black',
        'show_customize_nav' => '1',
        'show_customize_product_button' => '1',
    ];

    protected array $settingKeys = [
        'general' => [
            'site_name',
            'site_logo',
            'site_favicon',
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
            'home_lookbook_heading',
            'home_lookbook_button_text',
            'home_lookbook_button_url',
            'home_lookbook_image_1',
            'home_lookbook_image_2',
            'home_best_sellers_heading',
            'home_best_sellers_button_text',
            'home_best_sellers_button_url',
            'home_best_sellers_banner_image',
            'home_section_best_sellers_banner_enabled',
            'home_section_best_sellers_tabs_enabled',
            'home_section_lookbook_enabled',
            'home_section_benefits_enabled',
            'home_section_instagram_enabled',
            'home_section_flash_sale_enabled',
            'home_best_sellers_show_text',
            'home_lookbook_show_text',
            'home_flash_sale_show_text',
            'about_us_hero_show_text',
            'banner_text_color_default',
            'home_flash_sale_text_color',
            'home_best_sellers_text_color',
            'show_customize_nav',
            'show_customize_product_button',
            'about_us_banner_image',
            'about_us_choose_image',
            'about_us_growth_image',
            'home_flash_sale_heading',
            'home_flash_sale_text',
            'home_flash_sale_button_text',
            'home_flash_sale_button_url',
            'home_flash_sale_image',
            'home_flash_sale_bg_image',
            'banner_text_color_default',
            'home_flash_sale_text_color',
            'home_best_sellers_text_color',
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
            'about_us_hero_subtitle',
            'about_us_hero_heading',
            'about_us_hero_text_color',
            'about_us_hero_text_align',
            'about_us_intro_heading',
            'about_us_intro_subheading',
            'about_us_intro_body',
            'about_us_choose_heading',
            'about_us_choose_body',
            'about_us_choose_feature_label',
            'about_us_feature_1_title',
            'about_us_feature_1_text',
            'about_us_feature_2_title',
            'about_us_feature_2_text',
            'about_us_feature_3_title',
            'about_us_feature_3_text',
            'about_us_choose_footer',
            'about_us_quote_heading',
            'about_us_quote_body',
            'about_us_quote_subheading',
            'about_us_growth_heading',
            'about_us_growth_body',
            'about_us_why_choose_label',
            'about_us_why_1',
            'about_us_why_2',
            'about_us_why_3',
            'about_us_why_4',
            'about_us_why_5',
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
            'product_benefit_1_icon',
            'product_benefit_1_title',
            'product_benefit_1_text',
            'product_benefit_2_icon',
            'product_benefit_2_title',
            'product_benefit_2_text',
            'product_benefit_3_icon',
            'product_benefit_3_title',
            'product_benefit_3_text',
        ],
    ];

    public function index()
    {
        $settings = Setting::allAsArray();
        return view('admin.settings.index', [
            'settings' => $settings,
            'settingKeys' => $this->settingKeys,
            'homepageImageDefaults' => $this->homepageImageDefaults,
            'textSettingDefaults' => array_merge($this->textSettingDefaults, AboutPageContent::settingsDefaults()),
            'flagSettingDefaults' => $this->flagSettingDefaults,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'site_favicon' => 'nullable|mimes:ico,jpeg,png,jpg,gif,webp,svg|max:1024',
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
            'home_lookbook_heading' => 'nullable|string|max:255',
            'home_lookbook_button_text' => 'nullable|string|max:100',
            'home_lookbook_button_url' => 'nullable|string|max:500',
            'home_lookbook_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'home_lookbook_image_1_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'home_lookbook_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'home_lookbook_image_2_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'home_best_sellers_heading' => 'nullable|string|max:255',
            'home_best_sellers_button_text' => 'nullable|string|max:100',
            'home_best_sellers_button_url' => 'nullable|string|max:500',
            'home_best_sellers_banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'home_best_sellers_banner_image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'about_us_banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'about_us_banner_image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'about_us_choose_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'about_us_choose_image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'about_us_growth_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'about_us_growth_image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'about_us_hero_subtitle' => 'nullable|string|max:255',
            'about_us_hero_heading' => 'nullable|string|max:500',
            'about_us_hero_text_color' => 'nullable|string|in:black,white',
            'about_us_hero_text_align' => 'nullable|string|in:left,center,right',
            'about_us_intro_heading' => 'nullable|string|max:255',
            'about_us_intro_subheading' => 'nullable|string|max:255',
            'about_us_intro_body' => 'nullable|string|max:5000',
            'about_us_choose_heading' => 'nullable|string|max:255',
            'about_us_choose_body' => 'nullable|string|max:2000',
            'about_us_choose_feature_label' => 'nullable|string|max:255',
            'about_us_feature_1_title' => 'nullable|string|max:255',
            'about_us_feature_1_text' => 'nullable|string|max:500',
            'about_us_feature_2_title' => 'nullable|string|max:255',
            'about_us_feature_2_text' => 'nullable|string|max:500',
            'about_us_feature_3_title' => 'nullable|string|max:255',
            'about_us_feature_3_text' => 'nullable|string|max:500',
            'about_us_choose_footer' => 'nullable|string|max:2000',
            'about_us_quote_heading' => 'nullable|string|max:255',
            'about_us_quote_body' => 'nullable|string|max:3000',
            'about_us_quote_subheading' => 'nullable|string|max:500',
            'about_us_growth_heading' => 'nullable|string|max:255',
            'about_us_growth_body' => 'nullable|string|max:5000',
            'about_us_why_choose_label' => 'nullable|string|max:255',
            'about_us_why_1' => 'nullable|string|max:500',
            'about_us_why_2' => 'nullable|string|max:500',
            'about_us_why_3' => 'nullable|string|max:500',
            'about_us_why_4' => 'nullable|string|max:500',
            'about_us_why_5' => 'nullable|string|max:500',
            'home_flash_sale_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'home_flash_sale_image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'home_flash_sale_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'home_flash_sale_bg_image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'home_flash_sale_heading' => 'nullable|string|max:255',
            'home_flash_sale_text' => 'nullable|string|max:500',
            'home_flash_sale_button_text' => 'nullable|string|max:100',
            'home_flash_sale_button_url' => 'nullable|string|max:500',
            'banner_text_color_default' => 'nullable|string|in:black,white',
            'home_flash_sale_text_color' => 'nullable|string|in:black,white',
            'home_best_sellers_text_color' => 'nullable|string|in:black,white',
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
            'product_benefit_1_icon' => 'nullable|string|max:100',
            'product_benefit_1_title' => 'nullable|string|max:255',
            'product_benefit_1_text' => 'nullable|string|max:1000',
            'product_benefit_2_icon' => 'nullable|string|max:100',
            'product_benefit_2_title' => 'nullable|string|max:255',
            'product_benefit_2_text' => 'nullable|string|max:1000',
            'product_benefit_3_icon' => 'nullable|string|max:100',
            'product_benefit_3_title' => 'nullable|string|max:255',
            'product_benefit_3_text' => 'nullable|string|max:1000',
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

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
            $validated['site_favicon'] = $request->file('site_favicon')->store('settings', 'public');
        } else {
            $validated['site_favicon'] = Setting::get('site_favicon', '');
        }

        foreach ($this->homepageImageKeys as $imageKey) {
            if ($request->boolean('reset_'.$imageKey)) {
                $oldImage = Setting::get($imageKey);
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
                Setting::set($imageKey, '');

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

        $allKeys = array_merge(
            $this->settingKeys['general'],
            $this->settingKeys['content'],
            $this->settingKeys['social'],
            $this->settingKeys['other']
        );

        $textDefaults = array_merge($this->textSettingDefaults, AboutPageContent::settingsDefaults());

        foreach ($allKeys as $key) {
            if (in_array($key, $this->homepageImageKeys, true)) {
                continue;
            }
            if (array_key_exists($key, $this->flagSettingDefaults)) {
                Setting::set($key, $request->boolean($key) ? '1' : '0');

                continue;
            }
            $value = $validated[$key] ?? $request->input($key, '');
            if ($key === 'working_hours') {
                $value = $this->normalizeWorkingHours($value);
            }

            if (array_key_exists($key, $textDefaults) && trim((string) $value) === '') {
                $this->clearSetting($key);

                continue;
            }

            Setting::set($key, $value ?? '');
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }

    private function clearSetting(string $key): void
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            $setting->delete();
        }
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
