<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .form-control-sm {
            width: 500px;
            height: 50px;
        }
        body {
            background-color: #f2f2ff;
        }
        .btn-outline-secondary{
            background-color: transparent;
            border-color: #6c757d;
            color: #6c757d;
            border-radius: 5px;
        }
        .btn-outline-secondary:hover, .btn-outline-secondary:focus {
            background-color: #819EA8;
            color: #000;
        }
        h1{
            margin-bottom: 40px;
        }
        .form-label {
            color: #495057;
            font-weight: bold;
        }
        #message{
            width: 500px;
        }
    </style>
</head>
<body class="antialiased">
<!-- create-account.blade.php -->
<div class="container">
    <h1 class="mt-5">Create Bank Account</h1>

    <form action="{{ route('create-account') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="bankId" class="form-label">Bank ID</label>
            <input type="text" class="form-control form-control-sm @error('bankId') is-invalid @enderror" id="bankId" name="bankId" required>
            @error('bankId')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">password</label>
            <input type="number" class="form-control form-control-sm" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control form-control-sm" id="amount" name="amount" required>
        </div>
        <button type="submit" class="btn btn-outline-secondary">Create Account</button>
    </form>

    @if(Session::has('bankIdInvalid'))
        <div id="message" class="mt-3 alert alert-danger">
            <h4 class="alert-heading">Invalid Bank ID!</h4>
            <p>Please enter a valid bank ID.</p>
        </div>
    @endif

    @if(Session::has('accountNumber'))
        <div id="message" class="mt-3 alert alert-success">
            <h4 class="alert-heading">Account created successfully!</h4>
            <p><strong>Account Number</strong>: {{ Session::get('accountNumber') }}</p>
        </div>

    @endif
    @if(Session::has('password'))
        <div id="message" class="mt-3 alert alert-success">

            <p><strong>password</strong>: {{ Session::get('password') }}</p>
        </div>

    @endif
    <?php
    session()->forget('bankIdInvalid');
    session()->forget('accountNumber');
    session()->forget('password');
//
//    session()->flash('bankIdInvalid', true);
//    session()->flash('accountNumber', );
    ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
