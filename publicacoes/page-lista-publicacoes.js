/**
 * page-lista-publicacoes.js
 *
 * Controla a lista de publicações em /publicacoes/:
 * - abas de filtro (Artigos / Revistas / Livros / Capítulos de Livros)
 * - busca por título
 * - ordenação
 * - paginação numérica
 * - botão "Limpar filtros"
 * - modal "Ler artigo" (aberto via AJAX, sob demanda)
 *
 * Depende de andrewpPublicacoes = { ajaxUrl, nonce } (wp_localize_script,
 * ver inc/assets.php).
 *
 * @package andreWP
 */

( function () {
	'use strict';

	if ( typeof andrewpPublicacoes === 'undefined' ) {
		return;
	}

	var secao = document.getElementById( 'lista-publicacoes' );
	if ( ! secao ) {
		return;
	}

	var abasWrap      = document.getElementById( 'lista-publicacoes-abas' );
	var buscaInput    = document.getElementById( 'lista-publicacoes-busca' );
	var limparBtn     = document.getElementById( 'lista-publicacoes-limpar' );
	var ordenarSelect = document.getElementById( 'lista-publicacoes-ordenar' );
	var resultadosEl  = document.getElementById( 'lista-publicacoes-resultados' );
	var paginacaoEl   = document.getElementById( 'lista-publicacoes-paginacao' );
	var labelEl       = document.getElementById( 'lista-publicacoes-label' );
	var totalEl       = document.getElementById( 'lista-publicacoes-total' );

	var overlay      = document.getElementById( 'publicacao-modal-overlay' );
	var modalLoading = document.getElementById( 'publicacao-modal-loading' );
	var modalContent = document.getElementById( 'publicacao-modal-content' );

	// Aba ativa no carregamento da página = aba "padrão" (normalmente Artigos).
	var abaPadrao = resultadosEl ? resultadosEl.getAttribute( 'data-tipo' ) || 'todos' : 'todos';

	var estado = {
		tipo: abaPadrao,
		busca: '',
		orderby: 'recentes',
		paged: 1,
	};

	var debounceTimer = null;

	function labelDaAba( slug ) {
		var botao = abasWrap ? abasWrap.querySelector( '[data-tipo="' + slug + '"]' ) : null;
		if ( ! botao ) {
			return '';
		}
		var texto = botao.textContent.trim();
		// Deixa "Artigos" em vez de "ARTIGOS" no título da seção.
		return texto.charAt( 0 ) + texto.slice( 1 ).toLowerCase();
	}

	/**
	 * Marca visualmente qual aba está ativa (ou nenhuma, quando há busca —
	 * já que a busca varre todos os tipos e nenhuma aba específica reflete
	 * mais o resultado exibido).
	 */
	function atualizarAbasAtivas() {
		if ( ! abasWrap ) {
			return;
		}

		var nenhumaAtiva = '' !== estado.busca;

		abasWrap.querySelectorAll( '.lista-publicacoes__aba' ).forEach( function ( b ) {
			var ativa = ! nenhumaAtiva && b.getAttribute( 'data-tipo' ) === estado.tipo;
			b.classList.toggle( 'is-active', ativa );
			b.setAttribute( 'aria-selected', ativa ? 'true' : 'false' );
		} );
	}

	function buscarPublicacoes() {
		if ( resultadosEl ) {
			resultadosEl.classList.add( 'is-carregando' );
		}

		var dados = new FormData();
		dados.append( 'action', 'andrewp_filtrar_publicacoes' );
		dados.append( 'nonce', andrewpPublicacoes.nonce );
		dados.append( 'tipo', estado.tipo );
		dados.append( 'busca', estado.busca );
		dados.append( 'orderby', estado.orderby );
		dados.append( 'paged', estado.paged );

		fetch( andrewpPublicacoes.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: dados,
		} )
			.then( function ( resp ) { return resp.json(); } )
			.then( function ( json ) {
				if ( ! json || ! json.success ) {
					return;
				}

				if ( resultadosEl ) {
					resultadosEl.innerHTML = json.data.html;
					resultadosEl.setAttribute( 'data-tipo', estado.tipo );
					resultadosEl.setAttribute( 'data-pagina', json.data.pagina );
				}

				if ( paginacaoEl ) {
					paginacaoEl.innerHTML = json.data.paginacao;
				}

				if ( totalEl ) {
					totalEl.textContent = json.data.total;
				}

				if ( labelEl ) {
					labelEl.textContent = estado.busca
						? 'Resultados para "' + estado.busca + '"'
						: labelDaAba( estado.tipo ) || 'Publicações';
				}

				secao.scrollIntoView( { behavior: 'smooth', block: 'start' } );
			} )
			.catch( function () {
				if ( resultadosEl ) {
					resultadosEl.innerHTML = '<p class="lista-publicacoes__vazio">Não foi possível carregar as publicações. Tente novamente.</p>';
				}
			} )
			.finally( function () {
				if ( resultadosEl ) {
					resultadosEl.classList.remove( 'is-carregando' );
				}
			} );
	}

	// ---- Abas de filtro ----
	if ( abasWrap ) {
		abasWrap.addEventListener( 'click', function ( e ) {
			var botao = e.target.closest( '.lista-publicacoes__aba' );
			if ( ! botao ) {
				return;
			}

			// Clicar numa aba limpa a busca: senão o filtro de tipo fica
			// sem efeito (a busca varre todos os tipos enquanto preenchida).
			estado.busca = '';
			if ( buscaInput ) {
				buscaInput.value = '';
			}

			estado.tipo = botao.getAttribute( 'data-tipo' );
			estado.paged = 1;

			atualizarAbasAtivas();
			buscarPublicacoes();
		} );
	}

	// ---- Busca (com debounce) ----
	if ( buscaInput ) {
		buscaInput.addEventListener( 'input', function () {
			clearTimeout( debounceTimer );
			debounceTimer = setTimeout( function () {
				estado.busca = buscaInput.value.trim();
				estado.paged = 1;

				atualizarAbasAtivas();
				buscarPublicacoes();
			}, 350 );
		} );
	}

	// ---- Ordenação ----
	if ( ordenarSelect ) {
		ordenarSelect.addEventListener( 'change', function () {
			estado.orderby = ordenarSelect.value;
			estado.paged = 1;
			buscarPublicacoes();
		} );
	}

	// ---- Limpar filtros ----
	if ( limparBtn ) {
		limparBtn.addEventListener( 'click', function () {
			// Só faz alguma coisa se algum filtro estiver realmente ativo,
			// pra evitar uma requisição AJAX desnecessária.
			var temFiltroAtivo = '' !== estado.busca
				|| estado.tipo !== abaPadrao
				|| 'recentes' !== estado.orderby
				|| estado.paged !== 1;

			if ( ! temFiltroAtivo ) {
				return;
			}

			estado.busca   = '';
			estado.tipo    = abaPadrao;
			estado.orderby = 'recentes';
			estado.paged   = 1;

			if ( buscaInput ) {
				buscaInput.value = '';
			}
			if ( ordenarSelect ) {
				ordenarSelect.value = 'recentes';
			}

			atualizarAbasAtivas();
			buscarPublicacoes();
		} );
	}

	// ---- Paginação (delegado, pois o HTML é recriado a cada AJAX) ----
	if ( paginacaoEl ) {
		paginacaoEl.addEventListener( 'click', function ( e ) {
			var botao = e.target.closest( '[data-pagina]' );
			if ( ! botao || botao.disabled ) {
				return;
			}
			var novaPagina = parseInt( botao.getAttribute( 'data-pagina' ), 10 );
			if ( ! novaPagina || novaPagina < 1 ) {
				return;
			}
			estado.paged = novaPagina;
			buscarPublicacoes();
		} );
	}

	// ---- Modal "Ler artigo" ----
	function abrirModal( postId ) {
		if ( ! overlay ) {
			return;
		}

		overlay.classList.add( 'is-aberto' );
		overlay.setAttribute( 'aria-hidden', 'false' );
		document.body.classList.add( 'publicacao-modal-open' );

		if ( modalContent ) {
			modalContent.innerHTML = '';
			modalContent.style.display = 'none';
		}
		if ( modalLoading ) {
			modalLoading.style.display = 'flex';
		}

		var dados = new FormData();
		dados.append( 'action', 'andrewp_get_publicacao_modal' );
		dados.append( 'nonce', andrewpPublicacoes.nonce );
		dados.append( 'post_id', postId );

		fetch( andrewpPublicacoes.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: dados,
		} )
			.then( function ( resp ) { return resp.json(); } )
			.then( function ( json ) {
				if ( ! json || ! json.success ) {
					if ( modalContent ) {
						modalContent.innerHTML = '<p class="publicacao-modal__erro">Não foi possível carregar esta publicação.</p>';
					}
					return;
				}
				if ( modalContent ) {
					modalContent.innerHTML = json.data.html;
				}
			} )
			.catch( function () {
				if ( modalContent ) {
					modalContent.innerHTML = '<p class="publicacao-modal__erro">Não foi possível carregar esta publicação.</p>';
				}
			} )
			.finally( function () {
				if ( modalLoading ) {
					modalLoading.style.display = 'none';
				}
				if ( modalContent ) {
					modalContent.style.display = 'block';
				}
			} );
	}

	function fecharModal() {
		if ( ! overlay ) {
			return;
		}
		overlay.classList.remove( 'is-aberto' );
		overlay.setAttribute( 'aria-hidden', 'true' );
		document.body.classList.remove( 'publicacao-modal-open' );
	}

	// Delegado no documento: os botões "Ler artigo" são recriados a cada AJAX.
	document.addEventListener( 'click', function ( e ) {
		var abrir = e.target.closest( '.js-abrir-publicacao' );
		if ( abrir ) {
			var postId = abrir.getAttribute( 'data-post-id' );
			if ( postId ) {
				abrirModal( postId );
			}
			return;
		}

		if ( e.target.closest( '.js-fechar-publicacao' ) ) {
			fecharModal();
			return;
		}

		// Clique fora do card do modal (no overlay) fecha.
		if ( overlay && e.target === overlay ) {
			fecharModal();
		}
	} );

	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key && overlay && overlay.classList.contains( 'is-aberto' ) ) {
			fecharModal();
		}
	} );

} )();