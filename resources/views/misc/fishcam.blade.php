@extends('website.layouts.redesign.generic')

@section('page-title')
    The FishCam&trade;
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-12" style="height: 480px;">

            <img class="d-none h-100" id="fishcam">

            <div id="fishcam-warning" class="card mb-3">

                <div class="card-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2" aria-hidden="true"></i> Warning | Please don't
                    load this stream over a mobile connection.
                </div>

                <div class="card-body">
                    <div class="card-text">
                        The fishcam stream is of very high quality, and streams with roughly 0.5 MB/s. If you have a 1
                        gigabyte
                        data plan, you will use it up completely over the course of half an hour.
                    </div>
                </div>

                <div class="card-footer">
                    <button href="#" id="fishcam__activate" class="btn btn-warning btn-block">
                        <i class="fas fa-fish me-2"></i> I understand, start the fishcam anyway!
                    </button>
                </div>

            </div>

        </div>

    </div>

@endsection

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        const fishcam = document.getElementById("fishcam")
        document.getElementById("fishcam__activate").addEventListener('click', () => {
            fishcam.setAttribute('src', '{{ route("api::fishcam") }}')
            document.getElementById('fishcam-warning').classList.add('d-none')
            fishcam.classList.remove('d-none')
        })
    </script>

@endpush