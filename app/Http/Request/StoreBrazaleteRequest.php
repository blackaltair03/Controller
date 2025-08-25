<?php

// app/Http/Requests/StoreBrazaleteRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrazaleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Set to true to allow anyone, or add logic for user roles
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'qr_code' => 'required|string|max:100|unique:brazaletes,qr_code',
            'fecha_in' => 'required|date',
            'fecha_out' => 'required|date|after_or_equal:fecha_in',
            'estatus_id' => 'required|integer|exists:estatuses,id',
            'contador_reingresos' => 'sometimes|integer|min:0',
        ];
    }
}