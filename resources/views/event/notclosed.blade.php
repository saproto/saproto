@extends('website.layouts.default')

@section('page-title')
    Activity Administration
@endsection

@section('content')

    @if (count($activities) > 0)

        <p style="text-align: center">
            This overview encompasses all activities to be closed.
        </p>

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Event</th>
                <th>Fee</th>
                <th>Participants</th>
                <th>Registration period</th>
                <th>Account</th>
                <th></th>

            </tr>

            </thead>

            @foreach($activities as $activity)

                <form method="post" action="{{ route("event::financial::close", ['id' => $activity->id]) }}">

                    <tr>

                        {{ csrf_field() }}

                        <td>{{ $activity->id }}</td>

                        @if ($activity->event)
                            <td>
                                <a href="{{ route("event::show", ['id' => $activity->event->id]) }}">{{ $activity->event->title }}</a><br>
                                {{ date('D j F Y', $activity->event->start) }}
                            </td>
                        @else
                            <td>-</td>
                        @endif

                        <td>&euro; {{ number_format($activity->price, 2) }}</td>

                        <td>{{ $activity->users->count() }}</td>

                        <td>
                            {{ date('d-m-Y H:i:s', $activity->registration_start) }}
                            <br>
                            <span style="margin-left: 10%;">
                                {{ date('d-m-Y H:i:s', $activity->registration_end) }} (registration end)
                            </span>
                            <br>
                            <span style="margin-left: 10%;">
                                {{ date('d-m-Y H:i:s', $activity->deregistration_end) }} (deregistration end)
                            </span>
                        </td>

                        <td>
                            <select name="account" class="form-control">
                                @foreach(\Proto\Models\Account::orderBy('account_number', 'asc')->get() as $account)
                                    <option value="{{ $account->id }}">({{ $account->account_number }}
                                        ) {{ $account->name }}</option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            @if($activity->event && !$activity->event->over())
                                <button class="btn btn-info" disabled>Not ended yet.</button>
                            @else
                                <button type="submit" class="btn btn-warning">Close</button>
                            @endif
                        </td>

                    </tr>

                </form>

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            There are no activities to close! Hurray!
        </p>

    @endif

@endsection