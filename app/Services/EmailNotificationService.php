<?php

namespace App\Services;

use App\Mail\GenericOrderStatusMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailNotificationService
{
    public function sendWelcome(User $user): void
    {
        Mail::to($user->email)->queue(new GenericOrderStatusMail('Welcome to EcomPro', 'welcome', null));
    }

    public function sendOrderStatus(Order $order, string $template): void
    {
        Mail::to($order->user->email)->queue(new GenericOrderStatusMail('Order update', $template, $order));
    }
}
