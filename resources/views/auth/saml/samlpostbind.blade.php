@extends('website.layouts.panel')

@section('page-title')
    SAML2 Authentication
@endsection

@section('panel-title')
    Redirecting you back.
@endsection

@section('panel-body')

    <p>
        We would love to do this automagically, but your browser has JavaScript disabled. Please be so kind to press the
        button below to continue authenticating.
    </p>

@endsection

@section('panel-footer')

    <form method="POST" action="{{ $destination }}" id="samlform">
        <input type="hidden" name="SAMLResponse" value="{{ $response }}">
        <input type="submit" value="Continue!" class="btn btn-success" style="width: 100%;">
    </form>

    <script type="text/javascript">
        document.getElementById("samlform").submit();
    </script>

@endsection