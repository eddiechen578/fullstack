@if($model instanceof App\Entities\Question)
    @php
        $name = 'question';
        $firstURLSegment = 'questions';
    @endphp
@elseif($model instanceof App\Entities\Answer)
    @php
        $name = 'answer';
        $firstURLSegment = 'answers';
    @endphp
@endif

@php
    $formId = $name ."-". $model->id;
    $formAction = "/{$firstURLSegment}/{$model->id}/vote";
@endphp
<div class="d-flex flex-column vote-controls">
    <a  title="The {{$name}} is useful" class="vote-up {{Auth::guest()? 'off': ''}}"
        onclick="event.preventDefault(); document.getElementById('up-vote-{{$formId}}').submit()"
    >
        <i class="fa fa-caret-up fa-3x"></i>
    </a>
    <form id="up-vote-{{$formId}}" action="{{$formAction}}" method="post" style="display: none">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>
    <span class="vote-count">{{$model->votes_count}}</span>
    <a title="The {{$name}} is not useful" class="vote-down {{Auth::guest()? 'off': ''}}"
       onclick="event.preventDefault(); document.getElementById('down-vote-{{$formId}}').submit()"
    >
        <i class="fa fa-caret-down fa-3x"></i>
    </a>
    <form id="down-vote-{{$formId}}" action="{{$formAction}}" method="post" style="display: none">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>
    @if($model instanceof App\Entities\Question)
        @include('shared._favorite', [
            'model' => $model
        ])
    @elseif($model instanceof App\Entities\Answer)
        @include('shared._accept', [
           'model' => $model
       ])
    @endif
    <span class="favorites-count">{{$model->favorites_count}}</span>
</div>