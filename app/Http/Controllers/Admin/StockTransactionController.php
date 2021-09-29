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
use App\Models\Stockbroker;
use App\Models\User;

class StockTransactionController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index() {
        if (request()->ajax()) {
            $stocks = Stock::join('companies', 'stocks.companyId', '=', 'companies.id')
            ->join('customers', 'customers.id', '=', 'stocks.userId')
            ->orderBy('stocks.date', 'DESC')
            ->select(['stocks.id',
            DB::raw("DATE_FORMAT(stocks.date, '%Y.%m.%d') as date"),
            'customers.name',
            'customers.customerGroupID',
            'customers.routesOfKnownID',
            'stocks.companyId',
            DB::raw('customers.id as customersID'),
            'companies.companyName',
            'stocks.stockPrice','stocks.quantity',
            'stocks.invested', 'customers.stockBroker', 'customers.accountNumber', 'stocks.status', 'stocks.userId', 'stocks.createdBy']);
            
            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $stocks->where('customers.customerGroupID', $group_filter);
                }
            }
            
            if (request()->has('company_filter')) {
                $company_filter = request()->get('company_filter');
                if (!empty($company_filter)) {
                    $stocks->where('stocks.companyId', $company_filter);
                }
            }
            if (request()->has('route_filter')) {
                $route_filter = request()->get('route_filter');
                if (!empty($route_filter)) {
                    $stocks->where('customers.routesOfKnownID', $route_filter);
                }
            }
            return Datatables::of($stocks)
                ->addColumn('action', function($row) {
                    return '<a href="'.url('admin/edit_customer/'.$row->userId).'" class="btn btn-sm btn-primary"><i class="mdi mdi-eye-circle-outline"></i></a>';
                })
                ->addColumn('mass_delete', function($row) {
                    
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'" />';
                })
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/user-record/edit_stock/'.$row->id).'">'.$name.'</a>';
                })
                ->editColumn('status', function ($row) {
                    $status = $row->status;
                    if ($status == "Active") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_status" data-status="'.$row->status.'" data-id="'.$row->id.'">이체완료</a>';
                    } else if ($status == "Pending") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_status" data-id="'.$row->id.'" data-status="'.$row->status.'">진행중</a>';
                    } else if ($status == "Canceled") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn_status" data-id="'.$row->id.'" data-status="'.$row->status.'">취소</a>';
                    }
                    return $status_name;
                })
                ->editColumn('stockBroker', function ($row) {
                    $stockBroker = $row->stockBroker ? $row->stockBroker : 1 ;
                    $stockbrokername = Stockbroker::where('id', $stockBroker)->first();
                    return $stockbrokername->brokerName;
                })
                ->editColumn('invested', function ($row) {
                    return number_format($row->invested);
                })
                ->editColumn('stockPrice', function ($row) {
                    return number_format($row->stockPrice);
                })
                ->editColumn('quantity', function ($row) {
                    return number_format($row->quantity);
                })
                ->addColumn('admin', function($row) {
                    $admin = User::where('id', $row->createdBy)->first();
                    return $admin->name;
                })
                //->removeColumn('stocks.id')
                ->rawColumns(['action','name', 'stockBroker', 'admin', 'mass_delete', 'invested', 'stockPrice', 'quantity', 'status'])
                ->make(true);
        }
        $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        return view('admin.user-records.stocks.index')->with(compact('groups', 'companies', 'routeknowns'));
    }
    
    public function add(Request $request) {
        if(!$_POST) {
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            return view('admin.user-records.stocks.add')->with(compact('companies', 'customers'));
        } 
        else if ($request->submit) {
            
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'stock_status' => 'required',
                'stockPrice'  => 'required',
                'quantity' => 'required',
                'invested'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $stock = new Stock;
                $stock->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $stock->companyId = $request->company;
                $stock->status = $request->stock_status;
                $stock->stockPrice = $request->stockPrice;
                $stock->quantity = $request->quantity;
                $stock->invested = $request->invested;
                $stock->userId = $request->customer;
                $stock->createdBy = Auth::guard('admin')->user()->id;
                $stock->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return redirect('admin/user-record/stocks');
            }
        }
        else {
            return redirect('admin/user-record/stocks');
        }
    }

    public function update(Request $request) {
        if(!$_POST) {
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $stock = Stock::find($request->id);
            return view('admin.user-records.stocks.edit')->with(compact('stock', 'companies', 'customers'));
        } 
        else if ($request->submit){
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'stock_status' => 'required',
                'stockPrice'  => 'required',
                'quantity' => 'required',
                'invested'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $stock = Stock::find($request->id);
                $stock->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $stock->companyId = $request->company;
                $stock->status = $request->stock_status;
                $stock->stockPrice = $request->stockPrice;
                $stock->quantity = $request->quantity;
                $stock->invested = $request->invested;
                $stock->userId = $request->customer;
                $stock->createdBy = Auth::guard('admin')->user()->id;
                $stock->save();
                $this->helper->flash_message('success', 'Updated Successfully'); 

                return redirect('admin/user-record/stocks');
            }
        }
        return redirect('admin/user-record/stocks');
    }

    public function massDestroy(Request $request) {
        dd($request->input('selected_rows'));
        if (!empty($request->input('selected_rows'))) {
            $selected_rows = explode(',', $request->input('selected_rows'));
            
            $stocks = Stock::whereIn('id', $selected_rows)->delete();
        }
        

        return redirect()->back();
    }

    public function statuschange(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'stockid'=>'required',
                'status'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $stock = Stock::find($request->stockid);
                $stock->status = $request->status;
                $stock->save();
                return response()->json(['status' => 'Success'],201);
            }

        }
    }
}
