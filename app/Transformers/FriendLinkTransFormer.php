<?php
namespace App\TransFormers;

use App\Models\FriendLink;
use League\Fractal\TransformerAbstract;

class FriendLinkTransFormer extends TransformerAbstract {

  public function transform(FriendLink $friend_link){
    $normals = $friend_link->toArray();
    $attends = [

    ];
    return array_merge($normals, $attends);
  }

}
