<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    public function login()
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('index');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
            'password' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
