<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use App\Models\User;

class RecipeController extends Controller
{
    public function index() {

        return view('recipe.index');
    }

    public function generate(Request $request) {

        $ingredients = $request->input('ingredients');
        $prompt = "以下の材料と、自宅によくある調味料で簡単に30分以内で作れるレシピを一つ教えてください。先頭に余計な挨拶を書かないで、1行目は必ず 料理名：で始め、その行には料理名以外を書かない。2行目は、材料：で始め、その行には調味料を含む材料以外を書かない。3行目は、作り方：で始め、作り方以外を書かない。で答えてください。材料が記載されていない場合：冷蔵庫にある材料や、使いたい食材を入力してください！レシピをご提案します！と言ってください。材料：{$ingredients}";

        $response = Gemini::generativeModel('gemini-2.5-flash')->generateContent($prompt);

        return view('recipe.index', [
            'recipe' => $response->text(),
            'ingredients' => $ingredients
        ]);

    }

    public function store(Request $request){

        $recipe_data = $request->input('recipe_text');

        // 本文の材料作り方の部分を●に変える(str_replace)
        $recipe_text = str_replace(['材料', '作り方'], '●', $recipe_data);

        // $recipe_textの●の部分で切り分ける(explode)
        $parts = explode('●', $recipe_text);

        // 0.タイトル 1.レシピ 2.材料
        $title = $parts[0] ?? 'タイトルなし';
        $ingredients = $parts[1] ?? '';
        $recipe_text = $parts[2] ?? '';

        Recipe::create([
            'user_id' => Auth::id(),
            'title' => str_replace(['料理名', '：', ':'], '', $title),
            'recipe_text' => str_replace(['：', ':'], '', $recipe_text),
            'ingredients' => str_replace(['：', ':'], '', $ingredients),
            'image_path' => null,
        ]);

        return redirect()->route('recipe.index')->with([
            'message' => 'レシピを保存しました！',
            'recipe' => $recipe_data,
            'ingredients' => $request->input('ingredients'),
    ]);
    }
}
