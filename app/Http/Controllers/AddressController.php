<?php

namespace App\Http\Controllers;

use App\Http\Filters\AddressFilter;
use App\Models\Address;
use App\Models\PaymentSystem;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AddressController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filter = new AddressFilter($request);

        return view('admin.address.index', [
            'addresses' => Address::sortable(['id' => 'desc'])->filter($filter)->paginate(config('view.per_page')),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.address.create', [
            'paymentSystem' => PaymentSystem::all(['id', 'name']),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $address = new Address();
        $address->address = $request->get('address');
        $address->payment_system_id = $request->get('payment_system_id');
        $address->save();

        return redirect()->route('admin.address.index')->with([
            'success-message' => __('title.success')
        ]);
    }
}
