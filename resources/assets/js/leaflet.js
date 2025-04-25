import { GeoSearchControl, OpenStreetMapProvider } from 'leaflet-geosearch'
window.GeoSearch = new GeoSearchControl({
    provider: new OpenStreetMapProvider(),
    style: 'bar',
    resetButton: '🔍',
    showMarker: false,
    animateZoom: true,
})
import 'leaflet'
import 'leaflet.markercluster'
