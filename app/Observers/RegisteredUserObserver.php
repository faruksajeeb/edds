<?php

namespace App\Observers;

use App\Models\RegisteredUser;
use App\Lib\Webspice;

class RegisteredUserObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('registered_users');
    }
    /**
     * Handle the RegisteredUser "created" event.
     */
    public function created(RegisteredUser $registered_user): void
    {
        #Log
        $this->webspice->log('registered_users', $registered_user->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the RegisteredUser "updated" event.
     */
    public function updated(RegisteredUser $registered_user): void
    {
        #Log
        $this->webspice->log('registered_users', $registered_user->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('update_success');

        // $registered_user->updated_at = $this->webspice->now('datetime24');
        // $registered_user->updated_by = $this->webspice->getRegisteredUserId();
        // $registered_user->save();

    }

    /**
     * Handle the RegisteredUser "deleted" event.
     */
    public function deleted(RegisteredUser $registered_user): void
    {
        #Log
        $this->webspice->log('registered_users', $registered_user->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('delete_success');
    }


    public function restored(RegisteredUser $registered_user): void
    {
        #Log
        $this->webspice->log('registered_users', $registered_user->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('restore_success');

        // $registered_user->deleted_by = NULL;
        // $registered_user->save();
    }


    public function forceDeleted(RegisteredUser $registered_user): void
    {
        #Log
        $this->webspice->log('registered_users', $registered_user->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('force_delete_success');
    }

   
}
