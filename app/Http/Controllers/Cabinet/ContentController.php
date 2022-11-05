<?php
declare(strict_types=1);

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Contracts\View\View;

class ContentController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('cabinet.content.index', [
            'contents' => Content::where('delayed_time_publication', '<', now())
                ->sortable(['id' => 'desc'])
                ->paginate(config('view.per_page')),
        ]);
    }

    /**
     * @param Content $content
     * @return View
     */
    public function show(Content $content): View
    {
        return view('cabinet.content.show', [
            'content' => $content,
        ]);
    }
}
