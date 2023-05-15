@extends('template')

@section('title', 'Historial')

@section('appContent')

	<h1 class="text-2xl font-semibold mb-4">Historial</h1>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 text-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    Datos
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-900 divide-y divide-gray-700">
                            @foreach ($histories as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $item->created_at }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @foreach ($item->data as $data)
										<div class="border-b border-gray-700">
										</div>
										<div>
											<span class="text-gray-300">City: </span>{{ $data['city'] }}
										</div>
										<div>
											<span class="text-gray-300">Position: </span>Lat: {{ $data['position']['lat'] }}, Lng: {{ $data['position']['lng'] }}
										</div>
										<div>
											<span class="text-gray-300">Humidity: </span>{{ $data['humidity'] }}
										</div>
										<div class="border-b border-gray-700">
										</div>
                                    @endforeach
                                </td>
								<td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('history.show.specific', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center space-x-2" target="_blank">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
											<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
											<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <span>Ver Detalle</span>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $histories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection