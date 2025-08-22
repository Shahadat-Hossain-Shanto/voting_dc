<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PaymentDetailsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100000; $i++) {
            \DB::table('payment_details')->insert([
                'id' => 1633044+ $i,
                'customer_id' => $faker->numberBetween(10000000, 99999999),
                'imei_1' => $faker->numerify('###############'),
                'imei_2' => $faker->numerify('###############'),
                'serial_number' => $faker->unique()->numerify('###############'),
                'emi_status' => $faker->numberBetween(0, 1),
                'pos_invoice_number' => $faker->unique()->regexify('20[0-9]{2}-[A-Z0-9]{3}-DNO-[0-9]{8}'),
                'payment_date' => $faker->date(),
                'payment_amount' => $faker->numberBetween(1000, 5000),
                'total_due_amount' => $faker->numberBetween(5000, 10000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
