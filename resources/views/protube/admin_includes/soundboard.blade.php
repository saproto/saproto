<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        <i class="fas fa-volume-up fa-fw me-3"></i> Soundboard
    </div>

    <div class="card-body">

        <div class="row">

            @foreach($sounds as $sound)
                <div class="col-md-4 mb-2">
                    <button type="button" class="btn btn-outline-dark soundboard ellipsis w-100" rel="{{ $sound->id }}">
                        {{ $sound->name }}
                    </button>
                </div>
            @endforeach

        </div>

    </div>

</div>