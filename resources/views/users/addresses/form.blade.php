{!! csrf_field() !!}

@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <script type="text/javascript">
            Materialize.toast('{{ $error }}', 3000, 'rounded')
        </script>
    @endforeach
@endif

<!-- Search bar //-->
<div class="form-group">
    <label for="address-string" class="control-label">Look up an address:</label>
    <input type="text" class="form-control" id="address-string" name="address-string"
           placeholder="42 Wallaby Way, Sydney">
</div>

<!-- Container for preview //-->
<ul id="autocomplete-results" class="list-group">
</ul>

<!-- We need a map... //-->
<div id="map" style="display: none;"></div>

<!-- Actual form data in JSON //-->
<input type="hidden" id="address-data" name="address-data">

<div class="form-group">
    <label for="address-preview" class="control-label">Your address will be:</label>
    <input type="text" class="form-control" id="address-preview" placeholder="Waiting for input..." disabled>
</div>

<hr>

<!-- Form controls //-->
<button type="submit" class="btn btn-success">Save</button>
<button onClick="javascript:history.go(-1)" class="btn btn-default">Cancel</button>

<!-- Form JS //-->
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ getenv('GOOGLE_KEY_PUBLIC') }}&libraries=places"></script>

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
                                $("#address-data").val(JSON.stringify(data));
                                $("#address-preview").val(data.street + " " + data.number + ", " + data.zipcode + " " + data.city + ", " + data.country)
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
