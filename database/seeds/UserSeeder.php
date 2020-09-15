<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => \Str::orderedUuid(),
            'name' => 'General Admin',
            'email' => 'laravelteste@gmail.com',
            'password' => Hash::make('laravelteste'),
            'tipo' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ]);

        factory('App\User', 10)->create();

    }
}
