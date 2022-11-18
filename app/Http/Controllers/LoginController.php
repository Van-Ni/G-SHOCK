<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class LoginController extends Controller
{
    //
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:client')->except('logout');
    }

    public function showClientLoginForm()
    {
        return view('auth.login', ['url' => 'client']);
    }

    public function clientLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        // return $request->get('remember');
        if (Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->route('home');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
    public function logout()
    {
        Auth::guard('client')->logout();
        return redirect()->route('home');
    }
}
