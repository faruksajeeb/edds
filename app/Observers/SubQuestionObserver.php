<?php

namespace App\Observers;

use App\Models\SubQuestion;
use App\Lib\Webspice;

class SubQuestionObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('sub_questions');
    }
    /**
     * Handle the SubQuestion "created" event.
     */
    public function created(SubQuestion $sub_question): void
    {
        #Log
        $this->webspice->log('sub_questions', $sub_question->id, "INSERTED");
        # Cache Update
        $this->cacheClear();       
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the SubQuestion "updated" event.
     */
    public function updated(SubQuestion $sub_question): void
    {
        #Log
        $this->webspice->log('sub_questions', $sub_question->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('update_success');

        // $sub_question->updated_at = $this->webspice->now('datetime24');
        // $sub_question->updated_by = $this->webspice->getSubQuestionId();
        // $sub_question->save();

    }

    /**
     * Handle the SubQuestion "deleted" event.
     */
    public function deleted(SubQuestion $sub_question): void
    {
        #Log
        $this->webspice->log('sub_questions', $sub_question->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(SubQuestion $sub_question): void
    {
        #Log
        $this->webspice->log('sub_questions', $sub_question->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('restore_success');

        $this->webspice->versionUpdate();
        // $sub_question->deleted_by = NULL;
        // $sub_question->save();
    }

   
    public function forceDeleted(SubQuestion $sub_question): void
    {
        #Log
        $this->webspice->log('sub_questions', $sub_question->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();        
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
