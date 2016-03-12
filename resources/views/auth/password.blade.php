@extends('website/default/container')

@section('container')

    <div class="col-md-4 col-md-offset-4">

        <form method="POST" action="{{ route('login::resetpass') }}">

            <div class="panel panel-default">
                <div class="panel-heading">Request password reset</div>
                <div class="panel-body">

                    <div class="form-group">
                        <label for="email" class="control-label">E-mail:</label>
                        <input type="text" class="form-control" id="email" name="email"
                               placeholder="d.adams@student.utwente.nl">
                    </div>

                    {!! csrf_field() !!}

                </div>
                <div class="panel-footer clearfix">

                    <button type="submit" class="btn btn-success pull-right">Request reset</button>

                </div>
            </div>

        </form>

    </div>

@endsection