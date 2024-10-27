<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::truncate();
        //
        $data = [
            ['team_id' => 1, 'team_name' => '赤坂ドリブンズ', 'team_color' => 'b2d235',],
            ['team_id' => 2, 'team_name' => 'EX風林火山', 'team_color' => 'e60012',],
            ['team_id' => 3, 'team_name' => 'KADOKAWAサクラナイツ', 'team_color' => 'ef92ae',],
            ['team_id' => 4, 'team_name' => 'KOMAMI麻雀格闘倶楽部', 'team_color' => 'b60014',],
            ['team_id' => 5, 'team_name' => '渋谷ABEMAS', 'team_color' => 'bfa566',],
            ['team_id' => 6, 'team_name' => 'セガサミーフェニックス', 'team_color' => 'e14909',],
            ['team_id' => 7, 'team_name' => 'TEAM雷電', 'team_color' => 'fedf00',],
            ['team_id' => 8, 'team_name' => 'BEAST X', 'team_color' => '144324',],
            ['team_id' => 9, 'team_name' => 'U-NEXT Pirates', 'team_color' => '008fd0',],
        ];
        Team::insert($data);
    }
}
