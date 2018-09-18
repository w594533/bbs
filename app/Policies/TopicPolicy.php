<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }

    public function delete(User $user, Topic $topic)
    {
        //是否具有管理内容的权限，或者是发帖者本人可以删除
        return $user->hasPermissionTo('manage_contents') || $user->isAuthorOf($topic);
    }

}
