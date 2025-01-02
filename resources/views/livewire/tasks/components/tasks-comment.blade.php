@foreach ($task->comments as $comment )
<h5 class="my-3">Comments</h5>
<hr>
<div class="d-flex align-items-start">
    <img style="width:35px" class="me-2 avatar-sm rounded-circle"
        src="{{$comment->user->getImageURL()}}"
        alt="{{$comment->user->name}} Avatar">
    <div class="w-100">
        <div class="d-flex justify-content-between">
            <h6 class="">{{ $comment->user->name }}</h6>
            <small class="fs-6 fw-light text-muted"> {{$comment->created_at->diffForHumans()}}</small>
        </div>
        <p class="fs-6 mt-3 fw-light">
            {{$comment->content}}
        </p>
    </div>
</div>
@endforeach
