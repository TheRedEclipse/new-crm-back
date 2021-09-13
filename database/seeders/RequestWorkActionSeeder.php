<?php

namespace Database\Seeders;

use App\Models\RequestWorkAction;
use Illuminate\Database\Seeder;

class RequestWorkActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'refinish', 'title' => 'Refinish', 'icon' => 'refinish', 'sort' => 1, ],
            [ 'name' => 'replace', 'title' => 'Replace', 'icon' => 'replace', 'sort' => 2, ],
            [ 'name' => 'remove', 'title' => 'Remove existing', 'icon' => 'remove', 'sort' => 3, ],
            [ 'name' => 'install', 'title' => 'Install / Add new', 'icon' => 'install-add', 'sort' => 4, ],
        ];

        foreach($data as $item) {
            RequestWorkAction::firstOrCreate($item);
        }
    }
}
