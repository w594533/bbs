<?php
namespace App\TransFormers;

use App\Models\Topic;
use League\Fractal\TransformerAbstract;

class TopicTransFormer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'category'];
    public function transform(Topic $topic)
    {
        $normals = $topic->toArray();
        $attends = [

        ];
        return array_merge($normals, $attends);
    }

    public function includeUser(Topic $topic)
    {
        return $this->item($topic->user, new UserTransFormer);
    }

    public function includeCategory(Topic $topic)
    {
        return $this->item($topic->category, new CategoryTransFormer);
    }
}
