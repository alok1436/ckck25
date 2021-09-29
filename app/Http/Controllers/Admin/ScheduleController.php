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
use App\Models\Customer;
use App\Models\Schedule;
use App\Http\Start\Helpers;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index() {
        if (request()->ajax()) {
            $schedules = Schedule::all();
            foreach ($schedules as $schedule) {
                $events[] = [
                    'title' => $schedule->title,
                    'start' => $schedule->start_time,
                    'end' => $schedule->end_time,
                    'backgroundColor' => $schedule->backgroundColor,
                    'borderColor' => $schedule->borderColor,
                    'schedule_id' => $schedule->id
                ]; 
            }

            return $events;
        }
        $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        return view('admin.schedules.index')->with(compact('customers'));
    }
    public function add(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'title' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $schedule = new Schedule;
                $schedule->start_time = $request->starttime;
                $schedule->end_time = $request->endtime;
                $schedule->backgroundColor = $request->backgroundColor;
                $schedule->borderColor = $request->borderColor;
                $schedule->userId = $request->userId;
                $schedule->title = $request->title;
                $schedule->note = $request->note;
                $schedule->createdBy = Auth::guard('admin')->user()->id;
                $schedule->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }
    public function scheduledelete(Request $request) {
        if (request()->ajax()) {
            $schedule = Schedule::find($request->schedule_id);
            $schedule->delete();
            return response()->json(['status' => 'Success'],200);
        }
    }
}
