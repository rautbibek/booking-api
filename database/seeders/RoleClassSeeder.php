<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleClassSeeder extends Seeder
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
                'name'=>'admin',
                'guard_name'=>'api',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'user',
                'guard_name'=>'bpi',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'employee',
                'guard_name'=>'cpi',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'customer',
                'guard_name'=>'dpi',
                'created_at'=>now(),
                'updated_at'=>now()
            ]
        ];
        DB::table('roles')->insert($data);
        return;
    }
}
