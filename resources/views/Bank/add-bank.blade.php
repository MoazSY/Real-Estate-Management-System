<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Bank</title>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
          width: 1500px;
            margin: 0 auto;
            border: white;
            border-radius: 20px;
        }

        .card {

            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: #5D8AA8;
            color: #fff;
            border: white;
            border-radius: 20px;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            padding: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #5D8AA8;
            border-color: #5D8AA8;
            color: white;
        }

        .btn-primary:hover {
            background-color: #d4edda;
            border-color: #5D8AA8;
            color: #000;
        }
    </style>
</head>

<body class="antialiased">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add Bank</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('addbank') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Bank Name:</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="nameState" class="form-label">State Name:</label>
                            <input type="text" class="form-control" name="nameState" id="nameState" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <input type="text" class="form-control" name="address" id="address" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Bank</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session()->has('message'))
    <div class="alert alert-success mt-3 text-center">
        {{ session('message') }}
    </div>
@endif

<!-- Include Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
