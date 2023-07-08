<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{

    public function login(){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    /**
     * Attempt to login a user
     */
    public function auth(Request $request){
        if($request->has('fullname')){
            return $this->register($request);
        }
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $result = Auth::attempt([
            'email'=>$credentials['email'], 
            'password'=>$credentials['password']
        ]);

        if($result){            
            $request->session()->regenerate();
            return redirect()->intended(route("dashboard"));
        }
        Alert::error('Login Failed', 'Invalid login credentials');
        return redirect()->back();
    }

    /**
     * Add a new user
     */
    public function register(Request $request){
        $data = $request->validate([
            'fullname' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

       try{
            User::store($data);
            Alert::success('Registration Successful', 'You registation was successful, you can proceed to login');
            return redirect()->route('login');
       }catch(\Exception $args){
            Log::error($args);
            Alert::error('Registation Failed', 'An error occurred during your registration');
       }
       return redirect()->back();
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->back();
    }
}
