<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Gacha;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Gacha::class, function (Faker $faker) {
  $startDate = Carbon::now()->subDays($faker->numberBetween(1, 30));
  return [
    'name' => Str::random(25),
    'category_id' => $faker->numberBetween(1, 20),
    'company_id' => $faker->numberBetween(1, 20),
    'selling_price' => $faker->numberBetween(3000, 20000),
    'discounted_price' => $faker->numberBetween(100, 1000),
    'discounted_percent' => $faker->numberBetween(1, 30),
    'postage' => $faker->numberBetween(100, 1000),
    'status_apply_discounts' => $faker->numberBetween(1, 2),
    'status_operation' => $faker->numberBetween(0, 1),
    'status' => $faker->numberBetween(1, 3),
    'period_start' => $startDate->timestamp,
    'period_end' => $startDate->addDays($faker->numberBetween(1, 30))->timestamp,
    'description' => $faker->paragraph(),
  ];
});
