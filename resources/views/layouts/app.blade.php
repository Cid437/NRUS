<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NRUS')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        [x-cloak] {
        display: none !important;
        } 
    </style>

    @stack('styles')
</head>

<body>

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Page Content --}}
    <div class="container">
        @yield('content')
    </div>

    {{-- Alpine for dropdowns --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Extra scripts from pages --}}
    @stack('scripts')

</body>
</html>