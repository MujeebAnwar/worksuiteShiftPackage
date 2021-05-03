<?php

namespace Modules\Shifts\Entities;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{


    protected $guarded = [
        'id',
    ];

    protected $fillable = [

        'company_id',
        'name',
        'shift_date',
        'type',
        'cyclic_duration',
        'start_min_time',
        'start_time',
        'start_max_time',
        'finish_min_time',
        'finish_time',
        'finish_max_time',
        'break_time',
        'free_work_time',
        'free_work_time_range',
        'free_work_time_from',
        'free_work_time_to',
        'range',
        'range_from',
        'range_to',
        'unhealty_shift',
        'weekdays',
        'indefinite',
        'shift_end_on',
        'project_id',
        'task_id',
        'tag',
        'note',
        'publish',

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
}
