<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Support\Facades\Hash;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'テスト用ユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        Recipe::create([
            'user_id' => $user->id,
            'title' => 'カレー',
            'recipe_text' => '玉ねぎは薄切り、にんじんとじゃがいもは一口大の乱切りにする。鍋に油を熱し、玉ねぎがしんなりするまで炒める。肉、にんじん、じゃがいもを加え、肉の色が変わるまでさらに炒める。水を加え、沸騰したらアクを取り、弱火〜中火で約15分（具材が柔らかくなるまで）煮込む。一旦火を止め、ルーを割り入れて溶かす。再び弱火で5分ほど、とろみがつくまで煮込んで完成！',
            'ingredients' => '玉ねぎ（中1個）、にんじん（1/2本）、じゃがいも（1個）',
            'image_path' => null,
        ]);

        Recipe::create([
            'user_id' => $user->id,
            'title' => 'まぜご飯',
            'recipe_text' => '全ての具材を5mm角程度の小さめに切る（ご飯と混ざりやすくするため）。小鍋に具材と調味料を全て入れ、水分が少なくなるまで弱火で煮る。炊き上がったご飯に、煮た具材を加えてさっくりと混ぜ合わせる。',
            'ingredients' => '油揚げ（1枚）、にんじん（1/3本）、しいたけ（2枚）',
            'image_path' => null,
        ]);
    }
}
