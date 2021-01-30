<?php

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
        $users = [
            [
                'name' => 'ユーザー1',
                'email' => 'test1@email.com',
                'password' => Hash::make('testtest'),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'ユーザー2',
                'email' => 'test2@email.com',
                'password' => Hash::make('testtest'),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
