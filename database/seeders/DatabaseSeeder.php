<?php

namespace Database\Seeders;

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

        \App\Models\User::factory(50)->create()->each(function($user) {
            foreach ($user->user_type as $typeName) {
                $typeModel = 'App\\Models\\'.ucfirst($typeName);
                $typeModel::factory(1)->create([
                    'user_id' => $user->id
                ]);
            }
        });

    }
}
