@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css')}}">
@endsection

@section('content')

<div class="register_page">
    <div class="register__page-title">
        <h1>会員登録画面</h1>
    </div>

    <form action="{{ route('register') }}" method="post" novalidate>
        @csrf
        <div class="register_main">

            <label>お名前</label>
            <input type="text" name="name" value="{{ old('name') }}">

            <div class="error_message">
                @error('name')
                    {{  $message }}
                @enderror
            </div>

            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">

            <div class="error_message">
                @error('email')
                    {{  $message }}
                @enderror
            </div>

            <label>パスワード</label>
            <input type="password" name="password" value="{{ old('password') }}">

            <div class="error_message">
                @error('password')
                    {{ $message }}
                @enderror
            </div>

            <label>確認用パスワード</label>
            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">

            <div class="error_message">
                @error('password_confirmation')
                    {{ $message }}
                @enderror
            </div>

            <div class="register__button">
                <button type="submit">会員登録する</button>
            </div>
        </div>
    </form>
    <a href="{{ route('login') }}">ログインはこちら</a>
</div>

@endsection
