<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RecipeImageUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        $recipe = $this->route('recipe');

        return $recipe && (int) $recipe->user_id === (int) $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'recipe_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'recipe_image.required' => '画像を選択してください。',
            'recipe_image.image' => '画像ファイルを選んでください。',
            'recipe_image.mimes' => 'jpg または png の画像にしてください。',
            'recipe_image.max' => '画像は2MB以下にしてください。',
        ];
    }

    /**
     * バリデーション失敗時：エラーを「レシピID付きの名前の箱」に入れる。
     * Blade 側は @error の第2引数で同じ名前を指定すると、そのカードだけ表示される。
     */
    protected function failedValidation(Validator $validator): void
    {
        $recipe = $this->route('recipe');
        $bagName = 'recipe_upload_'.$recipe->id;

        throw (new ValidationException($validator))
            ->errorBag($bagName);
    }
}
