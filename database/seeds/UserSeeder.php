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
            'name' => 'Adminstrador Geral',
            'email' => 'laiquesantana@gmail.com',
            'cpf' => '06001814562',
            'password' => Hash::make('010619946463'),
            'tenant_id' => 1,
            'tipo' => 'admin',
            'orgao_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ]);

        factory('App\User', 10)->create();

    }
}
