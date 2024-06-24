<?php

namespace App\Listeners;

use App\Events\ContactFormSubmitted;
use App\Mail\ContactMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendContactFormEmail
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
    public function handle(ContactFormSubmitted $event): void
    {
        $users=User::get();
        foreach ($users as $key => $user) {
            // send mail
            Mail::to($user->email)->queue(new ContactMail($event->data));
        }
       
    }
}
