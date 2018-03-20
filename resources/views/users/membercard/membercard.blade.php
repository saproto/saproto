<html>
<head>
    <link rel="stylesheet" type="text/css"
          href="http://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    <style type="text/css">
        html, body {
            margin: 0px;
            padding: 0px;
        }

        #card {
            position: relative;

            width: 100%;
            height: 100%;

            font-family: 'Lato', Arial, sans-serif;
        }

        #name {
            font-size: 17px;

            overflow: hidden;

            font-weight: bold;
        }

        #power-icons {
            position: absolute;

            top: 20.4%;
            right: 1.2%;
            width: 4.1%;
            height: 55.6%;

            text-align: center;

            font-size: 13px;
        }

        #power-icons i:nth-child(1) {
            margin-top: 2.2%;
        }

        #power-icons i {
            margin-bottom: 2.2%;
        }

        #details {
            position: absolute;

            top: 28.7%;
            left: 5.8%;
            width: 58.1%;

            color: #000;

            font-size: 13px;
        }

        #details .heading {
            color: #aaa;

            text-transform: uppercase;
            font-size: 10px;

            margin-top: 3.7%;
        }

        #photo {
            position: absolute;

            top: 20.4%;
            right: 5.8%;
            width: 26.5%;
            height: 55.6%;
        }

        #barcode {
            position: absolute;

            bottom: 19%;
            left: 5.8%;
            width: 40.7%;
            height: 9.3%;
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