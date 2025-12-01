<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreStudentRequest extends FormRequest
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
    // protected function failedValidation(Validator $validator)
    // {
    //     // Itt tudod megadni a SAJÁT hibaüzenetedet
    //     $response = response()->json([
    //         'message' => 'Insert error: The given id number already exists, please choose another one',
    //         'errors' => $validator->errors()
    //     ], 409, options: JSON_UNESCAPED_UNICODE);

    //     throw new ValidationException($validator, $response);
    // }
    public function rules(): array
    {

        return [
            
            'igazolvanyszam' => [
                'required',
                'string',
                'max:20',
                'unique:students',              
            ],
        ];
    }
}
