<?php
namespace App\TransFormers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransFormer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $normals = $user->toArray();
        $attends = [
          'avatar' => config('app.url').$user->avatar_url,
          'last_actived_at' => $user->last_actived_at->toDateTimeString()
        ];
        return array_merge($normals, $attends);
    }
}
