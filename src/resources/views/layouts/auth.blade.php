<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AI Recipe</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/auth.css')}}">
    @yield('css')
</head>

<body>
    <header>
        <div class="header__nav">
            <h1>AI recipe</h1>
        </div>

        <main class="main">
            @yield('content')
        </main>
    </header>

</body>

</html>