@extends('website.layouts.default')

@section('head')
    @parent
    <meta http-equiv="refresh" content="{{ Session::get('passwordstore-verify') - time() }}">
@endsection

@section('page-title')
    Password Store
@endsection

@section('content')

    <p style="text-align: center;">
        <a href="{{ route('passwordstore::add', ['type' => 'password']) }}" class="btn btn-success">
            Add Password
        </a>
        <a href="{{ route('passwordstore::add', ['type' => 'note']) }}" class="btn btn-success">
            Add Secure Note
        </a>
    </p>

    <hr>

    @if (count($passwords) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>&nbsp;</th>
                <th>Description</th>
                <th>Access</th>
                <th>URL</th>
                <th>Username</th>
                <th>Password</th>
                <th>Age</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>

            </tr>

            </thead>

            <?php $i = 0; ?>

            @foreach($passwords as $password)

                <?php $i++; ?>

                @if($password->canAccess(Auth::user()))

                    <tr>

                        <td>{{ $password->id }}</td>

                        <td>
                            @if($password->isNote())
                                <i class="fas fa-sticky-note-o" aria-hidden="true"></i>
                            @else
                                <i class="fas fa-key" aria-hidden="true"></i>
                            @endif
                        </td>

                        <td>
                            {{ $password->description }}
                        </td>
                        <td>{{ $password->permission->display_name }}</td>

                        @if($password->isNote())

                            <td colspan="3">
                                <span class="passwordmanager__shownote" data-toggle="modal"
                                      data-target="#passwordmodal-{{ $password->id }}">
                                    Click here to view this secure note.
                                </span>
                            </td>

                        @else

                            <td>
                                @if($password->url)
                                    <a href="{{ $password->url }}" class="btn btn-default"><i class="fas fa-external-link" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </td>
                            <td><a class="passwordmanager__copy btn btn-default" href="#" copyTarget="user_{{ $i }}"><i class="fas fa-clipboard" aria-hidden="true"></i></a><input type="text" class="passwordmanager__hidden" id="user_{{ $i }}" value="{{ Crypt::decrypt($password->username) }}"></td>
                            <td><a class="passwordmanager__copy btn btn-default" href="#" copyTarget="pass_{{ $i }}"><i class="fas fa-clipboard" aria-hidden="true"></i></a><input type="text" class="passwordmanager__hidden" id="pass_{{ $i }}" value="{{ Crypt::decrypt($password->password) }}"></td>

                        @endif

                        <td style="color: {{ ($password->age() > 12 ? '#ff0000' : '#00ff00') }};">
                            {{ $password->age() }} months
                        </td>

                        <td>
                            <a href="{{ route("passwordstore::edit", ['id' => $password->id]) }}" class="btn btn-default"><i class="fas fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a href="{{ route("passwordstore::delete", ['id' => $password->id]) }}" class="btn btn-danger"><i class="fas fa-trash" aria-hidden="true"></i></a>
                        </td>

                    </tr>

                @endif

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            There is nothing for you to see.
        </p>

    @endif

    @foreach($passwords as $password)

        @if($password->isNote())

            <div class="modal fade" id="passwordmodal-{{ $password->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="passwordmodal-label-{{ $password->id }}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"
                                id="passwordmodal-label-{{ $password->id }}">{{ $password->description }}</h4>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" rows="30"
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
        $(".passwordmanager__copy").click(function() {
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
            } catch(e) {
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