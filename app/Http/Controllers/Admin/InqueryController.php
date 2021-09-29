<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Validator;
use Session;
use App\Models\Routeknown;
use App\Models\Customergroup;
use App\Models\Company;
use App\Http\Start\Helpers;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Inquery;
use App\Models\Customer;
use App\Models\User;
use App\Models\Stock;


class InqueryController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }
    public function index() {
        if (request()->ajax()) {
            $inqueries = Inquery::join('customers', 'inqueries.customerId', '=', 'customers.id')
            ->orderBy('inqueries.created_at', 'DESC')
            ->select(['inqueries.id',
                DB::raw("DATE_FORMAT(inqueries.created_at, '%Y.%m.%d') as date"),
                'customers.name',
                'inqueries.note',
                'customers.customerGroupID',
                'customers.routesOfKnownID',
                'inqueries.keyword',
                'inqueries.customerId', 
                'inqueries.createdBy'
            ]);
            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $inqueries->where('customers.customerGroupID', $group_filter);
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
                    $inqueries->whereIn('customerId', $companyid);
                    
                }
            }
            if (request()->has('route_filter')) {
                $route_filter = request()->get('route_filter');
                if (!empty($route_filter)) {
                    $inqueries->where('customers.routesOfKnownID', $route_filter);
                }
            }
            return Datatables::of($inqueries)
                ->addColumn('action', function($row) {
                    return '<a href="'.url('admin/edit_customer/'.$row->customerId).'" class="btn btn-sm btn-primary"><i class="mdi mdi-eye-circle-outline"></i></a>';
                })
                ->addColumn('mass_delete', function($row) {
                
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'" />';
                })
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/user-record/edit_inquery/'.$row->id).'">'.$name.'</a>';
                })
                ->editColumn('keyword', function ($row) {
                    $keyword = $row->keyword;
                    $keyword_name = "";
                    if (!empty($keyword)) {
                        $keyword_arr = explode(',', $keyword);
                        foreach($keyword_arr as $item) {
                            $keyword_name.='<span class="tag badge bg-info p-1 me-1">'.$item.'</span>';
                        }  
                    } else {
                        $keyword_name = '';
                    }
                    return $keyword_name;
                })
                ->addColumn('admin', function($row) {
                    $admin = User::where('id', $row->createdBy)->first();
                    return $admin->name;
                })
                ->rawColumns(['action','name', 'admin', 'mass_delete', 'keyword'])
                ->make(true);
        }
        $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        return view('admin.user-records.inquery.index')->with(compact('groups', 'companies', 'routeknowns'));
    }
    public function add(Request $request) {
        if(!$_POST) {
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            return view('admin.user-records.inquery.add')->with(compact('customers'));
        } 
        else if ($request->submit) {
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

                return redirect('admin/user-record/inquery');
            }
        }
        else {
            return redirect('admin/user-record/inquery');
        }
    }
    public function update(Request $request) {
        if(!$_POST) {
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $inquery = Inquery::find($request->id);
            return view('admin.user-records.inquery.edit')->with(compact('customers', 'inquery'));
        } 
        else if ($request->submit) {
            $rules = array(
                'note'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $inquery = Inquery::find($request->id);
                $inquery->note = $request->note;
                $inquery->keyword = $request->keyword;
                $inquery->customerId = $request->customer;
                $inquery->createdBy = Auth::guard('admin')->user()->id;
                $inquery->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return redirect('admin/user-record/inquery');
            }
        }
        else {
            return redirect('admin/user-record/inquery');
        }
    }

    public function massDestroy(Request $request) {
        
        if (!empty($request->input('selected_rows'))) {
            $selected_rows = explode(',', $request->input('selected_rows'));
            $inquery = Inquery::whereIn('id', $selected_rows)->delete();
        }
        

        return redirect()->back();
    }
}
