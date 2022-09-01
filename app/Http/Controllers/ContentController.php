<?php

namespace App\Http\Controllers;

use App\Http\Filters\ContentFilter;
use App\Http\Requests\ContentCreateRequest;
use App\Models\Content;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContentController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filter = new ContentFilter($request);

        return view('admin.content.index', [
            'contents' => Content::sortable(['id' => 'desc'])->filter($filter)->paginate(config('view.per_page')),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.content.create');
    }

    /**
     * @param ContentCreateRequest $request
     * @return RedirectResponse
     */
    public function store(ContentCreateRequest $request): RedirectResponse
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
     * @param Content $content
     * @return View
     */
    public function edit(Content $content): View
    {
        return view('admin.content.edit', [
            'content' => $content,
        ]);
    }

    /**
     * @param Request $request
     * @param Content $content
     * @return RedirectResponse
     */
    public function update(Request $request, Content $content): RedirectResponse
    {
        $content->title = $request->get('title');
        $content->preview = $request->get('preview');
        $content->text = $request->get('text');
        $content->delayed_time_publication = $request->get('delayed_time_publication');
        $content->save();

        return redirect()->route('admin.content.edit', $content)->with([
            'success-message' => __('title.success')
        ]);
    }

    /**
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
