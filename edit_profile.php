
<?php
require_once 'db_connect.php';  // DB接続
require_once __DIR__ . '/init.php';

$error = '';

// ユーザー情報取得
$stmt = $pdo->prepare('SELECT name, email, age FROM users WHERE id = :id');
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

// フォームが送信されたときだけ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // フォームから値を受け取る
    $nickname         = trim($_POST['nickname'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $age              = (int)($_POST['age'] ?? 0);

    // 1. 未入力チェック
    if ($nickname === '' || $email === '' || $age === 0) {
        $error = '未入力の項目があります。';
    } else {
        /*
        // 2. メールアドレス重複チェック
        $sql = 'SELECT id FROM users WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        */

        //if ($user) {
        //    $error = 'このメールアドレスは既に登録されています。';
        //} else {
            // 3. users テーブルを UPDATE
            //    nickname → DB の name カラムに入れているのがポイント
            $sql = 'UPDATE users SET name = :name, email = :email, age = :age WHERE id = :id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name', $nickname, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':age', $age, PDO::PARAM_INT);
            $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

            $stmt->execute();

            // 6. 変更完了 → マイページへ
            header('Location: mypage.php');
            exit;
        //}
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント情報変更 - Board Game Cafe</title>
    <link rel="stylesheet" href="style/register_style.css">
</head>

<body>
    <header>
        <a href="index.php"><h1>ボードゲームカフェ</h1></a>
    </header>
    <main>
        <h1>アカウント情報変更</h1>

<!-- エラーメッセージ表示 -->
<?php if ($error !== ''): ?>
    <p style="color:red;">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

        <div class="register_form">
            <form action="edit_profile.php" method="post">
                <p><label for="nickname">ニックネーム</label></p>
                <p><input type="text" name="nickname" id="nickname" value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>"></p>

                <p><label for="email">メールアドレス</label></p>
                <p><input type="text" name="email" id="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>"></p>

                <p><label for="age">年齢</label></p>
                <p><input type="number" name="age" id="age" value="<?= htmlspecialchars($user['age'], ENT_QUOTES, 'UTF-8') ?>" min="0" max="120"></p>

                <button type="submit">変更する</button>
            </form>
        </div>
    </main>
    <footer>
        <p>© 2025 ボードゲームカフェ</p>
    </footer>
</body>

</html>