<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\Controller;
use App\TransFormers\NotificationTransFormer;

class NotificationsController extends Controller
{
    public function userIndex()
    {
        $notifications = $this->user()->notifications()->paginate(20);
        return $this->response->paginator($notifications, new NotificationTransFormer());
    }

    public function read()
    {
        $this->user()->markAsRead();
        return $this->response->noContent();
    }
}
