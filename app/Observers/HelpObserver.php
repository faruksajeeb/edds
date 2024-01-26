<?php

namespace App\Observers;

use App\Models\Help;
use App\Lib\Webspice;

class HelpObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('helps');
    }
    /**
     * Handle the help "created" event.
     */
    public function created(Help $help): void
    {
        #Log
        $this->webspice->log('helps', $help->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the help "updated" event.
     */
    public function updated(Help $help): void
    {
        #Log
        $this->webspice->log('helps', $help->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('update_success');

        // $help->updated_at = $this->webspice->now('datetime24');
        // $help->updated_by = $this->webspice->gethelpId();
        // $help->save();

    }

    /**
     * Handle the help "deleted" event.
     */
    public function deleted(Help $help): void
    {
        #Log
        $this->webspice->log('helps', $help->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(Help $help): void
    {
        #Log
        $this->webspice->log('helps', $help->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('restore_success');

        // $help->deleted_by = NULL;
        // $help->save();
    }

   
    public function forceDeleted(Help $help): void
    {
        #Log
        $this->webspice->log('helps', $help->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
