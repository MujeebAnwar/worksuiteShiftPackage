<?php

namespace Modules\Shifts\Entities;
use App\EmployeeDetails;
use App\Scopes\CompanyScope;
use App\User;
use Illuminate\Database\Eloquent\Model;

class AssignShifts extends Model
{

    protected $guarded = [
        'id',
    ];

    protected $fillable =[
        'company_id',
        'department_id',
        'color',
        'shift_id',
        'employee_id',
        'extra_hours',
        'publish',
        'date_added',
        'month_added',
        'year_added',
        'created_at'
    ];


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

    public function employees()
    {
        return $this->belongsTo(ExtendedUserClass::class, 'employee_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class,'shift_id','id');
    }
}
