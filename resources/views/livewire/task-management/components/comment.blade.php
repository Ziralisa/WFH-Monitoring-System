<div class="col-md-4">
    <button type="button" class="btn btn-block bg-gradient-primary mb-3" data-bs-toggle="modal"
        data-bs-target="#modal-{{ $task->id }}" wire:click='setTaskId({{ $task->id }})'>View Comments</button>

    <div wire:ignore class="modal fade" id="modal-{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $task->id }}"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                {{-- MODAL HEADER --}}
                <div class="modal-header d-flex align-items-center justify-content-start gap-3 p-4">
                    <div class="px-4">
                        <p class="h6 mb-0 text-s">Last updated:</p>
                        <p class="h6 text-uppercase text-secondary text-xs text-center opacity-7">{{ $task->updated_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="card w-100">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="ps-2 w-20 ">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="h6 mb-2 text-s text-center">{{ $task->assignedUser->name ?? 'Unassigned' }}</p>
                                                    <span
                                                        class="badge badge-sm badge-secondary bg-dark">{{ $task->task_status }}</span>
                                                </div>
                                            </td>
                                            <td class="ps-2 w-80">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="h6 mb-2 text-s mx-3">{{ $task->name }}
                                                    </p>
                                                    <span class="text-s text-secondary mx-3">{{ $task->task_description }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL BODY --}}
                <div class="modal-body">
                    <p class="h6">Comments</p>
                    {{-- COMMENT CARDS --}}
                    @forelse ($task->comments as $comment)
                        <div class="d-flex align-items-start my-2">
                            <img style="width:35px" class="avatar avatar-sm me-3 mt-3"
                                src="../assets/img/team-{{ rand(1, 6) }}.jpg">
                            {{-- <img  class="avatar avatar-sm me-3"> --}}
                            <div class="card w-100 p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="">{{ $comment->user->name }}</h6>
                                    @if ($comment->user->id == auth()->id())
                                        <div>
                                            <a wire:click="editComment({{ $comment->id }})" class="mx-3 cursor-pointer" data-bs-toggle="modal" data-bs-target="#editCommentModal"><u>Edit</u></a>
                                            <a wire:click="deleteComment({{ $comment->id }})"
                                                class="text-danger cursor-pointer"><u>Delete</u></a>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body p-0">
                                    <p class="fs-6 mt-2">
                                        {{ $comment->content }}
                                    </p>
                                    <small class="h6 text-uppercase text-secondary text-xxs text-center opacity-7">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>NO COMMENTS FOUND</p>
                    @endforelse

                    <form wire:submit.prevent="storeComment">
                        <div class="d-flex m-3 align-items-center">
                            <textarea wire:model.defer="commentContent" id="comment-content" name="comment-content" class="fs-6 form-control me-2"
                                rows="1" placeholder="Add a comment.."></textarea>
                            <button type="submit" class="btn btn-primary btn-sm">Comment</button>
                        </div>
                        @error('commentContent')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @if (session()->has('message'))
                            <div class="text-success mt-2">
                                {{ session('message') }}
                            </div>
                        @endif
                    </form>
                </div>

                {{-- MODAL FOOTER --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-link  ml-auto" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FORM TO EDIT COMMENT -->
<div wire:ignore class="modal fade" id="editCommentModal" tabindex="-1" role="dialog" aria-labelledby="editCommentModal"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            {{-- MODAL HEADER --}}
            <div class="modal-header d-flex align-items-center justify-content-start gap-3 p-4">
                <div class="px-4">
                    <p class="h6 mb-0 text-s">Edit Comment</p>
                </div>
            </div>

            {{-- MODAL BODY --}}
            <div class="modal-body">
                <form wire:submit.prevent="updateComment">
                    <div class="form-group">
                        <label for="commentContent" class="h6">Comment</label>
                        <textarea wire:model.defer="commentContent" id="commentContent" name="commentContent"
                            class="form-control" rows="3" placeholder="Edit your comment..."></textarea>
                    </div>
                    @error('commentContent')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update Comment</button>
                    </div>
                </form>
            </div>

            {{-- MODAL FOOTER --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

