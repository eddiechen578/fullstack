<?php

namespace App\Http\Controllers;

use App\Entities\Question;
use function foo\func;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;
use Illuminate\Support\Facades\DB;
class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = Question::with('user');

        if($search = $request->input('search')){
            $like = "%$search%";
            $builder->where(function ($query) use ($like){
                        $query->where('title', 'like', $like)
                              ->orWhere('body', 'like', $like);
                        })
                        ->get();
        }

        if($orderBy = $request->input('orderby')){
            if(preg_match('/^(.+)_(asc|desc)$/', $orderBy, $m)){
                if(in_array($m[1], ['created'])){
                    $builder->orderBy('created_at', $m[2]);
                }
            }
        }

        $questions = $builder->paginate(10);

        return view('questions.index', compact('questions'))
               ->with('filters', [
                   'search'  => $search,
                   'orderby' => $orderBy
               ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();

        return view('questions.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title', 'body'));

        return redirect()->route('questions.index')
                        ->with('success', "You question has been submitted");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entities\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $this->authorize('update', $question);
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $this->authorize('update', $question);

        $question->update($request->only('title', 'body'));

        if($request->expectsJson()){
            return response()->json([
                "message" => "Your question has been updated.",
                "body_html" => $question->body_html
            ]);
        }

        return redirect('/questions')->with('success', 'Your question has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
       $this->authorize('delete', $question);

       $question->delete();

        if(request()->expectsJson()){
            return response()->json([
                "message" => "Your questions has been delete.",
            ]);
        }

       return redirect('/questions')->with('success', "Your questions has been delete.");
    }
}
