<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicios;
use Image;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Servicios::all();

        foreach ($servicios as $key => $item){
            $servicios[$key]->icon = asset('images')."/".$item->icon;
        }

        return $servicios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = $request->get('image');
        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        Image::make($request->get('image'))
            ->resize(50, 50)
            ->save(public_path('images/').$name);


        $servicio = new Servicios();
        $servicio->name = $request->get('nombre');
        $servicio->desc = $request->get('desc');
        $servicio->icon = $name;
        $servicio->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servicio = Servicios::find($id);
        $servicio->icon = asset('images')."/".$servicio->icon;
        return $servicio;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service = Servicios::findOrFail($id);

        if($service){
            $service->name = $request->get('nombre');
            $service->desc = $request->get('desc');

            if($request->get('image')){
                $this->deleteImage($service->icon);

                $imagen = $request->get('image');
                $timestamp = new \DateTime();
                $name = $timestamp->getTimestamp().'.' . explode('/', explode(':', substr($imagen, 0, strpos($imagen, ';')))[1])[1];
                Image::make($imagen)
                    ->resize(50, 50)
                    ->save(public_path('images/').$name);

                $service->icon = $name;
            }


            $service->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $servicio = Servicios::findOrFail($id);
        if($servicio){
            $this->deleteImage($servicio->icon);
            Servicios::destroy($id);
            return response()->json("Success");
        }else{
            return response()->json("Error",401);
        }
    }

    private function deleteImage($image){
        if (file_exists(public_path('images/').$image)) {
            return @unlink(public_path('images/').$image);
        }

        return false;
    }
}
