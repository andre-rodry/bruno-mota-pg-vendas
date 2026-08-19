/**
 * Grid de Trajetoria
 * - "Carregar mais" (paginação via AJAX)
 * - Modal "Ver mais" (abre/fecha + busca conteúdo via AJAX + troca de abas)
 * Vanilla JS, sem dependências. Usa admin-ajax.php do WordPress.
 */
( function () {
	'use strict';

	/* =========================================================
	   Parte 1: Grid + "Carregar mais"
	   ========================================================= */

	const grid = document.getElementById( 'grid-trajetoria-lista' );

	if ( grid ) {

		const section = document.getElementById( 'grid-trajetoria' ) || grid;

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

		const loadBtn = document.getElementById( 'carregar-mais-trajetoria' );

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

		function fetchTrajetoria() {
			setLoading( true );

			const body = new URLSearchParams( {
				action: 'andrewp_load_trajetoria',
				nonce: window.andrewpTrajetoria.nonce,
				paged: state.paged,
			} );

			fetch( window.andrewpTrajetoria.ajaxUrl, {
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
					grid.innerHTML = '<p class="grid-trajetoria__empty">Não foi possível carregar a trajetoria. Tente novamente.</p>';
				} )
				.finally( function () {
					setLoading( false );
				} );
		}

		if ( loadBtn ) {
			loadBtn.addEventListener( 'click', function () {
				state.paged += 1;
				fetchTrajetoria();
			} );
		}
	}

	/* =========================================================
	   Parte 2: Modal "Ver mais"
	   ========================================================= */

	const modalOverlay = document.getElementById( 'trajetoria-modal-overlay' );

	if ( modalOverlay ) {

		const modalLoading = document.getElementById( 'trajetoria-modal-loading' );
		const modalContent = document.getElementById( 'trajetoria-modal-content' );

		function abrirModal() {
			modalOverlay.classList.add( 'is-open' );
			modalOverlay.setAttribute( 'aria-hidden', 'false' );
			document.body.classList.add( 'trajetoria-modal-aberto' );
		}

		function fecharModal() {
			modalOverlay.classList.remove( 'is-open' );
			modalOverlay.setAttribute( 'aria-hidden', 'true' );
			document.body.classList.remove( 'trajetoria-modal-aberto' );
			modalContent.innerHTML = '';
		}

		function carregarTrajetoriaModal( postId ) {
			modalContent.innerHTML = '';
			modalLoading.style.display = 'flex';
			abrirModal();

			const body = new URLSearchParams( {
				action: 'andrewp_get_trajetoria_modal',
				nonce: window.andrewpTrajetoria.nonce,
				post_id: postId,
			} );

			fetch( window.andrewpTrajetoria.ajaxUrl, {
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
						modalContent.innerHTML = '<p class="trajetoria-modal__erro">Não foi possível carregar os detalhes.</p>';
					}
				} )
				.catch( function () {
					modalLoading.style.display = 'none';
					modalContent.innerHTML = '<p class="trajetoria-modal__erro">Erro ao carregar. Tente novamente.</p>';
				} );
		}

		function trocarAba( tabBtn ) {
			const modal = tabBtn.closest( '.trajetoria-modal' );
			const alvo  = tabBtn.dataset.tab;

			if ( ! modal ) {
				return;
			}

			modal.querySelectorAll( '.trajetoria-modal__tab' ).forEach( function ( t ) {
				t.classList.toggle( 'is-active', t === tabBtn );
			} );
			modal.querySelectorAll( '.trajetoria-modal__panel' ).forEach( function ( p ) {
				p.classList.toggle( 'is-active', p.dataset.panel === alvo );
			} );
		}

		function irParaSlide( carousel, index ) {
			const slides = carousel.querySelectorAll( '.trajetoria-modal__carousel-slide' );
			const dots   = carousel.querySelectorAll( '.trajetoria-modal__carousel-dot' );

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
			const abrirBtn = e.target.closest( '.js-abrir-trajetoria-modal' );
			if ( abrirBtn ) {
				carregarTrajetoriaModal( abrirBtn.dataset.postId );
				return;
			}

			const carouselNav = e.target.closest( '.trajetoria-modal__carousel-nav' );
			if ( carouselNav ) {
				e.preventDefault();
				const carousel = carouselNav.closest( '.trajetoria-modal__carousel' );
				const atual = parseInt( carousel.dataset.current || '0', 10 );
				const delta = carouselNav.classList.contains( 'trajetoria-modal__carousel-nav--next' ) ? 1 : -1;
				irParaSlide( carousel, atual + delta );
				return;
			}

			const carouselDot = e.target.closest( '.trajetoria-modal__carousel-dot' );
			if ( carouselDot ) {
				const carousel = carouselDot.closest( '.trajetoria-modal__carousel' );
				irParaSlide( carousel, parseInt( carouselDot.dataset.index, 10 ) );
				return;
			}

			const tabBtn = e.target.closest( '.trajetoria-modal__tab' );
			if ( tabBtn ) {
				trocarAba( tabBtn );
				return;
			}

			// Fecha clicando no botão de fechar (dentro do conteúdo AJAX) ou fora do modal.
			if ( e.target.closest( '.trajetoria-modal__fechar' ) || e.target === modalOverlay ) {
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