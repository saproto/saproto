@extends('website.layouts.redesign.generic')

@section('page-title')
    Proto's sticker tracker!
@endsection

@vite('resources/assets/js/echo.js')
@vite('resources/assets/js/leaflet.js')
@vite('node_modules/leaflet-geosearch/dist/geosearch.css')
@vite('node_modules/leaflet.markercluster/dist/MarkerCluster.css')
@vite('node_modules/leaflet/dist/leaflet.css')

@section('container')
    <div class="card mb-3 mt-3">
        <div class="card-header bg-dark text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>The Proto Sticker Tracker!</div>
                <div>
                    In total
                    <span id="sticker-amount"></span>
                    stickers placed!
                </div>
                @can('board')
                    <a
                        href="{{ route('stickers.admin') }}"
                        class="btn btn-info"
                    >
                        <i class="fas fa-edit"></i>
                        <span class="d-none d-sm-inline">Sticker admin</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div id="map"></div>

    <div
        class="modal fade"
        id="sticker-report-modal"
        tabindex="-1"
        role="dialog"
    >
        <div class="modal-dialog model-sm" role="document">
            <form id="sticker-report-form" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="POST" />
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Report a sticker</h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            The sticker you want to report
                            <img
                                id="sticker-report-image"
                                class="mt-2"
                                src=""
                                style="width: 100%; display: block"
                            />
                        </div>
                        <div>
                            The reason you want to report this sticker
                            <input
                                type="text"
                                class="form-control mt-2"
                                name="report_reason"
                                placeholder="Please provide a reason for reporting this sticker."
                                minlength="3"
                                maxlength="255"
                                required
                            />
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
                            Report this sticker
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div
        class="modal fade"
        id="sticker-confirm-delete-modal"
        tabindex="-1"
        role="dialog"
    >
        <div class="modal-dialog model-sm" role="document">
            <form id="sticker-delete-form" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE" />
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Confirm deleting your sticker
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            You placed it on
                            <span id="sticker-delete-date"></span>
                            <img
                                id="sticker-delete-image"
                                class="mt-2"
                                src=""
                                style="width: 100%; display: block"
                            />
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

    <div
        class="modal fade"
        id="markerModal"
        tabindex="-1"
        aria-labelledby="markerModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="markerModalLabel">
                        Add a Proto Sticker!
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <form
                        id="stickerForm"
                        method="post"
                        action="{{ route('stickers.store') }}"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        <input type="hidden" id="modal-lat" name="lat" />
                        <input type="hidden" id="modal-lng" name="lng" />
                        <div class="mb-3">
                            Please keep in mind that any pictures you upload
                            here will be publicly available.
                        </div>
                        <div class="mb-3">
                            <div
                                class="d-inline-flex w-100 justify-content-between"
                            >
                                <label for="stickerImage" class="form-label">
                                    Upload Sticker Image
                                </label>

                                @include(
                                    'components.forms.checkbox',
                                    [
                                        'name' => 'today_checkbox',
                                        'checked' => $cur_category->can_reply ?? true,
                                        'label' => 'Today',
                                    ]
                                )
                            </div>
                            <input
                                class="form-control"
                                type="file"
                                id="stickerImage"
                                name="sticker"
                                accept="image/jpg, image/jpeg"
                            />

                            @include(
                                'components.forms.datetimepicker',
                                [
                                    'name' => 'stick_date',
                                    'label' => 'Stuck on:',
                                    'placeholder' => Carbon::now()->timestamp,
                                    'form_class_name' => 'd-none',
                                    'format' => 'date',
                                ]
                            )
                            <img
                                id="previewImg"
                                class="mt-3"
                                src=""
                                alt="Photo Preview"
                            />
                        </div>

                        <button
                            id="stickerSubmit"
                            type="submit"
                            class="btn btn-success"
                            disabled="disabled"
                        >
                            Stick this sticker!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
    
@endpush

