@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
<div id="alert">
    @include('components.alert')
</div>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-10">
            <div class="card-header p-0 pb-4">
                <h6 class="page-title">Profile</h6>
            </div>
            <div class="card">
                <form class="add-form" role="form" method="POST" action={{ route('users.update',$user->id) }} enctype="multipart/form-data">
                    @csrf
                    @method("patch")
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-control-label">Full Name</label>
                                    <input class="form-control" type="text" name="name" value="{{$user->name}}">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">Email address</label>
                                    <input class="form-control" type="email" name="email" value="{{ $user->email }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Moderation level</label>
                                            <select class="form-control" name="access_level">
                                                <option>Select option</option>
                                                @foreach($levels as $level)
                                                <option value="{{$level->id}}" {{($level->id == $user->access_level) ? 'selected' : ''}}>{{$level->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Category</label>
                                            <select class="form-control" name="category">
                                            <option>Select option</option>
                                                @foreach($categories as $category)
                                                <option value="{{$category->id}}" {{($category->id == $user->category) ? 'selected' : ''}}>{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label">Profile Image</label>
                                    <img src="{{(isset($user) && ($user->avatar != '')) ?  asset($user->avatar): asset('img/profile-img-upload.png')}}" class="w-100 cursor-pointer img-upload-btn" />
                                    <input type="hidden" name="avatar_path" value="{{$user->avatar}}" />
                                    <input type="file" name="avatar" class="d-none" />
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                    </div>
                </form>
            </div>
            <div class="card-header p-0 pb-4 mt-4">
                <h6 class="page-title">Account Security</h6>
            </div>
            <button class="btn btn-primary text-xs btn-custom-padding" data-bs-toggle="modal" data-bs-target="#passwordModal">Change Password</button>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content px-2">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="modal-form" role="form" method="POST" action="{{route('change.perform')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="email" value="{{$user->email}}" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Current Password</label>
                                <input class="form-control" type="password" name="c_password" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">New Password</label>
                                <input class="form-control" type="password" name="password" value="" placeholder="Type here">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Confirm New Password</label>
                                <input class="form-control" type="password" name="confirm_password" value="" placeholder="Type here">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mt-3 w-100 py-3">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{asset('assets/js/jquery-3.6.1.min.js')}}"></script>
<script>
    $(".img-upload-btn").click(() => {
        $("[name=avatar]").click();
    })

    $("[name=avatar]").change(function(e) {
        $(this).parents('form').find($(".img-upload-btn")).attr('src', URL.createObjectURL(this.files[0]));
    })
</script>
@endpush