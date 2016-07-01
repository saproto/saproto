<html>
<head>
    <style type="text/css">
        html, body {
            margin: 0px;
            padding: 0px;
        }

        #card {
            position: relative;

            width: 86mm;
            height: 52mm;

            font-family: Arial, sans-serif;
        }

        #name {
            font-size: 13px;

            overflow: hidden;

            font-weight: bold;
        }

        #details {
            position: absolute;

            top: 15.5mm;
            left: 5mm;
            width: 50mm;

            color: #000;

            font-size: 9px;
        }

        #details .heading {
            color: #aaa;

            text-transform: uppercase;
            font-size: 7px;

            margin-top: 2mm;
        }

        #photo {
            position: absolute;

            top: 11mm;
            right: 5mm;
            width: 22.5mm;
            height: 30mm;
        }

        #barcode {
            position: absolute;

            bottom: 8.5mm;
            left: 5mm;
            width: 35mm;
            height: 5mm;
        }
    </style>
</head>
<body>
<div id="card">
    <div id="details">
        <div id="name">{{ $user->name }}</div>
        <div class="heading">Member since</div>
        <div>{{ ($user->member->created_at->timestamp < 0 ? 'Before we kept track!' : date('F j, Y', strtotime($user->member->created_at))) }}</div>
        <div class="heading">Card validity</div>
        <div>{{ date('M Y') }} - {{ date('M Y', strtotime('+2 years')) }}</div>
    </div>
    <img id="photo" src="data:{{ $user->photo->mime }};base64,{{ $user->photo->getBase64(450,600) }}">
    <img id="barcode" src="data:image/png;base64,{!! DNS1D::getBarcodePNG($user->id, "CODABAR", 500) !!}">
</div>
</body>
</html>