<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Asegúrate de permitir la autorización
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:10',
            'direccion' => 'nullable|string',
        ];
    }
}
