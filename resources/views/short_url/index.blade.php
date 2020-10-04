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
                        <td>Target</td>
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
                            <td>
                                {{ $url->description }}
                            </td>
                            <td>
                                <span class="text-muted">{{ route('short_url::go', ['short' => null]) }}</span>/<strong>{{ $url->url }}</strong>
                            </td>
                            <td>
                                {{ $url->clicks }}
                            </td>
                            <td style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; max-width: 300px">
                                {{ $url->target }}
                            </td>
                            <td>
                                <button
                                   data-toggle="popover"
                                   data-placement="right"
                                   data-title="{{ $url->description }}"
                                   data-content="{{ $url->target }}"
                                   class="btn badge badge-info">
                                    <i class="fas fa-eye text-white"></i>
                                </button>
                            </td>

                        </tr>

                    @endforeach

                </table>
                </div>

                <div id="preview-modal" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p id="target-url"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer pb-0">
                    {{ $urls->links() }}
                </div>

            </div>

        </div>

    </div>

    <script>
        $('#preview-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var targetUrl = button.data('url');
            var modal = $(this);
            modal.find('.modal-title').text('New message to ' + recipient);
            modal.find('.modal-body #target-url').val(recipient);
        })
    </script>

@endsection