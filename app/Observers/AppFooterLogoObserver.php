<?php

namespace App\Observers;

use App\Models\AppFooterLogo;
use App\Lib\Webspice;

class AppFooterLogoObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear()
    {
        $this->webspice->forgetCache('app_footer_logos');
    }
    /**
     * Handle the healthcare "created" event.
     */
    public function created(AppFooterLogo $app_footer_logo): void
    {
        #Log
        $this->webspice->log('app_footer_logos', $app_footer_logo->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('insert_success');
    }


    /**
     * Handle the healthcare "updated" event.
     */
    public function updated(AppFooterLogo $app_footer_logo): void
    {
        #Log
        $this->webspice->log('app_footer_logos', $app_footer_logo->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('update_success');

        // $app_footer_logo->updated_at = $this->webspice->now('datetime24');
        // $app_footer_logo->updated_by = $this->webspice->gethealthcareId();
        // $app_footer_logo->save();

    }

    /**
     * Handle the healthcare "deleted" event.
     */
    public function deleted(AppFooterLogo $app_footer_logo): void
    {
        #Log
        $this->webspice->log('app_footer_logos', $app_footer_logo->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('delete_success');
    }

    
    public function restored(AppFooterLogo $app_footer_logo): void
    {
        #Log
        $this->webspice->log('app_footer_logos', $app_footer_logo->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('restore_success');

        // $app_footer_logo->deleted_by = NULL;
        // $app_footer_logo->save();
    }

   
    public function forceDeleted(AppFooterLogo $app_footer_logo): void
    {
        #Log
        $this->webspice->log('app_footer_logos', $app_footer_logo->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        $this->webspice->versionUpdate();
        #Message
        $this->webspice->message('force_delete_success');
    }
}
