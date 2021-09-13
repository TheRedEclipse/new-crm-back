<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'admin', 'title' => 'Admin', 'sort' => 1 ],
            [ 'name' => 'lead', 'title' => 'Lead', 'sort' => 2 ],
        ];
        
        foreach($data as $item) {
            $role = Role::firstOrCreate($item + ['guard_name' => 'api']);
            $role->syncPermissions($item['name'] === 'admin' ? Permission::all() : []);
        }
    }
}
