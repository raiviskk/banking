<?php

namespace App\Console\Commands;

use App\Models\Stock;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchStocksCommand extends Command
{
    protected $signature = 'stocks:fetch';
    protected $description = 'Fetch stock prices';

    private const BASE_URL = 'https://financialmodelingprep.com/api/v3/quote/';
    private const API_KEY = 'AYRAHKF0IV1gWmjLJ51FnI8jubd6y1zt';

    public function handle(Client $client): void
    {
        $validSymbols = ['AAPL', 'GOOGL', 'MSFT', 'AMZN', 'TSLA', 'FB', 'NFLX', 'NVDA', 'PYPL', 'INTC'];

        foreach ($validSymbols as $symbol) {
            $response = $client->get(self::BASE_URL . $symbol . '?apikey=' . self::API_KEY);
            $data = json_decode($response->getBody()->getContents());

            $symbol = $data[0]->symbol ?? null;
            $price = $data[0]->price ?? null;

            if ($symbol !== null && $price !== null) {
                Stock::updateOrCreate(
                    ['symbol' => $symbol],
                    ['price' => $price]
                );
            }
        }

        $this->info('Stock prices fetched successfully!');
    }
}
