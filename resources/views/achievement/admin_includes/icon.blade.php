<form method="post" action="{{ route("achievement::icon", ["id" => $achievement->id]) }}"
      enctype="multipart/form-data">

    {!! csrf_field() !!}

    <input type="hidden" name="fa_icon" id="icon">

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Set the icon
        </div>

        <div class="card-body">

            <div class="form-group">
                <label data-placement="inline" class="icp icp-auto"
                       data-selected="{{  substr($achievement->fa_icon, 3) }}"></label>
            </div>

        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-success btn-block">
                Save icon
            </button>

        </div>

    </div>

</form>



@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        $('.icp-auto').iconpicker();
        $('.icp').on('iconpickerSelected', function (e) {
            $('#icon').val(e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue));
        });
    </script>
@endpush