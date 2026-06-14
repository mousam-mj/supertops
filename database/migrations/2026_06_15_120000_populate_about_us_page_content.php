<?php

use App\Models\PolicyPage;
use App\Support\AboutPageContent;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $page = PolicyPage::where('slug', 'about-us')->first();
        if (! $page) {
            PolicyPage::create([
                'slug' => 'about-us',
                'title' => 'About Us',
                'content' => AboutPageContent::defaultHtml(),
                'is_active' => true,
            ]);

            return;
        }

        if (AboutPageContent::isPlaceholder($page->content)) {
            $page->update(['content' => AboutPageContent::defaultHtml()]);
        }
    }

    public function down(): void
    {
        // Leave existing content unchanged on rollback.
    }
};
