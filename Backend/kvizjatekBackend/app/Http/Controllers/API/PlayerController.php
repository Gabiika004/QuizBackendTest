<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Player::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $player = Player::create([
            'name' => $request->name,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
            'email' => $request->email,
            'credit' => 0,
            'isActive'  => 1

        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $player = Player::find($id);
        if(is_null ($player)){
            return response()->json(['message' => "Player not found with id: $id"], 404);
        } else {
            return response()->json($player, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $player = Player::find($id);
        if(is_null ($player)){
            return response()->json(['message' => "Player not found with id: $id"], 404);
        } else {
            $player->fill($request->all());
            if ($request->has('password')) {
                $player->password = password_hash($request->password, PASSWORD_DEFAULT);
            }
            $player->save();
            return response()->json($player, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $player = Player::find($id);
        $player->delete();
        if(is_null ($player)){
            return response()->json(['message' => "Player not found with id: $id"], 404);
        } else {
            return response()->noContent();
        }
    }
}
