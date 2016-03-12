{!! csrf_field() !!}

        <!-- Search bar //-->
<div class="form-group">
    <label for="address-string" class="col-sm-3 control-label">Search</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="address-string" placeholder="42 Wallaby Way, Sydney">
    </div>
</div>

<!-- Container for preview //-->
<div class="form-group">
    <label for="address-string" class="col-sm-3 control-label">Results</label>
    <div class="col-sm-9">
        <ul id="autocomplete-results" class="list-group">
            <a class="list-group-item">Enter search term...</a>
        </ul>
    </div>
</div>

<hr>

<!-- We need a map... //-->
<div id="map" style="display: none;"></div>

<!-- Actual form data in JSON //-->
<div class="form-group">
    <label for="street" class="col-sm-3 control-label">Street</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="street" name="street" placeholder="Wallaby Way">
    </div>
</div>
<div class="form-group">
    <label for="number" class="col-sm-3 control-label">Number</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="number" name="number" placeholder="42">
    </div>
</div>
<div class="form-group">
    <label for="zipcode" class="col-sm-3 control-label">ZIP Code</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="2003FN">
    </div>
</div>
<div class="form-group">
    <label for="city" class="col-sm-3 control-label">City</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="city" name="city" placeholder="Sydney">
    </div>
</div>
<div class="form-group">
    <label for="country" class="col-sm-3 control-label">Country</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="country" name="country" placeholder="Australia">
    </div>
</div>

<hr>

<!-- Form controls //-->
<button type="submit" class="btn btn-success">Save</button>
<button onClick="javascript:history.go(-1)" class="btn btn-default">Cancel</button>

<!-- Form JS //-->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ getenv('GOOGLE_KEY_PUBLIC') }}&libraries=places"></script>

<script type="text/javascript">

    var autocomplete = new google.maps.places.AutocompleteService();

    $("#address-string").keyup(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        } else {
            autocomplete.getQueryPredictions({input: $(this).val()}, function (prediction, status) {
                if (status == "OK") {

                    $("#autocomplete-results").html("");

                    var i = 0;
                    for (p in prediction) {
                        if (i < 5) {
                            $("#autocomplete-results").append('<a href="#' + prediction[p].place_id + '" class="list-group-item autocomplete-result" data-id="' + prediction[p].place_id + '">' + prediction[p].description + '</a>');
                            i++;
                        }
                    }

                    $(".autocomplete-result").click(function () {
                        var service = new google.maps.places.PlacesService(new google.maps.Map(document.getElementById('map')));
                        service.getDetails({
                            placeId: $(this).attr('data-id')
                        }, function (place, status) {
                            if (status == "OK") {
                                var data = placeToObject(place);
                                $("#street").val(data.street);
                                $("#number").val(data.number);
                                $("#zipcode").val(data.zipcode);
                                $("#city").val(data.city);
                                $("#country").val(data.country);
                            }
                        });
                    });

                }
            });
        }
    });

    function placeToObject(place) {
        var o = {};
        for (a in place.address_components) {
            var comp = place.address_components[a];
            for (t in comp.types) {
                switch (comp.types[t]) {
                    case "street_number":
                        o.number = comp.long_name;
                        break;
                    case "route":
                        o.street = comp.long_name;
                        break;
                    case "locality":
                        o.city = comp.long_name;
                        break;
                    case "country":
                        o.country = comp.long_name;
                        break;
                    case "postal_code":
                        o.zipcode = comp.long_name;
                        break;
                }
            }
        }
        return o;
    }

</script>
