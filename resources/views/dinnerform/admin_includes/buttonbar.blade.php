<div class="card-footer border-bottom">

    <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit
    </button>

    @if($dinnerform)
        <a href="{{ route("dinnerform::delete", ['id' => $dinnerform->id]) }}"
           class="btn btn-danger pull-left">Delete</a>
    @endif

    <a href="{{ route("homepage") }}"
       class="btn btn-default pull-right">Back to homepage</a>

</div>