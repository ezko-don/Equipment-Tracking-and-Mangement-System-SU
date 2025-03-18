<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    // ✅ Show login page
    public function create()
    {
        return view('auth.login'); // Ensure you have resources/views/auth/login.blade.php
    }

    // ✅ Handle login request
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard'); // Redirect admins
            }
            return redirect()->route('dashboard'); // Redirect normal users
        }

        return back()->withErrors(['email' => 'Invalid login credentials']);
    }

    // ✅ Handle logout request
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logged out successfully');
    }
}