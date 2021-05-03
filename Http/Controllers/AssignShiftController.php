<?php
namespace Modules\Shifts\Http\Controllers;
use App\EmployeeDetails;
use App\Helper\Reply;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Team;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Shifts\ExcelClass\AssignShitsExcel;
use Modules\Shifts\Http\Controllers\Employees\AssignedShifts;
use Modules\Shifts\Http\Requests\AssigShiftRequest;
use Modules\Shifts\Entities\AssignShifts;
use Modules\Shifts\Entities\Shift;

class AssignShiftController extends AdminBaseController
{


    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = Lang::get('shifts::app.assignShift');
        $this->pageIcon = 'fa fa-calendar';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->pageTitle = Lang::get('shifts::app.shiftsAssigned');
        $this->pageIcon = 'fa fa-calendar';


        $date = Carbon::parse(Carbon::now()->year . '-' . Carbon::now()->month . '-01');
        $dateNow = $date->format('Y-m-d');

        $nextWeek = $date->addDay($date->daysInMonth)->format('Y-m-d');


        $this->employees = AssignShifts::whereHas('employees')
            ->with('employees')
            ->where('created_at', '>=', $dateNow)
            ->where('created_at', '<', $nextWeek)
            ->groupBY('employee_id')
            ->get()
            ->pluck('employees');

        $this->departments = Team::all();


        $date = Carbon::parse(Carbon::now()->year . '-' . Carbon::now()->month . '-01');
        $period = CarbonPeriod::create($date->format('Y-m-d'), $date->addDay($date->daysInMonth)->format('Y-m-d'));

        $datesArray = [];

        foreach ($period as $date) {

            $datesArray[] = $date->format('d-m-Y');
        }

        $this->weekDates = $datesArray;

