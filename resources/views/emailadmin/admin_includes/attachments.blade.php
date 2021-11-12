@if($email)

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Attachments
        </div>

        @if($email->attachments->count() > 0)

            <table class="table">

                <thead>
                <th>File</th>
                <th>Size</th>
                <th></th>
                </thead>

                @foreach($email->attachments as $attachment)

                    <tr>
                        <td>
                            <a href="{{ $attachment->generatePath() }}">{{ $attachment->original_filename }}</a>
                        </td>
                        <td>
                            <i>{{ $attachment->getFileSize() }}</i>
                        </td>
                        <td>
                            <a onclick="return confirm('You sure you want to delete this attachment?')"
                               href="{{ route('email::attachment::delete', ['id' => $email->id, 'file_id' => $attachment->id]) }}">
                                <i class="fas fa-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>

                @endforeach

            </table>

        @else

            <div class="card-body">
                <p class="card-text text-center">There are no attachments to this e-mail.</p>
            </div>

        @endif

        <div class="card-footer">

            <form method="post" enctype="multipart/form-data"
                  action="{{ route('email::attachment::add', ['id'=>$email->id]) }}">

                {{ csrf_field() }}

                <div class="custom-file mb-3">
                    <input type="file" id="attachment" class="form-control" name="attachment">
                    <label class="form-label" for="attachment">Choose file</label>
                </div>

                <button type="submit" class="btn btn-success btn-block"
                        onclick="return confirm('Any unsaved changes to the e-mail will be discarded if you continue.')">
                    Upload
                </button>

            </form>

        </div>

    </div>

@endif