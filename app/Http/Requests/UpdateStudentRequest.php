<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' =>'required|string|max:255',
            'email' =>'required|string|lowercase|email|max:255|unique:students,email,'.$this->student->id,
            'class_id' =>'required|exists:classes,id',
            'section_id' =>'required|exists:sections,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'class_id.exists' => 'A Classe selecionada não existe.',
            'section_id.exists' => 'A Seção selecionada não existe.',
            'email.unique' => 'Este email já está em uso.',
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'class_id.required' => 'O campo classe é obrigatório.',
            'section_id.required' => 'O campo seção é obrigatório.',
        ];
    }
}
