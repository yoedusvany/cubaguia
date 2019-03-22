<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use Image;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slider = Slider::all();

        foreach ($slider as $key => $item){
            $slider[$key]->image = asset('images')."/".$item->image;
        }
        return $slider;
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
            ->save(public_path('images/').$name);


        $slider = new Slider();
        $slider->title = $request->get("title");
        $slider->title_en = $request->get("title_en");
        $slider->desc = $request->get("desc");
        $slider->desc_en = $request->get("desc_en");
        $slider->image = $name;
        $slider->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->image = asset('images')."/".$slider->image;
        return response()->json($slider);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $slider = Slider::findOrFail($id);

        $image = $request->get('image');

        if ($image != null && filter_var($image, FILTER_VALIDATE_URL) === false) {
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($request->get('image'))
                ->save(public_path('images/').$name);
        }else{
            $name = $slider->image;
        }

        $slider->title = $request->get("title");
        $slider->title_en = $request->get("title_en");
        $slider->desc = $request->get("desc");
        $slider->desc_en = $request->get("desc_en");
        $slider->image = $name;
        $slider->save();

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        if($slider){
            $slider->destroy();
            response()->json();
        }else{
            response()->json("Error", 401);
        }
    }
}
