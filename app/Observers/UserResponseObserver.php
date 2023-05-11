<?php

namespace App\Observers;

use App\Models\UserResponse;
use App\Lib\Webspice;

class UserResponseObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('user_responses');
    }
    /**
     * Handle the UserResponse "created" event.
     */
    public function created(UserResponse $user_response): void
    {
        #Log
        $this->webspice->log('user_responses', $user_response->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the UserResponse "updated" event.
     */
    public function updated(UserResponse $user_response): void
    {
        #Log
        $this->webspice->log('user_responses', $user_response->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('update_success');

        // $user_response->updated_at = $this->webspice->now('datetime24');
        // $user_response->updated_by = $this->webspice->getUserResponseId();
        // $user_response->save();

    }

    /**
     * Handle the UserResponse "deleted" event.
     */
    public function deleted(UserResponse $user_response): void
    {
        #Log
        $this->webspice->log('user_responses', $user_response->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(UserResponse $user_response): void
    {
        #Log
        $this->webspice->log('user_responses', $user_response->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('restore_success');

        // $user_response->deleted_by = NULL;
        // $user_response->save();
    }

   
    public function forceDeleted(UserResponse $user_response): void
    {
        #Log
        $this->webspice->log('user_responses', $user_response->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
