<?php

use Illuminate\Database\Seeder;
use App\Models\FriendLink;

class FriendLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $friend_links = factory(FriendLink::class, 4)->make();
        FriendLink::insert($friend_links->toArray());
    }
}
