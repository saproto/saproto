@extends('website.layouts.default-nobg')

@section('page-title')
    Achievement Administration
@endsection

@section('content')

    <div class="col-md-6 col-md-offset-3">

    <form method="post"
          action="{{ ($new ? route("achievement::add") : route("achievement::edit", ['id' => $achievement->id])) }}">

        {!! csrf_field() !!}

        <div class="panel panel-default">

            <div class="panel-heading">
                {{ ($new ? "Create a new Achievement." : "Edit Achievement " . $achievement->name .".") }}
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Be Awesome"
                           value="{{ $achievement->name or '' }}" required>
                </div>

                <div class="form-group">
                    <label for="desc">Description:</label>
                    <input type="text" class="form-control" id="desc" name="desc" placeholder="Become member of Proto"
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
                    @if(!$new)

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
                                <td>{{ count($achievement->current(true)) }}</td>
                            </tr>
                            <tr>
                                <td>All users</td>
                                <td>{{ count($achievement->current(false)) }}</td>
                            </tr>
                            </tbody>
                        </table>

                    @endif
                </div>

            </div>

            <div class="panel-footer clearfix">

                <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit</button>

                <a href="{{ route("achievement::list") }}" class="btn btn-default pull-right">Cancel</a>

            </div>

        </div>

    </form>

    @if(!$new)

        <form method="post" action="{{ route("achievement::image", ["id" => $achievement->id]) }}"
              enctype="multipart/form-data">

            {!! csrf_field() !!}

            <div class="panel panel-default">

                <div class="panel-heading">
                    Update icon
                </div>

                <div class="panel-body">

                    @if($achievement->img_file_id)

                        <img src="{{ route('file::get', $achievement->img_file_id) }}" width="100%;">

                    @else
                        <p>
                            &nbsp;
                        </p>
                        <p style="text-align: center;">
                            This achievement has no icon yet. Upload one now!
                        </p>
                    @endif

                    <hr>

                    <div class="form-horizontal">

                        <div class="form-group">
                            <label for="image" class="col-sm-4 control-label">New achievement icon</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="image" type="file" name="image">
                            </div>
                        </div>

                    </div>

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

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        /*select, option {*/
        /*background: #fff;*/
        /*color: black;*/
        /*}*/

        /*select option:hover {*/
        /*background: black;*/
        /*color: black;*/
        /*cursor: none;*/
        /*}*/

        select.COMMON, option[value="COMMON"] {
            background: #FFFFFF;
            color: black;
        }

        select.UNCOMMON, option[value="UNCOMMON"] {
            background: #1E90FF;
            color: white;
        }

        select.RARE, option[value="RARE"] {
            background: #9932CC;
            color: white;
        }

        select.EPIC, option[value="EPIC"] {
            background: #333333;
            color: white;
        }

        select.LEGENDARY, option[value="LEGENDARY"] {
            background: #C1FF00;
            color: black;
        }

        /********** ONLY FIREFOX **********/
        /*select option:checked {*/
        /*box-shadow: 0 0 10px 100px #555 inset;*/
        /*}*/

    </style>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">
        $('select').on('change', function (ev) {
            $(this).attr('class', 'form-control').addClass($(this).children(':selected').val());
        });
    </script>

@endsection