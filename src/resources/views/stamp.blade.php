<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/stamp.css')}}">
    <title>stamp page</title>
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <h2>Atte</h2>
        <nav class="header__nav">
            <ul class="nav__list">
                <li class="nav__list-item">
                    <a class="nav__list-item--link">ホーム</a>
                </li>
                <li class="nav__list-item">
                    <a class="nav__list-item--link">日付一覧</a>
                </li>
                <li class="nav__list-item">
                    <form action="/logout" method="post">
                        @csrf
                        <button class="nav__list-item--link---button" type="submit">ログアウト</button>
                    </form>
                </li>
            </ul>
        </nav>
        </div>
    </header>
    <main>
        <div class="stamp__page">
            <div class="user__name">
                <p class="user__name-good-job">{{Auth::user()->name}}さんお疲れ様です！</p>
            </div>
            <p class="message">{{session('message')}}</p>
                <div class="stamp__list">
                        <form class="stamp__list-attend" action="/attend" method="post">
                            @csrf
                            <button class="stamp__button" type="submit">
                            勤務開始
                            </button>
                        </form>
                    <form class="stamp__list-leave" action="/leave" method="post">
                        @csrf
                        <button class="stamp__button" type="submit">
                            勤務終了
                        </button>
                    </form>
                    <form class="stamp__list-breakin" action="/breakin" method="post">
                        @csrf
                        <button class="stamp__button" type="submit">
                            休憩開始
                        </button>
                    </form>
                    <form class="stamp__list-breakout" action="/breakout" method="post">
                        @csrf
                        <button class="stamp__button" type="submit">
                            休憩終了
                        </button>
                    </form>
                </div>
            <div class="copyright">
                <small class="atte__copyright">Atte,inc.</small>
            </div>
        </div>
    </main>