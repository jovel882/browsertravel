@extends('template')

@section('title', 'Mapa de Humedad')

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
	<h1 class="text-2xl font-semibold mb-4">Mapa de humedad</h1>
	<div id="map-container">
		<div id="map"></div>
	</div>
@endsection

@section('jsGeneral')
	<script>
		function getWeatherData(position) {
			return new Promise(function (resolve, reject) {
				var url =
					"https://api.openweathermap.org/data/2.5/weather?lat=" +
					position.lat +
					"&lon=" +
					position.lng +
					"&appid={{ env('API_KEY_WEATHER') }}";
				setTimeout(() => {
					fetch(url)
						.then(function (response) {
							if (response.ok) {
								return response.json();
							} else {
								throw new Error(
									"Error en la respuesta de la API"
								);
							}
						})
						.then(function (data) {
							resolve(data);
						})
						.catch(function (error) {
							reject(error);
						});
				}, 5000);
			});
		}

		var map = L.map("map").setView([28.6139, -81.209], 5); // Coordenadas aproximadas del centro de Florida

		L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
			attribution:
				'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
			maxZoom: 18,
		}).addTo(map);

		var markers = [
			{
				city: "Miami",
				position: { lat: 25.7617, lng: -80.1918 },
				humidity: "Pendiente...", // Valor de humedad para Miami (inicialmente desconocido)
			},
			{
				city: "Orlando",
				position: { lat: 28.5383, lng: -81.3792 },
				humidity: "Pendiente...", // Valor de humedad para Orlando (inicialmente desconocido)
			},
			{
				city: "New York",
				position: { lat: 40.7128, lng: -74.006 },
				humidity: "Pendiente...", // Valor de humedad para Nueva York (inicialmente desconocido)
			},
		];

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

			// Realizar solicitud al endpoint de OpenWeatherMap
			getWeatherData(marker.position)
				.then(function (data) {
					// Obtener el valor de la humedad desde la respuesta JSON
					if (data && data.main && data.main.humidity) {
						marker.humidity = data.main.humidity;
						infoWindow.setContent(
							"Ciudad: " +
								marker.city +
								"<br>Humedad: " +
								marker.humidity
						);
					} else {
						infoWindow.setContent(
							"Ciudad: " +
								marker.city +
								"<br>Humedad: No disponible"
						);
					}

					mapMarker.bindPopup(infoWindow);
				})
				.catch(function (error) {
					console.log(
						"Error al obtener datos de humedad:",
						error
					);
					infoWindow.setContent(
						"Ciudad: " +
							marker.city +
							"<br>Humedad: Error al obtener datos"
					);
					mapMarker.bindPopup(infoWindow);
				});
		});
	</script>
@endsection