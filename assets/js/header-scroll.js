/* =========================================================
   header-scroll.js
   Mostra o header (.site-header) apenas depois que o usuário
   rola a página; no topo (scrollY = 0) ele fica escondido.
   ========================================================= */
document.addEventListener('DOMContentLoaded', function () {
	var header = document.querySelector('.site-header');
	if (!header) return;

	var SHOW_AFTER = 10; // px rolados até o header aparecer

	function onScroll() {
		if (window.scrollY > SHOW_AFTER) {
			header.classList.add('is-visible');
			header.classList.add('is-scrolled');
		} else {
			header.classList.remove('is-visible');
			header.classList.remove('is-scrolled');
		}
	}

	window.addEventListener('scroll', onScroll, { passive: true });
	onScroll(); // estado inicial correto, mesmo se a página carregar já rolada
});