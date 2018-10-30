@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Add Alias
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            <div class="card mb-3">

                <form method="post" action="{{ route("alias::add") }}">

                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                </div>

                <div class="card-body">

                        {!! csrf_field() !!}

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="awesome-alias" name="alias">
                            <div class="input-group-append">
                                <span class="input-group-text">@ {{ config('proto.emaildomain') }}</span>
                            </div>
                        </div>

                        <hr>

                        <label for="destination">Forward to an e-mail address:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="destination" name="destination">
                        </div>

                        <label for="destination">Or forward to a member:</label>
                        <select class="form-control user-search" id="user" name="user">
                        </select>

                </div>

                <div class="card-footer">

                    <button type="submit" class="btn btn-success float-right">Submit</button>

                    <a href="{{ route("alias::index") }}" class="btn btn-default">Cancel</a>

                </div>

                </form>

            </div>

        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        $("#user").on('change', function () {
            $("#destination").val('');
        });

        $("#destination").on('click', function () {
            $("#destination").focus();
            $("#user").val('off');
        })

    </script>

@endsection