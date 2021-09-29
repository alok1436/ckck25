<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\User;
use App\Http\Start\Helpers;
use Validator;
use Session;
use Carbon\Carbon;

class AdminController extends Controller
{

    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index() {
        $years = range(Carbon::now()->year - 1, Carbon::now()->year);
        return view('admin.index')->with(compact('years'));
    }

    public function login()
        {
            return view('admin.auth.login');
        }

    public function authenticate(Request $request) {
        if($request->getmethod() == 'GET') {
            return redirect()->route('admin_login');
        }
        
        $admin = User::where('email', $request->email)->first();
        if(isset($admin)) {
            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->intended('admin/dashboard'); // Redirect to dashboard page
            }
            $this->helper->flash_message('danger', 'Log In Failed. Please Check Your Email/Password'); // Call flash message function
            request()->flashExcept('password');
            return redirect('admin/login')->withInput(request()->except('password')); // Redirect to login page
        }
        $this->helper->flash_message('danger', 'Log In Failed. You are Blocked by Admin.'); // Call flash message function
        request()->flashExcept('password');
        return redirect('admin/login')->withInput(request()->except('password')); // Redirect to login page
    }

    public function logout() {
        Auth::guard('admin')->logout();

        return redirect('admin/login');
    }
}
