<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Sekolah;
//use App\Article;
use App\User;
use Validator;

class SekolahController extends BaseController
{
    public function getAll()
    {
        $data = Sekolah::all();
        return $this->sendResponseJson($data, 'retrive all data success.');
    }
    public function getByNpsn(Request $request)
    {
        $this->checkAuth();

        if (empty($request->npsn)) {
            return $this->sendErrorJson("npsn don't be empty.", []);
        }

        $data = Sekolah::where('id', $request->npsn)->first();
        $message = !empty($data) ? 'retrive data success' : "npsn can't find.";
        return $this->sendResponseJson($data, $message);
    }

    public function getSiswa(Request $request)
    {
//        $data = Sekolah::find('123456789')->get();
        $data = Sekolah::where('id', $request->npsn)->first()->siswas;
        return $this->sendResponseJson($data, 'retrive all data siswa success.');
    }

    public function getUser()
    {
        $data = User::where('id', Auth::user()->id)->first()->siswas;
        $status = [
            'user' => Auth::user(),
            'siswa' => $data,
        ];

        return $this->sendResponseJson($status, 'retrive data success.');
    }

    public function store(Request $request)
    {
        $request->only(['id', 'nama_sekolah']);

        $validasi = Validator::make($request->all(), [
            'id' => 'required|min:8',
            'nama_sekolah' => 'required',
        ]);

        if ($validasi->fails()) {
            return $this->sendErrorJson('validation error', $validasi->errors());
        }

        if ($request->has(['id', 'nama_sekolah'])) {
            Sekolah::create($request->all());
            $status = [
                'npsn' => $request->id,
                'nama_sekolah' => $request->nama_sekolah,
            ];
            return $this->sendResponseJson($status, 'sekolah has been added.');
        }

    }

    public function delete(Request $request, $id)
    {
        if (!$id) return $this->sendErrorJson('id is required.', []);
        $data = Sekolah::where('id', $id)->first();
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

    public function update(Request $request, $id)
    {
        if (empty($id)) return $this->sendErrorJson('id is required.', []);
        $data = Sekolah::where('id', $id)->first();

        $check = !empty($data);

        if (!$check) {
            return $this->sendErrorJson('id not found.', []);
        }

        $status = [
            'id' => empty($request->id) ? $data->id : $request->id,
            'nama_sekolah' => empty($request->nama_sekolah) ? $data->nama_sekolah : $request->nama_sekolah,
        ];

        $data->update($status);

        return $this->sendResponseJson($status, 'data has been updated.');
    }

    public function testing(Request $request, $id)
    {
        $sekolah = Sekolah::where('id', $id)->first();
        $status = [
            'data' => $sekolah,
            'isEmpty' => empty($sekolah),
        ];

        return $this->sendResponseJson($status, 'unit testing get data');
    }

    /*public function artikel()
    {
         $data = Article::where('id', 1)->first()->tags;
         return $this->sendResponseJson($data, 'retrive article success.');
    }*/

    private function checkAuth() {
        if (Auth::guest()) {
            return $this->sendErrorJson('Unauthorized', [], 402);
        }
        return;
    }
    public function showuser(User $user)
    {
        return response()->json($user, 200);
    }
}

