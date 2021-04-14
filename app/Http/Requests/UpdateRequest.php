<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'string|min:2',
            'surname' => 'string|min:2',
            'email' => 'email|unique:users,email,'.$this->user,
            'password' => [
                'min:8',
                'confirmed',
                'regex:/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[~!@#$%^&*()_+|}{:"?><,.\';=\-\\[\]`]).*$/'
                ],
            'user_type' => 'array',
            'user_type.*' => [
                'distinct',
                'regex:/\b(worker|lecturer)\b/'
            ],
            'phone_number' => 'string|min:7|max:10',
            'education' => 'string|min:5',
            'postal_state' => 'string',
            'postal_city' => 'string',
            'postal_code' => 'string',
            'postal_street' => 'string',
            'postal_number' => 'string',
            'address_state' => 'string',
            'address_city' => 'string',
            'address_code' => 'string',
            'address_street' => 'string',
            'address_number' => 'string',
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
