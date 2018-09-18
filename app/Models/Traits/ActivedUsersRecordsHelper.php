<?php
namespace App\Models\Traits;

use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Topic;
use App\Models\Reply;
use Carbon\Carbon;
use DB;

trait ActivedUsersRecordsHelper
{
    protected $users = [];//记录最后的活跃用户

    protected $key = 'actived_users_records';
    protected $expired_at = 65; //过期时间，单位 分钟

    protected $days = 7; //多少天内的活跃度
  protected $topic_weight = 7; //发布一次话题 7 分
  protected $reply_weight = 4; //回复一次话题 4 分
  protected $limits = 7; //取出多少数据

  public function activedUsers()
  {
      return Cache::remember($this->key, $this->expired_at, function () {
          return $this->calculateActivedUsers();
      });
  }

    //每一小时，计算一次数据
    public function syncCalculateActivedUsers()
    {
        $actived_users = $this->calculateActivedUsers();
        Cache::put($this->key, $actived_users, $this->expired_at);
    }

    private function calculateActivedUsers()
    {
        $this->calculateTopicUsers();
        $this->calculateReplyUsers();

        //按照分数高低排序，取出前N条
        array_sort($this->users, function ($user) {
            return $user['score'];
        });

        $users = array_slice($this->users, 0, $this->limits, true);

        // 新建一个空集合
        $active_users = collect();

        foreach ($users as $user_id => $score) {
            // 找寻下是否可以找到用户
            $user = $this->find($user_id);

            // 如果数据库里有该用户的话
            if ($user) {
                // 将此用户实体放入集合的末尾
                $active_users->push($user);
            }
        }
        return $active_users;
    }

    private function calculateTopicUsers()
    {
        //一周之内，按照created_at时间排序
        $topics = Topic::query()->select(DB::raw('count(*) as topic_count, user_id'))
                                ->where('created_at', '>=', Carbon::now()->subDays($this->days)->toDateTimeString())
                                ->groupBy('user_id')->get()->toArray();
        foreach ($topics as $user) {
            $this->users[$user['user_id']]['score'] = $this->topic_weight * $user['topic_count'];
        }
    }

    private function calculateReplyUsers()
    {
        $replies = Reply::query()->select(DB::raw('count(*) as reply_count, user_id'))
                              ->where('created_at', '>=', Carbon::now()->subDays($this->days)->toDateTimeString())
                              ->groupBy('user_id')->get()->toArray();
        foreach ($replies as $user) {
            if (isset($this->users[$user['user_id']])) {
                $this->users[$user['user_id']]['score'] += $user['reply_count'] * $this->reply_weight;
            } else {
                $this->users[$user['user_id']]['score'] = $user['reply_count'] * $this->reply_weight;
            }
        }
    }
}
