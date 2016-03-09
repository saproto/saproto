@extends('website/default/container')

@section('container')

    <div class="col-md-4 col-md-offset-4">

        <h1>
            @section('errornumber')
                000
            @show
             ::
            @section('errorshort')
                WTF???
            @show
        </h1>

        @section('errormessage')
            This is a generic error.
        @show

    </div>

@endsection