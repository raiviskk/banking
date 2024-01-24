<?php

namespace Database\Seeders;


use App\Console\Commands\FetchCryptoPricesCommand;
use App\Console\Commands\FetchCurrencyRateCommand;
use App\Console\Commands\FetchStocksCommand;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call(FetchCurrencyRateCommand::class);
        Artisan::call(FetchCryptoPricesCommand::class);
        Artisan::call(FetchStocksCommand::class);

        $this->call([
            AccountTypeSeeder::class,
        ]);

        User::factory()->count(5)->create();

    }
}
