<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログイン画面に会員登録リンクが表示され指定ページに遷移できる(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertSee('会員登録はこちら');
        $response->assertSee('href="'.route('register').'"', false);
    }

    public function test_会員登録画面にログインリンクが表示され指定ページに遷移できる(): void
    {
        $response = $this->get(route('register'));

        $response->assertOk();
        $response->assertSee('ログインはこちら');
        $response->assertSee('href="'.route('login').'"', false);
    }

    public function test_ログイン画面で未入力だと指定の日本語バリデーションが出る(): void
    {
        $response = $this->from(route('login'))->post(route('login'), []);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
            'password' => 'パスワードを入力してください',
        ]);
    }

    public function test_ログイン情報が違うと指定のエラーメッセージが出る(): void
    {
        User::factory()->create([
            'email' => 'taro@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->from(route('login'))->post(route('login'), [
            'email' => 'taro@example.com',
            'password' => 'wrongwrong',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
        $this->assertGuest();
    }

    public function test_会員登録で未入力だと指定の日本語バリデーションが出る(): void
    {
        $response = $this->from(route('register'))->post(route('register'), []);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
            'email' => 'メールアドレスを入力してください',
            'password' => 'パスワードを入力してください',
            'password_confirmation' => '確認用パスワードを入力してください',
        ]);
    }

    public function test_会員登録に成功するとDBに保存されログイン状態になって指定ページへ遷移する(): void
    {
        $response = $this->post(route('register'), [
            'name' => '太郎',
            'email' => 'taro@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/recipe');
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'name' => '太郎',
            'email' => 'taro@example.com',
        ]);
    }
}
