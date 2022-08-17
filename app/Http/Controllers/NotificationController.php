<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.notification.index', [
            'notifications' => Notification::sortable(['id' => 'desc'])->paginate(config('view.per_page')),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.notification.create');
    }

    /**
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
