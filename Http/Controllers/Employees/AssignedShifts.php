<?php


namespace Modules\Shifts\Http\Controllers\Employees;


use App\Http\Controllers\Member\MemberBaseController;
use App\Team;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Support\Facades\Auth;
use Modules\Shifts\Entities\AssignShifts;
use Modules\Shifts\Entities\Shift;

class AssignedShifts extends MemberBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Shifts Assigned';
        $this->pageIcon = 'fa fa-calendar';
    }
    public function index()
    {
        $this->pageTitle = 'Shifts Assigned';
        $this->pageIcon = 'fa fa-calendar';


        $date =Carbon::parse(Carbon::now()->year.'-'.Carbon::now()->month.'-01');
        $dateNow = $date->format('Y-m-d');

        $nextWeek = $date->addDay($date->daysInMonth)->format('Y-m-d');


        $id = Auth::id();
        $this->employees =AssignShifts::whereHas('employees')
            ->with('employees')
            ->whereHas('employees.user', function ($query) use($id) {
                return $query->where('id',$id);
            })
            ->with('employees.user')
            ->where('created_at','>=',$dateNow)
            ->where('created_at','<',$nextWeek)
            ->groupBY('employee_id')
            ->get()
            ->pluck('employees');

        $this->departments = Team::all();


        $date =Carbon::parse(Carbon::now()->year.'-'.Carbon::now()->month.'-01');
        $period = CarbonPeriod::create($date->format('Y-m-d'),$date->addDay($date->daysInMonth)->format('Y-m-d'));

        $datesArray = [];

        foreach ($period as $date) {

            $datesArray[] = $date->format('d-m-Y');
        }

        $this->weekDates = $datesArray;

        $this->shifts = Shift::all();

        return view('shifts::employees.assigned',$this->data);

    }
}