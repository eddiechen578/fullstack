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

        auth()->user()->voteAnswer($answer, $vote);

        return back();
    }
}
