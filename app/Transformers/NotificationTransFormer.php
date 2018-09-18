<?php
namespace App\TransFormers;

use League\Fractal\TransformerAbstract;
use Illuminate\Notifications\DatabaseNotification;

class NotificationTransFormer extends TransformerAbstract
{
    public function transform(DatabaseNotification $notification)
    {
        return $notification->toArray();
    }
}
