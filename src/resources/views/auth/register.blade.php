<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/register.css')}}">
    <title>register page</title>
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <h2>Atte</h2>
        </div>
    </header>

    <main>
        <div class="register__page">
            <form class="form" action="/register" method="post">
                @csrf
                <div class="form__title">
                    <h3>会員登録</h3>
                </div>
                <div class="form__content">
                    <div class="form__content-item">
                        <input class="form__text" type="text" name="name" value="{{old('name')}}" placeholder="名前">
                    </div>
                    <div class="form__content-item">
                        <input class="form__text" type="email" name="email" value="{{old('email')}}" placeholder="メールアドレス">
                    </div>
                    <div class="form__content-item">
                        <input class="form__text" type="password" name="password" placeholder="パスワード">
                    </div>
                    <div class="form__content-item">
                        <input class="form__text" type="password" name="password_confirmation" placeholder="確認用パスワード">
                    </div>
                    <div class="form__content-item">
                        <button class="form__button" type="submit">会員登録</button>
                    </div>
                    <div class="login">
                        <p class="login__detail">
                            アカウントをお持ちの方はこちらから
                        </p>
                        <a class="login__link" href="/login">ログイン</a>
                    </div>
            </form>
        </div>
        <div class="copyright">
            <small class="atte__copyright">Atte,inc.</small>
        </div>
    </main>
</body>
</html>