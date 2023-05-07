<?php

namespace App\Observers;

// use App\Models\Role;
use Spatie\Permission\Models\Role;
use App\Lib\Webspice;

class RoleObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('roles');
    }
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        #Log
        $this->webspice->log('roles', $role->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        #Log
        $this->webspice->log('roles', $role->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('update_success');

        // $role->updated_at = $this->webspice->now('datetime24');
        // $role->updated_by = $this->webspice->getRoleId();
        // $role->save();

    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        #Log
        $this->webspice->log('roles', $role->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('delete_success');

        // $role->deleted_at = $this->webspice->now('datetime24');
        // $role->deleted_by = $this->webspice->getRoleId();
        // $role->save();
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        #Log
        $this->webspice->log('roles', $role->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('restore_success');

        // $role->deleted_by = NULL;
        // $role->save();
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        #Log
        $this->webspice->log('roles', $role->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
