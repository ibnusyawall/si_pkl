<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;

use App\User;

class UserController extends BaseController
{
    public function getAll()
    {
        $data = User::all();
        return $this->sendResponseJson($data, 'retrive all data user success.');
    }

    public function showuser(User $user)
    {
        return response()->json($user, 200);
    }

    public function update(Request $request, $email)
    {
        if (empty($id)) return $this->sendErrorJson('id is required.', []);
        $data = User::where('id', $id)->first();

        $check = !empty($data);

        if (!$check) {
            return $this->sendErrorJson('id not found.', []);
        }

        $status = [
            'name' => empty($request->name) ? $data->name : $request->name,
            'email' => empty($request->email) ? $data->email : $request->email,
            'password' => empty($request->password) ? $data->password : bcrypt($request->password),
            'status' => empty($request->status) ? $data->status : $request->status,
        ];

        $data->update($status);

        return $this->sendResponseJson($status, 'data has been updated.');
    }

    public function delete(Request $request, $id)
    {
        if (!$id) return $this->sendErrorJson('id is required.', []);
        $data = User::where('id', $id)->first();
        $check = !empty($data);

        if (!$check) {
            return $this->sendErrorJson('id not found.', []);
        }

        $data->delete();

        $status = [
            'id' => $id,
        ];

        return $this->sendResponseJson($status, 'data has been deleted.');
    }
}
