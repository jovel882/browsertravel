<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\History;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Requests\HistoryRequest;

class HumidityController extends Controller
{
    public function showActualMap() :View
    {
        return view('map', [
            'cities' => City::all()->map(fn(City $item, int $key) =>
                [
                    'city' => $item->name,
                    'position' => [
                        'lat' => $item->lat,
                        'lng' => $item->lng
                    ],
                    'humidity' => 'Pendiente...',
                ]
            )
        ]);
    }

    public function storeHistory(HistoryRequest $request) :JsonResponse
    {
        $response = History::store([
            'data' => $request->cities
        ]);

        return response()->json($response, isset($response['status']) && $response['status'] === true ?  200 : 500);
    }

    public function showHistory() :View
    {
        return view('history', [
            'histories' => History::orderBy('created_at', 'DESC')->paginate(10)
        ]);
    }
    public function showHistoryDetail(History $history) :View
    {
        return view('historyDetails', compact('history'));
    }
}
