<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'fullname.first_name' => ['required', 'string', 'max:255'],
            'fullname.middle_name' => ['string', 'max:255'],
            'fullname.last_name' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', Rule::unique('staff')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('staff')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
        ])->validateWithBag('updateProfileInformation');


        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'fullname' => [
                    'first_name' => ucwords(strtolower($input['fullname']['first_name'])),
                    'middle_name' => ucwords(strtolower($input['fullname']['middle_name'] ?? '')),
                    'last_name' => ucwords(strtolower($input['fullname']['last_name'])),
                ],
                'telephone' => $input['telephone'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'fullname' => [
                    'first_name' => ucwords(strtolower($input['fullname']['first_name'])),
                    'middle_name' => ucwords(strtolower($input['fullname']['middle_name'] ?? '')),
                    'last_name' => ucwords(strtolower($input['fullname']['last_name'])),
                ],
            'telephone' => $input['telephone'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
