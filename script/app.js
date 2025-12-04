document.addEventListener('DOMContentLoaded', () => {
    console.log('Board Game Cafe website loaded');

    // Simple interaction for the "More" button
    const moreBtn = document.querySelector('.more-btn');
    if (moreBtn) {
        moreBtn.addEventListener('click', () => {
            alert('もっと多くのゲームを表示する機能は現在開発中です。');
        });
    }

    // ページ内リンクのスムーススクロール処理
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            if (targetId) {
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});
