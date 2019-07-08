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
                'name' => 'Yudi Hertanto',
                'email' => 'y.hertanto17@gmail.com',
                'password' => Hash::make('asdasdasd'),
                'phone' => '+6289602222206',
                'city_id' => 159,
                'email_verified_at' => now(),
                'photo_url' => 'picture.jpg',
                'is_admin' => true
            ],
            [
                'name' => 'Yudi Hertanto',
                'email' => 'tanyudi17@gmail.com',
                'password' => Hash::make('asdasdasd'),
                'phone' => '+6289602222206',
                'city_id' => 159,
                'email_verified_at' => now(),
                'photo_url' => 'picture.jpg'
            ]
        ];

        foreach($users as $user) {
            \App\Entities\User::create($user);
        }
    }
}
