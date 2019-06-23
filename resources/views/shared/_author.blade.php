<span class="text-muted">{{$label . " " . $model->created_date}}</span>
<div class="media mt-3">
    <a href="{{$model->user->url}}" class="pr-2">
        <img src="{{$model->user->avatar}}" alt="" width="30" height="30">
    </a>
    <div class="media-body mt-2">
        <a href="{{$model->user->url}}">
            {{$model->user->name}}"
        </a>
    </div>
</div>