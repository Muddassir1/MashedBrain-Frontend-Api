<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}"
    id="" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <h5 class="text-white me-sm-5 my-3 my-lg-0"><span class="color-gray">Welcome,</span> <span
                class="text-primary font-weight-bolder">{{ auth()->user()->name }}</span></h5>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 justify-content-sm-end flex-column flex-sm-row"
            id="navbar">
            <div class="pe-md-3 d-flex align-items-center w-md-50 w-100 mb-3 mb-sm-0">
                <div class="input-group search-bar-top">
                    <span
                        class="input-group-text text-body border-radius-top-start-pill border-radius-bottom-start-pill"><i
                            class="fal fa-search font-weight-bold" aria-hidden="true"></i></span>
                    <input type="text" class="form-control border-radius-top-end-pill border-radius-bottom-end-pill"
                        placeholder="Search Here">
                </div>
            </div>
            <ul class="navbar-nav justify-content-sm-end">
                <li class="nav-item dropdown pe-2 d-flex align-items-center" id="notificationDropdown">
                    <a href="javascript:;" class="nav-link text-white bell-nav p-3 rounded-circle"
                        style="position: relative" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img src="{{ asset('/img/icons/misc/bell.png') }}" />
                        @if (count($notifications) > 0)
                            <div class="notif-available"
                                style="height: 11px;width: 11px;position: absolute;background: #806bf6;top: 1px;right: 3px;border-radius: 13px;"">
                            </div>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        @if (count($notifications) == 0)
                            <li>
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <p class="m-0">No unread notifications</p>
                                </a>
                            </li>
                        @endif
                        @foreach ($notifications as $notification)
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            @if ($notification->type == 'App\Notifications\NewUserRegistration')
                                                <img src="{{ asset('img/defaults/avatar/default.png') }}"
                                                    class="avatar avatar-xs me-3 ">
                                            @elseif ($notification->type == 'App\Notifications\TransactionNotification')
                                                <img src="{{ asset('img/small-logos/money.png') }}"
                                                    class="avatar avatar-xs me-3 ">
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <p class="text-dark text-sm mb-1">
                                                {{ $notification->data['message'] }}
                                            </p>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-clock me-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown ps-3 d-flex align-items-center">
                    <div class="avatar-top me-3" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset(auth()->user()->avatar) }}" class="rounded-circle" width="57" />
                    </div>
                    <div class="user-meta">
                        <p class="name m-0 font-weight-bolder">{{ auth()->user()->name }}</p>
                        <p class="email m-0">{{ auth()->user()->email }}</p>
                    </div>
                    <ul class="dropdown-menu w-100 mt-0 px-3 py-3 me-sm-n4 user-dropdown text-md"
                        aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item border-radius-md"
                                href="{{ route('users.edit', Auth::user()->id) }}">
                                <div class="d-flex py-1">
                                    <div class="my-auto me-3">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <p class="text-dark mb-1">
                                            My Profile
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="{{ route('moderation') }}">
                                <div class="d-flex py-1">
                                    <div class="my-auto me-3">
                                        <i class="far fa-cog"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <p class="text-dark mb-1">
                                            Settings
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto me-3">
                                        <i class="fa fa-sign-out" style="transform: rotate(180deg)"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <p class="text-dark mb-1"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </p>
                                        <form role="form" method="post" action="{{ route('logout') }}"
                                            id="logout-form" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center flex-fill justify-content-end">
                    <a href="javascript:;" class="nav-link p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-gray"></i>
                            <i class="sidenav-toggler-line bg-gray"></i>
                            <i class="sidenav-toggler-line bg-gray"></i>
                        </div>
                    </a>
                </li>
                <!-- <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li> -->
                <!-- <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="./img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New message</span> from Laur
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="./img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New album</span> by Travis Scott
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            1 day
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>credit-card</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(453.000000, 454.000000)">
                                                            <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                                            <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            Payment successfully completed
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->


@push('js')
    <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#notificationDropdown").on('show.bs.dropdown', function() {
                $.ajax({
                    url: "{{ route('read-notifs') }}",
                    success: (data) => {

                    },
                    error: (data) => {
                        console.log(data);
                    }
                })
            });
        })
    </script>
@endpush
