@extends('website.layouts.default')

@section('page-title')
    Pastries
@endsection

@section('content')

    @include('pastries.addpastry')

    <hr>

    @if (count($pastries) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Person A</th>
                <th>Person B</th>
                <th>Pastry</th>
                <th>Added on</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($pastries as $pastry)

                <tr>

                    <td>{{ $pastry->id }}</td>
                    <td>
                        <a href="{{ route('user::profile', ['id' => $pastry->user_a->id]) }}">{{ $pastry->user_a->name }}</a>
                    </td>

                    @if ($pastry->user_b)
                        <td>
                            <a href="{{ route('user::profile', ['id' => $pastry->user_b->id]) }}">{{ $pastry->user_b->name }}</a>
                        </td>
                    @else
                        <td>{{ $pastry->person_b }}</td>
                    @endif

                    <td>{{ $pastry->type() }}</td>

                    <td>{{ $pastry->created_at->format('d/m/Y') }}</td>

                    <td>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('pastries::delete', ['id' => $pastry->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            No Pastries on record
        </p>

    @endif

@endsection