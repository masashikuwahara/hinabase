<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function edit(Request $request)
    {
        return view('admin.account.edit', ['user' => $request->user()]);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],              // ← いまのPW検証
            'password'         => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        return back()->with('status', 'password-updated');
    }

    public function updateEmail(Request $request)
    {
        $validated = $request->validate([
            'email'            => ['required','string','email','max:255','unique:users,email'],
            'current_password' => ['required', 'current_password'],              // ← 認証の二重化
        ]);

        $user = $request->user();

        // Email Verification を使っているなら、再認証フロー
        $user->forceFill([
            'email' => $validated['email'],
        ])->save();

        // メール認証を有効にしている場合は再認証トリガ（任意）
        if (method_exists($user, 'sendEmailVerificationNotification')) {
            $user->forceFill(['email_verified_at' => null])->save();
            $user->sendEmailVerificationNotification();
        }

        return back()->with('status', 'email-updated');
    }
}
