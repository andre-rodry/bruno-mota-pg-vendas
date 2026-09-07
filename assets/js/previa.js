let pbTransitionTimeout1, pbTransitionTimeout2;
let pbModalTransitionTimeout1, pbModalTransitionTimeout2;
let pbCurrentSection = null;
let pbCurrentBlockIndex = 0;

/* ---------- Estado do zoom no modal ---------- */
const PB_ZOOM_MIN = 1;
const PB_ZOOM_MAX = 4;
const PB_ZOOM_STEP = 0.5;

let pbZoom = 1;
let pbPanX = 0;
let pbPanY = 0;
let pbIsDragging = false;
let pbDragStartX = 0;
let pbDragStartY = 0;
let pbPanStartX = 0;
let pbPanStartY = 0;
let pbPinchStartDist = 0;
let pbPinchStartZoom = 1;

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

    pbSetupZoomEvents();
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

    var modal = document.getElementById('pb-modal');
    var modalOpen = modal && modal.classList.contains('active');

    if (modalOpen) {
        if (e.key === 'Escape') pbCloseModal();
        if (e.key === 'ArrowLeft' && pbZoom === 1) pbModalMove(-1);
        if (e.key === 'ArrowRight' && pbZoom === 1) pbModalMove(1);
        if (e.key === '+' || e.key === '=') pbZoomIn();
        if (e.key === '-') pbZoomOut();
        if (e.key === '0') pbResetZoom();
        return;
    }

    if (e.key === 'ArrowLeft') pbMoveBlock(-1);
    if (e.key === 'ArrowRight') pbMoveBlock(1);
});

/* ==========================================================================
   Modal (lightbox) + Zoom
   ========================================================================== */

