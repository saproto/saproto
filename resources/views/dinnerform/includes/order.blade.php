<div class="row justify-content-center">

    <form method="post" action="{{ route('dinnerform::orderline::add', ['id'=>$dinnerform->id]) }}">

        {!! csrf_field() !!}

        <div class="card mb-3">

            <div class="card-header bg-dark text-white">
                Add an order with us at {{$dinnerform->restaurant}}
                <a href="{{"//".$dinnerform->url}}" class="btn btn-success float-end me-3">
                    <i class="fas fa-utensils"></i> {{$dinnerform->restaurant}}'s website
                </a>
                @if($dinnerform->event)
                    <br>
                    <span class="text-muted">
                        <i><small>For the event: {{$dinnerform->event->title}}</small></i>
                    </span>
                @endif
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="order">What do you want to order?</label>
                    <input class="form-control" id="order" name="order" type="text" required>
                </div>
                <div class="form-group">
                    <label for="price">What does that cost?</label>
                    <input class="form-control" id="price" name="price" type="number" min="1" step="any" required>
                </div>
                @if(!$dinnerform->event_id)
                    <div class="form-check">
                        <input class="form-check-input" id="helper" name="helper" type="checkbox">
                        <label for="helper">Are you a helper at this event?</label>
                    </div>
                @else
                    <br>
                    <div class="form-group">
                        @if($dinnerform->event->activity && $dinnerform->event->activity->isHelping(Auth::user()))
                            <p class="card-text bg-info text-light text-center rounded">
                                <i>
                                    You are registered as a helper on this event and will receive the helper
                                    discount of €{{$dinnerform->discount}} off your order!
                                </i>
                            </p>
                        @else
                            <span class="text-muted">
                                <i>You are not registered as a helper on this event.</i>
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <div class="card-footer">
                <input type="submit" class="btn btn-success btn-block" value="Order!">
            </div>

        </div>
    </form>
</div>