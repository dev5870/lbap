<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Contracts\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        return view('cabinet.content.index', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'contents' => Content::where('delayed_time_publication', '<', now())
                ->sortable(['id' => 'desc'])
                ->paginate(config('view.per_page')),
        ]);
    }

    public function show(Content $content): View
    {
        return view('cabinet.content.show', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'content' => $content,
        ]);
    }
}