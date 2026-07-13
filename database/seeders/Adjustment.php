<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Adjustment extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lists = ['Törés', 'Lopás', 'Korrekció'];
        foreach($lists as $list){
            DB::table('adjustment_types')->insert([
                'adjustment_type' => $list,
                'uuid' => Str::uuid()
            ]);
        }
        
    }
}
