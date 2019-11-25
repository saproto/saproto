@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Short URL Service
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                    <a class="badge badge-info float-right" href="{{ route('short_url::edit', ['id' => 'new']) }}">
                        Create Short URL</a>
                </div>

                <table class="table table-hover table-sm">

                    <thead>

                    <tr class="bg-dark text-white">
                        <td></td>
                        <td>Description</td>
                        <td>Url</td>
                        <td>Clicks</td>
                        <td>Target</td>
                    </tr>

                    </thead>

                    @foreach($urls as $url)

                        <tr>

                            <td>
                                <a href="{{ route('short_url::delete', ['id' => $url->id]) }}"
                                   class="fa fa-trash-alt text-danger"></a>
                                <a href="{{ route('short_url::edit', ['id' => $url->id]) }}"
                                   class="fa fa-pencil-alt text-success ml-2"></a>
                            </td>
                            <td>
                                {{ $url->description }}
                            </td>
                            <td>
                                <span class="text-muted">{{ route('short_url::go', ['short' => null]) }}</span>/<strong>{{ $url->url }}</strong>
                            </td>
                            <td>
                                {{ $url->clicks }}
                            </td>
                            <td>
                                {{ $url->target }}
                            </td>

                        </tr>

                    @endforeach

                </table>

                <div class="card-footer pb-0">
                    {{ $urls->links() }}
                </div>

            </div>

        </div>

    </div>

@endsection