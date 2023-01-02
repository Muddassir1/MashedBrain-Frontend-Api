@extends('layouts.app', ['class' => 'g-sidenav-show'])

@push('css')
    <link href="{{ asset('assets/css/daterangepicker.css') }}" rel="stylesheet" />
@endpush

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="heading-top">Total Earnings</p>
                                    <h3 class="font-weight-bolder color-dark-purple">
                                        ৳ {{ number_format($earnings) }}
                                    </h3>
                                    <p class="text-sm font-weight-medium font-roboto color-gray mt-5">
                                        @if ($percent_earnings > 0)
                                            <span class="text-primary">{{ (int) $percent_earnings }}%</span> than last week
                                        @else
                                            <span class="color-red">{{ (int) $percent_earnings }}%</span> than last week
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="card-menu">
                                    <i class="fas fa-ellipsis-v text-dark" aria-hidden="true"></i>
                                </div>
                                <div class="graph-image">
                                    @if ($percent_earnings > 0)
                                        <img src="/img/icons/misc/graph-purple.png" />
                                    @else
                                        <img src="/img/icons/misc/graph-orange.png" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="heading-top">Total Install</p>
                                    <h3 class="font-weight-bolder color-dark-purple">
                                        {{ number_format($downloads) }}
                                    </h3>
                                    <p class="text-sm font-weight-medium font-roboto color-gray mt-5">
                                        @if ($percent_downloads > 0)
                                            <span class="text-primary">{{ (int) $percent_downloads }}%</span> than last week
                                        @else
                                            <span class="color-red">{{ (int) $percent_downloads }}%</span> than last week
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="card-menu">
                                    <i class="fas fa-ellipsis-v text-dark" aria-hidden="true"></i>
                                </div>
                                <div class="graph-image">
                                    @if ($percent_downloads > 0)
                                        <img src="/img/icons/misc/graph-purple.png" />
                                    @else
                                        <img src="/img/icons/misc/graph-orange.png" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="heading-top">Active Subscription</p>
                                    <h3 class="font-weight-bolder color-dark-purple">
                                        {{ number_format($subscriptions) }}
                                    </h3>
                                    <p class="text-sm font-weight-medium font-roboto color-gray mt-5">
                                        @if ($percent_subscriptions > 0)
                                            <span class="text-primary">{{ (int) $percent_subscriptions }}%</span> than last week
                                        @else
                                            <span class="color-red">{{ (int) $percent_subscriptions }}%</span> than last week
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="card-menu">
                                    <i class="fas fa-ellipsis-v text-dark" aria-hidden="true"></i>
                                </div>
                                <div class="graph-image">
                                    @if ($percent_subscriptions > 0)
                                        <img src="/img/icons/misc/graph-purple.png" />
                                    @else
                                        <img src="/img/icons/misc/graph-orange.png" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="heading-top">Download Per Book</p>
                                    <h3 class="font-weight-bolder color-dark-purple">
                                        456
                                    </h3>
                                    <p class="text-sm font-weight-medium font-roboto color-gray mt-5">
                                        <span class="text-red">-13%</span> than last week
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="card-menu">
                                    <i class="fas fa-ellipsis-v text-dark" aria-hidden="true"></i>
                                </div>
                                <div class="graph-image">
                                    <img src="/img/icons/misc/graph-orange.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <div class="row">
                            <div class="col-md-9">
                                <h6 class="text-capitalize">Revenue</h6>
                                <p class="mb-0 text-desc">
                                    A detailed text here about the graph
                                </p>
                            </div>
                            <div class="col-md-3">
                                <div class="daterange-container">
                                    <i class="fal fa-calendar-alt px-1" style="font-size: 19px"></i>
                                    <input type="text" name="daterange" class="daterange form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="bar-chart" class="chart-canvas" height="300px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card users-card mb-4">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <div class="row">
                            <div class="col-md-9">
                                <h6 class="text-capitalize">Recent Users</h6>
                                <p class="mb-0 text-desc">
                                    A detailed text here about the graph
                                </p>
                            </div>
                            <div class="col-md-3">
                                <div class="daterange-container">
                                    <i class="fal fa-calendar-alt" style="font-size: 19px"></i>
                                    <input type="text" name="users_filter" class="daterange form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <table id="users-table" class="table align-items-center mb-0 users-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email
                                    </th>
                                    <th>
                                        Phone Number</th>
                                    <th>
                                        Membership</th>
                                    <th>
                                        Action</th>
                                    <th>
                                        date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recent_users as $user)
                                    <tr>
                                        <td class="px-0">
                                            <div class="d-flex py-1">
                                                <div>
                                                    <img src="{{ asset($user->avatar) }}" class="rounded-circle avatar me-3"
                                                        alt="image">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="mb-0 text-sm"><a class="text-darker"
                                                            href="{{ route('users.edit', $user->id) }}">{{ $user->name }}</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm text-darker mb-0">{{ $user->email }}</p>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <p class="text-sm text-darker mb-0">{{ $user->phone }}</p>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <p class="text-sm text-darker mb-0">{{ $user->get_membership_name() }}
                                            </p>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex">
                                                <p class="text-sm mb-0 color-{{ $user->status ? 'green' : 'blue' }} cursor-pointer"
                                                    onclick="document.getElementById('status-{{ $user->id }}').submit()">
                                                    {{ $user->status ? 'Unban' : 'Ban' }}</p>
                                                <p class="text-sm mb-0 ps-2 color-red cursor-pointer"
                                                    onclick="document.getElementById('delete-{{ $user->id }}').submit()">
                                                    Delete</p>
                                            </div>
                                        </td>
                                        <form action="{{ route('users.status', $user->id) }}" method="POST"
                                            id="status-{{ $user->id }}">
                                            @csrf
                                        </form>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            id="delete-{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <td>{{ date('Y-m-d', strtotime($user->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="d-none">
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.dateTime.min.js') }}"></script>

    <script>
        var nerds = {!! $grouped_nerds->toJson() !!};
        var newbies = {!! $grouped_newbie->toJson() !!};

        var nerdData = getGraphUserData(nerds, 1, 12);
        var newbieData = getGraphUserData(newbies, 1, 12);

        // Graph month filter
        $('input.daterange').daterangepicker({
            opens: 'left',
            startDate: moment().startOf('year'),
            endDate: moment().endOf('year'),
            locale: {
                format: 'MMM'
            },
            showDropdowns: true,
        }, function(start, end, label) {
            startMonth = start.get('month') + 1;
            endMonth = end.get('month') + 1;
            var filtered_nerds = getGraphUserData(nerds, startMonth, endMonth);
            var filtered_newbies = getGraphUserData(newbies, startMonth, endMonth);
            updateChart(filtered_nerds, filtered_newbies);
        });

        var ctx1 = document.getElementById("bar-chart").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');

        var revChart;

        revChart = new Chart(ctx1, {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                        label: "Nerd",
                        pointRadius: 0,
                        backgroundColor: "#806BF6",
                        fill: true,
                        data: nerdData,
                        barThickness: 25,
                        barPercentage: 1.0,
                    },
                    {
                        label: "Newbie",
                        pointRadius: 0,
                        backgroundColor: "#231F38",
                        fill: true,
                        data: newbieData,
                        barThickness: 25,
                        barPercentage: 1.0,
                    }
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        //display: false,
                        align: "end",
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        min: 0,
                        max: 150,
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#B3B5B6',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            callback: function(value, index, ticks) {
                                return value + "K"
                            },
                            stepSize: 25
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 0,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        function updateChart(nerds, newbies) {
            data = revChart.data.datasets;
            console.log(data);
            data[0].data = nerds;
            data[1].data = newbies;
            revChart.data.datasets = data;
            revChart.update();
        }

        function getGraphUserData(data, start, end) {

            var graphData = [];
            var filtered = Object.keys(data).filter(key => (key >= start && key <= end));

            for (var i = 1; i <= 12; i++) {
                if (data[i] && filtered.includes(i.toString()))
                    graphData.push(data[i].length);
                else {
                    graphData.push(0);
                }
            }
            return graphData;
        }

        var minDate = '';
        var maxDate = "";

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
            //searching: false,
            info: false,
            scrollX: true,
            ordering: false,
            "lengthChange": false,
            pageLength: 3,
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
                $(".users-card").after($("#users-table_paginate"));
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
    </script>
@endpush
