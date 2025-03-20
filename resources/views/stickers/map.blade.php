@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Proto's sticker tracker!
@endsection

@section('container')
    <div id="map"></div>

    <div class="modal fade" id="sticker-confirm-delete-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog model-sm" role="document">
            <form id="sticker-delete-form" method="POST">
                {{ csrf_field() }}
                <input
                    type="hidden"
                    name="_method"
                    value="DELETE"
                />
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm deleting your sticker</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            You placed it on <span id="sticker-delete-date"></span>
                            <image id="sticker-delete-image" class="mt-2" src="" style="width: 100%; display: block;"></image>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-default"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="confirm-button btn btn-danger"
                        >
                            Unstick my sticker
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="markerModal" tabindex="-1" aria-labelledby="markerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="markerModalLabel">Add a Proto Sticker!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="stickerForm"  method="post" action="{{ route('stickers.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="modal-lat" name="lat">
                        <input type="hidden" id="modal-lng" name="lng">
                        <div class="mb-3">
                        Please keep in mind that any pictures you upload here will be publicly available.
                        </div>
                        <div class="mb-3">
                            <label for="stickerImage" class="form-label">Upload Sticker Image</label>
                            <input class="form-control" type="file" id="stickerImage" name="sticker" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-success">Stick this sticker</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css"/>
@endpush

@push('stylesheet')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

    <style rel="stylesheet">
        #map { height: calc(100vh - 100px);
        margin-top: 56px;
        }
        .leaflet-popup-content{
            margin: 0;
            width:500px;
        }
        .leaflet-popup-content-wrapper{
            overflow: hidden;
        }
    </style>
@endpush

@push('javascript') <script type="text/javascript" nonce="{{ csp_nonce() }}">
    var map = L.map('map').setView([52.23888875842265, 6.85738688030243], 18);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const markerFiles =[
        'chip',
        'cloud',
        'gear',
        'heart',
        'light',
        'world'
    ];

    const markerIcons = markerFiles.map((path)=>{
        return L.icon({
            iconUrl: `images/logo/markers/${path}.png`,
            iconSize: [30, 60], // size of the icon
            iconAnchor: [12, 60], // point of the icon which will correspond to marker's location
            popupAnchor: [5, -55], // point from which the popup should open relative to the iconAnchor
        })
    })

    var locationButton = L.control({ position: 'topright' });

    locationButton.onAdd = function(map) {
        var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
        div.innerHTML = '<button id="locateMe" class="btn btn-primary">📍 My Location</button>';
        div.style.cursor = "pointer";

        L.DomEvent.on(div, 'click', function() {
            if (!navigator.geolocation) {
                alert("Geolocation is not supported by your browser.");
                return;
            }

            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude
                const lng = position.coords.longitude

                map.setView([lat, lng], 18); // Zoom into user's location
                addTempMarker(lat, lng)
            }, function() {
                alert("Unable to retrieve your location.");
            });
        });

        return div;
    };

    locationButton.addTo(map);

    const markers = L.markerClusterGroup()
    map.addLayer(markers);

    var tempMarker;

    const placedMarkers = {!! json_encode($stickers) !!}

    placedMarkers.forEach((marker) => {
        var markerInstance = L.marker([marker.lat, marker.lng], {icon: markerIcons[Math.floor(Math.random() * markerIcons.length)]});
        bindMarkerPopup(marker, markerInstance);
        markers.addLayer(markerInstance);
    });

    function bindMarkerPopup(marker, markerInstance){
        const popupContent = document.createElement('div')

        if (marker.image) {
            var img = document.createElement("img");
            img.src = marker.image;
            img.style.width = "100%";
            img.style.display = "block";
            popupContent.appendChild(img);
        }

        const detailsDiv = document.createElement('div')
        detailsDiv.className="d-flex flex-row justify-content-between ms-2 me-2";

        const ownerP = document.createElement('p')
        ownerP.innerHTML = `Stuck by: ${marker.user??'Legacy user'}`;
        detailsDiv.appendChild(ownerP);

        const dateP = document.createElement('p')
        dateP.innerHTML = `date: ${marker.date}`;
        detailsDiv.appendChild(dateP);

        popupContent.appendChild(detailsDiv);

        if (marker.is_owner) {
                var removeButton = document.createElement("button");
                removeButton.className = "btn btn-sm position-absolute top-0 start-0";
                removeButton.innerHTML = '<i class="h5 fas mt-2 ms-2 fa-trash text-danger"></i>';
                removeButton.addEventListener("click", function() {
                    removeSticker(marker, markerInstance);
                });
                popupContent.appendChild(removeButton);
        }
        markerInstance.bindTooltip(marker.user, {direction: 'top'})
        markerInstance.bindPopup(popupContent).openPopup();
    }

    function removeSticker(marker, markerInstance) {
        console.log('Remove sticker with id ' + marker.id);

        const deleteDate = document.getElementById('sticker-delete-date')
        deleteDate.textContent=marker.date;
        console.log(deleteDate)

        const deleteImage = document.getElementById('sticker-delete-image');
        deleteImage.src = marker.image;

        const deleteForm = document.getElementById('sticker-delete-form');
        deleteForm.action = '{{ route('stickers.destroy', ['sticker' => 'id']) }}'.replace(
            'id',
            marker.id
        );

        window.modals['sticker-confirm-delete-modal'].action = '{{ route('event::togglepresence', ['id' => 'id']) }}'.replace(
            'id',
            marker.id
        )
        window.modals['sticker-confirm-delete-modal'].show();

    }

    document.addEventListener("DOMContentLoaded", function() {
        map.on('click', onMapClick);
    });

    function onMapClick(e) {
        const lat = e.latlng.lat.toFixed(6)
        const lng = e.latlng.lng.toFixed(6)
        addTempMarker(lat, lng)
    }

    function addTempMarker(lat, lng){
        if (tempMarker) {
            if (tempMarker.getLatLng().lat === parseFloat(lat) && tempMarker.getLatLng().lng === parseFloat(lng)) {
                return; // Prevent reopening the popup on the same location
            }
            map.removeLayer(tempMarker);
        }

        tempMarker = L.marker([lat, lng]).addTo(map);
        var popupContent = document.createElement("div");
        popupContent.className="m-2"
        popupContent.innerHTML = `<p>Stick sticker at: ${lat}, ${lng}</p>`;

        var addButton = document.createElement("button");
        addButton.className = "btn btn-primary btn-sm";
        addButton.textContent = "Stick sticker here!";
        addButton.addEventListener("click", function() {
            confirmMarker(lat, lng);
        });

        var cancelButton = document.createElement("button");
        cancelButton.className = "btn btn-danger btn-sm";
        cancelButton.textContent = "Cancel";
        cancelButton.addEventListener("click", function() {
            cancelMarker();
        });

        const buttonDiv = document.createElement("div");
        buttonDiv.className = "d-flex flex-row justify-content-between";
        buttonDiv.appendChild(addButton);
        buttonDiv.appendChild(cancelButton);
        popupContent.appendChild(buttonDiv)

        tempMarker.bindPopup(popupContent).openPopup();
    }

    function confirmMarker(lat, lng) {
        document.getElementById("modal-lat").value = lat;
        document.getElementById("modal-lng").value = lng;
        window.modals.markerModal.show();
    }

    function cancelMarker() {
        if (tempMarker) {
            map.removeLayer(tempMarker);
            tempMarker = null;
        }
    }
</script>

@endpush
