<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateRatesCommand extends Command
{
    protected $signature = 'update:rates';

    protected $description = 'Command description';

    public function handle(): void
    {
        cache()->rememberForever('ton_usdt_price',fn() => $this->getTokenPrice('EQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAM9c'));
        cache()->rememberForever('qrk_usdt_price',fn() => $this->getTokenPrice('EQDPcsUQojf-CrUnwBvToqVO4ssGokM7rU_1Xcor9AwBIALh'));
        cache()->rememberForever('not_usdt_price',fn() => $this->getTokenPrice('EQAvlWFDxGF2lXm67y4yzC17wYKD9A0guwPkMs1gOsM__NOT'));
    }

    public function getTokenPrice(string $contract_address,int $deimals = 9 ): float|int
    {
        $apiKey =config('services.expand.api_key');

        if (!$apiKey) {
            throw new \RuntimeException('EXPAND_API_KEY is not set in the environment variables.');
        }

        // Define API parameters
        $expandApiUrl = 'https://api.expand.network/dex/getprice';
        $dexId = config('services.expand.dex_id'); // The dexId for STON.fi. [1]

        // Official Jetton address for USDT on the TON network. [2]
        $usdtAddress = 'EQCxE6mUtQJKFnGfaROTKOt1lZbDiiX1kCixRv7Nw2Id_sDs';

        // Path for the swap: from TON to USDT
        $path = "{$contract_address},{$usdtAddress}";

        $amountIn = '1' . str_repeat('0', $deimals);

        try {
            // Make the GET request to the expand.network API
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-API-KEY' => $apiKey
            ])->get($expandApiUrl, [
                'dexId' => $dexId,
                'path' => $path,
                'amountIn' => $amountIn,
            ]);

            if ($response->failed()) {
                throw new \RuntimeException('Failed to fetch data from expand.network API: ' . $response->body());

            }

            $data = $response->json();

            // The 'amountOut' is the amount of USDT we get for 1 TON.
            // USDT on TON has 6 decimals, so we divide by 1,000,000. [2]
            $amountOut = (float) data_get($data, 'data.amountsOut.1', 0);
            return $amountOut / pow(10, 6);

        } catch (\Exception $e) {
            Log::error('Error calling expand.network API: ' . $e->getMessage());
        }
        return 0.0; // Return 0 if there was an error
    }
}
