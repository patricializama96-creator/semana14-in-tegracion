<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comercio_id' => ['required', 'exists:comercios,id'],
            'cliente_nombre' => ['required', 'string', 'max:255'],
            'monto' => ['required', 'numeric', 'min:0'],
            'estado' => ['required', 'string', 'max:255'],
        ];
    }
}
