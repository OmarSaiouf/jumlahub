<?php

namespace App\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            "product_id" => [
                'required',
                'uuid',
                'exists:products,id',
            ],
            'payment_provider_id' => [
                'required',
                "exists:payment_providers,id"
            ],
            'quantity'=>['required', 'numeric',"min:1"]
            
        ];
    }
}
