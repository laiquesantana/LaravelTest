<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrgaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orgaos = array(
            'SMS' => 'Secretária Municipal de Sáude',
            'SMED' => 'Secretária Municipal de Educação',
       
        );

        foreach ($orgaos as $sigla => $nome) {
            DB::table('orgao')->insert([
                'nome' => $nome,
                'sigla' => $sigla,
                'uuid' => \Str::orderedUuid(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
