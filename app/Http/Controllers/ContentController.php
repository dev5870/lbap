<?php

namespace App\Http\Controllers;

use App\Http\Filters\ContentFilter;
use App\Models\Content;
use App\Models\Notification;
use App\Models\Setting;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filter = new ContentFilter($request);

        return view('admin.content.index', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'contents' => Content::sortable(['id' => 'desc'])->filter($filter)->paginate(config('view.per_page')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.content.create', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $content = new Content();
        $content->title = $request->get('title');
        $content->preview = $request->get('preview');
        $content->text = $request->get('text');
        $content->delayed_time_publication = $request->get('delayed_time_publication');
        $content->save();
        $content->refresh();

        if (
            $request->file('file') &&
            ((new FileUploadService())->handle($request->file('file'), $content, $request->get('description')) === false)
        ) {
            return redirect()->route('admin.content.edit', $content)->with([
                'error-message' => __('title.file_not_upload')
            ]);
        }

        return redirect()->route('admin.content.index')->with([
            'success-message' => __('title.success')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Content $content
     * @return View
     */
    public function edit(Content $content): View
    {
        return view('admin.content.edit', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'content' => $content,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Content $content
     * @return RedirectResponse
     */
    public function update(Request $request, Content $content): RedirectResponse
    {
        $content->title = $request->get('title');
        $content->preview = $request->get('preview');
        $content->text = $request->get('text');
        $content->delayed_date_publication = $request->get('delayed_date_publication');
        $content->delayed_time_publication = $request->get('delayed_time_publication');
        $content->save();

        return redirect()->route('admin.content.edit', $content)->with([
            'success-message' => __('title.success')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Content $content
     * @return RedirectResponse
     */
    public function destroy(Content $content): RedirectResponse
    {
        $content->delete();

        return redirect()->route('admin.content.index')->with([
            'success-message' => __('title.success')
        ]);
    }
}
