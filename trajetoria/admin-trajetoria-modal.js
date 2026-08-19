/**
 * Admin: campos do metabox "Conteúdo do Modal" na edição de Trajetoria.
 * - Repeaters genéricos (destaques, documentos, impacto): clona um
 *   <template> e injeta antes do botão "+ Adicionar", sem precisar
 *   reindexar nomes (todos os inputs usam name="campo[]").
 * - Galeria: seletor de mídia múltiplo, guarda os IDs numa lista
 *   separada por vírgula num input hidden.
 * - Documentos: seletor de mídia único por linha, guarda o ID do
 *   anexo escolhido no input hidden daquela linha.
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {

		/* ---------- Repeaters genéricos ---------- */
		document.querySelectorAll( '[data-repeater-add]' ).forEach( function ( addBtn ) {
			addBtn.addEventListener( 'click', function () {
				const containerId = addBtn.getAttribute( 'data-repeater-add' );
				const templateId  = addBtn.getAttribute( 'data-repeater-template' );
				const container   = document.getElementById( containerId );
				const template    = document.getElementById( templateId );

				if ( ! container || ! template ) {
					return;
				}

				const clone = template.content.cloneNode( true );
				container.appendChild( clone );
			} );
		} );

		// Delegação: remover linha de qualquer repeater (funciona mesmo
		// pras linhas criadas dinamicamente depois do carregamento).
		document.addEventListener( 'click', function ( e ) {
			const removeBtn = e.target.closest( '.andrewp-repeater__remove' );
			if ( removeBtn ) {
				const row = removeBtn.closest( '.andrewp-repeater__row' );
				if ( row ) {
					row.remove();
				}
			}

			/* ---------- Certificado (imagem única) ---------- */
		const certBtn     = document.getElementById( 'andrewp-certificado-selecionar' );
		const certHidden  = document.getElementById( 'trajetoria_certificado_id' );
		const certPreview = document.getElementById( 'andrewp-certificado-preview' );

		if ( certBtn ) {
			let certFrame = null;

			certBtn.addEventListener( 'click', function ( e ) {
				e.preventDefault();

				if ( certFrame ) {
					certFrame.open();
					return;
				}

				certFrame = wp.media( {
					title: 'Selecionar imagem do certificado',
					button: { text: 'Usar esta imagem' },
					multiple: false,
					library: { type: 'image' },
				} );

				certFrame.on( 'select', function () {
					const attachment = certFrame.state().get( 'selection' ).first().toJSON();
					const url = ( attachment.sizes && attachment.sizes.thumbnail )
						? attachment.sizes.thumbnail.url
						: attachment.url;

					certHidden.value = attachment.id;
					certPreview.innerHTML = '<div class="andrewp-galeria-preview__item" data-id="' + attachment.id + '">' +
						'<img src="' + url + '" alt="" />' +
						'<button type="button" class="andrewp-galeria-preview__remove" id="andrewp-certificado-remover">&times;</button>' +
						'</div>';
				} );

				certFrame.open();
			} );
		}

		if ( certPreview ) {
			certPreview.addEventListener( 'click', function ( e ) {
				if ( e.target.closest( '#andrewp-certificado-remover' ) ) {
					certHidden.value = '';
					certPreview.innerHTML = '';
				}
			} );
		}
		} );

		/* ---------- Galeria de imagens (múltipla) ---------- */
		const galeriaBtn      = document.getElementById( 'andrewp-galeria-selecionar' );
		const galeriaHidden    = document.getElementById( 'trajetoria_galeria_ids' );
		const galeriaPreview   = document.getElementById( 'andrewp-galeria-preview' );

		function getGaleriaIds() {
			if ( ! galeriaHidden.value ) {
				return [];
			}
			return galeriaHidden.value.split( ',' ).filter( Boolean );
		}

		function setGaleriaIds( ids ) {
			galeriaHidden.value = ids.join( ',' );
		}

		function renderGaleriaThumb( attachment ) {
			const url = ( attachment.sizes && attachment.sizes.thumbnail )
				? attachment.sizes.thumbnail.url
				: attachment.url;

			const item = document.createElement( 'div' );
			item.className = 'andrewp-galeria-preview__item';
			item.dataset.id = attachment.id;
			item.innerHTML = '<img src="' + url + '" alt="" />' +
				'<button type="button" class="andrewp-galeria-preview__remove">&times;</button>';
			galeriaPreview.appendChild( item );
		}

		if ( galeriaBtn ) {
			let galeriaFrame = null;

			galeriaBtn.addEventListener( 'click', function ( e ) {
				e.preventDefault();

				if ( galeriaFrame ) {
					galeriaFrame.open();
					return;
				}

				galeriaFrame = wp.media( {
					title: 'Selecionar imagens da galeria',
					button: { text: 'Adicionar à galeria' },
					multiple: true,
					library: { type: 'image' },
				} );

				galeriaFrame.on( 'select', function () {
					const selecionadas = galeriaFrame.state().get( 'selection' ).toJSON();
					const idsAtuais = getGaleriaIds();

					selecionadas.forEach( function ( attachment ) {
						const idStr = String( attachment.id );
						if ( idsAtuais.indexOf( idStr ) === -1 ) {
							idsAtuais.push( idStr );
							renderGaleriaThumb( attachment );
						}
					} );

					setGaleriaIds( idsAtuais );
				} );

				galeriaFrame.open();
			} );
		}

		if ( galeriaPreview ) {
			galeriaPreview.addEventListener( 'click', function ( e ) {
				const removeBtn = e.target.closest( '.andrewp-galeria-preview__remove' );
				if ( ! removeBtn ) {
					return;
				}
				const item = removeBtn.closest( '.andrewp-galeria-preview__item' );
				const id = item.dataset.id;
				const idsAtuais = getGaleriaIds().filter( function ( existente ) {
					return existente !== id;
				} );
				setGaleriaIds( idsAtuais );
				item.remove();
			} );
		}

		/* ---------- Documentos (um arquivo por linha) ---------- */
		document.addEventListener( 'click', function ( e ) {
			const selecionarBtn = e.target.closest( '.andrewp-doc-selecionar' );
			if ( ! selecionarBtn ) {
				return;
			}
			e.preventDefault();

			const row = selecionarBtn.closest( '.andrewp-repeater__row' );
			const hiddenInput = row.querySelector( '.andrewp-doc-arquivo-id' );
			const nomeSpan = row.querySelector( '.andrewp-doc-arquivo-nome' );

			const docFrame = wp.media( {
				title: 'Selecionar documento',
				button: { text: 'Usar este arquivo' },
				multiple: false,
			} );

			docFrame.on( 'select', function () {
				const attachment = docFrame.state().get( 'selection' ).first().toJSON();
				hiddenInput.value = attachment.id;
				nomeSpan.textContent = attachment.filename || attachment.title || ( 'Arquivo #' + attachment.id );
			} );

			docFrame.open();
		} );

	} );
} )();