<?php


namespace Modules\Shifts\Entities;


use App\EmployeeDetails;
use App\Scopes\CompanyScope;
use App\User;
use Carbon\Carbon;

class ExtendedUserClass extends EmployeeDetails
{

    protected $table ='employee_details';
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);

        self::creating(function ($model) {
            if (company()) {
                $model->company_id = company()->id;
            }
        });
    }
    public function assignedShifts()
    {
        $dateNow =Carbon::now()->format('Y-m-d');
        $nextWeek = Carbon::now()->addDay('8')->format('Y-m-d');

        return $this->hasMany(AssignShifts::class,'employee_id','id')
            ->where('created_at','>=',$dateNow)
            ->where('created_at','<',$nextWeek)
            ->get();
    }


    public function assignedShiftsData($id,$date)
    {

        return $this->hasMany(AssignShifts::class,'employee_id','id')
            ->where('employee_id',$id)
            ->where('date_added',$date)
            ->get();
    }


}