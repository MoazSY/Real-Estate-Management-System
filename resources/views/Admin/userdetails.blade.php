<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">

    <style>
        body {
            padding: 20px;
            background-color: #f9f9f9;
        }

        h1 {
            color: #000000;
            text-align: left;
        }

        .user-details-container {
            margin-top: 20px;
            margin-bottom: 20px;
            background-color: #E1EBEE ;
            border: 2px solid #ffffff;
            border-radius: 30px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #333;
            max-width: 700px;
            margin: 0 auto; /* Center the container horizontally */
        }

        .user-details p {
            margin: 10px 0;
            line-height: 1.5;
            color: black;
            /*font-style: italic;*/
            margin-bottom: 20px;
            font-size: 20px;
        }

        .user-image {
            width: 300px;
            height: 300px;
            object-fit: cover;
            margin-top: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .user-section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #000000;
            text-align: left;
        }
        :root {
            --dark: #bbb;
            --light: #fff;
            --light-muted: #5D8AA8;
        }

        /*body {*/
        /*    font-family: sans-serif;*/
        /*}*/

        /* Switch Styling
         * ===================================== */
        toggle-switch {
            height: 0.5em;
            width: 50px;
        }

        toggle-switch::part(track) {
            padding: 0.125em;
            border-radius: 1em;
            background-color: hsl(0, 0%, 67%);
        }

        toggle-switch::part(slider) {
            border-radius: 1em;
            background-color: hsl(0, 0%, 100%);
            box-shadow: 0.0625em 0.0625em 0.125em hsla(0, 0%, 0%, 0.25);
        }

        toggle-switch[checked]::part(track) {
            background-color: var(--light-muted);
        }

        /* Light
         * ===================================== */
        #light {
            fill: var(--dark);
        }

        #light.on {
            fill: var(--light);
            filter: drop-shadow(0 0 5em var(--light));
        }

        /* Page
         * ===================================== */
        section {
            display: flex;
            max-width: 30rem;
            margin: auto;
            align-items: center;
            justify-content: center;
        }

        section > div {
            flex: 1;
        }

        .switch-container {
            font-size: 3rem;
            text-align: center;
        }

        .lightbulb-container {
            text-align: center;
        }

        .lightbulb {
            overflow: visible;
            max-width: 20em;
            max-height: calc(90vh - 4rem);
        }

        footer {
            text-align: center;
        }



    </style>
</head>
<body>
<div class="container">
    <div class="user-details-container">

    <h1>User Details</h1>
        <div class="user-details">
            <p>Name: {{ $details[1] }}</p>
            <p>Rate: {{ $details[2] }}</p>
            <p>Age: {{ $details[6] }}</p>
            <p>Gender: {{ $details[7] }}</p>
            <p>Information: {{ $details[8] }}</p>
            <p>Phone Number: {{ $details[4] }}</p>
            <p>Email Address: {{ $details[5] }}</p>

            <form action="{{ route('delete_property', $details[0]->id) }}" method="GET" style="display: flex; align-items: center;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="margin-bottom: 20px;margin-top: 10px">Delete</button>

            </form>
{{--            <div class="switch-container" style="margin-left: -380px;margin-top: -100px;">--}}
{{--                <p style="font-size: 15px; "><strong>Block User</strong></p>--}}
{{--                <toggle-switch id="switch"  ></toggle-switch>--}}
{{--            </div>--}}
        </div>
        <h2 class="user-section-title">User Image</h2>

        <div class="row">
            @if (is_array($details[3]))
                @foreach ($details[3] as $imageUrl)
                    <div class="col-md-6">
                        <img src="{{ asset(trim($imageUrl)) }}" alt="User Image" class="user-image">
                    </div>
                @endforeach
            @else
                @php
                    $imageUrls = explode(',', $details[3]);
                @endphp

            <!-- Loop through the array of URLs to display the images -->
                @foreach ($imageUrls as $imageUrl)
                    <div class="col-md-6">
                        <img src="{{ asset(trim($imageUrl)) }}" alt="User Image" class="user-image">
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @if (session('error'))
        <div id="message" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</div>
<?php
    session()->forget('message');
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
<script type="module" src="https://unpkg.com/@auroratide/toggle-switch@0.1.1/lib/define.js"></script>


<script>
    // const toggleSwitch = document.getElementById('switch')
    //
    // toggleSwitch.addEventListener('toggle-switch:change', ({ detail }) => {
    //     toggleSwitch.classList.toggle('off', !detail.checked)
    //     toggleSwitch.classList.toggle('on', detail.checked)
    // })
    {{--const toggleSwitch = document.getElementById('switch');--}}

    {{--toggleSwitch.addEventListener('toggle-switch:change', async ({ detail }) => {--}}
    {{--    const v = document.querySelector('.switch-container');--}}
    {{--    const userId = "{{ $details[0]->id }}";--}}
    {{--    const csrfToken = "{{ csrf_token() }}";--}}

    {{--    try {--}}
    {{--        if (detail.checked) {--}}
    {{--            // If the user is not already suspended, call the suspend route--}}
    {{--            await fetch(`/suspend/${userId}`, {--}}
    {{--                method: 'POST',--}}
    {{--                headers: {--}}
    {{--                    'Content-Type': 'application/json',--}}
    {{--                    'X-CSRF-TOKEN': csrfToken--}}
    {{--                }--}}
    {{--            });--}}
    {{--        } else {--}}
    {{--            // If the switch is turned off--}}
    {{--            // If the user is already suspended, call the unsuspend route--}}
    {{--            await fetch(`/unsuspend/${userId}`, {--}}
    {{--                method: 'POST',--}}
    {{--                headers: {--}}
    {{--                    'Content-Type': 'application/json',--}}
    {{--                    'X-CSRF-TOKEN': csrfToken--}}
    {{--                }--}}
    {{--            });--}}
    {{--        }--}}
    {{--    } catch (error) {--}}
    {{--        console.error('An error occurred:', error);--}}
    {{--    }--}}

    {{--    if (v) {--}}
    {{--        v.classList.toggle('off', !detail.checked);--}}
    {{--        v.classList.toggle('on', detail.checked);--}}
    {{--    }--}}
    {{--});--}}

    {{--// Set the initial state of the switch based on the getUser route--}}
    {{--const switchContainer = document.querySelector('.switch-container');--}}
    {{--if (switchContainer) {--}}
    {{--    const isSuspended = {{ $details[9] }};--}}
    {{--    toggleSwitch.checked = isSuspended;--}}
    {{--    switchContainer.classList.toggle('off', !isSuspended);--}}
    {{--    switchContainer.classList.toggle('on', isSuspended);--}}
    {{--}--}}
</script>
</body>
</html>
