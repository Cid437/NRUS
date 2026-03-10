<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'NRUS Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">

    <style>
        body {
            min-height: 100vh;
            background: #f8f9fa;
        }
        .admin-layout .sidebar {
            min-height: 100vh;
            background: #0d6efd;
        }
        .admin-layout .sidebar a {
            color: #fff;
        }
        .admin-layout .sidebar a.active,
        .admin-layout .sidebar a:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .admin-footer {
            background: #fff;
            border-top: 1px solid #dee2e6;
            padding: 0.8rem;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>

    @stack('styles')
</head>
<body class="admin-layout">
    <div class="d-flex flex-column flex-lg-row">
        <aside class="sidebar p-3 d-none d-lg-block" style="width: 220px;">
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none fs-5 fw-bold">🛒 NRUS Admin</a>
            </div>
            <nav class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}" class="nav-link rounded mb-1 @routeIs('admin.dashboard') active @endif">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="nav-link rounded mb-1 @routeIs('admin.products.*') active @endif">Products</a>
                <a href="{{ route('admin.users.index') }}" class="nav-link rounded mb-1 @routeIs('admin.users.*') active @endif">Users</a>
                <a href="{{ route('admin.reviews.index') }}" class="nav-link rounded mb-1 @routeIs('admin.reviews.*') active @endif">Reviews</a>
                <a href="{{ route('admin.transactions.index') }}" class="nav-link rounded mb-1 @routeIs('admin.transactions.*') active @endif">Transactions</a>
            </nav>

            <div class="mt-5 pt-3 border-top border-white-25">
                <div class="text-white mb-2">{{ auth()->user()->name }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100">Logout</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm d-lg-none">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">NRUS Admin</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminMobileMenu" aria-controls="adminMobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="adminMobileMenu">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.products.index') }}">Products</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.reviews.index') }}">Reviews</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.transactions.index') }}">Transactions</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="p-3 p-lg-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <h1 class="h4 mb-2 mb-md-0">@yield('header', 'Admin Panel')</h1>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-sm">Back to Shop</a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6 class="mb-2">Please fix the following errors:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @yield('content')
            </div>

            <footer class="admin-footer">© {{ date('Y') }} NRUS Admin Panel</footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
