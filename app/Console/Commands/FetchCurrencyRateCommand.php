<?php

namespace App\Console\Commands;

use App\Models\Currency;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchCurrencyRateCommand extends Command
{

    protected $signature = 'currencies:fetch';

    protected $description = 'Fetch all currency rates';

    private array $validCurrencies = [
        'EUR', 'USD', 'GBP', 'CHF', 'JPY'
    ];
    private const BASE_CURRENCY = 'EUR';

    public function handle(Client $client): void
    {
        $response = $client->get('https://api.coinbase.com/v2/exchange-rates?currency=' . self::BASE_CURRENCY);
        $response = json_decode($response->getBody()->getContents());


        foreach ($response->data->rates as $code => $rate){
            if (in_array($code, $this->validCurrencies) == false){
                continue;
            }
            Currency::updateOrCreate(
                ['code' => $code,],
                ['rate' => $rate]
            );
        }
    }
}
