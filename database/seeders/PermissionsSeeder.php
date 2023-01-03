<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name'=>'create messages']);
        Permission::create(['name'=>'view messages']);
        Permission::create(['name'=>'update messages']);
        Permission::create(['name'=>'delete messages']);

        Permission::create(['name'=>'create statuses']);
        Permission::create(['name'=>'view statuses']);
        Permission::create(['name'=>'update statuses']);
        Permission::create(['name'=>'delete statuses']);

        Permission::create(['name'=>'create types']);
        Permission::create(['name'=>'view types']);
        Permission::create(['name'=>'update types']);
        Permission::create(['name'=>'delete types']);

        Permission::create(['name'=>'create replies']);
        Permission::create(['name'=>'delete replies']);

        Permission::create(['name'=>'create users']);
        Permission::create(['name'=>'view users']);
        Permission::create(['name'=>'update users']);
        Permission::create(['name'=>'delete users']);

        Permission::create(['name'=>'view statistic']);

        Permission::create(['name'=>'create roles']);
        Permission::create(['name'=>'view roles']);
        Permission::create(['name'=>'update roles']);
        Permission::create(['name'=>'delete roles']);
    }
}
