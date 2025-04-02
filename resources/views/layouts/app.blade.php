<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Logistics')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">



    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}

    <style>
        body {
            display: flex;
            height: 100vh;
            flex-direction: column;
        }
        .main-container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            color: white;
            height: 100vh;
            padding-top: 15px;
        }
        .sidebar a {
            padding: 10px 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background-size: cover;
        }
    </style>
</head>
<body>

    <!-- Header -->
    @include('layouts.header')

    <div class="main-container">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
