<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Reply $reply)
    {
        //是否具有管理内容的权限，或者是本人可以删除
        return $user->hasPermissionTo('manage_contents') || $user->isAuthorOf($reply);
    }
}
