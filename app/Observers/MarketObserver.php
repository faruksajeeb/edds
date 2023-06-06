<?php

namespace App\Observers;

use App\Models\Market;
use App\Lib\Webspice;

class MarketObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('markets');
    }
    /**
     * Handle the Market "created" event.
     */
    public function created(Market $market): void
    {
        #Log
        $this->webspice->log('markets', $market->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the Market "updated" event.
     */
    public function updated(Market $market): void
    {
        #Log
        $this->webspice->log('markets', $market->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('update_success');

        // $market->updated_at = $this->webspice->now('datetime24');
        // $market->updated_by = $this->webspice->getMarketId();
        // $market->save();

    }

    /**
     * Handle the Market "deleted" event.
     */
    public function deleted(Market $market): void
    {
        #Log
        $this->webspice->log('markets', $market->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(Market $market): void
    {
        #Log
        $this->webspice->log('markets', $market->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('restore_success');

        // $market->deleted_by = NULL;
        // $market->save();
    }

   
    public function forceDeleted(Market $market): void
    {
        #Log
        $this->webspice->log('markets', $market->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
