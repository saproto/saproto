<link rel="stylesheet" href="{{ asset('assets/application.min.css') }}">

@if(!$app->environment('production'))
    <style type="text/css">
        #wrap {
            background-image: repeating-linear-gradient(-45deg, transparent, transparent 25px, #222 25px, #222 50px);
        }
    </style>
@endif