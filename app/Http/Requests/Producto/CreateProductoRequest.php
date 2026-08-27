<?php

namespace App\Http\Requests\Producto;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductoRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|int|min:0',
            'imagen'       => [
                $this->isMethod('POST') ? 'nullable' : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
            'activo' => 'required'
        ];
    }
}
