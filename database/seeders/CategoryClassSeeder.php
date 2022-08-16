<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryClassSeeder extends Seeder
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
                'name'=>'footsal',
                'slug'=>'footsal',
                'image'=>'https://media.wired.com/photos/5b899992404e112d2df1e94e/master/pass/trash2-01.jpg',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'Venue',
                'slug'=>'venue',
                'image'=>'https://media.wired.com/photos/5b899992404e112d2df1e94e/master/pass/trash2-01.jpg',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'Resort',
                'slug'=>'resort',
                'image'=>'https://media.wired.com/photos/5b899992404e112d2df1e94e/master/pass/trash2-01.jpg',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'Hotel',
                'slug'=>'hotel',
                'image'=>'https://media.wired.com/photos/5b899992404e112d2df1e94e/master/pass/trash2-01.jpg',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'Restaurant',
                'slug'=>'restaurant',
                'image'=>'https://media.wired.com/photos/5b899992404e112d2df1e94e/master/pass/trash2-01.jpg',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ];
        DB::table('categories')->insert($data);
        return;
    }
}
