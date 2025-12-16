<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class StockController extends Controller
{
    public function index()
    {
        $response = Http::get('http://api.marketstack.com/v1/eod', [
            'access_key' => config('services.marketstack.key'),
            'symbols' => 'AAPL,MSFT,GOOGL,AMZN,TSLA',
            'limit' => 5,
        ]);

        if (!$response->successful()) {
            return response()->json([], 500);
        }

        return response()->json(
            collect($response->json('data'))->map(function ($stock) {
                return [
                    'symbol' => $stock['symbol'],
                    'price'  => $stock['close'],
                    'date'   => $stock['date'],
                ];
            })
        );
    }
}
