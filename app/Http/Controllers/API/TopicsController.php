<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\API\TopicRequest;
use App\Http\Controllers\API\Controller;
use App\TransFormers\TopicTransFormer;
use App\Models\Topic;
use App\Models\User;

class TopicsController extends Controller
{
    public function index(Request $request, Topic $topic)
    {
        $query = $topic->query();
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        $query->orderToApi($request->order?:'');
        $topics = $query->paginate(20);
        return $this->response->paginator($topics, new TopicTransFormer);
    }

    //某个用户的话题列表
    public function userIndex(User $user, Topic $topic)
    {
        $topics = $topic->where('user_id', $user->id)->recent()->paginate(20);
        return $this->response->paginator($topics, new TopicTransFormer);
    }

    public function show(Topic $topic)
    {
        return $this->response->item($topic, new TopicTransFormer);
    }


    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->category_id = $request->category_id;
        $topic->user_id = $this->user()->id;
        $topic->save();
        return $this->response->created();
    }

    public function update(Request $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return $this->response->item($topic, new TopicTransFormer);
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('delete', $topic);
        $topic->delete();
        return $this->response->noContent();
    }
}
