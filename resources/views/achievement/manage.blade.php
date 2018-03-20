@extends('website.layouts.default-nobg')

@section('page-title')
    Achievement Administration
@endsection

@section('content')

    <div class="col-md-6 {{ $new ? "col-md-offset-3" : "" }}">

        <form method="post"
              action="{{ ($new ? route("achievement::add") : route("achievement::update", ['id' => $achievement->id])) }}">

            {!! csrf_field() !!}

            <div class="panel panel-default">

                <div class="panel-heading">
                    {{ ($new ? "Create a new Achievement" : "Edit Achievement " . $achievement->name) }}
                </div>

                <div class="panel-body">

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Be Awesome"
                               value="{{ $achievement->name or '' }}" required>
                    </div>

                    <div class="form-group">
                        <label for="desc">Description:</label>
                        <input type="text" class="form-control" id="desc" name="desc"
                               placeholder="Become member of Proto"
                               value="{{ $achievement->desc or '' }}" required>
                    </div>

                    <div class="form-group">
                        <label for="tier">Tier:</label>
                        <select class="form-control {{ $achievement->tier or '' }}" name="tier">
                            <option value="COMMON"
                                    {{ (!$new && $achievement->tier == "COMMON" ? 'selected' : '') }}>
                                COMMON
                            </option>
                            <option value="UNCOMMON"
                                    {{ (!$new && $achievement->tier == "UNCOMMON" ? 'selected' : '') }}>
                                UNCOMMON
                            </option>
                            <option value="RARE"
                                    {{ (!$new && $achievement->tier == "RARE" ? 'selected' : '') }}>RARE
                            </option>
                            <option value="EPIC"
                                    {{ (!$new && $achievement->tier == "EPIC" ? 'selected' : '') }}>EPIC
                            </option>
                            <option value="LEGENDARY"
                                    {{ (!$new && $achievement->tier == "LEGENDARY" ? 'selected' : '') }}>
                                LEGENDARY
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="isPrize">Is prize:</label>
                        <br>
                        <input type="hidden" name="isPrize" value="0">
                        <input type="checkbox" id="isPrize" name="isPrize" value="1" {{ (!$new && $achievement->isPrize ? 'checked' : '') }}>
                    </div>

                    @if(!$new)

                        <div class="form-group">

                            <hr>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>User count</th>
                                    <th>Achieved</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Members only</td>
                                    <td>{{ count($achievement->currentOwners(true)) }}</td>
                                </tr>
                                <tr>
                                    <td>All users</td>
                                    <td>{{ count($achievement->currentOwners(false)) }}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                    @endif

                </div>

                <div class="panel-footer clearfix">

                    <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit
                    </button>

                    <a href="{{ route("achievement::list") }}" class="btn btn-default pull-right">Cancel</a>

                </div>

            </div>

        </form>

        @if(!$new)

            <form method="post" action="{{ route("achievement::icon", ["id" => $achievement->id]) }}"
                  enctype="multipart/form-data">

                {!! csrf_field() !!}

                <div class="panel panel-default">

                    <div class="panel-heading">
                        Update icon
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label data-placement="inline" class="icp icp-auto"
                                   data-selected="{{  substr($achievement->fa_icon, 3) }}"></label>
                        </div>

                        <input type="hidden" name="fa_icon" id="icon">

                    </div>

                    <div class="panel-footer clearfix">
                        <button type="submit" class="btn btn-success pull-right">
                            Replace icon
                        </button>
                    </div>

                </div>

            </form>

        @endif

    </div>

    @if(!$new)

        <div class="col-md-6">

            <div class="panel panel-default">

                <div class="panel-heading">
                    Preview
                </div>

                <div class="panel-body">

                    <ul class="achievement-list achievement-preview">

                        <li class="achievement {{ $achievement->tier }}">

                            <div class="achievement-label">
                                <img src="{{ asset('images/achievements/' . strtolower($achievement->tier) . '.svg') }}"
                                     alt="">
                            </div>

                            <div class="achievement-icon">
                                @if($achievement->fa_icon)
                                    <i class="{{ $achievement->fa_icon }}" aria-hidden="true"></i>
                                @else
                                    No icon available
                                @endif
                            </div>

                            <div class="achievement-tooltip">

                                <div class="achievement-button">
                                    <img src="{{ asset('images/achievements/' . strtolower($achievement->tier) . '_tooltip.svg') }}"
                                         alt="">
                                    <div class="achievement-button-icon">
                                        @if($achievement->fa_icon)
                                            <i class="{{ $achievement->fa_icon }}" aria-hidden="true"></i>
                                        @else
                                            No icon available
                                        @endif
                                    </div>
                                </div>

                                <div class="achievement-text">

                                    <div class="achievement-title">
                                        <strong>{{ $achievement->name }}</strong>
                                    </div>

                                    <div class="achievement-desc">
                                        <p>{{ $achievement->desc }}</p>
                                    </div>

                                </div>

                            </div>

                        </li>

                    </ul>

                </div>

            </div>

            <div class="panel panel-default">

                <div class="panel-heading">
                    Gift this Achievement
                </div>

                <form method="post"
                      action="{{ route("achievement::give", ['id' => $achievement->id]) }}">

                    {!! csrf_field() !!}

                    <div class="panel-body">

                        <div class="form-group">
                            <div id="user-select">
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="member-name"
                                           placeholder="John Doe"
                                           required>
                                    <input type="hidden" id="member-id" name="user_id" required>
                                </div>
                                <div class="col-sm-3">
                                    <input type="button" class="form-control btn btn-success" id="member-clear"
                                           value="Clear">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="panel-footer clearfix">

                        <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Give
                        </button>

                    </div>

                </form>

            </div>

            <div class="panel panel-default">

                <div class="panel-heading">
                    Users with this Achievement
                </div>

                <div class="panel-body">

                    @if (count($achievement->currentOwners(false)) > 0)

                        @foreach($achievement->currentOwners(false) as $user)

                            <div class="member">
                                <div class="member-picture"
                                     style="background-image:url('{!! $user->generatePhotoPath(100, 100) !!}');"></div>
                                <a href="{{ route("user::profile", ['id'=>$user->getPublicId()]) }}">{{ $user->name }}</a>

                                <p class="pull-right activity__admin-controls">
                                    <a class="activity__admin-controls__button--delete"
                                       href="{{ route('achievement::take', ['id' => $achievement->id, 'user' => $user->id]) }}">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </p>
                            </div>

                        @endforeach

                    @else

                        Nobody obtained this achievement yet

                    @endif

                </div>

                <div class="panel-footer clearfix">

                    <div class="pull-right">

                        <div class="btn-group" role="group">
                            <div class="btn-group" role="group">
                                <a href="{{ route('achievement::takeAll', ['id' => $achievement->id]) }}" - +
                                   class="btn btn-danger">
                                    Take from everyone
                                </a>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            @endif

        </div>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">
        $('select').on('change', function (ev) {
            $(this).attr('class', 'form-control').addClass($(this).children(':selected').val());
        });
    </script>

    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <script>
        $("#member-name").autocomplete({
            minLength: 3,
            source: "{{ route("api::members") }}",
            select: function (event, ui) {
                $("#member-name").val(ui.item.name + " (ID: " + ui.item.id + ")").prop('disabled', true);
                ;
                $("#member-id").val(ui.item.id);
                return false;
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>").append(item.name).appendTo(ul);
        };
        $("#member-clear").click(function () {
            $("#member-name").val("").prop('disabled', false);
            ;
            $("#member-id").val("");
        });
    </script>

    <script src="//farbelous.github.io/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.js"></script>
    <link rel="stylesheet" href="//farbelous.github.io/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.css">

    <script>
        $('.icp-auto').iconpicker();

        $('.icp').on('iconpickerSelected', function (e) {
            $('#icon').val(e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue));
        });
    </script>

@endsection