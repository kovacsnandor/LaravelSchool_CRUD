<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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
    public function rules(int $studentId): array
    {
               // Feltételezve, hogy az ID-t a route-ból kapod, pl. students/{student}
       $studentId = $this->route('student');  
        return [
                'igazolvanyszam' => [          
                'required',             
                'string',             
                'max:20',           
                Rule::unique('students')->ignore($studentId), 
                ]];
    }
}
