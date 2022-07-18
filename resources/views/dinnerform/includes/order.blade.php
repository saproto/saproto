<div class="row justify-content-center">

        <form method="post" action="{{ route('dinnerform::orderline::add', ['id'=>$dinnerform->id]) }}">

            {!! csrf_field() !!}

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    Add an order with us at {{$dinnerform->restaurant}}
                    <a href="{{"//".$dinnerform->url}}"
                       class="btn btn-success float-end me-3">
                        <i class="fas fa-utensils"></i> {{$dinnerform->restaurant}}'s website
                    </a>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="order">What do you want to order?</label>
                        <input class="form-control" id="order" name="order" type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="price">What does that cost?</label>
                        <input class="form-control" id="price" name="price" type="number" min="1" step="any"
                               required>
                    </div>
                    <div class="form-group">
                        Are you a helper at this event?
                        <input class="form-check-inline" id="helper" name="helper" type="checkbox">
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-success btn-block" value="Order!">
                </div>

            </div>
        </form>
    </div>