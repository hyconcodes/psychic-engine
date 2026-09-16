<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'lowercase', Rule::unique(User::class)],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        $referrer = null;

        if (! empty($input['ref'])) {
            $referrer = User::where('username', strtolower($input['ref']))->first();
        }

        $user = User::create([
            'name' => $input['name'],
            'username' => $input['username'],
            'email' => $input['email'],
            'phone' => $input['phone'] ?? null,
            'password' => $input['password'],
            'referred_by' => $referrer?->id,
        ]);

        if ($referrer) {
            Session::flash('toast_message', "Registered successfully! Invited by @{$referrer->username}");
            Session::flash('toast_variant', 'success');
        } else {
            Session::flash('toast_message', 'Registered successfully as a normal user');
            Session::flash('toast_variant', 'success');
        }

        return $user;
    }
}
