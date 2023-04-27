<?php

namespace App\Http\Controllers;

use App\Lib\Webspice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            //    $this->user = Auth::user();
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    public function companySetting(Request $request)
    {
        #permission verfy
        if (is_null($this->user) || !$this->user->can('company.setting')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }
        if ($request->all()) {
            $request->validate(
                [
                    'company_name' => 'required'
                ]
            );
            $updateData = array(
                'company_name' => $request->company_name,
                'contact_person' => $request->contact_person,
                'address' => $request->address,
                'country' => $request->country,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'mobile_number' => $request->mobile_number,
                'fax' => $request->fax,
                'website_url' => $request->website_url,
                'updated_at' => now()
            );
            try {
                DB::table('company_settings')
                    ->where('id', 1)
                    ->update($updateData);
                # remove cache
                Cache::forget('company_settings');
            } catch (\Exception $e) {
                # return error message
                return back()->with("error", $e->getMessage());
            }
            # write log
            Webspice::log('company_settings', 1, "Company information updated.");
            # success message
            return back()->with("success", "Company information has been changed successfully!");
        }
        if (Cache::has('company_settings')) {
            # get from file cache
            $companySettings = Cache::get('company_settings');
        } else {
            # get from database
            $companySettings = DB::table('company_settings')->first();
            Cache::put('company_settings', $companySettings);
        }
        return view('settings.company-setting', compact('companySettings'));
    }

    public function basicSetting(Request $request)
    {
        #permission verfy
        if (is_null($this->user) || !$this->user->can('basic.setting')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }
        if ($request->all()) {
            $request->validate(
                [
                    'default_country' => 'required'
                ]
            );
            $updateData = array(
                'default_country' => $request->default_country,
                'timezone' => $request->timezone,
                'currency_code' => $request->currency_code,
                'date_format' => $request->date_format,
                'default_language' => $request->default_language,
                'currency_symbol' => $request->currency_symbol,
                'updated_at' => now()
            );
            try {
                DB::table('basic_settings')
                    ->where('id', 1)
                    ->update($updateData);
                # remove cache
                Cache::forget('basic_settings');
            } catch (\Exception $e) {
                # return error message
                return back()->with("error", $e->getMessage());
            }
            # write log
            Webspice::log('basic_settings', 1, "Basic information updated.");
            # success message
            return back()->with("success", "Basic information has been changed successfully!");
        }
        if (Cache::has('basic_settings')) {
            # get from file cache
            $basicSettings = Cache::get('basic_settings');
        } else {
            # get from database
            $basicSettings = DB::table('basic_settings')->first();
            Cache::put('basic_settings', $basicSettings);
        }
        return view('settings.basic-setting', compact('basicSettings'));
    }

    public function themeSetting(Request $request)
    {
        #permission verfy
        if (is_null($this->user) || !$this->user->can('theme.setting')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }
        if ($request->all()) {
            $request->validate(
                [
                    'website_name' => 'required',
                    'website_logo' => 'required|mimes:png,jpg,jpeg,gif,svg|max:2048',
                    'website_favicon' => 'required|mimes:ico,png,jpg,jpeg,svg|max:512'
                ]
            );

            $websiteLogoFileName = "";
            $websiteFaviconFileName = "";
            if ($request->hasFile('website_logo')) {
                $websiteLogo = $request->website_logo;
                #custom file name
                $websiteLogoFileName = time() . "-logo-" . Webspice::sanitizeFileName($websiteLogo->getClientOriginalName());
            }

            if ($request->hasFile('website_logo')) {
                $websiteFavicon = $request->website_favicon;
                #custom file name        
                $websiteFaviconFileName = time() . "-favicon-" . Webspice::sanitizeFileName($websiteFavicon->getClientOriginalName());
            }
            # Move Uploaded File
            $destinationPath = 'uploads';
            //$websiteLogo->move($destinationPath,$websiteLogoFileName);

            try {
                # Existing file remove before upload a file
                $existingRecord = DB::table('theme_settings')->where('id', 1)->first();
                if (File::exists(public_path($destinationPath . '/' . $existingRecord->website_logo))) {
                    File::delete(public_path($destinationPath . '/' . $existingRecord->website_logo));
                }
                if (File::exists(public_path($destinationPath . '/' . $existingRecord->website_favicon))) {
                    File::delete(public_path($destinationPath . '/' . $existingRecord->website_favicon));
                }
                # Move Uploaded File
                if (
                    $websiteLogo->move($destinationPath, $websiteLogoFileName) &&
                    $websiteFavicon->move($destinationPath, $websiteFaviconFileName)
                ) {

                    # Update database
                    $updateData = array(
                        'website_name' => $request->website_name,
                        'website_logo' => $websiteLogoFileName,
                        'website_favicon' => $websiteFaviconFileName,
                        'updated_at' => now()
                    );

                    DB::table('theme_settings')
                        ->where('id', 1)
                        ->update($updateData);
                    # remove cache
                    Cache::forget('theme_settings');
                }
            } catch (\Exception $e) {
                if (File::exists(public_path($destinationPath . '/' . $websiteLogoFileName))) {
                    File::delete(public_path($destinationPath . '/' . $websiteLogoFileName));
                }
                if (File::exists(public_path($destinationPath . '/' . $websiteFaviconFileName))) {
                    File::delete(public_path($destinationPath . '/' . $websiteFaviconFileName));
                }
                # return error message
                return back()->with("error", $e->getMessage());
            }
            # write log
            Webspice::log('theme_settings', 1, "Theme information updated.");
            # success message
            return back()->with("success", "Theme information has been changed successfully!");
        }
        if (Cache::has('theme_settings')) {
            # get from file cache
            $themeSettings = Cache::get('theme_settings');
        } else {
            # get from database
            $themeSettings = DB::table('theme_settings')->first();
            Cache::put('theme_settings', $themeSettings);
        }
        return view('settings.theme-setting', compact('themeSettings'));
    }
    public function emailSetting(Request $request)
    {
        // $emailSettings = DB::table('email_settings')->get();
        return view('settings.email-setting', [
            // 'emailSettings' => $emailSettings
        ]);
    }
    public function performanceSetting(Request $request)
    {
        // $performanceSettings = DB::table('performance_settings')->get();
        return view('settings.performance-setting', [
            // 'performanceSettings' => $performanceSettings
        ]);
    }
    public function approvalSetting(Request $request)
    {
        // $approvalSettings = DB::table('approval_settings')->get();
        return view('settings.approval-setting', [
            // 'approvalSettings' => $approvalSettings
        ]);
    }
    public function invoiceSetting(Request $request)
    {
        #permission verify
        if (is_null($this->user) || !$this->user->can('invoice.setting')) {
            abort(403, 'SORRY! You are unauthorized to access user list!');
        }
        #input verify
        if ($request->all()) {
            $request->validate(
                [
                    'invoice_prefix' => 'required',
                    'invoice_logo' => 'required|mimes:png,jpg,jpeg,gif,svg|max:2048'
                ]
            );

            $invoiceLogoFileName = "";
            if ($request->hasFile('invoice_logo')) {
                $invoiceLogo = $request->invoice_logo;
                #custom file name
                $invoiceLogoFileName = time() . "-invoice-logo-" . Webspice::sanitizeFileName($invoiceLogo->getClientOriginalName());
            }

            # Move Uploaded File
            $destinationPath = 'uploads';
            //$websiteLogo->move($destinationPath,$websiteLogoFileName);

            try {
                # Existing file remove before upload a file
                $existingRecord = DB::table('invoice_settings')->where('id', 1)->first();
                if (File::exists(public_path($destinationPath . '/' . $existingRecord->invoice_logo))) {
                    File::delete(public_path($destinationPath . '/' . $existingRecord->invoice_logo));
                }
                # Move Uploaded File
                if ($invoiceLogo->move($destinationPath, $invoiceLogoFileName)) {
                    # Update database
                    $updateData = array(
                        'invoice_prefix' => $request->invoice_prefix,
                        'invoice_logo' => $invoiceLogoFileName,
                        'updated_at' => now()
                    );

                    DB::table('invoice_settings')
                        ->where('id', 1)
                        ->update($updateData);
                    # remove cache
                    Cache::forget('invoice_settings');
                }
            } catch (\Exception $e) {
                if (File::exists(public_path($destinationPath . '/' . $invoiceLogoFileName))) {
                    File::delete(public_path($destinationPath . '/' . $invoiceLogoFileName));
                }
                # return error message
                return back()->with("error", $e->getMessage());
            }
            # write log
            Webspice::log('invoice_settings', 1, "Invoice information updated.");
            # success message
            return back()->with("success", "Invoice information has been changed successfully!");
        }
        if (Cache::has('invoice_settings')) {
            # get from file cache
            $invoiceSettings = Cache::get('invoice_settings');
        } else {
            # get from database
            $invoiceSettings = DB::table('invoice_settings')->first();
            Cache::put('invoice_settings', $invoiceSettings);
        }
        return view('settings.invoice-setting', compact('invoiceSettings'));
    }
    public function salarySetting(Request $request)
    {
        // $salarySettings = DB::table('salary_settings')->get();
        return view('settings.salary-setting', [
            // 'salarySettings' => $salarySettings
        ]);
    }
    public function notificationSetting(Request $request)
    {
        // $notificationSettings = DB::table('notification_settings')->get();
        return view('settings.notification-setting', [
            // 'notificationSettings' => $notificationSettings
        ]);
    }
    public function toxboxSetting(Request $request)
    {
        // $toxboxSettings = DB::table('toxbox_settings')->get();
        return view('settings.toxbox-setting', [
            // 'toxboxSettings' => $toxboxSettings
        ]);
    }
    public function cronSetting(Request $request)
    {
        // $cronSettings = DB::table('cron_settings')->get();
        return view('settings.cron-setting', [
            // 'cronSettings' => $cronSettings
        ]);
    }
}
