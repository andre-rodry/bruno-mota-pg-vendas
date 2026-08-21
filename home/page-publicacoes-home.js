/**
 * page-publicacoes-home.js
 * Carrossel da seção "Publicações e Artigos" (home).
 *
 * - Funciona para .livros-carousel e .artigos-carousel (qualquer elemento com [data-carousel]).
 * - Livros tem data-autoplay="4000" no HTML -> passa sozinho a cada 4s.
 * - Pausa o autoplay quando o mouse está em cima, e retoma quando sai.
 * - Pontinhos (.dot) navegam manualmente e resetam o timer do autoplay.
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('[data-carousel]').forEach(initCarousel);
	});

	function initCarousel(wrapper) {
		var name  = wrapper.getAttribute('data-carousel');
		var track = wrapper.querySelector('.carousel-track');
		var dots  = Array.prototype.slice.call(
			document.querySelectorAll('[data-dots="' + name + '"] .dot')
		);

		if (!track || !track.children.length) {
			return;
		}

		var autoplayDelay = parseInt(wrapper.getAttribute('data-autoplay'), 10) || 0;
		var autoplayTimer = null;
		var isHovering    = false;

		function itemsPerView() {
			if (window.innerWidth < 782) {
				return 1;
			}
			return name === 'artigos' ? 3 : 1;
		}

		function totalPages() {
			return Math.max(1, Math.ceil(track.children.length / itemsPerView()));
		}

		function currentPage() {
			var cardWidth = track.children[0].offsetWidth + gapSize();
			var pageWidth = cardWidth * itemsPerView();
			return pageWidth ? Math.round(track.scrollLeft / pageWidth) : 0;
		}

		function gapSize() {
			var styles = window.getComputedStyle(track);
			return parseInt(styles.columnGap || styles.gap || '20', 10) || 20;
		}

		function goToPage(pageIndex) {
			var pages = totalPages();
			var page  = ((pageIndex % pages) + pages) % pages; // wrap around
			var index = page * itemsPerView();
			var card  = track.children[index];

			if (card) {
				track.scrollTo({ left: card.offsetLeft - track.offsetLeft, behavior: 'smooth' });
			}
			updateDots(page);
		}

		function updateDots(activePage) {
			dots.forEach(function (dot, i) {
				dot.classList.toggle('is-active', i === activePage);
			});
		}

		function nextPage() {
			goToPage(currentPage() + 1);
		}

		function startAutoplay() {
			if (!autoplayDelay || isHovering) {
				return;
			}
			stopAutoplay();
			autoplayTimer = window.setInterval(nextPage, autoplayDelay);
		}

		function stopAutoplay() {
			if (autoplayTimer) {
				window.clearInterval(autoplayTimer);
				autoplayTimer = null;
			}
		}

		// Clique nos pontinhos.
		dots.forEach(function (dot) {
			dot.addEventListener('click', function () {
				var index = parseInt(dot.getAttribute('data-index'), 10) || 0;
				goToPage(index);
				startAutoplay(); // reinicia contagem após clique manual
			});
		});

		// Atualiza pontinho ativo quando o usuário arrasta/rola manualmente.
		var scrollTimeout;
		track.addEventListener('scroll', function () {
			window.clearTimeout(scrollTimeout);
			scrollTimeout = window.setTimeout(function () {
				updateDots(currentPage());
			}, 100);
		});

		// Pausa autoplay no hover (desktop) e no touch (mobile).
		wrapper.addEventListener('mouseenter', function () {
			isHovering = true;
			stopAutoplay();
		});
		wrapper.addEventListener('mouseleave', function () {
			isHovering = false;
			startAutoplay();
		});
		wrapper.addEventListener('touchstart', stopAutoplay, { passive: true });
		wrapper.addEventListener('touchend', startAutoplay, { passive: true });

		// Recalcula ao redimensionar a janela.
		window.addEventListener('resize', function () {
			updateDots(currentPage());
		});

		startAutoplay();
	}
})();