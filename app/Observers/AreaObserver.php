<?php

namespace App\Observers;

use App\Models\Area;
use App\Lib\Webspice;

class AreaObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('areas');
    }
    /**
     * Handle the Area "created" event.
     */
    public function created(Area $area): void
    {
        #Log
        $this->webspice->log('areas', $area->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the Area "updated" event.
     */
    public function updated(Area $area): void
    {
        #Log
        $this->webspice->log('areas', $area->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('update_success');

        // $area->updated_at = $this->webspice->now('datetime24');
        // $area->updated_by = $this->webspice->getAreaId();
        // $area->save();

    }

    /**
     * Handle the Area "deleted" event.
     */
    public function deleted(Area $area): void
    {
        #Log
        $this->webspice->log('areas', $area->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(Area $area): void
    {
        #Log
        $this->webspice->log('areas', $area->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('restore_success');

        // $area->deleted_by = NULL;
        // $area->save();
    }

   
    public function forceDeleted(Area $area): void
    {
        #Log
        $this->webspice->log('areas', $area->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
