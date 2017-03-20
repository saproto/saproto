@extends('website.layouts.default')

@section('page-title')
    Withdrawal of {{ date('d-m-Y', strtotime($withdrawal->date)) }}
@endsection

@section('content')

    <table class="table">

        <thead>
        <tr>
            <th>ID</th>
            <th>Users</th>
            <th>Orderlines</th>
            <th>Sum</th>
            <th>Status</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td>{{ $withdrawal->withdrawalId() }}</td>
            <td>{{ $withdrawal->users()->count() }}</td>
            <td>{{ $withdrawal->orderlines->count() }}</td>
            <td>&euro;{{ $withdrawal->total() }}</td>
            <td>{{ $withdrawal->closed ? 'Closed' : 'Pending' }}</td>
        </tr>
        </tbody>

    </table>

    <hr>

    <form method="post" action="{{ route('omnomcom::withdrawal::edit', ['id' => $withdrawal->id]) }}">

        {!! csrf_field() !!}

        <div class="row">

            <div class="col-md-2">
                <input type="text" class="form-control datetime-picker" name="date"
                       value="{{ date('d-m-Y', strtotime($withdrawal->date)) }}" required>
            </div>

            <div class="col-md-2">
                <input type="submit" value="Save" class="btn btn-success">
            </div>

            <div class="col-md-2">
                <div class="btn-group-justified">
                    <a href="{{ route('omnomcom::withdrawal::export', ['id' => $withdrawal->id]) }}"
                       class="btn btn-success">
                        Generate CSV
                    </a>
                </div>
            </div>

            <div class="col-md-2">
                <div class="btn-group-justified">
                    <a href="{{ route('omnomcom::withdrawal::email', ['id' => $withdrawal->id]) }}"
                       class="btn btn-success"
                       onclick="return confirm('This will send an e-mail to {{ $withdrawal->users()->count() }} users. Are you sure?');">
                        E-mail Users
                    </a>
                </div>
            </div>

            <div class="col-md-2">
                <div class="btn-group-justified">
                    <a href="{{ route('omnomcom::withdrawal::close', ['id' => $withdrawal->id]) }}"
                       class="btn btn-success"
                       onclick="return confirm('After closing, you cannot change anything about this withdrawal. Are you sure?');">
                        Close Withdrawal
                    </a>
                </div>
            </div>

            <div class="col-md-2">
                <div class="btn-group-justified">
                    <a href="{{ route('omnomcom::withdrawal::delete', ['id' => $withdrawal->id]) }}"
                       class="btn btn-success" onclick="return confirm('Are you sure?');">
                        Delete
                    </a>
                </div>
            </div>

        </div>

    </form>

    <hr>

    <table class="table">

        <thead>
        <tr>
            <th>User</th>
            @if(!$withdrawal->closed)
                <th>Bank Account</th>
                <th>Authorization</th>
            @endif
            <th>#</th>
            <th>Sum</th>
            @if(!$withdrawal->closed)
                <th>Controls</th>
            @endif
        </tr>
        </thead>

        @foreach($withdrawal->totalsPerUser() as $data)

            <tr>
                <td>{{ $data->user->name }}</td>
                @if(!$withdrawal->closed)
                    <td>
                        <strong>{{ $data->user->bank->iban }}</strong>
                        / {{ $data->user->bank->bic }}
                    </td>
                    <td>{{ $data->user->bank->machtigingid }}</td>
                @endif
                <td>{{ $data->count }}</td>
                <td>&euro;{{ number_format($data->sum, 2, ',', '.') }}</td>
                @if(!$withdrawal->closed)
                    <td>
                        <a href="{{ route('omnomcom::withdrawal::deleteuser', ['id' => $withdrawal->id, 'user_id' => $data->user->id]) }}">
                            Remove
                        </a>
                    </td>
                @endif
            </tr>

        @endforeach

    </table>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">
        // Initializes datetimepickers for consistent options
        $('.datetime-picker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                next: "fa fa-chevron-right",
                previous: "fa fa-chevron-left"
            },
            format: 'DD-MM-YYYY'
        });
    </script>

@endsection