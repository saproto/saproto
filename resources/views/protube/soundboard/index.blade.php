@extends('website.layouts.redesign.dashboard')

@section('page-title')
    ProTube Soundboard Admin
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                </div>

                <table class="table table-hover">

                    <thead>

                    <tr>

                        <th>Name</th>
                        <th>Controls</th>

                    </tr>

                    </thead>

                    <tbody>

                    @if (count($sounds) > 0)

                        @foreach($sounds as $sound)

                            <tr>

                                <td>
                                    <a href="{{ $sound->file->generatePath() }}">
                                        <i class="fas fa-cloud-download-alt fa-fw mr-2"></i>
                                    </a>
                                    {{ $sound->name }}
                                </td>
                                <td>
                                    <a class="btn btn-danger"
                                       onclick="return confirm('Are you sure you want to delete {{ $sound->name }}?');"
                                       href="{{ route('protube::soundboard::delete', ['id' => $sound->id]) }}">
                                        <i class="fas fa-trash mr-2"></i> Delete
                                    </a>
                                    <div class="btn btn-success sound__test" data-url="{{ $sound->file->generatePath() }}">
                                        <i class="fas fa-volume-up"></i> Test
                                    </div>
                                    <a class="btn btn-success"
                                       href="{{ route('protube::soundboard::togglehidden', ['id' => $sound->id]) }}">
                                        @if($sound->hidden) <i class="fas fa-eye"></i> Unhide @else <i class="fas fa-eye-slash"></i> Hide @endif
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    @endif

                    <form method="post" action="{{ route('protube::soundboard::store') }}" enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <tr>

                            <td>
                                <div class="row">
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" name="name" placeholder="Sound name">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="sound">
                                            <label class="custom-file-label">MP3</label>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-2" aria-hidden="true"></i> Save
                                </button>
                            </td>

                        </tr>

                    </form>

                    </tbody>

                </table>

                <div class="card-footer pb-0">
                    {!! $sounds->links() !!}
                </div>

            </div>

        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script type="text/javascript">

        var sound = document.createElement("AUDIO");

        $("body").delegate('.sound__test', 'click', function () {
            sound.src = $(this).attr('data-url');
            sound.play();
        });

    </script>

@endsection
