<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function show($id=0)
    {
        if ($id == 1){
            $notificaciones = Auth::user()->readNotifications;
            $color = 'success';
            $icono = 'fas fa-eye';
        }else{
            $notificaciones = Auth::user()->unreadNotifications;
            $color = 'warning';
            $icono = 'fas fa-eye-slash';
        }
        return view('admin.notificacion.index', compact('notificaciones','color'));
    }

    public function countNotification()
    {
        //$notificaciones = count(Auth::user()->unreadNotifications);
        $notificaciones = rand(0, 20);
        return response()->json(['notificaciones' => $notificaciones], 200);
    }


    public function markNotificacion(Request $request)
    {
        Auth::user()->unreadNotifications
        ->when($request->input('id'), function($query) use ($request){
            return $query->where('id', $request->input('id'));
        })->markAsread();
        return response()->noContent();
    }

    public function getNotificationsData(Request $request)
    {
            // Create array of available colors.

            $colors = [
                'light', 'dark','primary', 'secondary',
                'info', 'success', 'warning', 'danger'
            ];

            // Create a notifications array of data.

            $notifications = [
                [
                    'icon' => 'fas fa-fw fa-envelope',
                    'text' => rand(0, 10) . ' new messages',
                    'time' => rand(0, 10) . ' minutes',
                ],
                [
                    'icon' => 'fas fa-fw fa-users text-primary',
                    'text' => rand(0, 10) . ' friend requests',
                    'time' => rand(0, 60) . ' minutes',
                ],
                [
                    'icon' => 'fas fa-fw fa-file text-danger',
                    'text' => rand(0, 10) . ' new reports',
                    'time' => rand(0, 60) . ' minutes',
                ],
            ];

            // Create the notification dropdown content.

            $dropdownHtml = '';

            foreach ($notifications as $key => $not) {
                $icon = "<i class='mr-2 {$not['icon']}'></i>";

                $time = "<span class='float-right text-muted text-sm'>
                        {$not['time']}
                        </span>";

                $dropdownHtml .= "<a href='#' class='dropdown-item'>
                                    {$icon}{$not['text']}{$time}
                                </a>";

                if ($key < count($not)) {
                    $dropdownHtml .= "<div class='dropdown-divider'></div>";
                }
            }

            // Return the new notification data.

            return [
                'label'       => rand(0, 10),
                'label_color' => $colors[rand(0, 7)],
                'icon_color'  => $colors[rand(0, 7)],
                'dropdown'    => $dropdownHtml,
            ];
    }
}
