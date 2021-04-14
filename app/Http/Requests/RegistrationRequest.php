<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'name' => 'required|string|min:2',
            'surname' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[~!@#$%^&*()_+|}{:"?><,.\';=\-\\[\]`]).*$/'
                ],
            'user_type' => 'required|array',
            'user_type.*' => [
                'distinct',
                'regex:/\b(worker|lecturer)\b/'
            ],
            'phone_number' => 'string|min:7|max:10|required_if:user_type.0,lecturer|required_if:user_type.1,lecturer',
            'education' => 'string|min:5|required_if:user_type.0,lecturer|required_if:user_type.1,lecturer',
            'postal_state' => 'string|required_if:user_type.0,worker|required_if:user_type.1,worker',
            'postal_city' => 'string|required_if:user_type.0,worker|required_if:user_type.1,worker',
            'postal_code' => 'string|required_if:user_type.0,worker|required_if:user_type.1,worker',
            'postal_street' => 'string|required_if:user_type.0,worker|required_if:user_type.1,worker',
            'postal_number' => 'string|required_if:user_type.0,worker|required_if:user_type.1,worker',
            'address_state' => 'string|required_if:user_type.0,worker|required_if:user_type.1,worker',
            'address_city' => 'string|required_if:user_type.0,worker|required_if:user_type.1,worker',
            'address_code' => 'string|required_if:user_type.0,worker|required_if:user_type.1,worker',
            'address_street' => 'string|required_if:user_type.0,worker|required_if:user_type.1,worker',
            'address_number' => 'string|required_if:user_type.0,worker|required_if:user_type.1,worker',
        ];
    }

    public function messages()
    {
        return [
            'user_type.*.regex' => 'Invalid user type',
            'password.regex' => 'Password needs at least:8 characters, 1 uppercase letter, 1 special character and 1 number'
        ];
    }


    protected function prepareForValidation()
    {
        if($this->user_type){
            $this->merge([
                'user_type' => array_map('trim', explode(',', $this->user_type))
            ]);
        }
    }
}
