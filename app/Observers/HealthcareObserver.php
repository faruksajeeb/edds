<?php

namespace App\Observers;

use App\Models\Healthcare;
use App\Lib\Webspice;

class HealthcareObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('healthcares');
    }
    /**
     * Handle the healthcare "created" event.
     */
    public function created(Healthcare $healthcare): void
    {
        #Log
        $this->webspice->log('healthcares', $healthcare->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the healthcare "updated" event.
     */
    public function updated(Healthcare $healthcare): void
    {
        #Log
        $this->webspice->log('healthcares', $healthcare->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('update_success');

        // $healthcare->updated_at = $this->webspice->now('datetime24');
        // $healthcare->updated_by = $this->webspice->gethealthcareId();
        // $healthcare->save();

    }

    /**
     * Handle the healthcare "deleted" event.
     */
    public function deleted(Healthcare $healthcare): void
    {
        #Log
        $this->webspice->log('healthcares', $healthcare->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(Healthcare $healthcare): void
    {
        #Log
        $this->webspice->log('healthcares', $healthcare->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('restore_success');

        // $healthcare->deleted_by = NULL;
        // $healthcare->save();
    }

   
    public function forceDeleted(Healthcare $healthcare): void
    {
        #Log
        $this->webspice->log('healthcares', $healthcare->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
