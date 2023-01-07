<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use Session;

/**
 * My User Model
 */
use App\Models\User;

class LoginController extends Controller
{
    public function loginGet()
    {
        return view('auth.login');
    }

    // Column Name in Database
    private function MyCustomField()
    {
        return "custom_field";
    }

    function loginPost(Request $request)
    {
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required',

            /**
             * Example 1
             * 
             * Add Method
             */
            $this->MyCustomField() => 'required',

            /**
             * Example 2
             * 
             * Add key => value
             */
            "custom_field" => "required",

        ]);
            
        if(
            empty( $request->exists( 'email' ) ) &&
            empty( $request->exists( 'password' ) ) &&
            //check my custom field
            empty( $request->exists( "custom_field" ) )
        ){
            return view('auth.login')->with( 'login_page_error' , 'Request Exists Error');
        }

        if(
            empty( $request->filled( 'email' ) ) &&
            empty( $request->filled( 'password' ) ) &&
            //check my custom field
            empty( $request->filled( "custom_field" ) )
        ){
            return redirect()->route('admin_login_post')->withErrors('Empty Field');
        }

        $f_email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $f_pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        //filter inpıt my custom field
        $f_my_custom_field = filter_input(INPUT_POST, "custom_field", FILTER_SANITIZE_STRING);

        $credentials = [
            'email'         => $f_email,
            'password'      => $f_pass,
            //attempt my custom field
            "custom_field"   => $f_my_custom_field,
        ];

        if(Auth::attempt($credentials))
        {
            if( Auth::user()->role === "admin" )
            {
                User::changeStatus( Auth::id() );

                return redirect()->route('admin_dashboard');
            }
        }

        return redirect()->route('admin_login_post')->withErrors('Wrong Mail, Password or my_custom_field');
    }
}


?>