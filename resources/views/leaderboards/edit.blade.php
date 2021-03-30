@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($leaderboard == null ? "Create new leaderboard." : "Edit leaderboard: " . $leaderboard->name .".") }}
@endsection

@section('container')

    <div class="row justify-content-center" style="margin-top: 90px;">

        <div class="col-md-5 mb-3">

    <form method="post"
          action="{{ ($leaderboard == null ? route("leaderboards::add") : route("leaderboards::edit", ['id' => $leaderboard->id])) }}"
          enctype="multipart/form-data">

        {!! csrf_field() !!}



                <div class="card md-3">

                    <div class="card-header bg-dark text-white">
                        @yield('page-title')
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="organisation">Committee: {{$leaderboard->committee->name or ''}}</label>
                            <select class="form-control committee-search" id="organisation" name="committee">
                                <option value="{{$leaderboard && $leaderboard->committee_id ? $leaderboard->committee_id : ""}}"></option>
                            </select>
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
                        <input type="hidden" name="icon" id="icon" required>
                        <div class="form-group">
                            <label for="name">Icon:</label>
                                <label data-placement="inline" class="icp icp-auto"
                                       data-selected="{{$leaderboard ? substr($leaderboard->icon, 3) : ''}}"></label>
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


    </form>

        </div>



            @if ($leaderboard)

            <div class="col-md-5 mb-3">

                <form method="post"
                      action="{{ route("leaderboards_entries::add")}}"
                      enctype="multipart/form-data">


                    {!! csrf_field() !!}

                <div class="card md-3">

                    <div class="card-header bg-dark text-white">
                        {{ ($leaderboard == null ? "Add entries" : "Edit entries: " . $leaderboard->name)}}
                    </div>

                    <div class="card-body">
                        @if($entries != null)
                            @if(count($entries) > 0)
                        <table class="table table-sm table-hover">
                            <tr class="bg-dark text-white">
                                <td>User ID</td>
                                <td><i class="fas fa-user"></i> Username</td>
                                <td>Points</td>
                                <td></td>
                            </tr>
                            @else
                               <p>No entries yet, add entries here.</p>
                            @endif

                                @foreach($leaderboard->entries as $leaderboard_entry)

                                    <tr>
                                        <td>{{ $leaderboard_entry->user_id}}</td>
                                        <td>Username</td>
                                        <td>{{ $leaderboard_entry->points}}</td>
                                        <td>
                                            <a href="{{ route('leaderboards_entries::delete', ['id' => $leaderboard_entry->id]) }}">
                                                <i class="fas fa-trash text-danger fa-fw"></i>
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach

                        </table>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <select class="form-control user-search" name="user_id" required></select>
                                </div>
                                <div class="col-6">
                                    <label for="name">Points</label>
                                    <input type="text" class="form-control" id="entry-points" name="entry-points"
                                           placeholder="69" value="" required>
                                </div>
                            </div>

                        </div>

                    </div>

                    @endif

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right">
                                Submit
                            </button>
                            <a href="{{ route("leaderboards::add") }}" class="btn btn-default">Cancel</a>
                        </div>

                    </div>
                @endif

                </div>

            </div>

        </div>
    </form>
    </div>

@section('javascript')

    @parent

    <script>
        $('.icp-auto').iconpicker();
        $('.icp').on('iconpickerSelected', function (e) {
            $('#icon').val(e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue));
        });
    </script>

@endsection