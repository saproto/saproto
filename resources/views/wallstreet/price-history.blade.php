@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Wallsteet drink chart!
@endsection

@section('container')
<div class="mh-100 d-flex justify-content-center">
<canvas id="myChart"></canvas>
</div>
@endsection

@push('javascript')
<script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script nonce="{{ csp_nonce() }}">
    const ctx = document.getElementById('myChart');
    var chart=null;

    get(`{{route('api::wallstreet::all_prices', ['id'=>$id])}}`).then((products) => {
        console.log("creating chart")

        chart = new Chart(ctx, {
            type: 'line',
            data: createDataSets(products),
            scales: {
                x: {
                    stacked: true
                },
            },
            plugins: {
                filler: {
                    propagate: false
                },
                'samples-filler-analyser': {
                    target: 'chart-analyser'
                }
            },
            interaction: {
                intersect: false,
            },
        });
    })

    function createDataSets(products){
        let myData = {
            datasets: [],
        };
        products.forEach((product) => {
            let prices = [];
            product.wallstreet_prices.forEach((price) => {
                prices.push({
                    x: `${new Date(Date.parse(price.created_at)).getHours()}:${new Date(Date.parse(price.created_at)).getMinutes()}`,
                    y: price.price
                })
            });
            myData.datasets.push({label: product.name, data: prices})
        });
        return myData;
    }

    function updateChart(){
        get(`{{route('api::wallstreet::all_prices', ['id'=>$id])}}`).then((products) => {
            console.log("updating chart")
            console.log(products)
            chart.data = createDataSets(products);
            chart.update('none');
        })
    }

    updateChart();
    setInterval(updateChart, 30000);
</script>
@endpush