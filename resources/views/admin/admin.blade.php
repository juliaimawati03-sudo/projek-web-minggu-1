<!DOCTYPE html>

<html lang="id">

<head>

```
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title', 'Admin - SIMANTAP')</title>

<!-- Font Awesome -->
<link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

<!-- SB Admin 2 CSS -->
<link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
```

</head>

<body id="page-top">

```
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center"
           href="/admin/dashboard">

            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-seedling"></i>
            </div>

            <div class="sidebar-brand-text mx-3">
                SIMANTAP
            </div>

        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Dashboard -->
        <li class="nav-item active">

            <a class="nav-link" href="/admin/dashboard">

                <i class="fas fa-fw fa-tachometer-alt"></i>

                <span>Dashboard</span>

            </a>

        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Data Master
        </div>

        <!-- Produk -->
        <li class="nav-item">

            <a class="nav-link" href="#">

                <i class="fas fa-box"></i>

                <span>Produk</span>

            </a>

        </li>

        <!-- Supplier -->
        <li class="nav-item">

            <a class="nav-link" href="#">

                <i class="fas fa-truck"></i>

                <span>Supplier</span>

            </a>

        </li>

        <!-- Pengguna -->
        <li class="nav-item">

            <a class="nav-link" href="#">

                <i class="fas fa-users"></i>

                <span>Pengguna</span>

            </a>

        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Transaksi
        </div>

        <!-- Transaksi -->
        <li class="nav-item">

            <a class="nav-link" href="#">

                <i class="fas fa-shopping-cart"></i>

                <span>Transaksi</span>

            </a>

        </li>

        <!-- Pengeluaran -->
        <li class="nav-item">

            <a class="nav-link" href="#">

                <i class="fas fa-money-bill-wave"></i>

                <span>Pengeluaran</span>

            </a>

        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Laporan -->
        <li class="nav-item">

            <a class="nav-link" href="#">

                <i class="fas fa-chart-bar"></i>

                <span>Laporan</span>

            </a>

        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler -->
        <div class="text-center d-none d-md-inline">

            <button class="rounded-circle border-0" id="sidebarToggle"></button>

        </div>

    </ul>
    <!-- End of Sidebar -->


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Mobile) -->
                <button id="sidebarToggleTop"
                        class="btn btn-link d-md-none rounded-circle mr-3">

                    <i class="fa fa-bars"></i>

                </button>

                <!-- Page Title -->
                <div>

                    <h1 class="h3 mb-0 text-gray-800">
                        @yield('page-title', 'Dashboard')
                    </h1>

                    <small class="text-muted">
                        @yield('page-subtitle', 'Selamat datang di panel admin')
                    </small>

                </div>


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- User -->
                    <li class="nav-item dropdown no-arrow">

                        <a class="nav-link dropdown-toggle"
                           href="#"
                           id="userDropdown"
                           role="button"
                           data-toggle="dropdown">

                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <span id="user-name">Admin</span>
                            </span>

                            <i class="fas fa-user-circle fa-2x text-gray-400"></i>

                        </a>

                        <!-- Dropdown -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">

                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profil
                            </a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item"
                               href="#"
                               onclick="logout(); return false;">

                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>

                                Logout

                            </a>

                        </div>

                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->


            <!-- Page Content -->
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

                    <span>
                        © {{ date('Y') }} SIMANTAP - Sistem Informasi Manajemen Toko
                    </span>

                </div>

            </div>

        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->


<!-- Scroll to Top -->
<a class="scroll-to-top rounded" href="#page-top">

    <i class="fas fa-angle-up"></i>

</a>


<!-- Logout Modal -->
<div class="modal fade"
     id="logoutModal"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Siap untuk keluar?
                </h5>

                <button class="close"
                        type="button"
                        data-dismiss="modal">

                    <span>×</span>

                </button>

            </div>

            <div class="modal-body">

                Pilih "Logout" jika kamu ingin keluar dari halaman admin.

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary"
                        type="button"
                        data-dismiss="modal">

                    Batal

                </button>

                <a class="btn btn-danger"
                   href="#"
                   onclick="logout(); return false;">

                    Logout

                </a>

            </div>

        </div>

    </div>

</div>


<!-- jQuery -->
<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- SB Admin 2 JS -->
<script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>


<script>
    function logout() {

        if (confirm('Yakin ingin logout?')) {

            localStorage.removeItem('simantap_user');

            window.location.href = '/login';

        }

    }
</script>
```

</body>

</html>
