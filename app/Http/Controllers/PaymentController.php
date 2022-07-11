<?php

namespace App\Http\Controllers;

use App\Dto\PaymentCreateDto;
use App\Dto\PaymentUpdateDto;
use App\Enums\PaymentStatus;
use App\Http\Filters\PaymentFilter;
use App\Http\Requests\PaymentCreateRequest;
use App\Http\Requests\PaymentUpdateRequest;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Setting;
use App\Models\User;
use App\Services\PaymentService;
use App\Services\PaymentUpdateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
            'paymentTypes' => PaymentType::all(),
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
        $paymentCreateDto = new PaymentCreateDto();
        $paymentCreateDto->user = User::find($request->get('user_id'));
        $paymentCreateDto->fullAmount = $request->get('full_amount');
        $paymentCreateDto->type = $request->get('type');
        $paymentCreateDto->method = $request->get('method');

        if ((new PaymentService($paymentCreateDto))->handle()) {
            return redirect()->route('admin.payment.index')->with([
                'success-message' => __('title.success')
            ]);
        }

        return redirect()->route('admin.payment.create')->with([
            'error-message' => __('title.error')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Payment $payment
     * @return View
     */
    public function edit(Payment $payment): View
    {
        return view('admin.payment.edit', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'payment' => $payment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentUpdateRequest $request
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function update(PaymentUpdateRequest $request, Payment $payment): RedirectResponse
    {
        $paymentDto = new PaymentUpdateDto();
        $paymentDto->payment = $payment;
        $paymentDto->userAdmin = User::find(Auth::id());
        $paymentDto->user = $payment->user;

        if ($request->has('cancel')) {
            $paymentDto->status = PaymentStatus::CANCEL;
        }

        if ($request->has('confirm')) {
            $paymentDto->status = PaymentStatus::PAID;
        }

        if ((new PaymentUpdateService($paymentDto))->handle()) {
            return redirect()->route('admin.payment.edit', $payment)->with([
                'success-message' => __('title.success')
            ]);
        }

        return redirect()->route('admin.payment.edit', $payment)->with([
            'error-message' => __('title.error')
        ]);
    }
}