        $this->shifts = Shift::all();
        return view('shifts::assign-shifts.index', $this->data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->deparments = Team::all();
        $this->shifts = Shift::all();
        return view('shifts::assign-shifts.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssigShiftRequest $request)
    {


        $shift = Shift::findOrFail($request->shift_name);

        $matachedShift = [];
        $shiftDays = json_decode($shift->weekdays);

        $datesArray = [];

        $matchUser = [];


        foreach ($request->employees as $row) {
            if ($shift->indefinite) {
                $period = CarbonPeriod::create(Carbon::parse($shift->shift_date)->format('d-m-Y'), Carbon::parse($shift->shift_date)->addMonth('12')->format('d-m-Y'));


            } else {
                $period = CarbonPeriod::create(Carbon::parse($shift->shift_date)->format('d-m-Y'), Carbon::parse($shift->shift_end_on)->format('d-m-Y'));

            }
            $matchedUser = AssignShifts::with('shift')
                ->with('employees')
                ->with('employees.user')
                ->where('employee_id', $row)
                ->first();

            if ($matchedUser) {
                $matchUser[] = $matchedUser;
            } else {
                foreach ($period as $date) {


                    if (in_array($date->format('D'), $shiftDays)) {

                        AssignShifts::create(['department_id' => $request->dep_name,
                            'color' => $request->color,
                            'shift_id' => $request->shift_name,
                            'extra_hours' => $request->has('extra_hours') ? 1 : 0,
                            'employee_id' => $row,
                            'date_added' => $date->format('d-m-Y'),
                            'month_added' => $date->format('m'),
                            'year_added' => $date->format('Y'),
                            'created_at' => $date->format('Y-m-d')
                        ]);

                    }


                }
            }


        }

        if (!empty($matchUser)) {

            return response()->json([
                'data' => $matchUser,
                'shift' => $shift,

            ]);
        } else {

            return response()->json(['url' => route('admin.assign-shift.index')]);

        }


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AssignShifts::destroy($id);
        return Reply::success(__('Shift Deleted Successfully'));
    }

    public function getEmployees($id)
    {


        $details = EmployeeDetails::with('user')
            ->where('department_id', $id)
            ->get();

        return response()->json(['status' => true, 'employee' => $details]);

    }


    /**
     * Assign Shortcut shifts
     */
    public function shortcutShifts(Request $request)
    {

        $department_id = $request->dep_id;
        $shift_id = $request->shifts;
        $date_added = $request->date_added;
        $created_at = Carbon::parse($request->date_added)->format('Y-m-d');
        $employee_id = $request->employee;
        $month_added = Carbon::parse($request->date_added)->format('m');
        $year_added = Carbon::parse($request->date_added)->format('Y');

        AssignShifts::create([
            'department_id' => $department_id,
            'color' => '#2A8015',
            'shift_id' => $shift_id,
            'extra_hours' => 0,
            'employee_id' => $employee_id,
            'date_added' => $date_added,
            'month_added' => $month_added,
            'year_added' => $year_added,
            'created_at' => $created_at,
            'publish' => 0
        ]);
        return redirect()->route('admin.assign-shift.index');

    }


    public function search(Request $request)
    {
        $this->pageTitle = 'Shifts Assigned';
        $this->pageIcon = 'fa fa-calendar';


        if (!empty($request->month)) {

            $date = Carbon::parse(Carbon::now()->year . '-' . $request->month . '-01');
            $dateNow = $date->format('Y-m-d');
            $nextWeek = $date->addDay($date->daysInMonth)->format('Y-m-d');

        } else {

            $date = Carbon::parse(Carbon::now()->year . '-' . Carbon::now()->month . '-01');
            $dateNow = $date->format('Y-m-d');
            $nextWeek = $date->addDay($date->daysInMonth)->format('Y-m-d');

        }


        $this->employees = AssignShifts::whereHas('employees')
            ->with('employees');

        if (!empty($request->employee_name)) {
            $name = $request->employee_name;
            $this->employees = $this->employees
                ->whereHas('employees.user', function ($query) use ($name) {
                    return $query->where('name', 'LIKE', "%" . $name . "%");
                })
                ->with('employees.user');

        }

        if (!empty($request->department)) {
            $this->employees = $this->employees->where('department_id', $request->department);

        }
        $this->employees = $this->employees
            ->where('created_at', '>=', $dateNow)
            ->where('created_at', '<', $nextWeek)
            ->groupBY('employee_id')
            ->get()
            ->pluck('employees');
        if (!empty($request->employee)) {
            $this->employees = $this->employees->where('employee_id', $request->employee);

        }


        $this->departments = Team::all();

        if (!empty($request->month)) {

            $date = Carbon::parse(Carbon::now()->year . '-' . $request->month . '-01');
            $period = CarbonPeriod::create($date->format('Y-m-d'), $date->addDay($date->daysInMonth)->format('Y-m-d'));

        } else {

            $date = Carbon::parse(Carbon::now()->year . '-' . Carbon::now()->month . '-01');
            $period = CarbonPeriod::create($date->format('Y-m-d'), $date->addDay($date->daysInMonth)->format('Y-m-d'));

        }


        $datesArray = [];

        foreach ($period as $date) {

            $datesArray[] = $date->format('d-m-Y');
        }

        $this->weekDates = $datesArray;
        $this->shifts = Shift::all();
        $this->id = $request->employee;
        $this->name = $request->employee_name;
        $this->department_id = $request->department;
        $this->month = $request->month;
        if ($request->has('excel')) {
            return $this->exportIntoExcel($this->weekDates, $this->employees);
        }
        return view('shifts::assign-shifts.index', $this->data);

    }


    public function exportIntoExcel($weekDates, $employees)
    {


        return Excel::download(new AssignShitsExcel($weekDates, $employees), 'Assigned-Shifts.xlsx');

    }

    public function matachedEmployeeShift(Request $request)
    {

        $matchUser = [];
        $shift = null;
        $matachedEmployee = $request->employee;
        $matchedShift = $request->matachEmployee;
        $shift_id = $request->shift_id;
        $department_id = $request->dep_name;
        $color = $request->color;

        $oldShift = $request->matachEmployee['shift'];

        if ($oldShift['indefinite']) {
            $date = Carbon::parse($oldShift['shift_date']);
            $dateNow = $date->format('Y-m-d');
            $nextWeek = $date->addMonth('12')->format('Y-m-d');

        } else {
            $date = Carbon::parse($oldShift['shift_date']);
            $dateNow = $date->format('Y-m-d');
            $nextWeek = Carbon::parse($oldShift['shift_end_on'])->format('Y-m-d');

        }


        $newShift = Shift::findOrFail($request->shift_id);
        $shiftDays = json_decode($newShift->weekdays);

        if ($newShift->indefinite) {
            $period = CarbonPeriod::create(Carbon::parse($newShift->shift_date)->format('d-m-Y'), Carbon::parse($newShift->shift_date)->addMonth('12')->format('d-m-Y'));

        } else {
            $period = CarbonPeriod::create(Carbon::parse($newShift->shift_date)->format('d-m-Y'), Carbon::parse($newShift->shift_end_on)->format('d-m-Y'));

        }

        if ($request->apply == 1) {
            foreach ($request->employee as $employee) {
                if ($request->option == 1) {
                    $mathedShiftDelete = AssignShifts::where('shift_id', $employee['shift']['id'])
                        ->where('employee_id', $employee['employees']['id'])
                        ->where('created_at', '>=', $dateNow)
                        ->where('created_at', '<=', $nextWeek)
                        ->pluck('id');
                    AssignShifts::whereIn('id', $mathedShiftDelete)->delete();
                    foreach ($period as $date) {

                        if (in_array($date->format('D'), $shiftDays)) {
                            AssignShifts::create(['department_id' => $request->dep_name,
                                'color' => $color,
                                'shift_id' => $request->shift_id,
                                'extra_hours' => $request->extra,
                                'employee_id' => $employee['employees']['id'],
                                'date_added' => $date->format('d-m-Y'),
                                'month_added' => $date->format('m'),
                                'year_added' => $date->format('Y'),
                                'publish' => $request->publish,
                                'created_at' => $date->format('Y-m-d')
                            ]);
                        }


                    }

                    $matachedEmployee = [];
                }
                if ($request->option == 2) {
                    $matachedEmployee = [];

                }
                if ($request->option == 3) {
                    foreach ($period as $date) {
                        if (in_array($date->format('D'), $shiftDays)) {
                            AssignShifts::create(['department_id' => $request->dep_name,
                                'color' => $request->color,
                                'shift_id' => $request->shift_id,
                                'extra_hours' => $request->extra,
                                'employee_id' => $employee['employees']['id'],
                                'date_added' => $date->format('d-m-Y'),
                                'month_added' => $date->format('m'),
                                'year_added' => $date->format('Y'),
                                'publish' => $request->publish,
                                'created_at' => $date->format('Y-m-d')
                            ]);
                        }


                    }

                    $matachedEmployee = [];
                }

            }
        } else {
            if ($request->option == 1) {
                $mathedShiftDelete = AssignShifts::where('shift_id', $request->matachEmployee['shift_id'])
                    ->where('employee_id', $request->matachEmployee['employees']['id'])
                    ->where('created_at', '>=', $dateNow)
                    ->where('created_at', '<=', $nextWeek)
                    ->pluck('id');
                AssignShifts::whereIn('id', $mathedShiftDelete)->delete();
                foreach ($period as $date) {

                    if (in_array($date->format('D'), $shiftDays)) {
                        AssignShifts::create(['department_id' => $request->dep_name,
                            'color' => $request->color,
                            'shift_id' => $request->shift_id,
                            'extra_hours' => $request->has('extra_hours') ? 1 : 0,
                            'employee_id' => $request->employee[0]['employees']['id'],
                            'date_added' => $date->format('d-m-Y'),
                            'month_added' => $date->format('m'),
                            'year_added' => $date->format('Y'),
                            'publish' => $request->publish,
                            'created_at' => $date->format('Y-m-d')
                        ]);
                    }


                }
                array_shift($matachedEmployee);

            }
            if ($request->option == 2) {
                array_shift($matachedEmployee);

            }
            if ($request->option == 3) {
                foreach ($period as $date) {
                    if (in_array($date->format('D'), $shiftDays)) {
                        AssignShifts::create(['department_id' => $request->dep_name,
                            'color' => $request->color,
                            'shift_id' => $request->shift_id,
                            'extra_hours' => $request->has('extra_hours') ? 1 : 0,
                            'employee_id' => $request->employee[0]['employees']['id'],
                            'date_added' => $date->format('d-m-Y'),
                            'month_added' => $date->format('m'),
                            'year_added' => $date->format('Y'),
                            'publish' => $request->publish,
                            'created_at' => $date->format('Y-m-d')
                        ]);
                    }


                }
                array_shift($matachedEmployee);

            }

        }


        $matchUser[] = $matachedEmployee;
        $shift = $request->shift;


        if (!empty($matachedEmployee)) {

            return response()->json(['data' => $matchUser, 'shift' => $shift]);

        } else {

            return response()->json(['url' => route('admin.assign-shift.index')]);

        }

    }

    public function deleteForSingleEmployee(Request $request, $id)
    {
        $shift_id = $request->shift_id;
        $employee_id = $request->employee_id;
        AssignShifts::where('shift_id', $shift_id)
            ->where('employee_id', $employee_id)
            ->delete();

        return Reply::success(__('Shift Deleted Successfully'));

    }

    public function deleteForAllEmployees(Request $request, $id)
    {
        $shift_id = $request->shift_id;
        AssignShifts::where('shift_id', $shift_id)
            ->delete();
        return Reply::success(__('Shift Deleted Successfully'));
    }
}
