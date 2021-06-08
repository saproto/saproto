<form method="post"
      action="{{ ( !isset($dinnerformCurrent) ? route("dinnerform::add") : route("dinnerform::edit", ['id' => $dinnerformCurrent->id])) }}"
      enctype="multipart/form-data">

    {!! csrf_field() !!}

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Dinner form details
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <div class="row align-items-end mb-6">

                        <div class="col-md-12 mb-3">

                            <label for="restaurant">Dinner form restaurant:</label>
                            <input type="text" class="form-control" id="restaurant" name="restaurant"
                                   placeholder="Elat Roma"
                                   value="{{ $dinnerformCurrent->restaurant ?? '' }}"
                                   required
                            />

                        </div>
                    </div>

                    <div class="row align-items-end mb-6">
                        <div class="col-md-12 mb-3">

                            <label for="description">Description:</label>
                            <input type="text" class="form-control" id="description" name="description"
                                   placeholder="Order with us at Elat Roma" value="{{ $dinnerformCurrent->description ?? '' }}" required>

                        </div>
                    </div>
                    <div class="row align-items-end mb-6">
                        <div class="col-md-12 mb-3">

                            <label for="url">Url:</label>
                            <input type="text" class="form-control" id="url" name="url"
                                   value="{{ $dinnerformCurrent->url ?? 'https://forms.gle/t2hDEnkNCLXNpvYTA' }}" required>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="row align-items-end mb-6">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="dinnerform_start">dinnerform start:</label>
                                @include('website.layouts.macros.datetimepicker', [
                                    'name' => 'start',
                                    'format' => 'datetime',
                                    'placeholder' => $dinnerformCurrent ? $dinnerformCurrent->start->timestamp : null
                                ])
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="dinnerform_end">dinnerform end:</label>
                                @include('website.layouts.macros.datetimepicker',[
                                    'name' => 'end',
                                    'format' => 'datetime',
                                    'placeholder' => $dinnerformCurrent ? $dinnerformCurrent->end->timestamp : null
                                ])
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <div class="card-footer border-bottom">
            <button type="submit" class="btn btn-success">Submit</button>

            @if($dinnerformCurrent)
                <a href="{{ route("dinnerform::delete", ['id' => $dinnerformCurrent->id]) }}"
                   class="btn btn-danger ml-4">Delete</a>
            @endif
        </div>

    </div>

</form>