function pbOpenModal() {
    if (!pbCurrentSection) return;
    var modal = document.getElementById('pb-modal');
    var modalImg = document.getElementById('pb-modal-img');
    var block = window.pbPreviaData[pbCurrentSection].blocks[pbCurrentBlockIndex];
    if (!block) return;

    modalImg.src = block.img;
    modalImg.alt = block.name;
    document.getElementById('pb-modal-caption').textContent = block.name;

    pbResetZoom();

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function pbCloseModal() {
    var modal = document.getElementById('pb-modal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
    pbResetZoom();
}

function pbModalBackdropClick(e) {
    if (e.target.id === 'pb-modal') pbCloseModal();
}

function pbModalMove(direction, e) {
    if (e) e.stopPropagation();
    if (pbZoom !== 1) return; // não navega enquanto estiver com zoom
    pbMoveBlock(direction);

    var block = window.pbPreviaData[pbCurrentSection].blocks[pbCurrentBlockIndex];
    var modalImg = document.getElementById('pb-modal-img');

    clearTimeout(pbModalTransitionTimeout1);
    clearTimeout(pbModalTransitionTimeout2);

    modalImg.classList.add('pb-transitioning');
    pbModalTransitionTimeout1 = setTimeout(function () {
        modalImg.src = block.img;
        document.getElementById('pb-modal-caption').textContent = block.name;
        pbModalTransitionTimeout2 = setTimeout(function () {
            modalImg.classList.remove('pb-transitioning');
        }, 50);
    }, 200);
}

/* ---------- Zoom / Pan ---------- */

function pbApplyTransform() {
    var img = document.getElementById('pb-modal-img');
    img.style.transform = 'translate(' + pbPanX + 'px, ' + pbPanY + 'px) scale(' + pbZoom + ')';

    var viewport = document.getElementById('pb-modal-viewport');
    viewport.classList.toggle('pb-zoomed', pbZoom > 1);

    var levelEl = document.getElementById('pb-zoom-level');
    if (levelEl) levelEl.textContent = Math.round(pbZoom * 100) + '%';
}

function pbClampPan() {
    var viewport = document.getElementById('pb-modal-viewport');
    var img = document.getElementById('pb-modal-img');
    if (!viewport || !img) return;

    var vw = viewport.clientWidth;
    var vh = viewport.clientHeight;
    var iw = img.clientWidth * pbZoom;
    var ih = img.clientHeight * pbZoom;

    var maxX = Math.max(0, (iw - vw) / 2);
    var maxY = Math.max(0, (ih - vh) / 2);

    // como transform-origin é 0 0, ajusta o centro manualmente
    var overflowX = Math.max(0, iw - vw);
    var overflowY = Math.max(0, ih - vh);

    var minPanX = -overflowX + (vw - img.clientWidth) / 2 * (pbZoom - 1) * 0;
    // Simplificado: limita para a imagem não "sumir" da viewport
    pbPanX = Math.min(Math.max(pbPanX, -(overflowX)), 0) + (vw - iw > 0 ? (vw - iw) / 2 : 0);
    pbPanY = Math.min(Math.max(pbPanY, -(overflowY)), 0) + (vh - ih > 0 ? (vh - ih) / 2 : 0);
}

function pbSetZoom(newZoom, centerX, centerY) {
    var viewport = document.getElementById('pb-modal-viewport');
    var img = document.getElementById('pb-modal-img');
    if (!viewport || !img) return;

    newZoom = Math.min(PB_ZOOM_MAX, Math.max(PB_ZOOM_MIN, newZoom));
    if (newZoom === pbZoom) return;

    var rect = viewport.getBoundingClientRect();
    var originX = centerX !== undefined ? centerX - rect.left : rect.width / 2;
    var originY = centerY !== undefined ? centerY - rect.top : rect.height / 2;

    // Ponto na imagem (antes do zoom) correspondente ao ponto do cursor
    var imgX = (originX - pbPanX) / pbZoom;
    var imgY = (originY - pbPanY) / pbZoom;

    pbZoom = newZoom;

    // Recalcula pan para manter o mesmo ponto da imagem sob o cursor
    pbPanX = originX - imgX * pbZoom;
    pbPanY = originY - imgY * pbZoom;

    if (pbZoom === 1) {
        pbPanX = 0;
        pbPanY = 0;
    } else {
        pbClampPanSimple();
    }

    pbApplyTransform();
}

function pbClampPanSimple() {
    var viewport = document.getElementById('pb-modal-viewport');
    var img = document.getElementById('pb-modal-img');
    if (!viewport || !img) return;

    var vw = viewport.clientWidth;
    var vh = viewport.clientHeight;
    var iw = img.clientWidth * pbZoom;
    var ih = img.clientHeight * pbZoom;

    if (iw <= vw) {
        pbPanX = (vw - iw) / 2;
    } else {
        var minX = vw - iw;
        pbPanX = Math.min(0, Math.max(minX, pbPanX));
    }

    if (ih <= vh) {
        pbPanY = (vh - ih) / 2;
    } else {
        var minY = vh - ih;
        pbPanY = Math.min(0, Math.max(minY, pbPanY));
    }
}

function pbZoomIn() {
    pbSetZoom(pbZoom + PB_ZOOM_STEP);
}

function pbZoomOut() {
    pbSetZoom(pbZoom - PB_ZOOM_STEP);
}

function pbResetZoom() {
    pbZoom = 1;
    pbPanX = 0;
    pbPanY = 0;
    pbApplyTransform();
}

function pbSetupZoomEvents() {
    var viewport = document.getElementById('pb-modal-viewport');
    var img = document.getElementById('pb-modal-img');
    if (!viewport || !img) return;

    // Clique simples: se já tem zoom, não faz nada (evita navegar sem querer);
    // sem zoom, clique simples não faz nada — usamos duplo clique para zoom.
    viewport.addEventListener('dblclick', function (e) {
        e.stopPropagation();
        if (pbZoom > 1) {
            pbResetZoom();
        } else {
            pbSetZoom(2.5, e.clientX, e.clientY);
        }
    });

    // Scroll do mouse = zoom
    viewport.addEventListener('wheel', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var delta = e.deltaY < 0 ? PB_ZOOM_STEP : -PB_ZOOM_STEP;
        pbSetZoom(pbZoom + delta, e.clientX, e.clientY);
    }, { passive: false });

    // Arrastar quando ampliado (mouse)
    viewport.addEventListener('mousedown', function (e) {
        if (pbZoom <= 1) return;
        e.preventDefault();
        pbIsDragging = true;
        pbDragStartX = e.clientX;
        pbDragStartY = e.clientY;
        pbPanStartX = pbPanX;
        pbPanStartY = pbPanY;
        viewport.classList.add('pb-dragging');
    });

    window.addEventListener('mousemove', function (e) {
        if (!pbIsDragging) return;
        pbPanX = pbPanStartX + (e.clientX - pbDragStartX);
        pbPanY = pbPanStartY + (e.clientY - pbDragStartY);
        pbClampPanSimple();
        pbApplyTransform();
    });

    window.addEventListener('mouseup', function () {
        if (!pbIsDragging) return;
        pbIsDragging = false;
        viewport.classList.remove('pb-dragging');
    });

    // Touch: arrastar com 1 dedo, pinça com 2 dedos
    viewport.addEventListener('touchstart', function (e) {
        if (e.touches.length === 1 && pbZoom > 1) {
            pbIsDragging = true;
            pbDragStartX = e.touches[0].clientX;
            pbDragStartY = e.touches[0].clientY;
            pbPanStartX = pbPanX;
            pbPanStartY = pbPanY;
        } else if (e.touches.length === 2) {
            pbIsDragging = false;
            pbPinchStartDist = pbGetTouchDist(e.touches);
            pbPinchStartZoom = pbZoom;
        }
    }, { passive: true });

    viewport.addEventListener('touchmove', function (e) {
        if (e.touches.length === 1 && pbIsDragging) {
            e.preventDefault();
            pbPanX = pbPanStartX + (e.touches[0].clientX - pbDragStartX);
            pbPanY = pbPanStartY + (e.touches[0].clientY - pbDragStartY);
            pbClampPanSimple();
            pbApplyTransform();
        } else if (e.touches.length === 2) {
            e.preventDefault();
            var dist = pbGetTouchDist(e.touches);
            var ratio = dist / pbPinchStartDist;
            var midX = (e.touches[0].clientX + e.touches[1].clientX) / 2;
            var midY = (e.touches[0].clientY + e.touches[1].clientY) / 2;
            pbSetZoom(pbPinchStartZoom * ratio, midX, midY);
        }
    }, { passive: false });

    viewport.addEventListener('touchend', function (e) {
        if (e.touches.length === 0) {
            pbIsDragging = false;
        }
    });
}

function pbGetTouchDist(touches) {
    var dx = touches[0].clientX - touches[1].clientX;
    var dy = touches[0].clientY - touches[1].clientY;
    return Math.sqrt(dx * dx + dy * dy);
}