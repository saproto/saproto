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

                            <label for="url">Restaurant website:</label>
                            <input type="text" class="form-control" id="url" name="url"
                                   placeholder='https://www.elat-roma.nl/'
                                   value="{{ $dinnerformCurrent->url ?? ''}}" required>
                        </div>
                    </div>
                    <div class="row align-items-end mb-6">
                        <div class="col-md-12 mb-3">

                            <label value="url">Helper discount €:</label>
                            <input type="value" class="form-control" id="discount" name="discount"
                                   placeholder='7.5'
                                   value="{{ $dinnerformCurrent->discount ?? ''}}" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="row align-items-end mb-6">

                        <div class="col-md-6">
                            @include('website.layouts.macros.datetimepicker', [
                                'name' => 'start',
                                'label' => 'Dinnerform start:',
                                'placeholder' => $dinnerformCurrent ? $dinnerformCurrent->start->timestamp : null
                            ])
                        </div>

                        <div class="col-md-6">
                            @include('website.layouts.macros.datetimepicker',[
                                'name' => 'end',
                                'label' => 'Dinnerform end:',
                                'placeholder' => $dinnerformCurrent ? $dinnerformCurrent->end->timestamp : null
                            ])
                        </div>

                    </div>
                    <div class="row align-items-end mb-6">
                        <div class="col-md-12 mb-3 mt-3 form-group autocomplete">
                            <label value="url">Event:</label>
                            <input class="form-control event-search" id="eventSelect" name="eventSelect"
                                   value="{{$dinnerformCurrent?$dinnerformCurrent->event_id:''}}"
                                   placeholder="{{($dinnerformCurrent && $dinnerformCurrent->event && $dinnerformCurrent->event->activity)?$dinnerformCurrent->event->title:''}}">
                        </div>
                    </div>


                    <div class="col-md-12 mb-3">
                        <input type="checkbox" class="form-check-input" id="homepage" name="homepage"
                               @if($dinnerformCurrent&&$dinnerformCurrent->visible_home_page||!$dinnerformCurrent)
                                   checked
                                @endif
                        />
                        <label for="homepage">Visible on the homepage?  </label>
                    </div>
                </div>

            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Submit</button>

            @if($dinnerformCurrent)
                <a href="{{ route("dinnerform::delete", ['id' => $dinnerformCurrent->id]) }}"
                   class="btn btn-danger ms-4">Delete</a>
            @endif
        </div>

    </div>

</form>