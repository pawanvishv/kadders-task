<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateParentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Get the parent ID from route
        $parentId = $this->route('parent');

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('parents', 'email')->ignore($parentId),
            ],
            'country_id' => 'required|exists:countries,id',
            'birth_date' => 'required|date',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'residential_proof.*' => 'file|mimes:jpg,png,pdf',
            'profile_image' => 'file|image',
            'children' => 'array',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email address.',
            'email.unique' => 'Email already exists.',
            'country_id.required' => 'Country is required.',
            'country_id.exists' => 'Country not found.',
            'birth_date.required' => 'Birth date is required.',
            'birth_date.date' => 'Invalid date format.',
            'state_id.required' => 'State is required.',
            'state_id.exists' => 'State not found.',
            'city_id.required' => 'City is required.',
            'city_id.exists' => 'City not found.',
            'residential_proof.*.mimes' => 'Residential proof must be jpg, png, or pdf.',
            'profile_image.image' => 'Profile image must be an image.',
            'children.array' => 'Children must be an array.',
        ];
    }
}
