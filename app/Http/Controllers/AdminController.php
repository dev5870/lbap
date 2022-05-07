<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @return View
     */
    public function dashboard(): View
    {
        $users = User::orderBy('id', 'desc')->take(5)->get();

        return view('admin.dashboard', [
            'users' => $users
        ]);
    }
}
