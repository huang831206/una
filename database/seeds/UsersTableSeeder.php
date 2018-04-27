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
        DB::table('users')->truncate();

        App\User::create([
            'email' => 'a@aa.aa',
            'name'=>'admin',
            'password'=>Hash::make('aaaaaa')
        ]);

    }
}
