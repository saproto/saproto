<form method="post" action="{{ route("achievement::icon", ["id" => $achievement->id]) }}"
      enctype="multipart/form-data">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Set the icon
        </div>

        <div class="card-body">

            @include('website.layouts.macros.iconpicker', [
                'name' => 'fa_icon',
                'placeholder' => isset($achievement) ? $achievement->fa_icon : null,
                'label' => 'Achievement icon:'
            ])

            <button type="submit" class="btn btn-success btn-block">
                Save icon
            </button>

        </div>

    </div>

</form>