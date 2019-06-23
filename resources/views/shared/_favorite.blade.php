<a title="Click to mark as favorite question (Click again to undo)" class="favorite mr-2 {{Auth::guest()?'off' :($model->is_favorited? 'favorited': '')}}"
   onclick="event.preventDefault(); document.getElementById('favorite-question-{{$model->id}}').submit()"
>
    <i class="fa fa-star fa-2x"></i>
</a>
<form id="favorite-question-{{$model->id}}" action="/{{$firstURLSegment}}/{{$model->id}}/favorites" method="post" style="display: none">
    @csrf
    @if($model->is_favorited)
        @method('DELETE')
    @endif
</form>