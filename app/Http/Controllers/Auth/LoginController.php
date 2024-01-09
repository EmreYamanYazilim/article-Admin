<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLogin()
    {

        return view("auth.login");
    }

    public function showRegister()
    {
        return view("auth.register");
    }

    public function login(LoginRequest $request)
    {

        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember;

        !is_null($remember) ? $remember = true : $remember = false;

        $user = User::where("email", $email)->first();

        if ($user && \Hash::check($password, $user->password)) {
            Auth::login($user);
//            Auth::loginUsingId($user->id);  bu userin 2. yöntem
            return redirect()->route("admin.index");
        } else {
            return redirect()
                ->route("login")
                ->withErrors([
                    "email" => "verdiğiniz bilgilerle eşlesen bir kullanici bulunamadı "
                ])
                ->onlyInput("email", "remember"); // valuesine gidip  {{ old("email") }}
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route("login");
        }
    }
}
