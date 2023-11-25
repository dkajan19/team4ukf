<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class ResetPasswordController extends Controller
{

    protected $redirectTo = '/login';

    protected function redirectPath(Request $request)
    {
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/login';
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }

    public function showResetForm(Request $request, $token = null)
    {
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenData) {
            return redirect()->route('password.request')->withErrors(['email' => 'Neplatné resetovanie hesla.']);
        }

        return view('auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules());

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            \DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        }

        return $status == Password::PASSWORD_RESET
            ? redirect($this->redirectPath($request))->with('status', trans($status))
            : redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($status)]);
    }
}
