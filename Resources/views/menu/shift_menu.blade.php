@section('other-section')
    <button class="btn btn-default btn-xs btn-circle btn-outline filter-section-close"><i class="fa fa-chevron-left"></i></button>
    <ul class="nav tabs-vertical">
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.shifts.index') active @endif">
            <a href="{{ route('admin.shifts.index') }}">@lang('shifts::app.shifts')</a>
        </li>

        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.shifts.create') active @endif">
            <a href="{{ route('admin.shifts.create') }}">@lang('shifts::app.createShifts')</a>
        </li>
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.assign-shift.create') active @endif">
            <a href="{{ route('admin.assign-shift.create') }}">@lang('shifts::app.assignShift')</a>
        </li>
        <li class="tab @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.assign-shift.index' || \Illuminate\Support\Facades\Route::currentRouteName() == 'search' ) active @endif ">
            <a href="{{ route('admin.assign-shift.index') }}">@lang('shifts::app.assignedShifts')</a>
        </li>
    </ul>
@endsection
