<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports</title>

    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        /* Custom CSS styles */
        body{
            margin-top: 100px;

            background-color: #f8f9fa;
        }
        .report-card {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .report-reason {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .report-link {
            display: block;
            margin-top: 10px;
            color: #ffffff;
            text-decoration: none;
            margin-left: 20px;
            display: inline-block;
            background-color: #8DA399   ; /* Set your desired background color */
            padding: 5px 10px; /* Set your desired padding */
            border-radius: 5px;

        }

        .report-card {
            /* Add your desired styles here to make the card smaller */
            width: 500px;
            height: 100px;
            /* Additional styles like padding, margin, etc. */
        }
    </style>
</head>
<body class="antialiased">
<div id="reports" class="container">
    <h3>Reports</h3>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ route('getreports') }}')
            .then(response => response.json())
            .then(data => {
                console.log(data)
                const reports = data.reports;
                console.log(data.reports)
                let reportsdetails = document.getElementById('reports');

                reports.forEach(report => {
                    let reportElement = document.createElement('div');
                    reportElement.className = 'report-card';

                    let html = '';
                    html += `<p class="report-reason">Report Reason: ${report['reason']}</p>`;
                    if(report['property'])
                    {html += `<a class="report-link" href="{{ route('getpropertybyId', '') }}/${report['property'].id}">Reported Property</a>`;
                    {{--html += `<a class="report-link" href="{{ route('getuser', '') }}/${report['owner'].id}">Property Owner</a>`;--}}
                    }
                    if(report['user'])
                    {
                        html += `<a class="report-link" href="{{ route('getuser', '') }}/${report['user'].id}">Reported User</a>`;

                    }
                    html += `<a class="report-link" href="{{ route('getuser', '') }}/${report['reporter'].id}">Reporter</a>`;

                    reportElement.innerHTML = html;
                    reportsdetails.appendChild(reportElement);
                });
            })
            .catch(error => console.error(error));
    });
</script>

<!-- Add Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

