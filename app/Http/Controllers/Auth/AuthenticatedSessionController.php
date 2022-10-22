<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Periode;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $periode_id = Periode::query()->latest()->value('id');

        $request->session()->put('periode_id', $periode_id);

        // dd($request);
        if (Auth::user()->hasRole('super admin')) {
            return redirect()->intended(RouteServiceProvider::HOME);
        } elseif (Auth::user()->hasRole('pengurus')) {
            return redirect()->intended(RouteServiceProvider::PONDOK);
        } else {
            return redirect()->intended(RouteServiceProvider::USER);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function setPeriode(Request $request)
    {
        $request->session()->put('periode_id', $request->periode_id);
        return redirect()->back();
    }
}