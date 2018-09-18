<?php
namespace App\Http\Models\Traits;
use Carbon\Carbon;
use Redis;

trait LastActivedAtHelper {

  protected $hash_table_prefix = 'last_actived_at_';//表名前缀
  protected $hash_field_prefix = 'user_';//字段名前缀

  //记录最后的活跃时间
  public function recordLastActivedAt()
  {
    $date = Carbon::now()->toDateString();

    //Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
    $hash = $this->hash_table_prefix . $date;

    //字段名称，比如user_1
    $field = $this->hash_field_prefix . $this->id;

    //获取当前的日期
    $now = Carbon::now()->toDateTimeString();

    Redis::hSet($hash, $field, $now);
  }

  //任务调度同步到数据库最后的活跃时间
  public function sysncLastActivedAt()
  {
    $date = Carbon::now()->toDateString();

    $hash = $this->hash_table_prefix . $date;

    $datas = Redis::hGetAll($hash);
    foreach ($datas as $key => $value) {
        $user_id = str_replace($this->hash_field_prefix, '', $key);

        if ($user = $this->find($user_id)) {
          $user->last_actived_at = $value;
          $user->save();
        }
    }

    Redis::del($hash);
  }

  //获取最后的活跃时间
  public function getLastActivedAtAttribute($value)
  {
    $date = Carbon::now()->toDateString();

    $hash = $this->hash_table_prefix . $date;

    $field = $this->hash_field_prefix . $this->id;

    $datetime = Redis::hGet($hash, $field) ? : $value;

    if ($datetime) {
      return new Carbon($datetime);//时间格式化
    } else {
      return $this->created_at;
    }
  }
}
