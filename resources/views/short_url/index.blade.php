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

                <div class="table-responsive">

                    <table class="table table-hover table-sm">

                        <thead>

                        <tr class="bg-dark text-white">
                            <td></td>
                            <td>Description</td>
                            <td>Url</td>
                            <td>Clicks</td>
                            <td class="text-center">Target</td>
                            <td></td>
                        </tr>

                        </thead>

                        @foreach($urls as $url)

                            <tr>

                                <td class="pl-2">
                                    <a href="{{ route('short_url::delete', ['id' => $url->id]) }}"
                                       class="fa fa-trash-alt text-danger mr-2"></a>
                                    <a href="{{ route('short_url::edit', ['id' => $url->id]) }}"
                                       class="fa fa-pencil-alt text-success"></a>
                                </td>
                                <td style="overflow-wrap: break-word; max-width: 200px">
                                    {{ $url->description }}
                                </td>
                                <td>
                                    <span class="text-muted">saproto.nl/go</span><strong>/{{ $url->url }}</strong>
                                </td>
                                <td>
                                    {{ $url->clicks }}
                                </td>
                                <td class="text-center">
                                    <button
                                       data-toggle="popover"
                                       data-placement="right"
                                       data-trigger="focus"
                                       data-title="{{ $url->description }}"
                                       data-content="{{ $url->target }}"
                                       class="btn badge badge-info">
                                        <i class="fas fa-link text-white"></i>
                                    </button>
                                </td>

                            </tr>

                        @endforeach

                    </table>

                </div>

                <div class="card-footer pb-0">
                    {{ $urls->links() }}
                </div>

            </div>

        </div>

    </div>

@endsection