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
        $this->call(TenantSeeder::class); 
        $this->call(OrgaoSeeder::class); 
        $this->call(UserSeeder::class);
        $this->call(UnidadeFederativasSeeder::class);
    }
}
