<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.page.index', [
            'pages' => Page::sortable(['id' => 'desc'])->paginate(config('view.per_page')),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.page.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $page = new Page();
        $page->title = $request->get('title');
        $page->text = $request->get('text');

        if (!$page->save()) {
            return redirect()->route('admin.page.edit', $page)->with([
                'error-message' => __('title.error.create')
            ]);
        }

        return redirect()->route('admin.page.index')->with([
            'success-message' => __('title.success')
        ]);
    }

    /**
     * @param Page $page
     * @return View
     */
    public function edit(Page $page): View
    {
        return view('admin.page.edit', [
            'page' => $page,
        ]);
    }

    /**
     * @param Request $request
     * @param Page $page
     * @return RedirectResponse
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
        $page->title = $request->get('title');
        $page->text = $request->get('text');
        $page->save();

        return redirect()->route('admin.page.edit', $page)->with([
            'success-message' => __('title.success')
        ]);
    }

    /**
     * @param Page $page
     * @return RedirectResponse
     */
    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.page.index')->with([
            'success-message' => __('title.success')
        ]);
    }
}
