<?php

namespace App\Observers;

use App\Models\User;
use App\Lib\Webspice;

use Mail;
use Exception;

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
        $this->webspice->message('insert_success');

        
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
        $body = $user->name . " User has been updated successfully.!";
        #Log
        $this->webspice->log('users', $user->id, "UPDATED");
        # Cache Update
        $this->webspice->forgetCache('users');
        #Message
        $this->webspice->message('update_success');

      
        // $user->updated_at = $this->webspice->now('datetime24');
        // $user->updated_by = $this->webspice->getUserId();
        // $user->save();


        # Send Mail
        $data = array(
            'name' => "Sajeeb",
            'body' => $body
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
        $message = $user->name . " User has been deleted successfully.!";

        #Log
        $this->webspice->log('users', $user->id, "DELETED");
        # Cache Update
        $this->webspice->forgetCache('users');
        #Message
        $this->webspice->message('delete_success');

        # Send Mail
        $data = array(
            'name' => "Sajeeb",
            'body' => $message
        );

        Mail::send('mail.user_mail', $data, function ($message) use($user){
            $message->to($this->webspice->toEmail, 'Sajeeb Omar')->subject($user->name.' User Deleted');
            $message->from('noreply@gmail.com', 'EDDS ADMIN');
        });
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        $message = $user->name . " has been restored successfully.!";
        #Log
        $this->webspice->log('users', $user->id, "RESTORED");
        # Cache Update
        $this->webspice->forgetCache('users');
        #Message
        $this->webspice->message('restore_success');

        # Send Mail
        $data = array(
            'name' => "Sajeeb",
            'body' => $message
        );

        Mail::send('mail.user_mail', $data, function ($message) use($user){
            $message->to($this->webspice->toEmail, 'Sajeeb Omar')->subject($user->name.' User Restored');
            $message->from('noreply@gmail.com', 'EDDS ADMIN');
        });
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        $message = $user->name . " has been force deleted successfully.!";
        #Log
        $this->webspice->log('users', $user->id, "FORCE DELETED");
        # Cache Update
        $this->webspice->forgetCache('users');
        #Message
        $this->webspice->message('force_delete_success');

        
        # Send Mail
        $data = array(
            'name' => "Sajeeb",
            'body' => $message
        );

        Mail::send('mail.user_mail', $data, function ($message) use($user){
            $message->to($this->webspice->toEmail, 'Sajeeb Omar')->subject($user->name.' User force deleted');
            $message->from('noreply@gmail.com', 'EDDS ADMIN');
        });
    }
}
