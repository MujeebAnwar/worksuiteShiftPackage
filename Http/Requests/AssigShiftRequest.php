<?php

namespace Modules\Shifts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssigShiftRequest extends FormRequest
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
        if (!$this->has('employees'))
        {
            $this->request->add(['employees'=>'']);

        }
        return [
            'dep_name' => 'required',
            'employees' => 'required',
            'shift_name' => 'required'
        ];
    }


    /**
     * Custom Massages apply to the request
     * @return array
     */

    public function messages()
    {

        return [
            'dep_name.required' => 'Please provide a Department.',
            'employees.required' => 'Please provide a Employees.',
            'shift_name.required' => 'Please provide a Shift.',




        ];
    }
}
