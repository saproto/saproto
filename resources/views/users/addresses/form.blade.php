{!! csrf_field() !!}

<div class="row">

    <div class="col-md-6 col-xs-12">

        <!-- We need a map... //-->
        <div id="map" style="display: none;"></div>

        <!-- Actual form data in JSON //-->
        <div class="form-group">
            <label for="street">Street</label>
            <input type="text" class="form-control" id="street" name="street" placeholder="Wallaby Way"
                   value="{{ $user->address->street or "" }}">
        </div>
        <div class="form-group">
            <label for="number">Number</label>
            <input type="text" class="form-control" id="number" name="number" placeholder="42"
                   value="{{ $user->address->number or "" }}">
        </div>
        <div class="form-group">
            <label for="zipcode">ZIP Code</label>
            <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="2003FN"
                   value="{{ $user->address->zipcode or "" }}">
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Sydney"
                   value="{{ $user->address->city or "" }}">
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" class="form-control" id="country" name="country" placeholder="Australia"
                   value="{{ $user->address->country or "" }}">
        </div>

    </div>

    <div class="col-md-6 col-xs-12">

        <div class="panel">
            <div class="panel-body">

                <p>You can use the form below to search for an address and auto-complete the form. You can also manually
                    fill in the form.</p>

                <input type="text" class="form-control" id="address-string"
                       placeholder="42 Wallaby Way, Sydney">

                <hr>

                <ul id="autocomplete-results" class="list-group">
                    <a class="list-group-item">Enter search term...</a>
                </ul>

            </div>
        </div>

    </div>

</div>