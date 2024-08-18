<!DOCTYPE html>
<html>
<head>
    <title>Logout Page</title>
</head>
<body>
<script>
    // Clear the browser's cache
    window.location.href = "{{ route('Admin') }}";
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Logout') }}</div>

                <div class="card-body">
                    <p>You have been logged out successfully.</p>
                    <p>Click <a href="{{ route('Admin') }}">here</a> to login again.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
