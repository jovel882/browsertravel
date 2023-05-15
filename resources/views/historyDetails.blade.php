@extends('template')

@section('title', 'Historial - Detalle')

@section('cssGeneral')
	<link
	rel="stylesheet"
	href="https://unpkg.com/leaflet/dist/leaflet.css"
	/>
	<style>
		#map-container {
			position: relative;
			padding-bottom: 56.25%; /* Proporción de aspecto 16:9 para el contenedor del mapa */
			padding-top: 30px;
			height: 0;
			overflow: hidden;
		}
	
		#map {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}
	</style>
@endsection

@section('jsInclude')
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
@endsection

@section('appContent')
	<h1 class="text-2xl font-semibold mb-4">Historial # {{ $history->id }}</h1>
	<h1 class="text-3xl font-semibold mb-4">Fecha {{ $history->created_at }}</h1>
	<h1 class="text-3xl font-semibold mb-4">Datos</h1>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 text-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Ciudad
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Latitud
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Longitud
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Humedad
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-900 divide-y divide-gray-700">
                            @foreach ($history->data as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item['city'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item['position']['lat'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item['position']['lng'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item['humidity'] }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
	<div id="map-container">
		<div id="map"></div>
	</div>
@endsection

@section('jsGeneral')
	<script>
		function getHumidity(markers) {
			markers.forEach(function (marker) {
				var infoWindow = L.popup();

				var mapMarker = L.marker(marker.position).addTo(map);

				infoWindow.setContent(
					"Ciudad: " + marker.city + "<br>Humedad: " + marker.humidity
				);

				mapMarker.bindPopup(infoWindow);

				mapMarker.on("click", function () {
					this.openPopup();
				});

			});
		}
		var map = L.map("map").setView([28.6139, -81.209], 2); // Coordenadas aproximadas del centro de Florida

		L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
			attribution:
				'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
			maxZoom: 18,
		}).addTo(map);

		var markers = {{ Js::from($history->data) }};

		getHumidity(markers);
	</script>
@endsection