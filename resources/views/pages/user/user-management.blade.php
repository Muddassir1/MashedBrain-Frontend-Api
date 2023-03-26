@extends('layouts.app')

@push('css')
    <link href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Management'])
    <div id="alert">
        @include('components.alert')
    </div>

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card-header pb-3 row align-items-center">
                <div class="col-md-3 col-6">
                    <h6 class="page-title">Users<span class="data-count text-primary ms-2">( {{count($users)}} )</span></h6>
                </div>
                <div class="col-md-3 col-6">
                    <div class="daterange-container">
                        <i class="fal fa-calendar-alt text-lg"></i>
                        <input type="text" name="users_filter"style="height:45px"
                            class="daterange form-control w-80 text-xs" />
                    </div>
                </div>
                <div class="col-md-6 col-12 text-md-end mt-2 mt-md-0">
                    <a href="#"
                        class="btn btn-primary btn-hover-outline font-weight-bold mb-0 border-primary border export-csv">
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
                                    <th>
                                        Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-0">
                                            <div class="d-flex px-0 py-1">
                                                <div>
                                                    <img src="{{ asset($user->avatar) }}" class="avatar me-3 rounded-circle"
                                                        alt="image">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm font-weight-normal text-darker"><a
                                                            href="{{ route('users.edit', $user->id) }}">{{ $user->name }}</a>
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0 text-darker">{{ $user->email }}</h6>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm mb-0 text-darker">{{ $user->phone }}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-sm text-darker mb-0">{{ $user->get_membership_name() }}</p>
                                        </td>
                                        <td class="align-middle">
                                            <p class="text-sm text-dark mb-0">
                                                <button
                                                    class="btn btn-outline-{{ $user->status ? 'blue' : 'warning' }} me-2 mb-0 px-0 py-1 w-40 text-sm font-weight-normal"
                                                    onclick="document.getElementById('status-{{ $user->id }}').submit()">{{ $user->status ? 'Unban' : 'Ban' }}</button>
                                                <button class="btn btn-outline-red mb-0 text-sm py-1 font-weight-normal"
                                                    onclick="document.getElementById('delete-{{ $user->id }}').submit()">Delete</button>
                                            </p>
                                            <form action="{{ route('users.status', $user->id) }}" method="POST"
                                                id="status-{{ $user->id }}">
                                                @csrf
                                            </form>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                id="delete-{{ $user->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                        <td>{{ date('Y-m-d', strtotime($user->created_at)) }}</td>
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
    <script src="{{ asset('assets/js/plugins/dataTables.dateTime.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>

    <script>
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            locale: {
                format: 'MMM DD'
            },
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format(
                'YYYY-MM-DD'));
        });

        var minDate = '';
        var maxDate = '';

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = minDate;
                var max = maxDate;
                var createdAt = data[5];
                if (
                    (min == "" || max == "") ||
                    (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
                ) {
                    return true;
                }
                return false;
            }
        );

        var table = $('#users-table').DataTable({
            // searching: false,
            info: false,
            ordering: false,
            "lengthChange": false,
            pageLength: 5,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    filename: 'MashedBrain - Users'
                }
            ],
            columnDefs: [{
                target: 5,
                visible: false
            }],
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

        $('input[name="users_filter"]').daterangepicker({
            opens: 'left',
            startDate: moment().startOf('year'),
            endDate: moment().endOf('year'),
            locale: {
                format: 'MMM DD'
            },
            showDropdowns: true,
        }, function(start, end, label) {
            minDate = start;
            maxDate = end;
            table.draw();
        });

        $(".export-csv").click(function() {
            $(".buttons-csv").click();
        })
    </script>
@endpush
