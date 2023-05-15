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
	<div class="hidden flex items-center bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert" id="error-container-general">
		<div class="mr-2">
		  <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
			<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
		  </svg>
		</div>
		<div>
		  <strong class="font-bold">Error:</strong>
		  <div id="error-container">
		  </div>
		</div>
	</div>
	<div id="map-container">
		<div id="map"></div>
	</div>
@endsection

@section('jsGeneral')
	<script>
		window.CSRF_TOKEN = '{{ csrf_token() }}';
		const promises = [];
		function handlePromiseOrError(param) {
			if (param instanceof Promise) {
				param
					.then((result) => {
						handleResponse(result);
					})
					.catch( (error) => {
						handleResponse(error);
					});
			} else {
				handleResponse(param)
			}
		}
		function handleResponse(response) {
			let errorContainer = document.getElementById("error-container");
			errorContainer.innerHTML = ""; // Limpiar el contenido previo

			try {
				if (response.errors) {
					const element = document.getElementById('error-container-general');
					element.classList.remove('hidden');
					for (let error in response.errors) {
						let span = document.createElement("span");
						span.classList.add("block");
						span.textContent = response.errors[error];
						errorContainer.appendChild(span);
					}
				} else {
					const element = document.getElementById('error-container-general');
					element.classList.remove('hidden');
					let span = document.createElement("span");
					span.classList.add("block");
					span.textContent = response;
					errorContainer.appendChild(span);
				}
			} catch (error) {
				const element = document.getElementById('error-container-general');
				element.classList.remove('hidden');
				let span = document.createElement("span");
				span.classList.add("block");
				span.textContent = "Se produjo un error en la operación.";
				errorContainer.appendChild(span);
			}
		}
		function getWeatherData(position) {
			return new Promise(function (resolve, reject) {
				var url =
					"https://api.openweathermap.org/data/2.5/weather?lat=" +
					position.lat +
					"&lon=" +
					position.lng +
					"&appid={{ env('API_KEY_WEATHER') }}";
				
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
			});
		}
		function sendMarketsData(markets) {
			return new Promise((resolve, reject) => {
				const url = new URL('{{ route('history') }}');
    			url.searchParams.append('cities', JSON.stringify(markets));

				fetch(url, {
					method: "POST",
					headers: {
						'X-CSRF-TOKEN': window.CSRF_TOKEN,
						"Content-Type": "application/json",
					}
				})
					.then((response) => {
						if (response.ok) {
							resolve(response.json());
						} else if (response.status == 422) {
							reject(response.json());
						} else {
							reject('Error al guardar en el historial: '+response.status + ' - '+response.statusText);
						}
					})
					.catch((error) => {
						reject(error);
					});
			});
		}

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

				// Realizar solicitud al endpoint de OpenWeatherMap
				const promise = getWeatherData(marker.position)
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
				promises.push(promise);
			});
		}
		var map = L.map("map").setView([28.6139, -81.209], 5); // Coordenadas aproximadas del centro de Florida

		L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
			attribution:
				'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
			maxZoom: 18,
		}).addTo(map);

		var markers = {{ Js::from($cities) }};

		getHumidity(markers);
		Promise.all(promises)
			.then(function () {
				sendMarketsData(markers)
					.catch(function (error){
						handlePromiseOrError(error);
					});
			})
			.catch(function (error) {
				handleResponse(error);
			});
	</script>
@endsection