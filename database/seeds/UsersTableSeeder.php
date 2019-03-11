<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adm123'),
        ];
        $admin_user = User::create($admin);

        $admin_user->assignRole('admin');

        $developer =
            [
                'name' => 'developer',
                'email' => 'developer@gmail.com',
                'password' =>  bcrypt('dev123'),
            ];
        $developer_user = User::create($developer);

        $developer_user->assignRole('developer');
    }
}
