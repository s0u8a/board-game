<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>
    <link rel="stylesheet" href="style/register_style.css">
</head>

<body>
    <header>
        <h1>ボードゲームカフェ</h1>
    </header>
    <main>
        <h1>会員登録</h1>
        <div class="register_form">
            <form action="#" method="post">
                <p><label>ニックネーム<br><input type="text"></label></p>
                <p><label>メールアドレス<br><input type="text"></label></p>
                <p><label>パスワード<br><input type="password"></label></p>
                <p><label>パスワード確認<br><input type="password"></label></p>
                <p><label>年齢<br><input type="number" value="18" min="0" max="120"></label></p>
                <button>会員登録</button>
            </form>
            <p>既に会員登録されている方はこちら</p>
            <p><a href="login.php">ログイン</a></p>
        </div>
    </main>
    <footer>
        <p>© 2025 ボードゲームカフェ</p>
    </footer>
</body>

</html>