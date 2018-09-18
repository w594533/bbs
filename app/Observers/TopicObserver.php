<?php
namespace App\Observers;

use App\Models\User;
use App\Models\Topic;
use App\Jobs\SlugTranslate;
use App\Handlers\SlugTranslateHandler;

class TopicObserver {


  public function saving(Topic $topic)
    {
        //xss攻击处理
        $topic->body = clean($topic->body);
        // 生成话题摘录
        $topic->excert = Topic::makeExcert($topic->body);

        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( $topic->title) {
            // 推送任务到队列
            SlugTranslate::dispatch($topic);
        }
    }
}
