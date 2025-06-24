<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Points2Model extends Model
{
    protected $table = 'points';

    protected $guarded = ['id'];

    public function gejson_points()
    {
        $points = $this
            ->select(DB::raw('points.id, st_asgeojson(points.geom) as geom, points.name, points.description, points.jumlah_sawit, points.image, points.telah_dilakukan_monitoring, points.created_at, points.updated_at, points.user_id, users.name as user_created'))
            ->leftJoin('users', 'points.user_id', '=', 'users.id')
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($points as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'telah_dilakukan_monitoring'=>$p->telah_dilakukan_monitoring,
                    'jumlah_sawit'=>$p->jumlah_sawit,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'image' => $p->image,
                    'user_id'=>$p->user_id,
                    'user_created'=>$p->user_created,

                ],

            ];

            array_push($geojson['features'], $feature);
        }

        return $geojson;
    }


    public function gejson_point($id)
    {
        $point = $this
            ->select(DB::raw('id, st_asgeojson(geom) as geom, name, description, telah_dilakukan_monitoring, jumlah_sawit, image, created_at, updated_at'))
            ->where('id', $id)

            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($point as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'telah_dilakukan_monitoring'=>$p->telah_dilakukan_monitoring,
                    'jumlah_sawit'=>$p->jumlah_sawit,
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
