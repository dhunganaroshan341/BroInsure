<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'fname' => 'Roshan',
                'lname' => 'Dhungana',
                'mobilenumber' => '9800000001',
                'email' => 'roshan@example.com',
                'countrycode' => '977',
                'usertype' => 1,
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'fname' => 'Sita',
                'lname' => 'Shrestha',
                'mobilenumber' => '9800000002',
                'email' => 'sita@example.com',
                'countrycode' => '977',
                'usertype' => 1,
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'fname' => 'Ramesh',
                'lname' => 'Koirala',
                'mobilenumber' => '9800000003',
                'email' => 'ramesh@example.com',
                'countrycode' => '977',
                'usertype' => 1,
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'fname' => 'Anita',
                'lname' => 'Gurung',
                'mobilenumber' => '9800000004',
                'email' => 'anita@example.com',
                'countrycode' => '977',
                'usertype' => 1,
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'fname' => 'Bikash',
                'lname' => 'Khadka',
                'mobilenumber' => '9800000005',
                'email' => 'bikash@example.com',
                'countrycode' => '977',
                'usertype' => 1,
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'fname' => 'Maya',
                'lname' => 'Sharma',
                'mobilenumber' => '9800000006',
                'email' => 'maya@example.com',
                'countrycode' => '977',
                'usertype' => 1,
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'fname' => 'Suman',
                'lname' => 'Gautam',
                'mobilenumber' => '9800000007',
                'email' => 'suman@example.com',
                'countrycode' => '977',
                'usertype' => 1,
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'fname' => 'Priya',
                'lname' => 'Thapa',
                'mobilenumber' => '9800000008',
                'email' => 'priya@example.com',
                'countrycode' => '977',
                'usertype' => 1,
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'fname' => 'Rajan',
                'lname' => 'Rai',
                'mobilenumber' => '9800000009',
                'email' => 'rajan@example.com',
                'countrycode' => '977',
                'usertype' => 1,
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'fname' => 'Kiran',
                'lname' => 'Magar',
                'mobilenumber' => '9800000010',
                'email' => 'kiran@example.com',
                'countrycode' => '977',
                'usertype' => 1,
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
