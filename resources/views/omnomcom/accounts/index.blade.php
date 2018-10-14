@extends('website.layouts.default')

@section('page-title')
    OmNomCom Product Administration
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <p style="text-align: center;">
                <a href="{{ route('omnomcom::accounts::add') }}">Create a new account.</a>
            </p>

            <hr>

            @if (count($accounts) > 0)

                <table class="table">

                    <thead>

                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Acc. Number</th>
                        <th>Associated Prod.</th>

                    </tr>

                    </thead>

                    @foreach($accounts as $account)

                        <tr>

                            <td>{{ $account->id }}</td>
                            <td>
                                <a href="{{ route('omnomcom::accounts::show', ['id' => $account->id]) }}">
                                    {{ $account->name }}
                                </a>
                            </td>
                            <td>
                                {{ $account->account_number }}
                            </td>
                            <td>
                                {{ $account->products->count() }}
                            </td>
                            <td>
                                <a class="btn btn-xs btn-default"
                                   href="{{ route('omnomcom::accounts::edit', ['id' => $account->id]) }}" role="button">
                                    <i class="fas fa-pencil" aria-hidden="true"></i>
                                </a>
                                <a class="btn btn-xs btn-danger"
                                   href="{{ route('omnomcom::accounts::delete', ['id' => $account->id]) }}"
                                   role="button">
                                    <i class="fas fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </table>

            @else

                <p style="text-align: center;">
                    There are no accounts matching your query.
                </p>

            @endif

        </div>

    </div>

@endsection