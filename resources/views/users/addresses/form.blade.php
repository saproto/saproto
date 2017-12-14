{!! csrf_field() !!}

<div class="row">

    <div class="col-md-6 col-xs-12">

        <!-- We need a map... //-->
        <div id="map" style="display: none;"></div>

        <!-- Actual form data in JSON //-->
        <div class="form-group">
            <label for="street" class="col-sm-3 control-label">Street</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="street" name="street" placeholder="Wallaby Way"
                       value="{{ $address->street or "" }}">
            </div>
        </div>
        <div class="form-group">
            <label for="number" class="col-sm-3 control-label">Number</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="number" name="number" placeholder="42"
                       value="{{ $address->number or "" }}">
            </div>
        </div>
        <div class="form-group">
            <label for="zipcode" class="col-sm-3 control-label">ZIP Code</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="2003FN"
                       value="{{ $address->zipcode or "" }}">
            </div>
        </div>
        <div class="form-group">
            <label for="city" class="col-sm-3 control-label">City</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="city" name="city" placeholder="Sydney"
                       value="{{ $address->city or "" }}">
            </div>
        </div>
        <div class="form-group">
            <label for="country" class="col-sm-3 control-label">Country</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="country" name="country" placeholder="Australia"
                       value="{{ $address->country or "" }}">
            </div>
        </div>

        <a href="{{ route("user::dashboard", ['id' => $user->id]) }}" class="btn btn-default pull-right" style="width: 100px;">
            Cancel
        </a>
        <button type="submit" class="btn btn-success pull-right" style="margin-right: 15px; width: 100px;">Save</button>

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