<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8"> <!-- ページの文字コード設定 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- スマホ対応 -->
    <title>Board Game Cafe</title> <!-- タイトル -->

    <!-- 外部CSS読み込み -->
    <link rel="stylesheet" href="style/home.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- ヘッダーエリア -->
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <!-- ロゴ画像。失敗時はテキストへ切替 -->
                <img src="images/logo.png" alt="Logo" class="logo-img"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                <div class="logo-text" style="display:none;">🎲 ホーム</div>
            </div>

            <!-- ナビゲーションメニュー -->
            <nav class="nav">
                <a href="game.php" class="nav-link">ゲーム</a>
                <a href="reserve.php" class="nav-link">貸出予約</a>
            </nav>

            <!-- ログインボタン -->
            <!-- TODO: ログイン済み => ユーザー名表示 -->
            <a href="login.php" class="login-btn">ログイン</a> 
        </div>
    </header>

    <main>
        <!-- メインのヒーローセクション -->
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">ボードゲームカフェOPEN</h1>

                <!-- 上に重なる統計情報カード -->
                <div class="hero-stats-overlay">
                    <div class="hero-stat-card rotate-left">
                        <span class="stat-number">50</span> <!-- ゲーム数 -->
                        <span class="stat-label">貸出可能なゲーム</span>
                    </div>

                    <a href="#" class="cta-button">ゲーム一覧を見る</a> <!-- CTAボタン -->

                    <div class="hero-stat-card rotate-right">
                        <span class="stat-number">5</span> <!-- 予約数 -->
                        <span class="stat-label">予約数</span>
                    </div>

                    <div class="hero-stat-card rotate-right-2">
                        <span class="stat-number">30</span> <!-- レビュー数 -->
                        <span class="stat-label">レビュー数</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 下部に改めて統計を並べたセクション -->
        <section class="stats-section">
            <div class="container stats-grid">
                <div class="stat-box">
                    <p class="stat-box-label">貸出可能なゲーム</p>
                    <p class="stat-box-number">50</p>
                </div>
                <div class="stat-box">
                    <p class="stat-box-label">予約数</p>
                    <p class="stat-box-number">5</p>
                </div>
                <div class="stat-box">
                    <p class="stat-box-label">レビュー数</p>
                    <p class="stat-box-number">30</p>
                </div>
            </div>
        </section>

        <!-- 新着ゲーム表示 -->
        <section class="new-games">
            <div class="container">
                <h2 class="section-title">新着ゲーム</h2>

                <!-- ゲーム画像4つ。エラー時はプレースホルダー -->
                <div class="games-grid">
                    <div class="game-card"><img src="images/game-1.png" alt="Game 1"
                            onerror="this.src='https://placehold.co/300x200?text=Game+1'"></div>
                    <div class="game-card"><img src="images/game-2.png" alt="Game 2"
                            onerror="this.src='https://placehold.co/300x200?text=Game+2'"></div>
                    <div class="game-card"><img src="images/game-3.png" alt="Game 3"
                            onerror="this.src='https://placehold.co/300x200?text=Game+3'"></div>
                    <div class="game-card"><img src="images/game-4.png" alt="Game 4"
                            onerror="this.src='https://placehold.co/300x200?text=Game+4'"></div>
                </div>

                <!-- もっと見るボタン -->
                <div class="more-btn-container">
                    <button class="more-btn">もっと見る</button>
                </div>
            </div>
        </section>

        <!-- お知らせセクション -->
        <section class="news">
            <div class="container">
                <h2 class="section-title">お知らせ</h2>

                <!-- 最初のお知らせ -->
                <div class="news-item">
                    <span class="news-date">2024年4月1日</span>
                    <span class="news-content">ウェブサイトを開設しました。</span>
                </div>
            </div>
        </section>
    </main>

    <!-- フッター -->
    <footer class="footer">
        <div class="container footer-container">
            <div class="footer-left">
                <p class="footer-label">住所</p>
            </div>
            <div class="footer-right">
                <p>住所：東京都新宿区新宿 1-1-1</p> <!-- 店舗住所 -->
                <p>営業時間：10:00〜20:00</p> <!-- 営業時間 -->
            </div>
        </div>
    </footer>

    <!-- JavaScript読み込み -->
    <script src="script/app.js"></script>
</body>

</html>