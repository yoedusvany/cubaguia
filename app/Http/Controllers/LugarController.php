<?php

namespace App\Http\Controllers;

use App\Imagen;
use App\Lugar;
use Illuminate\Http\Request;
use Image;
use function MongoDB\BSON\toJSON;

class LugarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lugar.list');
    }

    public function list()
    {
        $lugares = Lugar::all();

        foreach ($lugares as $key => $lugar){
            if($lugar->imgs()->first()){
                $lugares[$key]->imagen = asset('images')."/".$lugar->imgs()->first()->nombre;
            }
        }

        return $lugares;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->get('image'))
        {
            $lugar = new Lugar();
            $lugar->nombre = $request->get('nombre');
            $lugar->desc = $request->get('desc');
            $lugar->save();

            $imagenes = $request->get('image');

            foreach ($imagenes as $key => $image){
                $timestamp = new \DateTime();
                $name = $timestamp->getTimestamp().$key.'.' . explode('/', explode(':', substr($image["nombre"], 0, strpos($image["nombre"], ';')))[1])[1];
                Image::make($image["nombre"])
                    ->resize(800, 600)
                    ->save(public_path('images/').$name);

                $img = new Imagen();
                $img->nombre = $name;
                $img->lugar_id = $lugar->id;
                $img->save();
                unset($img);
            }

            return response()->json(['success' => 'You have successfully uploaded an image'], 200);
        }else{
            return response()->json(['error' => 'Some error uploading'], 501);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lugar  $lugar
     * @return \Illuminate\Http\Response
     */
    public function show(Lugar $lugar)
    {
        $images = $lugar->imgs()->get();

        foreach ($images as $key => $item){
            $images[$key]->nombre = asset('images')."/".$images[$key]->nombre;
        }

        $lugar->images = $images;
        return $lugar;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lugar  $lugar
     * @return \Illuminate\Http\Response
     */
    public function edit(Lugar $lugar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lugar  $lugar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lugar $lugar)
    {
        $lugar->update([
            'nombre'=> $request->get("nombre"),
            'desc'=> $request->get("desc")
        ]);

        $imagenes = $request->get('image');

        foreach ($imagenes as $key => $image){
            if(!isset($image['id'])){
                $timestamp = new \DateTime();
                $name = $timestamp->getTimestamp().$key.'.' . explode('/', explode(':', substr($image["nombre"], 0, strpos($image["nombre"], ';')))[1])[1];
                Image::make($image["nombre"])
                    ->resize(800, 600)
                    ->save(public_path('images/').$name);

                $img = new Imagen();
                $img->nombre = $name;
                $img->lugar_id = $lugar->id;
                $img->save();
                unset($img);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lugar  $lugar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lugar $lugar)
    {
        $this->deleteAllimages($lugar->id);
        if($lugar->delete()){
            response()->json(null);
        }else{
            response()->json('Error');
        }

    }

    private function deleteAllimages($id){
        $images = Imagen::where("lugar_id",$id)->get();

        foreach ($images as $image){
            $path = public_path('images')."/".$image->nombre;
            if (file_exists($path)) {
                @unlink($path);
            }
        }
    }

    public function deleteImage($imageId){
        $image = Imagen::where("id",$imageId)->first();

        $path = public_path('images')."/".$image->nombre;
        if (file_exists($path)) {
            @unlink($path);
        }

        if($image->delete()){
            response()->json(null);
        }else{
            response()->json('Error');
        }
    }
}
