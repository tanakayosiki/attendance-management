<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/date.css')}}">
    <title>work date</title>
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <h2>Atte</h2>
        <nav class="header__nav">
            <ul class="nav__list">
                <li class="nav__list-item">
                        <a class="nav__list-item--link" href="/">ホーム</a>
                </li>
                <li class="nav__list-item">
                        <a class="nav__list-item--link" href="/date">日付一覧</a>
                </li>
                <li class="nav__list-item">
                    <form class="form" action="/logout" method="post">
                        @csrf
                        <button class="nav__list-item--link---button" type="submit">
                            ログアウト</button>
                    </form>
                </li>
            </ul>
        </nav>
        </div>
    </header>
    <main>
        <div class="work__date">
            <div class="date">
                <div class="date__list">
                    <form action="/date/prev" method="post">
                        @csrf
                        <button class="date__prev-button" type="submit"><</button>
                    </form>
                    <p class="date__content">
                        {{$ymd}}
                    </p>
                    <form action="/date/next" method="post">
                        @csrf
                        <button class="date__next-button" type="submit">></button>
                    </form>
                </div>
            </div>
            <table class="work__table">
                <tr class="work__table-row">
                    <th class="work__table-title">名前</th>
                    <th class="work__table-title">勤務時間</th>
                    <th class="work__table-title">勤務終了</th>
                    <th class="work__table-title">休憩時間</th>
                    <th class="work__table-title">勤務時間</th>
                </tr>
                @foreach($users as $user)
                <tr class="work__table-row">
                    <td class="work__table-content">{{$user['user']['name']}}</td>
                    <td class="work__table-content">{{$user->getAttend()}}</td>
                    <td class="work__table-content">{{$user->getLeave()}}</td>
                    <td class="work__table-content">{{$user['break_total']}}</td>
                    <td class="work__table-content">{{$user['work_time']}}</td>
                </tr>
                @endforeach
            </table>
            {{$users->links('vendor.pagination.mypagination')}}
        </div>
        <div class="copyright">
            <small class="atte__copyright">Atte,inc.</small>
        </div>
    </main>
</body>
</html>