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

            <!-- タブ切り替え -->
            <div class="tabs">
                <button class="tab-btn active" onclick="switchTab('future')">今後の予約</button>
                <button class="tab-btn" onclick="switchTab('past')">過去の予約</button>
            </div>

            <!-- フィルター (ゲームのみ) -->
            <div class="filter-section">
                <div class="filter-group">
                    <label for="filter-game">ゲームで絞り込み</label>
                    <select id="filter-game" onchange="renderReservations()">
                        <option value="">すべて</option>
                        <option value="カタン">カタン</option>
                        <option value="ドミニオン">ドミニオン</option>
                        <option value="カルカソンヌ">カルカソンヌ</option>
                        <option value="パンデミック">パンデミック</option>
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
                        </tr>
                    </thead>
                    <tbody id="reservation-list">
                        <!-- JSで描画 -->
                    </tbody>
                </table>
                <p id="no-result-message" style="display:none; text-align:center; margin-top:20px; padding: 20px;">表示する予約はありません。</p>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container footer-container">
            <p class="copyright">&copy; 2024 Board Game Cafe Admin</p>
        </div>
    </footer>

    <script>
        // モックデータ (日付はYYYY-MM-DD形式で管理)
        // 動作確認のため、現在日付前後のデータを適当に用意
        const todayStr = new Date().toISOString().split('T')[0];
        
        // 過去の日付生成用ヘルパー
        const addDays = (days) => {
            const d = new Date();
            d.setDate(d.getDate() + days);
            return d.toISOString().split('T')[0];
        };

        const mockReservations = [
            { date: addDays(0), time: '13:00', name: '山田 太郎', count: 4, game: 'カタン' },
            { date: addDays(0), time: '18:00', name: '高橋 健太', count: 4, game: 'カタン' },
            { date: addDays(2), time: '15:00', name: '鈴木 一郎', count: 2, game: 'ドミニオン' },
            { date: addDays(5), time: '10:00', name: '佐藤 花子', count: 6, game: 'パンデミック' },
            { date: addDays(-1), time: '14:00', name: '田中 美咲', count: 3, game: 'カルカソンヌ' },
            { date: addDays(-5), time: '19:00', name: '伊藤 博文', count: 5, game: 'カタン' },
            { date: addDays(-10), time: '12:00', name: '渡辺 徹', count: 2, game: 'ドミニオン' }
        ];

        let currentTab = 'future'; // 'future' or 'past'

        function switchTab(tabName) {
            currentTab = tabName;
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            // クリックされたボタンにactiveをつける (テキスト内容で判定するか、引数で渡すか。今回は簡易的にindexやeventから判定もできるが、明示的にクラス操作する)
            // event.targetが使えない呼び出しもあるため、tabNameで判定してDOM取得推奨だが、今回はonclick="switchTab"なのでevent.targetでOK
            if(event) event.target.classList.add('active');

            renderReservations();
        }

        function renderReservations() {
            const gameFilter = document.getElementById('filter-game').value;
            const listBody = document.getElementById('reservation-list');
            const noMsg = document.getElementById('no-result-message');
            listBody.innerHTML = '';

            // 今日の日付 (YYYY-MM-DD)
            const today = new Date().toISOString().split('T')[0];

            // データの振り分け
            let filtered = mockReservations.filter(r => {
                // ゲームフィルタ
                if (gameFilter && r.game !== gameFilter) return false;
                
                // タブによる期間フィルタ
                if (currentTab === 'future') {
                    // 今日以降 (今日含む)
                    return r.date >= today;
                } else {
                    // 昨日以前
                    return r.date < today;
                }
            });

            // ソート
            // 今後の予約: 日付が近い順 (昇順)
            // 過去の予約: 日付が近い順 (降順 = 新しい順)
            filtered.sort((a, b) => {
                if (currentTab === 'future') {
                    if (a.date === b.date) return a.time.localeCompare(b.time); // 同日は時間順
                    return a.date.localeCompare(b.date);
                } else {
                    if (a.date === b.date) return b.time.localeCompare(a.time); // 同日は時間遅い順(任意)
                    return b.date.localeCompare(a.date);
                }
            });

            if (filtered.length === 0) {
                noMsg.style.display = 'block';
            } else {
                noMsg.style.display = 'none';
                filtered.forEach(r => {
                    const tr = document.createElement('tr');
                    
                    // 日付表示生成
                    let dateDisplay = r.date.replace(/-/g, '/'); // YYYY/MM/DD
                    if (r.date === today) {
                        dateDisplay += ' <span class="badge-today">今日</span>';
                    }

                    tr.innerHTML = `
                        <td>${dateDisplay}</td>
                        <td>${r.time}</td>
                        <td>${r.name}</td>
                        <td>${r.count}名</td>
                        <td>${r.game}</td>
                    `;
                    listBody.appendChild(tr);
                });
            }
        }

        // 初期表示
        window.addEventListener('DOMContentLoaded', () => {
            renderReservations();
        });
    </script>
</body>
</html>
