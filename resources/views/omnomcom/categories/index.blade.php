@extends('website.layouts.default')

@section('page-title')
    OmNomCom Product Category Administration
@endsection

@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <p style="text-align: center;">
                <a href="{{ route('omnomcom::categories::add') }}">Create a new category.</a>
            </p>

            <hr>

            @if (count($categories) > 0)

                <table class="table">

                    <thead>

                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Associated Prod.</th>

                    </tr>

                    </thead>

                    @foreach($categories as $category)

                        <tr>

                            <td>{{ $category->id }}</td>
                            <td>
                                <a href="{{ route('omnomcom::categories::show', ['id' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </td>
                            <td>
                                {{ count($category->products()) }}
                            </td>
                            <td>
                                <a class="btn btn-xs btn-default"
                                   href="{{ route('omnomcom::categories::edit', ['id' => $category->id]) }}" role="button">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <a class="btn btn-xs btn-danger"
                                   onclick="return confirm('Remove category \'{{ $category->name }}\'?');"
                                   href="{{ route('omnomcom::categories::delete', ['id' => $category->id]) }}"
                                   role="button">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </table>

            @else

                <p style="text-align: center;">
                    There are no categories matching your query.
                </p>

            @endif

        </div>

    </div>

@endsection