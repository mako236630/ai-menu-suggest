<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AI Recipe</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css')}}">
    @yield('css')
</head>
<body>
    <header>
        <div class="header__nav">
            <a href="{{ route('recipe.index'
            ) }}">home</a>
            <a href="{{ route('mypage.index') }}">mypage</a>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="logout__button" type="submit">logout</button>
            </form>
        </div>

        <main class="main">
            @yield('content')
            </main>
    </header>
    
</body>
</html>