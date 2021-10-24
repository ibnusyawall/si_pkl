<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;

use App\User;
use App\Siswa;
use App\Absen;
use App\Sekolah;

use Validator;

class SiswaController extends BaseController
{
    public $sakit = 'sakit';
    public $hadir = 'hadir';
    public $izin = 'izin';
    public $alfa = 'alfa';


    public function getAll()
    {
        $data = Siswa::all();
        return $this->sendResponseJson($data, 'retrive all data siswa success.');
    }

    public function get($id)
    {
        $data = Siswa::where('nis', $id)->first();
        $user = Siswa::where('nis', $id)->first()->user;
        $status = [
           'data' => $data,
           'user' => $user,
        ];
        return $this->sendResponseJson($status, 'retrive data siswa success.');
    }

    public function kehadiran($id)
    {
        $siswa = Siswa::where('nis', $id)->first();
        $data = Absen::where('siswa_id', $id)->get();

        $status = [
            'nis' => $id,
            'nama' => $siswa->nama_lengkap,
            'asal_sekolah' => $siswa->asal_sekolah,
            'jurusan' => $siswa->jurusan,
            'kehadiran' => [
                'hadir' => $this->countObject($data, 'kehadiran', 'hadir'),
                'sakit' => $this->countObject($data, 'kehadiran', 'sakit'),
                'izin' => $this->countObject($data, 'kehadiran', 'izin'),
                'alfa' => $this->countObject($data, 'kehadiran', 'alfa'),
            ],
            'absensi' => $data,
        ];

        return $this->sendResponseJson($status, 'retrive data kehadiran success.');
    }

    public function store(Request $request)
    {
        $required = ['nis', 'nama_lengkap', 'asal_sekolah', 'jurusan', 'jenis_kelamin', 'sekolah_id'];

        $request->only($required);

        $validate = Validator::make($request->all(), [
            'nis' => 'required|unique:siswas,nis',
            'nama_lengkap' => 'required',
            'jurusan' => 'required',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'sekolah_id' => 'required',
        ]);


        if ($validate->fails()){
            return $this->sendErrorJson('error validation', $validate->errors());
        }

            $last_record = User::orderBy('id', 'desc')->first();

            $user_id = $last_record->id;

            $data = $request->all();
            $data['user_id'] = $user_id;

            Siswa::create($data);
            $status = [
                'nis' => $request->nis,
                'nama_lengkap' => $request->nama_lengkap,
                'jurusan' => $request->jurusan,
                'jenis_kelamin' => $request->jenis_kelamin,
                'sekolah_id' => $request->sekolah_id,
                'user_id' => $user_id,
            ];
            return $this->sendResponseJson($status, 'siswa has been added.');
    }


    public function delete(Request $request, $id)
    {
        if (!$id) return $this->sendErrorJson('id is required.', []);
        $data = Siswa::where('nis', $id)->first();
        $check = !empty($data);

        if (!$check) {
            return $this->sendErrorJson('id not found.', []);
        }

        Siswa::where('nis', $id)->delete();

        $status = [
            'id' => $id,
        ];

        return $this->sendResponseJson($status, 'data has been deleted.');
    }

    public function update(Request $request, $id)
    {
        if (empty($id)) return $this->sendErrorJson('id is required.', []);
        $data = Siswa::where('nis', $id)->first();

        $check = !empty($data);

        if (!$check) {
            return $this->sendErrorJson('id not found.', []);
        }

        $status = [
            'nis' => empty($request->nis) ? $data->nis : $request->nis,
            'nama_lengkap' => empty($request->nama_lengkap) ? $data->nama_lengkap : $request->nama_lengkap,
            'asal_sekolah' => empty($request->asal_sekolah) ? $data->asal_sekolah : $request->asal_sekolah,
            'jurusan' => empty($request->jurusan) ? $data->jurusan : $request->jurusan,
            'jenis_kelamin' => empty($request->jenis_kelamin) ? $data->jenis_kelamin : $request->jenis_kelamin,
            'sekolah_id' => empty($request->sekolah_id) ? $data->sekolah_id : $request->sekolah_id,
        ];

        Siswa::where('nis', $id)->update($status);

        return $this->sendResponseJson($status, 'data has been updated.');
    }

    private function countObject($obj, $key, $val)
    {
        $result = $obj->filter(function($v) use ($val, $key) {
            return $v[$key] == $val;
        });
        return $result;
    }
}
