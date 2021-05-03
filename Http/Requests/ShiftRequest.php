<?php
namespace Modules\Shifts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        return [
            'shift_name' => 'required',
            'shift_date' => 'required|date_format:m/d/Y',
            'shift_type' => 'required',
            'cyclic_duration' => 'nullable|numeric',
            'start_min_time' => 'nullable|date_format:g:i A',
            'start_time' => 'nullable|date_format:g:i A',
            'start_max_time' => 'nullable|date_format:g:i A',
            'finish_min_time' => 'nullable|date_format:g:i A',
            'finish_time' => 'nullable|date_format:g:i A',
            'finish_max_time' => 'nullable|date_format:g:i A',
            'break_time' => 'nullable | numeric',
            'work_time' => 'nullable|numeric',
            'from' =>   'nullable|date_format:g:i A',
            'to' => 'nullable|date_format:g:i A',
            'work_range_from' =>'nullable|date_format:g:i A',
            'work_range_to' =>'nullable|date_format:g:i A',
            'weekday' =>'required',
            'end_on' => 'nullable|date_format:m/d/Y',

        ];
    }
}
