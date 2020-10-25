<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        DB::table('users')->insert([
            'name'     => 'Super Admin',
            'email'    => 'superadmin@gmail.com',
            'phone'    => '7797771984',
            'password' => bcrypt('superadmin'),
            'role'     => 0,
            'status'   => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'name'     => 'Distributor',
            'email'    => 'distributor1@gmail.com',
            'phone'    => '8158810031',
            'password' => bcrypt('admin'),
            'role'     => 1,
            'status'   => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'name'     => 'Retailer',
            'email'    => 'retailer@gmail.com',
            'phone'    => '9002011555',
            'password' => bcrypt('admin'),
            'role'     => 2,
            'status'   => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'name'     => 'Seller',
            'email'    => 'seller@gmail.com',
            'phone'    => '1234567892',
            'password' => bcrypt('admin'),
            'role'     => 3,
            'status'   => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'name'     => 'Workers',
            'email'    => 'workers@gmail.com',
            'phone'    => '1234567890',
            'password' => bcrypt('admin'),
            'role'     => 4,
            'status'   => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);



    }
}
