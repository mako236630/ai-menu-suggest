@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/recipe/index.css')}}">
@endsection

@section('content')

    <div class="recipe__main">
        <div class="logo__image">
            <video autoplay muted loop playsinline class="logo-video">
                <source src="{{ asset('/images/AI-recipe.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <form action="{{ route('recipe.generate') }}" method="post">
            @csrf
            <p class="recipe__explanation">冷蔵庫にある材料や、使いたい材料を入力してください。</p>
            <input class="recipe__input" type="text" name="ingredients" value="{{ $ingredients ?? '' }}" placeholder="豚肉,キャベツ">
            <button class="recipe__button" type="submit">レシピを聞く</button>
        </form>

        @if(session('message'))
            <div class="flash__message">
                {{  session('message') }}
            </div>
        @endif

        @if(isset($recipe))
            @if($recipe === "冷蔵庫にある材料や、使いたい食材を入力してください！レシピをご提案します！")
                <p class="recipe__hint">{{ $recipe }}</p>
            @else
                <div class="recipe__result">
                    <h2 class="recipe__result-title">おすすめのレシピ</h2>

                    <div class="recipe__result-body">
                        {!! nl2br(e($recipe)) !!}
                    </div>
                </div>

                <form action="{{ route('recipe.store') }}" method="post">
                    @csrf
                    <textarea name="recipe_text" hidden readonly>{{ $recipe }}</textarea>
                    <div class="recipe__store-button">
                        <button class="recipe__button" type="submit">レシピを保存する</button>
                    </div>
                </form>
            @endif
        @endif
    </div>


@endsection