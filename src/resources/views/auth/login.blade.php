<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <title>login page</title>
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <h2>Atte</h2>
        </div>
    </header>

    <main>
        <div class="login__page">
            <form class="form" action="/login" method="post">
                @csrf
                <div class="form__title">
                    <h3>ログイン</h3>
                </div>
                <div class="form__content">
                    <div class="form__content-item">
                        <input class="form__text" type="email" name="email" value="{{old('email')}}" placeholder="メールアドレス">
                        @error('email')
                        {{$errors->first('email')}}
                        @enderror
                    </div>
                    <div class="form__content-item">
                        <input class="form__text" type="password" name="password" placeholder="パスワード">
                        @error('password')
                        {{$errors->first('password')}}
                        @enderror
                    </div>
                    <div class="form__content-item">
                        <button class="form__button" type="submit">ログイン</button>
                    </div>
                    <div class="register">
                        <p class="register__detail">
                            アカウントをお持ちでない方はこちらから
                        </p>
                        <a class="register__link" href="/register">会員登録</a>
                    </div>
            </form>
        </div>
        <div class="copyright">
            <small class="atte__copyright">Atte,inc.</small>
        </div>
    </main>
</body>
</html>