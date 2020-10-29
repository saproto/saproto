@extends('website.layouts.redesign.dashboard')

@section('page-title')
    OmNomCom Product Category Administration
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                    <a href="{{ route('omnomcom::categories::add') }}" class="float-right badge badge-success">
                        Add new category
                    </a>
                </div>

                @if (count($categories) > 0)

                    <div class="table-responsive">
                        <table class="table table-borderless table-hover">

                            @foreach($categories as $category)

                                <tr>

                                    <td class="text-right">{{ $category->id }}</td>
                                    <td>
                                        {{ $category->name }}
                                    </td>
                                    <td>
                                        {{ count($category->products()) }} products
                                    </td>
                                    <td>
                                        <a href="{{ route('omnomcom::categories::show', ['id' => $category->id]) }}">
                                            <i class="fas fa-edit mr-2" aria-hidden="true"></i>
                                        </a>
                                        <a onclick="return confirm('Remove category \'{{ $category->name }}\'?');"
                                           href="{{ route('omnomcom::categories::delete', ['id' => $category->id]) }}">
                                            <i class="fas fa-trash text-danger" aria-hidden="true"></i>
                                        </a>
                                    </td>

                                </tr>

                            @endforeach

                        </table>
                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection