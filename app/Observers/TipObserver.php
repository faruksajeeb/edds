<?php

namespace App\Observers;

use App\Models\Tip;
use App\Lib\Webspice;

class TipObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('tips');
    }
    /**
     * Handle the tip "created" event.
     */
    public function created(Tip $tip): void
    {
        #Log
        $this->webspice->log('tips', $tip->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the tip "updated" event.
     */
    public function updated(Tip $tip): void
    {
        #Log
        $this->webspice->log('tips', $tip->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('update_success');

        // $tip->updated_at = $this->webspice->now('datetime24');
        // $tip->updated_by = $this->webspice->gettipId();
        // $tip->save();

    }

    /**
     * Handle the tip "deleted" event.
     */
    public function deleted(Tip $tip): void
    {
        #Log
        $this->webspice->log('tips', $tip->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(Tip $tip): void
    {
        #Log
        $this->webspice->log('tips', $tip->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('restore_success');

        // $tip->deleted_by = NULL;
        // $tip->save();
    }

   
    public function forceDeleted(Tip $tip): void
    {
        #Log
        $this->webspice->log('tips', $tip->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
