<?php
declare(strict_types=1);

namespace App\Http\Controllers\Cabinet;

use App\Dto\PaymentCreateDto;
use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Cabinet\PaymentCreateRequest;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('cabinet.payment.index', [
            'payments' => Payment::where('user_id', '=', Auth::id())
                ->sortable(['id' => 'desc'])
                ->paginate(config('view.per_page')),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cabinet.payment.create', [
            'user' => User::with('address')
                ->where('id', '=', Auth::id())
                ->first(),
        ]);
    }

    /**
     * @param PaymentCreateRequest $request
     * @return RedirectResponse
     */
    public function store(PaymentCreateRequest $request): RedirectResponse
    {
        $paymentType = PaymentType::whereName('real_money')->first();

        $paymentCreateDto = new PaymentCreateDto();
        $paymentCreateDto->user = User::find(Auth::id());
        $paymentCreateDto->userInitiator = User::find(Auth::id());
        $paymentCreateDto->type = $paymentType->id;
        $paymentCreateDto->method = PaymentMethod::WITHDRAW;
        $paymentCreateDto->address = $request->get('address');
        $paymentCreateDto->fullAmount = $request->get('full_amount');

        if ((new PaymentService($paymentCreateDto))->handle()) {
            return redirect()->route('cabinet.payment.index')->with([
                'success-message' => __('title.success')
            ]);
        }

        return redirect()->route('cabinet.payment.withdraw')->with([
            'error-message' => __('title.error.withdraw')
        ]);
    }

    /**
     * @return View
     */
    public function withdraw(): View
    {
        return view('cabinet.payment.withdraw');
    }
}
