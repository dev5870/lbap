<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    /**
     * @return View
     */
    public function dashboard(): View
    {
        $users = User::orderBy('id', 'desc');

        return view('admin.dashboard', [
            'users' => $users->take(5)->get(),
            'allUser' => $users->count(),
            'lastDay' => $users->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count(),
        ]);
    }
}
