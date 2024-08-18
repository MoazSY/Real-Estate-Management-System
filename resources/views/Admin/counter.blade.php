<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Counter Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /*table {*/
        /*    width: 100%;*/
        /*    border-collapse: collapse;*/
        /*    border-spacing: 0;*/
        /*}*/
        /*th {*/
        /*    font-size: 18px;*/
        /*    font-weight: bold;*/
        /*    text-align: left;*/
        /*    padding: 10px;*/
        /*    border-bottom: 2px solid #ddd;*/
        /*}*/
        /*td {*/
        /*    font-size: 24px;*/
        /*    text-align: center;*/
        /*    padding: 20px;*/
        /*    border: 1px solid #ddd;*/
        /*}*/
        .counter-label {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        /*.counter-value {*/
        /*    font-size: 24px;*/
        /*    font-weight: bold;*/
        /*    color: #aec1ff;*/
        /*    background-color: #ffffff;*/
        /*    padding: 10px 20px;*/
        /*    border-radius: 5px;*/
        /*    display: flex;*/
        /*    align-items: center;*/
        /*    justify-content: center;*/
        /*    position: relative;*/
        /*    width: 1%;*/
        /*    height: 1%;*/

        /*}*/
        .counter-value {
            font-size: 24px;
            font-weight: bold;
            color: #aec1ff;
            background-color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            width: 5%;
            height: 5%;
            margin: auto;
            margin-bottom: 50px;

            transform: scale(2);
        }

        .counter-value i {
            font-size: 36px;
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        .counter-value .counter-number {
            margin-left: 50px;
        }
        h3 {
            color: darkslateblue;
            text-align: center;
            margin-bottom: 50px;
            font-size: 24px;


        }
        #sells-counter-value {
            font-size: 24px;
            font-weight: bold;
            color: #000000;
            text-align: center;
            position: absolute; /* make the element position absolute */
            /*top: 50%; !* position the element 50% from the top *!*/
            left: 40%; /* position the element 50% from the left */
            /*transform: translateX(-50%); !* center the element horizontally *!*/
            align-items: center;
            margin-top: 75px;


        }
        #rents-counter-value {
            font-size: 24px;
            font-weight: bold;
            color: #000000;
            text-align: center;
            position: absolute; /* make the element position absolute */
            /*top: 50%; !* position the element 50% from the top *!*/
            left: 45%; /* position the element 50% from the left */
            /*transform: translateX(-50%); !* center the element horizontally *!*/
            align-items: center;
            margin-top: 75px;

        }
        #sells {
            display: inline-block;
            vertical-align: top;
            width: 50%;
            padding: 20px;
            horiz-align:left ;
            /*top: 50%; */
            left: 20%;

            box-sizing: border-box;

        }
        #rents {
            position: absolute;
            top: 0;

            right: 0%;
            display: inline-block;
            vertical-align: top;
            width: 50%;
            padding: 20px;
            box-sizing: border-box;
        }
        /*.counter-value {*/
        /*    font-size: 48px;*/
        /*    padding: 20px;*/
        /*}*/

        .section1 {
            margin-bottom: 20px;
            position: absolute;
            top: calc(100% + 20px); /* Position section1 below sells-counter-value */
            left: -55%;
            width: 50%;
            padding: 20px;
            box-sizing: border-box;
        }

        .section2 {
            margin-bottom: 20px;
            position: absolute;
            top: calc(100% + 20px); /* Position section2 below rents-counter-value */
            right: 10%;
            left: 45%;
            width: 50%;
            padding: 20px;
            box-sizing: border-box;
        }

        .section h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .section .details {
            margin-left: 20px;
        }
        body {
            font-family: Arial, sans-serif;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            color: darkslateblue;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .details {
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 5px;
        }

        .details p {
            margin: 0;
            line-height: 1.5;
        }

        .details strong {
            font-weight: bold;
        }

        .details a {
            display: block;
            margin-top: 10px;
            color: #337ab7;
            text-decoration: none;
        }

        .details a:hover {
            text-decoration: underline;
        }

        .divider {
            margin-top: 20px;
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div id="sells">
    <h3>Sells</h3>
    <div class="counter-value" id="sells-counter">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-check" viewBox="0 0 16 16">
            <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207l-5 5V13.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 2 13.5V8.207l-.646.647a.5.5 0 1 1-.708-.708L7.293 1.5Z"/>
            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.707l.547.547 1.17-1.951a.5.5 0 1 1 .858.514Z"/>
        </svg>

        <span id="sells-counter-value">Loading...</span>

</div>

<div id="rents">
    <h3>Rents</h3>
    <div class="counter-value" id="rents-counter">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-check" viewBox="0 0 16 16">
            <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.708L8 2.207l-5 5V13.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 0 1h-4A1.5 1.5 0 0 1 2 13.5V8.207l-.646.647a.5.5 0 1 1-.708-.708L7.293 1.5Z"/>
            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.707l.547.547 1.17-1.951a.5.5 0 1 1 .858.514Z"/>
        </svg>

        <span id="rents-counter-value">Loading...</span>

</div>
    <div class="section1">

    <!-- Sell Details -->
        <!-- Sell Details -->
        <h2>Sells</h2>
        <div id="sell-details" class="details"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('{{ route('sells') }}')
                .then(response => response.json())
                .then(data => {
                    const sells = data.sells;
                    let sellDetails = document.getElementById('sell-details');

                    sells.forEach(sell => {
                        let sellElement = document.createElement('div');

                        sellElement.innerHTML += `<p><strong>Selling Number:</strong> ${sell['selling number']}</p>`;
                        sellElement.innerHTML += `<p><strong>Seller Name:</strong> ${sell['seller'].name}</p>`;
                        sellElement.innerHTML += `<p><strong>Buyer Name:</strong> ${sell['buyer'].name}</p>`;
                        sellElement.innerHTML += '<a class="view-property-link" href="{{ route('getpropertybyId', '') }}/' + sell['property'].id + '">Sold Property</a>';
                        sellElement.innerHTML += '<a class="view-seller-link" href="{{ route('getuser', '') }}/' + sell['seller'].id + '">Seller</a>';
                        sellElement.innerHTML += '<a class="view-buyer-link" href="{{ route('getuser', '') }}/' + sell['buyer'].id + '">Buyer</a>';
                        sellElement.innerHTML += `<div class="divider"></div>`;

                        sellDetails.appendChild(sellElement);
                    });
                })
                .catch(error => console.error(error));
        });
    </script>
        <div class="section2">

            <!-- Rent Details -->
            <h2>Rents</h2>
            <div id="rent-details" class="details"></div>
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

    // Call the sells_counter route and update the sells counter value
    getCounterValue('{{ route("sells_counter") }}', 'sells-counter-value');

    // Call the rents_counter route and update the rents counter value
    getCounterValue('{{ route("rents_counter") }}', 'rents-counter-value');
</script>
</body>
</html>
