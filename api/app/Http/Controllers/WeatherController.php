<?php

namespace App\Http\Controllers;

use App\Models\Meteosuisse;
use Illuminate\Http\Request;
use App\Models\Weather;
use Carbon\Carbon;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $orderBy = $request->input('orderBy');
        $order = $request->input('order');
        $limit = $request->input('limit');

        // GET - Retourner toutes les données de la base de données, max : 3 mois

        // récupére la dernière date de la table
        $latestDate = Weather::latest('date')->first()->date;
        // récupère les données des derniers 3 mois à partir de la dernière date de la table
        $weather = Weather::whereDate('date', '>=', Carbon::parse($latestDate)->subMonths(3))
                        ->orderBy($orderBy, $order)
                        ->when($limit, function ($query, $limit) {
                            return $query->take($limit);
                        })
                        ->get();

        return response()->json($weather);
    }

    public function all(Request $request) 
    {
        $limit = $request->input('limit');

        $weather = Weather::query()    
                        ->orderBy('date', 'asc')
                        ->when($limit, function ($query, $limit) {
                            return $query->take($limit);
                        })
                        ->get();

        return response()->json($weather);
    }

    public function latest()
    {
        // récupére la dernière date de la table
        $weather = Weather::latest('date')->first();
        return response()->json($weather);
    }

    public function date($year, $month, $day) 
    {
        $weather = Weather::whereDate('date', '=', "$year-$month-$day")->get();
        return response()->json($weather);
    }

    public function chooseDates(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $orderBy = $request->input('orderBy');
        $order = $request->input('order');
        $limit = $request->input('limit');

        $weather = Weather::whereBetween('date', [$start, $end])
                        ->orderBy($orderBy, $order)
                        ->when($limit, function ($query, $limit) {
                            return $query->take($limit);
                        })
                        ->get();
        
        
        return response()->json($weather);
    }

    public function addData(Request $request)
    {
        $data = $request->validate([
            'wind' => $request->input('wind'),
            'gust' => $request->input('gust'),
            'temperature' => $request->input('temperature'),
            'precipitation' => $request->input('precipitation')
        ]);
        $meteosuisse = Meteosuisse::create($data);

        return response()->json($meteosuisse, 201);
    }
}
