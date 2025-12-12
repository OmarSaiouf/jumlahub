<?php

namespace App\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetMyOrdersRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "limit" => [
                "nullable",
                "integer",
                "min:1",
                "max:100"
            ],
            "offset" => [
                "nullable",
                "integer",
                "min:0",
            ]
        ];
    }
}
