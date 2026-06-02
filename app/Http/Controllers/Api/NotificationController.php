<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NotificationRequest;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Response;

class NotificationController extends Controller
{
    public function index()
    {
        // auth()->user()->unreadNotifications->markAsRead();
        $notifications = auth()->user()->notifications()->paginate(request()->query('per_page', 10));

        return Response::ok(__('lang.success'), NotificationResource::collection($notifications), true);
    }

    public function read(NotificationRequest $request)
    {
        $notification = auth()->user()->notifications()->where('id', $request->notification_id)->first();
        $notification->markAsRead();

        return Response::ok(__('lang.success'));
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return Response::ok(__('lang.success'));
    }

    public function delete(NotificationRequest $request)
    {
        $notification = auth()->user()->notifications()->where('id', $request->notification_id)->first();
        $notification->delete();

        return Response::noContent(__('lang.success'));
    }

    public function unreadNotificationCount()
    {
        $data['count'] = auth()->user()->unreadNotifications->count();

        return Response::ok(__('lang.success'), $data);
    }

    public function toggleDisable()
    {
        auth()->user()->update([
            'disable_notifications' => ! auth()->user()->disable_notifications,
        ]);

        return Response::ok(__('lang.success'));
    }
}
