<?php

namespace App\Observers;

use App\Models\RespondentType;
use App\Lib\Webspice;

class RespondentTypeObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('respondent_types');
    }
    /**
     * Handle the help "created" event.
     */
    public function created(RespondentType $RespondentType): void
    {
        #Log
        $this->webspice->log('respondent_types', $RespondentType->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the help "updated" event.
     */
    public function updated(RespondentType $RespondentType): void
    {
        #Log
        $this->webspice->log('respondent_types', $RespondentType->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('update_success');

        // $RespondentType->updated_at = $this->webspice->now('datetime24');
        // $RespondentType->updated_by = $this->webspice->gethelpId();
        // $RespondentType->save();

    }

    /**
     * Handle the help "deleted" event.
     */
    public function deleted(RespondentType $RespondentType): void
    {
        #Log
        $this->webspice->log('respondent_types', $RespondentType->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(RespondentType $RespondentType): void
    {
        #Log
        $this->webspice->log('respondent_types', $RespondentType->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('restore_success');

        // $RespondentType->deleted_by = NULL;
        // $RespondentType->save();
    }

   
    public function forceDeleted(RespondentType $RespondentType): void
    {
        #Log
        $this->webspice->log('respondent_types', $RespondentType->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
