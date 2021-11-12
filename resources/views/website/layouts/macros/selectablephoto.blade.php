<div class="col-lg-2 col-lg-3 col-md-4 col-sm-6">
    <div class="photo-select">
        <input name="photo[{{ $photo->id }}]" type="checkbox"
               style="align-self: flex-start;" id="photo_{{ $photo->id }}">
        <div class="card mb-3">
            <label for="photo_{{ $photo->id }}" class="card-img photo_pop"
                   style="display: flex; height: 200px; background-image: url({{ $photo->thumb() }});">
                @if($photo->private)
                    <p class="card-text ellipsis" style="align-self: flex-end;">
                        <i class="fas fa-eye-slash ms-4 me-2 text-info"
                           data-toggle="tooltip" data-placement="top"
                           title="This photo is only visible to members."></i>
                    </p>
                @endif
            </label>

        </div>
    </div>

</div>