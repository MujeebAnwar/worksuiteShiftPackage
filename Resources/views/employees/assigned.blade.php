@extends('layouts.member-app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>

    </div>
@endsection
@push('head-script')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .box-block{
            min-width: 200px;
        }
        .box-btn{
            min-width: 80px;
        }
        .user-avatar {
            position: relative;
            min-width: 150px;
        }
        .user-avatar .avatar {

            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto 0;
        }
        .user-avatar .info {
            padding-left: 45px;
        }


        .table-responsive {

            /*overflow: visible;*/
            display: block;
            width: 100%;
            overflow: auto !important;
            margin-bottom: 20px;

        }
    </style>

@endpush

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="white-box">

                <div class="table-responsive">
                    @if(count($employees) >0)
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th style="width: 18%;">Scheduled Shift</th>
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

                                                    <div class="" style="width: 100%;background: {{$userShift->color}};padding:10px;color: #FFFFFF;">
                                                        {{$userShift->shift ? $userShift->shift->start_time : ''}} -{{$userShift->shift ? $userShift->shift->finish_time :''}}<br>
                                                        {{$userShift->shift ? ucwords($userShift->shift->name) : ''}}
                                                    </div>
                                                    <br>

                                                @endforeach
                                            </td>
                                        @else

                                            <td class="box-btn" >
                                                N/A
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

            </div>

        </div>

    </div>


@endsection
