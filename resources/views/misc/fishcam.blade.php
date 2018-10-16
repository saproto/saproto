@extends('website.layouts.redesign.generic-sidebar')

@section('page-title')
    The FishCam&trade;
@endsection

@section('container')

    <div class="row justify-content-center">

    <div class="card" id="fishcam" style="width: 640px; height: 480px;">

        <div class="card-header bg-danger text-white">
            <i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i> Warning | Please don't
            load this page over a mobile connection.
        </div>

        <div class="card-body">

            <div class="card-text">
                The fishcam stream is of very high quality, and streams with roughly 0.5 MB/s. If you have a 1 gigabyte
                data plan, you will use it up completely over the course of half an hour.
            </div>

        </div>

        <div class="card-footer">

            <button href="#" id="fishcam__activate" class="btn btn-danger btn-block">
                <i class="fas fa-fish mr-2"></i> I understand, start the fishcam anyway!
            </button>

        </div>

    </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        $("#fishcam__activate").click(function () {

            $("#fishcam").css('background-image', 'url(\'{{ route('api::fishcam') }}\')').html('');

        });

    </script>

@endsection