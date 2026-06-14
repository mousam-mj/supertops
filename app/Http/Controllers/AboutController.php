<?php

namespace App\Http\Controllers;

use App\Models\PolicyPage;
use App\Support\AboutPageContent;

class AboutController extends Controller
{
    public function show()
    {
        $page = PolicyPage::where('slug', 'about-us')->first();

        if (! $page) {
            $page = new PolicyPage([
                'slug' => 'about-us',
                'title' => 'About Us',
                'content' => AboutPageContent::defaultHtml(),
                'is_active' => true,
            ]);
        } elseif (AboutPageContent::isPlaceholder($page->content)) {
            $page->content = AboutPageContent::defaultHtml();
        }

        if (! $page->is_active) {
            abort(404);
        }

        return view('aboutus', compact('page'));
    }
}
