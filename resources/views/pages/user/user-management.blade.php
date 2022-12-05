@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
<div id="alert">
    @include('components.alert')
</div>

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card-header pb-3 row align-items-center">
            <div class="col-4">
                <h6 class="page-title">Users<span class="data-count text-primary ms-2">(3,147)</span></h6>
            </div>
            <div class="col-4">
                <div class="filter-dropdown dropdown">
                    <div class="filter-box dropdown-toggle cursor-pointer" id="filterdropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="./img/icons/misc/filter.png" />
                        Apply Filter
                    </div>
                    <ul class="dropdown-menu" aria-labelledby="filterdropdown">
                        <li><a class="dropdown-item" href="#">Sort by Name</a></li>
                        <li><a class="dropdown-item" href="#">Sort by Author</a></li>
                        <li><a class="dropdown-item" href="#">Sort by Date</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-4 text-md-end">
                <a href="#" class="btn btn-primary btn-hover-outline font-weight-normal mb-0 border-primary border">
                    <i class="fal fa-plus me-3"></i>Export CSV
                </a>
            </div>
        </div>
        <div class="card mb-4 px-4">
            <div class="card-body px-0 pt-3 pb-2">
                <div class="table-responsive p-0">
                    <table id="users-table" class="table align-items-center mb-0 users-table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email
                                </th>
                                <th class="text-center text-secondary">
                                    Phone Number</th>
                                <th>
                                    Membership</th>
                                <th>
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="px-0">
                                    <div class="d-flex px-0 py-1">
                                        <div>
                                            <img src="{{asset($user->avatar)}}" class="avatar me-3 rounded-circle" alt="image">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm text-dark"><a href="{{route('users.edit',$user->id)}}">{{$user->name}}</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{$user->email}}</h6>
                                    </p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{$user->phone}}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{$user->get_membership_name()}}</p>
                                </td>
                                <td class="align-middle">
                                    <p class="text-sm text-dark mb-0">
                                        <button class="btn btn-outline-{{($user->status) ? 'blue' : 'warning'}} text-bold me-2 mb-0 px-0 w-35" onclick="document.getElementById('status-{{$user->id}}').submit()">{{($user->status) ? 'Unban' : 'Ban'}}</button>
                                        <button class="btn btn-outline-danger text-bold  mb-0" onclick="document.getElementById('delete-{{$user->id}}').submit()">Delete</button>
                                    </p>
                                    <form action="{{ route('users.status', $user->id) }}" method="POST" id="status-{{$user->id}}">
                                        @csrf
                                    </form>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="delete-{{$user->id}}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="assets/js/jquery-3.6.1.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/daterangepicker.min.js"></script>

<script>
    $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        locale: {
            format: 'MMM DD'
        },
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });

    $('#users-table').DataTable({
        searching: false,
        info: false,
        ordering: false,
        "lengthChange": false,
        pageLength: 5,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": "<img src='img/icons/misc/arrow-left.png' />",
                "sNext": "<img src='img/icons/misc/arrow-right.png' />",
            }
        },
        "initComplete": function(settings, json) {
            $(".card").after($("#users-table_paginate"));
        }
    });
</script>
@endpush