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

            <h1 class="mt-5 mb-5" style="font-size: 60px;">Is Alfred There?</h1>

            <h1 class="mt-5 mb-5" data-countdown-text-counting="Nope. Alfred will be back in {}."
                data-countdown-text-finished="Alfred should be there. 👀" id="alfred-text">
                We're currently looking for Alfred, please stand by...
            </h1>
            <h4 id="alfred-actualtime"></h4>

            <h1 class="mt-5 mb-5" id="alfred-emoji" style="font-size: 120px;">🤔</h1>

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
            const text = document.getElementById('alfred-text')
            const time = document.getElementById('alfred-actualtime')
            const emoji = document.getElementById('alfred-emoji')
            window.axios.get('{{ config('app-proto.primary-domain') }}{{ route('api::isalfredthere', [], false) }}')
                .then(res => {
                    const data = res.data
                    switch(data.status) {
                        case('there'):
                            text.classList.remove('proto-countdown')
                            text.innerHTML = 'Alfred is there!'
                            time.innerHTML = ''
                            time.classList.add('d-none')
                            emoji.innerHTML = '🎉😁'
                            document.body.classList.add('bg-success')
                        break
                        case('unknown'):
                            text.classList.remove('proto-countdown')
                            text.innerHTML = "We couldn't find Alfred..."
                            time.innerHTML = ''
                            time.classList.add('d-none')
                            emoji.innerHTML = '👀'
                            document.body.classList.add('bg-warning')
                        break
                        case('away'):
                            text.classList.add('proto-countdown')
                            text.setAttribute('data-countdown-start', data.backunix)
                            time.innerHTML = `That would be ${data.back}.`
                            time.classList.remove('d-none')
                            emoji.innerHTML = '😞🕓'
                            document.body.classList.add('bg-danger')
                            if (! alfredCountdownStarted) {
                                initializeCountdowns()
                                alfredCountdownStarted = true
                            }
                        break
                    }
                })
                .catch(error => {
                    console.error(error)
                    text.innerHTML = "We couldn't find Alfred..."
                    emoji.innerHTML = '👀'
                    document.body.classList.add('bg-warning')
                })
        }
    </script>

@endpush