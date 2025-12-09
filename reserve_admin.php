<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約管理 - Board Game Cafe</title>
    <link rel="stylesheet" href="style/home.css">
    <link rel="stylesheet" href="style/reserve_admin.css"> <!-- 新規CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <img src="images/logo.png" alt="Logo" class="logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                <div class="logo-text" style="display:none;">管理画面</div>
            </div>
            <nav class="nav">
                <a href="home.php" class="nav-link">ホームに戻る</a>
            </nav>
        </div>
    </header>

    <main class="admin-main">
        <div class="container">
            <h1 class="page-title">予約管理</h1>

            <!-- フィルター -->
            <div class="filter-section">
                <div class="filter-group">
                    <label for="filter-month">年月</label>
                    <input type="month" id="filter-month" onchange="filterReservations()">
                </div>
                <div class="filter-group">
                    <label for="filter-game">ゲーム</label>
                    <select id="filter-game" onchange="filterReservations()">
                        <option value="">すべて</option>
                        <option value="catan">カタン</option>
                        <option value="dominion">ドミニオン</option>
                        <option value="carcassonne">カルカソンヌ</option>
                        <option value="pandemic">パンデミック</option>
                    </select>
                </div>
            </div>

            <!-- 予約リストテーブル -->
            <div class="reservation-list-container">
                <table class="reservation-table">
                    <thead>
                        <tr>
                            <th>日付</th>
                            <th>時間</th>
                            <th>予約者名</th>
                            <th>人数</th>
                            <th>ゲーム</th>
                            <th>ステータス</th>
                        </tr>
                    </thead>
                    <tbody id="reservation-list">
                        <!-- モックデータ -->
                        <tr data-date="2024-05-01" data-game="catan">
                            <td>2024/05/01</td>
                            <td>13:00</td>
                            <td>山田 太郎</td>
                            <td>4</td>
                            <td>カタン</td>
                            <td><span class="status status-confirmed">確定</span></td>
                        </tr>
                        <tr data-date="2024-05-03" data-game="dominion">
                            <td>2024/05/03</td>
                            <td>15:00</td>
                            <td>鈴木 一郎</td>
                            <td>2</td>
                            <td>ドミニオン</td>
                            <td><span class="status status-pending">未確定</span></td>
                        </tr>
                        <tr data-date="2024-04-28" data-game="carcassonne">
                            <td>2024/04/28</td>
                            <td>10:00</td>
                            <td>田中 美咲</td>
                            <td>3</td>
                            <td>カルカソンヌ</td>
                            <td><span class="status status-finished">完了</span></td>
                        </tr>
                        <tr data-date="2024-05-10" data-game="catan">
                            <td>2024/05/10</td>
                            <td>18:00</td>
                            <td>高橋 健太</td>
                            <td>4</td>
                            <td>カタン</td>
                            <td><span class="status status-confirmed">確定</span></td>
                        </tr>
                    </tbody>
                </table>
                <p id="no-result-message" style="display:none; text-align:center; margin-top:20px;">条件に一致する予約はありません。</p>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container footer-container">
            <p class="copyright">&copy; 2024 Board Game Cafe Admin</p>
        </div>
    </footer>

    <script>
        // 初期化: 今月をセット
        window.addEventListener('DOMContentLoaded', () => {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            document.getElementById('filter-month').value = `${yyyy}-${mm}`;
            
            // 初回フィルタリング（任意だが、全件表示したい場合はmonthの値をemptyにするか、ロジック調整）
            // ここでは一旦フィルタリングせずに、デフォルトで何か表示するか、
            // もしくはリスト側の日付に合わせてフィルタリングするか。
            // ユーザー要望的に「一覧表示のみで大丈夫」かつ「フィルターをかけられる」なので、
            // 最初は全件または直近が表示されている方が親切かも。
            // 今回はモックデータが少ないので、とりあえずフィルタ関数を呼んで、初期値（今月）で絞る挙動にする。
            // モックデータの日付が5月メインなので、5月にセットしてみるデモ用ロジック。
            document.getElementById('filter-month').value = "2024-05";
            filterReservations();
        });

        function filterReservations() {
            const monthVal = document.getElementById('filter-month').value; // YYYY-MM
            const gameVal = document.getElementById('filter-game').value;

            const rows = document.querySelectorAll('#reservation-list tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const dateStr = row.getAttribute('data-date'); // YYYY-MM-DD
                const gameStr = row.getAttribute('data-game');

                // 年月チェック
                let matchMonth = true;
                if (monthVal) {
                    if (!dateStr.startsWith(monthVal)) {
                        matchMonth = false;
                    }
                }

                // ゲームチェック
                let matchGame = true;
                if (gameVal) {
                    if (gameStr !== gameVal) {
                        matchGame = false;
                    }
                }

                if (matchMonth && matchGame) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const msg = document.getElementById('no-result-message');
            if (visibleCount === 0) {
                msg.style.display = 'block';
            } else {
                msg.style.display = 'none';
            }
        }
    </script>
</body>
</html>
