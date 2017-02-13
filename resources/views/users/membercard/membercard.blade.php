<html>
<head>
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
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

        #power-icons {
            position: absolute;

            top: 11mm;
            right: 1.0mm;
            width: 3.5mm;
            height: 30mm;

            text-align: center;

            font-size: 11px;
        }

        #power-icons i:nth-child(1) {
            margin-top: 1.2mm;
        }

        #power-icons i {
            margin-bottom: 1.2mm;
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
    @if(!$overlayonly)
        <div id="details">
            <div id="name">{{ $user->name }}</div>
            <div class="heading">Member since</div>
            <div>{{ ($user->member->created_at->timestamp < 0 ? 'Before we kept track!' : date('F j, Y', strtotime($user->member->created_at))) }}</div>
            <div class="heading">Card validity</div>
            <div>{{ date('M Y') }} - {{ date('M Y', strtotime('+3 years')) }}</div>
        </div>
        @if($user->photo)
            <img id="photo" src="data:{{ $user->photo->mime }};base64,{{ $user->photo->getBase64(450,600) }}">
        @endif
        <img id="barcode" src="data:image/png;base64,{!! DNS1D::getBarcodePNG($user->id, "CODABAR", 500) !!}">
    @endif
    <div id="power-icons">
        @if($user->isInCommitteeBySlug('protopeners'))
            <i class="fa fa-unlock-alt" aria-hidden="true"></i><br>
        @endif
    </div>
</div>
</body>
</html>