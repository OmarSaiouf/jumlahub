<?php

namespace App\Actions\Fortify;

use App\Core\Enums\UserRole;
use App\Core\Models\City;
use App\Core\Models\Country;
use App\Core\Models\Currency;
use App\Core\Models\Language;
use App\Modules\Users\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
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
        ])->validate();

        $imagePath = null;

        if (isset($input['image']) && $input['image'] instanceof UploadedFile) {
            $imagePath = $input['image']->store('users', 'public');
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'language_id' => $input['language_id'],
            'currency_id' => $input['currency_id'],
            'country_id' => $input['country_id'],
            'city_id' => $input['city_id'],
            'address' => $input['address'] ?? null,
            'role' => UserRole::USER->getValue(),
            'image' => $imagePath,
            'password' => Hash::make($input['password']),
        ]);
    }
}
