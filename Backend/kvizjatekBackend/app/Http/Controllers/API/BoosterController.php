<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBoosterRequest;
use App\Models\Booster;
use Illuminate\Http\Request;


class BoosterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Booster::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booster = Booster::find($id);
        if(is_null ($booster)){
            return response()->json(['message' => "Booster not found with id: $id"], 404);
        } else {
            return response()->json($booster, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBoosterRequest  $request, string $id)
    {
        $booster = Booster::find($id);
        if(is_null ($booster)){
            return response()->json(['message' => "Booster not found with id: $id"], 404);
        } else {
            $booster->fill($request->all());
            $booster->save();
            return response()->json($booster, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booster = Booster::find($id);
        if(is_null ($booster)){
            return response()->json(['message' => "Booster not found with id: $id"], 404);
        } else {
            $booster->delete();
            return response()->json(['message' => "Booster deleted successfully"], 200);
        }
    }
}
