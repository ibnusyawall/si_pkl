<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;

use App\Penilaian;
use Validator;
use Str;

class PenilaianController extends BaseController
{
    public function getByNis($nis)
    {
        $data = Penilaian::where('siswa_id', $nis)->get();

        if (empty($data)) {
            return $this->sendErrorJson('nis not found.', ['type' => gettype($data), 'empty' => empty($data), 'data' => $data]);
        }

        return $this->sendResponseJson(['type' => gettype($data), 'empty' => $this->emptyObj($data), 'data' => $data], 'retrive data nilai success.');
    }

    private function emptyObj( $obj ) {
        foreach ( $obj AS $prop ) {
            return FALSE;
        }

        return TRUE;
    }
}
