<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CryptoController extends Controller
{
public function getAllCryptoMarketsJson()
{
    $response = Http::withHeaders([
        'x-cg-demo-api-key' => env('COINGECKO_API_KEY'),
    ])->get('https://api.coingecko.com/api/v3/coins/markets', [
        'vs_currency' => 'eur',
        'order' => 'market_cap_desc',
        'per_page' => 250,
        'page' => 1,
    ]);

    return response()->json($response->json());
}

}
