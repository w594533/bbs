<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);
        $user_ids = User::all()->pluck("id")->toArray();
        $topic_ids = Topic::all()->pluck("id")->toArray();

        $replies = factory(Reply::class, 100)->make()->each(function($reply, $index) use ($faker, $user_ids, $topic_ids) {
          $reply->user_id = $faker->randomElement($user_ids);
          $reply->topic_id = $faker->randomElement($topic_ids);
        });

        Reply::insert($replies->toArray());
    }
}
