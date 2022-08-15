<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.notification.index', [
            'notifications' => Notification::sortable(['id' => 'desc'])->paginate(config('view.per_page')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('admin.notification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $notification = new Notification();
        $notification->text = $request->get('text');
        $notification->status = $request->get('status');
        $notification->type = $request->get('type');
        $notification->save();

        return redirect()->route('admin.notification.index')->with([
            'success-message' => __('title.success')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Notification $notification
     * @return View
     */
    public function edit(Notification $notification): View
    {
        return view('admin.notification.edit', [
            'notification' => $notification,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Notification $notification
     * @return RedirectResponse
     */
    public function update(Request $request, Notification $notification): RedirectResponse
    {
        $notification->text = $request->get('text');
        $notification->status = $request->get('status');
        $notification->type = $request->get('type');
        $notification->save();

        return redirect()->route('admin.notification.edit', $notification)->with([
            'success-message' => __('title.success')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Notification $notification
     * @return RedirectResponse
     */
    public function destroy(Notification $notification): RedirectResponse
    {
        $notification->delete();

        return redirect()->route('admin.notification.index')->with([
            'success-message' => __('title.success')
        ]);
    }
}
