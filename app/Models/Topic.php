<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = [
      'title', 'body', 'slug', 'excert', 'view_count', 'reply_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function replies()
    {
      return $this->hasMany(Reply::class);
    }

    public static function makeExcert($body)
    {
        $html = $body;
        $excert = trim(preg_replace('/\s\s+/', ' ', strip_tags($html)));
        return str_limit($excert, 200);
    }

    public function scopeOrderToApi($query, $order = '')
    {
        switch ($order) {
        case 'recent':
          return $query->recent();
          break;
        default:
          return $query->recentReplied();
          break;
      }
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }
}
