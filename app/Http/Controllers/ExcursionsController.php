<?php

namespace App\Http\Controllers;

use App\ExcursionLugar;
use App\Excursions;
use App\Lugar;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Image;

class ExcursionsController extends Controller
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
     * @return Collection
     */
    public function index()
    {
        //
        return view('excursiones.list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $excursiones = Excursions::all();

        foreach ($excursiones as $key => $excursion){
            $excursiones[$key]->img = asset('images')."/".$excursion->img;
        }

        return $excursiones;
    }

    public function lugares($excursionId)
    {
        $excursiones_lugares = ExcursionLugar::where('excursion_id',$excursionId)->get();
        $places = array();
        $imagenes = array();

        foreach ($excursiones_lugares as $excursion_lugar){
            $place = $excursion_lugar->lugar;

            foreach ($place->imgs as $image){
                $imagenes[] = asset('images')."/".$image->nombre;
            }
            $place->imagenes = $imagenes;
            $places[] = $place;
        }

        return response()->json($places);
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
        $image = $request->get('image');
        $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        Image::make($request->get('image'))
            ->resize(800, 600)
            ->save(public_path('images/').$name);

        $excursion = new Excursions();
        $excursion->nombre = $request->get('nombre');
        $excursion->precio = $request->get('precio');
        $excursion->desc = $request->get('desc');
        $excursion->img = $name;
        $excursion->save();

        $lugares = $request->get('listaLugares');

        foreach ($lugares as $lugar){
            $excursionLugar = new ExcursionLugar();
            $excursionLugar->excursion_id = $excursion->id;
            $excursionLugar->lugar_id = $lugar;
            $excursionLugar->save();
        }

        response()->json(null);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Excursions  $excursions
     * @return \Illuminate\Http\Response
     */
    public function show($excursionId)
    {
        $excursion = Excursions::find($excursionId);
        $excursion->img = asset('images')."/".$excursion->img;

        $excursion->lugares;

        return $excursion;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Excursions  $excursions
     * @return \Illuminate\Http\Response
     */
    public function edit(Excursions $excursions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Excursions  $excursions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $excursionID)
    {
        $excursion = Excursions::find($excursionID);

        if($excursion){
            $image = $request->get('image');

            if (filter_var($image, FILTER_VALIDATE_URL) === false) {
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                Image::make($request->get('image'))
                    ->resize(800, 600)
                    ->save(public_path('images/').$name);
            }else{
                $path = parse_url("http://cubaguia.develop/images/1551324862.jpeg")["path"];
                $pathFragments = explode('/', $path);
                $name = end($pathFragments);
            }

            $excursion = Excursions::find($excursionID);
            $excursion->nombre = $request->get('nombre');
            $excursion->precio = $request->get('precio');
            $excursion->desc = $request->get('desc');
            $excursion->img = $name;
            $excursion->save();

            ExcursionLugar::where('excursion_id', $excursionID)->delete();

            $lugares = $request->get('listaLugares');

            foreach ($lugares as $lugar){
                $excursionLugar = new ExcursionLugar();
                $excursionLugar->excursion_id = $excursion->id;
                $excursionLugar->lugar_id = $lugar;
                $excursionLugar->save();
            }

            response()->json(null);
        }else{
            $returnData = array(
                'status' => 'error',
                'message' => 'Excursion ID no encontrada.'
            );
            return response()->json($returnData, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Excursions  $excursions
     * @return \Illuminate\Http\Response
     */
    public function destroy($excursion)
    {
        $item = Excursions::find($excursion);

        if($item->delete()){
            response()->json(null);
        }else{
            $returnData = array(
                'status' => 'error',
                'message' => 'An error occurred!'
            );
            return response()->json($returnData, 500);
        }
    }
}
