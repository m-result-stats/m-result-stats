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
            ['team_id' => 1, 'team_name' => '赤坂ドリブンズ', 'team_color' => '387d39',],
            ['team_id' => 2, 'team_name' => 'EX風林火山', 'team_color' => 'ae0000',],
            ['team_id' => 3, 'team_name' => 'KADOKAWAサクラナイツ', 'team_color' => 'c91e7f',],
            ['team_id' => 4, 'team_name' => 'KOMAMI麻雀格闘倶楽部', 'team_color' => 'ea0005',],
            ['team_id' => 5, 'team_name' => '渋谷ABEMAS', 'team_color' => 'a86400',],
            ['team_id' => 6, 'team_name' => 'セガサミーフェニックス', 'team_color' => 'e14909',],
            ['team_id' => 7, 'team_name' => 'TEAM雷電', 'team_color' => 'dd6700',],
            ['team_id' => 8, 'team_name' => 'BEASTX', 'team_color' => '004d25',],
            ['team_id' => 9, 'team_name' => 'U-NEXT Pirates', 'team_color' => '0e0280',],
        ];
        Team::insert($data);
    }
}
