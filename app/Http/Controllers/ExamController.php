<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\Answers;
use APP\Models\ExamSession;

class ExamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        
        $user = auth()->user();

        if (!$request->session()->has('exam_start_time')) 
        {
            $request->session()->put('exam_start_time', now());
        }

        $startTime = $request->session()->get('exam_start_time');
        $examDuration = 10 * 60; // 10 minutes in seconds
        $elapsed = now()->diffInSeconds($startTime);
        $remaining = max($examDuration - $elapsed, 0);

        if ($remaining <= 0) 
        {
            return redirect('/exam/submit');
        }



        // If not already set, shuffle questions and store order in session
        if (!$request->session()->has('shuffled_question_ids')) {
            $shuffled = Questions::inRandomOrder()->limit(10)->pluck('id')->toArray();
            $request->session()->put('shuffled_question_ids', $shuffled);
            $request->session()->put('current_question_index', 0);
        }

        // Get current index
        $index = $request->session()->get('current_question_index', 0);
        $questionIds = $request->session()->get('shuffled_question_ids');

        // If index exceeds count, redirect to result
        if ($index >= count($questionIds)) {
            return redirect('/exam/result');
        }

        // Load the current question
        $questionId = $questionIds[$index];
        $question = Questions::findOrFail($questionId);

        // Check if user already answered this question
        $answer = Answers::where('user_id', $user->id)
                        ->where('question_id', $question->id)
                        ->first();

        return view('exam.index', [
            'question' => $question,
            'currentIndex' => $index,
            'userAnswer' => $answer->selected_option ?? null,
            'timeLeft' => $remaining

        ]);
    }


    public function answer(Request $request)
    {
        // dd($request);
        $user = auth()->user();

        // Save or update answer
        Answers::updateOrCreate(
            ['user_id' => $user->id, 'question_id' => $request->question_id],
            ['selected_option' => $request->answer]
        );


        // Save mark for review flag in session
        $marked = $request->has('mark_for_review') && $request->mark_for_review == '1';

        $markedQuestions = session('marked_questions', []);
        if ($marked) {
        $markedQuestions[$request->question_id] = true;
        } else {
        unset($markedQuestions[$request->question_id]);
        }
        session(['marked_questions' => $markedQuestions]);


        $index = session('current_question_index');

        if ($request->action === 'next') {
            session(['current_question_index' => $index + 1]);
        } elseif ($request->action === 'previous') {
            session(['current_question_index' => max($index - 1, 0)]);
        } elseif ($request->action === 'review') {
            return redirect('/exam/review');
        } elseif ($request->action === 'submit') {
            return redirect('/exam/submit');
        }
        elseif ($request->action === 'save') {
            return redirect('/exam');
        }

        return redirect('/exam');
    }


    public function submit(Request $request)
    {
        $user = auth()->user();

        ExamSession::updateOrCreate(
            ['user_id' => $user->id],
            ['end_time' => now(), 'status' => 'completed']
        );

        session()->forget(['shuffled_question_ids', 'current_question_index', 'exam_started']);

        return redirect('/exam/result');
    }


    public function review()
    {
        $user = auth()->user();
        $questionIds = session('shuffled_question_ids', []);
        $answers = Answers::where('user_id', $user->id)
                         ->whereIn('question_id', $questionIds)
                         ->pluck('selected_option', 'question_id');

        $questions = Questions::whereIn('id', $questionIds)->get();

        return view('exam.review', compact('questions', 'answers'));
    }


    public function result()
    {
        $user = auth()->user();
        $questionIds = session('shuffled_question_ids', []);

        $questions = Questions::whereIn('id', $questionIds)->get();
        $answers = Answers::where('user_id', $user->id)
                         ->whereIn('question_id', $questionIds)
                         ->get()
                         ->keyBy('question_id');

        $score = 0;

        foreach ($questions as $question) {
            if (isset($answers[$question->id]) &&
                $answers[$question->id]->selected_option === $question->correct_option) {
                $score++;
            }
        }

        return view('exam.result', ['score' => $score, 'total' => count($questionIds)]);
    }


    public function thankYou()
    {
        return view('thankyou');

    }

}