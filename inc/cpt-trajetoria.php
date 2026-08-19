<?php
/**
 * CPT "Trajetória" + taxonomia "Tipo de Trajetória" + campos do Modal
 *
 * Registra o tipo de conteúdo usado pela página /trajetorias/
 * (trajetoria/content-grid-trajetorias.php) e todos os campos
 * personalizados que alimentam o modal "Ver mais" de cada trajetória
 * (trajetoria/modal-trajetoria.php).
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Post Type: Trajetória
 */
function andrewp_register_cpt_trajetoria() {
	$labels = array(
		'name'                  => __( 'Trajetórias', 'andrewp' ),
		'singular_name'         => __( 'Trajetória', 'andrewp' ),
		'menu_name'             => __( 'Trajetórias', 'andrewp' ),
		'add_new'               => __( 'Adicionar Nova', 'andrewp' ),
		'add_new_item'          => __( 'Adicionar Nova Trajetória', 'andrewp' ),
		'edit_item'             => __( 'Editar Trajetória', 'andrewp' ),
		'new_item'              => __( 'Nova Trajetória', 'andrewp' ),
		'view_item'             => __( 'Ver Trajetória', 'andrewp' ),
		'search_items'          => __( 'Buscar Trajetórias', 'andrewp' ),
		'not_found'             => __( 'Nenhuma trajetória encontrada', 'andrewp' ),
		'not_found_in_trash'    => __( 'Nenhuma trajetória na lixeira', 'andrewp' ),
		'all_items'             => __( 'Todas as Trajetórias', 'andrewp' ),
		'featured_image'        => __( 'Imagem da Trajetória', 'andrewp' ),
		'set_featured_image'    => __( 'Definir imagem', 'andrewp' ),
		'remove_featured_image' => __( 'Remover imagem', 'andrewp' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'trajetoria' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-awards',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'trajetoria', $args );
}
add_action( 'init', 'andrewp_register_cpt_trajetoria' );

/**
 * Taxonomia: Tipo de Trajetória
 */
function andrewp_register_tax_tipo_trajetoria() {
	$labels = array(
		'name'          => __( 'Tipos de Trajetória', 'andrewp' ),
		'singular_name' => __( 'Tipo de Trajetória', 'andrewp' ),
		'search_items'  => __( 'Buscar Tipos', 'andrewp' ),
		'all_items'     => __( 'Todos os Tipos', 'andrewp' ),
		'edit_item'     => __( 'Editar Tipo', 'andrewp' ),
		'update_item'   => __( 'Atualizar Tipo', 'andrewp' ),
		'add_new_item'  => __( 'Adicionar Novo Tipo', 'andrewp' ),
		'new_item_name' => __( 'Nome do Novo Tipo', 'andrewp' ),
		'menu_name'     => __( 'Tipos', 'andrewp' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'tipo-trajetoria' ),
	);

	register_taxonomy( 'tipo_trajetoria', array( 'trajetoria' ), $args );
}
add_action( 'init', 'andrewp_register_tax_tipo_trajetoria' );

function andrewp_criar_termos_padrao_trajetoria() {
	if ( get_option( 'andrewp_termos_trajetoria_criados' ) ) {
		return;
	}

	$termos_padrao = array(
		'legislacao'  => 'Legislação',
		'palestra'    => 'Palestra',
		'podcast'     => 'Podcast',
		'entrevista'  => 'Entrevista',
		'evento'      => 'Evento',
		'publicacao'  => 'Publicação',
		'artigo'      => 'Artigo',
		'curso'       => 'Curso',
		'premiacao'   => 'Premiação',
	);

	foreach ( $termos_padrao as $slug => $nome ) {
		if ( ! term_exists( $slug, 'tipo_trajetoria' ) ) {
			wp_insert_term( $nome, 'tipo_trajetoria', array( 'slug' => $slug ) );
		}
	}

	update_option( 'andrewp_termos_trajetoria_criados', 1 );
}
add_action( 'init', 'andrewp_criar_termos_padrao_trajetoria', 20 );

function andrewp_renomear_termo_premiacao() {
	if ( get_option( 'andrewp_termo_premiacao_renomeado' ) ) {
		return;
	}

	$termo = get_term_by( 'slug', 'premiacao', 'tipo_trajetoria' );

	if ( $termo && ! is_wp_error( $termo ) ) {
		wp_update_term( $termo->term_id, 'tipo_trajetoria', array(
			'name' => 'Reconhecimento',
		) );
	}

	update_option( 'andrewp_termo_premiacao_renomeado', 1 );
}
add_action( 'init', 'andrewp_renomear_termo_premiacao', 21 );

/**
 * Lista de ícones disponíveis para o badge do topo do modal e para cada
 * "destaque" da lista.
 */
function andrewp_trajetoria_icones_disponiveis() {
	return array(
		'globo'      => array( 'dashicon' => 'dashicons-admin-site-alt3', 'label' => __( 'Globo (Internacional)', 'andrewp' ) ),
		'premio'     => array( 'dashicon' => 'dashicons-awards',          'label' => __( 'Prêmio', 'andrewp' ) ),
		'estrela'    => array( 'dashicon' => 'dashicons-star-filled',     'label' => __( 'Estrela', 'andrewp' ) ),
		'livro'      => array( 'dashicon' => 'dashicons-book-alt',        'label' => __( 'Livro', 'andrewp' ) ),
		'microfone'  => array( 'dashicon' => 'dashicons-microphone',      'label' => __( 'Microfone', 'andrewp' ) ),
		'calendario' => array( 'dashicon' => 'dashicons-calendar-alt',    'label' => __( 'Calendário', 'andrewp' ) ),
		'grupo'      => array( 'dashicon' => 'dashicons-groups',         'label' => __( 'Grupo / Pessoas', 'andrewp' ) ),
		'lapis'      => array( 'dashicon' => 'dashicons-edit',            'label' => __( 'Lápis / Escrita', 'andrewp' ) ),
		'local'      => array( 'dashicon' => 'dashicons-location',        'label' => __( 'Localização', 'andrewp' ) ),
		'documento'  => array( 'dashicon' => 'dashicons-media-document',  'label' => __( 'Documento', 'andrewp' ) ),
	);
}

function andrewp_trajetoria_icone_dashicon( $slug ) {
	$icones = andrewp_trajetoria_icones_disponiveis();
	return isset( $icones[ $slug ] ) ? $icones[ $slug ]['dashicon'] : 'dashicons-tag';
}

/* =========================================================================
 * METABOX 1: "Detalhes da Trajetória" — Ano + Destaque
 * ========================================================================= */

function andrewp_metabox_destaque() {
	add_meta_box(
		'andrewp_trajetoria_destaque',
		__( 'Detalhes da Trajetória', 'andrewp' ),
		'andrewp_metabox_destaque_html',
		'trajetoria',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'andrewp_metabox_destaque' );

function andrewp_metabox_destaque_html( $post ) {
	wp_nonce_field( 'andrewp_salvar_destaque', 'andrewp_destaque_nonce' );

	$destaque = get_post_meta( $post->ID, '_trajetoria_destaque', true );
	$ano      = get_post_meta( $post->ID, '_trajetoria_ano', true );
	?>
	<p>
		<label for="trajetoria_ano" style="display:block; font-weight:600; margin-bottom:4px;">
			<?php esc_html_e( 'Ano da trajetória', 'andrewp' ); ?>
		</label>
		<input
			type="number"
			id="trajetoria_ano"
			name="trajetoria_ano"
			value="<?php echo esc_attr( $ano ); ?>"
			placeholder="<?php echo esc_attr( get_the_date( 'Y', $post ) ); ?>"
			min="1900"
			max="2100"
			step="1"
			style="width:100%;"
		/>
		<span class="description">
			<?php esc_html_e( 'Deixe em branco para usar a data de publicação do post.', 'andrewp' ); ?>
		</span>
	</p>
	<hr />
	<p>
		<label>
			<input type="checkbox" name="trajetoria_destaque" value="1" <?php checked( $destaque, '1' ); ?> />
			<?php esc_html_e( 'Marcar como destaque (mostra a faixa "DESTAQUE" no card)', 'andrewp' ); ?>
		</label>
	</p>
	<?php
}

function andrewp_salvar_destaque( $post_id ) {
	if ( ! isset( $_POST['andrewp_destaque_nonce'] ) ||
		! wp_verify_nonce( $_POST['andrewp_destaque_nonce'], 'andrewp_salvar_destaque' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	$destaque = isset( $_POST['trajetoria_destaque'] ) ? '1' : '';
	update_post_meta( $post_id, '_trajetoria_destaque', $destaque );

	if ( isset( $_POST['trajetoria_ano'] ) && '' !== trim( $_POST['trajetoria_ano'] ) ) {
		$ano = absint( $_POST['trajetoria_ano'] );
		if ( $ano >= 1900 && $ano <= 2100 ) {
			update_post_meta( $post_id, '_trajetoria_ano', $ano );
		}
	} else {
		delete_post_meta( $post_id, '_trajetoria_ano' );
	}
}
add_action( 'save_post_trajetoria', 'andrewp_salvar_destaque' );

/* =========================================================================
 * METABOX 2: "Conteúdo do Modal" — tudo que alimenta o "Ver mais"
 * ========================================================================= */

function andrewp_metabox_modal() {
	add_meta_box(
		'andrewp_trajetoria_modal',
		__( 'Conteúdo do Modal ("Ver mais")', 'andrewp' ),
		'andrewp_metabox_modal_html',
		'trajetoria',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'andrewp_metabox_modal' );

function andrewp_metabox_modal_html( $post ) {
	wp_nonce_field( 'andrewp_salvar_modal', 'andrewp_modal_nonce' );

	$badge_label = get_post_meta( $post->ID, '_trajetoria_badge_label', true );
	$icone       = get_post_meta( $post->ID, '_trajetoria_icone', true );
	$local       = get_post_meta( $post->ID, '_trajetoria_local', true );
	$subtitulo   = get_post_meta( $post->ID, '_trajetoria_subtitulo', true );

	$destaques_icone     = (array) get_post_meta( $post->ID, '_trajetoria_destaques_icone', true );
	$destaques_titulo    = (array) get_post_meta( $post->ID, '_trajetoria_destaques_titulo', true );
	$destaques_descricao = (array) get_post_meta( $post->ID, '_trajetoria_destaques_descricao', true );

	// Galeria por upload (attachment IDs) — mantido pra produção.
	$galeria_ids = get_post_meta( $post->ID, '_trajetoria_galeria', true );
	$galeria_ids = $galeria_ids ? array_filter( array_map( 'absint', explode( ',', $galeria_ids ) ) ) : array();

	// NOVO: galeria por URL (teste/rascunho, sem precisar subir arquivo).
	$galeria_urls_raw = get_post_meta( $post->ID, '_trajetoria_galeria_urls', true );

	$doc_titulo    = (array) get_post_meta( $post->ID, '_trajetoria_doc_titulo', true );
	$doc_descricao = (array) get_post_meta( $post->ID, '_trajetoria_doc_descricao', true );
	$doc_arquivo   = (array) get_post_meta( $post->ID, '_trajetoria_doc_arquivo_id', true );

	$impacto = (array) get_post_meta( $post->ID, '_trajetoria_impacto', true );

	$cta_texto = get_post_meta( $post->ID, '_trajetoria_cta_texto', true );
	$cta_url   = get_post_meta( $post->ID, '_trajetoria_cta_url', true );

	$icones = andrewp_trajetoria_icones_disponiveis();

	// Link do botão de auto-preenchimento com dados de exemplo.
	$seed_url = wp_nonce_url(
		add_query_arg(
			array( 'action' => 'andrewp_seed_trajetoria_demo', 'post_id' => $post->ID ),
			admin_url( 'admin-post.php' )
		),
		'andrewp_seed_trajetoria_demo_' . $post->ID
	);
	?>
	<div class="andrewp-modal-fields">

		<p>
			<a href="<?php echo esc_url( $seed_url ); ?>" class="button button-secondary"
			   onclick="return confirm('Isso vai sobrescrever os campos do modal deste post com o exemplo (Universidad Nacional Rosario Castellanos). Continuar?');">
				<?php esc_html_e( '⚡ Preencher com exemplo (Universidad Rosario)', 'andrewp' ); ?>
			</a>
		</p>

		<h4><?php esc_html_e( 'Cabeçalho', 'andrewp' ); ?></h4>
		<table class="form-table">
			<tr>
				<th><label for="trajetoria_badge_label"><?php esc_html_e( 'Rótulo do badge', 'andrewp' ); ?></label></th>
				<td>
					<input type="text" id="trajetoria_badge_label" name="trajetoria_badge_label" class="large-text" value="<?php echo esc_attr( $badge_label ); ?>" placeholder="Ex: TRAJETÓRIA INTERNACIONAL" />
				</td>
			</tr>
			<tr>
				<th><label for="trajetoria_icone"><?php esc_html_e( 'Ícone do badge', 'andrewp' ); ?></label></th>
				<td>
					<select id="trajetoria_icone" name="trajetoria_icone">
						<?php foreach ( $icones as $slug => $dados ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $icone, $slug ); ?>>
								<?php echo esc_html( $dados['label'] ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="trajetoria_local"><?php esc_html_e( 'Local', 'andrewp' ); ?></label></th>
				<td>
					<input type="text" id="trajetoria_local" name="trajetoria_local" class="large-text" value="<?php echo esc_attr( $local ); ?>" placeholder="Ex: Rosario, Argentina" />
				</td>
			</tr>
			<tr>
				<th><label for="trajetoria_subtitulo"><?php esc_html_e( 'Subtítulo', 'andrewp' ); ?></label></th>
				<td>
					<input type="text" id="trajetoria_subtitulo" name="trajetoria_subtitulo" class="large-text" value="<?php echo esc_attr( $subtitulo ); ?>" placeholder="Ex: Cooperação Acadêmica Internacional" />
				</td>
			</tr>
		</table>
		<p class="description">
			<?php esc_html_e( 'A descrição longa do resumo usa o campo "Corpo" (editor principal) do post.', 'andrewp' ); ?>
		</p>

		<hr />

		<h4><?php esc_html_e( 'Destaques (lista com ícone, título e descrição)', 'andrewp' ); ?></h4>
		<div id="andrewp-repeater-destaques" class="andrewp-repeater">
			<?php
			$total_destaques = max( count( $destaques_titulo ), 1 );
			for ( $i = 0; $i < $total_destaques; $i++ ) :
				$d_icone = isset( $destaques_icone[ $i ] ) ? $destaques_icone[ $i ] : '';
				$d_tit   = isset( $destaques_titulo[ $i ] ) ? $destaques_titulo[ $i ] : '';
				$d_desc  = isset( $destaques_descricao[ $i ] ) ? $destaques_descricao[ $i ] : '';
				?>
				<div class="andrewp-repeater__row">
					<select name="trajetoria_destaques_icone[]">
						<?php foreach ( $icones as $slug => $dados ) : ?>
							<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $d_icone, $slug ); ?>>
								<?php echo esc_html( $dados['label'] ); ?>
							</option>
						<?php endforeach; ?>
					</select>
					<input type="text" name="trajetoria_destaques_titulo[]" value="<?php echo esc_attr( $d_tit ); ?>" placeholder="<?php esc_attr_e( 'Título', 'andrewp' ); ?>" />
					<input type="text" name="trajetoria_destaques_descricao[]" value="<?php echo esc_attr( $d_desc ); ?>" placeholder="<?php esc_attr_e( 'Descrição', 'andrewp' ); ?>" />
					<button type="button" class="button andrewp-repeater__remove">&times;</button>
				</div>
			<?php endfor; ?>
		</div>
		<template id="andrewp-template-destaque">
			<div class="andrewp-repeater__row">
				<select name="trajetoria_destaques_icone[]">
					<?php foreach ( $icones as $slug => $dados ) : ?>
						<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $dados['label'] ); ?></option>
					<?php endforeach; ?>
				</select>
				<input type="text" name="trajetoria_destaques_titulo[]" placeholder="<?php esc_attr_e( 'Título', 'andrewp' ); ?>" />
				<input type="text" name="trajetoria_destaques_descricao[]" placeholder="<?php esc_attr_e( 'Descrição', 'andrewp' ); ?>" />
				<button type="button" class="button andrewp-repeater__remove">&times;</button>
			</div>
		</template>
		<button type="button" class="button" data-repeater-add="andrewp-repeater-destaques" data-repeater-template="andrewp-template-destaque">
			<?php esc_html_e( '+ Adicionar destaque', 'andrewp' ); ?>
		</button>

		<hr />

		<h4><?php esc_html_e( 'Artigo (texto completo, opcional)', 'andrewp' ); ?></h4>
		<?php
		wp_editor(
			get_post_meta( $post->ID, '_trajetoria_artigo_texto', true ),
			'trajetoria_artigo_texto',
			array(
				'textarea_name' => 'trajetoria_artigo_texto',
				'media_buttons' => false,
				'textarea_rows' => 8,
				'teeny'         => true,
			)
		);
		?>
		<p class="description"><?php esc_html_e( 'Preencha só se esta trajetória tiver um texto/artigo completo próprio.', 'andrewp' ); ?></p>

		<hr />

		<h4><?php esc_html_e( 'Galeria de imagens', 'andrewp' ); ?></h4>

		<p><strong><?php esc_html_e( 'Opção A — Upload (produção)', 'andrewp' ); ?></strong></p>
		<input type="hidden" id="trajetoria_galeria_ids" name="trajetoria_galeria_ids" value="<?php echo esc_attr( implode( ',', $galeria_ids ) ); ?>" />
		<div id="andrewp-galeria-preview" class="andrewp-galeria-preview">
			<?php foreach ( $galeria_ids as $img_id ) : ?>
				<div class="andrewp-galeria-preview__item" data-id="<?php echo esc_attr( $img_id ); ?>">
					<?php echo wp_get_attachment_image( $img_id, 'thumbnail' ); ?>
					<button type="button" class="andrewp-galeria-preview__remove">&times;</button>
				</div>
			<?php endforeach; ?>
		</div>
		<button type="button" class="button" id="andrewp-galeria-selecionar">
			<?php esc_html_e( '+ Selecionar imagens do computador', 'andrewp' ); ?>
		</button>

		<p style="margin-top:16px;"><strong><?php esc_html_e( 'Opção B — Links de imagem (teste/rascunho)', 'andrewp' ); ?></strong></p>
		<textarea name="trajetoria_galeria_urls" rows="4" class="large-text code" placeholder="https://exemplo.com/foto1.jpg&#10;https://exemplo.com/foto2.jpg"><?php echo esc_textarea( $galeria_urls_raw ); ?></textarea>
		<p class="description">
			<?php esc_html_e( 'Uma URL por linha. Útil para testar o modal sem precisar subir arquivos. Se preenchido, tem prioridade sobre o upload acima.', 'andrewp' ); ?>
		</p>

		<hr />

		<h4><?php esc_html_e( 'Documentos (PDFs e arquivos)', 'andrewp' ); ?></h4>
		<div id="andrewp-repeater-documentos" class="andrewp-repeater">
			<?php
			$total_docs = max( count( $doc_titulo ), 1 );
			for ( $i = 0; $i < $total_docs; $i++ ) :
				$dt = isset( $doc_titulo[ $i ] ) ? $doc_titulo[ $i ] : '';
				$dd = isset( $doc_descricao[ $i ] ) ? $doc_descricao[ $i ] : '';
				$da = isset( $doc_arquivo[ $i ] ) ? absint( $doc_arquivo[ $i ] ) : 0;
				$nome_arquivo = $da ? basename( get_attached_file( $da ) ) : '';
				?>
				<div class="andrewp-repeater__row andrewp-repeater__row--doc">
					<input type="text" name="trajetoria_doc_titulo[]" value="<?php echo esc_attr( $dt ); ?>" placeholder="<?php esc_attr_e( 'Título do documento', 'andrewp' ); ?>" />
					<input type="text" name="trajetoria_doc_descricao[]" value="<?php echo esc_attr( $dd ); ?>" placeholder="<?php esc_attr_e( 'Descrição curta', 'andrewp' ); ?>" />
					<input type="hidden" class="andrewp-doc-arquivo-id" name="trajetoria_doc_arquivo_id[]" value="<?php echo esc_attr( $da ); ?>" />
					<span class="andrewp-doc-arquivo-nome"><?php echo esc_html( $nome_arquivo ); ?></span>
					<button type="button" class="button andrewp-doc-selecionar"><?php esc_html_e( 'Selecionar arquivo', 'andrewp' ); ?></button>
					<button type="button" class="button andrewp-repeater__remove">&times;</button>
				</div>
			<?php endfor; ?>
		</div>
		<template id="andrewp-template-documento">
			<div class="andrewp-repeater__row andrewp-repeater__row--doc">
				<input type="text" name="trajetoria_doc_titulo[]" placeholder="<?php esc_attr_e( 'Título do documento', 'andrewp' ); ?>" />
				<input type="text" name="trajetoria_doc_descricao[]" placeholder="<?php esc_attr_e( 'Descrição curta', 'andrewp' ); ?>" />
				<input type="hidden" class="andrewp-doc-arquivo-id" name="trajetoria_doc_arquivo_id[]" value="" />
				<span class="andrewp-doc-arquivo-nome"></span>
				<button type="button" class="button andrewp-doc-selecionar"><?php esc_html_e( 'Selecionar arquivo', 'andrewp' ); ?></button>
				<button type="button" class="button andrewp-repeater__remove">&times;</button>
			</div>
		</template>
		<button type="button" class="button" data-repeater-add="andrewp-repeater-documentos" data-repeater-template="andrewp-template-documento">
			<?php esc_html_e( '+ Adicionar documento', 'andrewp' ); ?>
		</button>

		<hr />

		<h4><?php esc_html_e( 'Impacto desta trajetória (lista curta)', 'andrewp' ); ?></h4>
		<div id="andrewp-repeater-impacto" class="andrewp-repeater">
			<?php
			$total_impacto = max( count( $impacto ), 1 );
			for ( $i = 0; $i < $total_impacto; $i++ ) :
				$imp = isset( $impacto[ $i ] ) ? $impacto[ $i ] : '';
				?>
				<div class="andrewp-repeater__row">
					<input type="text" name="trajetoria_impacto[]" value="<?php echo esc_attr( $imp ); ?>" placeholder="<?php esc_attr_e( 'Ex: Internacionalização da produção científica', 'andrewp' ); ?>" style="flex:1;" />
					<button type="button" class="button andrewp-repeater__remove">&times;</button>
				</div>
			<?php endfor; ?>
		</div>
		<template id="andrewp-template-impacto">
			<div class="andrewp-repeater__row">
				<input type="text" name="trajetoria_impacto[]" placeholder="<?php esc_attr_e( 'Ex: Internacionalização da produção científica', 'andrewp' ); ?>" style="flex:1;" />
				<button type="button" class="button andrewp-repeater__remove">&times;</button>
			</div>
		</template>
		<button type="button" class="button" data-repeater-add="andrewp-repeater-impacto" data-repeater-template="andrewp-template-impacto">
			<?php esc_html_e( '+ Adicionar item de impacto', 'andrewp' ); ?>
		</button>

		<hr />

		<h4><?php esc_html_e( 'Botão externo (opcional)', 'andrewp' ); ?></h4>
		<table class="form-table">
			<tr>
				<th><label for="trajetoria_cta_texto"><?php esc_html_e( 'Texto do botão', 'andrewp' ); ?></label></th>
				<td>
					<input type="text" id="trajetoria_cta_texto" name="trajetoria_cta_texto" class="large-text" value="<?php echo esc_attr( $cta_texto ); ?>" placeholder="Ex: Ver mais detalhes" />
				</td>
			</tr>
			<tr>
				<th><label for="trajetoria_cta_url"><?php esc_html_e( 'Link', 'andrewp' ); ?></label></th>
				<td>
					<input type="url" id="trajetoria_cta_url" name="trajetoria_cta_url" class="large-text" value="<?php echo esc_attr( $cta_url ); ?>" placeholder="https://" />
				</td>
			</tr>
		</table>

	</div>
	<?php
}

/**
 * Salva todos os campos do metabox "Conteúdo do Modal".
 */
function andrewp_salvar_modal( $post_id ) {
	if ( ! isset( $_POST['andrewp_modal_nonce'] ) ||
		! wp_verify_nonce( $_POST['andrewp_modal_nonce'], 'andrewp_salvar_modal' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	update_post_meta( $post_id, '_trajetoria_badge_label', isset( $_POST['trajetoria_badge_label'] ) ? sanitize_text_field( wp_unslash( $_POST['trajetoria_badge_label'] ) ) : '' );
	update_post_meta( $post_id, '_trajetoria_icone', isset( $_POST['trajetoria_icone'] ) ? sanitize_key( $_POST['trajetoria_icone'] ) : '' );
	update_post_meta( $post_id, '_trajetoria_local', isset( $_POST['trajetoria_local'] ) ? sanitize_text_field( wp_unslash( $_POST['trajetoria_local'] ) ) : '' );
	update_post_meta( $post_id, '_trajetoria_subtitulo', isset( $_POST['trajetoria_subtitulo'] ) ? sanitize_text_field( wp_unslash( $_POST['trajetoria_subtitulo'] ) ) : '' );

	$d_icone = isset( $_POST['trajetoria_destaques_icone'] ) ? (array) $_POST['trajetoria_destaques_icone'] : array();
	$d_tit   = isset( $_POST['trajetoria_destaques_titulo'] ) ? (array) $_POST['trajetoria_destaques_titulo'] : array();
	$d_desc  = isset( $_POST['trajetoria_destaques_descricao'] ) ? (array) $_POST['trajetoria_destaques_descricao'] : array();

	$out_icone = array();
	$out_tit   = array();
	$out_desc  = array();
	foreach ( $d_tit as $i => $titulo ) {
		$titulo = sanitize_text_field( wp_unslash( $titulo ) );
		$desc   = isset( $d_desc[ $i ] ) ? sanitize_text_field( wp_unslash( $d_desc[ $i ] ) ) : '';
		if ( '' === $titulo && '' === $desc ) {
			continue;
		}
		$out_icone[] = isset( $d_icone[ $i ] ) ? sanitize_key( $d_icone[ $i ] ) : '';
		$out_tit[]   = $titulo;
		$out_desc[]  = $desc;
	}
	update_post_meta( $post_id, '_trajetoria_destaques_icone', $out_icone );
	update_post_meta( $post_id, '_trajetoria_destaques_titulo', $out_tit );
	update_post_meta( $post_id, '_trajetoria_destaques_descricao', $out_desc );

	// Galeria por upload.
	$galeria_raw = isset( $_POST['trajetoria_galeria_ids'] ) ? sanitize_text_field( wp_unslash( $_POST['trajetoria_galeria_ids'] ) ) : '';
	$galeria_ids = array_filter( array_map( 'absint', explode( ',', $galeria_raw ) ) );
	update_post_meta( $post_id, '_trajetoria_galeria', implode( ',', $galeria_ids ) );

	// NOVO: Galeria por URL (teste). Uma por linha, sanitizada como URL, linhas vazias descartadas.
	$galeria_urls_raw = isset( $_POST['trajetoria_galeria_urls'] ) ? wp_unslash( $_POST['trajetoria_galeria_urls'] ) : '';
	$linhas           = preg_split( '/[\r\n]+/', $galeria_urls_raw );
	$urls_limpas      = array();
	foreach ( (array) $linhas as $linha ) {
		$linha = trim( $linha );
		if ( '' === $linha ) {
			continue;
		}
		$url_valida = esc_url_raw( $linha );
		if ( $url_valida ) {
			$urls_limpas[] = $url_valida;
		}
	}
	update_post_meta( $post_id, '_trajetoria_galeria_urls', implode( "\n", $urls_limpas ) );

	$doc_tit  = isset( $_POST['trajetoria_doc_titulo'] ) ? (array) $_POST['trajetoria_doc_titulo'] : array();
	$doc_desc = isset( $_POST['trajetoria_doc_descricao'] ) ? (array) $_POST['trajetoria_doc_descricao'] : array();
	$doc_arq  = isset( $_POST['trajetoria_doc_arquivo_id'] ) ? (array) $_POST['trajetoria_doc_arquivo_id'] : array();

	$out_doc_tit  = array();
	$out_doc_desc = array();
	$out_doc_arq  = array();
	foreach ( $doc_tit as $i => $titulo ) {
		$titulo  = sanitize_text_field( wp_unslash( $titulo ) );
		$desc    = isset( $doc_desc[ $i ] ) ? sanitize_text_field( wp_unslash( $doc_desc[ $i ] ) ) : '';
		$arquivo = isset( $doc_arq[ $i ] ) ? absint( $doc_arq[ $i ] ) : 0;
		if ( '' === $titulo && ! $arquivo ) {
			continue;
		}
		$out_doc_tit[]  = $titulo;
		$out_doc_desc[] = $desc;
		$out_doc_arq[]  = $arquivo;
	}
	update_post_meta( $post_id, '_trajetoria_doc_titulo', $out_doc_tit );
	update_post_meta( $post_id, '_trajetoria_doc_descricao', $out_doc_desc );
	update_post_meta( $post_id, '_trajetoria_doc_arquivo_id', $out_doc_arq );

	$impacto_raw = isset( $_POST['trajetoria_impacto'] ) ? (array) $_POST['trajetoria_impacto'] : array();
	$impacto_out = array();
	foreach ( $impacto_raw as $texto ) {
		$texto = sanitize_text_field( wp_unslash( $texto ) );
		if ( '' !== $texto ) {
			$impacto_out[] = $texto;
		}
	}
	update_post_meta( $post_id, '_trajetoria_impacto', $impacto_out );

	update_post_meta( $post_id, '_trajetoria_artigo_texto', isset( $_POST['trajetoria_artigo_texto'] ) ? wp_kses_post( wp_unslash( $_POST['trajetoria_artigo_texto'] ) ) : '' );

	update_post_meta( $post_id, '_trajetoria_cta_texto', isset( $_POST['trajetoria_cta_texto'] ) ? sanitize_text_field( wp_unslash( $_POST['trajetoria_cta_texto'] ) ) : '' );
	update_post_meta( $post_id, '_trajetoria_cta_url', isset( $_POST['trajetoria_cta_url'] ) ? esc_url_raw( wp_unslash( $_POST['trajetoria_cta_url'] ) ) : '' );
}
add_action( 'save_post_trajetoria', 'andrewp_salvar_modal' );

/**
 * Handler do botão "Preencher com exemplo": grava os mesmos dados
 * do mock (Universidad Nacional Rosario Castellanos) direto no post,
 * usando URLs de imagem (Unsplash) em vez de exigir upload.
 */
function andrewp_seed_trajetoria_demo_handler() {
	$post_id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : 0;

	if ( ! $post_id || 'trajetoria' !== get_post_type( $post_id ) ) {
		wp_die( esc_html__( 'Post inválido.', 'andrewp' ) );
	}

	check_admin_referer( 'andrewp_seed_trajetoria_demo_' . $post_id );

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		wp_die( esc_html__( 'Sem permissão.', 'andrewp' ) );
	}

	update_post_meta( $post_id, '_trajetoria_badge_label', 'TRAJETÓRIA INTERNACIONAL' );
	update_post_meta( $post_id, '_trajetoria_icone', 'globo' );
	update_post_meta( $post_id, '_trajetoria_local', 'Rosario, Argentina' );
	update_post_meta( $post_id, '_trajetoria_subtitulo', 'Cooperação Acadêmica Internacional' );

	wp_update_post( array(
		'ID'           => $post_id,
		'post_content' => 'Apresentação de trabalho acadêmico e doação da coletânea Reflexões dos Economistas Baianos, incluindo capítulo de autoria sobre a evolução do microcrédito na Bahia (1973–2008).',
	) );

	update_post_meta( $post_id, '_trajetoria_destaques_icone', array( 'grupo', 'livro', 'lapis', 'grupo' ) );
	update_post_meta( $post_id, '_trajetoria_destaques_titulo', array(
		'Apresentação Acadêmica',
		'Doação Institucional',
		'Capítulo de Autoria',
		'Intercâmbio Acadêmico',
	) );
	update_post_meta( $post_id, '_trajetoria_destaques_descricao', array(
		'Apresentação de pesquisa sobre desenvolvimento regional e economia brasileira durante visita acadêmica à Universidad Nacional Rosario Castellanos.',
		'Entrega da coletânea Reflexões dos Economistas Baianos ao acervo da universidade.',
		'Análise da evolução do microcrédito na Bahia (1973–2008).',
		'Fortalecimento da cooperação e do intercâmbio entre instituições de ensino e pesquisa.',
	) );

	update_post_meta( $post_id, '_trajetoria_galeria_urls', implode( "\n", array(
		'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=800&q=80',
		'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&q=80',
		'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&q=80',
		'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=800&q=80',
	) ) );

	update_post_meta( $post_id, '_trajetoria_doc_titulo', array(
		'Coletânea doada',
		'Capítulo de autoria',
		'Comprovante de doação',
		'Apresentação do trabalho',
	) );
	update_post_meta( $post_id, '_trajetoria_doc_descricao', array(
		'Reflexões dos Economistas Baianos',
		'Análise da evolução do microcrédito na Bahia (1973–2008)',
		'Registro da entrega da obra à universidade',
		'Slides da apresentação acadêmica',
	) );
	update_post_meta( $post_id, '_trajetoria_doc_arquivo_id', array( 0, 0, 0, 0 ) );

	update_post_meta( $post_id, '_trajetoria_impacto', array(
		'Internacionalização da produção científica',
		'Difusão da pesquisa brasileira',
		'Cooperação entre instituições',
		'Fortalecimento do intercâmbio acadêmico latino-americano',
	) );

	update_post_meta( $post_id, '_trajetoria_cta_texto', 'Ver mais detalhes' );
	update_post_meta( $post_id, '_trajetoria_cta_url', 'https://www.rosario.gob.ar/' );

	wp_safe_redirect( add_query_arg( array( 'andrewp_seed_ok' => 1 ), get_edit_post_link( $post_id, 'raw' ) ) );
	exit;
}
add_action( 'admin_post_andrewp_seed_trajetoria_demo', 'andrewp_seed_trajetoria_demo_handler' );

/**
 * Carrega o JS/CSS do admin (repeaters + seletor de mídia).
 */
function andrewp_admin_assets_trajetoria( $hook ) {
	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}

	global $post;
	if ( ! $post || 'trajetoria' !== get_post_type( $post ) ) {
		return;
	}

	wp_enqueue_media();

	wp_enqueue_style(
		'andrewp-admin-trajetoria-modal',
		get_template_directory_uri() . '/trajetoria/admin-trajetoria-modal.css',
		array(),
		filemtime( get_template_directory() . '/trajetoria/admin-trajetoria-modal.css' )
	);

	wp_enqueue_script(
		'andrewp-admin-trajetoria-modal',
		get_template_directory_uri() . '/trajetoria/admin-trajetoria-modal.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/trajetoria/admin-trajetoria-modal.js' ),
		true
	);
}
add_action( 'admin_enqueue_scripts', 'andrewp_admin_assets_trajetoria' );