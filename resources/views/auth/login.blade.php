@extends('website/default/container')

@section('container')

    <form method="POST" action="{{ route('login::show') }}">

        {!! csrf_field() !!}

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <script type="text/javascript">
                    Materialize.toast('{{ $error }}', 3000, 'rounded')
                </script>
            @endforeach
        @endif

        <div class="row">

            <div class="grey-text lighten-5 input-field col l6 offset-l3 m12 s12">
                <input id="username" name="email" type="text" class="validate">
                <label for="username">Username</label>
            </div>

        </div>

        <div class="row">

            <div class="grey-text lighten-5 input-field col l6 offset-l3 m12 s12">
                <input id="password" name="password" type="password" class="validate">
                <label for="password">Password</label>
            </div>

        </div>

        <div class="row">

            <div class="col l6 offset-l3 m12 s12">
                <input type="checkbox" id="remember" name="remember"/>
                <label for="remember">Remember Me</label>

                <button type="submit" class="waves-effect waves-light btn light-green right"><i class="fa fa-unlock-alt right"></i>login</button>
                <a class="btn-flat right" href="{{ route('login::resetpass') }}">Forgot your password?</a>
            </div>

        </div>

    </form>

@endsection