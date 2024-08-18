<!DOCTYPE html>
<html>
<head>
    <title>Property Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
            background-color: #ffffff;
        }

        h1 {
            color: #000000;
            text-align: left;
        }

        .property-details-container {
            margin-top: 20px;
            margin-bottom: 20px;
            background-color: #E1EBEE  ;
            border: 1px solid #ffffff;

            border-radius: 30px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #333;
            max-width: 1000px;
            margin: 0 auto; /* Center the container horizontally */
        }

        .property-details p {
            margin: 10px 0;
            line-height: 1.5;
            color: darkslategrey;
            /*font-style: italic;*/
            font-size: 20px;
        }

        .property-section-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #000000;
            text-align: left;
        }

        .property-images-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .property-images-container img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .property-video {
            width: 100%;
            margin-top: 20px;
            border-radius: 4px;
        }
        .form-container {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }


        .btn-primary{
            background-color: #5D8AA8;
            border-color: #5D8AA8;
            color: white;
        }
        .btn-primary:hover {
            background-color: #d4edda;
            border-color: #5D8AA8;
            color: #000;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="property-details-container">
        <h1>Property Details</h1>

        <div class="property-details">
            <p>Owner Name: {{ $details[1] }}</p>
            <p>Location: {{ $details[3] }}</p>
            <p>State: {{ $details[4] }}</p>
            <p>Type Of Property: {{ $details[0]->typeofproperty }}</p>
            <p>Sell Or Rent: {{ $details[0]->rent_or_sell }}</p>
            <p>Number Of Rooms: {{ $details[0]->numberofRooms }}</p>
            <p>Description: {{ $details[0]->descreption }}</p>
            <p>Price: {{ $details[0]->price }}</p>
            <p>Monthly Rent: {{ $details[0]->monthlyRent }}</p>
            <div class="form-container">
            <form action="{{ route('getuser', $details[0]->id) }}" method="GET">
                <button type="submit" class="btn btn-primary">Show Owner</button>
            </form>
            <form action="{{ route('delete_property', $details[0]->id) }}" method="GET">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            </div>

        </div>
        <h2 class="property-section-title">Property Images</h2>

        <div class="property-images-container">

            @if (is_array($details[0]->image))
                @foreach ($details[0]->image as $imageUrl)
                    <img src="{{ asset(trim($imageUrl)) }}" alt="Property Image">
                @endforeach
            @else
                @php
                    $imageUrls = explode(',', $details[0]->image);
                @endphp

            <!-- Loop through the array of URLs to display the images -->
                @foreach ($imageUrls as $imageUrl)
                    <img src="{{ asset(trim($imageUrl)) }}" alt="Property Image">
                @endforeach
            @endif
        </div>
        <h2 class="property-section-title">Property Video</h2>

        <video controls class="property-video">
            <source src="{{ asset($details[0]->video) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
