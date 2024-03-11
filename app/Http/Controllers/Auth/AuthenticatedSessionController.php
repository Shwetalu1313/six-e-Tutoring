<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = User::find(Auth::id());
        $user->last_login_at = now();
        $user->timestamps = false;
        $user->save();

        $request->session()->regenerate();
        switch (Auth::user()->role_id) {
            case (1):
                $home = route('dashboards.staff');
                break;
            case (2):
                $home = route('dashboards.tutor');
                break;
            case (3):
                $home = route('dashboards.student');
                break;
            default:
                $home = route('dashboard');
        }
        return redirect()->intended($home)->with('id', Auth::id());
        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
