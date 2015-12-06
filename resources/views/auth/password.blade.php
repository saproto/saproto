@extends('website/default/container')

@section('container')

    <form method="POST" action="{{ route('login::resetpass') }}">

        {!! csrf_field() !!}

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <script type="text/javascript">
                    Materialize.toast('{{ $error }}', 3000, 'rounded')
                </script>
            @endforeach
        @endif

        <div class="row">

            <div class="grey-text lighten-5 input-field col offset-l3 l6 m12 s12">
                <input id="username" name="email" type="text" class="validate">
                <label for="username">Username</label>
            </div>

        </div>

        <div class="row">

            <div class="col offset-l1 l6 m12 s12">
                <button type="submit" class="waves-effect waves-light btn light-green right"><i class="fa fa-send right"></i>send request</button>
            </div>

        </div>

    </form>

@endsection