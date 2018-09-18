<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Http\Controllers\API\Controller;
use App\TransFormers\ReplyTransFormer;
use App\Http\Requests\API\RepliesRequest;

class RepliesController extends Controller
{
    public function index(Request $request, Reply $reply)
    {
        $query = $reply->query();
        if($request->topic_id) {
          $query->where('topic_id', $request->topic_id);
        }
        $query->orderBy('created_at', 'desc');
        $replies = $query->paginate(20);
        return $this->response->paginator($replies, new ReplyTransFormer);
    }

    public function userIndex(User $user)
    {
      $replies = Reply::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(20);
      return $this->response->paginator($replies, new ReplyTransFormer);
    }

    public function store(RepliesRequest $request, Topic $topic, Reply $reply)
    {
        $reply->body = clean($request->body, 'user_topic_body');
        $reply->user_id = $this->user()->id;
        $reply->topic_id = $topic->id;
        $reply->save();
        return $this->response->created();
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);
        $reply->delete();
        return $this->response->noContent();
    }
}
