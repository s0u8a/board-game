document.addEventListener('DOMContentLoaded', () => {
    const text = {
        notFound: '\u30b2\u30fc\u30e0\u304c\u898b\u3064\u304b\u308a\u307e\u305b\u3093\u3067\u3057\u305f',
        backToList: '\u30b2\u30fc\u30e0\u4e00\u89a7\u3078\u623b\u308b',
        statusAvailable: '\u8cb8\u51fa\u53ef\u80fd',
        labelGenre: '\u30b8\u30e3\u30f3\u30eb',
        labelPlayers: '\u30d7\u30ec\u30a4\u4eba\u6570',
        labelPlayTime: '\u30d7\u30ec\u30a4\u6642\u9593',
        labelDifficulty: '\u96e3\u6613\u5ea6',
        unitPeople: '\u4eba',
        suffixMore: '\u4ee5\u4e0a',
        suffixUntil: '\u307e\u3067',
    };

    const getGameIdFromUrl = () => {
        const params = new URLSearchParams(window.location.search);
        return parseInt(params.get('id'), 10);
    };

    const placeholderImage = 'https://placehold.co/300x300?text=No+Image';

    const normalizeImageList = (value) => {
        if (!value) return [];
        if (Array.isArray(value)) {
            return value
                .map((item) => String(item || '').trim())
                .filter(Boolean);
        }
        const raw = String(value).trim();
        if (!raw) return [];
        if (raw.startsWith('[')) {
            try {
                const parsed = JSON.parse(raw);
                if (Array.isArray(parsed)) {
                    return parsed
                        .map((item) => String(item || '').trim())
                        .filter(Boolean);
                }
            } catch (err) {
            }
        }
        return raw
            .split(/[\n,]+/)
            .map((item) => item.trim())
            .filter(Boolean);
    };

    const generateStars = (rating) => {
        const r = isNaN(rating) ? 0 : Number(rating);
        const fullStars = Math.floor(r);
        const hasHalf = r % 1 !== 0;
        const starFull = '\u2605';
        const starEmpty = '\u2606';
        let starsHtml = '';

        for (let i = 0; i < 5; i++) {
            if (i < fullStars) {
                starsHtml += starFull;
            } else if (i === fullStars && hasHalf) {
                starsHtml += starFull;
            } else {
                starsHtml += `<span style="color: #ddd;">${starEmpty}</span>`;
            }
        }
        starsHtml += `<span class="game-rating-value">${r.toFixed(1)}</span>`;
        return starsHtml;
    };

    const renderImageGallery = (title, rawImages) => {
        const imgEl = document.getElementById('details-img');
        const thumbsEl = document.getElementById('details-thumbs');
        if (!imgEl) return;

        const images = normalizeImageList(rawImages);
        const mainImage = images[0] || placeholderImage;
        imgEl.src = mainImage;
        imgEl.alt = title || 'Game image';

        if (!thumbsEl) return;

        thumbsEl.innerHTML = '';

        if (images.length <= 1) {
            thumbsEl.style.display = 'none';
            return;
        }

        thumbsEl.style.display = '';
        const buttons = [];

        const setActive = (index) => {
            buttons.forEach((button, buttonIndex) => {
                const isActive = buttonIndex === index;
                button.classList.toggle('active', isActive);
                button.setAttribute('aria-current', isActive ? 'true' : 'false');
            });
        };

        images.forEach((src, index) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'game-thumb-btn';
            button.setAttribute('aria-label', `${title || 'Game'} image ${index + 1}`);

            const thumb = document.createElement('img');
            thumb.src = src;
            thumb.alt = `${title || 'Game'} thumbnail ${index + 1}`;
            thumb.onerror = () => {
                thumb.src = placeholderImage;
                thumb.onerror = null;
            };

            button.appendChild(thumb);
            button.addEventListener('click', () => {
                imgEl.src = src;
                imgEl.alt = title || 'Game image';
                setActive(index);
            });

            thumbsEl.appendChild(button);
            buttons.push(button);
        });

        setActive(0);
    };

    const gameId = getGameIdFromUrl();
    if (!gameId) {
        showNotFound();
        return;
    }

    // Attach event listener immediately if button exists
    // Update reserve button link
    const reserveBtn = document.querySelector('.reserve-btn');
    if (reserveBtn) {
        reserveBtn.href = `reserve.php?game_id=${gameId}`;
    }

    async function loadGame() {
        try {
            const res = await fetch(`games_api.php?id=${gameId}`);
            const data = await res.json();
            if (!data.ok || !data.game) {
                throw new Error(data.error || text.notFound);
            }
            renderGame(data.game);
        } catch (err) {
            showNotFound(err.message);
        }
    }

    function renderGame(game) {
        document.title = `${game.title} - Board Game Cafe`;

        const titleEl = document.getElementById('details-title');
        const ratingEl = document.getElementById('details-rating');
        const statusEl = document.getElementById('details-status');
        const descEl = document.getElementById('details-desc');
        const metaListEl = document.getElementById('details-meta-list');

        // Removed reserveBtn logic from here as it is now at the top level

        if (titleEl) titleEl.textContent = game.title;
        renderImageGallery(game.title, game.image_urls || game.image_url);
        if (ratingEl) ratingEl.innerHTML = `<span class="stars">${generateStars(game.rating || 0)}</span>`;

        if (statusEl) {
            statusEl.textContent = text.statusAvailable;
            statusEl.style.color = '#28a745';
        }

        if (descEl) descEl.textContent = game.description || '';

        if (metaListEl) {
            let players = '';
            if (game.min_players && game.max_players) {
                players = `${game.min_players}-${game.max_players}${text.unitPeople}`;
            } else if (game.min_players) {
                players = `${game.min_players}${text.unitPeople}${text.suffixMore}`;
            } else if (game.max_players) {
                players = `${game.max_players}${text.unitPeople}${text.suffixUntil}`;
            }

            metaListEl.innerHTML = `
                <li>${text.labelGenre}: ${game.genre || ''}</li>
                <li>${text.labelPlayers}: ${players}</li>
                <li>${text.labelPlayTime}: ${game.play_time || ''}</li>
                <li>${text.labelDifficulty}: ${game.difficulty || ''}</li>
            `;
        }
    }

    function showNotFound(msg = text.notFound) {
        const container = document.querySelector('.game-details-card');
        if (container) {
            container.innerHTML = `<h2>${msg}</h2><a href="game.php">${text.backToList}</a>`;
        }
    }

    loadGame();
});
