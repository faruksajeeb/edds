<?php

namespace App\Observers;

use App\Models\User;
use App\Lib\Webspice;

class UserObserver
{
    protected $webspice;

    public function __construct(Webspice $webspice)
    {
        $this->webspice = $webspice;
    }

    public function cacheClear(){
        $this->webspice->forgetCache('users');
    }
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        #Log
        $this->webspice->log('users', $user->id, "INSERTED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('insert_success');

        #Send Email
        $subject = $user->name." user updated";
        $data = array(
            'name' => 'Admin',
            'body' => 'User("'.$user->name.') has been created successfully.'
        );
        $this->webspice->sendEmail($to=$this->webspice->adminEmail,$cc=null,$subject,$data,$template='mail.user_mail');
    }


    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {   
        #Log
        $this->webspice->log('users', $user->id, "UPDATED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('update_success');
      
        // $user->updated_at = $this->webspice->now('datetime24');
        // $user->updated_by = $this->webspice->getUserId();
        // $user->save();

        #Send Email
        $subject = $user->name." user updated";
        $data = array(
            'name' => 'Admin',
            'body' => 'User('.$user->name.') has been updated successfully.'
        );
        $this->webspice->sendEmail($to=$this->webspice->adminEmail,$cc=null,$subject,$data,$template='mail.user_mail');
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        #Log
        $this->webspice->log('users', $user->id, "DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('delete_success');

        #Send Email
        $subject = $user->name." user delete";
        $data = array(
            'name' => 'Admin',
            'body' => 'User('.$user->name.') has been deleted successfully.'
        );
        $this->webspice->sendEmail($to=$this->webspice->adminEmail,$cc=null,$subject,$data,$template='mail.user_mail');

        // $user->deleted_at = $this->webspice->now('datetime24');
        // $user->deleted_by = $this->webspice->getUserId();
        // $user->save();
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {        
        #Log
        $this->webspice->log('users', $user->id, "RESTORED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('restore_success');

        
        #Send Email
        $subject = $user->name." user restored";
        $data = array(
            'name' => 'Admin',
            'body' => "User(".$user->name.") has been restored successfully.!"
        );
        $this->webspice->sendEmail($to=$this->webspice->adminEmail,$cc=null,$subject,$data,$template='mail.user_mail');
        
        // $user->deleted_by = NULL;
        // $user->save();
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        #Log
        $this->webspice->log('users', $user->id, "FORCE DELETED");
        # Cache Update
        $this->cacheClear();
        #Message
        $this->webspice->message('force_delete_success');

        #Send Email
        $subject = $user->name." user force delete";
        $data = array(
            'name' => 'Admin',
            'body' => "User(".$user->name.") has been deleted permenently."
        );
        $this->webspice->sendEmail($to=$this->webspice->adminEmail,$cc=null,$subject,$data,$template='mail.user_mail');
    }
}
