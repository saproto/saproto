
<div class="row mt-2">

    <div class="col-md-6 col-xs-12">

        <form class="form-horizontal" method="POST"
              action="{{ $action == 'add' ? route('user::address::add', ['id' => $user->id]) : route('user::address::edit', ['id' => $user->id]) }}">

            {!! csrf_field() !!}

            <p class="text-center text-uppercase">
                The Netherlands<br>
                <img src="{{ asset('images/flags-large/nl.png') }}" height="70px;" class="rounded-lg mt-2 mb-2">
            </p>

            <hr>

            <div class="form-group">
                <label for="zipcode">ZIP Code</label>
                <input type="text" class="form-control" id="zipcode" name="zipcode-nl" placeholder="2003FN">
            </div>

            <div class="form-group mb-4">
                <label for="number">Street number</label>
                <input type="text" class="form-control" id="number" name="number-nl" placeholder="42">
            </div>

            <button type="submit" class="btn btn-success btn-block" name="nl-lookup">Look-up and save</button>

        </form>

    </div>

    <div class="col-md-6 col-xs-12">

        <form class="form-horizontal" method="POST"
              action="{{ $action == 'add' ? route('user::address::add', ['id' => $user->id]) : route('user::address::edit', ['id' => $user->id]) }}">

            {!! csrf_field() !!}

            <p class="text-center text-uppercase">
                World<br>
                <img src="{{ asset('images/flags-large/world.jpg') }}" height="70px;" class="rounded-lg mt-2 mb-2">
            </p>

            <hr>

            <div class="form-group">
                <label for="street">Street</label>
                <input type="text" class="form-control" id="street" name="street" placeholder="Wallaby Way" value="{{ $address->street ?? '' }}">
            </div>
            <div class="form-group">
                <label for="number">Number</label>
                <input type="text" class="form-control" id="number" name="number" placeholder="42" value="{{ $address->number ?? '' }}">
            </div>
            <div class="form-group">
                <label for="zipcode">ZIP Code</label>
                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="2003FN" value="{{ $address->zipcode ?? '' }}">
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Sydney" value="{{ $address->city ?? '' }}">
            </div>
            <div class="form-group mb-4">
                <label for="country">Country</label>
                <input type="text" class="form-control" id="country" name="country" placeholder="Australia" value="{{ $address->country ?? '' }}">
            </div>

            <button type="submit" class="btn btn-success btn-block">Save</button>

        </form>

    </div>

</div>