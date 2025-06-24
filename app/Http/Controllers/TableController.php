<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use App\Models\Points2Model;
use App\Models\poygonsModel;
use Illuminate\Http\Request;
use App\Models\Poygons2Model;
use App\Models\PolylinesModel;
use App\Models\Polylines2Model;

class TableController extends Controller
{
    public function __construct()
    {
        $this->points = new Points2Model();
        $this->polylines = new Polylines2Model();
        $this->poygons = new Poygons2Model();
    }
    public function index()
    {
        $data = [
            'title' => 'Table2',
            'points'=>$this->points->all(),
            'polylines'=>$this->polylines->all(),
            'poygons'=>$this->poygons->all(),


        ];

        return view('table2', $data);
    }
}
