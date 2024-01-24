<?php

namespace App\Console\Commands;

use App\Models\Crypto;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchCryptoPricesCommand extends Command
{
    protected $signature = 'crypto:fetch';

    protected $description = 'Fetch all crypto rates';

    public function handle(Client $client): void
    {
        $response = $client->get('https://api.coinbase.com/v2/prices/EUR/sell');
        $response = json_decode($response->getBody()->getContents(), false);

        foreach ($response->data as $crypto){

            Crypto::updateOrCreate(
                ['code' => $crypto->base],
                ['rate' => $crypto->amount]
            );
        }
    }
}
