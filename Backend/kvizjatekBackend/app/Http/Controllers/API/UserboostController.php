<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Userboost;
use App\Models\User;
use App\Models\Booster;
use Illuminate\Support\Facades\Facade;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UserboostController extends Controller
{
    /**
     * Felhasználó által birtokolt boosterek listázása.
     * Itt lekérdezzük a felhasználó által birtokolt összes boostert,
     * beleértve a kapcsolódó booster információkat is.
     */
    public function index(Request $request)
    {
        // Ellenőrizzük, hogy van-e 'userId' query paraméter a kérésben
        if ($request->has('userId')) {
            $userId = $request->query('userId');
            $userBoosts = Userboost::where('userid', $userId)->with('booster')->get();
            return response()->json($userBoosts);
        }
    
        // Ha nincs megadva 'userId', akkor visszatérünk minden userboosttal
        return response()->json(Userboost::with('booster')->get());
    }

    public function boostersByUserId($userId)
    {
    $userBoosts = Userboost::where('userid', $userId)->with('booster')->get();
    if ($userBoosts->isEmpty()) {
        return response()->json(['message' => 'Nincsenek boosterek ezzel a felhasználói azonosítóval.'], 404);
    }
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
            return response()->json(['message' => 'Userboost not found!'], 404);
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

    public function updateUserBoosterStatus(Request $request)
    {
        $userId = $request->input('userid');
        $boosterId = $request->input('boosterid');
    
        // Logolás hozzáadása a kérés adatainak nyomon követéséhez
        Log::info("updateUserBoosterStatus called with userId: $userId, boosterId: $boosterId");
    
        $userBoost = Userboost::where('userid', $userId)->where('boosterid', $boosterId)->first();
    
        if (!$userBoost) {
            Log::warning("Userboost not found for userId: $userId, boosterId: $boosterId");
            //return response()->json(['message' => "Userboost not found for userId: $userId, boosterId: $boosterId"], 404);
        }
    
        $userBoost->used = true;
        $userBoost->save();
    
        return response()->json(['message' => 'Userboost updated successfully'], 200);
    }
    
}
