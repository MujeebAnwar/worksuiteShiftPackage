@extends('layouts.app')

@section('page-title')
    @include('shifts::menu.shift_menu')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}
                <span class="text-info b-l p-l-10 m-l-5">{{ $shiftsCount }}</span> <span
                        class="font-12 text-muted m-l-5">@lang('shifts::app.totalShifts')</span>
            </h4>
            <p><b>@lang('shifts::app.shiftSchedule')</b></p>
        </div>

        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
            <a href="{{ route('admin.shifts.create') }}" class="btn btn-outline btn-success btn-sm"> @lang('shifts::app.addNewShifts') <i class="fa fa-plus" aria-hidden="true"></i></a>

        </div>
    </div>
@endsection

@push('head-script')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')

    <div class="row">

        <div class="col-xs-12">
            <div class="white-box">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                        <thead>
                        <tr>
                            <th>@lang('shifts::app.shiftId')</th>
                            <th>@lang('shifts::app.name')</th>
                            <th>@lang('shifts::app.startDate')</th>
                            <th>@lang('shifts::app.startTime')</th>
                            <th>@lang('shifts::app.endDate')</th>
                            <th>@lang('shifts::app.endTime')</th>
                            <th>@lang('shifts::app.action')</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

@endsection

@push('footer-script')

    <script src="{{ asset('plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
    <script>
        $(function() {
            var table = $('#users-table').dataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: '{!! route('admin.getShifts') !!}',
                language: {
                    "url": "<?php echo __("app.datatable") ?>"
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'start_time', name: 'start_time' },
                    { data: 'end_date', name: 'end_date' },
                    { data: 'end_time', name: 'end_time' },
                    { data: 'action', name: 'action' }

                    ]
            });


            $('body').on('click', '.sa-params', function(){
                var id = $(this).data('user-id');
                swal({
                    title: "@lang('messages.sweetAlertTitle')",
                    text: "@lang('messages.confirmation.recoverSuperAdmin')",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "@lang('messages.deleteConfirmation')",
                    cancelButtonText: "@lang('messages.confirmNoArchive')",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {

                        console.log(id)
                        var url = "{{ route('admin.shifts.destroy',':id') }}";
                        url = url.replace(':id', id);

                        var token = "{{ csrf_token() }}";

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
                    }
                });
            });



        });

    </script>
@endpush
