<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SocialNetwork;

class SocialNetworksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SocialNetwork::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sn = new SocialNetwork();
        $sn->url = $request->get('url');
        $sn->tipo = $request->get('tipo');
        return $sn->save() ? response()->json() : response()->json("Error", 401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return SocialNetwork::findOrFail($id);
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
        $sn = SocialNetwork::findOrFail($id);

        if($sn){
            $sn->url = $request->get('url');
            $sn->tipo = $request->get('tipo');
            $sn->save();
            return response()->json();
        }else{
            return response()->json("Error", 401);
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
        return SocialNetwork::destroy($id);
    }
}
