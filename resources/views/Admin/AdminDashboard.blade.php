<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">


    <style>
        /* Custom styles */
        .sidebar-toggle {
            cursor:pointer;
            top: 0;
            position: absolute;
            width: 50px;
            height:50px;
            font-size: 30px;

        }
        .sidebar-close{
            cursor:pointer;
            font-size: 30px;
            /*width: 50px;*/
            /*height:50px;*/

        }

        /*.sidebar-container {*/
        /*    background-color: #f8f9fa;*/
        /*    width: 250px;*/
        /*    position: fixed;*/
        /*    top: 0;*/
        /*    left: 0;*/
        /*    height: 100vh;*/
        /*    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);*/
        /*    transition: transform 0.3s ease;*/
        /*    z-index: 100;*/
        /*    transform: translateX(-100%);*/

        /*}*/



        /*.sidebar-container.open {*/
        /*    transform: translateX(0);*/

        /*}*/
        .sidebar-container {
            width: 250px; /* Adjust the width as per your preference */
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background-color: #f5f5f5; /* Adjust the background color as needed */
            z-index: 999;
            overflow-y: auto;
            transition: 0.3s;
            transform: translateX(0);
        }

        .sidebar-container.open {
            transform: translateX(0);
        }

        .sidebar-menu {
            /* ... existing styles ... */
            display: block; /* Add this to always show the sidebar menu */
        }

        .sidebar-header {
            background-color: #e5e7f4 ;
            color: #000;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;

        }

        .sidebar-title {
            margin: 0;
            margin-left: 50px;
        }

        /*.sidebar-menu {*/
        /*    display: none;*/

        /*    padding: 20px;*/
        /*}*/

        .sidebar-menu-title {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #00000f;
            margin-left: 50px;
        }

        .sidebar-menu-item {
            margin-bottom: 10px;
            font-size: 17px;
        }

        .sidebar-menu-item a {
            text-decoration: none;
            color: #212529;
            margin-left: 50px;

        }

        /*.main-content {*/
        /*    margin-left: 250px;*/
        /*    padding: 20px;*/
        /*}*/
        body {
            background-color: #f8f9fa;
        }

        .main-content {
            display: none;
            margin-left: 260px;
            width: 1050px;

            /*margin: 20px;*/
            background-color: #fff;
            box-shadow: 0 0 10px gray;
            padding: 20px;
            border-radius: 10px;

        }

        .table {
            border-radius: 10px;
            overflow: hidden;
            width: 1000px;
        }

        .table thead th {
            background-color: #819EA8;
            color: #fff;
            border-color: #dee2e6;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #fffff6;
        }

        .table td, .table th {
            border-color: #dee2e6;
        }
        .view-details-link {
            background-color: #e5e7f4;
            color: black;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
        }

        .view-details-link:hover {
            background-color: #D8BFD8;
        }
        td button {
            background-color: #E6E6FA;
            color: black;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        td button:hover {
            background-color: #D8BFD8;
        }
        #pre_loader {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color:white;
            z-index: 9999;
        }

        #pre_loader img {
            width: 100px;
            height: 100px;
        }

        /*.card details1 {*/
        /*    position: absolute;*/
        /*    top: 50px;*/
        /*    left: 300px;*/
        /*}*/

        /*.card details2 {*/
        /*    position: absolute;*/
        /*    top: 50px;*/
        /*    right: 100px;*/
        /*}*/
        .counter-container {
            display: flex;
            justify-content: space-between;
            margin-bottom:300px;
            top: 50px;
        }

        .counter-container .counter-value {
            /*display: flex;*/
            /*align-items: center;*/
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Align items to the start of the container */
            /*align-items: center;*/


            font-size: 25px;
            margin-bottom: 20px;
            color: #aec1ff;
            margin-left: 60px;
        }
       h3 {
            font-size: 30px;
            margin-bottom: 30px;
            color: #000000;
            margin-left: 0px;
        }


        #sells-counter-value {
            margin-left: 15px;
            color: #000000;
            font-weight: bold; /* Make the text bold */
            font-size: 30px; /* Set your desired font size */

        }


        /*.counter-container.counter-value svg {*/
        /*    width: 40px;*/
        /*    height: 40px;*/
        /*    fill: currentColor;*/
        /*    margin-right: 5px;*/
        /*    margin-bottom: 30px;*/

        /*}*/

        #rents-counter-value {
            color: #000000;
            font-weight: bold; /* Make the text bold */
            font-size: 30px; /* Set your desired font size */
            position: absolute;
            right: 120px;

        }


        .counter-value svg {
            width: 40px;
            height: 40px;
            fill: currentColor;
            margin-right: 5px;
            margin-bottom: 30px;

        }
        .card-container {
            position: relative;
    }

        .details1 {
            position: absolute;
            margin-left: 400px;
            border: 2px solid #E1EBEE;

            border-radius: 25px;
        }
        .details2 {
            position: absolute;
            right: 400px;
            border: 2px solid #E1EBEE;

            border-radius: 25px;
        }
        .counter-container{
            margin-top: 20px;

        }
        .user-image-container {
            position: relative;
            display: inline-block;
            /*margin-left: 50px;*/
        }

        .user-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

        .full-image-overlay {
            position: absolute;
            top: 0;
            left: 100%;
            display: none;
            z-index: 999;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            background-color: #fff;
            padding: 5px;
            transition: 0.3s;
        }

        .user-thumbnail:hover + .full-image-overlay {
            display: block;
        }

        .full-user-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        body {
            background-color: #f8f9fa;
        }

    </style>
