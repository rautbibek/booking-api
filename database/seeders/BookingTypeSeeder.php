<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'booking_type'=>'hourly',
            ],
            [
                'booking_type'=>'daily',
            ],
            [
                'booking_type'=>'weekly',
            ],
            [
                'booking_type'=>'monthly',
            ]
        ];
        DB::table('booking_types')->insert($data);
        return;
    }
}
