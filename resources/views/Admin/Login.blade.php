<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            width: 1000px;
            margin: 0 auto;
            padding-top: 100px;
            text-align: center;

        }

        h1 {
            margin-bottom: 30px;
            color: #495057;
            margin-bottom: 50px;
            margin-top: 20px;
        }

        input {
            margin-bottom: 20px;
            width: 50%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
            margin-left: -100px;
        }

        button:hover {
            background-color: #0069d9;
        }

        #message {
            margin-top: 20px;
            color: #dc3545;
            width: 300px;
            margin-left: 200px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1>Login</h1>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>
                    </form>
                    @if (session('error'))
                        <div id="message" class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<?php
session()->forget('error');
?>

</body>
</html>

