/**
 * Grid de Conquistas — filtro por categoria (pílulas) e "carregar mais".
 * Vanilla JS, sem dependências. Usa admin-ajax.php do WordPress.
 *
 * Os filtros de "ano" e "ordenar" foram removidos: a ordenação é sempre
 * por mais recentes primeiro, definida no backend (inc/ajax-conquistas.php).
 */
( function () {
	'use strict';

	const grid = document.getElementById( 'grid-conquistas-lista' );
	if ( ! grid ) {
		return;
	}

	// Seção inteira (título "Todas as Conquistas" + subtítulo + pílulas + grid).
	// Usada como alvo do scroll, pra sempre subir até o topo da seção, não só até os cards.
	const section = document.getElementById( 'grid-conquistas' ) || grid;

	// O header do tema é fixo/sticky e fica por cima do conteúdo ao rolar.
	// scrollIntoView() sozinho ignora isso e deixa o título escondido atrás do header.
	// Por isso calculamos a altura real do header (em vez de "chutar" um valor fixo)
	// e compensamos manualmente, animando o scroll com uma curva suave (easing)
	// em vez do "smooth" nativo do navegador, que varia de velocidade entre browsers
	// e costuma parecer brusco em distâncias curtas.
	//
	// easeInOutQuint: início e fim bem graduais, com uma aceleração maior só no
	// meio do percurso — dá a sensação de "flutuar" até o destino em vez de
	// ganhar/perder velocidade de forma abrupta.
	function easeInOutQuint( t ) {
		return t < 0.5
			? 16 * t * t * t * t * t
			: 1 - Math.pow( -2 * t + 2, 5 ) / 2;
	}

	let scrollAnimationId = null;

	function animateScrollTo( targetY, duration ) {
		// Cancela uma animação de scroll anterior ainda em andamento (ex.: o usuário
		// clicou em "carregar mais" ou trocou de filtro rapidamente), evitando que
		// duas animações concorrentes disputem a posição do scroll e travem o efeito.
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
		const extraGap = 16; // respiro extra abaixo do header, só estética
		const top = section.getBoundingClientRect().top + window.pageYOffset - headerHeight - extraGap;

		animateScrollTo( top, 900 ); // 900ms: suave, sem parecer arrastado
	}

	const pillsWrap = document.querySelector( '.grid-conquistas__pills' );
	const loadBtn   = document.getElementById( 'carregar-mais-conquistas' );

	const state = {
		tipo: '',
		paged: 1,
		hasMore: loadBtn ? true : false,
	};

	function setLoading( isLoading ) {
		grid.style.opacity = isLoading ? '0.5' : '1';
		if ( loadBtn ) {
			loadBtn.classList.toggle( 'is-loading', isLoading );
			loadBtn.disabled = isLoading;
		}
	}

	function fetchConquistas( append ) {
		setLoading( true );

		const body = new URLSearchParams( {
			action: 'andrewp_load_conquistas',
			nonce: window.andrewpConquistas.nonce,
			paged: state.paged,
			tipo: state.tipo,
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

				if ( append ) {
					grid.insertAdjacentHTML( 'beforeend', json.data.html );
				} else {
					grid.innerHTML = json.data.html;
				}

				state.hasMore = json.data.has_more;

				if ( loadBtn ) {
					loadBtn.style.display = state.hasMore ? '' : 'none';
				}

				// Rola suavemente até o topo da seção (título "Todas as Conquistas"),
				// já descontando a altura do header fixo, pra ver os novos cards
				// sem precisar subir a página manualmente.
				scrollToSection();
			} )
			.catch( function () {
				grid.innerHTML = '<p class="grid-conquistas__empty">Não foi possível carregar as conquistas. Tente novamente.</p>';
			} )
			.finally( function () {
				setLoading( false );
			} );
	}

	// Pílulas de categoria.
	if ( pillsWrap ) {
		pillsWrap.addEventListener( 'click', function ( e ) {
			const btn = e.target.closest( '.grid-conquistas__pill' );
			if ( ! btn ) {
				return;
			}

			pillsWrap.querySelectorAll( '.grid-conquistas__pill' ).forEach( function ( p ) {
				p.classList.remove( 'is-active' );
			} );
			btn.classList.add( 'is-active' );

			state.tipo  = btn.dataset.tipo || '';
			state.paged = 1;
			fetchConquistas( false );
		} );
	}

	// Carregar mais: troca os cards atuais pelos da próxima leva (não empilha embaixo).
	if ( loadBtn ) {
		loadBtn.addEventListener( 'click', function () {
			state.paged += 1;
			fetchConquistas( false );
		} );
	}
} )();