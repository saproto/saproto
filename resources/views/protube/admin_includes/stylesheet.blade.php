@section('stylesheet')

    @parent

    <style>

        #connected {
            display: none;
        }

        .slider.slider-horizontal {
            width: 100%;
        }

        .video:nth-child(even) {
            background-color: #eee;
        }

        #showVideo:hover {
            background-color: #e9ecef !important;
            border-color: #ced4da !important;
            color: #495057 !important;
        }

        #showVideo.active:hover {
            background-color: #007d8d !important;
            border-color: #007280 !important;
            color: #fff !important;
        }

    </style>
@endsection