@foreach(Announcement::all() as $announcement)

    @if($announcement->showForUser(Auth::user()))

        @if ($announcement->show_as_popup)

            <?php
                $announcement->dismissForUser(Auth::user());
            ?>

            <div class="modal fade" id="{{ $announcement->modalId() }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Announcement</h4>
                        </div>
                        <div class="modal-body">
                            {!! Markdown::convertToHtml($announcement->content) !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-{{ $announcement->bootstrap_style() }}"
                                    data-dismiss="modal">
                                Close modal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @section('javascript')

                @parent

                <script type="text/javascript">
                    $(window).on('load', function () {
                        $('#{{ $announcement->modalId() }}').modal('show');
                    });
                </script>

            @endsection

        @else

            <div role="alert"
                 class="alert alert-{{ $announcement->bootstrap_style() }}">

                @if ($announcement->is_dismissable)
                    <span class="float-right">
                       <a href="{{ route('announcement::dismiss', ['id' => $announcement->id]) }}">
                           <i class="fas fa-times-circle" aria-hidden="true"></i>
                       </a>
                    </span>
                @endif

                {!! Markdown::convertToHtml($announcement->content) !!}

            </div>

        @endif

    @endif

@endforeach