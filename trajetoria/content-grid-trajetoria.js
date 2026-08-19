/**
 * Grid de Conquistas
 * - "Carregar mais" (paginação via AJAX)
 * - Modal "Ver mais" (abre/fecha + busca conteúdo via AJAX + troca de abas)
 * Vanilla JS, sem dependências. Usa admin-ajax.php do WordPress.
 */
( function () {
	'use strict';

	/* =========================================================
	   Parte 1: Grid + "Carregar mais"
	   ========================================================= */

	const grid = document.getElementById( 'grid-conquistas-lista' );

	if ( grid ) {

		const section = document.getElementById( 'grid-conquistas' ) || grid;

		function easeInOutQuint( t ) {
			return t < 0.5
				? 16 * t * t * t * t * t
				: 1 - Math.pow( -2 * t + 2, 5 ) / 2;
		}

		let scrollAnimationId = null;

		function animateScrollTo( targetY, duration ) {
			if ( scrollAnimationId !== null ) {
				cancelAnimationFrame( scrollAnimationId );
			}

			const startY = window.pageYOffset;
			const distance = targetY - startY;
			const startTime = performance.now();

			function step( now ) {
				const elapsed = now - startTime;
				const progress = Math.min( elapsed / duration, 1 );
				const eased = easeInOutQuint( progress );

				window.scrollTo( 0, startY + distance * eased );

				if ( progress < 1 ) {
					scrollAnimationId = requestAnimationFrame( step );
				} else {
					scrollAnimationId = null;
				}
			}

			scrollAnimationId = requestAnimationFrame( step );
		}

		function scrollToSection() {
			const header = document.querySelector( '.site-header' )
				|| document.querySelector( 'header.header' )
				|| document.querySelector( 'header' );
			const headerHeight = header ? header.getBoundingClientRect().height : 0;
			const extraGap = 16;
			const top = section.getBoundingClientRect().top + window.pageYOffset - headerHeight - extraGap;

			animateScrollTo( top, 900 );
		}

		const loadBtn = document.getElementById( 'carregar-mais-conquistas' );

		const state = {
			paged: 1,
			hasMore: !! loadBtn,
		};

		function setLoading( isLoading ) {
			grid.style.opacity = isLoading ? '0.5' : '1';
			if ( loadBtn ) {
				loadBtn.classList.toggle( 'is-loading', isLoading );
				loadBtn.disabled = isLoading;
			}
		}

		function fetchConquistas() {
			setLoading( true );

			const body = new URLSearchParams( {
				action: 'andrewp_load_conquistas',
				nonce: window.andrewpConquistas.nonce,
				paged: state.paged,
			} );

			fetch( window.andrewpConquistas.ajaxUrl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: body.toString(),
			} )
				.then( function ( res ) { return res.json(); } )
				.then( function ( json ) {
					if ( ! json.success ) {
						return;
					}

					grid.innerHTML = json.data.html;
					state.hasMore = json.data.has_more;

					if ( loadBtn ) {
						loadBtn.style.display = state.hasMore ? '' : 'none';
					}

					scrollToSection();
				} )
				.catch( function () {
					grid.innerHTML = '<p class="grid-conquistas__empty">Não foi possível carregar as conquistas. Tente novamente.</p>';
				} )
				.finally( function () {
					setLoading( false );
				} );
		}

		if ( loadBtn ) {
			loadBtn.addEventListener( 'click', function () {
				state.paged += 1;
				fetchConquistas();
			} );
		}
	}

	/* =========================================================
	   Parte 2: Modal "Ver mais"
	   ========================================================= */

	const modalOverlay = document.getElementById( 'conquista-modal-overlay' );

	if ( modalOverlay ) {

		const modalLoading = document.getElementById( 'conquista-modal-loading' );
		const modalContent = document.getElementById( 'conquista-modal-content' );

		function abrirModal() {
			modalOverlay.classList.add( 'is-open' );
			modalOverlay.setAttribute( 'aria-hidden', 'false' );
			document.body.classList.add( 'conquista-modal-aberto' );
		}

		function fecharModal() {
			modalOverlay.classList.remove( 'is-open' );
			modalOverlay.setAttribute( 'aria-hidden', 'true' );
			document.body.classList.remove( 'conquista-modal-aberto' );
			modalContent.innerHTML = '';
		}

		function carregarConquistaModal( postId ) {
			modalContent.innerHTML = '';
			modalLoading.style.display = 'flex';
			abrirModal();

			const body = new URLSearchParams( {
				action: 'andrewp_get_conquista_modal',
				nonce: window.andrewpConquistas.nonce,
				post_id: postId,
			} );

			fetch( window.andrewpConquistas.ajaxUrl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: body.toString(),
			} )
				.then( function ( res ) { return res.json(); } )
				.then( function ( json ) {
					modalLoading.style.display = 'none';

					if ( json.success ) {
						modalContent.innerHTML = json.data.html;
					} else {
						modalContent.innerHTML = '<p class="conquista-modal__erro">Não foi possível carregar os detalhes.</p>';
					}
				} )
				.catch( function () {
					modalLoading.style.display = 'none';
					modalContent.innerHTML = '<p class="conquista-modal__erro">Erro ao carregar. Tente novamente.</p>';
				} );
		}

		function trocarAba( tabBtn ) {
			const modal = tabBtn.closest( '.conquista-modal' );
			const alvo  = tabBtn.dataset.tab;

			if ( ! modal ) {
				return;
			}

			modal.querySelectorAll( '.conquista-modal__tab' ).forEach( function ( t ) {
				t.classList.toggle( 'is-active', t === tabBtn );
			} );
			modal.querySelectorAll( '.conquista-modal__panel' ).forEach( function ( p ) {
				p.classList.toggle( 'is-active', p.dataset.panel === alvo );
			} );
		}

		function irParaSlide( carousel, index ) {
			const slides = carousel.querySelectorAll( '.conquista-modal__carousel-slide' );
			const dots   = carousel.querySelectorAll( '.conquista-modal__carousel-dot' );

			if ( ! slides.length ) {
				return;
			}

			const total = slides.length;
			const alvo  = ( ( index % total ) + total ) % total;

			slides.forEach( function ( s, i ) {
				s.classList.toggle( 'is-active', i === alvo );
			} );
			dots.forEach( function ( d, i ) {
				d.classList.toggle( 'is-active', i === alvo );
			} );

			carousel.dataset.current = alvo;
		}

		// Delegação: cobre também os cards e abas que chegam depois via AJAX.
		document.addEventListener( 'click', function ( e ) {
			const abrirBtn = e.target.closest( '.js-abrir-conquista-modal' );
			if ( abrirBtn ) {
				carregarConquistaModal( abrirBtn.dataset.postId );
				return;
			}

			const carouselNav = e.target.closest( '.conquista-modal__carousel-nav' );
			if ( carouselNav ) {
				e.preventDefault();
				const carousel = carouselNav.closest( '.conquista-modal__carousel' );
				const atual = parseInt( carousel.dataset.current || '0', 10 );
				const delta = carouselNav.classList.contains( 'conquista-modal__carousel-nav--next' ) ? 1 : -1;
				irParaSlide( carousel, atual + delta );
				return;
			}

			const carouselDot = e.target.closest( '.conquista-modal__carousel-dot' );
			if ( carouselDot ) {
				const carousel = carouselDot.closest( '.conquista-modal__carousel' );
				irParaSlide( carousel, parseInt( carouselDot.dataset.index, 10 ) );
				return;
			}

			const tabBtn = e.target.closest( '.conquista-modal__tab' );
			if ( tabBtn ) {
				trocarAba( tabBtn );
				return;
			}

			// Fecha clicando no botão de fechar (dentro do conteúdo AJAX) ou fora do modal.
			if ( e.target.closest( '.conquista-modal__fechar' ) || e.target === modalOverlay ) {
				fecharModal();
			}
		} );

		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && modalOverlay.classList.contains( 'is-open' ) ) {
				fecharModal();
			}
		} );
	}

} )();