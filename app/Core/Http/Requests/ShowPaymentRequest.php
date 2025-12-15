<?php

namespace App\Core\Http\Requests;

use App\Modules\Orders\Facades\OrderFacade;
use Illuminate\Foundation\Http\FormRequest;

class ShowPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return OrderFacade::check($this->order_id, auth('web')->id());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "order_id" => [
                'required',
                'uuid',
                'exists:orders,id'
            ]
        ];
    }
}
