<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeCrudFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_レシピ保存がDBに登録され成功メッセージが出る(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('recipe.store'), [
            'recipe_text' => '料理名：テスト料理材料：卵, 塩作り方：焼く',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'レシピを保存しました！');

        $this->assertDatabaseHas('recipes', [
            'user_id' => $user->id,
            'title' => 'テスト料理',
        ]);
    }

    public function test_レシピ削除がDBから削除され成功メッセージが出る(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $recipe = Recipe::create([
            'user_id' => $user->id,
            'title' => '削除対象',
            'recipe_text' => '手順',
            'ingredients' => '材料',
            'image_path' => null,
        ]);

        $response = $this->actingAs($user)->delete(route('recipe.delete', $recipe));

        $response->assertRedirect();
        $response->assertSessionHas('message', 'レシピを削除しました');

        $this->assertDatabaseMissing('recipes', [
            'id' => $recipe->id,
        ]);
    }
}
