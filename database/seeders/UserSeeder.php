<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::count() > 0) {
            return;
        }
        
        $data = [
            [
                'email' => 'admin@site.com',
                'name' => 'John',
                'last_name' => 'Doe',
                'password' => Hash::make('password')
            ],
        ];
        
        foreach($data as $item) {
            $user = User::create($item);
            $user->syncRoles(['admin']);
        }

        User::factory(10)->create();
    }
}
