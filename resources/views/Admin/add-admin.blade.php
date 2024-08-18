<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .small-input {
            width: 400px;
            height: 50px;
            border: 2px solid #E1EBEE;

            border-radius: 5px;
        }
        .alert {
            align-content: center;
            border-radius: 5px;
            width: 250px;
        }

        .alert-success {
            background-color: #d4edda ;
            color: #000;
        }
        h3{
            margin-bottom: 20px;
            color: gray;
        }
        .btn-outline {
            background-color: #E1EBEE;
            border-color: #E1EBEE;
            color: #000;
            border-radius: 5px;
        }

        .btn-outline:hover, .btn-outline-grey:focus {
            background-color: #819EA8;
            color: #000;
        }
        body {
            background-color: #f8f9fa;
        }

        /*.center-text {*/
        /*    text-align: center;*/
        /*}*/
    </style>
</head>
<body>

<div class="container mt-5">
    <h3>Add admin details</h3>
    <form action="{{ route('addadmin') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" id="name" class="form-control small-input" required>
            </div>
            <div class="col">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control small-input" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control small-input" required>
            </div>
            <div class="col">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" name="phone" id="phone" class="form-control small-input" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="age" class="form-label">Age:</label>
                <input type="number" name="age" id="age" class="form-control small-input" required>
            </div>
            <div class="col">
                <label for="gender" class="form-label">Gender:</label>
                <select name="gender" id="gender" class="form-select small-input" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="information" class="form-label">Information:</label>
                <textarea name="information" id="information" class="form-control small-input" required></textarea>
            </div>
            <div class="col">
                <label for="image" class="form-label">Image:</label>
                <input type="file" name="image" id="image" class="form-control small-input" required>
            </div>

        </div>

        <div>
            <button type="submit" class="btn btn-outline">Add Admin</button>
        </div>
    </form>
    @if(session()->has('message'))
        <div class="alert alert-success mt-3 alert-heading">
            {{ session('message') }}
        </div>

    @endif

    @php
        session()->forget('message');
    @endphp
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
