<?php

namespace Modules\Shifts\Library;

use Illuminate\Support\Facades\Auth;

class Shift
{

    public static function returnMenu()
    {
        $route = route('admin.shifts.index');
        echo '<li><a href="'.$route.'" class="waves-effect"><i class="fa fa-calendar"></i> <span class="hide-menu">  Shift & Schedule</span></a> </li>';
    }

    public static function employeeMenu()
    {
        $route = route('member.employeeShiftAssigned');
        echo '<li><a href="'.$route.'" class="waves-effect"><i class="fa fa-calendar"></i> <span class="hide-menu">  Shifts Assigned </span></a> </li>';

    }
}