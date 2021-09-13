<?php

namespace Database\Seeders;

use App\Models\AttachmentUsageType;
use Illuminate\Database\Seeder;

class AttachmentUsageTypeSeeder extends Seeder
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
                'usage_type' => 'Header',
            ],

            [
                'usage_type' => 'How We Work',
            ],

            [
                'usage_type' => 'Why We Are Different',
            ],

            [
                'usage_type' => 'Before',
            ],

            [
                'usage_type' => 'After',
            ],

            [
                'usage_type' => 'Photo',
            ],
            
            [
                'usage_type' => 'Material Specification',
            ],

            [
                'usage_type' => 'Photos',
            ],

            [
                'usage_type' => 'Logo',
            ],
            [
                'usage_type' => 'main_photo',
            ],
            
            [
                'usage_type' => 'preffered_styles',
            ]
        ];

        foreach($data as $item) {
            AttachmentUsageType::firstOrCreate($item);
        }
    }
}
