@if ($email)
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">Attachments</div>

        @if ($email->hasMedia())
            <table class="table">
                <thead>
                    <tr>
                        <th>File</th>
                        <th>Size</th>
                        <th></th>
                    </tr>
                </thead>

                @foreach ($email->getMedia() as $media)
                    <tr>
                        <td>
                            <a href="{{ $media->getUrl() }}">
                                {{ $media->file_name }}
                            </a>
                        </td>
                        <td>
                            <i>{{ $media->human_readable_size }}</i>
                        </td>
                        <td>
                            @include(
                                'components.modals.confirm-modal',
                                [
                                    'action' => route('email::attachment::delete', [
                                        'id' => $email->id,
                                        'file_id' => $media->id,
                                    ]),
                                    'text' => '<i class="fas fa-trash text-danger"></i>',
                                    'title' => 'Confirm Delete',
                                    'message' => 'Are you sure you want to delete this attachment?',
                                    'confirm' => 'Delete',
                                ]
                            )
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <div class="card-body">
                <p class="card-text text-center">
                    There are no attachments to this e-mail.
                </p>
            </div>
        @endif

        <div class="card-footer">
            <form
                id="add_attachment"
                method="post"
                enctype="multipart/form-data"
                action="{{ route('email::attachment::create', ['id' => $email->id]) }}"
            >
                @csrf

                <div class="custom-file mb-3">
                    <input
                        type="file"
                        id="attachment"
                        class="form-control"
                        name="attachment"
                    />
                </div>

                @include(
                    'components.modals.confirm-modal',
                    [
                        'form' => '#add_attachment',
                        'classes' => 'btn btn-success btn-block',
                        'text' => 'Upload',
                        'title' => 'Confirm Upload',
                        'message' =>
                            'Any unsaved changes to the e-mail will be discarded if you upload an attachment. Are you sure you want to continue?',
                        'confirm' => 'Upload',
                    ]
                )
            </form>
        </div>
    </div>
@endif
