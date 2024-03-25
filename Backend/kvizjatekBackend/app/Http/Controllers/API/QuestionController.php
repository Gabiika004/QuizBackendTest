<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
 /**
     * Display a listing of all questions with their answers.
     */
    public function index()
    {
        // A kérdések és a hozzájuk tartozó válaszok lekérdezése
        $questions = Question::with('answers')->get();
        return response()->json($questions);
    }

    /**
     * Display a specific question with its answers.
     */
    public function show($id)
    {
        $question = Question::with('answers')->find($id);
        if (!$question) {
            return response()->json(['message' => "Question not found with id: $id"], 404);
        }
        return response()->json($question);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $question = Question::find($id);
        if(is_null ($question)){
            return response()->json(['message' => "Question not found with id: $id"], 404);
    } else {
        $question->fill($request->all());
        $question->save();
        return response()->json($question, 200);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::find($id);
        if(is_null ($question)){
            return response()->json(['message' => "Question not found with id: $id"], 404);
    } else {
        $question->delete();
        return response()->json(['message' => "Question deleted successfully"], 200);
    }
}
}
