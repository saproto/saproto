@extends('website.layouts.default')

@section('page-title')
    UTwente Address Book Search
@endsection

@section('content')

    <form method="post" action="{{ route('ldap::search') }}">
        {!! csrf_field() !!}
        <input type="text" id="ldapsearch__input" name="query" class="form-control"
               placeholder="Enter your search term here and hit enter..." value="{{ $term }}">
    </form>

    @if (count($data) == 0 && $term != null)

        <hr>

        <p style="text-align: center;">
            Your search returned no results.
        </p>

    @elseif($term != null)

        <hr>

        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Occupation</th>
                <th>E-mail</th>
                <th>Phone</th>
                <th>Room</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $result)

                <tr>
                    <td>
                        {{ property_exists($result, 'givenname') ? $result->givenname : null }} {{ property_exists($result, 'middlename') ? $result->middlename : null }} {{ property_exists($result, 'sn') ? $result->sn : null }}, {{ property_exists($result, 'initials') ? $result->initials : null }}
                    </td>
                    <td>
                        @if($result->type == 'student')
                            Student {{ property_exists($result, 'department') ? $result->department : null }}
                        @elseif($result->type == 'employee')
                            {{ property_exists($result, 'department') ? $result->department : null }} Employee
                        @else
                            Functional Account
                            {{ property_exists($result, 'department') ? '('.$result->department.')' : null }}
                        @endif
                    </td>
                    <td>
                        @if(property_exists($result, 'mail'))
                            <a href="mailto:{{ $result->mail }}">{{ $result->mail }}</a>
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td>
                        @if(property_exists($result, 'telephonenumber'))
                            <a href="tel:{{ $result->telephonenumber }}">{{ $result->telephonenumber }}</a>
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td>
                        @if(property_exists($result, 'physicaldeliveryofficename'))
                            {{ $result->physicaldeliveryofficename }}
                        @else
                            &nbsp;
                        @endif
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>

    @endif

@endsection
