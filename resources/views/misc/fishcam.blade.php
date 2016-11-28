@extends('website.layouts.default-nobg')

@section('page-title')
    The FishCam&trade;
@endsection

@section('content')

    <div id="fishcam">

        <p style="font-size: 90px; text-align: center;">
            <i id="fishcam__activate" class="fa fa-exclamation-triangle" aria-hidden="true"></i>
        </p>

        <p>
            <strong>Warning</strong>
            The fishcam stream is of very high quality, and streams with roughly 0.5 MB/s.
            <strong>Please don't load this page over a mobile connection.</strong>
            Seriously.
            If you have a 1 gigabyte data plan, you will use it up completely over the course of half an hour.
            Please click the exclamation mark to start the stream.
        </p>

    </div>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        $("#fishcam__activate").click(function () {

            $("#fishcam").css('background-image', 'url(\'{{ env('FISHCAM_URL') }}\')').html('');

        });

    </script>

@endsection