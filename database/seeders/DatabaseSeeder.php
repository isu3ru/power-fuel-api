<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
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
        $adminRole = Role::create(['name' => 'administrator']);
        $customerRole = Role::create(['name' => 'customer']);
        $guestRole = Role::create(['name' => 'guest']);
        $users = User::factory(1)->create();
        $users->first()->assignRole($adminRole);
    }
}
