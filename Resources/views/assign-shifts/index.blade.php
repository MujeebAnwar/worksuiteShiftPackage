@extends('layouts.app')

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
        .swal-modal{
            width:90% !important;
        }
        .swal-button:hover{
            background: rgb(212,103,82) !important;
        }
        .swal-button--deleteThisShift{
            background: #DD6B55;
            color: white;
            border: none;
            box-shadow: none;
            font-size: 17px;
            font-weight: 500;
            -webkit-border-radius: 2px;
            border-radius: 2px;
            padding: 10px 32px;
            margin: 26px 5px 0 5px;
            cursor: pointer;
        }
        .swal-button--deleteShiftEmployee{
            background: #DD6B55;
            color: white;
            border: none;
            box-shadow: none;
            font-size: 17px;
            font-weight: 500;
            -webkit-border-radius: 2px;
            border-radius: 2px;
            padding: 10px 32px;
            margin: 26px 5px 0 5px;
            cursor: pointer;
        }
        .swal-button--deleteAll{
            background: #DD6B55;
            color: white;
            border: none;
            box-shadow: none;
            font-size: 17px;
            font-weight: 500;
            -webkit-border-radius: 2px;
            border-radius: 2px;
            padding: 10px 32px;
            margin: 26px 5px 0 5px;
            cursor: pointer;
        }
        .swal-button--cancel{
            background: #C1C1C1;
            color: white;
            border: none;
            box-shadow: none;
            font-size: 17px;
            font-weight: 500;
            -webkit-border-radius: 2px;
            border-radius: 2px;
            padding: 10px 32px;
            margin: 26px 5px 0 5px;
            cursor: pointer;
        }
        .swal-button--cancel:hover{
            background: #C1C1C1 !important;

        }

    </style>

@endpush

@section('content')

    <div class="row">
        <form action="{{route('admin.search')}}" method="post">
            @csrf
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="employee" value="{{isset($id) ? $id : ''}}" class="form-control" placeholder="@lang('shifts::app.employeeIDCode')">
                </div>

            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="employee_name" value="{{isset($name) ? $name :""}}" class="form-control" placeholder="@lang('shifts::app.employeeName')">
                </div>


            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select name="department" id="" class="form-control">
                        <option value="">@lang('shifts::app.selectDepartment')</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}" {{isset($department_id) ? $department->id==$department_id? 'selected':'' : ''}}>{{$department->team_name}}</option>
                        @endforeach
                    </select>

                </div>

            </div>
            <div class="col-md-3">
                <div class="form-group">

                    <select name="month" id="" class="form-control">
                        <option value="">@lang('shifts::app.selectMonth')</option>
                        <option value="01" {{isset($month) ? "01"==$month?'selected':'' :''}} >January</option>
                        <option value="02" {{isset($month) ? "02"==$month?'selected':'' :''}}>February</option>
                        <option value="03" {{isset($month) ? "03"==$month?'selected':'' :''}} >March</option>
                        <option value="04" {{isset($month) ? "04"==$month?'selected':'' :''}}>April</option>
                        <option value="05" {{isset($month) ? "05"==$month?'selected':'' :''}}>May</option>
                        <option value="06" {{isset($month) ? "06"==$month?'selected':'' :''}}>June</option>
                        <option value="07" {{isset($month) ? "07"==$month?'selected':'' :''}}>July</option>
                        <option value="08" {{isset($month) ? "08"==$month?'selected':'' :''}}>August</option>
                        <option value="09" {{isset($month) ? "08"==$month?'selected':'' :''}}>September</option>
                        <option value="10" {{isset($month) ? "10"==$month?'selected':'' :''}}>October</option>
                        <option value="11" {{isset($month) ? "11"==$month?'selected':'' :''}}>November</option>
                        <option value="12" {{isset($month) ? "12"==$month?'selected':'' :''}}>December</option>

                    </select>
                </div>
            </div>
            <div class="col-md-7">
                <div class="from-group">
                    <button class="btn btn-success waves-effect waves-light m-r-1"><i class="fa fa-search"></i> @lang('shifts::app.search')</button>
                    <button class="btn btn-info waves-effect waves-light m-r-1" name="excel"><i class="fa fa-download"></i> @lang('shifts::app.exportToExcel')</button>

                </div>

            </div>
        </form>

    </div>


                <div class="m-t-10">
                    @include('shifts::menu.shift_menu')

                    <div class="tab-content">
                        <div id="vhome3" class="tab-pane active">
                            @include('shifts::assign-shifts-table.table',[$weekDates,$employees])
                        </div>
                    </div>



                </div>

    <!-- Modal -->

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h1 class="modal-title">@lang('shifts::app.selectShift')</h1>
                </div>
                <form action="{{route('admin.shortcutShiftAssign')}}" method="post">
                    <div class="modal-body">
                    <h1>@lang('shifts::app.selectShift')</h1>
                     @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="shifts" id="" class="form-control">
                                        @foreach($shifts as $shift)
                                            <option value="{{$shift->id}}">{{$shift->name}}</option>
                                        @endforeach

                                    </select>
                                    <input type="hidden" name="dep_id" id="dep_id" value="">
                                    <input type="hidden" name="employee" id="employee" value="">
                                    <input type="hidden" name="date_added" id="date_added" value="">
                                </div>
                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-1"><i class="fa fa-check"></i> Save</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-r-1" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                </div>
                </form>
            </div>

        </div>
    </div>
    <!-- .row -->

@endsection

@push('footer-script')
    <script src="{{asset('plugins/bower_components/switchery/dist/switchery.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
    $('.btn-add-shift').on('click',function () {

        $('#dep_id').val($(this).data('department'));
        $('#employee').val($(this).data('employee'));
        $('#date_added').val($(this).data('date'))
        $('#myModal').modal('show')


    })


    $('.assigned_shift_id').on('click',function(){
        var id = $(this).data('user-id');
        var shift_id = $(this).data('shift-id');
        var employee_id = $(this).data('employee-id');
        swal("@lang('messages.sweetAlertTitle')", "@lang('shifts::app.alertMessage')", "warning", {
            buttons: {
                deleteThisShift:{
                    text : "@lang('shifts::app.deleteSingle')",
                    value :'1',
                },
                deleteShiftEmployee:{
                    text: "@lang('shifts::app.deleteForEmployee')",
                    value:'2',

                },
                deleteAll:{
                    text: "@lang('shifts::app.deleteForAllEmployees')",
                    value:'3'
                },
                cancel: "@lang('messages.confirmNoArchive')",
            },
        }).then((value) => {
            var token = "{{ csrf_token() }}";
            switch (value) {
                case "1":
                    var url = "{{ route('admin.assign-shift.destroy',':id') }}";
                    url = url.replace(':id', id);


                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                window.location = "{{url()->current()}}"
                            }
                        }
                    });
                    break;

                case "2":
                    var url = "{{ route('admin.deleteForSingleEmployee',':id') }}";
                    url = url.replace(':id', id);


                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {

                            '_token': token,
                            'shift_id':shift_id,
                            'employee_id':employee_id,
                            '_method': 'DELETE'
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                window.location = "{{url()->current()}}"
                            }
                        }
                    });

                    break;
                case "3":
                    var url = "{{ route('admin.deleteForAllEmployees',':id') }}";
                    url = url.replace(':id', id);


                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {
                            '_token': token,
                            '_method': 'DELETE',
                            'shift_id' : shift_id
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                window.location = "{{url()->current()}}"
                            }
                        }
                    });

                    break;


                default:

            }
        });
    });


    </script>
    <script>


    </script>

@endpush



