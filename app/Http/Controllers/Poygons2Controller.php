<?php

namespace App\Http\Controllers;

use App\Models\poygonsModel;
use Illuminate\Http\Request;
use App\Models\Poygons2Model;

class Poygons2Controller extends Controller
{


    public function __construct()
    {
        $this->poygons = new Poygons2Model();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:poygons,name',
                'description' => 'required',
                'geom_polygon' => 'required',
                'image' => 'nullable|mimes:jpeg,png,gif,svg|max:2000',
                'jenis_kesehatan_sawit'=>'required',
                


            ],
            [
                'name.required' => 'Name is required', // Perbaikan sintaks & typo
                'name.unique' => 'Name already exists', // Perbaikan typo
                'description.required' => 'Description is required',
                'geom_polygon' => 'Geometry Polygon is required',

            ]
        );

        // create images dir if not exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // get image file
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polygons." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }


        $data = [
            'geom' => $request->geom_polygon,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
            'user_id'=>auth()->user()->id,


        ];

        // insert data
        if (!$this->poygons->create($data)) {

            return redirect()->route('map')->with('error', 'Polygon failed to added');
        }

        // redirec to map
        return redirect()->route('map')->with('success', 'Polygon has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=[
            'title'=>'Edit poygon',
            'id'=>$id,
        ];
       return view('edit-poygon', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
           $request->validate(
            [
                'name' => 'required|unique:poygons,name,' . $id,
                'description' => 'required',
                'geom_polygon' => 'required',
                'image' => 'nullable|mimes:jpeg,png,gif,svg|max:2000'

            ],
            [
                'name.required' => 'Name is required', // Perbaikan sintaks & typo
                'name.unique' => 'Name already exists', // Perbaikan typo
                'description.required' => 'Description is required',
                'geom_polygon' => 'Geometry Polygon is required',

            ]
        );

        // create images dir if not exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // Get olde image file name
        $old_image = $this->poygons->find($id)->image;

        // get image file
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_poygons." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);

            // delete old image
             if ($old_image != null){
            if (file_exists('./storage/images/' . $old_image)){
                unlink('./storage/images/' . $old_image);
            }
          }


        } else {
            $name_image = $old_image;
        }


        $data = [
            'geom' => $request->geom_polygon,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,


        ];

        // insert data
        if (!$this->poygons->find($id)->update($data)) {

            return redirect()->route('map')->with('error', 'Polygon failed to update');
        }

        // redirec to map
        return redirect()->route('map')->with('success', 'Polygon has been updat');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $imagefile = $this->poygons->find($id)->image;

        if (!$this->poygons->destroy($id)) {
            return redirect()->route('map')->with('error', 'poygons failed to delete');
        }

        // delete iamge
        if ($imagefile != null) {
            if (file_exists('./storage/images/' . $imagefile)) {
                unlink('./storage/images/' . $imagefile);
            }
        }

        return redirect()->route('map')->with('success', 'poygons has been delete');
    }
}
