<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Roles;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        DB::table('admin_roles')->truncate();

        $adminRoles = Roles::where('name', 'admin')->first();
        $authorRoles = Roles::where('name', 'author')->first();
        $userRoles = Roles::where('name', 'user')->first();

        $admin = Admin::create([
            'admin_name' => 'linhadmin',
            'admin_email' => 'linhnga2002@gmail.com',
            'admin_password' => md5('123'),
            'admin_phone' => '0123456789'
            
        ]);
        $author = Admin::create([
            'admin_name' => 'linhauthor',
            'admin_email' => 'linhngaauthor2002@gmail.com',
            'admin_password' => md5('123'),
            'admin_phone' => '0123456789'
            
        ]);
        $user = Admin::create([
            'admin_name' => 'linhuser',
            'admin_email' => 'linhngauser2002@gmail.com',
            'admin_password' => md5('123'),
            'admin_phone' => '0123456789'
            
        ]);

        $admin->roles()->attach($adminRoles);
        $author->roles()->attach($authorRoles);
        $user->roles()->attach($userRoles);

        factory(App\Admin::class,20)->create();

    }
}
