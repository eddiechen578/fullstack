@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                            <form action="{{ route('questions.index') }}" class="form-inline serach-form">
                                <div class="input-group mr-3">
                                    <input type="text" class="form-control" name="search" placeholder="搜尋">
                                </div>

                                <select class="form-control " name="orderby" >
                                    <option value="">排序方式</option>
                                    <option value="created_asc">最先建立時間</option>
                                    <option value="created_desc">最後建立時間</option>
                                </select>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-outline-primary">Search</button>
                                </div>
                            </form>
                    </div>
                </div>
                </form>
                <hr>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2> All Questions</h2>
                            <div class="ml-auto">
                                <a href="{{route('questions.create')}}" class="btn btn-outline-secondary">
                                    Ask Question
                                </a>
                            </div>
                        </div>
                    </div>

                     <div class="card-body">
                       @include('layouts._messages')
                         @forelse($questions as $question)
                            <div class="media">
                                <div class="d-flex flex-column counters">
                                    <div class="vote">
                                        <strong>{{$question->votes_count}}</strong> {{str_plural('vote', $question->votes_count)}}
                                    </div>
                                    <div class="status {{$question->status}}">
                                        <strong>{{$question->answers_count}}</strong> {{str_plural('answer', $question->answers_count)}}
                                    </div>
                                    <div class="view">
                                       {{$question->views ." ". str_plural('view', $question->views)}}
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0">
                                            <a href="{{$question->url}}">{{$question->title}}</a>
                                        </h3>
                                        <div class="ml-auto">
                                            @can('update', $question)
                                            <a href="{{route('questions.edit', $question->id)}}" class="btn btn-sm btn-outline-info">
                                                Edit
                                            </a>
                                            @endcan
                                            @can('delete', $question)
                                            <form class="form-delete" action="{{route('questions.destroy', $question->id)}}" method="post">
                                                {{method_field('DELETE')}}
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure?')"
                                                >Delete</button>
                                            </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <p class="lead">
                                            Asked by
                                        <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                                        <small class="text-muted">{{$question->created_date}}</small>
                                    </p>
                                    <div class="excerpt">
                                        <p>
                                        {{$question->excerpt(350)}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                       @empty
                            <div class="alert alert-warning">
                                <strong>Sorry</strong> There are no answers available.
                            </div>
                       @endforelse
                          @if(!count($questions))
                             <div class="media">
                                 <p>no search found.</p>
                             </div>
                          @endif
                            @include('pagination.pagination_stats', ['paginator' => $questions])
                            {{$questions->appends($filters)->links()}}
                     </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="keyword" value="{{$filters['search']}}">
@endsection
@push('style')
    <style>
        span.highlight{
            color: red;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
@endpush
@push('script')
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>

    <script>

        var key = $('#keyword').val();

        $.fn.wrapInTag = function(opts) {
            console.log(RegExp(opts.words.join('|'), 'gi'))
            var   words = opts.words || []
                , regex = RegExp(words.join('|'), 'gi') // case insensitive
                , replacement = '<span class="highlight">$&</span>';

            return this.html(function() {
                return $(this).text().replace(regex, replacement);
            });
        };

        $('p').wrapInTag({
            words: [key, 'red']
        });
    </script>
@endpush