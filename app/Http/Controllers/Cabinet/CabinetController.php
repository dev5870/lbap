<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Page;
use App\Models\UserUserAgent;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('cabinet.index', [
            'lastContents' => Content::orderBy('id', 'desc')->take(5)->get(),
            'logs' => UserUserAgent::where('user_id', '=', Auth::id())->sortable(['created_at' => 'desc'])->take(5)->get(),
        ]);
    }

    /**
     * @param Page $page
     * @return View
     */
    public function page(Page $page): View
    {
        return view('cabinet.page.show', [
            'page' => $page,
        ]);
    }
}