</head>
<body class="antialiased">

{{--<div id="pre_loader">--}}
{{--    <img src="public/pre-loader/loader-01.svg" alt="">--}}
{{--</div>--}}

{{--<div id="pre_loader">--}}
{{--    <img src="{{ asset('public/pre-loader/loader-01.svg') }}" alt="">--}}
{{--</div>--}}

<div id="pre_loader">
    <img src="{{ asset('public/pre-loader/Dual Ball-1s-200px.svg') }}" alt="">
</div>
<div class="counter-container">
    <div class="card-deck">
        <div class="card details1" style="height: 15rem; width: 15rem;">
            <div class="card-body">
                <h3 class="card-title">Sells Counter</h3>
                <div class="counter-value" id="sells-counter">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-check" viewBox="0 0 16 16">
                            <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207l-5 5V13.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 2 13.5V8.207l-.646.647a.5.5 0 1 1-.708-.708L7.293 1.5Z"/>
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.707l.547.547 1.17-1.951a.5.5 0 1 1 .858.514Z"/>
                        </svg>
                    </div>
                    <div>
                        <span id="sells-counter-value">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-deck">
    <div class="card details2" style="height: 15rem; width: 15rem;">
        <div class="card-body">
            <h3 class="card-title">Rents Counter</h3>
            <div class="counter-value" id="rents-counter">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-check" viewBox="0 0 16 16">
                        <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207l-5 5V13.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 2 13.5V8.207l-.646.647a.5.5 0 1 1-.708-.708L7.293 1.5Z"/>
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.707l.547.547 1.17-1.951a.5.5 0 1 1 .858.514Z"/>
                    </svg>
                </div>
                <div>
                    <span id="rents-counter-value">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<!-- Sidebar toggle button -->
<div class="sidebar-toggle" onclick="toggleSidebar()">&#9776;</div>

<!-- Sidebar container -->
<div class="sidebar-container" id="sidebar">
    <!-- Sidebar header -->
    <div class="sidebar-header">
        <h2 class="sidebar-title">Menu</h2>
{{--        <div class="sidebar-close" onclick="toggleSidebar()">&times;</div>--}}
    </div>
@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::guard('admin')->user();
//    dd($user);
@endphp




    <!-- Sidebar menu -->
    <div class="sidebar-menu">
        <h3 class="sidebar-menu-title">Account</h3>
        <div class="sidebar-menu-item">
            <div class="user-info">
                <div class="user-image-container">
                    <img src="{{ $user->image ?? '' }}" alt="User Image" class="user-image user-thumbnail">

                    <div class="full-image-overlay">
                        <img src="{{ $user->image ?? '' }}" alt="Full User Image" class="full-user-image">
                    </div>
                </div>
                <span class="name">{{ $user->name }}</span>


            </div>
        </div>


        <div class="sidebar-menu-item">
            <a href="{{ route('add-admin') }}">Add Admin</a>
        </div>

        <div class="sidebar-menu-item">
            <a href="#" onclick="logout()">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <h3 class="sidebar-menu-title">Navigation</h3>

        <div class="sidebar-menu-item">
            <a href="{{ route('Sells') }}">Sells</a>
        </div>
        <div class="sidebar-menu-item">
            <a href="{{ route('Rents') }}">Rents</a>
        </div>


        <div class="sidebar-menu-item">
            <a href="{{route('reports')}}">Reports</a>
        </div>
{{--        <div class="sidebar-menu-item">--}}
{{--            <a href="{{route('complaints')}}">Complaints</a>--}}
{{--        </div>--}}



    </div>
