<?php

namespace App\Observers;

use App\Models\SubAnswer;
use App\Lib\Webspice;

class SubAnswerObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('sub_answers');
    }
    /**
     * Handle the SubAnswer "created" event.
     */
    public function created(SubAnswer $sub_answer): void
    {
        #Log
        $this->webspice->log('sub_answers', $sub_answer->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the SubAnswer "updated" event.
     */
    public function updated(SubAnswer $sub_answer): void
    {
        #Log
        $this->webspice->log('sub_answers', $sub_answer->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('update_success');

        // $sub_answer->updated_at = $this->webspice->now('datetime24');
        // $sub_answer->updated_by = $this->webspice->getSubAnswerId();
        // $sub_answer->save();

    }

    /**
     * Handle the SubAnswer "deleted" event.
     */
    public function deleted(SubAnswer $sub_answer): void
    {
        #Log
        $this->webspice->log('sub_answers', $sub_answer->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(SubAnswer $sub_answer): void
    {
        #Log
        $this->webspice->log('sub_answers', $sub_answer->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('restore_success');

        // $sub_answer->deleted_by = NULL;
        // $sub_answer->save();
    }

   
    public function forceDeleted(SubAnswer $sub_answer): void
    {
        #Log
        $this->webspice->log('sub_answers', $sub_answer->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
