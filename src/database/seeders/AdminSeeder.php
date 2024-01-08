<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('users')->truncate();
        \DB::table('admins')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user = User::updateOrCreate(['name' => 'User'], [
            'name' => 'User',
            'name_furigana' => 'システム',
            'email' => 'user@example.com',
            'password' => bcrypt('Gachapo123'),
            'customer_id' => 1,
            'birthday' => '20-03-1999',
            'phone' => '323-3232-3311',
            'category_id' => 1,
            'gender' => 1,
            'profession' => 'Test',
            'address_first' => 'Ha Noi',
            'address_second' => 'HCM',
            'address_type' => 1,
            'status' => 1,
            'status_two_step_verification' => false,
            'status_notifice' => false
        ]);
        $user->syncRoles(ROLE_ADMIN);

        $admin = Admin::updateOrCreate(['name' => 'Admin'], [
            'name' => 'Admin',
            'name_furigana' => 'システム',
            'email' => 'admin@example.com',
            'password' => bcrypt('Gachapo123'),
            'status' => ACTIVE,
        ]);
    }
}
