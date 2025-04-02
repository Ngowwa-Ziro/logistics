<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Internet Banking')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            height: 100%;
            padding-top: 15px;
        }
        .sidebar a {
            color: white;
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
        }
    </style>
</head>
<body>



    <div class="content">
        @yield('content')
    </div>

</body>
</html>
