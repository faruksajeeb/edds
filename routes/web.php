<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Lib\Webspice;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubQuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\SubAnswerController;
use App\Http\Controllers\UserResponseController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\MarketController;

use App\Http\Livewire\Backend\OptionGroup;
use App\Http\Livewire\Backend\Options;
use App\Http\Livewire\Backend\CategoryComponent;
use App\Http\Livewire\Backend\SubCategoryComponent;

use App\Http\Livewire\Frontend\Home;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Home::class)->name('/');

Route::middleware('auth')->group(function () {
    Route::get('active-inactive', [Webspice::class, 'activeInactive'])->name('active.inactive');
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::any('change-password', [UserController::class, 'changePassword'])->name('change-password');
    Route::get('user-profile', [UserController::class, 'userProfile'])->name('user-profile');

    Route::get('option-groups', OptionGroup::class)->name('option-groups');
    Route::get('options', Options::class)->name('options');
    Route::get('categories', CategoryComponent::class)->name('categories');
    Route::get('sub_categories', SubCategoryComponent::class)->name('sub_categories');

    Route::group(['middleware' => ['role:superadmin|developer']], function () { //user & role only created by superadmin
        Route::resources([
            'roles' => RoleController::class,
            'users' => UserController::class,
            'permissions' => PermissionController::class,
            'questions' => QuestionController::class,
            'sub_questions' => SubQuestionController::class,
            'answers' => AnswerController::class,
            'sub_answers' => SubAnswerController::class,
            'user_responses' => UserResponseController::class,
            'areas' => AreaController::class,
            'markets' => MarketController::class
        ]);
        Route::match(['get', 'put'], 'company-setting', [SettingController::class, 'companySetting'])->name('company-setting');
        Route::match(['get', 'put'], 'basic-setting', [SettingController::class, 'basicSetting'])->name('basic-setting');
        Route::match(['get', 'put'], 'theme-setting', [SettingController::class, 'themeSetting'])->name('theme-setting');
        Route::match(['get', 'put'], 'email-setting', [SettingController::class, 'emailSetting'])->name('email-setting');
        Route::match(['get', 'put'], 'performance-setting', [SettingController::class, 'performanceSetting'])->name('performance-setting');
        Route::match(['get', 'put'], 'approval-setting', [SettingController::class, 'approvalSetting'])->name('approval-setting');
        Route::match(['get', 'put'], 'invoice-setting', [SettingController::class, 'invoiceSetting'])->name('invoice-setting');
        Route::match(['get', 'put'], 'salary-setting', [SettingController::class, 'salarySetting'])->name('salary-setting');
        Route::match(['get', 'put'], 'notification-setting', [SettingController::class, 'notificationSetting'])->name('notification-setting');
        Route::match(['get', 'put'], 'toxbox-setting', [SettingController::class, 'toxboxSetting'])->name('toxbox-setting');
        Route::match(['get', 'put'], 'cron-setting', [SettingController::class, 'cronSetting'])->name('cron-setting');
    });

    # User
    Route::group([
        'prefix' => '/users',
        'as' => 'users.',
    ], function () {
        Route::post('/{user}/restore', [UserController::class, 'restore'])->name('restore');
        Route::delete('/{user}/force-delete', [UserController::class, 'forceDelete'])->name('force-delete');
        Route::post('/restore-all', [UserController::class, 'restoreAll'])->name('restore-all');
    });

    # Role
    Route::group([
        'prefix' => '/roles',
        'as' => 'roles.',
    ], function () {
        Route::post('/{role}/restore', [RoleController::class, 'restore'])->name('restore');
        Route::delete('/{role}/force-delete', [RoleController::class, 'forceDelete'])->name('force-delete');
        Route::post('/restore-all', [RoleController::class, 'restoreAll'])->name('restore-all');
    });
    Route::get('clear-permission-cache', [RoleController::class, 'clearPermissionCache'])->name('clear-permission-cache');
    
    # Permission
    Route::group([
        'prefix' => '/permissions',
        'as' => 'permissions.',
    ], function () {
        Route::post('/{permission}/restore', [PermissionController::class, 'restore'])->name('restore');
        Route::delete('/{permission}/force-delete', [PermissionController::class, 'forceDelete'])->name('force-delete');
        Route::post('/restore-all', [PermissionController::class, 'restoreAll'])->name('restore-all');
    });

    # Question
    Route::group([
        'prefix' => '/questions',
        'as' => 'questions.',
    ], function () {
        Route::post('/{question}/restore', [QuestionController::class, 'restore'])->name('restore');
        Route::delete('/{question}/force-delete', [QuestionController::class, 'forceDelete'])->name('force-delete');
        Route::post('/restore-all', [QuestionController::class, 'restoreAll'])->name('restore-all');
    });

    # Sub Question
    Route::group([
        'prefix' => '/sub_questions',
        'as' => 'sub_questions.',
    ], function () {
        Route::post('/{sub_question}/restore', [SubQuestionController::class, 'restore'])->name('restore');
        Route::delete('/{sub_question}/force-delete', [SubQuestionController::class, 'forceDelete'])->name('force-delete');
        Route::post('/restore-all', [SubQuestionController::class, 'restoreAll'])->name('restore-all');
    });

    # Answer
    Route::group([
        'prefix' => '/answers',
        'as' => 'answers.',
    ], function () {
        Route::post('/{answer}/restore', [AnswerController::class, 'restore'])->name('restore');
        Route::delete('/{answer}/force-delete', [AnswerController::class, 'forceDelete'])->name('force-delete');
        Route::post('/restore-all', [AnswerController::class, 'restoreAll'])->name('restore-all');
    });
    
    # Sub Answer
    Route::group([
        'prefix' => '/sub_answers',
        'as' => 'sub_answers.',
    ], function () {
        Route::post('/{sub_answer}/restore', [SubAnswerController::class, 'restore'])->name('restore');
        Route::delete('/{sub_answer}/force-delete', [SubAnswerController::class, 'forceDelete'])->name('force-delete');
        Route::post('/restore-all', [SubAnswerController::class, 'restoreAll'])->name('restore-all');
    });

    # User Response
    Route::group([
        'prefix' => '/user_responses',
        'as' => 'user_responses.',
    ], function () {
        Route::post('/{user_response}/restore', [UserResponseController::class, 'restore'])->name('restore');
        Route::delete('/{user_response}/force-delete', [UserResponseController::class, 'forceDelete'])->name('force-delete');
        Route::post('/restore-all', [UserResponseController::class, 'restoreAll'])->name('restore-all');
    });

    # Area
    Route::group([
        'prefix' => '/areas',
        'as' => 'areas.',
    ], function () {
        Route::post('/{area}/restore', [AreaController::class, 'restore'])->name('restore');
        Route::delete('/{area}/force-delete', [AreaController::class, 'forceDelete'])->name('force-delete');
        Route::post('/restore-all', [AreaController::class, 'restoreAll'])->name('restore-all');
    });

     # Market
     Route::group([
        'prefix' => '/markets',
        'as' => 'markets.',
    ], function () {
        Route::post('/{market}/restore', [MarketController::class, 'restore'])->name('restore');
        Route::delete('/{market}/force-delete', [MarketController::class, 'forceDelete'])->name('force-delete');
        Route::post('/restore-all', [MarketController::class, 'restoreAll'])->name('restore-all');
    });

    # Report
    Route::match(['get','post'],'survey-report', [ReportController::class, 'surveyReport'])->name('survey-report');
});
Route::get('/clear', function () {
    // Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:cache');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return back()->with("success", 'Cleared all.');
});


require __DIR__ . '/auth.php';
