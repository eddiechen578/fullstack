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
