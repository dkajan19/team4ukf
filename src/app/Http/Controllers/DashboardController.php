<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->user_roles->rola;

        return view('dashboard', compact('role'));
    }
}
