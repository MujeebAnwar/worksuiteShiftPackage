<div class="table-responsive">
    @if(count($employees) >0)
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 18%;">@lang('shifts::app.scheduledShift')</th>
                @foreach($weekDates as $date)

                    <th style="width: 10.25%">{{Carbon\Carbon::parse($date)->format('D M d')}}</th>
            @endforeach

            </thead>
            <tbody>

            @foreach($employees as $employee)
                <tr>
                    <td>

                        <div class="user-avatar">
                            <div class="avatar">
                                <img src="{{ $employee->user->image_url }}" alt="" class="img-circle dropdown-toggle h-30 w-30"/>

                            </div>
                            <div class="info">
                                <b>{{$employee->user ? $employee->user->name : 'N\A'}}</b> <br>
                                {{$employee->designation ? $employee->designation->name : 'N\A'}}<br>
                                <small>{{$employee->employee_id}}</small>
                            </div>
                        </div>



                    </td>
                    @foreach($weekDates as $date)


                        @if(count($userShifts =$employee->assignedShiftsData($employee->id,$date) ) > 0)


                            <td class="box-block">


                        @foreach($userShifts as $userShift)


                                <div class="assigned_shift_id"  data-toggle="tooltip" data-user-id="{{$userShift->id}}" data-shift-id="{{$userShift->shift->id}}" data-employee-id="{{$employee->id}}" data-original-title="Delete"  style="cursor:pointer;width: 100%;background: {{$userShift->color}};padding:10px;color: #FFFFFF;">
                                    {{$userShift->shift ? $userShift->shift->start_time : ''}} -{{$userShift->shift ? $userShift->shift->finish_time :''}}<br>
                                    {{$userShift->shift ? ucwords($userShift->shift->name) : ''}}
                                </div>


                                    <br>

                            @endforeach
                            </td>
                        @else

                            <td class="box-btn" >
                                <a href="javascript:void(0)" class="btn btn-primary btn-add-shift" data-date="{{$date}}" data-department="{{$employee->designation ? $employee->designation->id : ''}}" data-employee="{{$employee->id}}" >
                                    <i class="fa fa-plus"></i>
                                </a>
                            </td>

                        @endif
                    @endforeach

                </tr>
            @endforeach

            </tbody>
        </table>
        @else
        <h1>No Data Found</h1>
        @endif


</div>
