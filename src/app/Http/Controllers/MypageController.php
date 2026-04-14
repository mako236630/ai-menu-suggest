<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecipeImageUploadRequest;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MypageController extends Controller
{
    public function index() {

        $userId = Auth::id();
        $name = Auth::user()->name;

        $recipes = Recipe::where('user_id', $userId)->get();

        return view('user.mypage', compact('recipes', 'name'));
    }

    public function uploadImage(RecipeImageUploadRequest $request, Recipe $recipe)
    {
        if ($request->hasFile('recipe_image')) {

            if ($recipe->image_path) {
                Storage::disk('public')->delete($recipe->image_path);
            }

            $path = $request->file('recipe_image')->store('recipes', 'public');

            $recipe->update([
                'image_path' => $path,
            ]);
        }

        return back()->with('message', '写真を投稿しました！');
    }

    public function delete(Request $request, Recipe $recipe) {

        $recipe->delete();

        return back()->with('message', 'レシピを削除しました');
    }
}
