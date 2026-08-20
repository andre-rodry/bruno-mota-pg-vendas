/**
 * Galeria de Momentos — Trajetória
 * Carrossel horizontal + Lightbox
 * -------------------------------------------------
 * Sem dependências externas (JS puro).
 */
(function () {
	"use strict";

	document.addEventListener("DOMContentLoaded", function () {
		var secao = document.getElementById("galeria-trajetoria");
		if (!secao) return;

		var track = secao.querySelector(".galeria-track");
		var itens = Array.prototype.slice.call(secao.querySelectorAll(".galeria-item"));
		var thumbs = Array.prototype.slice.call(secao.querySelectorAll(".galeria-thumb"));
		var btnPrev = secao.querySelector(".galeria-nav--prev");
		var btnNext = secao.querySelector(".galeria-nav--next");

		var lightbox = document.getElementById("galeria-lightbox");
		var lbImg = document.getElementById("galeria-lightbox-img");
		var lbTitulo = document.getElementById("galeria-lightbox-titulo");
		var lbDescricao = document.getElementById("galeria-lightbox-descricao");
		var lbAtual = document.getElementById("galeria-lightbox-atual");
		var lbMax = document.getElementById("galeria-lightbox-max");
		var lbPrev = lightbox ? lightbox.querySelector(".galeria-lightbox-nav--prev") : null;
		var lbNext = lightbox ? lightbox.querySelector(".galeria-lightbox-nav--next") : null;
		var lbFechar = lightbox ? lightbox.querySelectorAll("[data-galeria-fechar]") : [];

		var fotos = thumbs.map(function (thumb) {
			return {
				src: thumb.getAttribute("data-full"),
				alt: thumb.querySelector("img") ? thumb.querySelector("img").getAttribute("alt") : "",
				titulo: thumb.getAttribute("data-titulo") || "",
				descricao: thumb.getAttribute("data-descricao") || "",
			};
		});

		var indiceAtual = 0;

		/* ---------------- Carrossel ---------------- */

		function larguraDeAvanco() {
			if (!itens.length) return 0;
			var item = itens[0];
			var estilo = window.getComputedStyle(track);
			var gap = parseFloat(estilo.columnGap || estilo.gap || 0) || 0;
			return item.getBoundingClientRect().width + gap;
		}

		function atualizarEstadoBotoes() {
			if (!track) return;
			var inicio = track.scrollLeft <= 2;
			var fim = track.scrollLeft + track.clientWidth >= track.scrollWidth - 2;

			if (btnPrev) btnPrev.disabled = inicio;
			if (btnNext) btnNext.disabled = fim;
		}

		if (btnPrev) {
			btnPrev.addEventListener("click", function () {
				track.scrollBy({ left: -larguraDeAvanco(), behavior: "smooth" });
			});
		}

		if (btnNext) {
			btnNext.addEventListener("click", function () {
				track.scrollBy({ left: larguraDeAvanco(), behavior: "smooth" });
			});
		}

		if (track) {
			track.addEventListener("scroll", atualizarEstadoBotoes, { passive: true });
			window.addEventListener("resize", atualizarEstadoBotoes);
			atualizarEstadoBotoes();
		}

		/* ---------------- Lightbox ---------------- */

		function abrirLightbox(indice) {
			if (!lightbox || !fotos.length) return;
			indiceAtual = ((indice % fotos.length) + fotos.length) % fotos.length;
			renderizarLightbox();
			lightbox.classList.add("is-aberta");
			lightbox.setAttribute("aria-hidden", "false");
			document.body.style.overflow = "hidden";
		}

		function fecharLightbox() {
			if (!lightbox) return;
			lightbox.classList.remove("is-aberta");
			lightbox.setAttribute("aria-hidden", "true");
			document.body.style.overflow = "";
		}

		function renderizarLightbox() {
			var foto = fotos[indiceAtual];
			if (!foto || !lbImg) return;
			lbImg.src = foto.src;
			lbImg.alt = foto.alt || "";
			if (lbTitulo) lbTitulo.textContent = foto.titulo || "";
			if (lbDescricao) lbDescricao.textContent = foto.descricao || "";
			if (lbAtual) lbAtual.textContent = indiceAtual + 1;
			if (lbMax) lbMax.textContent = fotos.length;
		}

		function proximaFoto() {
			indiceAtual = (indiceAtual + 1) % fotos.length;
			renderizarLightbox();
		}

		function fotoAnterior() {
			indiceAtual = (indiceAtual - 1 + fotos.length) % fotos.length;
			renderizarLightbox();
		}

		thumbs.forEach(function (thumb, indice) {
			thumb.addEventListener("click", function () {
				abrirLightbox(indice);
			});
		});

		if (lbNext) lbNext.addEventListener("click", proximaFoto);
		if (lbPrev) lbPrev.addEventListener("click", fotoAnterior);

		lbFechar.forEach(function (el) {
			el.addEventListener("click", fecharLightbox);
		});

		document.addEventListener("keydown", function (evento) {
			if (!lightbox || !lightbox.classList.contains("is-aberta")) return;

			if (evento.key === "Escape") fecharLightbox();
			if (evento.key === "ArrowRight") proximaFoto();
			if (evento.key === "ArrowLeft") fotoAnterior();
		});
	});
})();