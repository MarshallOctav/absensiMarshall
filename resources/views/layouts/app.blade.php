<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }} - Dashboard</title>

    <!-- Custom fonts -->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    


    <!-- Custom styles -->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        /* CSS untuk mengatur overflow */
        #wrapper {
            display: flex;
            height: 100vh; /* Mengisi tinggi viewport */
        }
        #content-wrapper {
            flex: 1; /* Membuat konten mengambil sisa ruang */
            overflow-y: auto; /* Mengaktifkan scroll pada konten */
        }
        .sidebar {
            width: 250px; /* Atur lebar sidebar */
            overflow-y: auto; /* Mengaktifkan scroll pada sidebar */
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        @auth
            @if(auth()->user()->role !== 'siswa') <!-- Hanya tampilkan sidebar jika bukan siswa -->
                <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                    <!-- Sidebar - Brand -->
                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-laugh-wink"></i>
                        </div>
                        <div class="sidebar-brand-text mx-3">SMK 911</div>
                    </a>

                    <!-- Divider -->
                    <hr class="sidebar-divider my-0">

                    <!-- Nav Items -->
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-fw fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.manageStudents') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.manageStudents') }}">
                                <i class="fas fa-fw fa-users"></i>
                                <span>Manage Students</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.manageUsers') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.manageUsers') }}">
                                <i class="fas fa-fw fa-user-cog"></i>
                                <span>Manage Users</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.manageClasses') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.manageClasses') }}">
                                <i class="fas fa-fw fa-school"></i>
                                <span>Manage Classes</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('admin.manageAttendance') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.manageAttendance') }}">
                                <i class="fas fa-fw fa-calendar-check"></i>
                                <span>Manage Attendance</span>
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'guru')
                        <li class="nav-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('teacher.dashboard') }}">
                                <i class="fas fa-fw fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('teacher.attendance') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('teacher.attendance') }}">
                                <i class="fas fa-fw fa-calendar-check"></i>
                                <span>Attendance</span>
                            </a>
                        </li>
                    @endif
                </ul>
            @endif
        @endauth
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                <img class="img-profile rounded-circle" src="{{ asset('assets/img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- End of Page Content -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>© {{ date('Y') }} SMK 911. ✈️🏢🔥</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Are you sure?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are sure.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
</body>
</html>
