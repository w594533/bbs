<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Controller;
use App\Models\FriendLink;
use App\TransFormers\FriendLinkTransFormer;

class FriendLinksController extends Controller
{
    public function index()
    {
      $friend_links = FriendLink::all();
      return $this->response->collection($friend_links, new FriendLinkTransFormer);
    }
}
