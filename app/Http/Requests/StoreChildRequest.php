<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChildRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email',
            'country_id' => 'required|exists:countries,id',
            'birth_date' => 'required|date',
            // 'age' => 'required|integer|min:0',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'birth_certificate' => 'nullable|file|mimes:jpg,png,pdf',
            'parent_ids'=>'array'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email address.',
            'email.unique' => 'This email is already taken.',
            'country_id.required' => 'Country is required.',
            'country_id.exists' => 'Country not found.',
            'birth_date.required' => 'Birth date is required.',
            'birth_date.date' => 'Invalid date format.',
            'age.required' => 'Age is required.',
            'age.integer' => 'Age must be a number.',
            'state_id.required' => 'State is required.',
            'state_id.exists' => 'State not found.',
            'city_id.required' => 'City is required.',
            'city_id.exists' => 'City not found.',
            'birth_certificate.mimes' => 'Birth certificate must be jpg, png, or pdf.',
            'parent_ids'=> 'Parents should be array'
        ];
    }

}
