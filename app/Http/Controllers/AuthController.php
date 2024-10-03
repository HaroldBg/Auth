<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\AccountValidationMail;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    //


    public function create(): View
    {
        return view('register');

    }

    public function store(RegisterRequest $request)
    {
        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mail_verification_code' => Str::uuid(),
        ]);
        Mail::to($user['email'])->send(new AccountValidationMail($user));
        return redirect()->route('login');
    }

    public function login(LoginRequest $request)
    {
        $check = $request->only('email', 'password');
        if (Auth::attempt($check)) {
            return redirect()->intended('Dashboard');
        }
        return back()->with(['error' => 'Back credential']);
    }

    public function update(RegisterRequest $request)
    {

    }

    public function validateAccount($code)
    {
        //let find the user with the code
        $exist = User::query()->where('mail_verification_code', $code)->exists();
        if (!$exist) {
            return back()->with(['error' => 'Back credential']);
        }
        $user = User::where('mail_verification_code', $code)->firstOrFail();
//        dd($user->id);
        $validate = User::where('mail_verification_code', $code)->update([
            'enable' => true,
            'email_verified_at' => Carbon::now(),
        ]);
        if ($validate) {
            return redirect()->route('login');
        } else {
            return back()->with(['error' => 'Back credential']);
        }
    }

    public function sendResetMail(ResetPasswordRequest $request)
    {
        // let's find user for this mail
        $user = User::query()->where('email', $request->email)->exists();
        if (!$user) {
            return back()->with(['error' => 'Back credential']);
        }
        $user = User::query()->where('email', $request->email)->first();
//        dd($user['email']);
        // let's create reset token
        $done = DB::table('password_resets')->updateOrInsert(
            [
                'email' => $request->email
            ],
            [
                'email' => $request->email,
                'token' => uniqid(Str::random(32), true),
            ]
        );
        if (!$done) {
            return back()->with(['error' => 'Back credential']);
        }
        Mail::to($request->email)->send(new PasswordResetMail($user));
        return redirect()->route('reset-page');
    }

    public function resetView($token)
    {
        // let's find user with this token
        dd($token);
        $exist = DB::table('password_resets')->where('token', $token)->exists();
        if (!$exist) {
            return back()->with(['error' => 'Back credential']);
        }
        // get mail for find user
        $user = User::query()
            ->where('email',
                (
                    DB::table('password_resets')
                    ->select('email')
                    ->where('token', $token)
                    ->first()
                )
            )
            ->first();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
