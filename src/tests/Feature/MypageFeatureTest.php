<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MypageFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function onePixelPngBytes(): string
    {
        return base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/Pu3qWQAAAABJRU5ErkJggg=='
        );
    }

    public function test_マイページにログイン者が保存したレシピだけ表示される(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['name' => '太郎']);
        /** @var User $other */
        $other = User::factory()->create(['name' => '次郎']);

        Recipe::create([
            'user_id' => $user->id,
            'title' => '太郎のレシピ',
            'recipe_text' => '手順',
            'ingredients' => '材料',
            'image_path' => null,
        ]);
        Recipe::create([
            'user_id' => $other->id,
            'title' => '次郎のレシピ',
            'recipe_text' => '手順',
            'ingredients' => '材料',
            'image_path' => null,
        ]);

        $response = $this->actingAs($user)->get(route('mypage.index'));

        $response->assertOk();
        $response->assertSee('太郎 さんのマイページ');
        $response->assertSee('太郎のレシピ');
        $response->assertDontSee('次郎のレシピ');
    }

    public function test_マイページから画像投稿するとDBとストレージに保存される(): void
    {
        Storage::fake('public');

        /** @var User $user */
        $user = User::factory()->create();
        $recipe = Recipe::create([
            'user_id' => $user->id,
            'title' => 'テスト料理',
            'recipe_text' => '手順',
            'ingredients' => '材料',
            'image_path' => null,
        ]);

        $file = UploadedFile::fake()->createWithContent('dish.png', $this->onePixelPngBytes());

        $response = $this->actingAs($user)->post(route('recipe.upload', $recipe), [
            'recipe_image' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', '写真を投稿しました！');

        $recipe->refresh();
        $this->assertNotNull($recipe->image_path);
        $this->assertStringStartsWith('recipes/', $recipe->image_path);
        $this->assertTrue(Storage::disk('public')->exists($recipe->image_path));
    }

    public function test_マイページから削除できてDBから消える(): void
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
        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
    }
}
