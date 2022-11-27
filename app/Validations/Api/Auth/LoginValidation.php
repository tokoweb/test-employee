<?php

namespace App\Validations\Api\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class LoginValidation
{
    /**
     * Index validation.
     *
     * @param  $request
     * @return  ArrayObject
     */
    public function index($request)
    {
        $result = [];
        $result['status'] = false;

        // Check required parameter is exist
        if ($request->email) {
            $request['email'] = Str::lower($request->email);
        }

        $validate = [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ];

        $request->validate($validate);

        $user = User::firstWhere('email', $request->email);

        if (!Hash::check($request->password, $user->password)) {
            $result['message'] = 'Password salah !';
            $result = (object) $result;

            return $result;
        }

        // Validation success
        $result['status'] = true;
        $result['message'] = 'Validation successfully !';

        $result = (object) $result;

        return $result;
    }
}
