@extends('layouts.auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')

<div class="login__page">
    <div class="login__page-title">
        <h1>ログイン画面</h1>
    </div>

    <form action="{{ route('login') }}" method="post" novalidate>
        @csrf
        <div class="register_main">

            <div class="error_message">
                @error('email')
                    @if ($message === 'ログイン情報が登録されていません')
                        {{ $message }}
                    @endif
                @enderror
            </div>

            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
            <div class="error_message">
                @error('email')
                    @if($message !== 'ログイン情報が登録されていません')
                        {{  $message }}
                    @endif
                @enderror
            </div>

            <label>パスワード</label>
            <input type="password" name="password" value="{{ old('password') }}">

            <div class="error_message">
                @error('password')
                    {{ $message }}
                @enderror
            </div>

            <div class="login__button">
                <button type="submit">ログインする</button>
            </div>
        </div>
    </form>
    <a href="{{ route('register') }}">会員登録はこちら</a>
    </div>

@endsection