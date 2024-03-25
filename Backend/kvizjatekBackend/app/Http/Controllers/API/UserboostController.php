<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Userboost;
use App\Models\User;
use App\Models\Booster;

class UserboostController extends Controller
{
    /**
     * Felhasználó által birtokolt boosterek listázása.
     * Itt lekérdezzük a felhasználó által birtokolt összes boostert,
     * beleértve a kapcsolódó booster információkat is.
     */
    public function index(Request $request)
    {
        $userId = $request->userId;
        $userBoosts = Userboost::where('userid', $userId)->with('booster')->get();
        return response()->json($userBoosts);
    }

    /**
     * Új booster hozzáadása a felhasználóhoz.
     * A kérésben érkező adatok validálása után létrehozunk egy új Userboost rekordot.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'userid' => 'required|exists:users,id',
            'boosterid' => 'required|exists:boosters,id',
            'used' => 'boolean',
        ]);

        $userboost = new Userboost($validatedData);
        $userboost->save();

        return response()->json(['message' => 'Booster successfully added to user'], 201);
    }

    /**
     * Egy adott felhasználóhoz rendelt booster adatainak lekérdezése.
     */
    public function show($id)
    {
        $userboost = Userboost::find($id);
        if (!$userboost) {
            return response()->json(['message' => 'Userboost not found'], 404);
        }
        return response()->json($userboost);
    }

    /**
     * Felhasználó boosterének frissítése.
     * Például, a booster 'used' állapotának frissítése.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'used' => 'required|boolean',
        ]);

        $userboost = Userboost::find($id);
        if (!$userboost) {
            return response()->json(['message' => 'Userboost not found'], 404);
        }

        $userboost->update($validatedData);
        return response()->json(['message' => 'Userboost updated successfully']);
    }

    /**
     * Booster eltávolítása a felhasználótól.
     */
    public function destroy($id)
    {
        $userboost = Userboost::find($id);
        if (!$userboost) {
            return response()->json(['message' => 'Userboost not found'], 404);
        }

        $userboost->delete();
        return response()->json(['message' => 'Userboost deleted successfully']);
    }

    /**
     * A felhasználó boostereinek resetelése új játékhoz.
     * Ez a metódus minden booster 'used' mezőjét false-ra állítja,
     * jelezve, hogy újra használhatóak.
     */
    public function resetBoostersForNewGame(Request $request, $userId)
    {
        $userExists = User::find($userId);
        if (!$userExists) {
            return response()->json(['message' => 'User not found'], 404);
        }

        Userboost::where('userid', $userId)->update(['used' => false]);
        return response()->json(['message' => 'Boosters reset successfully for user']);
    }
}
