<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:students',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nome é Obrigatório',
            'email.required' => 'Email é Obrigatório',
            'class_id.required' => 'Classe é Obrigatório',
            'section_id.required' => 'Seção é Obrigatório',
            'class_id.exists' => 'Classe não existe',
            'section_id.exists' => 'Seção não existe',
            'email.unique' => 'Email já existe',
            'email.email' => 'Email inválido',
            'name.max' => 'Nome deve ter no máximo 255 caracteres'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nome do aluno',
            'email' => 'E-mail do aluno',
            'class_id' => 'Classe do aluno',
            'section_id' => 'Seção do aluno',
        ] + parent::attributes();
    }
}
