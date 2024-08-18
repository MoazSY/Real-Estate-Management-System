<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complaints</title>

    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body{
            margin-top: 100px;
        }
        .complaint-card {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;

        }

        .complaint {
            font-weight: bold;
            margin-bottom: 5px;
            flex: 1;

        }

        .complainer-link {
            display:block;
            margin-top: 0px;
            color: #ffffff;
            text-decoration: none;
            margin-left: 20px;
            display: inline-block;
            background-color: #8DA399   ; /* Set your desired background color */
            padding: 5px 10px; /* Set your desired padding */
            border-radius: 5px;
            position: absolute;
            left: 300px;

        }
        .complaint-card {
            /* Add your desired styles here to make the card smaller */
            width: 500px;
            height: 100px;
            display: flex;
            align-items: center;
            /* Additional styles like padding, margin, etc. */
        }




    </style>
</head>
<body class="antialiased">
<div id="complaints" class="container">
    <h3>Complaints</h3>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ route('getcomplaints') }}')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const complaints = data.complaints;
                console.log(data.complaints);
                let complaintsdetails = document.getElementById('complaints');

                complaints.forEach(complaint => {
                    let complaintElement = document.createElement('div');
                    complaintElement.className = 'complaint-card';

                    let html = '';
                    html += `<p class="complaint">Complaint: ${complaint['complain']}</p>`;
                    html += `<a class="complainer-link" href="{{ route('getuser', '') }}/${complaint['user'].id}">User</a>`;

                    complaintElement.innerHTML = html;
                    complaintsdetails.appendChild(complaintElement);
                });
            })
            .catch(error => console.error(error));
    });
</script>

<!-- Add Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
