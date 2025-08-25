<?php

// app/Http/Requests/UpdateBrazaleteRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrazaleteRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $brazaleteId = $this->route('brazalete')->id;

        return [
            'qr_code' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('brazaletes')->ignore($brazaleteId),
            ],
            'fecha_in' => 'sometimes|required|date',
            'fecha_out' => 'sometimes|required|date|after_or_equal:fecha_in',
            'estatus_id' => 'sometimes|required|integer|exists:estatuses,id',
            'contador_reingresos' => 'sometimes|integer|min:0',
        ];
    }
}