<?php

namespace App\Observers;

use App\Models\User;
use App\Lib\Webspice;

use Mail;

class UserObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $message = $user->name . " User has been created successfully.!";
 
        #Log
        $this->webspice->log('users', $user->id, "INSERTED");
        # Cache Update
        $this->webspice->forgetCache('users');
        #Message
        $this->webspice->updateOrFail('success');

        # Send Mail
        $data = array(
            'name' => "Sajeeb",
            'body' => $message
        );

        Mail::send('mail.user_mail', $data, function ($message) {
            $message->to('ofsajeeb@gmail.com', 'Sajeeb Omar')->subject('New User Created');
            $message->from('noreply@gmail.com', 'EDDS ADMIN');
        });
    }


    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $message = $user->name . " User has been updated successfully.!";
 
        #Log
        $this->webspice->log('users', $user->id, "UPDATED");
        # Cache Update
        $this->webspice->forgetCache('users');
        #Message
        $this->webspice->updateOrFail('success');

        # Send Mail
        $data = array(
            'name' => "Sajeeb",
            'body' => $message
        );

        Mail::send('mail.user_mail', $data, function ($message) {
            $message->to($this->webspice->toEmail, 'Sajeeb Omar')->subject(' User Information Updated');
            $message->from('noreply@gmail.com', 'EDDS ADMIN');
        });
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
