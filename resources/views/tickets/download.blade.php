<html>
<head>

    <style type="text/css">

        * {
            box-sizing: border-box;
        }

        body {
            width: 210mm;
            height: 297mm;
            font-family: Arial;
            margin: 0;

            text-align: center;
        }

        p {
            margin: 40px auto;
        }

        h3 {
            margin-bottom: -20px;
        }

        #barcode {
            width: 125mm;
            height: 10mm;
            margin-bottom: 40px;
        }

        #protologo {
            width: 40%;
        }

    </style>

</head>
<body>

<p>
    <img id="barcode" src="data:image/png;base64,{!! DNS1D::getBarcodePNG($ticket->barcode, "CODABAR") !!}">
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
    {{ $ticket->user->email }}
</p>

<p>
    <sub>#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</sub>
</p>

<p style="margin-top: 100mm;"></p>

<img src="{{ asset('images/logo/regular.png') }}" id="protologo">

<p>
    <sub>
        the ticketing system is proudly presented to you by the<br>
        <strong>Have You Tried Turning It Off And On Again committee</strong>
    </sub>
</p>

</body>
</html>