@push('stylesheet')
    <style rel="stylesheet">
        #map {
            height: 75%;
        }
        .leaflet-popup-content {
            margin: 0;
        }
        .leaflet-popup-content-wrapper {
            overflow: hidden;
        }

        .cluster-icon {
            background:
                linear-gradient(0, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),
                url('images/logo/markers/light.png');
            border-radius: 50%;
            background-size: contain;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.5em;
        }

        .results {
            color: black;
        }
        div[data-key] {
            cursor: pointer;
        }
        div[data-key]:hover {
            background-color: var(--bs-primary);
        }
    </style>
@endpush

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        window.addEventListener('load', () => {
            window.Echo.channel(`stickers`)
                .listen('StickerPlacedEvent', (marker) => {
                    addMarkerToMap(marker)
                    updateMarkerCount()
                })
                .listen('StickerRemovedEvent', (marker) => {
                    removeMarkerFromMap(marker.id)
                    updateMarkerCount()
                })
                .error((error) => {
                    console.error(error)
                    setTimeout(() => {
                        window.location.reload()
                    }, 10000)
                })

            const url = new URL(window.location.href)
            let currentZoom = url.searchParams.get('zoom') ?? 18
            let currentLat = url.searchParams.get('lat') ?? 52.23888875842265
            let currentLng = url.searchParams.get('lng') ?? 6.85738688030243

            const markerInstances = new Map()

            const map = L.map('map', {
                minZoom: 2,
                worldCopyJump: true,
                maxBoundsViscosity: 0.9,
            }).setView([currentLat, currentLng], currentZoom)

            const bounds = [
                [-90, -180],
                [90, 180],
            ]
            map.setMaxBounds(bounds)

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution:
                    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            }).addTo(map)

            map.addControl(window.GeoSearch)

            const markerFiles = [
                'chip',
                'cloud',
                'gear',
                'heart',
                'light',
                'world',
            ]

            const markerIcons = markerFiles.map((path) => {
                return L.icon({
                    iconUrl: `images/logo/markers/${path}.png`,
                    iconSize: [30, 60], // size of the icon
                    iconAnchor: [12, 60], // point of the icon which will correspond to marker's location
                    popupAnchor: [5, -55], // point from which the popup should open relative to the iconAnchor
                })
            })

            var locationButton = L.control({ position: 'topright' })

            locationButton.onAdd = function (map) {
                var div = L.DomUtil.create(
                    'div',
                    'leaflet-bar leaflet-control leaflet-control-custom'
                )
                div.innerHTML =
                    '<button id="locateMe" class="btn btn-primary"><i class="fas fa-location-dot"></i></button>'
                div.style.cursor = 'pointer'

                L.DomEvent.on(div, 'click', function (ev) {
                    L.DomEvent.stopPropagation(ev)
                    if (!navigator.geolocation) {
                        alert('Geolocation is not supported by your browser.')
                        return
                    }

                    navigator.geolocation.getCurrentPosition(
                        function (position) {
                            const lat = position.coords.latitude
                            const lng = position.coords.longitude

                            map.flyTo([lat, lng], 18) // Zoom into user's location
                            addTempMarker(lat, lng)
                        },
                        function () {
                            alert('Unable to retrieve your location.')
                        }
                    )
                })

                return div
            }

            locationButton.addTo(map)

            const markers = L.markerClusterGroup({
                animateAddingMarkers: true,
                iconCreateFunction: (cluster) => {
                    const childCount = cluster.getChildCount()
                    return new L.DivIcon({
                        html: '<div><span>' + childCount + '</span></div>',
                        className: 'cluster-icon',
                        iconSize: [40, 40],
                    })
                },
            })
            map.addLayer(markers)

            var tempMarker

            const placedMarkers = {!! json_encode($stickers) !!}

            placedMarkers.forEach((marker) => {
                addMarkerToMap(marker)
            })

            function updateMarkerCount() {
                let stickerAmount = document.getElementById('sticker-amount')
                stickerAmount.textContent = markers.getLayers().length
            }
            updateMarkerCount()

            function addMarkerToMap(marker) {
                const markerInstance = L.marker([marker.lat, marker.lng], {
                    icon: markerIcons[
                        Math.floor(Math.random() * markerIcons.length)
                    ],
                })
                bindMarkerPopup(marker, markerInstance)
                markerInstances.set(marker.id, markerInstance)
                markers.addLayer(markerInstance)
            }

            function removeMarkerFromMap(markerId) {
                const markerInstance = markerInstances.get(markerId)
                markers.removeLayer(markerInstance)
                markerInstances.delete(markerId)
            }

            function bindMarkerPopup(marker, markerInstance) {
                const popupContent = document.createElement('div')

                if (marker.image) {
                    const img = document.createElement('img')
                    img.src = marker.image
                    img.style.width = '100%'
                    popupContent.appendChild(img)
                    img.loading = 'lazy'
                }

                const detailsDiv = document.createElement('div')
                detailsDiv.className = 'mx-2 mt-2'

                const ownerP = document.createElement('div')
                ownerP.innerHTML = `Stuck by: ${marker.is_owner ? 'you!' : (marker.user ?? 'Unknown')}`
                detailsDiv.appendChild(ownerP)

                const dateP = document.createElement('div')
                dateP.innerHTML = `On: ${marker.date}`
                detailsDiv.appendChild(dateP)

                popupContent.appendChild(detailsDiv)

                const controlsDiv = document.createElement('div')
                controlsDiv.className =
                    'w-100 d-inline-flex text-center justify-content-center'
                const isBoard = '{{ Auth::user()->can('board') }}'
                if (marker.is_owner || isBoard) {
                    const removeButton = document.createElement('button')
                    removeButton.className = 'btn btn-sm'
                    removeButton.innerHTML =
                        '<i class="h5 fas fa-trash text-danger"></i>'
                    removeButton.addEventListener('click', function () {
                        removeSticker(marker)
                    })
                    controlsDiv.appendChild(removeButton)
                }

                if (!marker.is_owner || isBoard) {
                    const reportButton = document.createElement('button')
                    reportButton.className = 'btn btn-sm'
                    reportButton.innerHTML =
                        '<i class="h5 fas fa-triangle-exclamation text-warning"></i>'
                    reportButton.addEventListener('click', function () {
                        reportSticker(marker)
                    })
                    controlsDiv.appendChild(reportButton)
                }

                popupContent.appendChild(controlsDiv)

                markerInstance.bindTooltip(marker.user, {
                    direction: 'top',
                    offset: [5, -55],
                })
                markerInstance.bindPopup(popupContent).openPopup()
            }

            let checkbox = document.getElementById('today_checkbox')
            checkbox?.addEventListener('change', function () {
                if (checkbox.checked) {
                    document
                        .getElementById('datetimepicker-stick_date-form')
                        .classList.add('d-none')
                } else {
                    document
                        .getElementById('datetimepicker-stick_date-form')
                        .classList.remove('d-none')
                }
            })

            function removeSticker(marker) {
                const deleteDate = document.getElementById(
                    'sticker-delete-date'
                )
                deleteDate.textContent = marker.date

                const deleteImage = document.getElementById(
                    'sticker-delete-image'
                )
                deleteImage.src = marker.image

                const deleteForm = document.getElementById(
                    'sticker-delete-form'
                )
                deleteForm.action =
                    '{{ route('stickers.destroy', ['sticker' => 'id']) }}'.replace(
                        'id',
                        marker.id
                    )

                window.modals['sticker-confirm-delete-modal'].show()
            }
            const reportForm = document.getElementById('sticker-report-form')

            function reportSticker(marker) {
                const reportImage = document.getElementById(
                    'sticker-report-image'
                )
                reportImage.src = marker.image

                reportForm.action =
                    '{{ route('stickers.report', ['sticker' => 'id']) }}'.replace(
                        'id',
                        marker.id
                    )
                reportForm.setAttribute('data-sticker-id', marker.id)

                window.modals['sticker-report-modal'].show()
            }

            map.on('click', onMapClick)
            map.on('moveend', () => {
                const center = map.getCenter()
                const url = new URL(window.location.href)
                url.searchParams.set('lat', center.lat)
                url.searchParams.set('lng', center.lng)
                window.history.replaceState(null, '', url.toString())
            })
            map.on('zoomend', function () {
                const zoomLevel = map.getZoom()
                const url = new URL(window.location.href)
                url.searchParams.set('zoom', zoomLevel)
                window.history.replaceState(null, '', url.toString())
            })

            function onMapClick(e) {
                const lat = e.latlng.lat.toFixed(6)
                const lng = e.latlng.lng.toFixed(6)
                addTempMarker(lat, lng)
            }

            function addTempMarker(lat, lng) {
                if (tempMarker) {
                    if (
                        tempMarker.getLatLng().lat === parseFloat(lat) &&
                        tempMarker.getLatLng().lng === parseFloat(lng)
                    ) {
                        return // Prevent reopening the popup on the same location
                    }
                    map.removeLayer(tempMarker)
                }

                tempMarker = L.marker([lat, lng], {
                    icon: markerIcons[4],
                }).addTo(map)
                var popupContent = document.createElement('div')
                popupContent.className = 'm-3'
                popupContent.innerHTML = `<p>Stick at: ${lat}, ${lng}</p>`

                var addButton = document.createElement('button')
                addButton.className = 'btn btn-primary btn-sm'
                addButton.textContent = 'Stick sticker here!'
                addButton.addEventListener('click', function () {
                    confirmMarker(lat, lng)
                })

                var cancelButton = document.createElement('button')
                cancelButton.className = 'btn btn-danger btn-sm'
                cancelButton.textContent = 'Cancel'
                cancelButton.addEventListener('click', function () {
                    cancelMarker()
                })

                const buttonDiv = document.createElement('div')
                buttonDiv.className = 'd-flex flex-row justify-content-between'
                buttonDiv.appendChild(addButton)
                buttonDiv.appendChild(cancelButton)
                popupContent.appendChild(buttonDiv)

                tempMarker
                    .bindPopup(popupContent, {
                        closeButton: false,
                    })
                    .openPopup()
            }

            function confirmMarker(lat, lng) {
                document.getElementById('modal-lat').value = lat
                document.getElementById('modal-lng').value = lng
                window.modals.markerModal.show()
            }

            function cancelMarker() {
                if (tempMarker) {
                    map.removeLayer(tempMarker)
                    tempMarker = null
                }
            }

            const imgInput = document.querySelector('#stickerImage')
            const previewImg = document.querySelector('#previewImg')
            const stickerSubmit = document.querySelector('#stickerSubmit')
            imgInput.addEventListener('input', (e) => {
                stickerSubmit.disabled = true
                const file = e.target.files[0]
                if (!file) return

                const reader = new FileReader()
                reader.onload = function (readerEvent) {
                    const image = new Image()
                    image.onload = function () {
                        //resize to the largest side of 1920px
                        const maxSize = 1920
                        const oldWidth = image.naturalWidth
                        const oldHeight = image.naturalHeight
                        const scale = Math.min(
                            maxSize / oldWidth,
                            maxSize / oldHeight,
                            1
                        )

                        const width = oldWidth * scale
                        const height = oldHeight * scale

                        const canvas = document.createElement('canvas')
                        canvas.width = width
                        canvas.height = height
                        canvas
                            .getContext('2d')
                            .drawImage(image, 0, 0, width, height)

                        // Convert to Blob
                        canvas.toBlob(
                            (blob) => {
                                const newFile = new File([blob], file.name, {
                                    type: 'image/jpeg',
                                    lastModified: Date.now(),
                                })

                                // Replace the input file with the new resized file
                                const dataTransfer = new DataTransfer()
                                dataTransfer.items.add(newFile)
                                imgInput.files = dataTransfer.files

                                // Show preview
                                previewImg.src = URL.createObjectURL(blob)
                                previewImg.onload = () => {
                                    URL.revokeObjectURL(previewImg.src)
                                }
                                stickerSubmit.disabled = false
                            },
                            'image/jpeg',
                            0.75
                        )
                    }
                    image.src = readerEvent.target.result
                }
                reader.readAsDataURL(file)
            })
        })
    </script>
@endpush
