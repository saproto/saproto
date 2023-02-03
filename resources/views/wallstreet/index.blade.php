<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link rel="shortcut icon" href="{{ asset('images/favicons/favicon1.png') }}"/>

    <title>Wallstreet drink chart!</title>
</head>
<body>
    <div>
    <canvas id="myChart"></canvas>
</div>
</body>

@include('website.layouts.assets.javascripts')
@stack('javascript')
<script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script nonce="{{ csp_nonce() }}">
    get('/api/wallstreet/drink/' + {{$id}}, function (data) {
            console.log(data)
    })

    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
