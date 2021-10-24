<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;

use App\User;
use Validator;
use Illuminate\Support\Facades\Cookie;

class LoginController extends BaseController
{
    public function register(Request $request)
    {
        $check = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($check->fails()){
            return $this->sendErrorJson('validation error', $check->errors());
        }

        try {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $data['status'] = empty($request->status) ? 'unverified' : $request->status;

            DB::table('users')->insert($data);
            //$user = User::create($data);

            return $this->sendResponseJson($data, 'user register successfully.');
        } catch (\Exception $e) {
            return $this->sendErrorJson('Whoops, looks like something went wrong', [], 500);
        }
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $status = [
                'token' => $user->createToken('si_pkl')->accessToken,
                'users' => Auth::user(),
            ];
            cookie('Authorization', $status['token'], 10080, '/dashboard');

            return $this->sendResponseJson($status, 'user login successfully.');
        } else {
            return $this->sendErrorJson('Unauthorized', ['error' => 'Unauthorized users.', 'email' => $request->email]);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return $this->sendResponseJson(['status' => '200', 'message' => 'you have been successfully logout.']);
    }
}
