<?php

namespace App\Observers;

// use App\Models\Permission;
use Spatie\Permission\Models\Permission;
use App\Lib\Webspice;

class PermissionObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('permissions');
    }
    /**
     * Handle the Permission "created" event.
     */
    public function created(Permission $permission): void
    {
        #Log
        $this->webspice->log('permissions', $permission->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the Permission "updated" event.
     */
    public function updated(Permission $permission): void
    {
        #Log
        $this->webspice->log('permissions', $permission->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('update_success');

        // $permission->updated_at = $this->webspice->now('datetime24');
        // $permission->updated_by = $this->webspice->getPermissionId();
        // $permission->save();

    }

    /**
     * Handle the Permission "deleted" event.
     */
    public function deleted(Permission $permission): void
    {
        #Log
        $this->webspice->log('permissions', $permission->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('delete_success');

        // $permission->deleted_at = $this->webspice->now('datetime24');
        // $permission->deleted_by = $this->webspice->getPermissionId();
        // $permission->save();
    }

    /**
     * Handle the Permission "restored" event.
     */
    public function restored(Permission $permission): void
    {
        #Log
        $this->webspice->log('permissions', $permission->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('restore_success');

        // $permission->deleted_by = NULL;
        // $permission->save();
    }

    /**
     * Handle the Permission "force deleted" event.
     */
    public function forceDeleted(Permission $permission): void
    {
        #Log
        $this->webspice->log('permissions', $permission->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
