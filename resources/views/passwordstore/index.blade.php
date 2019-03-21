@extends('website.layouts.redesign.dashboard')

@section('head')
    @parent
    <meta http-equiv="refresh" content="{{ Session::get('passwordstore-verify') - time() }}">
@endsection

@section('page-title')
    Password Store
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-2 mb-3">

            <a href="{{ route('passwordstore::add', ['type' => 'password']) }}" class="btn btn-success btn-block mb-3">
                Add Password
            </a>
            <a href="{{ route('passwordstore::add', ['type' => 'note']) }}" class="btn btn-success btn-block">
                Add Secure Note
            </a>

        </div>

        <div class="col-8">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    Password store
                </div>


                @if (count($passwords) > 0)

                    <table class="table table-hover table-borderless table-sm">

                        <thead>

                        <tr class="bg-dark text-white">

                            <td></td>
                            <td>Description</td>
                            <td>Access</td>
                            <td>URL</td>
                            <td>User</td>
                            <td>Pass</td>
                            <td>Comment</td>
                            <td>Age</td>
                            <td></td>
                            <td></td>

                        </tr>

                        </thead>

                        <?php $i = 0; ?>

                        @foreach($passwords as $password)

                            <?php $i++; ?>

                            @if($password->canAccess(Auth::user()))

                                <tr>

                                    <td class="text-right">
                                        @if($password->username == null)
                                            <i class="fas fa-sticky-note" aria-hidden="true"></i>
                                        @else
                                            <i class="fas fa-key" aria-hidden="true"></i>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $password->description }}
                                    </td>
                                    <td>{{ $password->permission->display_name }}</td>

                                    <td class="text-center">
                                        @if($password->url)
                                            <a href="{{ $password->url }}">
                                                <i class="fas fa-globe-africa" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($password->username != null)
                                            <i class="fas fa-user mr-1"></i>
                                            <a class="passwordmanager__copy" href="#" copyTarget="user_{{ $i }}">
                                                <i class="fas fa-clipboard"></i>
                                            </a>
                                            <input type="text" class="passwordmanager__hidden" id="user_{{ $i }}"
                                                   value="{{ Crypt::decrypt($password->username) }}">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($password->password != null)
                                            <i class="fas fa-key mr-1"></i>
                                            <a class="passwordmanager__copy" href="#"
                                               copyTarget="pass_{{ $i }}">
                                                <i class="fas fa-clipboard"></i>
                                            </a>
                                            <input type="text" class="passwordmanager__hidden" id="pass_{{ $i }}"
                                                   value="{{ Crypt::decrypt($password->password) }}">
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if($password->note)
                                            <span class="passwordmanager__shownote" data-toggle="modal"
                                                  data-target="#passwordmodal-{{ $password->id }}">
                                            <i class="fas fa-sticky-note"></i>
                                        </span>
                                        @endif
                                    </td>

                                    <td class="{{ ($password->age() > 12 ? 'text-danger' : 'text-primary') }}">
                                        {{ $password->age() }} months
                                    </td>

                                    <td>
                                        <a href="{{ route("passwordstore::edit", ['id' => $password->id]) }}">
                                            <i class="fas fa-edit mr-2"></i>
                                        </a>
                                        <a href="{{ route("passwordstore::delete", ['id' => $password->id]) }}">
                                            <i class="fas fa-trash text-danger"></i>
                                        </a>
                                    </td>

                                </tr>

                            @endif

                        @endforeach

                    </table>

                @else

                    <div class="card-body">
                        <p class="card-text text-centerØ">
                            There is nothing for you to see.
                        </p>
                    </div>

                @endif

            </div>

        </div>

    </div>

    @foreach($passwords as $password)

        @if($password->note != null)

            <div class="modal fade" id="passwordmodal-{{ $password->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="passwordmodal-label-{{ $password->id }}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $password->description }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" rows="15"
                                      readonly>{{ Crypt::decrypt($password->note) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        @endif

    @endforeach

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">
        $(".passwordmanager__copy").click(function () {
            //copyToClipboard($("#" + $(this).attr("copyTarget")));
            copyToClipboard(document.getElementById($(this).attr("copyTarget")));
        });

        function copyToClipboard(elem) {
            // create hidden text element, if it doesn't already exist
            var targetId = "_hiddenCopyText_";
            var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
            var origSelectionStart, origSelectionEnd;
            if (isInput) {
                // can just use the original source element for the selection and copy
                target = elem;
                origSelectionStart = elem.selectionStart;
                origSelectionEnd = elem.selectionEnd;
            } else {
                // must use a temporary form element for the selection and copy
                target = document.getElementById(targetId);
                if (!target) {
                    var target = document.createElement("textarea");
                    target.style.position = "absolute";
                    target.style.left = "-9999px";
                    target.style.top = "0";
                    target.id = targetId;
                    document.body.appendChild(target);
                }
                target.textContent = elem.textContent;
            }
            // select the content
            var currentFocus = document.activeElement;
            target.focus();
            target.setSelectionRange(0, target.value.length);

            // copy the selection
            var succeed;
            try {
                succeed = document.execCommand("copy");
            } catch (e) {
                succeed = false;
            }
            // restore original focus
            if (currentFocus && typeof currentFocus.focus === "function") {
                currentFocus.focus();
            }

            if (isInput) {
                // restore prior selection
                elem.setSelectionRange(origSelectionStart, origSelectionEnd);
            } else {
                // clear temporary content
                target.textContent = "";
            }
            return succeed;
        }
    </script>

@endsection