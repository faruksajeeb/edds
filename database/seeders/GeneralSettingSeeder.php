<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Create default company
        DB::table('company_settings')->insert([
            'company_name' => 'ABC Ltd.',
            'contact_person' => 'Omar Sajeeb Mridha',
            'created_at' => now()
        ]);

        # Create default Basic Setting
        DB::table('basic_settings')->insert([
            'default_country' => 'Bangladesh',
            'timezone' => 'Asia/Dhaka',
            'currency_code' => 'BDT',
            'date_format' => 'Y-m-d',
            'default_language' => 'English',
            'currency_symbol' => '৳',
            'created_at' => now()
        ]);

         # Create default Theme Setting
         DB::table('theme_settings')->insert([
            'website_name' => 'XYZ Ltd.',
            'created_at' => now()
        ]);

         # Create default Email Setting
         DB::table('email_settings')->insert([
            'host_type' => 'SMTP',
            'email_from' => 'example@mail.com',
            'email_from_name' => 'Company Name',
            'created_at' => now()
        ]);

         # Create default Invoice Setting
         DB::table('invoice_settings')->insert([
            'invoice_prefix' => 'INV',
            'created_at' => now()
        ]);

         # Create default Notification Setting
         DB::table('notifications_settings')->insert([
            'employee' => 'no',
            'holidays' => 'no',
            'leaves' => 'no',
            'events' => 'no',
            'chat' => 'no',
            'jobs' => 'no',
            'created_at' => now()
        ]);

         # Create default Tox-box Setting
         DB::table('toxbox_settings')->insert([
            'api_key' => '',
            'api_secret' => '',
            'created_at' => now()
        ]);

         # Create default cron Setting
         DB::table('cron_settings')->insert([
            'cron_key' => '',
            'created_at' => now()
        ]);
    }
}
