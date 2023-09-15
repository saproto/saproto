@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Actual membership totals
@endsection

@section('container')
    <div style="position: relative; height:90vh; width:95vw; margin-left:auto">
        <canvas id="chart"></canvas>
    </div>
@endsection

@push('javascript')
    {{--    chart.js and the date adapter--}}
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script nonce="{{ csp_nonce() }}"
            src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

    <script type='text/javascript' nonce='{{ csp_nonce() }}'>

        const ctx = document.getElementById('chart');
        var chart = null;
        var data = {!! json_encode($events->toArray(), JSON_HEX_TAG) !!};

        console.log(data)

        function createDataSets(data){
            console.log(data[0])
            let myData = {
                datasets: [],
            };
            console.log(typeof(data))
            Object.values(data).forEach(product => {
                let prices = [];
                product.forEach((item) => {
                    date=new Date((item.Start) * 1000)
                    date=date.setFullYear(date.getFullYear(), date.getMonth(), 1);
                    prices.push({
                        x: date,
                        y: item.Total,
                    })
                })
                console.log(product)
                myData.datasets.push({label: product[0].Board, data: prices})
            });
            console.log(myData)
            return myData;
        }

        console.log("creating chart")

        chart = new Chart(ctx, {
            type: "line",
            options: {
                offset: true,
                spanGaps: true,
                scales: {
                    x: {
                        type: "time",
                        time: {
                            unit: "month",
                            // displayFormats: {
                            //     month: "MMM",
                            // },
                        },
                        parsing: false
                    }
                },
                responsive:true,
            },
            data: createDataSets(data),
        });
    </script>
@endpush