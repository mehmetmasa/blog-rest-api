<?php
namespace App\Http\Controllers;
use App\Helpers\ResponseHelper;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function login(Request $request)
    {
        // Validate passed parameters
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        // Get the admin with the email
        // ADMIN SITUATIN CHECK!
        $admin = Admin::where('username', $request['username'])->first();

        // check is user exist
        if (!isset($admin)) {
            return ResponseHelper::response(false,'User does not exist with this details.');
        }

        // confirm that the password matches
        if (!Hash::check($request['password'], $admin['password'])) {
            return ResponseHelper::response(false,'Incorrect user credentials.');
        }

        // Generate Token
        $token = $admin->createToken('AuthToken')->accessToken;

        // Add Generated token to user column
        Admin::where('username', $request['username'])->update(array('api_token' => $token));

        return ResponseHelper::response(
            true,
            'Login successfully.',
            [
                'user' => $admin,
                'api_token' => $token
            ]
        );
    }
}
