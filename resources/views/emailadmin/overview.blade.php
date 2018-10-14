@extends('website.layouts.default')

@section('page-title')
    E-mail Administration
@endsection

@section('content')

    <div class="row">

        <div class="col-md-6">

            <h3>E-mail lists (<a href="{{ route('email::list::add') }}">create new</a>)</h3>

            <table class="table">

                <thead>

                <tr>

                    <th>#</th>
                    <th>List name</th>
                    <th>Public</th>
                    <th>Subscribers</th>
                    <th>Controls</th>

                </tr>

                </thead>

                <tr>
                    <td>&nbsp;</td>
                    <td>All members</td>
                    <td><i>System managed</i></td>
                    <td>{{ Member::count() }}</td>
                    <td><i>Not editable</i></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>All active members</td>
                    <td><i>System managed</i></td>
                    <td>{{ Member::countActiveMembers() }}</td>
                    <td><i>Not editable</i></td>
                </tr>

                @foreach(EmailList::all() as $list)

                    <tr>

                        <td>{{ $list->id }}</td>
                        <td>{{ $list->name }}</td>
                        <td>{{ ($list->is_member_only ? 'Member only' : 'Public') }}</td>
                        <td>{{ $list->users->count() }}</td>
                        <td>
                            <a class="btn btn-xs btn-default"
                               href="{{ route('email::list::edit', ['id' => $list->id]) }}" role="button">
                                <i class="fas fa-pencil" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-xs btn-danger"
                               onclick="return confirm('Delete e-mail list {{ $list->name }}?');"
                               href="{{ route('email::list::delete', ['id' => $list->id]) }}" role="button">
                                <i class="fas fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>

                    </tr>

                @endforeach

            </table>

        </div>

        <div class="col-md-6">

            <h3>E-mails (<a href="{{ route('email::add') }}">create new</a>)</h3>

            <table class="table">

                <thead>

                <tr>

                    <th>#</th>
                    <th>Description</th>
                    <th>Recipients</th>
                    <th>Scheduled</th>
                    <th>Status</th>
                    <th>Controls</th>

                </tr>

                </thead>

                @foreach(Email::orderBy('id', 'desc')->get() as $email)

                    <tr style="{{ ($email->sent ? 'opacity: 0.5;' : '') }}">

                        <td>{{ $email->id }}</td>
                        <td>{{ $email->description }}</td>
                        <td>
                            @if ($email->sent)
                                {{ $email->sent_to }}
                            @else
                                {{ $email->recipients()->count() }}*
                            @endif
                            <br>
                            Via
                            @if ($email->to_user)
                                all users
                            @elseif($email->to_member)
                                all members
                            @elseif($email->to_active)
                                all active members
                            @elseif($email->to_list)
                                list(s) {{ $email->getListName() }}
                            @elseif($email->to_event)
                                event(s) {{ $email->getEventName() }}
                            @endif
                        </td>
                        <td>
                            {{ date('d-m Y', $email->time) }}<br>
                            {{ date('H:i', $email->time) }}
                        </td>
                        <td>
                            @if (!$email->sent)
                                @if ($email->ready)
                                    Queued
                                @else
                                    Draft
                                @endif
                            @else
                                <i>Sent</i>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-xs btn-info" target="_blank"
                               href="{{ route('email::show', ['id' => $email->id]) }}" role="button">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </a>
                            @if (!$email->sent)
                                <a class="btn btn-xs btn-danger"
                                   onclick="return confirm('You sure you want to delete this e-mail?')"
                                   href="{{ route('email::delete', ['id' => $email->id]) }}" role="button">
                                    <i class="fas fa-trash-o" aria-hidden="true"></i>
                                </a>
                                @if (!$email->ready)
                                    <a class="btn btn-xs btn-success"
                                       href="{{ route('email::toggleready', ['id' => $email->id]) }}" role="button">
                                        <i class="fas fa-send-o" aria-hidden="true"></i>
                                    </a>
                                    <a class="btn btn-xs btn-default"
                                       href="{{ route('email::edit', ['id' => $email->id]) }}" role="button">
                                        <i class="fas fa-pencil" aria-hidden="true"></i>
                                    </a>
                                @else
                                    <a class="btn btn-xs btn-warning"
                                       href="{{ route('email::toggleready', ['id' => $email->id]) }}" role="button">
                                        <i class="fas fa-undo" aria-hidden="true"></i>
                                    </a>
                                @endif
                            @endif
                        </td>

                    </tr>

                @endforeach

            </table>

            <p>
                Recipient numbers suffixed with an asterisk (*) may change if people sign in or out of mailing lists
                between now and dispatch
            </p>

        </div>

    </div>

@endsection