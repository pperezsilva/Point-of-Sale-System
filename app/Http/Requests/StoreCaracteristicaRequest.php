<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCaracteristicaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
        'nombre' => 'required|max:255|unique:caracteristicas,nombre',
        'descripcion' => 'nullable|max:255',
    ];

    if ($this->has('sigla')) {
        $rules['sigla'] = 'required|max:5';
    }

    return $rules;
    }
}
