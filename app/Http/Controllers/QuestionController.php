<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Questions');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestdata = $request->all();
        $question = $requestdata['question'];

        //save question
        $newQuestion = new Question;
        $newQuestion->question = $question;
        $newQuestion->save();

        $newAnswers = $requestdata['answers'];
        foreach ($newAnswers as $answer) {
            $newAnswer = new Answer;
            $newAnswer->answer = $answer['answer'];
            $newAnswer->question_id = $newQuestion->id;
            $newAnswer->correct_answer = $answer['correct_answer'];
            $newAnswer->save();
        }
        return redirect('/questions')->with('success', 'Question and answers created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
