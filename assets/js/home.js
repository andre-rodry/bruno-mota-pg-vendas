/* =======================================================================
 * home.js
 * JS CONSOLIDADO de todas as seções da home (front-page.php):
 *   1. Banner       (animação de entrada, sem GSAP)
 *   2. Galeria       (lightbox de momentos)
 *   3. Mídia         (carrossel de participações — loop infinito sem clonar)
 *   4. Publicações   (artigos via REST API + carrossel de entrevistas)
 *
 * Os arquivos separados (banner.js, gallery.js, media.js, publications.js)
 * não existem mais no disco — cada bloco abaixo mantém seu próprio IIFE
 * original, então nada muda em termos de escopo/comportamento.
 * ======================================================================= */

/* ================================
 * 1) BANNER — animação de entrada
 * ================================ */
(function () {
  function boot() {
    var section = document.querySelector(".bml-home-banner");
    if (!section) return false;

    var title = section.querySelector('[data-gsap="title"]');
    var subtitle = section.querySelector('[data-gsap="subtitle"]');
    var buttons = section.querySelectorAll('[data-gsap="btn"]');
    var scroll = section.querySelector('[data-gsap="scroll"]');
    var socialLabel = section.querySelector(".bml-social-label");
    var socialIcons = section.querySelectorAll(".bml-social-icons a");

    function reveal(el, delay) {
      if (!el) return;
      setTimeout(function () {
        el.classList.add("bml-reveal");
      }, delay);
    }

    reveal(title, 0);
    reveal(subtitle, 150);

    buttons.forEach(function (btn, i) {
      reveal(btn, 300 + i * 100);
    });

    reveal(scroll, 500);
    reveal(socialLabel, 400);

    socialIcons.forEach(function (icon, i) {
      reveal(icon, 450 + i * 60);
    });

    return true;
  }

  // Fallback de segurança: se por algum motivo o JS falhar em
  // rodar a tempo, revela tudo depois de 2s sem animação, para
  // nunca deixar o conteúdo escondido.
  function fallbackReveal() {
    document.querySelectorAll(".bml-home-banner .bml-gsap-init").forEach(function (el) {
      el.classList.add("bml-reveal");
    });
  }

  function waitAndBoot() {
    boot();
    setTimeout(fallbackReveal, 2000);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", waitAndBoot);
  } else {
    waitAndBoot();
  }
})();

/* ================================
 * 2) GALERIA DE MOMENTOS — Lightbox
 * ================================ */
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

/* ================================================
 * 3) PARTICIPAÇÕES NA MÍDIA — loop infinito sem clonar
 * ================================================ */
