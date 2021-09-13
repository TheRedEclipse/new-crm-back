<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
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
                'name' => 'lead',
                'title' => 'Lead',
                'description' => 'Users which created after leads generation',
            ],
            [
                'name' => 'worker',
                'title' => 'Worker',
                'description' => 'Users of organization',
            ],
        ];
        
        foreach($data as $item) {
            UserType::firstOrCreate($item);
        }
    }
}
