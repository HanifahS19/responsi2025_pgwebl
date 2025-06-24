<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use App\Models\Points2Model;
use Illuminate\Http\Request;


class points2Controller extends Controller
{
    public function __construct()
    {
        $this->points = new Points2Model();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Map', // objek
        ];

        return view('map', $data);
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
        //untukmeangkap data dari form dan memasukan data ke database melalui model. menambah data baru

        //validate request penting karena menjaga kualitas data yang diinputkan

        $request->validate(
            [
                'name' => 'required|unique:points,name', // sesuai name input
                'description' => 'required',
                'geom_point' => 'required',
                'image' => 'nullable|mimes:jpeg,png,gif,svg|max:2000'

            ],
            [
                'name.required' => 'Name is required', // Perbaikan sintaks & typo
                'name.unique' => 'Name already exists', // Perbaikan typo
                'description.required' => 'Description is required',
                'geom_point' => 'Geometry Point is required',
            ]
        );

        // create images dir if not exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // get image file
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }


        $data = [
            'geom' => $request->geom_point,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
            'user_id'=>auth()->user()->id,
        ];

        // insert data
        if (!$this->points->create($data)) {

            return redirect()->route('map')->with('error', 'Point failed to added');
        }

        // redirec to map
        return redirect()->route('map')->with('success', 'Point has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //menampilkan 1 data tertentu
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=[
            'title'=>'Edit point',
            'id'=> $id,
        ];
       return view('edit-point', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $request->validate(
            [
                'name' => 'required|unique:points,name,' . $id, // sesuai name input
                'description' => 'required',
                'geom_point' => 'required',
                'image' => 'nullable|mimes:jpeg,png,gif,svg|max:2000'

            ],
            [
                'name.required' => 'Name is required', // Perbaikan sintaks & typo
                'name.unique' => 'Name already exists', // Perbaikan typo
                'description.required' => 'Description is required',
                'geom_point' => 'Geometry Point is required',
            ]
        );

        // create images dir if not exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        // Get olde image file name
        $old_image = $this->points->find($id)->image;


        // get image file
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
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
            'geom' => $request->geom_point,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // insert data
        if (!$this->points->find($id)->update($data)) {

            return redirect()->route('map')->with('error', 'Point failed to update');
        }

        // redirec to map
        return redirect()->route('map')->with('success', 'Point has been update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imagefile = $this->points->find($id)->image;

        if (!$this->points->destroy($id)) {
            return redirect()->route('map')->with('error', 'Point failed to delete');
        }

        // delete iamge
        if ($imagefile != null) {
            if (file_exists('./storage/images/' . $imagefile)) {
                unlink('./storage/images/' . $imagefile);
            }
        }

        return redirect()->route('map')->with('success', 'point has been delete');
    }
}
