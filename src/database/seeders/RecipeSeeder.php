<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Recipe;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        Recipe::create([
            'user_id' => $user->id,
            'title' => 'カレー',
            'recipe_text' => '玉ねぎ2個・トマト1個・牛乳200ml・鶏もも肉',
            'ingredients' => '玉ねぎ2個とトマト2個でできるカレー',
            'image_path' => null,
        ]);

        Recipe::create([
            'user_id' => $user->id,
            'title' => 'まぜご飯',
            'recipe_text' => '鶏もも肉・しめじ・油揚げ・ごぼう',
            'ingredients' => '簡単な混ぜご飯のレシピ',
            'image_path' => null,
        ]);
    }
}
