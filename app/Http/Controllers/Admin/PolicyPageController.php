<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PolicyPage;
use App\Support\AboutPageContent;
use App\Support\PolicyPageDefaults;
use Illuminate\Http\Request;

class PolicyPageController extends Controller
{
    /** Default slugs that must exist in the table. */
    protected const DEFAULT_SLUGS = [
        'about-us' => 'About Us',
        'terms-and-conditions' => 'Terms & Conditions',
        'privacy-policy' => 'Privacy Policy',
        'return-and-refund' => 'Return and Refund Policy',
        'cancellation-policy' => 'Cancellation Policy',
    ];

    /**
     * List all policy pages. Creates any missing default pages so they appear in the list.
     */
    public function index()
    {
        foreach (self::DEFAULT_SLUGS as $slug => $title) {
            PolicyPage::firstOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'content' => $slug === 'about-us'
                        ? AboutPageContent::defaultHtml()
                        : '<p>Edit this page to add content.</p>',
                    'is_active' => true,
                ]
            );
        }

        $pages = PolicyPage::orderBy('slug')->get();
        return view('admin.policy-pages.index', compact('pages'));
    }

    /**
     * Show edit form for a policy page.
     */
    public function edit(PolicyPage $policy_page)
    {
        if ($policy_page->slug === 'about-us' && AboutPageContent::isPlaceholder($policy_page->content)) {
            $policy_page->content = AboutPageContent::defaultHtml();
            $policy_page->save();
        }

        $pageDefault = PolicyPageDefaults::forSlug($policy_page->slug);

        return view('admin.policy-pages.edit', compact('policy_page', 'pageDefault'));
    }

    /**
     * Update a policy page.
     */
    public function update(Request $request, PolicyPage $policy_page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string|max:100000',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->boolean('reset_to_default')) {
            $default = PolicyPageDefaults::forSlug($policy_page->slug);
            if ($default) {
                $validated['title'] = $default['title'];
                $validated['content'] = $default['content'];
            }
        }

        $policy_page->update($validated);

        $message = $request->boolean('reset_to_default')
            ? 'Page reset to default content.'
            : 'Policy page updated successfully!';

        return redirect()->route('admin.policy-pages.edit', $policy_page)
            ->with('success', $message);
    }
}
