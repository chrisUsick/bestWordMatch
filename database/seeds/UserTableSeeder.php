<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->delete();
      DB::table('users')->insert([
        'email'=>'a@b.com',
        'password'=>bcrypt('a'),
        'name'=>'Chris'
      ]);
    }
}
