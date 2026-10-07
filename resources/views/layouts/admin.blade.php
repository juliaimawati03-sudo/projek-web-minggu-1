<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') | SIMANTAP</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body id="page-top">

    <div id="wrapper">

        {{-- Sidebar --}}
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: linear-gradient(180deg, #15803d 10%, #166534 100%);">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SIMANTAP</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Menu Utama</div>

            <li class="nav-item {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.transaksi.index') }}">
                    <i class="fas fa-fw fa-receipt"></i>
                    <span>Transaksi Penjualan</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.pembelian.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pembelian.create') }}">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Pembelian Supplier</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Data Master</div>

            <li class="nav-item {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.produk.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Produk</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.supplier.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.supplier.index') }}">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Supplier</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.pengguna.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Pengguna</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Laporan</div>

            <li class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Laporan Keuangan</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        {{-- Content Wrapper --}}
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ auth()->user()->nama ?? 'Admin' }}
                                </span>
                                <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>

                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">@yield('page-title', 'Dashboard')</h1>
                            <p class="mb-0 text-muted small">@yield('page-desc', '')</p>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <ul class="mb-0 pl-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @yield('content')

                </div>

            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>© {{ date('Y') }} SIMANTAP. All rights reserved.</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yakin ingin logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" jika Anda yakin ingin keluar.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    @stack('scripts')
</body>
</html>