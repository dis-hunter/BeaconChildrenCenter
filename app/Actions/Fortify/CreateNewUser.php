<?php

namespace App\Actions\Fortify;

use App\Models\DoctorSpecialization;
use App\Models\Gender;
use App\Models\Role;
use App\Models\User;
use App\Services\RegistrationNumberManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

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
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'numeric'],
            'role' => ['required', 'numeric'],
            'specialization' => ['nullable','numeric'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:staff'],
            'telephone' => ['required','unique:staff'],
            'password' => $this->passwordRules(),
            'password_confirmation' => ['required','same:password'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $reg= new RegistrationNumberManager('staff','staff_no');
        $staff_no = $reg->generateUniqueRegNumber();

        $specialization = null;//default
        if (in_array($input['role'], [2,5]) && isset($input['specialization'])) {
            $specialization = $input['specialization'];
        }

        return User::create([
            'fullname' => [
                'first_name' => $input['firstname'],
                'middle_name' => $input['middlename'],
                'last_name' => $input['lastname'],
            ],
            'gender_id' => $input['gender'],
            'role_id' => $input['role'],
            'specialization_id' => $specialization,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'telephone' => $input['telephone'],
            'staff_no' => $staff_no,
        ]);
    }
}
