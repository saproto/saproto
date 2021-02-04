@extends('website.layouts.redesign.generic')

@section('page-title')
    The FishCam&trade;
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-12" style="max-width: 640px; max-height: 480px;">

            <div class="card mb-3">

                <div class="card-header bg-danger text-white fishcam-warning">
                    <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i> Warning | Please don't
                    load this stream over a mobile connection.
                </div>

                <img class="card-img-top card-img-bottom" style="display: none;" id="fishcam">

                <div class="card-body fishcam-warning">

                    <div class="card-text">
                        The fishcam stream is of very high quality, and streams with roughly 0.5 MB/s. If you have a 1
                        gigabyte
                        data plan, you will use it up completely over the course of half an hour.
                    </div>

                </div>

                <div class="card-footer fishcam-warning">

                    <button href="#" id="fishcam__activate" class="btn btn-warning btn-block">
                        <i class="fas fa-fish mr-2"></i> I understand, start the fishcam anyway!
                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection

@push('javascript')
    <script type="text/javascript">

        $("#fishcam__activate").click(function () {

            $("#fishcam").attr('src', '{{ route("api::fishcam") }}').show();
            $(".fishcam-warning").hide();

        });

    </script>

@endpush