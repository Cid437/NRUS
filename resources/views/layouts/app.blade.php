<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'NRUS')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-..." crossorigin="anonymous">
    @stack('styles')

    <style>
        :root {
            --main-bg: #f8f9fa;
            --card-bg: #ffffff;
            --primary-color: #000000;
            --primary-hover: #222222;
            --muted-color: #6c757d;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--main-bg);
            color: #212529;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .main-content {
            flex: 1;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .footer {
            background: #000000;
            color: #fff;
            padding: 0.9rem 0;
            font-size: 0.9rem;
        }

        .card.shadow-sm {
            box-shadow: 0 0.6rem 1rem rgba(0, 0, 0, 0.05);
        }

        .table thead {
            background: var(--primary-color);
            color: #fff;
        }

        .btn-theme {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
            border-radius: 0.35rem;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 0.2rem 0.4rem rgba(0,0,0,0.15);
        }

        .btn-theme:hover,
        .btn-theme:focus {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 0.4rem 0.8rem rgba(0,0,0,0.22);
        }

        .btn-outline-theme {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-theme:hover,
        .btn-outline-theme:focus {
            background-color: var(--primary-color);
            color: #fff;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid rgba(0,0,0,0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.75rem 1rem rgba(0, 0, 0, 0.08);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0,0,0,0.08);
        }

        .text-muted {
            color: var(--muted-color) !important;
        }
    </style>
</head>
<body>
    @include('components.navbar')
    <main class="main-content container">@yield('content')</main>
    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>