<?php
require_once __DIR__ . '/init.php';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ご利用料金 - Board Game Cafe</title>
    <link rel="stylesheet" href="style/home.css">
    <link rel="stylesheet" href="style/price.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <a href="index.php"
                    style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <img src="images/logo.png" alt="Logo" class="logo-img"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                    <span class="logo-label">ホーム</span>
                </a>
            </div>
            <nav class="nav">
                <a href="game.php" class="nav-link">ゲーム</a>
                <a href="reserve.php" class="nav-link">貸し出し予約</a>
                <a href="price.php" class="nav-link active">ご利用料金</a>
                <?php if (isset($_SESSION['is_admin']) && (int) $_SESSION['is_admin'] === 1): ?>
                    <a href="game_admin.php" class="nav-link">管理(ゲーム)</a>
                    <a href="reserve_admin.php" class="nav-link">管理(予約)</a>
                    <a href="review_admin.php" class="nav-link">管理(レビュー)</a>
                <?php endif; ?>
            </nav>
            <?php
            if (isset($_SESSION['user_id'])) {
                $stmt = $pdo->prepare('SELECT name FROM users WHERE id = :id');
                $stmt->execute([':id' => $_SESSION['user_id']]);
                $user = $stmt->fetch();
                echo '<a href="mypage.php" class="login-btn">' . htmlspecialchars($user['name']) . ' さん</a>';
            } else {
                echo '<a href="login.php" class="login-btn">ログイン</a>';
            }
            ?>
        </div>
    </header>

    <main class="container price-container">
        <h1>ご利用料金</h1>

        <section class="price-section rules-section">
            <ul class="rules-list">
                <li>食べもの、お菓子のお持ち込みOKです（※飲みものはご遠慮ください）</li>
                <li>ボードゲームのお持ち込みOKです。</li>
                <li>全席禁煙です。</li>
            </ul>
        </section>

        <section class="price-section weekday-section">
            <h2>平日 ご利用料金（15:00～22:00）</h2>
            <table class="price-table">
                <tr>
                    <td>1時間</td>
                    <td>￥400</td>
                </tr>
                <tr>
                    <td>3時間パック</td>
                    <td>￥1,000</td>
                </tr>
                <tr>
                    <td>5時間パック</td>
                    <td>￥1,500</td>
                </tr>
                <tr>
                    <td>フリータイム</td>
                    <td>￥1,800</td>
                </tr>
                <tr>
                    <td>延長30分</td>
                    <td>￥200</td>
                </tr>
                <tr>
                    <td>平日限定 学生/U22 パック（4時間）</td>
                    <td>￥900</td>
                </tr>
            </table>
        </section>

        <section class="price-section weekend-section">
            <h2>土･日･祝日 ご利用料金（13:00～22:00）</h2>
            <table class="price-table">
                <tr>
                    <td>1時間</td>
                    <td>￥500</td>
                </tr>
                <tr>
                    <td>3時間パック</td>
                    <td>￥1,300</td>
                </tr>
                <tr>
                    <td>5時間パック</td>
                    <td>￥2,000</td>
                </tr>
                <tr>
                    <td>フリータイム</td>
                    <td>￥2,800</td>
                </tr>
                <tr>
                    <td>延長30分</td>
                    <td>￥250</td>
                </tr>
            </table>
        </section>

        <section class="price-section note-section">
            <p class="attention-text">※1ドリンクオーダー制です。ご入店時に、1ドリンクのご注文をお願いいたします。</p>
        </section>

        <section class="price-section discount-section">
            <div class="discount-item">
                <h3>学生/U22 割引</h3>
                <p>2時間以上ご利用の学生または22歳以下の方は、お会計時に学生証、免許証、保険証等（年齢が分かるもの）提示で ￥200 割引いたします。</p>
            </div>
            <div class="discount-item">
                <h3>イベント参加割引</h3>
                <p>マーダーミステリー、TRPG等のイベント参加の前後に延長利用される方は、1時間ごとに ￥100 割引いたします。</p>
            </div>
            <div class="discount-item">
                <h3>子ども料金</h3>
                <p>中学生、小学生、未就学児の方はご利用料金が半額となります。</p>
                <p class="small-note">※小学生以下は保護者同伴でお願いいたします。</p>
            </div>
        </section>

        <section class="price-section menu-section">
            <h2>メニュー</h2>

            <div class="menu-category">
                <h3>ドリンク</h3>
                <table class="menu-table">
                    <tr>
                        <td>コーヒー（HOT／ICE）</td>
                        <td>￥400</td>
                    </tr>
                    <tr>
                        <td>紅茶（HOT／ICE）</td>
                        <td>￥400</td>
                    </tr>
                    <tr>
                        <td>チャイ（HOT）</td>
                        <td>￥400</td>
                    </tr>
                    <tr>
                        <td>ハーブティー（HOT）</td>
                        <td>￥400</td>
                    </tr>
                    <tr>
                        <td>抹茶ラテ（HOT）</td>
                        <td>￥400</td>
                    </tr>
                    <tr>
                        <td>ソイカフェラテ（HOT／ICE）</td>
                        <td>￥450</td>
                    </tr>
                    <tr>
                        <td>コーヒーフロート（ICE）</td>
                        <td>￥450</td>
                    </tr>
                </table>
            </div>

            <div class="menu-category">
                <h3>ソフトドリンク</h3>
                <table class="menu-table">
                    <tr>
                        <td>コーラ</td>
                        <td>￥300</td>
                    </tr>
                    <tr>
                        <td>ジンジャーエール（マイルド／スパイシー）</td>
                        <td>￥300</td>
                    </tr>
                    <tr>
                        <td>オレンジジュース（果汁100％）</td>
                        <td>￥300</td>
                    </tr>
                    <tr>
                        <td>アップルジュース（果汁100％）</td>
                        <td>￥300</td>
                    </tr>
                    <tr>
                        <td>グレープフルーツジュース（果汁100％）</td>
                        <td>￥300</td>
                    </tr>
                    <tr>
                        <td>レモネード（HOT／ICE）</td>
                        <td>￥400</td>
                    </tr>
                    <tr>
                        <td>緑茶（HOT／ICE）</td>
                        <td>￥300</td>
                    </tr>
                    <tr>
                        <td>ウーロン茶（HOT／ICE）</td>
                        <td>￥300</td>
                    </tr>
                </table>
            </div>

            <div class="menu-category">
                <table class="menu-table simple-list">
                    <tr>
                        <td>フロート</td>
                        <td>＋￥100</td>
                    </tr>
                </table>
                <p class="small-note">※お好きなドリンクにバニラアイスをトッピングできます。</p>
            </div>

            <div class="menu-category">
                <h3>プレミアムビール（アルコール）</h3>
                <table class="menu-table">
                    <tr>
                        <td>バドワイザー</td>
                        <td>￥550</td>
                    </tr>
                    <tr>
                        <td>ハイネケン</td>
                        <td>￥600</td>
                    </tr>
                    <tr>
                        <td>コロナ･エキストラ</td>
                        <td>￥600</td>
                    </tr>
                </table>
            </div>

            <div class="menu-category">
                <h3>ノンアルコールビール</h3>
                <table class="menu-table">
                    <tr>
                        <td>ヴェリタスブロイ</td>
                        <td>￥400</td>
                    </tr>
                </table>
            </div>

            <div class="menu-category">
                <h3>アイスクリーム</h3>
                <table class="menu-table">
                    <tr>
                        <td>バニラ</td>
                        <td>￥200</td>
                    </tr>
                </table>
            </div>
        </section>

    </main>

    <footer class="footer">
        <div class="container footer-container">
            <div class="footer-left">
                <p class="footer-label">住所</p>
            </div>
            <div class="footer-right">
                <p>住所：東京都新宿区新宿 1-1-1</p>
                <p>営業時間：10:00〜20:00</p>
            </div>
        </div>
    </footer>
</body>

</html>