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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-minicolors/2.3.5/jquery.minicolors.min.css ">
    <style>
        .custom_label{
            margin-top: 2%;
        }
        .cyclic_duration{
            margin-top: 11%;
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
        .border-div{
            border: 2px solid #978e8e;
            border-radius: 10px;
            padding: 5px;
        }
        .employee-div{
            background: #fff5f5;
        }
        .time-div{
            background: #cfc7c7;
        }
        .arrow-icon{
            margin-top: 13px;
            font-size: 30px !important;
            transform: scale(2.5,1);
            margin-left: 80px;
        }
        .selected{
            background: grey;
        }
        .modal-header {
            background-color: #ffffff !important;

        }
        .modal-header .close {
            color: #322a2a !important;

        }
    </style>
@endpush

@section('content')

    <div class="row">

        <div class="col-xs-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                   @lang('shifts::app.assignShiftHeading')
                </div>
                <div class="vtabs customvtab m-t-10">
                    @include('shifts::menu.shift_menu')

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            {!! Form::open(['method'=>'POST','class'=>'assign_shift_form','id'=>'assign-shift-form']) !!}
                            <div class="row">
                                <div class="col-sm-6 col-xs-6">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <label for="dep_name">@lang('shifts::app.department') <b class="error">*</b></label>
                                            <div class="form-group {{$errors->has('shift_name') ? 'has-error' : ''}}">
                                                <select name="dep_name" id="dep_name" class="form-control selectpicker2" >
                                                    <option value="" selected>@lang('shifts::app.selectADepartment')</option>


                                                    @foreach($deparments as $dep)
                                                        <option value="{{$dep->id}}">{{$dep->team_name}}</option>
                                                    @endforeach
                                                </select>
                                                    <div class="error" id="dep_name_error" style="display: none;">

                                                    </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <label for="employees">@lang('shifts::app.employees') <b class="error">*</b></label>
                                            <div class="form-group {{$errors->has('shift_name') ? 'has-error' : ''}}">
                                                <select name="employees[]" id="employees" class="form-control Employeeselectpicker2" multiple >

                                                </select>

                                                    <div class="error" id="employee-error" style="display: none;">

                                                    </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <label for="employees">@lang('shifts::app.color')</label>

                                            <div class="form-group">
                                                <input type="hidden" class="form-control" name="color" value="#2A8015" id="color">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-md-12 col-xs-12">
                                            <label for="dep_name">@lang('shifts::app.shift') <b class="error">*</b></label>

                                            <div class="form-group {{$errors->has('shift_name') ? 'has-error' : ''}}">
                                                <select name="shift_name" id="shift_name" class="form-control selectpicker2" >
                                                    <option value="" selected>@lang('shifts::app.selectAShift')</option>
                                                    @foreach($shifts as $shift)
                                                        <option value="{{$shift->id}}">{{$shift->name}}</option>
                                                    @endforeach
                                                </select>

                                                    <div class="error" id="shift_error" style="display: none;">

                                                    </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-md-12 col-xs-12">
                                            <label for="note">@lang('shifts::app.acceptExtraHours')</label>

                                            <div class="form-group">

                                                <div class="switchery-demo">
                                                    <input type="checkbox" id="is_recommended" name="extra_hours" class="js-switch" data-size="small" data-color="#00c292" data-secondary-color="#f96262" style="display: none;" data-switchery="true">

                                                </div>
                                            </div>

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
                                <input type="hidden" value="" name="option-value" id="option-value">
                                <input type="hidden" value="" name="not_assign" id="not_assign">
                                <input type="hidden" value="" name="both" id="both">

                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>



                </div>
            </div>


        </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h1 class="">@lang('shifts::app.modalAssignShift')</h1>
                </div>
                <div class="modal-body">
                        <h5><b>@lang('shifts::app.modalHeading') </b></h5>
                    <h5 id="error"></h5>

                    <div class="row border-div" id="assign_replace_div">
                            <div class="col-md-12">
                                <h4><b>@lang('shifts::app.assignAndReplace')</b></h4>
                                <p>@lang('shifts::app.assignAndReplaceHeading')</p>
                                <div class="col-md-2 employee-div">
                                    <h6 class="employee-name"></h6>
                                    <p class="employee-id"></p>
                                </div>
                                <div class="col-md-2 time-div">
                                    <h6 class="employee-time"></h6>
                                    <p class="shift-name"></p>

                                </div>
                                <div class="col-md-3">
                                    <i class="fa fa-arrow-right arrow-icon"></i>
                                </div>
                                <div class="col-md-2 employee-div">
                                    <h6  class="employee-name"></h6>
                                    <p class="employee-id"></p>
                                </div>
                                <div class="col-md-2 time-div">
                                    <h6 class="new-shift-time"></h6>
                                    <p class="new-shift-name"></p>

                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row border-div" id="not_assign_div">
                            <div class="col-md-12">
                                <h4><b>@lang('shifts::app.dontAssign')</b></h4>
                                <p>@lang('shifts::app.keepAlready')</p>
                                <div class="col-md-2 employee-div">
                                    <h6 class="employee-name"></h6>
                                    <p class="employee-id"></p>
                                </div>
                                <div class="col-md-2 time-div">
                                    <h6 class="employee-time"></h6>
                                    <p class="shift-name"></p>

                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row border-div" id="both_div">
                            <div class="col-md-12">
                                <h4><b>@lang('shifts::app.assignAndKeep')</b></h4>
                                <p>@lang('shifts::app.bothValid')</p>
                                <div class="col-md-2 employee-div">
                                    <h6 class="employee-name"></h6>
                                    <p class="employee-id"></p>
                                </div>
                                <div class="col-md-2 time-div">
                                    <h6 class="employee-time"></h6>
                                    <p class="shift-name"></p>

                                </div>
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-2 employee-div">
                                    <h6  class="employee-name"></h6>
                                    <p class="employee-id"></p>
                                </div>
                                <div class="col-md-2 time-div">
                                    <h6 class="new-shift-time"></h6>
                                    <p class="new-shift-name"></p>

                                </div>
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <input type="checkbox" name="applied" style="float: left" id="apply">
                        <lable style="float: left;padding: 2px">@lang('shifts::app.applyConflict')</lable>
                        <button type="button" class="btn btn-success waves-effect waves-light m-r-1 submit"><i class="fa fa-check"></i> @lang('shifts::app.save')</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-r-1" data-dismiss="modal"><i class="fa fa-close"></i> @lang('shifts::app.close')</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-minicolors/2.3.5/jquery.minicolors.min.js "></script>
    <script>

        var employeeData;
        var matchEmployee;
        var matchedShift;
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function (elem) {
            new Switchery($(this)[0], $(this).data());

        });
        $('.publish').each(function (elem) {
            new Switchery($(this)[0], $(this).data());

        });

        $('.selectpicker2').select2();

        $('.Employeeselectpicker2').select2();

        $('#employees').on('change',function () {
            var value =$(this).val();
            if (value != null || value != "")
            {

                $('#employee-error').empty();

            }
        });
        $('#shift_name').on('change',function () {
            var value =$(this).val();
            if (value != null || value != "")
            {

                $('#shift_error').empty();

            }
        });
        $('.Employeeselectpicker2').on("select2:select", function (e) {
            var data = e.params.data.text;
            if(data=='All'){


                $(".Employeeselectpicker2 > option").prop("selected","selected");
                $(".Employeeselectpicker2").trigger("change");
                $(".Employeeselectpicker2 option[value='All']").val(null)
            }
        });

        $.minicolors.defaults = $.extend($.minicolors.defaults, {
            changeDelay: 200,
            letterCase: 'uppercase',
            theme: 'bootstrap'
        });
        $('#color').minicolors();
        $('#dep_name').on('change',function () {

            var options='';
            var value =$(this).val()
            var url ="{{route('admin.getEmployees',':id')}}";
            url = url.replace(':id',value);
            if (value == null || value == "")
            {

                $('#employees').empty();

            }else{
                $('#dep_name_error').empty();
                $.ajax ({
                    type: "GET",
                    url: url,
                    success: function(response) {
                        $.each(response.employee,function (key,value) {
                            options+='<option value="'+value.id+'">'+value.user["name"]+'</option>'

                        });

                        $('#employees').empty().append(options)

                    }
                });
            }


        });

        $('#assign_replace_div').on('click',function () {
            if($(this).hasClass('selected'))
            {
                $(this).removeClass('selected')
                $('#option-value').val('')
            }else{
                $(this).addClass('selected')
                $('#not_assign_div').removeClass('selected')
                $('#both_div').removeClass('selected')
                $('#option-value').val(1)


            }

        });

        $('#not_assign_div').on('click',function () {

            if($(this).hasClass('selected'))
            {
                $(this).removeClass('selected')
                $('#option-value').val('')
            }else{
                $(this).addClass('selected');
                $('#assign_replace_div').removeClass('selected')
                $('#both_div').removeClass('selected')
                $('#option-value').val(2)

            }

        })
        $('#both_div').on('click',function () {

            if($(this).hasClass('selected'))
            {
                $(this).removeClass('selected');
                $('#option-value').val('')
            }else{
                $(this).addClass('selected');
                $('#assign_replace_div').removeClass('selected')
                $('#not_assign_div').removeClass('selected')
                $('#option-value').val(3)

            }

        });
        $('#save-form').on('click',function () {

            var url = "{{route('admin.assign-shift.store')}}"


            $.ajax ({
                type: "POST",
                dataType: "JSON",
                url: url,
                data : $('#assign-shift-form').serialize(),
                success: function(ajaxresult) {

                    if(ajaxresult.data)
                    {
                        employeeData=ajaxresult.data;
                        matchEmployee = ajaxresult.data[0]
                        matchedShift =ajaxresult.shift
                        var data = ajaxresult.data[0];
                        var shift = ajaxresult.shift;
                        $('.employee-name').empty().html(data.employees.user.name)
                        $('.shift-name').empty().html(data.shift.name)
                        $('.employee-time').empty().html('<b>'+data.shift.start_time+' '+data.shift.finish_time+'</b>')
                        $('.employee-id').empty().html(data.employees.employee_id)
                        $('.new-shift-name').empty().html(shift.name)
                        $('.new-shift-time').empty().html('<b>'+shift.start_time+' '+shift.finish_time+'</b>')
                        $('#myModal').modal('show');
                    }else{


                        window.location = ajaxresult.url
                    }


                },
                error:function (error) {

                    if (error.responseJSON)
                    {
                        if (error.responseJSON.errors.dep_name)
                        {
                            $('#dep_name_error').empty().html(error.responseJSON.errors.dep_name[0])
                            $('#dep_name_error').css('display','block');
                        }else{
                            $('#dep_name_error').empty();
                            $('#dep_name_error').css('display','none');
                        }
                        if (error.responseJSON.errors.employees)
                        {
                            $('#employee-error').empty().html(error.responseJSON.errors.employees[0])
                            $('#employee-error').css('display','block');
                        }else{
                            $('#employee-error').empty()
                            $('#employee-error').css('display','noe');
                        }
                        if (error.responseJSON.errors.shift_name)
                        {
                            $('#shift_error').empty().html(error.responseJSON.errors.shift_name[0])
                            $('#shift_error').css('display','block');

                        }else{
                            $('#shift_error').empty()
                            $('#shift_error').css('display','none');
                        }

                    }



                }
            });

        });
        $('.submit').on('click',function () {

             if ( $('#option-value').val() =="")
            {

                $('#error').html('<b>Please Select one option</b>')
                $('#error').addClass('alert')
                $('#error').addClass('alert-danger')



            }else{
                 var url = "{{route('admin.matachedEmployeeShift')}}"


                 $('#myModal').modal('hide');
                 $.ajax ({
                     type: "POST",
                     dataType: "JSON",
                     url: url,
                     data: {
                         'employee':employeeData,
                         'matachEmployee' :matchEmployee,
                         'shift' :matchedShift,
                         'dep_name':$('#dep_name').val(),
                         'color': $('#color').val(),
                         'shift_id' :$('#shift_name').val(),
                         'extra' :$('#is_recommended').prop("checked") ? 1 : 0,
                         'option':$('#option-value').val(),
                         'apply' :$("#apply").prop("checked") ? 1 : 0,
                         '_token':"{{csrf_token()}}"
                     },
                     success: function (ajaxresult) {


                         if(ajaxresult.data)
                         {
                             employeeData=ajaxresult.data[0];
                             matchEmployee = ajaxresult.data[0][0]
                             matchedShift =ajaxresult.shift
                             var data = ajaxresult.data[0][0];
                             var shift = ajaxresult.shift;
                             $('.employee-name').empty().html(data.employees.user.name)
                             $('.shift-name').empty().html(data.shift.name)
                             $('.employee-time').empty().html('<b>'+data.shift.start_time+' '+data.shift.finish_time+'</b>')
                             $('.employee-id').empty().html(data.employees.employee_id)
                             $('.new-shift-name').empty().html(shift.name)
                             $('.new-shift-time').empty().html('<b>'+shift.start_time+' '+shift.finish_time+'</b>')
                             $('#myModal').modal('show');


                         }else{

                             window.location = ajaxresult.url
                         }

                     }
                 });


             }

        })


    </script>
    <script>


    </script>

@endpush

