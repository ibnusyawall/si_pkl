<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Penilaian as Nilai;
use Validator;
use Str;

class PenilaianController extends BaseController
{
    public function getByNis($nis)
    {
        $data = Nilai::where('siswa_id', $nis)->get();

        if ($this->emptyObj($data)) {
            return $this->sendErrorJson('nis not found.', []);
        }

        return $this->sendResponseJson($data, 'retrive data nilai success.');
    }

    public function getById($id)
    {
        $data = Nilai::where('id', $id)->first();

        if (empty($data)) {
            return $this->sendErrorJson('id not found.', []);
        }

        return $this->sendResponseJson($data, 'retrive data nilai success.');
    }

    public function store(Request $request)
    {
        $required = [
            'siswa_id', 'nilai_sikap', 'nilai_pengetahuan',
        ];

        $request->only($required);

        $validasi = Validator::make($request->all(), [
            'siswa_id' => 'required|min:9',
            'nilai_sikap' => 'required|in:A,B,C,D',
            'nilai_pengetahuan' => 'required|in:A,B,C,D',
        ]);

        if ($validasi->fails()) {
            return $this->sendErrorJson('error validation.', $validasi->errors());
        }


        $status = [
            'id' => Str::uuid(),
            'siswa_id' => $request->siswa_id,
            'nilai_sikap' => $request->nilai_sikap,
            'nilai_pengetahuan' => $request->nilai_pengetahuan,
            'tanggal' => date('Y-m-d H:i:s'),
        ];

        Nilai::create($status);

        return $this->sendResponseJson($status, 'data has been saved.');
    }

    public function update(Request $request, $id)
    {
        $data = Nilai::where('id', $id)->first();
        $check = !empty($data);

        if (!$check) {
            return $this->sendErrorJson('id not found.', []);
        }

        $required = [
            'nilai_sikap', 'nilai_pengetahuan'
        ];

        $request->only($required);

        if ($request->has('nilai_sikap') || $request->has('nilai_pengetahuan')) {
            $status = [
                'siswa_id' => $data->siswa_id,
                'nilai_sikap' => empty($request->nilai_sikap) ? $data->nilai_sikap : $request->nilai_sikap,
                'nilai_pengetahuan' => empty($request->nilai_pengetahuan) ? $data->nilai_pengetahuan : $request->nilai_pengetahuan,
            ];

            Nilai::where('id', $id)->update($status);

            return $this->sendResponseJson($status, 'data nilai has been updated.');
        }
    }

    public function deleteByNis($nis)
    {
        $data = Nilai::where('siswa_id', $nis)->get();

        if ($this->emptyObj($data)) {
            return $this->sendErrorJson('nis not found.', []);
        }

        Nilai::where('siswa_id', $nis)->delete();

        $status = [
            'nis' => $this->objectCount($data),
        ];

        return $this->sendResponseJson($status, 'data has been deleted.');
    }

    public function deleteById($id)
    {
        $data = Nilai::where('id', $id)->first();
        $check = !empty($data);

        if (empty($data)) {
            return $this->sendErrorJson('id not found.', []);
        }

        Nilai::where('id', $id)->delete();

        $status = [
            'id' => $id,
        ];

        return $this->sendResponseJson($status, 'data has been deleted.');
    }

    private function objectCount($obj)
    {
        $result = $obj->filter(function($v) {
            return $v->siswa_id;
        });
        return $result;
    }

    private function emptyObj( $obj ) {
        foreach ( $obj AS $prop ) {
            return FALSE;
        }

        return TRUE;
    }
}
