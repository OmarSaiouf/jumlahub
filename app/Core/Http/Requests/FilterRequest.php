<?php

namespace App\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            "sort" => ["nullable", "in:" . implode(',', \App\Core\Enums\FilterSort::values())],
            "status" => ["nullable", "in:" . implode(',', \App\Core\Enums\FilterStatus::values())],
            "q" => ["nullable", "string"],
        ];
    }
}
