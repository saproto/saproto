<div class="card-footer border-bottom">

    <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit
    </button>

    @if($dinnerformCurrent)
        <a href="{{ route("dinnerform::delete", ['id' => $dinnerformCurrent->id]) }}"
           class="btn btn-danger pull-left">Delete</a>
    @endif

    <a href="{{ route("dinnerform::add") }}"></a>

</div>