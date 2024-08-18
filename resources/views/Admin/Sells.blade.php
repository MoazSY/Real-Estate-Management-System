<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sells Page</title>
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
            margin-left: 500px;
            margin-top: -70px;

        }

        h3 {
            font-size: 30px;
            margin-bottom: 30px;
            color: #000000;
            margin-left: 50px;
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
        #sells-counter-value {
            margin-left: 15px;
            color: #000000;
            font-weight: bold; /* Make the text bold */

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
            margin-left: -100px;

        }
        /*.details2 {*/

        /*    border: 1px solid #D0C9C0;*/
        /*    border-radius: 20px;*/

        /*    padding: 20px;*/
        /*    background-color: #ffffff;*/
        /*    font-size: 20px;*/
        /*    margin-bottom: 10px;*/
        /*    color: #333;*/
        /*    width: 200px;*/
        /*    hight:50px;*/
        /*    margin-left: -10px;*/
        /*    margin-top: -30px;*/

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
        <div class="details1">
            <h2>Sells</h2>

            <div id="sell-details"></div>
        </div>
    </div>
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
    </script>
</body>
</html>
