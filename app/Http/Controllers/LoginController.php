<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;

    public function __construct()
    {
        //Login Page can be viewd by anyone 

        $this->user = new user();

    }

    public function index()
    {

        // if session then dashboard 
        //else login page
        if (Auth::guard('admin')->check()) {
            return redirect("admin/dashboard");
        } else {
            $data['title'] = 'Admin Login';
            return view('login',$data);

        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $credentials = ["email" => $request->email, "password" => ($request->password)];

        //Check For Valid Admin and Authenticate
        if (Auth::guard('admin')->validate($credentials, false)) {
            //Authenticate (Create and Save Token)

            $data = User::where('email', $request->email)->where('is_active', 'Y')->get()->first();
            //Welcome Back, Admin!
            if (!$data) {
                return back()->withErrors(['message' => 'Username or Password didnot matched']);
            }
            $this->authenticate($credentials);
            $data->last_login = now(); // Sets the current date and time
            // Save the changes to the database
            $data->save();
            session()->flash("Success", "Welcome Back " . $data->fname);
            //Redirect To Dashboard //Success
            if (isset($data->userType) && in_array($data->userType->rolecode, ['PR', 'PRH', 'CU', 'QC'])) {
                if ($data->userType->rolecode && $data->userType->redirect_url) {
                    return redirect($data->userType->redirect_url);
                }
            }
            return redirect("admin/dashboard");
        }
        //Error
        return back()->withErrors(['message' => 'Username or Password did not matched']);
    }

    public function authenticate($credentials)
    {
        //Retrieve Admin using Credentials
        $admin = Auth::guard("admin")->getProvider()->retrieveByCredentials($credentials);
        //Authorize Admin (generate and put token under cookie)
        Auth::guard("admin")->login($admin, false);
    }

   

    public function logout()
    {

        Auth::guard('admin')->logout();
        return redirect('login');
    }
}
