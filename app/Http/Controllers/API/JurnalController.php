<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Jurnal;
use App\User;

use Validator;

class JurnalController extends BaseController
{
    public function getId($id)
    {
        $data = Jurnal::where('id', $id)->first();
        return $this->sendResponseJson($data, 'retrive data success.');
    }

    public function getNis($nis)
    {
        $data = Jurnal::where('siswa_id', $nis)->get();
        return $this->sendResponseJson($data, 'retrive all data success.');
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'judul' => 'required',
            'capaian_akhir' => 'required',
        ]);

        if ($validasi->fails()){
            return $this->sendErrorJson('validation error', $validasi->errors());
        }

        //if ($request->has(['judul', 'capaian_akhir'])) {
            $siswa = User::where('id', Auth::user()->id)->first()->siswas;
            $status = [
                'siswa_id' => $siswa->nis,
                'judul' => $request->judul,
                'capaian_akhir' => $request->capaian_akhir,
                'tanggal' => empty($request->tanggal) ? date('Y-m-d H:i:s') : $request->tanggal,
            ];

            Jurnal::create($status);

            return $this->sendResponseJson($status, 'jurnal has been added.');
        //}
    }

    public function update(Request $request, $id)
    {
        $data = Jurnal::where('id', $id)->first();
        $required = [
            'judul', 'capaian_akhir'
        ];

        //$request->only($required);

        //if ($request->has($required)){
            $status = [
                'siswa_id' => $data->siswa_id,
                'judul' => empty($request->judul) ? $data->judul : $request->judul,
                'capaian_akhir' => empty($request->capaian_akhir) ? $data->capaian_akhir : $request->capaian_akhir,
                'tanggal' => $data->tanggal,
            ];

            Jurnal::where('id', $id)->update($status);

            return $this->sendResponseJson($status, 'jurnal has been updated.');
        //}

    }
}
