<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\Customer;
use App\Models\City;
use App\Models\User;
use App\Models\Routeknown;
use App\Models\Customergroup;
use App\Models\Stock;
use App\Models\Company;
use App\Models\Stockbroker;
use App\Http\Start\Helpers;
use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Session;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Filetransfer;
use App\Models\Postdelivery;
use App\Models\Visitrecord;
use App\Models\Inquery;

class CustomerController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }
    
    public function cutomerImport(Request $request){
        if(request()->isMethod('post') && $request->ajax()){
            $validator = Validator::make($request->all(), [
                'file' => 'required',
                //'file' => 'required|mimes:csv',
            ],[
                'required'=>'Please choose import file',
                'mimes'=>'Please choose only Excel Files'
            ]);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }
            Excel::import(new CustomerImport,request()->file('file'));
            return response()->json([
                'success' => true,
                'message'   =>'customer excel sheet import successfully.'
            ]);
        }else{
            return view('admin.customers');
        }
    }

    public function cutomerExport(Request $request){
        $collection = Customer::select('customers.*');
        $collection->orderBy('id','DESC');
        $customers = $collection->get();
        return Excel::download(new CustomerExport($customers), 'customers_.'.time().'.xlsx');
    }
    
    public function index() {
        if (request()->ajax()) {
            $customer = Customer::leftjoin('cities', 'cities.id', '=', 'customers.city_id')
            //->orderBy('customers.date', 'DESC')
            ->select(['customers.id',
            DB::raw("DATE_FORMAT(customers.date, '%Y.%m.%d') as date"),'customers.name','customers.phonenumber1',
            DB::raw('(CASE 
                WHEN customers.gender = "M" THEN "Male" 
                WHEN customers.gender = "F" THEN "Female" 
                ELSE "Other" 
                END) AS gender'),
            'customers.age', 'cities.cityName', 'customers.customerGroupID', 'customers.email', 'customers.routesOfKnownID']);

            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $customer->where('customers.customerGroupID', $group_filter);
                }
            }
            
            if (request()->has('company_filter')) {
                $company_filter = request()->get('company_filter');
                if (!empty($company_filter)) {
                    $stocks = Stock::where('companyId', "=", $company_filter)->select('userId')->distinct()->get();
                    $companyid = array();
                    foreach ($stocks as $key => $value) {
                        array_push($companyid, $value['userId']);
                    }
                    $customer->whereIn('customers.id', $companyid);
                }
            }
            if (request()->has('route_filter')) {
                $route_filter = request()->get('route_filter');
                if (!empty($route_filter)) {
                    $customer->where('customers.routesOfKnownID', $route_filter);
                }
            }
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $customer->whereDate('date', '>=', $start)
                        ->whereDate('date', '<=', $end);
            }

            return Datatables::of($customer)
                ->addColumn(
                    'action',
                    '<a href="" class="btn btn-sm btn-primary"><i class="mdi mdi-pencil-box-multiple"></i>  Memo</a>'
                )
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/edit_customer/'.$row->id).'">'.$name.'</a>';
                })
                ->addColumn('mass_delete', function($row) {
                    
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'" />';
                })
                ->editColumn('phonenumber1', function ($row) {
                    $phonenumber1 = $row->phonenumber1 ? $row->phonenumber1 : 0 ;
                    return $this->helper->formatPhoneNum($phonenumber1);
                })
                ->editColumn('gender', function ($row) {
                    $gender = $row->gender=='Male' ? '남' : ($row->gender=='Female' ? '여' : '기타');
                    return $gender;
                })
                ->editColumn('customerGroupID', function ($row) {
                    return $row->customerGroup ? $row->customerGroup->groupName : '';
                })
                ->rawColumns(['action','name', 'phonenumber1', 'customerGroupID', 'mass_delete'])
                ->make(true);   
        }
        $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        return view('admin.customers.index')->with(compact('groups', 'companies', 'routeknowns'));
    }

    public function delete(Request $request, $id) {
        if(Customer::find($id)) {
            $customer = Customer::find($id);
            $customer->delete();
            $this->helper->flash_message('success', 'Customer has been deleted auccessfully'); 
            return redirect('admin/customers');
        }else{
            abort(403, 'Unauthorized action.');
        }
    }
    public function add(Request $request) {
        if(!$_POST) {
            $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $cities = City::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $stockbrokers = Stockbroker::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $admins = User::all();
            return view('admin.customers.add')->with(compact('groups', 'companies', 'routeknowns', 'cities', 'stockbrokers', 'admins'));  
        }else if($request->submit) {
            
            // Add Admin User Validation Rules
            //dd($request->all());
            $rules = array(
                /*'name' => 'required|unique:customers',
                'email'  => 'required|email|unique:customers',
                'group' => 'required',
                'age'  => 'required',
                'gender' => 'required',
                'cities'  => 'required',
                'address'  => 'required',
                'stock_firm'  => 'required',
                'account_number'  => 'required',
                'phonenumber2'  => 'required',*/
                'phonenumber1' => 'required',
                /*'edited_by'  => 'required',
                'edited_date'  => 'required',
                'routsofknown'  => 'required',*/
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            }
            $customer = new Customer;
            $customer->name = $request->name ? $request->name : 'no name';
            $customer->email    = $request->email;
            $customer->customerGroupID = $request->group;
            $customer->age   = $request->age;
            $customer->gender = $request->gender;
            $customer->city_id   = $request->cities;
            $customer->address   = $request->address;
            $customer->stockBroker = $request->stock_firm;
            $customer->accountNumber   = $request->account_number;
            $customer->phonenumber1   = $request->phonenumber1;
            $customer->phonenumber2 = $request->phonenumber2;
            $customer->createdBy   = $request->edited_by;
            $customer->updatedBy   = $request->edited_by;
            $customer->date = isset($request->edited_date) ? Carbon::createFromFormat('Y.m.d', $request->edited_date)->format('Y-m-d') : date('Y.m.d');
            $customer->routesOfKnownID = $request->routsofknown;
            $customer->save();

            // Call flash message function
            $this->helper->flash_message('success', 'Customer has been added auccessfully'); 
            return redirect('admin/customers');
        }
        else {
            return redirect('admin/add_customer');
        }
    }

    public function update(Request $request) {
        if(!$_POST) {
            $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $cities = City::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $stockbrokers = Stockbroker::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $admins = User::all();
            $stocks = Stock::join('companies', 'stocks.companyId', '=', 'companies.id')
                ->join('customers', 'customers.id', '=', 'stocks.userId')
                ->join('users', 'users.id', '=', 'stocks.createdBy')
                ->where('customers.id', '=', $request->id)
                ->orderBy('stocks.date', 'DESC')
                ->select(['stocks.id',
                DB::raw("DATE_FORMAT(stocks.date, '%Y.%m.%d') as date"),
                'customers.name',
                'companies.companyName',
                'users.name as adminname',
                'stocks.stockPrice','stocks.quantity',
                'stocks.invested', 'customers.stockBroker', 'customers.accountNumber', 'stocks.status', 'stocks.userId', 'stocks.createdBy'])
                ->get();
            $stocksCount = $stocks->count();
            $filetransfers = Filetransfer::join('companies', 'filetransfers.companyId', '=', 'companies.id')
                ->join('customers', 'customers.id', '=', 'filetransfers.userId')
                ->join('users', 'users.id', '=', 'filetransfers.createdBy')
                ->where('customers.id', '=', $request->id)
                ->orderBy('filetransfers.date', 'DESC')
                ->select([
                    'filetransfers.id',
                    DB::raw("DATE_FORMAT(filetransfers.date, '%Y.%m.%d') as date"),
                    'customers.name',
                    'users.name as adminname',
                    'companies.companyName',
                    'filetransfers.fileName',
                    'filetransfers.method',
                    'filetransfers.createdBy',
                    'filetransfers.userId',
                ])->get();
            $filetransfersCount = $filetransfers->count();
            $postdeliveries = Postdelivery::join('companies', 'postdeliveries.companyId', '=', 'companies.id')
                ->join('customers', 'customers.id', '=', 'postdeliveries.userId')
                ->join('users', 'users.id', '=', 'postdeliveries.createdBy')
                ->where('customers.id', '=', $request->id)
                ->orderBy('postdeliveries.date', 'DESC')
                ->select(['postdeliveries.id',
                    DB::raw("DATE_FORMAT(postdeliveries.date, '%Y.%m.%d') as date"),
                    'customers.name',
                    'users.name as adminname',
                    'companies.companyName',
                    'postdeliveries.cityId',
                    'postdeliveries.status',
                    'postdeliveries.address', 
                    'postdeliveries.userId', 
                    'postdeliveries.createdBy'
                ])->get();
            //dd($postdeliveries);
            $postdeliveriesCount = $postdeliveries->count();
            $visitrecords = Visitrecord::join('customers', 'visitrecords.userId', '=', 'customers.id')
                ->orderBy('visitrecords.date', 'DESC')
                ->join('users', 'users.id', '=', 'visitrecords.createdBy')
                ->where('customers.id', '=', $request->id)
                ->select(['visitrecords.id',
                    DB::raw("DATE_FORMAT(visitrecords.date, '%Y.%m.%d') as date"),
                    'customers.name',
                    'visitrecords.title',
                    'users.name as adminname',
                    'visitrecords.time',
                    'visitrecords.status',
                    'visitrecords.userId', 
                    'visitrecords.createdBy'
                ])->get();
            $visitrecordsCount = $visitrecords->count();
            $inqueries = Inquery::join('customers', 'inqueries.customerId', '=', 'customers.id')
                ->join('users', 'users.id', '=', 'inqueries.createdBy')
                ->where('customers.id', '=', $request->id)
                ->orderBy('inqueries.created_at', 'DESC')
                ->select(['inqueries.id',
                    DB::raw("DATE_FORMAT(inqueries.created_at, '%Y.%m.%d') as date"),
                    'customers.name',
                    'inqueries.note',
                    'users.name as adminname',
                    'customers.customerGroupID',
                    'customers.routesOfKnownID',
                    'inqueries.keyword',
                    'inqueries.customerId', 
                    'inqueries.createdBy'
                ])->get();
            $inqueriesCount = $inqueries->count();
            $customer = Customer::find($request->id);
            
            if($customer) {
                return view('admin.customers.edit')->with(compact('groups', 'companies', 'routeknowns', 'cities', 'stockbrokers', 'admins', 'customer', 'stocks', 'filetransfers', 'postdeliveries', 'visitrecords', 'inqueries', 'inqueriesCount', 'visitrecordsCount', 'postdeliveriesCount', 'filetransfersCount', 'stocksCount')); 
            }
            else {
                $this->helper->flash_message('danger', 'Invalid ID'); // Call flash message function
                return redirect('admin/customers');
            }
        }
        else if ($request->submit) {
            // Add Admin User Validation Rules
            
            $rules = array(
                /*'name' => 'required|unique:customers,name,'.$request->id,
                'email' => 'required|email|unique:customers,email,'.$request->id,
                'group'  => 'required',
                'age'   => 'required',
                'gender'  => 'required',
                'cities'  => 'required',
                'address'  => 'required',
                'stock_firm'  => 'required',
                'account_number'  => 'required',
                'phonenumber2'  => 'required',*/
                'phonenumber1' => 'required',
                /*'edited_by'  => 'required',
                'edited_date'  => 'required',
                'routsofknown'  => 'required',*/
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            }
            
            $customer = Customer::find($request->id);
            $customer->name = $request->name ? $request->name : 'no name';
            $customer->email = $request->email;
            $customer->customerGroupID = $request->group;
            $customer->age = $request->age;
            $customer->gender = $request->gender;
            $customer->city_id = $request->cities;
            $customer->address   = $request->address;
            $customer->stockBroker = $request->stock_firm;
            $customer->accountNumber   = $request->account_number;
            $customer->phonenumber1   = $request->phonenumber1;
            $customer->phonenumber2 = $request->phonenumber2;
            $customer->createdBy   = $request->edited_by;
            $customer->updatedBy   = $request->edited_by;
            $customer->date = isset($request->edited_date) ? Carbon::createFromFormat('Y.m.d', $request->edited_date)->format('Y-m-d') : date('Y.m.d');
            $customer->routesOfKnownID   = $request->routsofknown;
            $customer->save();

            $this->helper->flash_message('success', 'Customer has been updated successfully');

            return redirect('admin/edit_customer/'.$request->id);
        }
    }

    public function excelupload(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'excel_file' => 'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            }
            $path = $request->file('excel_file')->getRealPath();
            $data = Excel::load($path)->get();
            if($data->count() > 0) {
                foreach($data->toArray() as $key => $value) {
                    try {
                        $city = City::where('cityName', $value['city'])->first()->id;
                        $group = Customergroup::where('groupName', $value['group'])->first()->id;
                        if($value['gender'] == "Male") {
                            $gender = "M";
                        } else if ($value['gender'] == "Female") {
                            $gender = "F";
                        } else {
                            $gender = "O";
                        }
                        $insert_data[] = array(
                            'created_at'  => Carbon::createFromFormat('Y.m.d', $value['date'])->format('Y-m-d H:i:s'),
                            'name'=> $value['name'],
                            'phonenumber1'   => $value['number'],
                            'gender'=> $gender,
                            'age'  => $value['age'],
                            'city_id'   => $city,
                            'customerGroupID'   => $group,
                            'email'   => $value['email'],
                            'routesOfKnownID' => '1',
                            'createdBy' => '1',
                            'updatedBy' => '1'
                        );
                    } catch (\Exception $e) {
                        $this->helper->flash_message('error', $e->getMessage());
                    }
                    
                }
                if(!empty($insert_data)) {
                    //DB::table('customers')->insert($insert_data);
                    return response()->json(['status' => 'Success'],201);
                }
            }
            return response()->json(['status' => 'File empty or bad file'],401);
            
        }
        

    }

    public function massDestroy(Request $request) {
        if (request()->ajax()) {
            
            if (!empty($request->selected_rows)) {
                $selected_rows = $request->selected_rows;
                $customers = Customer::whereIn('id', $selected_rows)->delete();
                return response()->json(['status' => 'Success'],201);
            }
        }
        
    }

    public function stockformadd(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'status' => 'required',
                'stockPrice'  => 'required',
                'quantity' => 'required',
                'invested'  => 'required',
                'customerId'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $stock = new Stock;
                $stock->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $stock->companyId = $request->company;
                $stock->status = $request->status;
                $stock->stockPrice = $request->stockPrice;
                $stock->quantity = $request->quantity;
                $stock->invested = $request->invested;
                $stock->userId = $request->customerId;
                $stock->createdBy = Auth::guard('admin')->user()->id;
                $stock->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }

    public function stockformupdate(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'status' => 'required',
                'stockPrice'  => 'required',
                'quantity' => 'required',
                'invested'  => 'required',
                'customerId'  => 'required',
                'upstockid'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $stock = Stock::find($request->upstockid);
                $stock->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $stock->companyId = $request->company;
                $stock->status = $request->status;
                $stock->stockPrice = $request->stockPrice;
                $stock->quantity = $request->quantity;
                $stock->invested = $request->invested;
                $stock->userId = $request->customerId;
                $stock->createdBy = Auth::guard('admin')->user()->id;
                $stock->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }

    public function getstockform(Request $request) {
        if (request()->ajax()) {
            $stock = Stock::find($request->upstock);
            $data = [
                'quantity' => $stock->quantity,
                'stockPrice' => $stock->stockPrice,
                'invested' => $stock->invested,
                'company' => $stock->companyId,
                'stock_status' => $stock->status,
                'stockdate' => date('Y.m.d', strtotime($stock->date))
            ];
            return response()->json($data,200);
        }
    }
    public function transferformadd(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'method' => 'required',
                'fileName'  => 'required',
                'customerId'  => 'required',
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
                $filetransfer->userId = $request->customerId;
                $filetransfer->createdBy = Auth::guard('admin')->user()->id;
                $filetransfer->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }
    public function gettransferform(Request $request) {
        if (request()->ajax()) {
            $filetransfer = Filetransfer::find($request->fileid);
            $data = [
                'fileName' => $filetransfer->fileName,
                'company' => $filetransfer->companyId,
                'method' => $filetransfer->method,
                'date' => date('Y.m.d', strtotime($filetransfer->date))
            ];
            return response()->json($data,200);
        }
    }
    public function transferformupdate(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'method' => 'required',
                'fileName'  => 'required',
                'customerId'  => 'required',
                'fileid'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $filetransfer = Filetransfer::find($request->fileid);
                $filetransfer->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $filetransfer->companyId = $request->company;
                $filetransfer->method = $request->method;
                $filetransfer->fileName = $request->fileName;
                $filetransfer->userId = $request->customerId;
                $filetransfer->createdBy = Auth::guard('admin')->user()->id;
                $filetransfer->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }
    public function posterformadd(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'city' => 'required',
                'status' => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $postdelivery = new Postdelivery;
                $postdelivery->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $postdelivery->companyId = $request->company;
                $postdelivery->cityId = $request->city;
                $postdelivery->address = $request->address;
                $postdelivery->status = $request->status;
                $postdelivery->userId = $request->customer;
                $postdelivery->createdBy = Auth::guard('admin')->user()->id;
                $postdelivery->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }

    public function posterformupdate(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'city' => 'required',
                'status' => 'required',
                'customer'  => 'required',
                'postid'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $postdelivery = Postdelivery::find($request->postid);
                $postdelivery->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $postdelivery->companyId = $request->company;
                $postdelivery->cityId = $request->city;
                $postdelivery->address = $request->address;
                $postdelivery->status = $request->status;
                $postdelivery->userId = $request->customer;
                $postdelivery->createdBy = Auth::guard('admin')->user()->id;
                $postdelivery->save();
                $this->helper->flash_message('success', 'Post has been updated successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }

    public function getposterform(Request $request) {
        if (request()->ajax()) {
            $poster = Postdelivery::find($request->postid);
            $data = [
                'city' => $poster->cityId,
                'company' => $poster->companyId,
                'address' => $poster->address,
                'status' => $poster->status,
                'date' => date('Y.m.d', strtotime($poster->date))
            ];
            return response()->json($data,200);
        }
    }

    public function visitformadd(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'date' => 'required',
                'title'  => 'required',
                'time' => 'required',
                'status' => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $visitrecord = new Visitrecord;
                $visitrecord->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $visitrecord->title = $request->title;
                $visitrecord->time = $request->time;
                $visitrecord->status = $request->status;
                $visitrecord->userId = $request->customer;
                $visitrecord->createdBy = Auth::guard('admin')->user()->id;
                $visitrecord->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }
    public function visitformupdate(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'date' => 'required',
                'title'  => 'required',
                'time' => 'required',
                'status' => 'required',
                'customer'  => 'required',
                'visitid' => 'required'
            );
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $visitrecord = Visitrecord::find($request->visitid);
                $visitrecord->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $visitrecord->title = $request->title;
                $visitrecord->time = $request->time;
                $visitrecord->status = $request->status;
                $visitrecord->userId = $request->customer;
                $visitrecord->createdBy = Auth::guard('admin')->user()->id;
                $visitrecord->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }
    public function getvisitform(Request $request) {
        if (request()->ajax()) {
            $visit = Visitrecord::find($request->visitid);
            $data = [
                'title' => $visit->title,
                'time' => $visit->time,
                'status' => $visit->status,
                'date' => date('Y.m.d', strtotime($visit->date))
            ];
            return response()->json($data,200);
        }
    }

    public function inqueryformadd(Request $request) {
        $rules = array(
            'note'  => 'required',
            'customer'  => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } 
        else {
            
            $inquery = new Inquery;
            $inquery->note = $request->note;
            if (request()->has('keyword')) {
                $keyword = request()->get('keyword');
                if (!empty($keyword)) {
                    $inquery->keyword = $keyword;
                }
                else {
                    $inquery->keyword = '';
                }
            }
            $inquery->customerId = $request->customer;
            $inquery->createdBy = Auth::guard('admin')->user()->id;
            $inquery->save();
            $this->helper->flash_message('success', 'Added Successfully'); 

            return response()->json(['status' => 'Success'],201);
        }
    }
    public function inqueryformupdate(Request $request) {
        $rules = array(
            'note'  => 'required',
            'customer'  => 'required',
            'inqueryid' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } 
        else {
            $inquery = Inquery::find($request->inqueryid);
            $inquery->note = $request->note;
            $inquery->keyword = $request->keyword;
            $inquery->customerId = $request->customer;
            $inquery->createdBy = Auth::guard('admin')->user()->id;
            $inquery->save();
            $this->helper->flash_message('success', 'Added Successfully'); 

            return response()->json(['status' => 'Success'],201);
        }
    }

    public function getinqueryform(Request $request) {
        if (request()->ajax()) {
            $inquery = Inquery::find($request->inqueryid);
            $data = [
                'note' => $inquery->note,
                'keyword' => $inquery->keyword
            ];
            return response()->json($data,200);
        }
    }
}
