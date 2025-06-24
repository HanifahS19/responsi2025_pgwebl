<?php

namespace App\Http\Controllers;

use App\Models\poygonsModel;
use Illuminate\Http\Request;
use App\Models\Poygons2Model;

class StatistikController extends Controller
{
    public function index()
    {
        $sehat = Poygons2Model::where('jenis_kesehatan_sawit', 'Sehat')->count();
        $sedang = Poygons2Model::where('jenis_kesehatan_sawit', 'Sedang')->count();
        $sakit = Poygons2Model::where('jenis_kesehatan_sawit', 'Sakit')->count();

        return view('statistik-sawit', [
        'title' => 'Statistik Kesehatan Sawit',
        'sehat' => $sehat,
        'sedang' => $sedang,
        'sakit' => $sakit,
    ]);
}

}
