<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // Validate the form data
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string',
            'questions.question_text' => 'required|string',
            'questions.options.*' => 'required|string',
            'questions.correct_option_id' => 'required|integer',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create a new question instance
        $question = new Question();

        $question->subject = $request->subject;
        $question->question_text = $request->input('questions.question_text');
        $question->options = $request->input('questions.options');
        $question->correct_option_id = $request->input('questions.correct_option_id');

        // dd($question);
        // Save the question to the database
        $question->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Question added successfully.');
    }
}
