@extends('website.layouts.redesign.dashboard')

@section('page-title')
    {{ ($leaderboard == null ? "Create new leaderboard." : "Edit leaderboard: " . $leaderboard->name .".") }}
@endsection

@section('container')

    <div class="row justify-content-center">

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
                            <label for="organisation">Committee: {{$leaderboard->committee->name ?? ''}}</label>
                            <select class="form-control committee-search" id="organisation" name="committee" required>
                                <option value="{{$leaderboard && $leaderboard->committee_id ? $leaderboard->committee_id : ""}}"></option>
                            </select>
                        </div>

                        @if($leaderboard)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" {{ $leaderboard->featured ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">
                                    Feature this leaderboard on the home page. <i class="fas fa-sm fa-star"></i>
                                </label>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="name">Leaderboard name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Proto drink beer scores" value="{{ $leaderboard->name ?? '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="points_name">Points name:</label>
                            <input type="text" class="form-control" id="points_name" name="points_name"
                                   placeholder="Beers" value="{{ $leaderboard->points_name ?? '' }}" required>
                        </div>

                        <input type="hidden" name="icon" id="icon" required>
                        <div class="form-group">
                            <label for="name">Icon:</label>
                                <label data-placement="inline" class="icp icp-auto"
                                       data-selected="{{$leaderboard ? $leaderboard->icon : ''}}"></label>
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
                        <button type="submit" class="btn btn-success float-right ml-2">
                            Submit
                        </button>
                        @if($leaderboard != null)
                            <a class="btn btn-danger float-right" href="{{ route("leaderboards::delete", ['id'=>$leaderboard->id]) }}">Delete</a>
                        @endif
                    </div>

                </div>

            </form>

        </div>


        @if ($leaderboard)

            <div class="col-md-5 mb-3">

                <form method="post"
                      action="{{ route("leaderboards::entries::add")}}"
                      enctype="multipart/form-data">

                    {!! csrf_field() !!}

                    <input type="hidden" name="leaderboard_id" value="{{ $leaderboard->id }}">

                    <div class="card md-3">

                        <div class="card-header bg-dark text-white">
                            {{ ($leaderboard == null ? "Add entries" : "Edit entries for Leaderboard: " . $leaderboard->name)}}
                        </div>

                        <div class="card-body">

                            @if(count($entries) > 0)
                                <form action="">
                                    <div class="table-responsive">

                                        <table class="table table-sm table-hover mb-0">

                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>{{ $leaderboard->points_name }} <i class="ml-1 {{ $leaderboard->icon }}"></i></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($entries as $entry)
                                                    <tr>
                                                        <td>#{{ $loop->index+1 }}</td>
                                                        <td>{{ $entry->user->name }}</td>
                                                        <td style="width: 80px">
                                                            <input id="le_{{ $entry->id }}" data-id="{{ $entry->id }}" value="{{ $entry->points}}" class="le_points">
                                                        </td>
                                                        <td style="min-width: 60px">
                                                            <a data-id="{{ $entry->id }}" class="fa fas fa-lg fa-caret-up ml-2 le_increase"></a>
                                                            <a data-id="{{ $entry->id }}" class="fa fas fa-lg fa-caret-down ml-1 le_decrease"></a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('leaderboards::entries::delete', ['id' => $entry->id]) }}">
                                                                <i class="fas fa-trash text-danger fa-fw"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>

                                    </div>
                                </form>

                            @else
                                <p>No entries yet, add entries here.</p>
                            @endif

                        </div>

                        <div class="card-footer">
                            <div class="form-group mb-0">

                                <div class="row">
                                    <div class="col-9">
                                        <select class="form-control user-search" name="user_id" required></select>
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-outline-primary btn-block" type="submit">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </form>
            </div>

        @endif

    </div>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

    </script>

    <script type="text/javascript">
        $('.icp-auto').iconpicker();
        $('.icp').on('iconpickerSelected', function (e) {
            $('#icon').val(e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue));
        });

        $(function() {
            $('.le_points').on('change', function(e) {
                let id = $(e.target).attr('data-id');
                let points = parseInt($(`.le_points[data-id='${id}']`).val())
                updatePoints(id, points);
            });

            $('.le_increase').on('click', function(e) {
                let id = $(e.target).attr('data-id');
                let points = parseInt($(`.le_points[data-id='${id}']`).val())+1;
                updatePoints(id, points);
            });

            $('.le_decrease').on('click', function(e) {
                let id = $(e.target).attr('data-id');
                let points = parseInt($(`.le_points[data-id='${id}']`).val())-1;
                updatePoints(id, points);
            });
        });

        function updatePoints(id, points) {
            let data = new FormData();
            data.append('id', id);
            data.append('points', points);
            data.append('_token', '{{ csrf_token() }}');
            $.ajax({
                type: 'POST',
                url: '{{ route('leaderboards::entries::update') }}',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $(`.le_points[data-id='${id}']`).val(response.points);
                },
                error: function() {
                    window.alert('Something went wrong while updating the points. Please try again.');
                }
            })
        }
    </script>

@endsection