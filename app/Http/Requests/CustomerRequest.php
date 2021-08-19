<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'first_name' => 'required|string|max:191',
            'last_name' =>'required|string|max:191',
            'password' => 'required|string',
            'role_name' => 'required|string',
            'email' => 'required|email|max:191|unique:users,email',
            'mobile' => 'required',
            'birthday' => 'required',
            'tasks' => 'required',
            'is_notify' => 'required'
        ];
    }
}
