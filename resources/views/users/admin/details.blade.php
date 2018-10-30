@extends('website.layouts.redesign.dashboard')

@section('page-title')
    User information: {{ $user->name }}
@endsection

@section('container')

    <div class="row">

        <div class="col-md-3">

            @include('users.admin.admin_includes.contact')

            @include('users.admin.admin_includes.update')

        </div>

        <div class="col-md-3">

            @include('users.admin.admin_includes.actions')

        </div>

        <div class="col-md-3">

            @include('users.admin.admin_includes.membership')

        </div>

        <div class="col-md-3">

            @include('users.admin.admin_includes.hoofd')

        </div>

    </div>

    <!-- Modal for adding membership to user -->
    @include("users.admin.admin_includes.addmember-modal")

    <!-- Modal for removing membership from user -->
    @include("users.admin.admin_includes.removemember-modal")

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        $('body').delegate('#print-card', 'click', function () {

            if (confirm("Please confirm you want to print a membership card.")) {
                $.ajax({
                    url: '{{ route('membercard::print') }}',
                    data: {
                        '_token': '{!! csrf_token() !!}',
                        'id': $(this).attr('data-id')
                    },
                    method: 'post',
                    dataType: 'html',
                    success: function (data) {
                        alert(data);
                    },
                    error: function (data) {
                        alert("Something went wrong while requesting the print.");
                    }
                });
            }

        });

        $('body').delegate('#print-card-overlay', 'click', function () {

            if (confirm("Please confirm you have the right member card loaded.")) {
                $.ajax({
                    url: '{{ route('membercard::printoverlay') }}',
                    data: {
                        '_token': '{!! csrf_token() !!}',
                        'id': $(this).attr('data-id')
                    },
                    method: 'post',
                    dataType: 'html',
                    success: function (data) {
                        alert(data);
                    },
                    error: function (data) {
                        alert("Something went wrong while requesting the print.");
                    }
                });
            }

        });

    </script>

@endsection
