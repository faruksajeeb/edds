<?php

namespace App\Observers;

use App\Models\Answer;
use App\Lib\Webspice;

class AnswerObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('answers');
    }
    /**
     * Handle the Answer "created" event.
     */
    public function created(Answer $answer): void
    {
        #Log
        $this->webspice->log('answers', $answer->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the Answer "updated" event.
     */
    public function updated(Answer $answer): void
    {
        #Log
        $this->webspice->log('answers', $answer->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('update_success');

        // $answer->updated_at = $this->webspice->now('datetime24');
        // $answer->updated_by = $this->webspice->getAnswerId();
        // $answer->save();

    }

    /**
     * Handle the Answer "deleted" event.
     */
    public function deleted(Answer $answer): void
    {
        #Log
        $this->webspice->log('answers', $answer->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(Answer $answer): void
    {
        #Log
        $this->webspice->log('answers', $answer->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('restore_success');

        // $answer->deleted_by = NULL;
        // $answer->save();
    }

   
    public function forceDeleted(Answer $answer): void
    {
        #Log
        $this->webspice->log('answers', $answer->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
