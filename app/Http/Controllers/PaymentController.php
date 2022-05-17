<?php

namespace App\Http\Controllers;

use App\Http\Filters\PaymentFilter;
use App\Http\Requests\PaymentCreateRequest;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filter = new PaymentFilter($request);

        return view('admin.payment.index', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'payments' => Payment::sortable(['id' => 'desc'])->filter($filter)->paginate(config('view.per_page')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): View
    {
        return view('admin.payment.create', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PaymentCreateRequest $request
     * @return RedirectResponse
     */
    public function store(PaymentCreateRequest $request): RedirectResponse
    {
        if ((new PaymentService())->handle($request)) {
            return redirect()->route('admin.payment.index')->with([
                'success-message' => __('title.success')
            ]);
        }

        return redirect()->route('admin.payment.create')->with([
            'error-message' => __('title.error')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
