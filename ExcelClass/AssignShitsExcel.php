<?php

namespace Modules\Shifts\ExcelClass;


use App\User;
use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AssignShitsExcel implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $weekDates;
    private $employees;


    public function __construct($weekDates,$employees)
    {

        $this->weekDates = $weekDates;
        $this->employees = $employees;

    }


    public function view():View
    {


        $weekDates = $this->weekDates;
        $employees = $this->employees;

        return view('shifts::assign-shifts-table.excel-table',compact('weekDates','employees'));

    }
}