</div>
<!-- Main content -->
<div class="main-content">
    <table class="table " id="propertiesTable">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Owner Name</th>
            <th scope="col">Owner Rate</th>
            <th scope="col">Location</th>
            <th scope="col">State</th>
            <th scope="col">Delete</th>
            <th scope="col">View Details</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<!-- Bootstrap JS -->
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/bootstrap.bundle.min.js"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function getCounterValue(url, elementId) {
        var request = new XMLHttpRequest();
        request.open('GET', url, true);
        request.onload = function() {
            if (request.status >= 200 && request.status < 400) {
                document.getElementById(elementId).textContent = request.responseText;
            }
        };
        request.send();
    }


    // Call the sells_counter route and update the sells counter value
    getCounterValue('{{ route("sells_counter") }}', 'sells-counter-value');

    function getCounterValue(url, elementId) {
        var request = new XMLHttpRequest();
        request.open('GET', url, true);
        request.onload = function() {
            if (request.status >= 200 && request.status < 400) {
                document.getElementById(elementId).textContent = request.responseText;
            }
        };
        request.send();
    }

    // Call the rents_counter route and update the rents counter value
    getCounterValue('{{ route("rents_counter") }}', 'rents-counter-value');
    function logout() {
        event.preventDefault();
        // Clear the browser's history and replace it with the login route
        window.location.replace("{{ route('Admin') }}");
        // Perform the logout action
        document.getElementById('logout-form').submit();
    }
    {{--function logout() {--}}
    {{--    // Add the logout logic here, such as clearing session data or performing any necessary actions--}}

    {{--    // Redirect to the login page without the ability to go back to the admin dashboard--}}
    {{--    window.location.replace('{{ route("Admin") }}');--}}

    {{--    // Modify the browser history to prevent going back to the admin dashboard--}}
    {{--    history.replaceState(null, '', '{{ route("Admin") }}');--}}
    {{--}--}}
    window.addEventListener('load', function() {
        var preLoader = document.getElementById('pre_loader');
        setTimeout(function() {
            preLoader.style.display = 'none';
        }, 2000); // 2 seconds delay
    });
    // function toggleSidebar() {
    //
    //     var sidebarMenu = document.querySelector('.sidebar-menu');
    //     setTimeout(function() {
    //         sidebarMenu.style.display = 'block';
    //     }, 4000); // 2 seconds delay
    //
    //     var sidebar = document.getElementById("sidebar");
    //
    //     sidebar.classList.toggle("open");
    //
    //
    // }
    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("open");
    }

    // Remove the setTimeout function from your existing code




    document.addEventListener('DOMContentLoaded', function () {
        var mainContent = document.querySelector('.main-content');
        setTimeout(function() {
            mainContent.style.display = 'block';
        }, 2000); // 2 seconds delay
        fetch('{{ route('getproperty') }}')
            .then(response => response.json())
            .then(data => {
                const properties = data.data;
                const tableBody = document.querySelector('#propertiesTable tbody');
                let tableContent = '';

                properties.forEach(property => {
                    tableContent += '<tr>';
                    tableContent += '<td>' + property['owner name'] + '</td>';
                    tableContent += '<td>' + property['rate'] + '</td>';
                    tableContent += '<td>' + property['location'].address + '</td>';
                    tableContent += '<td>' + property['state'].nameState + '</td>';
                    tableContent += '<td>';
                    tableContent += '<form action="{{ route('delete_property', '') }}/' + property['property'].id + '" method="GET">';
                    tableContent += '@csrf';
                    tableContent += '@method('DELETE')';
                    tableContent += '<button type="submit" >Delete</button>';
                    tableContent += '</form>';
                    tableContent+= '</td>';
                    tableContent += '<td>'; // New column for the "View Details" button
                    tableContent += '<a class="view-details-link" href="{{ route('getpropertybyId', '') }}/' + property['property'].id + '">View Details</a>';
                    tableContent += '</td>';
                    tableContent += '</tr>';
                });

                tableBody.innerHTML = tableContent;
            })
            .catch(error => console.error(error));
    });
</script>
</body>
</html>
