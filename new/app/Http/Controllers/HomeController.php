<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect()
    {
        // Avoid infinite redirect loops
        if (Auth::check()) {
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }

        return redirect()->route('welcome');
    }
}