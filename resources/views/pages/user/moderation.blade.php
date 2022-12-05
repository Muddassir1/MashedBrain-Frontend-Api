@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
<div id="alert">
    @include('components.alert')
</div>
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card-header pb-3 row align-items-center">
            <div class="col-6">
                <h6 class="page-title">Moderations</h6>
            </div>
            <div class="col-6 text-md-end">
                <a href="#" class="btn btn-primary btn-hover-outline font-weight-normal mb-0 border-primary border" data-bs-toggle="modal" data-bs-target="#moderationModal">
                    <i class="fal fa-plus me-3"></i>Add New
                </a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 users-table">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Access Level</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div>
                                            <img src="{{asset($user->avatar)}}" class="avatar me-3 rounded-circle" alt="image">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm text-dark">{{$user->name}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{$user->email}}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{$user->get_access_level_name()}}</p>
                                </td>
                                <td class="align-middle">
                                    <p class="text-sm text-dark mb-0">
                                        <a href="{{route('users.edit',$user->id)}}" class="btn btn-outline-primary btn-outline-blue text-bold me-2 mb-0">Edit</a>
                                        <button class="btn btn-outline-danger text-bold  mb-0" onclick="document.getElementById('delete-{{$user->id}}').submit()">Delete</button>
                                    </p>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="delete-{{$user->id}}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="moderationModal" tabindex="-1" role="dialog" aria-labelledby="moderationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content px-2">
            <div class="modal-header">
                <h5 class="modal-title" id="moderationModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="modal-form" role="form" method="POST" action={{ route('users.store') }} enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Name</label>
                                <input class="form-control" type="text" name="name" value="">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">Password</label>
                                <div class="row">
                                    <div class="col-8 pe-md-0">
                                        <input class="form-control" name="password" value="" onfocus="focused(this)" onfocusout="defocused(this)">
                                    </div>
                                    <div class="col-4">
                                        <button type="button" class="btn btn-primary font-weight-normal w-100" onclick="generatePassword()">Generate</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Email</label>
                                    <input class="form-control" type="email" name="email" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="access_level" id="general" value="1">
                                    <label class="custom-control-label" for="1">General</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="access_level" id="admin" value="2">
                                    <label class="custom-control-label" for="2">Admin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="access_level" value="3" id="super_admin">
                                    <label class="custom-control-label" for="3">Super Admin</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mt-3 w-100 py-3">Add User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function generatePassword() {
        var length = 15,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            pass = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            pass += charset.charAt(Math.floor(Math.random() * n));
        }
        document.getElementsByName("password")[0].value = pass;
    }
</script>
@endpush