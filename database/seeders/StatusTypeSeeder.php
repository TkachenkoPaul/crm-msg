<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_types')->insert([
            'type_id' => 0,
            'name' => 'Открыта',
            'admin_id' => 1,
            'color' => 'bg-gradient-primary',
            'icon' => 'fa-folder-open',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('status_types')->insert([
            'type_id' => 1,
            'name' => 'Выполнена',
            'admin_id' => 1,
            'color' => 'bg-gradient-success',
            'icon' => 'fa-check',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('status_types')->insert([
            'type_id' => 2,
            'name' => 'Не выполнена и закрыта',
            'admin_id' => 1,
            'color' => 'bg-gradient-danger',
            'icon' => 'fa-times',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('status_types')->insert([
            'type_id' => 3,
            'name' => 'На доработку',
            'admin_id' => 1,
            'color' => 'bg-gradient-info',
            'icon' => 'fa-wrench',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('status_types')->insert([
            'type_id' => 4,
            'name' => 'Запланировано',
            'admin_id' => 1,
            'color' => 'bg-gradient-info',
            'icon' => 'fa-wrench',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
