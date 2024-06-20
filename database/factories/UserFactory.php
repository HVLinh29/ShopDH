<?php

use App\Admin;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Roles;
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

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'admin_name' => $faker->name,
        'admin_email' => $faker->unique()->safeEmail,
        'admin_phone' => '123',
        'admin_password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        
    ];
});
$factory->afterCreating(Admin::class,function($admin,$faker){
    $roles = Roles::where('name','user')->get();
    $admin->roles()->sync($roles->pluck('id_roles')->toArray());
});
