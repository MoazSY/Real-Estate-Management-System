<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Balance</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #819EA8;
            color: #fff;
            text-align: center;
            padding: 15px;
            border-radius: 0;
            border-bottom: none;
        }

        .card-title {
            margin-bottom: 0;
        }

        .form-label {
            color: #495057;
            font-weight: bold;
        }

        .form-control {
            border-radius: 0;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            border-radius: 0;
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
        }

        .btn-outline-grey {
            background-color: transparent;
            border-color: #6c757d;
            color: #6c757d;
            border-radius: 0;
        }

        .btn-outline-grey:hover, .btn-outline-grey:focus {
            background-color: #819EA8;
            color: #fff;
        }

        .alert {
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #000;
            font-size: 16px;
        }

        .alert-danger {
            background-color: #f8d7da ;
            color: #000;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Balance</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('add-money') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="account_number" class="form-label">Account Number:</label>
                            <input type="text" name="account_number" id="account_number" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Account password:</label>
                            <input type="text" name="password" id="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount:</label>
                            <input type="text" name="amount" id="amount" class="form-control">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-outline-grey">Add Money</button>
                        </div>
                    </form>
                </div>
            </div>
{{--            @if(session('message'))--}}
{{--                <div class="alert alert-success mt-3">--}}
{{--                    {{ session('message') }}--}}
{{--                </div>--}}
{{--            @endif--}}
            @if(Session::has('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
                {{--                @php--}}
                {{--                    session()->forget('AccountNumberInvalid');--}}
                {{--                @endphp--}}
            @endif


            @if(Session::has('AccountNumberInvalid'))
                <div class="alert alert-danger mt-3">
                    <h4 class="alert-heading">Invalid Account Number!</h4>
                    <p>Please enter correct account number.</p>
                </div>
{{--                @php--}}
{{--                    session()->forget('AccountNumberInvalid');--}}
{{--                @endphp--}}
            @endif
            @if(Session::has('PasswordInvalid'))
                <div class="alert alert-danger mt-3">
                    <h4 class="alert-heading">Invalid Password!</h4>
                    <p>Please enter correct password.</p>
                </div>
                {{--                @php--}}
                {{--                    session()->forget('AccountNumberInvalid');--}}
                {{--                @endphp--}}
            @endif
            @if(session()->has('message'))
                <div class="alert alert-success mt-3 center-text">
                    {{ session('message') }}
                </div>
                {{--                @php--}}
                {{--                    session()->forget('message');--}}
                {{--                @endphp--}}
            @endif
        </div>
    </div>
</div>

<?php
session()->forget('error');

session()->forget('AccountNumberInvalid');

session()->forget('PasswordInvalid');
session()->forget('message');
//
//session()->flash('AccountNumberInvalid', true);
//session()->flash('message', '');
?>

</body>
</html>
