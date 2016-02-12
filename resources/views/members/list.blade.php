@extends('website.default.container')

@section('container')
    <div class="row">
        <div class="col-md-5 col-xs-12">
            <div class="row">


                <div class="col-md-12" style="margin-bottom: 15px">
                    <form method="get" action="{{ URL::action('MemberAdminController@index') }}">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Search for..."
                                   value="{{ $search }}">
                    <span class="input-group-btn">
                        <input class="btn btn-default" type="submit" value="Go!">
                    </span>
                        </div>
                    </form>
                </div>


                <div class="col-md-12">
                    <table class="table table-hover">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                        </tr>
                        @foreach($users as $user)
                            <tr class="member" style="cursor: pointer;" user_id="{{ $user->id }}">
                                <td>{{ $user->id }}</td>
                                <td>@if($user->member()) <i class="fa fa-users"></i>@else <i
                                            class="fa fa-user"></i> @endif {{ $user->name }}</td>
                            </tr>
                        @endforeach
                    </table>

                    {!! $users->appends(['search' => $search])->render() !!}
                </div>


            </div>
        </div>

        <div class="col-md-7 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body" id="memberDetail">
                    <p>Choose a member</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(".member").click(function (e) {
            e.preventDefault();
            $("#memberDetail").load("/member/view/nested/" + $(this).attr('user_id'));
        })
    </script>
@endsection
