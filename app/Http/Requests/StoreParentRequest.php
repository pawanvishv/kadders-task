<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreParentRequest extends FormRequest
{
    // Allow anyone to make this request (adjust as needed)
    public function authorize()
    {
        return true;
    }

    // Validation rules
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email',
            'country_id' => 'required|exists:countries,id',
            'birth_date' => 'required|date',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'residential_proof.*' => 'file|mimes:jpg,png,pdf',
            'profile_image' => 'file|image',
            'children' => 'array'
        ];
    }

    // Custom error messages
    public function messages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already taken.',
            'country_id.required' => 'Country is required.',
            'country_id.exists' => 'Selected country does not exist.',
            'birth_date.required' => 'Birth date is required.',
            'birth_date.date' => 'Please provide a valid date.',
            'state_id.required' => 'State is required.',
            'state_id.exists' => 'Selected state does not exist.',
            'city_id.required' => 'City is required.',
            'city_id.exists' => 'Selected city does not exist.',
            'residential_proof.*.file' => 'Each residential proof must be a file.',
            'residential_proof.*.mimes' => 'Residential proof must be a jpg, png, or pdf file.',
            'profile_image.file' => 'Profile image must be a file.',
            'profile_image.image' => 'Profile image must be an image.',
            'children.array' => 'Children must be an array.',
        ];
    }
}
