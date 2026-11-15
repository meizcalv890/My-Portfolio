<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function edit()
    {
        return view('admin.account');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'different:current_password', Password::min(12)->mixedCase()->numbers()],
        ]);

        $request->user()->forceFill(['password' => $data['password']])->save();
        $request->session()->regenerate();

        return back()->with('success', 'Password diperbarui');
    }
}
