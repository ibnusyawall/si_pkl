<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Absen;
use Validator;
use Str;

class AbsenController extends BaseController
{
    public function get($id)
    {
        $data = Absen::where('id', $id)->first();

        if (empty($data)) {
            return $this->sendErrorJson('id not found.', []);
        }

        return $this->sendResponseJson($data, 'retrive data absen success.');
    }

    public function store(Request $request)
    {
        $required = [
            'siswa_id', 'kehadiran'
        ];

        $request->only($required);

        $tanggal = date('Y-m-d H:i:s');

        $validasi = Validator::make($request->all(), [
            'siswa_id' => 'required|min:9',
            'kehadiran' => 'required|in:hadir,izin,alfa,sakit',
        ]);

        if ($validasi->fails()) {
            return $this->sendErrorJson('error validation', $validasi->errors());
        }

//        if ($request->has($required)) {
            $status = [
                'id' => Str::uuid(),
                'siswa_id' => $request->siswa_id,
                'kehadiran' => $request->kehadiran,
                'tanggal' => empty($request->tanggal) ? date('Y-m-d H:i:s') : $request->tanggal,
            ];

            Absen::create($status);

            return $this->sendResponseJson($status, 'data absen has been saved.');
  //      }
    }

    public function update(Request $request, $id)
    {
        $data = Absen::where('id', $id)->first();
        $check = !empty($data);

        if (!$check) {
            return $this->sendErrorJson('id not found.', []);
        }

        $required = [
            'kehadiran'
        ];

        $request->only($required);

        if ($request->has($required)) {
            $status = [
                'siswa_id' => $data->siswa_id,
                'kehadiran' => empty($request->kehadiran) ? $data->kehadiran : $request->kehadiran,
            ];

            Absen::where('id', $id)->update($status);

            return $this->sendResponseJson($status, 'data absen has been updated.');
        }
    }

    public function delete($id)
    {
        $data = Absen::where('id', $id)->first();
        $check = !empty($data);

        if (!$check) {
            return $this->sendErrorJson('id not found.', []);
        }

        Absen::where('id', $id)->delete();

        $status = [
            'id' => $id,
            'siswa_id' => $data->siswa_id,
        ];

        return $this->sendResponseJson($status, 'data has been deleted.');
    }
}
