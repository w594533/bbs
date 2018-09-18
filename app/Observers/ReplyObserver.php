<?php
namespace App\Observers;

use App\Models\User;
use App\Models\Topic;
use App\Models\Reply;
use App\Notifications\InvoiceTopicReply;

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->topic->increment('reply_count');

        //消息通知用户
        $reply->topic->user->notifyInstance(new InvoiceTopicReply($reply));
    }

    public function deleted(Reply $reply)
    {
        $topic = $reply->topic;
        if ($topic->reply_count !== 0) {
            $topic->decrement('reply_count');
        }
    }
}
