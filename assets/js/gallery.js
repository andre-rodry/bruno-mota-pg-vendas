/**
 * Galeria de Momentos — Lightbox
 * Grade estática (sem animação de carrossel); a navegação acontece
 * apenas dentro do modal, via setas / teclado / swipe.
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', init);

	function init() {
		var lightbox = document.querySelector('[data-gallery-lightbox]');
		var triggers = Array.prototype.slice.call(document.querySelectorAll('[data-gallery-trigger]'));

		if (!lightbox || !triggers.length) return;

		var items = triggers.map(function (trigger) {
			return {
				full: trigger.getAttribute('data-full'),
				title: trigger.getAttribute('data-title') || '',
				desc: trigger.getAttribute('data-desc') || ''
			};
		});

		var stage = lightbox.querySelector('[data-gallery-stage]');
		var imageEl = lightbox.querySelector('[data-gallery-image]');
		var captionTitle = lightbox.querySelector('[data-gallery-caption-title]');
		var captionDesc = lightbox.querySelector('[data-gallery-caption-desc]');
		var counterEl = lightbox.querySelector('[data-gallery-counter]');
		var closeButtons = lightbox.querySelectorAll('[data-gallery-close]');
		var prevButton = lightbox.querySelector('[data-gallery-prev]');
		var nextButton = lightbox.querySelector('[data-gallery-next]');

		var currentIndex = 0;
		var lastFocusedEl = null;
		var isZoomed = false;
		var pan = { x: 0, y: 0 };
		var dragState = null;
		var pinchStartDist = null;
		var pinchStartScale = 1;

		var grid = document.querySelector('[data-gallery-grid]');
		var suppressClick = false;
		var gridPrevBtn = document.querySelector('[data-grid-prev]');
		var gridNextBtn = document.querySelector('[data-grid-next]');

		triggers.forEach(function (trigger, index) {
			trigger.addEventListener('click', function (e) {
				if (suppressClick) {
					e.preventDefault();
					suppressClick = false;
					return;
				}
				open(index);
			});
		});

		// --- Setas da fileira de miniaturas ---
		if (grid && gridPrevBtn && gridNextBtn) {
			var scrollStep = function () {
				var firstItem = grid.querySelector('.gallery-grid__item');
				var itemWidth = firstItem ? firstItem.getBoundingClientRect().width : 200;
				return itemWidth + 16; // largura do item + gap
			};

			var updateGridNavState = function () {
				var maxScroll = grid.scrollWidth - grid.clientWidth - 1;
				gridPrevBtn.disabled = grid.scrollLeft <= 0;
				gridNextBtn.disabled = grid.scrollLeft >= maxScroll;
			};

			gridPrevBtn.addEventListener('click', function () {
				grid.scrollBy({ left: -scrollStep() * 2, behavior: 'smooth' });
			});

			gridNextBtn.addEventListener('click', function () {
				grid.scrollBy({ left: scrollStep() * 2, behavior: 'smooth' });
			});

			grid.addEventListener('scroll', updateGridNavState);
			window.addEventListener('resize', updateGridNavState);
			updateGridNavState();
		}

		closeButtons.forEach(function (btn) {
			btn.addEventListener('click', close);
		});

		prevButton.addEventListener('click', function () { show(currentIndex - 1); });
		nextButton.addEventListener('click', function () { show(currentIndex + 1); });

		document.addEventListener('keydown', function (e) {
			if (!lightbox.classList.contains('is-open')) return;
			if (e.key === 'Escape') close();
			if (e.key === 'ArrowLeft') show(currentIndex - 1);
			if (e.key === 'ArrowRight') show(currentIndex + 1);
		});

		imageEl.addEventListener('click', function () {
			if (stageJustDragged) return;
			toggleZoom();
		});

		// --- Swipe (mobile) ---
		var touchStartX = 0;
		var touchStartY = 0;
		var touchDeltaX = 0;

		stage.addEventListener('touchstart', function (e) {
			if (e.touches.length === 2) {
				pinchStartDist = getTouchDistance(e.touches);
				pinchStartScale = isZoomed ? 2.2 : 1;
				return;
			}
			if (isZoomed) return;
			touchStartX = e.touches[0].clientX;
			touchStartY = e.touches[0].clientY;
			touchDeltaX = 0;
		}, { passive: true });

		stage.addEventListener('touchmove', function (e) {
			if (e.touches.length === 2 && pinchStartDist) {
				var dist = getTouchDistance(e.touches);
				var scale = pinchStartScale * (dist / pinchStartDist);
				scale = Math.min(Math.max(scale, 1), 3);
				setZoomVisual(scale);
				return;
			}
			if (isZoomed) return;
			touchDeltaX = e.touches[0].clientX - touchStartX;
		}, { passive: true });

		stage.addEventListener('touchend', function (e) {
			if (pinchStartDist) {
				var finalScale = parseFloat(imageEl.style.transform.replace(/[^0-9.]/g, '')) || 1;
				pinchStartDist = null;
				if (finalScale > 1.15) {
					applyZoom(true, Math.min(finalScale, 3));
				} else {
					applyZoom(false);
				}
				return;
			}
			if (isZoomed) return;
			if (Math.abs(touchDeltaX) > 60) {
				show(touchDeltaX < 0 ? currentIndex + 1 : currentIndex - 1);
			}
			touchDeltaX = 0;
		});

		// --- Arrastar com o mouse dentro do lightbox (desktop) para trocar de foto ---
		var stageDrag = null;
		var stageJustDragged = false;

		stage.addEventListener('mousedown', function (e) {
			if (isZoomed) return; // enquanto zoom estiver ativo, o arraste serve para mover a imagem (pan)
			stageDrag = { startX: e.clientX, moved: false };
			stage.classList.add('is-dragging');
			e.preventDefault();
		});

		window.addEventListener('mousemove', function (e) {
			if (!stageDrag) return;
			var delta = e.clientX - stageDrag.startX;
			if (Math.abs(delta) > 6) stageDrag.moved = true;
		});

		window.addEventListener('mouseup', function (e) {
			if (!stageDrag) return;
			var delta = e.clientX - stageDrag.startX;
			stage.classList.remove('is-dragging');
			if (stageDrag.moved) {
				stageJustDragged = true;
				setTimeout(function () { stageJustDragged = false; }, 0);
				if (Math.abs(delta) > 60) {
					show(delta < 0 ? currentIndex + 1 : currentIndex - 1);
				}
			}
			stageDrag = null;
		});

		// --- Pan while zoomed (mouse + touch) ---
		imageEl.addEventListener('pointerdown', function (e) {
			if (!isZoomed) return;
			dragState = {
				startX: e.clientX,
				startY: e.clientY,
				originX: pan.x,
				originY: pan.y
			};
			imageEl.setPointerCapture(e.pointerId);
		});

		imageEl.addEventListener('pointermove', function (e) {
			if (!dragState) return;
			pan.x = dragState.originX + (e.clientX - dragState.startX);
			pan.y = dragState.originY + (e.clientY - dragState.startY);
			applyPan();
		});

		['pointerup', 'pointercancel', 'pointerleave'].forEach(function (evt) {
			imageEl.addEventListener(evt, function () { dragState = null; });
		});

		function getTouchDistance(touches) {
			var dx = touches[0].clientX - touches[1].clientX;
			var dy = touches[0].clientY - touches[1].clientY;
			return Math.sqrt(dx * dx + dy * dy);
		}

		function open(index) {
			lastFocusedEl = document.activeElement;
			currentIndex = index;
			render(true);
			lightbox.setAttribute('aria-hidden', 'false');
			document.body.style.overflow = 'hidden';
			requestAnimationFrame(function () {
				lightbox.classList.add('is-open');
			});
		}

		function close() {
			lightbox.classList.remove('is-open');
			lightbox.setAttribute('aria-hidden', 'true');
			document.body.style.overflow = '';
			applyZoom(false);
			setTimeout(function () {
				imageEl.classList.remove('is-visible');
				if (lastFocusedEl) lastFocusedEl.focus();
			}, 260);
		}

		function show(index) {
			var total = items.length;
			currentIndex = ((index % total) + total) % total;
			applyZoom(false);
			// crossfade — sem deslocamento horizontal (sem efeito de carrossel)
			imageEl.classList.add('is-switching');
			setTimeout(function () {
				render(false);
			}, 160);
		}

		function render(isFirstOpen) {
			var item = items[currentIndex];
			imageEl.src = item.full;
			imageEl.alt = item.title;
			captionTitle.textContent = item.title;
			captionDesc.textContent = item.desc;
			counterEl.textContent = (currentIndex + 1) + ' / ' + items.length;

			imageEl.onload = function () {
				imageEl.classList.remove('is-switching');
				if (isFirstOpen) {
					requestAnimationFrame(function () {
						imageEl.classList.add('is-visible');
					});
				} else {
					imageEl.classList.add('is-visible');
				}
			};
		}

		function toggleZoom() {
			applyZoom(!isZoomed);
		}

		function applyZoom(state, scale) {
			isZoomed = state;
			pan = { x: 0, y: 0 };
			if (isZoomed) {
				imageEl.classList.add('is-zoomed');
				setZoomVisual(scale || 2.2);
			} else {
				imageEl.classList.remove('is-zoomed');
				imageEl.style.transform = 'scale(1) translate(0px, 0px)';
			}
		}

		function setZoomVisual(scale) {
			imageEl.style.transform = 'scale(' + scale + ') translate(' + pan.x + 'px, ' + pan.y + 'px)';
		}

		function applyPan() {
			var scale = isZoomed ? 2.2 : 1;
			imageEl.style.transform = 'scale(' + scale + ') translate(' + pan.x + 'px, ' + pan.y + 'px)';
		}
	}
})();