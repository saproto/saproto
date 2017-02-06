<html>
<head>
    <title>Participant checklist for {{ $event->title }}</title>
    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 1em;
        }
    </style>
</head>

<body>

<h1>Participant checklist for {{ $event->title }}</h1>

<table width="100%">
@foreach($event->activity->users as $user)
    <tr>
        <td width="25px"><input type="checkbox"></td>
        <td>{{ $user->name }}</td>
    </tr>
@endforeach
</table>

</body>

</html>