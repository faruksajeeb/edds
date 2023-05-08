<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\User;
use App\Observers\UserObserver;
use Spatie\Permission\Models\Role;
use App\Observers\RoleObserver;
use Spatie\Permission\Models\Permission;
use App\Observers\PermissionObserver;
use App\Models\Question;
use App\Observers\QuestionObserver;
use App\Models\SubQuestion;
use App\Observers\SubQuestionObserver;
use App\Models\Answer;
use App\Observers\AnswerObserver;
use App\Models\SubAnswer;
use App\Observers\SubAnswerObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Role::observe(RoleObserver::class);
        Permission::observe(PermissionObserver::class);
        Question::observe(QuestionObserver::class);
        SubQuestion::observe(SubQuestionObserver::class);
        Answer::observe(AnswerObserver::class);
        SubAnswer::observe(SubAnswerObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
