<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // DB::table('customers')->insert([
        //     'name'          => Str::random(10),
        //     'socialReason'  => Str::random(20),
        //     'cnpj'          => Str::random(16),

        // ]);

        if(Customer::count() > 100) {
            return;
        }
        Customer::factory(50)->create();
    }
}
