@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user/mypage.css')}}">
@endsection

@section('content')

    <div class="mypage__main">
        <h1 class="mypage__page-title">{{ $name }} さんのマイページ</h1>

        <h2 class="mypage__section-title">保存したレシピ一覧</h2>

        @if(session('message'))
            <p class="mypage__flash">{{ session('message') }}</p>
        @endif

        <div class="mypage__list">
            @if($recipes->count() > 0)
                @foreach($recipes as $recipe)
                    <div class="mypage__card">
                        <h3 class="mypage__label">料理名</h3>
                        <p class="mypage__title-text">{{ $recipe->title }}</p>

                        <label class="mypage__preview" for="recipe_image_{{ $recipe->id }}">
                            <img class="mypage__preview-img {{ $recipe->image_path ? '' : 'mypage__preview-img--hidden' }}"
                                id="recipe_preview_{{ $recipe->id }}"
                                src="{{ $recipe->image_path ? asset('storage/' . $recipe->image_path) : '' }}" alt="プレビュー">
                            <span
                                class="mypage__preview-placeholder {{ $recipe->image_path ? 'mypage__preview-placeholder--hidden' : '' }}">クリックで写真を選べます</span>
                        </label>

                        <form class="mypage__form" action="{{ route('recipe.upload', $recipe) }}" method="post"
                            enctype="multipart/form-data" novalidate>
                            @csrf

                            @error('recipe_image', 'recipe_upload_'.$recipe->id)
                                <p class="mypage__error">{{ $message }}</p>
                            @enderror

                            <input class="mypage__file" id="recipe_image_{{ $recipe->id }}" type="file" name="recipe_image"
                                accept="image/*">
                            <div class="mypage__form-actions">
                                <button class="mypage__button" type="submit">作った写真を投稿！</button>
                            </div>
                        </form>

                        <h4 class="mypage__sub-label">材料</h4>
                        <div class="mypage__body-text">{!! nl2br(e($recipe->ingredients)) !!}</div>

                        <h4 class="mypage__sub-label">作り方</h4>
                        <div class="mypage__body-text">{!! nl2br(e($recipe->recipe_text)) !!}</div>

                        <form class="mypage__form mypage__form--delete" action="{{ route('recipe.delete', $recipe) }}" method="post"
                            onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button class="mypage__button mypage__button--delete" type="submit">削除する</button>
                        </form>
                    </div>
                @endforeach
            @else
                <p class="mypage__empty">まだレシピを保存していません。</p>
            @endif
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.mypage__file').forEach(function (input) {
                input.addEventListener('change', function () {
                    var file = input.files && input.files[0];
                    var card = input.closest('.mypage__card');
                    if (!card || !file || !file.type.match(/^image\//)) {
                        return;
                    }
                    var img = card.querySelector('.mypage__preview-img');
                    var placeholder = card.querySelector('.mypage__preview-placeholder');
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        img.src = e.target.result;
                        img.classList.remove('mypage__preview-img--hidden');
                        if (placeholder) {
                            placeholder.classList.add('mypage__preview-placeholder--hidden');
                        }
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>

@endsection