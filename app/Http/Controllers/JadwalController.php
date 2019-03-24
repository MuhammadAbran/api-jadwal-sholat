<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;
use function GuzzleHttp\json_decode;

class JadwalController extends Controller
{

    public function show()
    {
        $url = "https://api.banghasan.com/sholat/format/json/kota";
        $data = json_decode(file_get_contents($url), true);
        $kota = $data['kota'];

        return view('home2', compact(['kota', 'i']));
    }
}
