@php
    use App\Enums\PhotoEnum;
@endphp

<div class="col-lg-2 col-lg-3 col-md-4 col-sm-6">
    <div class="photo-select">
        <input
            name="photos[]"
            value="{{ $photo->id }}"
            type="checkbox"
            class="align-self-start"
            id="photo_{{ $photo->id }}"
        />
        <div class="card mb-3">
            <label
                for="photo_{{ $photo->id }}"
                class="card-img photo_pop d-inline-flex justify-content-between align-content-end"
                style="
                    display: flex;
                    height: 200px;
                    background-image: url({{ $photo->getUrl(PhotoEnum::SMALL) }});
                "
            >
                <p class="card-text ellipsis align-self-end mb-1">
                    @if ($photo->private)
                        <i
                            class="fas fa-eye-slash text-info ms-2 mb-1"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="This photo is only visible to members."
                        ></i>
                    @endif
                </p>

                <p class="align-self-end user-select-none me-2 mb-1">
                    {{ Carbon::createFromTimestamp($photo->date_taken) }}
                </p>
            </label>
        </div>
    </div>
</div>
