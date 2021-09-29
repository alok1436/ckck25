<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Validator;
use Session;
use Carbon\Carbon;
use App\Models\Stock;
use App\Http\Start\Helpers;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Routeknown;
use App\Models\Customergroup;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Filetransfer;
use App\Models\Stockbroker;
use App\Models\User;
use App\Models\City;

class FiletransferController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index(){
        if (request()->ajax()) {
            $filetransfers = Filetransfer::join('companies', 'filetransfers.companyId', '=', 'companies.id')
            ->join('customers', 'customers.id', '=', 'filetransfers.userId')
            ->orderBy('filetransfers.date', 'DESC')
            ->select([
                'filetransfers.id',
                DB::raw("DATE_FORMAT(filetransfers.date, '%Y.%m.%d') as date"),
                'customers.name',
                'companies.companyName',
                'filetransfers.companyId',
                'filetransfers.fileName',
                'customers.customerGroupID',
                'customers.routesOfKnownID',
                'customers.id as customersID',
                'filetransfers.method',
                'filetransfers.createdBy',
                'filetransfers.userId',
            ]);
            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $filetransfers->where('customers.customerGroupID', $group_filter);
                }
            }
            
            if (request()->has('company_filter')) {
                $company_filter = request()->get('company_filter');
                if (!empty($company_filter)) {

                    $filetransfers->where('filetransfers.companyId', $company_filter);
                    
                }
            }
            if (request()->has('route_filter')) {
                $route_filter = request()->get('route_filter');
                if (!empty($route_filter)) {
                    $filetransfers->where('customers.routesOfKnownID', $route_filter);
                }
            }
            return Datatables::of($filetransfers)
                ->addColumn('action', function($row) {
                    return '<a href="'.url('admin/edit_customer/'.$row->userId).'" class="btn btn-sm btn-primary"><i class="mdi mdi-eye-circle-outline"></i></a>';
                })
                ->addColumn('mass_delete', function($row) {
                    
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'" />';
                })
                ->editColumn('method', function ($row) {
                    $method = $row->method;
                    if ($method == "Email") {
                        $method_name = '<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_method" data-id="'.$row->id.'" data-method="'.$row->method.'">이메일</a>';
                    } else if ($method == "Post") {
                        $method_name = '<a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_method" data-id="'.$row->id.'" data-method="'.$row->method.'">우편</a>';
                    } else if ($method == "SMS") {
                        $method_name = '<a href="javascript:void(0);" class="btn btn-info waves-effect waves-light btn_method" data-id="'.$row->id.'" data-method="'.$row->method.'">SMS</a>';
                    } else if ($method == "Messenger") {
                        $method_name = '<a href="javascript:void(0);" class="btn btn-secondary waves-effect waves-light btn_method" data-id="'.$row->id.'" data-method="'.$row->method.'">카카오톡</a>';
                    }
                    return $method_name;
                })
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/user-record/edit_file_transfer/'.$row->id).'">'.$name.'</a>';
                })
                ->addColumn('admin', function($row) {
                    $admin = User::where('id', $row->createdBy)->first();
                    return $admin->name;
                })
                ->rawColumns(['action','name', 'admin', 'mass_delete', 'method'])
                ->make(true);
        }
        $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        return view('admin.user-records.file-transfers.index')->with(compact('groups', 'companies', 'routeknowns'));
    }

    public function add(Request $request) {
        if(!$_POST) {
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            return view('admin.user-records.file-transfers.add')->with(compact('companies', 'customers'));
        } 
        else if ($request->submit) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'method' => 'required',
                'fileName'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $filetransfer = new Filetransfer;
                $filetransfer->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $filetransfer->companyId = $request->company;
                $filetransfer->method = $request->method;
                $filetransfer->fileName = $request->fileName;
                $filetransfer->userId = $request->customer;
                $filetransfer->createdBy = Auth::guard('admin')->user()->id;
                $filetransfer->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return redirect('admin/user-record/file-transfers');
            }
        }
        else {
            return redirect('admin/user-record/file-transfers');
        }
    }

    public function update(Request $request) {
        if(!$_POST) {
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $filetrans = Filetransfer::find($request->id);
            return view('admin.user-records.file-transfers.edit')->with(compact('companies', 'customers', 'filetrans'));
        } 
        else if ($request->submit) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'method' => 'required',
                'fileName'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $filetransfer = Filetransfer::find($request->id);
                $filetransfer->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $filetransfer->companyId = $request->company;
                $filetransfer->method = $request->method;
                $filetransfer->fileName = $request->fileName;
                $filetransfer->userId = $request->customer;
                $filetransfer->createdBy = Auth::guard('admin')->user()->id;
                $filetransfer->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return redirect('admin/user-record/file-transfers');
            }
        }
        return redirect('admin/user-record/file-transfers');
    }
    public function methodchange(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'fileid'=>'required',
                'method'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $filetransfer = Filetransfer::find($request->fileid);
                $filetransfer->method = $request->method;
                $filetransfer->save();
                return response()->json(['status' => 'Success'],201);
            }

        }
    }

    public function newcompany(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'company'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $company = new Company;
                $company->companyName = $request->company;
                $company->isActive = "Y";
                $company->createdBy = Auth::guard('admin')->user()->id;
                $company->save();
                return response()->json(['status' => 'Success', 'id'=> $company->id, 'companyName'=>$company->companyName],201);
            }

        }
    }

    public function newgroup(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'group'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $group = new Customergroup;
                $group->groupName = $request->group;
                $group->isActive = "Y";
                $group->createdBy = Auth::guard('admin')->user()->id;
                $group->save();
                return response()->json(['status' => 'Success', 'id'=> $group->id, 'groupName'=>$group->groupName],201);
            }

        }
    }

    public function newcity(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'city'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $city = new City;
                $city->cityName = $request->city;
                $city->isDelete = "N";
                $city->createdBy = Auth::guard('admin')->user()->id;
                $city->save();
                return response()->json(['status' => 'Success', 'id'=> $city->id, 'cityName'=>$city->cityName],201);
            }

        }
    }

    public function newstock(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'stock'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $broker = new Stockbroker;
                $broker->brokerName = $request->stock;
                $broker->isDelete = "N";
                $broker->createdBy = Auth::guard('admin')->user()->id;
                $broker->save();
                return response()->json(['status' => 'Success', 'id'=> $broker->id, 'brokerName'=>$broker->brokerName],201);
            }

        }
    }

    public function newroute(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'route'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $route = new Routeknown;
                $route->routeName = $request->route;
                $route->isActive = "Y";
                $route->createdBy = Auth::guard('admin')->user()->id;
                $route->save();
                return response()->json(['status' => 'Success', 'id'=> $route->id, 'routeName'=>$route->routeName],201);
            }

        }
    }
    public function massDestroy(Request $request) {
        
        if (!empty($request->input('selected_rows'))) {
            $selected_rows = explode(',', $request->input('selected_rows'));
            $files = Filetransfer::whereIn('id', $selected_rows)->delete();
        }
        

        return redirect()->back();
    }
}
