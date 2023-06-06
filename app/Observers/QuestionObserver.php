<?php

namespace App\Observers;

use App\Models\Question;
use App\Lib\Webspice;
use DB;

class QuestionObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('questions');
    }
    /**
     * Handle the Question "created" event.
     */
    public function created(Question $question): void
    {
        #Log
        $this->webspice->log('questions', $question->id, "INSERTED");
        # Cache Update
        $this->cacheClear();

        // Update a single record
        
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the Question "updated" event.
     */
    public function updated(Question $question): void
    {
        #Log
        $this->webspice->log('questions', $question->id, "UPDATED");
        # Cache Update
        $this->cacheClear();       
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('update_success');

        // $question->updated_at = $this->webspice->now('datetime24');
        // $question->updated_by = $this->webspice->getQuestionId();
        // $question->save();

    }

    /**
     * Handle the Question "deleted" event.
     */
    public function deleted(Question $question): void
    {
        #Log
        $this->webspice->log('questions', $question->id, "DELETED");
        # Cache Update
        $this->cacheClear();        
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(Question $question): void
    {
        #Log
        $this->webspice->log('questions', $question->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('restore_success');

        // $question->deleted_by = NULL;
        // $question->save();
    }

   
    public function forceDeleted(Question $question): void
    {
        #Log
        $this->webspice->log('questions', $question->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();        
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
