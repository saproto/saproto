<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <meta name="theme-color" content="#C1FF00">

    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Ticket Scanner for {{ $event->title }}"/>

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon'.mt_rand(1, 4).'.png') }}"/>

    <title>Ticket Scanner for {{ $event->title }}</title>

    @include('website.layouts.assets.stylesheets')

    <style type="text/css">

        * {
            box-sizing: border-box;
        }

        html, body {
            font-family: Lato, sans-serif;

            padding: 20px;

            background-color: #555;
        }

        .title {
            margin-top: 30px;
            font-size: 30px;
            color: #fff;
            text-align: center;
        }

        #scanner-field, #feedback-field {
            margin-top: 30px;
            padding-top: 20px;
            padding-bottom: 20px;

            font-size: 30px;
            width: 100%;

            border: none;

            text-align: center;
            background-color: #555;
            color: #fff;

            display: block;

            outline: none !important;
        }

        .blinker {
            animation: blinker 2s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        #flash {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #555;
            display: none;
        }

        .history th, .history td {
            color: #fff !important;
        }

        .history tr:first-child {
            font-weight: bold;
        }

        .history tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

    </style>

    <script>


    </script>

</head>

<body>

<div class="container-fluid">

    <p class="title">
        Ticket Scanner for {{ $event->title }}
    </p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <input type="text" id="scanner-field" onblur="javascript:focus();"
                   onsubmit="javascript:scan();">
        </div>
    </div>

    <p id="feedback-field" class="blinker">
        Waiting for input...
    </p>

    <hr>

    <table class="table history">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Ticket</th>
            <th>Scanned</th>
            <th>Valid</th>
        </tr>
        </thead>
        <tbody id="history">

        </tbody>
    </table>

</div>

<div id="flash">

</div>

@section('javascript')
    @include('website.layouts.assets.javascripts')
@show

<script type="text/javascript">

    var barcodetimeout;

    $(document).ready(function () {
        focus();
        $("#scanner-field").on('keyup', function (e) {
            clearTimeout(barcodetimeout);
            barcodetimeout = setTimeout(scan, 100);
        });
    });

    function setStatus(s) {

        switch (s) {

            case "got":
                $("#scanner-field").prop('disabled', true);
                $("#feedback-field").addClass('blinker').html("Validating barcode...");
                break;

            case "error":
                $("#scanner-field").prop('disabled', false);
                $("#feedback-field").removeClass('blinker').html("Something went wrong. Try again!");
                flash('#ff0000');
                setTimeout(setStatus, 1000);
                break;

            case "ok":
                $("#feedback-field").removeClass('blinker').html("Valid ticket!");
                flash('#c1ff00');
                setTimeout(setStatus, 1000);
                break;

            default:
                $("#scanner-field").prop('disabled', false);
                $("#feedback-field").addClass('blinker').html("Waiting for input...");
                focus();
                break;

        }

    }

    function focus() {
        $("#scanner-field").focus();
    }

    function flash(color) {
        $("#flash").css('background-color', color).css("opacity", 0.5).show().fadeOut(1000);
    }

    function scan() {
        var barcode = $("#scanner-field").val();
        if (barcode === "") return;

        setStatus("got");

        $.ajax({
            url: '{{ route('api::scan', ['event' => $event->id]) }}',
            data: {
                'barcode': barcode
            },
            dataType: 'json',
            success: function (data) {
                parseReply(data);
            },
            error: function () {
                setStatus('error');
            }
        })

        $("#scanner-field").val("");
    }

    function parseReply(data) {
        switch (data.code) {

            case 500:
                flash('#ff0000');
                $("#feedback-field").removeClass('blinker').html(data.message);
                setTimeout(setStatus, 1000);
                break;

            case 403:
                flash('orange');
                $("#feedback-field").removeClass('blinker').html(data.message);
                setTimeout(setStatus, 1000);
                $("#history").prepend("<tr>" +
                    "<td>" + data.data.id + "</td>" +
                    "<td>" + data.data.user.name + "</td>" +
                    "<td>" + data.data.ticket.product.name + "</td>" +
                    "<td>" + timeNow() + "</td>" +
                    "<td><span style='color: orange;'>Used on " + data.data.scanned + "</span></td>" +
                    "</tr>");
                break;

            case 200:
                setStatus('ok');
                $("#history").prepend("<tr>" +
                    "<td>" + data.data.id + "</td>" +
                    "<td>" + data.data.user.name + "</td>" +
                    "<td>" + data.data.ticket.product.name + "</td>" +
                    "<td>" + timeNow() + "</td>" +
                    "<td><span style='color: #c1ff00;'>Valid</span></td>" +
                    "</tr>");
                break;
        }
    }

    function timeNow() {

        var d = new Date();

        return ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2) + ":" + ("0" + d.getSeconds()).slice(-2);

    }

</script>

</body>

</html>
