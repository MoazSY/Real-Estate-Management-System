<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        a {
            margin-top: 20px;
            margin-left: 20px;
        }

        body {
            background-color: #f2f2ff;
        }

        h1 {
            color: #336699;
        }

        th {
            background-color: #eaeaea;
            color: #333333;
        }

        .btn-outline-primary {
            color: #336699;
            border-color: #336699;
        }

        .btn-outline-primary:hover {
            background-color: #336699;
            color: #f2f2f2;
        }
    </style>
</head>
<body class="antialiased">
<!-- dashboard.blade.php -->
<div class="container">
    <h1 class="mt-5">Bank Dashboard</h1>

    <table class="table">
        <thead>
        <tr>
            <th>Bank Id</th>
            <th>Name</th>
            <th>Location</th>
            <th>State</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($b as $bank)
            <tr>
                <td>{{ $bank['Id'] }}</td>
                <td>{{ $bank['name'] }}</td>
                <td>{{ $bank['location']}}</td>
                <td>{{ $bank['state'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('create') }}" class="btn btn-outline-primary">Create Bank Account</a>

    <a href="{{ route('add') }}" class="btn btn-outline-primary">Add Money</a>
    <a href="{{ route('show-balance') }}" class="btn btn-outline-primary">Show My Account</a>

</div>
<div class="position-fixed top-0 end-0 p-3">
    <a href="{{ route('logoutb') }}" >Logout</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
