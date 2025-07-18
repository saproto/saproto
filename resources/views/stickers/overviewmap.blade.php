@extends('website.layouts.redesign.generic-nonavandfooter')

@section('page-title')
    Proto's sticker tracker!
@endsection

@vite('resources/assets/js/echo.js')
@vite('resources/assets/js/leaflet.js')
@vite('node_modules/leaflet/dist/leaflet.css')

@section('container')
    <div class="card mt-3 mb-3">
        <div class="card-header bg-dark text-white">
            <div class="d-flex justify-content-between">
                <div>The Proto Sticker Tracker!</div>
                <div>
                    In total
                    <span id="sticker-amount"></span>
                    stickers placed!
                </div>
            </div>
        </div>
    </div>

    <div id="map" class="mb-3"></div>
@endsection

@push('stylesheet')
    <style rel="stylesheet">
        main#nonavandfooter {
            border: 0px;
            height: 100%;
            overflow: hidden;
            padding-top: 0px !important;
            display: flex;
            flex-direction: column;
        }
        #map {
            flex-grow: 1;
        }
    </style>
@endpush

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        window.addEventListener('load', () => {
            window.Echo.channel(`stickers`)
                .listen('StickerPlacedEvent', (marker) => {
                    addMarkerToMap(marker)
                })
                .error((error) => {
                    console.error(error)
                    setTimeout(() => {
                        window.location.reload()
                    }, 10000)
                })

            const map = L.map('map').setView([52.00888875842265, 5.70001], 7)
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution:
                    '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            }).addTo(map)

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
                    iconUrl: `/images/logo/markers/${path}.png`,
                    iconSize: [15, 30], // size of the icon
                    iconAnchor: [7, 32], // point of the icon which will correspond to marker's location
                    popupAnchor: [5, -55], // point from which the popup should open relative to the iconAnchor
                })
            })

            let stickerAmount = document.getElementById('sticker-amount')

            var markerCount = 0
            const placedMarkers = {!! json_encode($stickers) !!}

            placedMarkers.forEach((marker) => {
                addMarkerToMap(marker)
            })
            function addMarkerToMap(marker) {
                L.marker([marker.lat, marker.lng], {
                    icon: markerIcons[
                        Math.floor(Math.random() * markerIcons.length)
                    ],
                }).addTo(map)
                markerCount++
                stickerAmount.textContent = markerCount
            }
        })
    </script>
@endpush
