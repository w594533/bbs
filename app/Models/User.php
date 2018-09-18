<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Http\Models\Traits\LastActivedAtHelper;
use App\Models\Traits\ActivedUsersRecordsHelper;
use App\Notifications\InvoiceTopicReply;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, Notifiable, LastActivedAtHelper, ActivedUsersRecordsHelper;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'introduce', 'phone', 'avatar_image_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && file_exists(storage_path('app/public/'.$this->avatar))) {
            return \Storage::url($this->avatar);
        } else {
            return 'https://lccdn.phphub.org/uploads/avatars/19219_1532335784.jpg?imageView2/1/w/200/h/200';
        }
    }

    //消息标记已读
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    //消息通知
    public function notifyInstance($instance)
    {
        if ($this->id == \Auth::guard('api')->user()->id) {
            return;
        }
        $this->notify($instance);
        $this->increment('notification_count');
    }

    /**
     * 将passport的登录字段修改为邮箱或者手机号登录
    */
    public function findForPassport($username)
    {
        filter_var($username, FILTER_VALIDATE_EMAIL) ?
       $credentials['email'] = $username :
       $credentials['phone'] = $username;

        return self::where($credentials)->first();
    }
}
