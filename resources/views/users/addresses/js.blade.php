<!-- Form JS //-->
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ config('app-proto.google-key-public') }}&libraries=places"></script>

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