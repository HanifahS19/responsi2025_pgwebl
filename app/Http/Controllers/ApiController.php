<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use App\Models\Points2Model;
use App\Models\poygonsModel;
use Illuminate\Http\Request;
use App\Models\Poygons2Model;
use App\Models\PolylinesModel;
use App\Models\Polylines2Model;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->points = new Points2Model();
        $this->polylines = new Polylines2Model();
        $this->polygons = new Poygons2Model();
        $this->point = new Points2Model();
        $this->polyline = new Polylines2Model();
        $this->polygon = new Poygons2Model();



    }

    public function points()
    {
        $points = $this->points->gejson_points();

        return response()->json($points);

    }

    public function point($id)
    {
        $point = $this->point->gejson_point($id);

        return response()->json($point);

    }

    public function Polylines()
    {
        $polylines = $this->polylines->gejson_Polylines();
        return response()->json($polylines, 200, [], JSON_NUMERIC_CHECK);
    }

    public function Polyline($id)
    {
        $polyline = $this->polyline->gejson_Polyline($id);
        return response()->json($polyline, 200, [], JSON_NUMERIC_CHECK);
    }


    public function poygons()
    {
        $poygons = $this->polygons->gejson_poygons();

        return response()->json($poygons, 200, [],JSON_NUMERIC_CHECK);

    }

    public function poygon($id)
    {
        $poygon = $this->polygon->gejson_poygon($id);

        return response()->json($poygon, 200, [],JSON_NUMERIC_CHECK);

    }
}
