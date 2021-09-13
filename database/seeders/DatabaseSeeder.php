<?php

namespace Database\Seeders;

use App\Models\ProjectStageDate;
use App\Models\RequestWorkSubType;
use App\Models\RequestWorkSubTypeKind;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserTypeSeeder::class,
            UserSeeder::class,
            BuildingStageSeeder::class,
            BuildingTypeSeeder::class,
            ProjectStageDateSeeder::class,
            RequestRenovationTypeSeeder::class,
            RequestRoomTypeSeeder::class,
            RequestRoomStyleSeeder::class,
            RequestWorkTypeSeeder::class,
            RequestWorkActionSeeder::class,
            RequestWorkCountableTypeSeeder::class,
            StatusSeeder::class,
            AdvantageTypeSeeder::class,
            SlideTypeSeeder::class,
            SlideUsageTypeSeeder::class,
            AttachmentUsageTypeSeeder::class,
            MaterialTypeSeeder::class,
            PageTypeSeeder::class,
            PageSeeder::class,
            RequestWorkReplaceTypeSeeder::class,
            RequestWorkReplaceSeeder::class,
            RequestWorkTypeHasRequestWorkReplaceSeeder::class,
            AttachmentSeeder::class,
            ModelHasAttachmentSeeder::class,
            StateSeeder::class,
        ]);
    }
}
