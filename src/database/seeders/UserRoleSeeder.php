<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('user_role')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        \DB::table('user_role')->insert(array (
            0 =>
                array (
                    'user_id' => 1,
                    'role_id' => 1
                ),
        ));
    }
}
