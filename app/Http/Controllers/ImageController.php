<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Image;
use DataTables;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $images = Image::get();
        if ($request->ajax())
        {
            return DataTables::of($images)
                ->addIndexColumn()
                ->addColumn('actions', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . 
                    $row->id . '" data-original-title="Edit" class="edit editImage btn btn-info btn-sm"><i class="bi bi-pencil-square"></i></a>';
                    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . 
                    $row->id . '" data-original-title="Edit" class="delete deleteImage btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('images.index', compact('images'));
    }

    public function randomize()
    {
        $image = Image::inRandomOrder()->first();
        
        return response()->json($image);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreimageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Image::updateOrCreate(['id' => $request->imageid],
            ['provider' => $request->provider,
            'url' => $request->url,
        ]);

        return response()->json(['success' => 'Image added successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $image = Image::inRandomOrder()->first();
        
        return response()->json($image);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $image = Image::find($id);
        return response()->json($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateimageRequest  $request
     * @param  \App\Models\image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateimageRequest $request, image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Image::find($id)->delete();
        return response()->json(['success' => 'Image deleted successfully!']);
    }
}
