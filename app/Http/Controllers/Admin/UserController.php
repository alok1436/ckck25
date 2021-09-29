<?php
namespace App\Http\Controllers\Admin;

use DB;
use Hash;
use Auth;
use Session;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Start\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct(){
        $this->helper = new Helpers;
    }
    
    public function index() {
        $users = User::get();
        return view('admin.users.index',compact('users'));
    }
    
    public function store(Request $request) {
        if($request->isMethod('post') && $request->ajax()){

			//Start Validation
            $messages = [
                'name.required' => 'Name field is required',
                'email.required' => 'ID field is required',
                'password.required' => 'Passowrd field is required',
                'level.required' => 'Level field is required',
            ];
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'level' => 'required'
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 
            //end Validation

			$user = new User();
			$user->name = $request->name;
			$user->email = $request->email;
			$user->password = Hash::make($request->password);
			$user->level = $request->level;
			$user->save();
			return response()->json([
				'success'=>true,
				'message'=>'Account has been created.',
				'redirect_url'=>url("admin/users"),
				'reload' => false
			],200);
		}
        return view('admin.users.store');
    }
    
    public function edit(Request $request, $id) {
        $user = User::find($id);
         
        if($request->isMethod('post') && $request->ajax()){

			//Start Validation
            $messages = [
                'name.required' => 'Name field is required',
                'email.required' => 'ID field is required',
                'level.required' => 'Level field is required',
            ];
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'level' => 'required'
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 
            //end Validation

			$user->name = $request->name;
			$user->email = $request->email;
			if(trim($request->get ('password')) !=''){
                $user->password = Hash::make($request->password);
            }
			$user->level = $request->level;
			$user->save();
			return response()->json([
				'success'=>true,
				'message'=>'Account has been updated.',
				'redirect_url'=>url("admin/users"),
				'reload' => false
			],200);
		}
        return view('admin.users.edit',compact('user'));
    }
    
    public function delete(Request $request, $id) {
        if(User::find($id)){
            $user = User::find($id);
            $user->delete();
            $this->helper->flash_message('success', 'Account has been deleted successfully.'); 
            return redirect('admin/users');
        }
    }
}
