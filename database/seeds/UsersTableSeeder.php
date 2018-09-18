<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);

        $users = factory(User::class, 5)->make();
        $users_array = $users->makeVisible(['password', 'remember_token'])->toArray();
        User::insert($users_array);
    }
}
