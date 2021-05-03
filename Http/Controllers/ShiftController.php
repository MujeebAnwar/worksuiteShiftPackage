<?php

namespace Modules\Shifts\Http\Controllers;


use App\GlobalCurrency;
use App\GlobalSetting;
use App\Helper\Reply;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\LanguageSetting;
use App\Project;
use App\PushNotificationSetting;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Modules\Shifts\Http\Requests\ShiftRequest;
use Modules\Shifts\Entities\Shift;
use Yajra\DataTables\Facades\DataTables;

class ShiftController extends AdminBaseController
{




    public function __construct() {

        parent::__construct();

        $this->pageTitle = Lang::get('shifts::app.createAShift');
        $this->pageIcon = 'fa fa-calendar';

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->pageTitle =Lang::get('shifts::app.shifts');
        $this->shiftsCount = Shift::count();

        return view('shifts::index',$this->data);
    }

    public function data()
    {

        $shifts = Shift::all();

        return DataTables::of($shifts)
            ->addColumn('action', function($row){
                $action = '<a href="'.route('admin.shifts.edit', [$row->id]).'" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
                $action .=   ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="'.$row->id.'" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';


                return $action;

            })
            ->editColumn(
                'id',
                function ($row) {
                    return ucfirst($row->id);
                }
            )
            ->editColumn(
                'name',
                function ($row) {
                    return ucfirst($row->name);
                }
            )
            ->editColumn(
                'start_date',
                function ($row) {
                    return $row->shift_date ? Carbon::parse($row->shift_date)->format('d-m-Y'): 'N\A';

                }
            )
            ->editColumn(
                'start_time',
                function ($row) {
                    return $row->start_time ? $row->start_time: 'N\A';

                }
            )
            ->editColumn(
                'end_date',
                function ($row) {
                    return $row->indefinite == 1 ? 'Indefinite':  Carbon::parse($row->shift_end_on)->format('d-m-Y');

                }
            )
            ->editColumn(
                'end_time',
                function ($row) {
                    return $row->finish_time ? $row->finish_time: 'N\A';

                }
            )

            ->rawColumns(['id','name','start_date','start_time','end_date','end_time','action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->projects = Project::all();
        return view('shifts::create',$this->data);

    }

    /**
     * @param $project_id
     * return project task
     */
    public function getProjectTask($project_id)
    {

        $task = Task::where('project_id',$project_id)->get();
        if ($task)
        {
            return response()->json(['status'=>true,'task'=>$task]);
        }
        if ($task)
        {
            return response()->json(['status'=>false,'task'=>'NO Task Found']);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShiftRequest $request)
    {

        $weekDay = json_encode($request->weekday);

        if ($request->has('Indefinite'))
        {
            $end_on = null;
        }else{
            $end_on = $request->end_on;
        }
        if ($request->shift_type == 2)
        {
            $cyclicDuration =$request->cyclic_duration;
        }else{
            $cyclicDuration = null;
        }

        if ($request->shift_type == 3)
        {

            $free_work_time =$request->work_time;
            $free_work_time_from = $request->work_range_from;
            $free_work_to = $request->work_range_to;

        }else{
            $free_work_time =null;
            $free_work_time_from = null;
            $free_work_to = null;
        }
        $data = [
            'name' => $request->shift_name,
            'shift_date' => $request->shift_date,
            'type' => $request->shift_type,
            'cyclic_duration' =>  $cyclicDuration,
            'start_min_time' => $request->start_min_time,
            'start_time' => $request->start_time,
            'start_max_time' => $request->start_max_time,
            'finish_min_time' => $request->finish_min_time,
            'finish_time' => $request->finish_time,
            'finish_max_time' => $request->finish_max_time,
            'break_time' => $request->break_time,
            'free_work_time' =>$free_work_time,
            'free_work_time_range' => $request->work_range_type,
            'free_work_time_from' =>$free_work_time_from,
            'free_work_time_to' =>$free_work_to,
            'range' => $request->range_type,
            'range_from' => $request->from,
            'range_to' => $request->to,
            'unhealty_shift' => $request->has('unhealty_shit') ? 1 : 0,
            'weekdays' => $weekDay,
            'indefinite' => $request->has('Indefinite') ? 1 : 0,
            'shift_end_on'=> $end_on,
            'project_id' => $request->project,
            'task_id' => $request->task,
            'tag' => $request->tag,
            'note' => $request->note,
            'publish' => 0

        ];


        Shift::create($data);
        return redirect()->route('admin.shifts.index');


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->pageTitle = Lang::get('shifts::app.editAShift');
        $this->projects = Project::all();
        $this->shift = Shift::findOrFail($id);
        if (!empty($this->shift->project_id))
        {
            $project = Project::with('tasks')->find($this->shift->project_id);
            if ($project)
            {
                $this->tasks = $project->tasks;

            }else{
                $this->task =[];
            }
        }
        return view('shifts::edit',$this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShiftRequest $request, $id)
    {

        $weekDay = json_encode($request->weekday);

        if ($request->has('Indefinite'))
        {
            $end_on = null;
        }else{
            $end_on = $request->end_on;
        }
        if ($request->shift_type == 2)
        {
            $cyclicDuration =$request->cyclic_duration;
        }else{
            $cyclicDuration = null;
        }

        if ($request->shift_type == 3)
        {

            $free_work_time =$request->work_time;
            $free_work_time_from = $request->work_range_from;
            $free_work_to = $request->work_range_to;

        }else{
            $free_work_time =null;
            $free_work_time_from = null;
            $free_work_to = null;
        }
        $data = [
            'name' => $request->shift_name,
            'shift_date' => $request->shift_date,
            'type' => $request->shift_type,
            'cyclic_duration' =>  $cyclicDuration,
            'start_min_time' => $request->start_min_time,
            'start_time' => $request->start_time,
            'start_max_time' => $request->start_max_time,
            'finish_min_time' => $request->finish_min_time,
            'finish_time' => $request->finish_time,
            'finish_max_time' => $request->finish_max_time,
            'break_time' => $request->break_time,
            'free_work_time' =>$free_work_time,
            'free_work_time_range' => $request->work_range_type,
            'free_work_time_from' =>$free_work_time_from,
            'free_work_time_to' =>$free_work_to,
            'range' => $request->range_type,
            'range_from' => $request->from,
            'range_to' => $request->to,
            'unhealty_shift' => $request->has('unhealty_shit') ? 1 : 0,
            'weekdays' => $weekDay,
            'indefinite' => $request->has('Indefinite') ? 1 : 0,
            'shift_end_on'=> $end_on,
            'project_id' => $request->project,
            'task_id' => $request->task,
            'tag' => $request->tag,
            'note' => $request->note,
            'publish' => 0

        ];

        Shift::findOrFail($id)->update($data);
        return redirect()->route('admin.shifts.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Shift::destroy($id);
        return Reply::success(__('Shift Deleted Successfully'));

    }
}
