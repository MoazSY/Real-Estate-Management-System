<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Show My Accounts</title>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            /*max-width: 800px;*/
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            margin-top: 50px;
            font-size: 32px;
            text-align: center;
            margin-bottom: 100px;
            margin-left: -975px;
            color: #5D8AA8;
        }

        .card {
            background-color: #fff;
            border: 1px solid #5D8AA8;

            border-radius: 15px;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 2px 4px gray;
            margin-left: 50px;
            width: 400px;
        }

        .card-title {
            font-size: 24px;
            margin-bottom: 10px;
            color: #000;
        }

        .card-text {
            font-size: 18px;
            margin-bottom: 5px;
            color: #212529;
        }

    </style>
</head>
<body>
<div class="container">
    <h1>My Accounts</h1>

    <div class="row">
        @foreach ($accounts as $account)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Account Number: {{ $account->accountNumber }}</h2>
                        <p class="card-text">Bank: {{ $account->bank }}</p>
                        <p class="card-text">Balance: {{ $account->balance }} SL</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<!-- Include Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
