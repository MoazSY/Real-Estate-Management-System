<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Counter Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;

            background-color: #f8f9fa;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 100px;
        }

        .left-column {
            flex: 1;
            margin-left: 50px;
            margin-top: -20px;


        }

        .right-column {
            flex: 1;
            margin-right: 500px;
            margin-top: -70px;
            margin-left: 500px;

        }

        h3 {
            font-size: 30px;
            margin-bottom: 30px;
            color: #000000;
            margin-left: 0px;
        }

        .counter-value {
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Align items to the start of the container */
            /*align-items: center;*/


            font-size: 25px;
            margin-bottom: 20px;
            color: #aec1ff;
            margin-left: 60px;


        }
        #rents-counter-value {
            margin-left: 70px;
            color: #000000;
            font-weight: bold; /* Make the text bold */
            font-size: 30px; /* Set your desired font size */


        }


        .counter-value svg {
            width: 40px;
            height: 40px;
            fill: currentColor;
            margin-right: 5px;
            margin-bottom: 30px;

        }

        .details1 {
            border: 1px solid #ccc;
            border-radius: 30px;

            padding: 10px;
            background-color: #E1EBEE;
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
            width: 700px;
            margin-left: -150px;

        }
        /*.details2 {*/

        /*    border: 1px solid #ccc;*/
        /*    border-radius: 20px;*/

        /*    padding: 10px;*/
        /*    background-color: #D0C9C0;*/
        /*    font-size: 20px;*/
        /*    margin-bottom: 10px;*/
        /*    color: #333;*/
        /*    width: 200px;*/
        /*    margin-left: 50px;*/

        /*}*/
        h2{
            margin-left: 20px;
            font-size: 30px;
            color: #000000;

        }

        .details1 p {
            margin: 0;
            margin-top: 10px;
            line-height: 1.5;
            margin-left: 20px;
            color: black;
        }

        .details1 a {
            display: block;
            margin-top: 10px;
            color: #ffffff;
            text-decoration: none;
            margin-left: 20px;
            display: inline-block;
            background-color: #819EA8 ; /* Set your desired background color */
            padding: 5px 10px; /* Set your desired padding */
            border-radius: 5px;
        }

        .details a:hover {
            text-decoration: underline;
        }

        .divider {
            border-top: 1px solid #ccc;
            margin-top: 10px;
        }

    </style>
</head>
<body>
<div class="container">

<div class="right-column">


        <!-- Rent Details -->
    <div class="details1">
        <h2>Rents</h2>

        <div id="rent-details"></div>
    </div>
</div>
</div>
    <script>
        fetch('{{ route('rents') }}')
            .then(response => response.json())
            .then(data => {
                const rents = data.rents;
                let rentDetails = document.getElementById('rent-details');

                rents.forEach(rent => {
                    let rentElement = document.createElement('div');

                    rentElement.innerHTML += `<p><strong>Renting Number:</strong> ${rent['renting number']}</p>`;
                    rentElement.innerHTML += `<p><strong>Owner Name:</strong> ${rent['owner'].name}</p>`;
                    rentElement.innerHTML += `<p><strong>Renter Name:</strong> ${rent['renter'].name}</p>`;
                    rentElement.innerHTML += `<p><strong>Rental Period:</strong> ${rent['period']} months</p>`;
                    rentElement.innerHTML += `<p><strong>Rent Start Date:</strong> ${rent.rent_start}</p>`;
                    rentElement.innerHTML += `<p><strong>Rent End Date:</strong> ${rent.rent_end}</p>`;
                    rentElement.innerHTML += '<a class="view-details-link" href="{{ route('getpropertybyId', '') }}/' + rent['property'].id + '">Rented Property</a>';
                    rentElement.innerHTML += '<a class="view-owner-link" href="{{ route('getuser', '') }}/' + rent['owner'].id + '">Owner</a>';
                    rentElement.innerHTML += '<a class="view-renter-link" href="{{ route('getuser', '') }}/' + rent['renter'].id + '">Renter</a>';
                    rentElement.innerHTML += `<div class="divider"></div>`;

                    rentDetails.appendChild(rentElement);
                });
            })
            .catch(error => console.error(error));
    </script>

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

        // Call the rents_counter route and update the rents counter value
        getCounterValue('{{ route("rents_counter") }}', 'rents-counter-value');
    </script>
</body>
</html>
