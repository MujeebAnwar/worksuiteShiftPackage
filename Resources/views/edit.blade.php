@extends('layouts.app')

@section('page-title')

    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
            <p><b>@lang('shifts::app.shiftSchedule')</b></p>
        </div>

    </div>
@endsection

@push('head-script')

    <link rel="stylesheet" href="{{asset('plugins/bower_components/switchery/dist/switchery.min.css')}}">

    <style>
        .bootstrap-datetimepicker-widget table td{
            cursor: pointer;
        }
        .bootstrap-datetimepicker-widget table td.active{
            background-color: #007bff !important;
            color: #fff !important;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25) !important;

        }


        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 50px;
            margin-top:30px;
            margin-bottom:30px;
            margin-left: 10px;
        }

        .switch input {
            display:none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #FFFFFF;
            -webkit-transition: .4s;
            transition: .4s;
        }



        input:checked + .slider {
            background-color: #2ab934;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(55px);
            -ms-transform: translateX(55px);
            transform: translateX(55px);
        }

        /*------ ADDED CSS ---------*/
        .on
        {
            display: none;
        }

        .on
        {
            color: #FFFFFF;
            position: absolute;
            transform: translate(-50%,-50%);
            top: 50%;
            left: 50%;
            font-size: 16px;
            font-family: Verdana, sans-serif;
        }
        .off{
            color: #2ab934;
            position: absolute;
            transform: translate(-50%,-50%);
            top: 50%;
            left: 50%;
            font-size: 14px;
            font-family: Verdana, sans-serif;
        }

        input:checked+ .slider .on
        {display: block;}

        input:checked + .slider .off
        {display: none;}

        /*--------- END --------*/

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        .weekdays{
            background: #f6f7f9;
        }
        .input-group {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            width: 100%;
        }
        .input-group>.form-control{
            position: relative;
            flex: 1 1 auto;
            width: 1%;
            min-width: 0;
            margin-bottom: 0;
        }
        .input-group-append {
            margin-left: -1px;
            display: flex;
        }
        .input-group >.input-group-append >.input-group-text{
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        .input-group-text {

            /* display: flex; */
            align-items: center;
            padding: .375rem .75rem;
            margin-bottom: 0;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            text-align: center;
            white-space: nowrap;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            cursor: pointer;
        }
        .custom_label{
            margin-top: 2%;
        }
        .cyclic_duration{
            margin-top: 7%;
        }
        .error{
            color: #a94442;
        }
        .errorBorder{
            border: 1px solid #fb9678;
        }
        .inputError{
            border: 1px solid #fb9678;
        }

    </style>

@endpush

@section('content')

    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    @lang('shifts::app.shiftHeading')
                </div>
                <div class="vtabs customvtab m-t-10">
                    @include('shifts::menu.shift_menu')
                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            {!! Form::open(['method'=>'PUT','route' => ['admin.shifts.update',$shift->id],'id'=>'update-shift-form']) !!}

                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xs-12">

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group {{$errors->has('shift_name') ? 'has-error' : ''}}">
                                                <label for="shift_name">@lang('shifts::app.shiftName') <b class="error">*</b></label>
                                                <input type="text" class="form-control" id="shift_name"
                                                       name="shift_name"
                                                       value="{{$shift->name}}">
                                                @if($errors->has('shift_name'))
                                                    <div class="help-block">
                                                        {{ $errors->first('shift_name') }}
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group {{$errors->has('shift_date') ? 'has-error' : '' }}">
                                                <label for="shift_date">@lang('shifts::app.shiftDate') <b class="error">*</b></label>
                                                <div class="input-group date" id="date1" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input" name="shift_date" data-target="#date1" value="{{$shift->shift_date}}"/>
                                                    <div class="input-group-append" data-target="#date1" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                @if($errors->has('shift_date'))
                                                    <div class="help-block">
                                                        {{ $errors->first('shift_date') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="shift_date">@lang('shifts::app.shiftType')</label>
                                                <br>
                                                <input type="radio" {{$shift->type == 1 ? 'checked' : ''}}  class=""  id="recurring_type"
                                                       name="shift_type" value="1" {{old('shift_type') ? old('shift_type')=='1' ? 'checked' : '' : '' }}>
                                                <label for="">@lang('shifts::app.recurring')</label>
                                                <br>

                                                <input type="radio" class="" id="cyclic_type"  {{$shift->type == 2 ? 'checked' : ''}}
                                                name="shift_type" value="2" >
                                                <label for="">@lang('shifts::app.cyclic')</label>

                                                <br>
                                                <input type="radio" class="" id="free_type"
                                                       name="shift_type"
                                                       value="3" {{$shift->type == 3 ? 'checked' : ''}}>
                                                <label for="">@lang('shifts::app.free')</label>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-5 col-xs-12 cyclic_duration {{$shift->type == 2 ? 'show' : 'hide' }}">
                                            <div class="form-group {{$errors->has('cyclic_duration') ? 'has-error' : ''}}" >
                                                <label for="cyclic_duration">@lang('shifts::app.cyclicDuration')</label>

                                                <input type="number"  class="form-control"  min="1" max="7"  id="cyclic_duration"
                                                       name="cyclic_duration"
                                                       value="{{$shift->cyclic_duration}}">
                                                <label for="">(@lang('shifts::app.numberOfDuration'))</label>
                                                @if($errors->has('cyclic_duration'))
                                                    <div class="help-block">
                                                        {{ $errors->first('cyclic_duration') }}
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row time_class {{$shift->type != 3 ? 'show' : 'hide' }}">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="start_min_time">@lang('shifts::app.startMinTime')</label>
                                                <div class="input-group date {{$errors->has('start_min_time') ? 'errorBorder' : ''}}" id="datetimepicker1" data-target-input="nearest">
                                                    <input   type="text" name="start_min_time" value="{{$shift->start_min_time}}" class="form-control  datetimepicker-input" data-target="#datetimepicker1" id="startTime"/>

                                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                    </div>

                                                </div>
                                                @if($errors->has('start_min_time'))
                                                    <div class="error">
                                                        {{ $errors->first('start_min_time') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="start_time">@lang('shifts::app.startTime') </label>
                                                <div class="input-group date {{$errors->has('start_time') ? 'errorBorder' : ''}}"  id="datetimepicker2" data-target-input="nearest">
                                                    <input type="text"  name="start_time" value="{{$shift->start_time}}"   class="form-control datetimepicker-input" data-target="#datetimepicker2" id="endTime"/>
                                                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                    </div>
                                                </div>
                                                @if($errors->has('start_time'))
                                                    <div class="error">
                                                        {{ $errors->first('start_time') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="start_max_time">@lang('shifts::app.startMaxTime')</label>
                                                <div class="input-group date {{$errors->has('start_max_time') ? 'errorBorder' : ''}}"  id="datetimepicker3" data-target-input="nearest">
                                                    <input type="text"  name="start_max_time" value="{{$shift->start_max_time}}"  class="form-control datetimepicker-input" data-target="#datetimepicker3" id="endTime"/>
                                                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                    </div>
                                                </div>
                                                @if($errors->has('start_max_time'))
                                                    <div class="error">
                                                        {{ $errors->first('start_max_time')}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row time_class {{$shift->type != 3 ? 'show' : 'hide' }}">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="finish_min_time">@lang('shifts::app.finishMinTime')</label>
                                                <div class="input-group date {{$errors->has('finish_min_time') ? 'errorBorder' : ''}}"  id="datetimepicker4" data-target-input="nearest">
                                                    <input type="text" value="{{$shift->finish_min_time}}" name="finish_min_time"  class="form-control datetimepicker-input" data-target="#datetimepicker4" id="endTime"/>
                                                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                    </div>
                                                </div>
                                                @if($errors->has('finish_min_time'))
                                                    <div class="error">
                                                        {{ $errors->first('finish_min_time')}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="finish_time">@lang('shifts::app.finishTime')</label>
                                                <div class="input-group date {{$errors->has('finish_time') ? 'errorBorder' : ''}}"  id="datetimepicker5" data-target-input="nearest">
                                                    <input type="text"  name="finish_time" value="{{$shift->finish_time}}"  class="form-control datetimepicker-input" data-target="#datetimepicker5" id="endTime"/>
                                                    <div class="input-group-append" data-target="#datetimepicker5" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                    </div>
                                                </div>
                                                @if($errors->has('finish_time'))
                                                    <div class="error">
                                                        {{ $errors->first('finish_time')}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="finish_min_time">@lang('shifts::app.finishMaxTime')</label>
                                                <div class="input-group date {{$errors->has('finish_max_time') ? 'errorBorder' : ''}}"  id="datetimepicker6" data-target-input="nearest">
                                                    <input type="text" value="{{$shift->finish_max_time}}"  name="finish_max_time"  class="form-control datetimepicker-input" data-target="#datetimepicker6" id="endTime"/>
                                                    <div class="input-group-append" data-target="#datetimepicker6" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                    </div>
                                                </div>
                                                @if($errors->has('finish_max_time'))
                                                    <div class="error">
                                                        {{ $errors->first('finish_max_time')}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row {{$shift->type == 3 ? 'show' :'hide'}}" id="work_time">

                                        <div class="form-group {{$errors->has('work_time') ? 'has-error' : ''}}">
                                            <div class="col-md-5 col-sm-12 col-xs-12 custom_label">
                                                <label for="work_time">@lang('shifts::app.workTime') </label>

                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control" id="work_time" name="work_time" value="{{$shift->free_work_time}}">
                                                @if($errors->has('work_time'))
                                                    <div class="help-block">
                                                        {{ $errors->first('work_time') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <label for="hours">(@lang('shifts::app.amountOfHours'))</label>
                                        </div>
                                    </div>
                                    <div class="row {{$shift->type == 3 ? 'show' :'hide'}}" id="work_range_time">
                                        <div class="col-sm-12 col-md-3 col-xs-12 custom_label">
                                            <div class="form-group">
                                                <label for="range">@lang('shifts::app.workRange') ?</label>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2 col-xs-12" >
                                            <div class="form-group" id="work_range">
                                                <input type="radio" {{$shift->free_work_time_range == 1 ? 'checked' :''}} class=""  id="work_range_yes"
                                                       name="work_range_type"
                                                       value="1">
                                                <label for="">@lang('app.yes')</label>
                                                <br>
                                                <input type="radio" class="" value="0" {{$shift->free_work_time_range == 0 ? 'checked' :''}} id="work_range_no"
                                                       name="work_range_type">
                                                <label for="">@lang('app.no')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3 col-xs-12 work_time_range_period">
                                            <div class="form-group {{$errors->has('work_range_from') ? 'has-error' : ''}}">
                                                <label for="from">@lang('app.from')</label>
                                                <div class="input-group date {{$errors->has('work_range_from') ? 'errorBorder' : ''}}"  id="datetimepicker9" data-target-input="nearest">
                                                    <input type="text" value="{{$shift->free_work_time_from}}"  name="work_range_from"  class="form-control datetimepicker-input" data-target="#datetimepicker7" id="endTime"/>
                                                    <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                    </div>
                                                </div>
                                                @if($errors->has('work_range_from'))
                                                    <div class="help-block">
                                                        {{ $errors->first('work_range_from') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3 col-xs-12 work_time_range_period">
                                            <div class="form-group {{$errors->has('work_range_to') ? 'has-error' : ''}}">
                                                <label for="to">@lang('app.to')</label>
                                                <div class="input-group date {{$errors->has('work_range_to') ? 'errorBorder' : ''}}"  id="datetimepicker0" data-target-input="nearest">
                                                    <input type="text" value="{{$shift->free_work_time_to}}"  name="work_range_to"  class="form-control datetimepicker-input" data-target="#datetimepicker8" id="endTime"/>
                                                    <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                    </div>
                                                </div>
                                                @if($errors->has('work_range_to'))
                                                    <div class="help-block">
                                                        {{ $errors->first('work_range_to') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="form-group {{$errors->has('break_time') ? 'has-error' : ''}}">
                                            <div class="col-sm-12 col-md-5 col-xs-12 custom_label">

                                                <label for="break_time">@lang('shifts::app.breakTime') <b class="error">*</b></label>

                                            </div>
                                            <div class="col-sm-12 col-md-4 col-xs-12">
                                                <input type="text" name="break_time" value="{{$shift->break_time}}" class="form-control " id="break_time" >
                                                @if($errors->has('break_time'))
                                                    <div class="help-block">
                                                        {{ $errors->first('break_time') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <label for="hours">(@lang('shifts::app.hours'))</label>

                                        </div>
                                    </div>



                                    <div class="row">

                                        <div class="col-sm-12 col-md-2 col-xs-12 custom_label">
                                            <div class="form-group">
                                                <label for="range">@lang('shifts::app.range')</label>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3 col-xs-12" >
                                            <div class="form-group" id="range">
                                                <input type="radio" {{$shift->range == 1 ?'checked':''}} class=""  id="range_yes"
                                                       name="range_type"
                                                       value="1">
                                                <label for="">@lang('app.yes')</label>
                                                <br>
                                                <input type="radio" class="" value="0" id="range_no"
                                                       name="range_type" {{$shift->range == 0 ?'checked':''}}>
                                                <label for="">@lang('app.no')</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3 col-xs-12 range_period {{$shift->range == 1 ?'show':'hide'}}">
                                            <div class="form-group {{$errors->has('from') ? 'has-error' : ''}}">
                                                <label for="from">@lang('app.from')</label>
                                                <div class="input-group date {{$errors->has('from') ? 'errorBorder' : ''}}"  id="datetimepicker7" data-target-input="nearest">
                                                    <input type="text" value="{{$shift->range_from}}"  name="from"  class="form-control datetimepicker-input" data-target="#datetimepicker7" id="endTime"/>
                                                    <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                    </div>
                                                </div>

                                                @if($errors->has('from'))
                                                    <div class="help-block">
                                                        {{ $errors->first('from') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3 col-xs-12 range_period {{$shift->range == 1 ?'show':'hide'}}">
                                            <div class="form-group {{$errors->has('to') ? 'has-error' : ''}}">
                                                <label for="to">@lang('app.to')</label>
                                                <div class="input-group date {{$errors->has('to') ? 'errorBorder' : ''}}"  id="datetimepicker8" data-target-input="nearest">
                                                    <input type="text" value="{{$shift->range_to}}"  name="to"  class="form-control datetimepicker-input" data-target="#datetimepicker8" id="endTime"/>
                                                    <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                    </div>
                                                </div>

                                                @if($errors->has('to'))
                                                    <div class="help-block">
                                                        {{ $errors->first('to') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3 col-xs-12">
                                            <div class="form-group">
                                                <label for="unhealty_shit">@lang('shifts::app.unhealtyShift')</label>

                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-xs-3">
                                            <div class="form-group">
                                                <div class="switchery-demo">
                                                    <input type="checkbox" {{$shift->unhealty_shift == 1 ?'checked':''}} id="unhealty_shit" name="unhealty_shit" class="unhealty_shit" data-size="small" data-color="#00c292" data-secondary-color="#f96262" style="display: none;" data-switchery="true">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-xs-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-xs-12 {{$shift->type !=2 ? 'show' :'hide'}}" id="recurring_weekday">
                                            <label for="shift_date">@lang('shifts::app.weekdays') <b class="error">*</b></label>
                                            <div class="weekdays {{$errors->has('weekday') ? 'errorBorder' : ''}}">

                                                <div class="form-group">

                                                    <label class="switch">
                                                        <input type="checkbox" {{$shift->type ==2 ? 'disabled' :''}} @foreach(json_decode($shift->weekdays) as $scripts) @if('Mon' == $scripts) checked="checked" @endif @endforeach class="weekdayButton"  name="weekday[]" value="Mon" id="togBtn">
                                                        <div class="slider round">
                                                            <!--ADDED HTML -->
                                                            <span class="on">M</span>
                                                            <span class="off">M</span>
                                                            <!--END-->
                                                        </div>
                                                    </label>
                                                    <label class="switch">
                                                        <input type="checkbox" {{$shift->type ==2 ? 'disabled' :''}} class="weekdayButton" name="weekday[]" value="Tue" @foreach(json_decode($shift->weekdays) as $scripts) @if('Tue' == $scripts) checked="checked" @endif @endforeach id="togBtn">
                                                        <div class="slider round">
                                                            <!--ADDED HTML -->
                                                            <span class="on">T</span>
                                                            <span class="off">T</span>
                                                            <!--END-->
                                                        </div>
                                                    </label>
                                                    <label class="switch">
                                                        <input type="checkbox" {{$shift->type ==2 ? 'disabled' :''}} class="weekdayButton" name="weekday[]" value="Wed" @foreach(json_decode($shift->weekdays) as $scripts) @if('Wed' == $scripts) checked="checked" @endif @endforeach id="togBtn">
                                                        <div class="slider round">
                                                            <!--ADDED HTML -->
                                                            <span class="on">W</span>
                                                            <span class="off">W</span>
                                                            <!--END-->
                                                        </div>
                                                    </label>
                                                    <label class="switch">
                                                        <input type="checkbox" {{$shift->type ==2 ? 'disabled' :''}} class="weekdayButton" name="weekday[]" value="Thu" @foreach(json_decode($shift->weekdays) as $scripts) @if('Thu' == $scripts) checked="checked" @endif @endforeach id="togBtn">
                                                        <div class="slider round">
                                                            <!--ADDED HTML -->
                                                            <span class="on">T</span>
                                                            <span class="off">T</span>
                                                            <!--END-->
                                                        </div>
                                                    </label>
                                                    <label class="switch">
                                                        <input type="checkbox"  {{$shift->type ==2 ? 'disabled' :''}} class="weekdayButton" name="weekday[]" value="Fri" @foreach(json_decode($shift->weekdays) as $scripts) @if('Fri' == $scripts) checked="checked" @endif @endforeach id="togBtn">
                                                        <div class="slider round">
                                                            <!--ADDED HTML -->
                                                            <span class="on">F</span>
                                                            <span class="off">F</span>
                                                            <!--END-->
                                                        </div>
                                                    </label>
                                                    <label class="switch">
                                                        <input type="checkbox" {{$shift->type ==2 ? 'disabled' :''}} class="weekdayButton" name="weekday[]" value="Sat" @foreach(json_decode($shift->weekdays) as $scripts) @if('Sat' == $scripts) checked="checked" @endif @endforeach id="togBtn">
                                                        <div class="slider round">
                                                            <!--ADDED HTML -->
                                                            <span class="on">S</span>
                                                            <span class="off">S</span>
                                                            <!--END-->
                                                        </div>
                                                    </label>
                                                    <label class="switch">
                                                        <input type="checkbox" {{$shift->type !=2 ? 'disabled' :''}} class="weekdayButton" name="weekday[]" value="Sun" @foreach(json_decode($shift->weekdays) as $scripts) @if('Sun' == $scripts) checked="checked" @endif @endforeach id="togBtn">
                                                        <div class="slider round">
                                                            <!--ADDED HTML -->
                                                            <span class="on">S</span>
                                                            <span class="off">S</span>
                                                            <!--END-->
                                                        </div>
                                                    </label>


                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-xs-12 {{$shift->type ==2 ? 'show' :'hide'}}" id="week_day_number">
                                            <label for="shift_date">@lang('shifts::app.weekdays') <b class="error">*</b></label>
                                            <div class="weekdays {{$errors->has('weekday') ? 'errorBorder' : ''}}">

                                                <?php $current_day = ''; ?>
                                                <div class="form-group" id="week_day_switch">
                                                    @for($i=1; $i<=$shift->cyclic_duration; $i++)
                                                        @if($i==1)

                                                            @php $current_day = 'Mon' @endphp
                                                        @endif
                                                        @if($i==2)
                                                            @php $current_day = 'Tue'@endphp
                                                        @endif
                                                        @if($i==3)
                                                            @php $current_day = 'Wed'@endphp
                                                        @endif
                                                        @if($i==4)
                                                            @php $current_day = 'Thu'@endphp
                                                        @endif
                                                        @if($i==5)
                                                            @php $current_day = 'Fri'@endphp
                                                        @endif
                                                        @if($i==6)
                                                            @php $current_day = 'Sat'@endphp
                                                        @endif
                                                        @if($i==7)
                                                            @php $current_day = 'Sun' @endphp
                                                        @endif

                                                        <label class="switch">

                                                            <input type="checkbox" name="weekday[]" value="{{$current_day}}" @foreach(json_decode($shift->weekdays) as $scripts) @if($current_day == $scripts) checked="checked" @endif @endforeach class="cyclic_weekday" id="togBtn">
                                                            <div class="slider round">
                                                                <span class="on">{{$i}}</span>
                                                                <span class="off">{{$i}}</span>
                                                            </div>
                                                        </label>
                                                    @endfor

                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has('weekday'))
                                            <div class="error">
                                                {{$errors->first('weekday')}}
                                            </div>
                                        @endif
                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <div>
                                                <div class="form-group">
                                                    <label class="">
                                                        <input type="checkbox" {{$shift->indefinite == 1 ?'checked':''}} name=" Indefinite" id="indefinite" >
                                                        @lang('shifts::app.indefinite')
                                                    </label>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-xs-12 {{$shift->indefinite == 1 ?'hide':'show'}}" id="end_date">
                                            <div class="form-group">
                                                <label for="end_on">@lang('shifts::app.endOn') </label>
                                                <div class="input-group date {{$errors->has('end_on') ? 'errorBorder' : ''}}" id="date2" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"  id="end_on_input" name="end_on" value="{{$shift->shift_end_on}}" data-target="#date2"/>
                                                    <div class="input-group-append" data-target="#date2" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                                @if($errors->has('end_on'))
                                                    <div class="error">
                                                        {{ $errors->first('end_on') }}
                                                    </div>
                                                @endif
                                                <div class="error" id="error-for-endOn" style="display: none">

                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="project">@lang('shifts::app.project') </label>
                                                <select name="project" id="project" class="form-control">
                                                    <option value="0">@lang('shifts::app.selectProject')</option>
                                                    @foreach($projects as $project)
                                                        <option value="{{$project->id}}" {{$project->id == $shift->project_id ? 'selected' : ''}}>{{$project->project_name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="task">@lang('shifts::app.task') </label>
                                                <select name="task" id="task" class="form-control">
                                                    <option value="0">@lang('shifts::app.selectProjectTask')</option>
                                                    @if(!empty($tasks))
                                                        @foreach($tasks as $task)
                                                            <option value="{{$task->id}}" {{$task->id == $shift->task_id ? 'selected' : ''}}>{{$task->heading}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="tag">@lang('shifts::app.addATag')</label>
                                                <input type="text" class="form-control" id="tag"
                                                       name="tag"
                                                       value="{{$shift->tag}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <div class="form-group">
                                                <label for="note">@lang('shifts::app.addANote')</label>
                                                <textarea type="text" class="form-control" id="note" name="note">{{$shift->note}}</textarea>
                                            </div>
                                        </div>


                                        <button type="reset"
                                                class="btn btn-danger waves-effect waves-light m-r-10">
                                            <i class="fa fa-check"></i>
                                            @lang('shifts::app.cancel')

                                        </button>
                                        <button type="button" id="save-form"
                                                class="btn btn-success waves-effect waves-light m-r-10">
                                            <i class="fa fa-check"></i>
                                            @lang('shifts::app.save')

                                        </button>


                                    </div>

                                </div>

                                <div class="clearfix"></div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>

    <!-- .row -->

@endsection

@push('footer-script')
    <script src="{{asset('plugins/bower_components/switchery/dist/switchery.min.js')}}"></script>

    <script type="application/javascript" src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>


    <script>
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function (elem) {
            new Switchery($(this)[0], $(this).data());

        });
        $('.unhealty_shit').each(function (elem) {
            new Switchery($(this)[0], $(this).data());

        });
        $('#recurring_type').on('click',function () {
            console.log('as')
            recurringConditions();
        });
        $('#work_range_yes').on('click',function () {
            $('.work_time_range_period').show();
        })

        $('#work_range_no').on('click',function () {
            $('.work_time_range_period').hide();
        })

        /**
         * For Recurring
         */
        $('#save-form').on('click',function () {
            var indefinate = $('#indefinite').prop('checked');
            var end_on = $('#end_on_input').val()
            if (indefinate == false && end_on == "")
            {
                $('#error-for-endOn').html('Please Select one option between indefinate & end on');
                $('#error-for-endOn').css('display','block')

            }else{
                $('#update-shift-form').submit();
            }
        })

        function recurringConditions() {
            $('.weekdayButton').removeAttr('disabled');
            $('.vtabs').find('.cyclic_weekday').prop('disabled','disbled');
            $('#recurring_weekday').removeClass('hide')
            $('#recurring_weekday').show();
            $('#week_day_number').removeClass('show');
            $('#week_day_number').hide();
            $('.cyclic_duration').removeClass('show');
            $('.cyclic_duration').hide();

            $('.time_class').removeClass('hide')
            $('.time_class').show();
            $('#work_time').removeClass('show');
            $('#work_time').hide();
            $('#work_range_time').removeClass('show');
            $('#work_range_time').hide();

        }
        $('#cyclic_type').on('click',function () {

            cyclicConditions();

        });

        /**
         * For Cyclic Type Input
         */
        function cyclicConditions(){
            $('#recurring_weekday').removeClass('show');

            $('#recurring_weekday').hide();
            $('.cyclic_duration').removeClass('hide');
            $('.cyclic_duration').show();
            $('#work_time').hide();
            $('.weekdayButton').prop('disabled','disabled');
            $('.vtabs').find('.cyclic_weekday').removeAttr('disabled');
            week_day_number($('#cyclic_duration').val());
            $('#work_time').removeClass('show');
            $('#work_time').hide();
            $('#work_range_time').removeClass('show');
            $('#work_range_time').hide();


            $('.time_class').removeClass('hide')
            $('.time_class').show();
        }
        $('#free_type').on('click',function () {

            freeTypeConditions();
        });

        function freeTypeConditions()
        {
            $('.weekdayButton').removeAttr('disabled');
            $('.vtabs').find('.cyclic_weekday').prop('disabled','disbled');
            $('#recurring_weekday').removeClass('show');

            $('#recurring_weekday').show();
            $('#week_day_number').hide();
            $('.cyclic_duration').hide();
            $('#work_time').removeClass('hide');
            $('#work_time').show();
            $('.time_class').removeClass('show')
            $('.time_class').hide()
            $('#work_range_time').removeClass('hide');
            $('#work_range_time').show();
        }
        $('#range_yes').on('click',function () {
            $('.range_period').removeClass('hide')
            $('.range_period').show();
        })
        $('#range_no').on('click',function () {
            $('.range_period').hide();
        })
        $('#cyclic_duration').on('input',function () {

            week_day_number($(this).val())
        });
        $('#indefinite').on('click',function () {


            if ($(this).context.checked)
            {
                $('#end_date').removeClass('hide');
                $('#end_date').hide();
            }else{
                $('#end_date').removeClass('show');

                $('#end_date').show();

            }
        });
        function week_day_number(val)
        {

            var value =val;
            if (val)
            {
                if (value >= 1 && value <= 7)
                {
                    var week_day_number = $('#week_day_switch');

                    var day = '';
                    var currentDay='';
                    for (var i = 1;i<=value;i++)
                    {
                        if (i==1)
                        {
                            currentDay ='Mon'
                        }
                        if (i==2)
                        {
                            currentDay ='Tue'
                        }
                        if (i==3)
                        {
                            currentDay ='Wed'
                        }
                        if (i==4)
                        {
                            currentDay ='Thu'
                        }
                        if (i==5)
                        {
                            currentDay ='Fri'
                        }
                        if (i==6)
                        {
                            currentDay ='Sat'
                        }
                        if (i==7)
                        {
                            currentDay ='Sun'
                        }
                        day += '<label class="switch">'+
                            '<input type="checkbox"  name="weekday[]" value="'+currentDay+'"  class="cyclic_weekday" id="togBtn">'+
                            '<div class="slider round">'+
                            '<span class="on">'+i+'</span>'+
                            '<span class="off">'+i+'</span>'+
                            <!--END-->
                            '</div>'+
                            '</label>';
                        currentDay = '';
                    }

                    week_day_number.empty().append(day);

                    $('#week_day_number').removeClass('hide');
                    $('#week_day_number').show();
                }
            }

        }

        $('#project').on('change',function () {
            console.log();
            var url ="{{route('admin.getProjectTask',':id')}}";
            url = url.replace(':id',$(this).val());
            $.ajax ({
                type: "GET",
                url: url,
                success: function(reponse) {
                    var options ='<option value="0">Select Project Task</option>';
                    $.each(reponse.task,function (key,value) {
                        options+='<option value="'+value["id"]+'" >'+value["heading"]+'</option>'

                    });

                    $('#task').empty().append(options)

                }
            });

        })


    </script>
    <script>

        $('#datetimepicker1').datetimepicker({
            format: 'LT',
        });
        $('#datetimepicker2').datetimepicker({
            format: 'LT',

        });
        $('#datetimepicker3').datetimepicker({
            format: 'LT',
        });
        $('#datetimepicker4').datetimepicker({
            format: 'LT',

        });
        $('#datetimepicker4').datetimepicker({
            format: 'LT',
        });
        $('#datetimepicker5').datetimepicker({
            format: 'LT',
        });
        $('#datetimepicker6').datetimepicker({
            format: 'LT',
        });
        $('#datetimepicker7').datetimepicker({
            format: 'LT',
        });
        $('#datetimepicker8').datetimepicker({
            format: 'LT',
        });
        $('#datetimepicker9').datetimepicker({
            format: 'LT',
        });
        $('#datetimepicker0').datetimepicker({
            format: 'LT',
        });
        $('#date1').datetimepicker({
            format: 'L',
        });
        $('#date2').datetimepicker({
            format: 'L',
        });
    </script>

@endpush

