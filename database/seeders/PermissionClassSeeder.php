<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionClassSeeder extends Seeder
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
                'name'=>'create user',
                'guard_name'=>'api',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'edit user',
                'guard_name'=>'api',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'alter user',
                'guard_name'=>'api',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'view user',
                'guard_name'=>'api',
                'created_at'=>now(),
                'updated_at'=>now()
            ]
        ];
        
        DB::table('permissions')->insert($data);
        return;
    }
}
