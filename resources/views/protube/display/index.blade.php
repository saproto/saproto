@extends('website.layouts.redesign.dashboard')

@section('page-title')
    ProTube Display Admin
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                </div>

                <div class="table-responsive">
                <table class="table table-hover">

                    <thead>

                    <tr>

                        <td>Name</td>
                        <td>Display URL</td>
                        <td>Display Number</td>
                        <td></td>

                    </tr>

                    </thead>

                    <tbody>

                    @if (count($displays) > 0)

                        @foreach($displays as $display)

                            <form method="post" action="{{route('protube::display::update', ['id'=>$display->id])}}">

                                {!! csrf_field() !!}

                                <tr>

                                    <td>
                                        <input class="form-control" type="text" name="name" value="{{ $display->name }}">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="url" value="{{ $display->url }}">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="display" value="{{ $display->display }}">
                                    </td>
                                    <td>
                                        <a class="btn btn-danger"
                                           onclick="return confirm('Are you sure you want to delete {{ $display->name }}?');"
                                           href="{{ route('protube::display::delete', ['id' => $display->id]) }}" role="button">
                                            <i class="fas fa-trash me-2"></i> Delete
                                        </a>
                                        <button class="btn btn-success" type="submit"
                                                href="{{ route('protube::display::update', ['id' => $display->id]) }}"
                                                role="button">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                    </td>

                                </tr>

                            </form>

                        @endforeach

                    @endif

                    <form method="post" action="{{ route('protube::display::store') }}">

                        {!! csrf_field() !!}

                        <tr>

                            <td>
                                <input class="form-control" type="text" name="name" placeholder="Screen name">
                            </td>
                            <td>
                                <input class="form-control" type="text" name="url" placeholder="Screen URL">
                            </td>
                            <td>
                                <input class="form-control" type="text" name="display" placeholder="Screen #">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success" role="button">
                                    <i class="fas fa-save me-2" aria-hidden="true"></i> Save
                                </button>
                            </td>

                        </tr>

                    </form>

                    </tbody>

                </table>
                </div>

            </div>

        </div>

    </div>

@endsection