(function () {
  function initMidiaCarousel(root) {
    var viewport = root.querySelector('.bml-midia-track-viewport');
    var track = root.querySelector('.bml-midia-track');
    var prevBtn = root.querySelector('.bml-midia-seta-prev');
    var nextBtn = root.querySelector('.bml-midia-seta-next');

    if (!track) return;

    var isAnimating = false;

    function getCards() {
      return Array.prototype.slice.call(track.children);
    }

    function getStep() {
      var cards = getCards();
      if (!cards.length) return 0;
      var cardRect = cards[0].getBoundingClientRect();
      var gap = parseFloat(getComputedStyle(track).gap) || 20;
      return cardRect.width + gap;
    }

    function setTransform(px, withTransition) {
      track.style.transition = withTransition ? '' : 'none';
      track.style.transform = 'translateX(' + px + 'px)';
      if (!withTransition) {
        track.getBoundingClientRect();
        track.style.transition = '';
      }
    }

    function goNext() {
      if (isAnimating) return;
      var step = getStep();
      if (!step) return;
      isAnimating = true;

      setTransform(-step, true);

      var onEnd = function (e) {
        if (e.propertyName !== 'transform') return;
        track.removeEventListener('transitionend', onEnd);

        var first = track.firstElementChild;
        track.appendChild(first);

        setTransform(0, false);
        isAnimating = false;
      };
      track.addEventListener('transitionend', onEnd);
    }

    function goPrev() {
      if (isAnimating) return;
      var step = getStep();
      if (!step) return;
      isAnimating = true;

      var last = track.lastElementChild;
      track.insertBefore(last, track.firstElementChild);
      setTransform(-step, false);

      requestAnimationFrame(function () {
        setTransform(0, true);
      });

      var onEnd = function (e) {
        if (e.propertyName !== 'transform') return;
        track.removeEventListener('transitionend', onEnd);
        isAnimating = false;
      };
      track.addEventListener('transitionend', onEnd);
    }

    // ===== Autoplay =====
    var AUTOPLAY_DELAY = 4000;
    var autoplayTimer = null;

    function startAutoplay() {
      stopAutoplay();
      autoplayTimer = setInterval(goNext, AUTOPLAY_DELAY);
    }

    function stopAutoplay() {
      if (autoplayTimer) {
        clearInterval(autoplayTimer);
        autoplayTimer = null;
      }
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', function () {
        goPrev();
        startAutoplay();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function () {
        goNext();
        startAutoplay();
      });
    }

    root.addEventListener('mouseenter', stopAutoplay);
    root.addEventListener('mouseleave', startAutoplay);

    // Swipe touch (mobile)
    var startX = 0;
    var isDragging = false;

    if (viewport) {
      viewport.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
        isDragging = true;
        stopAutoplay();
      }, { passive: true });

      viewport.addEventListener('touchend', function (e) {
        if (!isDragging) return;
        isDragging = false;
        var endX = e.changedTouches[0].clientX;
        var diff = startX - endX;

        if (Math.abs(diff) > 40) {
          if (diff > 0) {
            goNext();
          } else {
            goPrev();
          }
        }
        startAutoplay();
      });
    }

    window.addEventListener('resize', function () {
      if (!isAnimating) setTransform(0, false);
    });

    setTransform(0, false);
    startAutoplay();
  }

  function init() {
    var carousels = document.querySelectorAll('.bml-midia-carousel-wrapper');
    carousels.forEach(function (el) {
      initMidiaCarousel(el);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();

/* ==========================================
 * 4) PUBLICAÇÕES E ARTIGOS
 * ========================================== */
(function () {
  // URL da REST API do site atual, injetada pelo PHP via wp_localize_script.
  // IMPORTANTE: como banner/gallery/media/publications foram consolidados
  // em home.js, o wp_localize_script agora deve apontar para o handle
  // 'meu-tema-home' (não mais 'meu-tema-publications') no functions.php.
  const PUB_REST_BASE = (typeof publicationsData !== "undefined" && publicationsData.restUrl)
    ? publicationsData.restUrl
    : "/wp-json/wp/v2/"; // fallback, caso o script rode fora do WordPress

  const PUB_QUANTIDADE = 2;
  const PUB_CATEGORIA_SLUG = ""; // ex: "financas" para filtrar só uma categoria

  async function carregarArtigosPublications() {
    const container = document.getElementById("publications-artigos-list");
    if (!container) return;

    try {
      let categoryParam = "";
      if (PUB_CATEGORIA_SLUG) {
        const catRes = await fetch(`${PUB_REST_BASE}categories?slug=${PUB_CATEGORIA_SLUG}`);
        const cats = await catRes.json();
        if (cats.length > 0) categoryParam = `&categories=${cats[0].id}`;
      }

      const res = await fetch(
        `${PUB_REST_BASE}posts?per_page=${PUB_QUANTIDADE}&_embed${categoryParam}`
      );
      if (!res.ok) throw new Error(`Erro HTTP ${res.status}`);

      const posts = await res.json();
      if (!posts.length) {
        container.innerHTML = `<p class="publications-status">Nenhum artigo encontrado.</p>`;
        return;
      }

      container.innerHTML = posts.map(post => {
        const titulo = post.title.rendered;
        const link = post.link;
        const media = post._embedded?.["wp:featuredmedia"]?.[0];
        const imagem = media?.source_url || "";

        return `
          <div class="publications-artigo-item">
            ${imagem ? `<img class="publications-artigo-thumb" src="${imagem}" alt="">` : `<div class="publications-artigo-thumb"></div>`}
            <div class="publications-artigo-body">
              <h4>${titulo}</h4>
              <a class="publications-leia-mais" href="${link}" target="_blank" rel="noopener">Leia mais &rarr;</a>
            </div>
          </div>
        `;
      }).join("");

    } catch (err) {
      console.error(err);
      container.innerHTML = `<p class="publications-status publications-status--error">Não foi possível carregar os artigos (${err.message}). Verifique se a REST API do WordPress está acessível nesse domínio.</p>`;
    }
  }

  carregarArtigosPublications();

  /* =======================================================
     ENTREVISTAS E COLUNAS
     Conteúdo externo (não vem do WordPress). Edite este array
     com as entrevistas/colunas reais e os links de destino.
     ======================================================= */
  const PUB_ENTREVISTAS = [
    {
      logo: "https://placehold.co/120x120/eb1c24/ffffff?text=Outras",
      label: "Coluna semanal",
      titulo: "Outras Palavras",
      link: "#" // troque pelo link real da coluna
    },
    {
      logo: "https://placehold.co/120x120/c1272d/ffffff?text=RED",
      label: "Artigo publicado no portal RED",
      titulo: "Rede Brasil Atual",
      link: "#" // troque pelo link real do artigo
    },
    {
      logo: "https://placehold.co/120x120/16233d/ffffff?text=CBN",
      label: "Entrevista em rádio",
      titulo: "CBN Salvador",
      link: "#"
    },
    {
      logo: "https://placehold.co/120x120/22345a/ffffff?text=A+Tarde",
      label: "Artigo de opinião",
      titulo: "Jornal A Tarde",
      link: "#"
    },
    {
      logo: "https://placehold.co/120x120/22345a/ffffff?text=A+Tarde",
      label: "Artigo de opinião",
      titulo: "Jornal A Tarde",
      link: "#"
    }
  ];

  const PUB_ITENS_POR_PAGINA = 2;
  const PUB_INTERVALO_MS = 5000;

  function montarCarrosselEntrevistasPublications() {
    const track = document.getElementById("publications-entrevistas-track");
    const dotsWrap = document.getElementById("publications-entrevistas-dots");
    if (!track || !dotsWrap) return;

    const paginas = [];
    for (let i = 0; i < PUB_ENTREVISTAS.length; i += PUB_ITENS_POR_PAGINA) {
      paginas.push(PUB_ENTREVISTAS.slice(i, i + PUB_ITENS_POR_PAGINA));
    }

    track.innerHTML = paginas.map(pagina => `
      <div class="publications-entrevistas-page">
        ${pagina.map(item => `
          <div class="publications-entrevista-item">
            <div class="publications-entrevista-logo"><img src="${item.logo}" alt="${item.titulo}"></div>
            <div class="publications-entrevista-body">
              <p>${item.label}</p>
              <h4>${item.titulo}</h4>
              <a class="publications-leia-mais" href="${item.link}" target="_blank" rel="noopener">Leia mais &rarr;</a>
            </div>
          </div>
        `).join("")}
      </div>
    `).join("");

    dotsWrap.innerHTML = paginas.map((_, i) =>
      `<button data-index="${i}" class="${i === 0 ? "active" : ""}"></button>`
    ).join("");

    let atual = 0;
    const dots = [...dotsWrap.querySelectorAll("button")];

    function irPara(index) {
      atual = index;
      track.style.transform = `translateX(-${atual * 100}%)`;
      dots.forEach((d, i) => d.classList.toggle("active", i === atual));
    }

    dots.forEach(dot => {
      dot.addEventListener("click", () => irPara(Number(dot.dataset.index)));
    });

    if (paginas.length > 1) {
      setInterval(() => {
        irPara((atual + 1) % paginas.length);
      }, PUB_INTERVALO_MS);
    }
  }

  montarCarrosselEntrevistasPublications();
})();