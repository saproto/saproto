@extends('website.layouts.redesign.generic-nonavandfooter')

@section('page-title')
    Is Alfred There?
@endsection

@push('head')
    <meta http-equiv="refresh" content="86400">
@endpush

@section('container')

    <div class="row text-white">

        <div class="col-md-12 text-center">

            <h1 class="mt-3 mb-3" style="font-size: 70px;">Is Alfred There?</h1>

            <h1 class="mt-3 mb-3 proto-countdown"  style="font-size: 50px;"data-countdown-text-counting="Nope. Alfred will be back in {}."
                data-countdown-text-finished="Alfred should be there. 👀" id="alfred-status">
                We're currently looking for Alfred, please stand by...
            </h1>
            <h4 id="alfred-actualtime"></h4>
            <h1 id="alfred-text"></h1>
            <h1 class="mt-5 mb-5" id="alfred-emoji" style="font-size: 120px;"><i class="fas fa-circle-question"></i></h1>

            <a href="//{{ config('app-proto.primary-domain') }}{{ route('homepage', [], false) }}">
                <img src="{{ asset('images/logo/inverse.png') }}" alt="Proto logo" height="120px">
            </a>

        </div>

    </div>

@endsection

@push('stylesheet')

    <style rel="stylesheet">
        body { background-color: var(--bs-warning); }
        main { border: none !important; }
    </style>

@endpush

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        let alfredCountdownStarted = false;

        lookForAlfred();
        setInterval(lookForAlfred, 60000);

        function lookForAlfred() {
            const status = document.getElementById('alfred-status')
            const text = document.getElementById('alfred-text')
            const time = document.getElementById('alfred-actualtime')
            const emoji = document.getElementById('alfred-emoji')
            get("{{route('api::isalfredthere')}}")
            .then(data => {
                console.log(data)
                if(data.text.length>0) {
                    text.innerHTML = '"'.concat(data.text, '"')
                }
                switch(data.status) {
                    case('there'):
                        status.classList.remove('proto-countdown')
                        status.innerHTML = 'Alfred is there!'
                        time.innerHTML = ''
                        time.classList.add('d-none')
                        emoji.innerHTML = '<i class="far fa-smile-beam"></i>'
                        document.body.classList.add('bg-success')
                    break
                    case('unknown'):
                        status.classList.remove('proto-countdown')
                        status.innerHTML = "We couldn't find Alfred..."
                        time.innerHTML = ''
                        time.classList.add('d-none')
                        emoji.innerHTML = '<i class="fas fa-binoculars"></i>'
                        document.body.classList.add('bg-warning')
                    break
                    case('away'):
                        time.innerHTML = `That would be ${data.back}.`
                        time.classList.remove('d-none')
                        emoji.innerHTML = '<i class="far fa-grimace"></i><i class="far fa-clock"></i>'
                        document.body.classList.add('bg-danger')
                            status.setAttribute('data-countdown-start', data.backunix)
                            window.timerList.forEach((timer)=>{
                                timer.start()
                            })
                    break
                }
            })
            .catch(error => {
                console.error(error)
                status.innerHTML = "We couldn't find Alfred..."
                emoji.innerHTML = '<i class="fas fa-triangle-exclamation"></i>'
                document.body.classList.add('bg-warning')
            })
        }
</script>
@endpush