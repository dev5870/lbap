<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Dto\PaymentCreateDto;
use App\Dto\PaymentUpdateDto;
use App\Enums\PaymentStatus;
use App\Http\Filters\PaymentFilter;
use App\Http\Requests\PaymentCreateRequest;
use App\Http\Requests\PaymentUpdateRequest;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\User;
use App\Services\PaymentService;
use App\Services\PaymentUpdateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filter = new PaymentFilter($request);

        return view('admin.payment.index', [
            'payments' => Payment::sortable(['id' => 'desc'])->filter($filter)->paginate(config('view.per_page')),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.payment.create', [
            'paymentTypes' => PaymentType::all(),
        ]);
    }

    /**
     * @param PaymentCreateRequest $request
     * @return RedirectResponse
     */
    public function store(PaymentCreateRequest $request): RedirectResponse
    {
        $paymentCreateDto = new PaymentCreateDto();
        $paymentCreateDto->user = User::find($request->get('user_id'));
        $paymentCreateDto->userInitiator = User::find(Auth::id());
        $paymentCreateDto->fullAmount = $request->get('full_amount');
        $paymentCreateDto->type = (int)$request->get('type');
        $paymentCreateDto->method = (int)$request->get('method');

        if ((new PaymentService($paymentCreateDto))->handle()) {
            return redirect()->route('admin.payment.index')->with([
                'success-message' => __('title.success')
            ]);
        }

        return redirect()->route('admin.payment.create')->with([
            'error-message' => __('title.error.create_payment')
        ]);
    }

    /**
     * @param Payment $payment
     * @return View
     */
    public function edit(Payment $payment): View
    {
        return view('admin.payment.edit', [
            'payment' => $payment,
        ]);
    }

    /**
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
            'error-message' => __('title.error.update_payment')
        ]);
    }
}
