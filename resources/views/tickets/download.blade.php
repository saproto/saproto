<html>
<head>

    <style type="text/css">

        * {
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: 100%;
            font-family: Arial;
            margin: 0 auto;
        }

        .half {
            position: absolute;

            left: 10%;
            right: 10%;

            height: 49%;
            margin: 0;

            text-align: center;
        }

        #half1 {
            top: 0;
            border-bottom: 3px dashed #000000;
        }

        #half2 {
            bottom: 0;
            padding-top: 45mm;
        }

        p {
            margin: 40px auto;
        }

        h3 {
            margin-bottom: -20px;
        }

        .barcode {
            width: 75mm;
            height: 10mm;
        }

        #barcode1 {
            margin-top: 5mm;
            margin-bottom: 7mm;
        }

        #barcode2 {
            margin-top: 5mm;
        }

        #protologo {
            width: 40%;
        }

    </style>

</head>
<body>

<div id="half1" class="half">

    <p>
        <img id="barcode1" class="barcode"
             src="data:image/png;base64,{!! DNS1D::getBarcodePNG($ticket->barcode, "CODABAR") !!}">
    </p>

    <h3>{{ $ticket->ticket->product->name }}</h3>
    <p>
        for the <strong>{{ $ticket->ticket->event->title }}</strong>
        @if($ticket->ticket->event->committee)
            <br>
            <sub>
                organized by the <strong>{{ $ticket->ticket->event->committee->name }}</strong>
            </sub>
        @endif
    </p>

    <p></p>

    <p>
        <strong>{{ $ticket->user->name }}</strong>
        <br>
        {{ $ticket->user->getDisplayEmail() }}
    </p>

    <p>
        <sub>#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</sub>
    </p>

    <p>
        <img id="barcode2" class="barcode"
             src="data:image/png;base64,{!! DNS1D::getBarcodePNG($ticket->barcode, "CODABAR") !!}">
    </p>

    <p>
        <sup>
            Please <strong>print</strong> this ticket and take it with you to the event. Scanning from mobile phones may
            work but is not supported. If you want to show this ticket on your mobile phone, turn up the brightness of
            your screen to the maximum possible.
        </sup>
    </p>

</div>

<div id="half2" class="half">

    <img src="{{ str_replace('https','http',asset('images/logo/regular.png')) }}" id="protologo">

    <p>
        <sub>
            the ticketing system is proudly presented to you by the<br>
            <strong>Have You Tried Turning It Off And On Again committee</strong>
        </sub>
    </p>

</div>

</body>
</html>