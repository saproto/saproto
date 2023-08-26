@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Wallsteet drink chart!
@endsection

@section('container')
<div style="position: relative; height:90vh; width:95vw; margin-left:auto">
<canvas id="myChart"></canvas>
</div>
@endsection

@push('javascript')
{{--    chart.js and the date adapter--}}
<script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<script nonce="{{ csp_nonce() }}">
    const ctx = document.getElementById('myChart');
    var chart=null;

    function createDataSets(products){
        let myData = {
            datasets: [],
        };
        products.forEach((product) => {
            let prices = [];
            product.wallstreet_prices.forEach((price) => {
                prices.push({
                    x: Date.parse(price.created_at),
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

    window.addEventListener('load', _ => {
        get(`{{route('api::wallstreet::all_prices', ['id'=>$id])}}`).then((products) => {
            console.log("creating chart")

            chart = new Chart(ctx, {
                type: "line",
                options: {
                    spanGaps: true,
                    scales: {
                        x: {
                            type: "time",
                            parsing: false
                        }
                    },
                    responsive:true,
                },
                data: createDataSets(products),
            });
        });

        updateChart();
        setInterval(updateChart, 30000);
    })

</script>
@endpush