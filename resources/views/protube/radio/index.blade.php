@extends('website.layouts.redesign.dashboard')

@section('page-title')
    ProTube Radio Station Admin
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                </div>

                <div class="card-body">

                    <form method="post" action="{{ route('protube::radio::store') }}">

                        {!! csrf_field() !!}

                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Stream name</label>
                                    <input class="form-control" type="text" name="name" placeholder="Proto Radio FM">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Stream URL</label>
                                    <input class="form-control" type="text" name="url" placeholder="Stream URL">
                                </div>
                            </div>

                            <div class="col-4">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fas fa-save mr-2" aria-hidden="true"></i> Save
                                </button>
                            </div>

                        </div>

                    </form>

                </div>

                <table class="table table-hover">

                    <thead>

                    <tr class="bg-dark text-white">

                        <td>Name</td>
                        <td>Stream URL</td>
                        <td>Controls</td>

                    </tr>

                    </thead>

                    <tbody>

                    @if (count($stations) > 0)

                        @foreach($stations as $station)

                            <tr>

                                <td>{{ $station->name }}</td>
                                <td>{{ $station->url }}</td>
                                <td>
                                    <a onclick="return confirm('Are you sure you want to delete {{ $station->name }}?');"
                                       href="{{ route('protube::radio::delete', ['id' => $station->id]) }}">
                                        <i class="fas fa-trash text-danger fa-fw"></i>
                                    </a>
                                    <a class="radio__test" data-url="{{ $station->url }}">
                                        <i class="fas fa-volume-up fa-fw"></i>
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    @endif

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        var radio = document.createElement("AUDIO");

        $("body").delegate('.radio__test', 'click', function () {
            stopPlaying();
            radio.src = $(this).attr('data-url');
            radio.play();
            $(this).removeClass('radio__test').addClass('radio__stop').html('<i class="fas fa-volume-mute fa-fw"></i>')
        });

        $("body").delegate('.radio__stop', 'click', function () {
            stopPlaying();
        });

        function stopPlaying() {
            $('.radio__stop').removeClass('radio__stop').addClass('radio__test').html('<i class="fas fa-volume-up fa-fw"></i>')
            radio.src = "";
        }

    </script>

@endsection