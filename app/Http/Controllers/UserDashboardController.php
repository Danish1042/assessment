<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        // dd($questions);
        return view('user.index', compact('questions'));
    }

    public function submit_answers(Request $request)
    {
        $answers = $request->input('answers');
        // dd($answers);
        $correctAnswers = 0;
        $totalQuestions = count($answers);

        foreach ($answers as $questionId => $user_answer) {
            $question = Question::find($questionId);
            // dd($question);
            $options = $question->options;
            $correctOptionIndex = $question->correct_option_id;
            $correctOption = $options[$correctOptionIndex];

            if ($user_answer === $correctOption) {
                $correctAnswers++;
            }
        }

        $incorrectAnswers = $totalQuestions - $correctAnswers;
        $percentageCorrect = ($correctAnswers / $totalQuestions) * 100;

        return response()->json([
            'totalQuestions' => $totalQuestions,
            'correctAnswers' => $correctAnswers,
            'incorrectAnswers' => $incorrectAnswers,
            'percentageCorrect' => $percentageCorrect
        ]);
    }
}
