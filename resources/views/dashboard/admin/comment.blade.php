@extends('layouts.admin')

@section('content')
@include('includes.alerts')

<div class="row">
    <div class="col-md-10">
        <div class="main-box no-header clearfix">
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <table class="table user-list">
                        <thead>
                            <tr>
                                <th class="text-center"><span>Commented On</span></th>
                                <th><span>Comment</span></th>
                                <th><span>From</span></th>
                                <th><span>Status</span></th>
                                <th><span>Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($comments as $comment)
                            <tr>
                                <td>
                                    <img src="{{url('uploads/blog/'.$comment->blog->image)}}" alt="">
                                    <a href="" class="user-link">{{$comment->blog->title}}</a>
                                </td>
                                <td>
                                    {{$comment->comment}}
                                </td>

                                <td>
                                    {{$comment->user->name}}
                                </td>

                                <td>
                                    <div class="row">
                                        <div class="col-4">
                                            <form method="post" action="{{ route('admin.commentApprove', ['id'=>$comment->id])}}">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="status" value="{{ $comment->status ? '0' : '1' }}">
                                                <button type="submit" class="{{ $comment->status ? 'btn btn-success btn-sm' : 'btn btn-secondary btn-sm' }}">
                                                    {{ $comment->status ? 'Approved' : 'Pending' }}
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col">

                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$comment->id}}">
                                                Decline
                                            </button>

                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="modal fade" id="deleteModal{{$comment->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title text-center" id="exampleModalLabel">Confirm Deletation</h6>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container">

                                                            ...Are you sure you want to delete <strong>{{$comment->comment}} ?</strong>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <a href="{{route('admin.commentDecline' , ['id'=> $comment->id])}}" type="submit" class="btn btn-danger">Decline</a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td style="width: 20%;">

                                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editModal{{$comment->id}}">
                                        <span class="fa-stack text-secondary">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </button>
                                    <div class="modal fade" id="editModal{{$comment->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="text-center" id="exampleModalLabel">Update Comment</h6>
                                                </div>
                                                <form method="POST" action="{{ route('admin.commentUpdate' , ['id'=> $comment->id]) }}" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="row mb-3">
                                                        <label for="comment" class="col-md-4 col-form-label text-md-end">{{ __('Comment') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="comment" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment" value="{{$comment->comment}}" required autocomplete="comment" autofocus placeholder="Enter Comment">

                                                            @error('title')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary"> {{ __('Update') }} </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <h6>No comment Found</h6>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection