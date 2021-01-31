@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($leaderboard == null ? "Create new leaderboard." : "Edit leaderboard: " . $leaderboard->name .".") }}
@endsection

@section('container')

    <form method="post"
          action="{{ ($leaderboard == null ? route("leaderboards::add") : route("leaderboards::edit", ['id' => $leaderboard->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row justify-content-center" style="margin-top: 90px;">

            <div class="col-md-5">

                <div class="card md-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <input type="hidden" name="fa_icon" id="icon">

                    <div class="card-body">

                        <div class="form-group">
                            <label for="organisation">Committee: {!! $leaderboard && $leaderboard->committee_id ? $leaderboard->committee->name : null !!}</label>
                            <select class="form-control committee-search" id="organisation" name="committee"></select>
                        </div>


                        <div class="form-group">
                            <label for="name">Leaderboard name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Proto drink beer scores" value="{{ $leaderboard->name or '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="name">Points name:</label>
                            <input type="text" class="form-control" id="points_name" name="points_name"
                                   placeholder="Beers" value="{{ $leaderboard->points_name or '' }}" required>
                        </div>
                        <input type="hidden" name="fa_icon" id="icon">
                        <div class="form-group">
                            <label for="name">Icon:</label>
                                <label data-placement="inline" class="icp icp-auto"
                                       data-selected=""></label>
                        </div>

                        <div class="form-group">
                                <label for="editor">Description:</label>
                                @include('website.layouts.macros.markdownfield', [
                                    'name' => 'description',
                                    'placeholder' => !$leaderboard ? 'A small paragraph about the leaderboard.' : null,
                                    'value' => !$leaderboard ? null : $leaderboard->description
                                ])
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success float-right">
                            Submit
                        </button>

                        <a href="{{ route("leaderboards::add") }}" class="btn btn-default">Cancel</a>
                    </div>

                </div>

            </div>

            <div class="col-md-5">

                <div class="card md-3">

                    <div class="card-header bg-dark text-white">
                        {{ ($leaderboard == null ? "Add entries" : "Edit entries: " . $leaderboard->name)}}
                    </div>

                </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success float-right">
                            Submit
                        </button>

                        <a href="{{ route("leaderboards::add") }}" class="btn btn-default">Cancel</a>
                    </div>

                </div>

            </div>

        </div>

    </form>

@section('javascript')

    @parent

    <script>
        $('.icp-auto').iconpicker();
        $('.icp').on('iconpickerSelected', function (e) {
            $('#icon').val(e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue));
        });
    </script>

@endsection