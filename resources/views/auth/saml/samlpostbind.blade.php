@extends('auth.template')

@section('page-title')
    SSO Authentication
@endsection

@section('login-body')

    <form method="POST" action="{{ $destination }}" id="samlform">
        <input type="hidden" name="SAMLResponse" value="{{ $response }}">
        <input type="submit" value="Continue Authentication" class="btn btn-default" style="width: 100%;">
    </form>

    <script type="text/javascript">
        document.getElementById("samlform").submit();
    </script>

@endsection