<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\News;
use App\Models\NewsCategories;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(50)
            ->create();

        NewsCategories::factory()
            ->count(5)
            ->create();

        News::factory()
            ->count(50)
            ->create();
    }
}
