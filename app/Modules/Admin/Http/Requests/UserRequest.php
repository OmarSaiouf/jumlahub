<?php

namespace App\Modules\Admin\Http\Requests;

use App\Modules\Admin\Models\City;
use App\Modules\Admin\Models\Country;
use App\Modules\Admin\Models\Currency;
use App\Modules\Admin\Models\Language;
use App\Modules\Admin\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'phone' => ['required', 'string', 'max:30'],
            'language_id' => ['required', 'integer', Rule::exists(Language::class, 'id')],
            'currency_id' => ['required', 'integer', Rule::exists(Currency::class, 'id')],
            'country_id' => ['required', 'integer', Rule::exists(Country::class, 'id')],
            'city_id' => ['required', 'integer', Rule::exists(City::class, 'id')],
            'address' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'password' => $this->passwordRules(),
        ];
    }
    function passwordRules(): array
    {
        return ['required', 'string', Password::default(), 'confirmed'];
    }
    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
