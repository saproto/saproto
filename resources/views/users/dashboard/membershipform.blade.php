@extends('website.layouts.redesign.generic')

@section('page-title')
    Sign membership contract
@endsection

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        let signatureAlert = $('#signature-alert');
        let canvas = document.getElementById('signature-pad');
        let signaturePad = new SignaturePad.default(canvas);

        window.onresize = resizeCanvas;
        resizeCanvas();

        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            let ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }

        $('#clear').on('click', function() {
            signaturePad.clear();
        });

        $('#signature-form').on('submit', function(e) {
            if (signaturePad.isEmpty()) {
                e.preventDefault();
                signatureAlert.removeClass('d-none');
            } else {
                $('#signature').val(signaturePad.toDataURL('image/png'));
            }
        });
    </script>
@endpush

@section('container')

    <div class="row justify-content-center">

        <div class="col-lg-6 col-md-7" style="max-width: 600px">

                <div class="card mb-3">

                    <div class="card-header bg-dark text-white">@yield('page-title')</div>

                    <div class="card-body">
                        @include('users.includes.membershipform_include')

                        <b>Signature:</b>
                        <div class="wrapper">
                            <canvas id="signature-pad"></canvas>
                            <button id="clear" class="btn btn-danger position-absolute m-2 px-2 py-1">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div id="signature-alert" class="alert alert-danger text-center d-none p-1 my-2 mx-4" role="alert">
                            We need your signature for the membership contract to be valid!
                        </div>

                        <p>
                            {{ $user->name }} <br>
                            Enschede, {{ date('M, d, Y', strtotime('today')) }}
                        </p>

                        <form id="signature-form" method="POST" action="{{ route('memberform::sign') }}">
                            @csrf
                            <input type="hidden" id="signature" name="signature"/>
                            <input type="submit" class="btn btn-info">
                        </form>
                    </div>

                </div>

        </div>

    </div>

@endsection
