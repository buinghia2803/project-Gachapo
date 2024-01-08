<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('options')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $option = Option::create([
            'key' => 'type_show_banner',
            'value' => BANNER_TYPE_RANDOM,
        ]);
    }
}
