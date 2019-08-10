<?php

namespace App\Http\Controllers;

use App\Entities\Answer;
use Illuminate\Http\Request;

class voteAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Answer $answer)
    {


        $vote = (int) request()->vote;

        $votesCount = auth()->user()->voteAnswer($answer, $vote);

        if(request()->expectsJson()){
            return response()->json([
               'message' => 'Thanks for the feedback',
               'votesCount' => $votesCount
            ]);
        }

        return back();
    }
}
