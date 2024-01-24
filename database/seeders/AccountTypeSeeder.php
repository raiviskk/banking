<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountTypes;

class AccountTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Debit', 'Saving', 'Investment', 'Crypto'];

        foreach ($types as $type) {
            AccountTypes::create(['type' => $type]);
        }
    }
}
