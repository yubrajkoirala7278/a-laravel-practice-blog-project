<?php

namespace App\Listeners;

use App\Events\BlogCreated;
use App\Mail\UserMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BlogCreated $event): void
    {
        $users=User::get();
        foreach ($users as $user) {
            Mail::to($user->email)->queue(new UserMail($event->blog));
        }
    }
}
