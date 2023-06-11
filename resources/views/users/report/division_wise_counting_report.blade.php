<x-app-layout>
    <x-slot name="title">
        Survey Report
    </x-slot>
    @push('styles')
        <style>

        </style>
    @endpush
    <div class="row">
        <div class="col-md-12 text-center">
            <h3 class="text-center">Division Wise Counting Report</h3>
            <div class="row">
                <div class="col-md-12">
                    <div id="mapPanel" style="height:800px; width:100%; position:relative">
                        <div id="map" style="height:100%; width:100%;"></div>
                        <div
                            style="position:absolute; top:50px; right:50px; padding:3px; height:18px; background:#fe6223; border-radius:3px;">
                            Poultry</div>
                        <div
                            style="position:absolute; top:75px; right:50px; padding:3px; height:18px; background:#f6cb2b; border-radius:3px;">
                            Wild Bird</div>
                        <div
                            style="position:absolute; top:100px; right:50px; padding:3px; height:18px; background:#17d27c; border-radius:3px;">
                            LBM Worker</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC08AOyEIZxUheEbBU8-BXrW_4M42oF8JQ&callback=initMap"
            defer></script>
        <script>
            // For latitude and longitude addition/subtraction do:
            var meters = 10000;

            // number of km per degree = ~111km (111.32 in google maps, but range varies
            // between 110.567km at the equator and 111.699km at the poles)
            //
            // 111.32km = 111320.0m (".0" is used to make sure the result of division is
            // double even if the "meters" variable can't be explicitly declared as double)
            var coef = meters / 111320.0;

            let map;
            // global array to store the marker object 
            let markersArray = [];

            function initMap() {
                const Bangladesh = {
                    lat: 23.684994,
                    lng: 90.356331
                };
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 7,
                    center: Bangladesh,
                    gestureHandling: "none",
                    zoomControl: false,
                });

                // create marker

                @if ($googleMapResult)
                    @foreach ($googleMapResult as $row)
                        @php
                            $poultry = $row->TOTAL_POULTRY;
                            $wildBird = $row->TOTAL_WILD_BIRD;
                            $lblWorker = $row->TOTAL_LBM_WORKER;
                            // $webspice = new \App\Lib\Webspice();
                            $location = $webspice->getGeoData($row->division, 'location');
                        @endphp
                        @if (!$location)
                            continue;
                        @endif ;

                        // add poultry marker
                        var newMarker = {
                            lat: {{ isset($location->lat) ? $location->lat : '' }},
                            lng: {{ isset($location->lng) ? $location->lng : '' }}
                        };
                        addMarker(newMarker, '{{ $poultry }}', title = 'Poultry', icon = 'icon-marker-ir.png');

                        // add wild bird marker
                        var new_lat = {{ isset($location->lat) ? $location->lat : '' }} + coef;
                        var new_long = {{ isset($location->lng) ? $location->lng : '' }} + coef / Math.cos(
                            {{ isset($location->lat) ? $location->lat : '' }} * 0.01745);
                        var newMarker = {
                            lat: new_lat,
                            lng: new_long
                        };
                        addMarker(newMarker, '{{ $wildBird }}', title = 'Wild Bird', icon = 'icon-marker-y.png');

                        // add LBM Worker marker
                        var new_lat = {{ isset($location->lat) ? $location->lat : '' }} + coef;
                        var new_long = {{ isset($location->lng) ? $location->lng : '' }} - coef / Math.cos(
                            <?php echo isset($location->lat) ? $location->lat : ''; ?> *
                            0.01745);
                        var newMarker = {
                            lat: new_lat,
                            lng: new_long
                        };
                        addMarker(newMarker, '{{ $lblWorker }}', title = 'LBM Worker', icon = 'icon-marker-g.png');
                    @endforeach ;
                @endif ;
            }

            function addMarker(latLng, label = "", title = '', icon = 'icon-marker-r.png') {
                let icon_url = "{{ asset('public/icons') }}/" + icon;

                let marker = new google.maps.Marker({
                    map: map,
                    position: latLng,
                    label: label,
                    title: title,
                    icon: {
                        url: icon_url,
                        scaledSize: new google.maps.Size(40, 40)
                    }
                });

                //store the marker object drawn in global array
                markersArray.push(marker);
            }

            window.initMap = initMap;
        </script>
    @endpush
</x-app-layout>
