<?php

namespace App\Http\Controllers;

use App\Models\poygonsModel;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function show($id)
    {
        $p = \App\Models\poygonsModel::findOrFail($id);

        $data = [
            'id' => $p->id,
            'name' => $p->name,
            'jenis_kesehatan_sawit' => $p->jenis_kesehatan_sawit,
            'warna_pada_visualisasi' => $p->warna_pada_visualisasi,
            'kerapatan' => $p->kerapatan,
            'kepemilikan' => $p->kepemilikan,
            'description' => $p->description,
            'area_m2' => $p->area_m2,
            'area_ha' => $p->area_ha,
            'area_hektar' => $p->area_hektar,
            'created_at' => $p->created_at,
            'updated_at' => $p->updated_at,
            'image' => $p->image,
            'user_id' => $p->user_id,
            'user_created' => $p->user_created,
        ];

        $title = 'Detail Riwayat Sawit';

        return view('riwayat', compact('data', 'title'));
    }
}
