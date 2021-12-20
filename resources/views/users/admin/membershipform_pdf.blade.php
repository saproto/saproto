<html lang="en">
<head>
    <title>S.A. Proto Membership Contract</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        * { box-sizing: border-box; }

        body {
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
            padding: 60px 80px;
        }

        h2 { margin-bottom: 60px; }

        p {
            margin: 40px auto;
            font-size: 16px;
        }
    </style>

</head>
<body>

@include('users.includes.membershipform_include')

<div style="height: 30mm;">
    <p style="margin-bottom: 0">Signature:</p>
    @if ($signature)
        <img src="{{ $signature }}" alt="signature" height="150">
    @endif
</div>

<p>
    <strong>{{ $user->name }}</strong><br>
    Enschede, {{ date('F j, Y') }}
</p>

</body>
</html>