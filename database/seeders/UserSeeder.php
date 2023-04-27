<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'ofsajeeb@gmail.com')->first();
        if (is_null($user)) {
            $user = new User();
            $user->name = "Omar Faruk Sajeeb";
            $user->email = "ofsajeeb@gmail.com";
            $user->password = Hash::make("12345678");
            $user->save();
            
            $user->assignRole('superadmin');
            // DB::table('model_has_roles')->insert(
            //     array(
            //         'role_id' => 1,
            //         'model_type' => 'App\Models\User',
            //         'model_id' => $user->id
            //         )
            // );
        }
    }
}
