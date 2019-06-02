@extends('layouts.app')

@section('content')
 <div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>Editing answer for question:<storng>{{$question->title}}</storng></h2>
                    </div>
                    <hr>
                    <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <textarea name="body" rows="7" class="form-control {{$errors->has('body')? 'is-invalid': ''}}">{{old('body', $answer->body)}}</textarea>
                            @if($errors->has('body'))
                                <div class="invalid-feeback">
                                    <strong>{{$errors->first('body')}}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-outline-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection
