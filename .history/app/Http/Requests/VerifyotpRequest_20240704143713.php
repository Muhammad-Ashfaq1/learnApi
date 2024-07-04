<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyotpRequest extends FormRequest
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
    public function rules(): array
    {
        return [
    'otp' => 'required|numeric|digits:6',
            'phone_number' => 'required|string|regex:/^\+\d{1,3} \(\d{3}\) \d{3}-\d{4}$/',
            'country_code' => 'required|string|size:2',
            'verification_code' => 'required|string|size:6',
            'device_token' => 'required|string',
        ];
    }
}
