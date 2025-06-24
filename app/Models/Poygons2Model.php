<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Poygons2Model extends Model
{
    protected $table = 'poygons';

    protected $guarded = ['id'];

    public function gejson_poygons()
    {
        $poygons = $this
            ->select(DB::raw('poygons.id, st_asgeojson(poygons.geom) as geom,
            COALESCE(st_area(geom, true), 0) as area_m2,
            COALESCE(st_area(geom, true)/1000000, 0) as area_km2,
            COALESCE(st_area(geom, true)/10000, 0) as area_hektar,
            poygons.name, poygons.description, poygons.image, poygons.jenis_kesehatan_sawit, poygons.warna_pada_visualisasi, poygons.kerapatan, poygons.kepemilikan, poygons.created_at, poygons.updated_at, poygons.user_id, users.name as user_created'))
            ->leftJoin('users', 'poygons.user_id', '=', 'users.id')

            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($poygons as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
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
                ],

            ];

            array_push($geojson['features'], $feature);
        }

        return $geojson;
    }

    public function gejson_poygon($id)
    {
        $poygon = $this
            ->select(DB::raw('id, st_asgeojson(geom) as geom,
            COALESCE(st_area(geom, true), 0) as area_m2,
            COALESCE(st_area(geom, true)/1000000, 0) as area_km2,
            COALESCE(st_area(geom, true)/10000, 0) as area_hektar,
            name, description, image, jenis_kesehatan_sawit, warna_pada_visualisasi, kerapatan, kepemilikan, created_at, updated_at'))
            ->where('id', $id)
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($poygon as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
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

                ],

            ];

            array_push($geojson['features'], $feature);
        }

        return $geojson;
    }
}
