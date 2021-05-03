<table class="table">
    <thead>
    <tr>
        <th>Scheduled Shift</th>
        @foreach($weekDates as $date)

            <th>{{Carbon\Carbon::parse($date)->format('D M d')}}</th>
    @endforeach

    </thead>
    <tbody>



    @foreach($employees as $employee)
        <tr>
            <td >

                {{$employee->user ? $employee->user->name : 'N\A'}}<br>
                {{$employee->designation ? $employee->designation->name : 'N\A'}}<br>
                {{$employee->employee_id}}

            </td>
            @foreach($weekDates as $date)
                @if(count($userShifts = $employee->assignedShiftsData($employee->id,$date)) > 0)
                    <td class="box-block">
                        @foreach($userShifts as $userShift)

                            {{$userShift->shift->start_time}} -{{$userShift->shift->finish_time}}<br>
                            {{ucwords($userShift->shift->name)}}
                            <br><br><br>
                        @endforeach

                    </td>
                @else
                    <td>
                        Free Shift
                    </td>

                @endif
            @endforeach

        </tr>
    @endforeach

    </tbody>
</table>


