@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($leaderboard == null ? "Create new leaderboard." : "Edit leaderboard. " . $leaderboard->name .".") }}
@endsection

@section('container')

    <form method="post"
          action="{{ ($leaderboard == null ? route("leaderboards::add") : route("leaderboards::edit", ['id' => $leaderboard->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}

        <div class="row justify-content-center">

            <div class="col-md-4">

                <div class="card md-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="organisation">Committee: {!! $leaderboard && $leaderboard->committee_id ? $leaderboard->committee_id : null !!}</label>
                            <select class="form-control committee-search" id="organisation" name="committee"></select>
                        </div>


                        <div class="form-group">
                            <label for="name">Leaderboard name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Proto drink beer scores" value="{{ $leaderboard->name or '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="name">Points name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Beers" value="{{ $leaderboard->points_name or '' }}" required>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success float-right">
                            Submit
                        </button>

                        <a href="{{ route("leaderboards::admin") }}" class="btn btn-default">Cancel</a>
                    </div>

                </div>

            </div>

            <div class="col-md-8">

                <div class="card md-3">

                    <div class="card-header bg-dark text-white">
                        Description
                    </div>

                    <div class="card-body row">

                        <div class="col-6">
                            <label for="editor">Leaderboard description:</label>
                            @include('website.layouts.macros.markdownfield', [
                                'name' => 'excerpt',
                                'placeholder' => !$leaderboard ? 'A small paragraph about the leaderboard.' : null,
                                'value' => !$leaderboard ? null : $leaderboard->description
                            ])
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection