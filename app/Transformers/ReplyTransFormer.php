<?php
namespace App\TransFormers;

use App\Models\Reply;
use League\Fractal\TransformerAbstract;

class ReplyTransFormer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'topic'];
    public function transform(Reply $reply)
    {
        $normals = $reply->toArray();
        $attends = [

        ];
        return array_merge($normals, $attends);
    }

    public function includeUser(Reply $reply)
    {
        return $this->item($reply->user, new UserTransFormer);
    }

    public function includeTopic(Reply $reply)
    {
        return $this->item($reply->topic, new TopicTransFormer);
    }
}
