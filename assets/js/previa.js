let pbTransitionTimeout1, pbTransitionTimeout2;
let pbCurrentSection = null;
let pbCurrentBlockIndex = 0;

document.addEventListener('DOMContentLoaded', function () {
    if (!window.pbPreviaOrder || !window.pbPreviaOrder.length) return;
    pbCurrentSection = window.pbPreviaOrder[0];

    // Preload every block image across every section
    window.pbPreviaOrder.forEach(function (key) {
        (window.pbPreviaData[key].blocks || []).forEach(function (block) {
            var preload = new Image();
            preload.src = block.img;
        });
    });
});

function pbSetSection(key, tabEl) {
    if (!window.pbPreviaData || !window.pbPreviaData[key]) return;
    var data = window.pbPreviaData[key];

    var tabs = document.querySelectorAll('#pb-service-tabs .service-tab');
    var index = window.pbPreviaOrder.indexOf(key);
    tabs.forEach(function (t) { t.classList.remove('active'); });
    tabEl.classList.add('active');

    var slider = document.getElementById('pb-tab-slider');
    var tabWidth = 100 / tabs.length;
    slider.style.left = (index * tabWidth) + '%';
    slider.style.width = tabWidth + '%';

    pbCurrentSection = key;
    pbCurrentBlockIndex = 0;

    document.getElementById('pb-main-title').textContent = data.label.toUpperCase();
    document.getElementById('pb-main-desc').textContent = data.desc;

    pbRenderBlocks(key);
    pbSwapImage(data.blocks[0].img);
}

function pbRenderBlocks(key) {
    var data = window.pbPreviaData[key];
    var group = document.getElementById('pb-block-group');
    group.innerHTML = '';

    data.blocks.forEach(function (block, i) {
        var div = document.createElement('div');
        div.className = 'block-thumb' + (i === 0 ? ' active' : '');
        div.onclick = function () { pbSetBlock(key, i, div); };

        var img = document.createElement('img');
        img.src = block.img;
        img.alt = block.name;
        img.loading = 'lazy';

        div.appendChild(img);
        group.appendChild(div);
    });
}

function pbSetBlock(key, index, thumbEl) {
    if (!window.pbPreviaData || !window.pbPreviaData[key]) return;
    var data = window.pbPreviaData[key];
    var block = data.blocks[index];
    if (!block) return;

    document.querySelectorAll('#pb-block-group .block-thumb').forEach(function (t) {
        t.classList.remove('active');
    });
    thumbEl.classList.add('active');

    pbCurrentSection = key;
    pbCurrentBlockIndex = index;

    pbSwapImage(block.img);
}

function pbSwapImage(url) {
    var img = document.getElementById('pb-main-view-img');
    if (img.src.indexOf(url) !== -1) return;

    clearTimeout(pbTransitionTimeout1);
    clearTimeout(pbTransitionTimeout2);

    img.classList.add('pb-transitioning');

    pbTransitionTimeout1 = setTimeout(function () {
        img.src = url;
        pbTransitionTimeout2 = setTimeout(function () {
            img.classList.remove('pb-transitioning');
        }, 80);
    }, 300);
}

function pbMoveBlock(direction) {
    if (!pbCurrentSection) return;
    var data = window.pbPreviaData[pbCurrentSection];
    var blocks = data.blocks;
    if (!blocks.length) return;

    var nextIndex = pbCurrentBlockIndex + direction;
    if (nextIndex >= blocks.length) nextIndex = 0;
    if (nextIndex < 0) nextIndex = blocks.length - 1;

    var thumbs = document.querySelectorAll('#pb-block-group .block-thumb');
    pbSetBlock(pbCurrentSection, nextIndex, thumbs[nextIndex]);
}

document.addEventListener('keydown', function (e) {
    var section = document.querySelector('.previa-bruno-section');
    if (!section) return;
    if (e.key === 'ArrowLeft') pbMoveBlock(-1);
    if (e.key === 'ArrowRight') pbMoveBlock(1);
});