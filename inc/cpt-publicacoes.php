<?php
/**
 * CPT "Publicação" + taxonomia "Tipo de Publicação" + campos do Modal
 *
 * Registra o tipo de conteúdo usado pela página /publicacoes/
 * (publicacoes/content-lista-publicacoes.php) e todos os campos
 * personalizados que alimentam o card da lista e os modais "Ler
 * artigo" (publicacoes/modal-publicacao.php para Artigos/Revistas,
 * publicacoes/modal-publicacao-livro.php para Livros/Capítulos).
 *
 * Segue o mesmo padrão de inc/cpt-trajetoria.php.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Post Type: Publicação
 */
function andrewp_register_cpt_publicacao() {
	$labels = array(
		'name'                  => __( 'Publicações', 'andrewp' ),
		'singular_name'         => __( 'Publicação', 'andrewp' ),
		'menu_name'             => __( 'Publicações', 'andrewp' ),
		'add_new'               => __( 'Adicionar Nova', 'andrewp' ),
		'add_new_item'          => __( 'Adicionar Nova Publicação', 'andrewp' ),
		'edit_item'             => __( 'Editar Publicação', 'andrewp' ),
		'new_item'              => __( 'Nova Publicação', 'andrewp' ),
		'view_item'             => __( 'Ver Publicação', 'andrewp' ),
		'search_items'          => __( 'Buscar Publicações', 'andrewp' ),
		'not_found'             => __( 'Nenhuma publicação encontrada', 'andrewp' ),
		'not_found_in_trash'    => __( 'Nenhuma publicação na lixeira', 'andrewp' ),
		'all_items'             => __( 'Todas as Publicações', 'andrewp' ),
		'featured_image'        => __( 'Logo / capa da publicação', 'andrewp' ),
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
		'rewrite'            => array( 'slug' => 'publicacao' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 21,
		'menu_icon'          => 'dashicons-media-document',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'publicacao', $args );
}
add_action( 'init', 'andrewp_register_cpt_publicacao' );

/**
 * Taxonomia: Tipo de Publicação
 * (Artigos / Revistas / Livros / Capítulos de Livros — os 4 "tabs" do filtro)
 */
function andrewp_register_tax_tipo_publicacao() {
	$labels = array(
		'name'          => __( 'Tipos de Publicação', 'andrewp' ),
		'singular_name' => __( 'Tipo de Publicação', 'andrewp' ),
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
		'rewrite'           => array( 'slug' => 'tipo-publicacao' ),
	);

	register_taxonomy( 'tipo_publicacao', array( 'publicacao' ), $args );
}
add_action( 'init', 'andrewp_register_tax_tipo_publicacao' );

/**
 * Cria os 4 termos padrão (uma vez só), na ordem em que devem aparecer
 * nas abas do filtro: Artigos, Revistas, Livros, Capítulos de Livros.
 */
function andrewp_criar_termos_padrao_publicacao() {
	if ( get_option( 'andrewp_termos_publicacao_criados' ) ) {
		return;
	}

	$termos_padrao = array(
		'artigo'            => 'Artigos',
		'revista'           => 'Revistas',
		'livro'             => 'Livros',
		'capitulo-de-livro' => 'Capítulos de Livros',
	);

	foreach ( $termos_padrao as $slug => $nome ) {
		if ( ! term_exists( $slug, 'tipo_publicacao' ) ) {
			wp_insert_term( $nome, 'tipo_publicacao', array( 'slug' => $slug ) );
		}
	}

	update_option( 'andrewp_termos_publicacao_criados', 1 );
}
add_action( 'init', 'andrewp_criar_termos_padrao_publicacao', 20 );

/**
 * Slug -> label singular usado para montar o texto padrão do
 * selo "ARTIGO PUBLICADO" / "LIVRO PUBLICADO" etc. no modal, quando o
 * campo "Texto do selo" não é preenchido manualmente.
 */
function andrewp_publicacao_selo_padrao( $slug ) {
	$mapa = array(
		'artigo'            => __( 'Artigo Publicado', 'andrewp' ),
		'revista'           => __( 'Publicação em Revista', 'andrewp' ),
		'livro'             => __( 'Livro Publicado', 'andrewp' ),
		'capitulo-de-livro' => __( 'Capítulo de Livro', 'andrewp' ),
	);

	return isset( $mapa[ $slug ] ) ? $mapa[ $slug ] : __( 'Publicação', 'andrewp' );
}

/**
 * Devolve o termo (WP_Term) principal de "tipo_publicacao" de um post,
 * ou null se não houver nenhum definido.
 */
function andrewp_publicacao_termo_principal( $post_id ) {
	$termos = get_the_terms( $post_id, 'tipo_publicacao' );

	if ( empty( $termos ) || is_wp_error( $termos ) ) {
		return null;
	}

	return $termos[0];
}

/**
 * Slug do tipo -> palavra usada no botão da lista: "Ler artigo",
 * "Ler revista", "Ler livro", "Ler capítulo".
 */
function andrewp_publicacoes_verbo_ler( $slug ) {
	$mapa = array(
		'artigo'            => __( 'artigo', 'andrewp' ),
		'revista'           => __( 'publicação', 'andrewp' ),
		'livro'             => __( 'livro', 'andrewp' ),
		'capitulo-de-livro' => __( 'capítulo', 'andrewp' ),
	);

	return isset( $mapa[ $slug ] ) ? $mapa[ $slug ] : __( 'publicação', 'andrewp' );
}

/**
 * Diz se o slug do tipo de publicação é "livro" ou "capítulo de livro" —
 * usado para decidir (a) qual template de modal carregar
 * (publicacoes/modal-publicacao-livro.php) e (b) quais botões aparecem
 * (Solicitar exemplar / Baixar exemplar gratuitamente) em vez dos
 * botões de Artigo/Revista (Acessar publicação).
 */
function andrewp_publicacao_eh_livro( $slug ) {
	return in_array( $slug, array( 'livro', 'capitulo-de-livro' ), true );
}

/**
 * Sufixo do grupo de campos "exclusivos" (Artigo / Revista) usado para
 * montar as chaves de meta e ler/gravar o valor certo conforme o
 * "Tipo de Publicação" (taxonomia) do post. Livro/Capítulo já tinha seu
 * próprio conjunto de campos e não usa este sufixo.
 */
function andrewp_publicacao_sufixo_tipo( $slug ) {
	if ( 'artigo' === $slug ) {
		return '_artigo';
	}

	if ( 'revista' === $slug ) {
		return '_revista';
	}

	return '';
}

/**
 * Lê um campo "exclusivo" (banner, selo, publicado por, indicado para)
 * já considerando o Tipo de Publicação do post, com fallback para a
 * antiga chave genérica (sem sufixo) usada antes da separação por tipo —
 * mantém compatibilidade com publicações já cadastradas.
 *
 * Ex.: andrewp_publicacao_meta_por_tipo( $post_id, 'selo_texto' )
 */
function andrewp_publicacao_meta_por_tipo( $post_id, $campo ) {
	$termo   = andrewp_publicacao_termo_principal( $post_id );
	$slug    = $termo ? $termo->slug : '';
	$sufixo  = andrewp_publicacao_sufixo_tipo( $slug );
	$chave   = '_publicacao_' . $campo . $sufixo;
	$valor   = get_post_meta( $post_id, $chave, true );

	if ( '' === $valor && '' !== $sufixo ) {
		// Compatibilidade com publicações antigas, salvas antes de
		// existirem campos separados por tipo.
		$valor = get_post_meta( $post_id, '_publicacao_' . $campo, true );
	}

	return $valor;
}

/* =========================================================================
 * METABOX 1: "Detalhes da Publicação" — usado no card da lista
 * ========================================================================= */

function andrewp_metabox_publicacao_detalhes() {
	add_meta_box(
		'andrewp_publicacao_detalhes',
		__( 'Detalhes da Publicação', 'andrewp' ),
		'andrewp_metabox_publicacao_detalhes_html',
		'publicacao',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'andrewp_metabox_publicacao_detalhes' );

function andrewp_metabox_publicacao_detalhes_html( $post ) {
	wp_nonce_field( 'andrewp_salvar_publicacao_detalhes', 'andrewp_publicacao_detalhes_nonce' );

	$veiculo = get_post_meta( $post->ID, '_publicacao_veiculo_nome', true );
	$ano     = get_post_meta( $post->ID, '_publicacao_ano', true );
	$tipo_conteudo = get_post_meta( $post->ID, '_publicacao_tipo_conteudo', true );
	if ( '' === $tipo_conteudo ) {
		$tipo_conteudo = 'online';
	}
	?>
	<p>
		<label for="publicacao_veiculo_nome" style="display:block; font-weight:600; margin-bottom:4px;">
			<?php esc_html_e( 'Veículo / Revista', 'andrewp' ); ?>
		</label>
		<input type="text" id="publicacao_veiculo_nome" name="publicacao_veiculo_nome"
			value="<?php echo esc_attr( $veiculo ); ?>" style="width:100%;"
			placeholder="Ex: Revista da UNICAMP" />
		<span class="description"><?php esc_html_e( 'Aparece abaixo do título, no card da lista.', 'andrewp' ); ?></span>
	</p>
	<p>
		<label for="publicacao_ano" style="display:block; font-weight:600; margin-bottom:4px;">
			<?php esc_html_e( 'Ano exibido no card e no modal', 'andrewp' ); ?>
		</label>
		<input type="number" id="publicacao_ano" name="publicacao_ano" min="1900" max="2100" step="1"
			value="<?php echo esc_attr( $ano ); ?>"
			placeholder="<?php echo esc_attr( get_the_date( 'Y', $post ) ); ?>" style="width:100%;" />
		<span class="description"><?php esc_html_e( 'Deixe em branco para usar o ano da data de publicação. No modal de Livros/Capítulos, este é o "Ano" exibido na ficha técnica.', 'andrewp' ); ?></span>
	</p>
	<p>
		<label for="publicacao_tipo_conteudo" style="display:block; font-weight:600; margin-bottom:4px;">
			<?php esc_html_e( 'Tipo de publicação (modal)', 'andrewp' ); ?>
		</label>
		<select id="publicacao_tipo_conteudo" name="publicacao_tipo_conteudo" style="width:100%;">
			<option value="online" <?php selected( $tipo_conteudo, 'online' ); ?>><?php esc_html_e( 'Publicação Online', 'andrewp' ); ?></option>
			<option value="impressa" <?php selected( $tipo_conteudo, 'impressa' ); ?>><?php esc_html_e( 'Publicação Impressa', 'andrewp' ); ?></option>
			<option value="digital" <?php selected( $tipo_conteudo, 'digital' ); ?>><?php esc_html_e( 'Publicação Digital', 'andrewp' ); ?></option>
		</select>
	</p>
	<p class="description">
		<?php esc_html_e( 'Use o campo "Tipo de Publicação" (taxonomia, coluna ao lado) para definir se é Artigo, Revista, Livro ou Capítulo de Livro — é o que alimenta as abas do filtro, escolhe o layout do modal e qual bloco de "Campos exclusivos" abaixo será usado.', 'andrewp' ); ?>
	</p>
	<?php
}

function andrewp_salvar_publicacao_detalhes( $post_id ) {
	if ( ! isset( $_POST['andrewp_publicacao_detalhes_nonce'] ) ||
		! wp_verify_nonce( $_POST['andrewp_publicacao_detalhes_nonce'], 'andrewp_salvar_publicacao_detalhes' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	update_post_meta( $post_id, '_publicacao_veiculo_nome', isset( $_POST['publicacao_veiculo_nome'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_veiculo_nome'] ) ) : '' );

	if ( isset( $_POST['publicacao_ano'] ) && '' !== trim( $_POST['publicacao_ano'] ) ) {
		$ano = absint( $_POST['publicacao_ano'] );
		if ( $ano >= 1900 && $ano <= 2100 ) {
			update_post_meta( $post_id, '_publicacao_ano', $ano );
		}
	} else {
		delete_post_meta( $post_id, '_publicacao_ano' );
	}

	update_post_meta( $post_id, '_publicacao_tipo_conteudo', isset( $_POST['publicacao_tipo_conteudo'] ) ? sanitize_key( $_POST['publicacao_tipo_conteudo'] ) : 'online' );
}
add_action( 'save_post_publicacao', 'andrewp_salvar_publicacao_detalhes' );

/* =========================================================================
 * METABOX 2: "Conteúdo do Modal (Página de Publicações)" — tudo que
 * alimenta os modais "Ler artigo" / "Ler livro" exibidos em /publicacoes/
 *
 * Estrutura:
 * - Sobre o autor (compartilhado entre todos os tipos)
 * - Campos exclusivos de Artigo   (banner + selo + publicado por + indicado para)
 * - Campos exclusivos de Revista  (banner + selo + publicado por + indicado para)
 * - Campos exclusivos de Livro / Capítulo de Livro (banner + ficha técnica + evento)
 * - Texto de destaque final (compartilhado)
 * - Botões do modal (compartilhado)
 * ========================================================================= */

function andrewp_metabox_publicacao_modal() {
	add_meta_box(
		'andrewp_publicacao_modal',
		__( 'Conteúdo do Modal (Página de Publicações)', 'andrewp' ),
		'andrewp_metabox_publicacao_modal_html',
		'publicacao',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'andrewp_metabox_publicacao_modal' );

/**
 * Imprime um seletor de imagem (media picker) reutilizável, usado para
 * o banner de cada bloco de "Campos exclusivos" (Artigo / Revista / Livro)
 * e também para a imagem do selo de evento.
 */
function andrewp_publicacao_campo_imagem_html( $args ) {
	$defaults = array(
		'hidden_id'  => '',
		'hidden_name'=> '',
		'value_id'   => 0,
		'preview_id' => '',
		'select_id'  => '',
		'remove_id'  => '',
		'label'      => '',
		'description'=> '',
		'preview_size' => 'medium',
	);
	$args = wp_parse_args( $args, $defaults );
	?>
	<p>
		<?php if ( $args['label'] ) : ?>
			<label style="display:block; font-weight:600; margin-bottom:4px;"><?php echo esc_html( $args['label'] ); ?></label>
		<?php endif; ?>
		<input type="hidden" id="<?php echo esc_attr( $args['hidden_id'] ); ?>" name="<?php echo esc_attr( $args['hidden_name'] ); ?>" value="<?php echo esc_attr( $args['value_id'] ); ?>" />
		<span id="<?php echo esc_attr( $args['preview_id'] ); ?>" style="display:block; margin-bottom:8px;">
			<?php if ( $args['value_id'] ) : ?>
				<?php echo wp_get_attachment_image( $args['value_id'], $args['preview_size'] ); ?>
			<?php endif; ?>
		</span>
		<button type="button" class="button" id="<?php echo esc_attr( $args['select_id'] ); ?>">
			<?php esc_html_e( '+ Selecionar imagem do banner', 'andrewp' ); ?>
		</button>
		<button type="button" class="button" id="<?php echo esc_attr( $args['remove_id'] ); ?>" <?php echo $args['value_id'] ? '' : 'style="display:none;"'; ?>>
			<?php esc_html_e( 'Remover', 'andrewp' ); ?>
		</button>
		<?php if ( $args['description'] ) : ?>
			<span class="description" style="display:block; margin-top:4px;"><?php echo esc_html( $args['description'] ); ?></span>
		<?php endif; ?>
	</p>
	<?php
}

function andrewp_metabox_publicacao_modal_html( $post ) {
	wp_nonce_field( 'andrewp_salvar_publicacao_modal', 'andrewp_publicacao_modal_nonce' );

	// Autor (compartilhado).
	$autor_nome = get_post_meta( $post->ID, '_publicacao_autor_nome', true );
	if ( '' === $autor_nome ) {
		$autor_nome = 'Bruno Mota';
	}
	$autor_bio    = get_post_meta( $post->ID, '_publicacao_autor_bio', true );
	$autor_avatar = absint( get_post_meta( $post->ID, '_publicacao_autor_avatar_id', true ) );

	// Artigo (exclusivo).
	$banner_artigo_id      = absint( get_post_meta( $post->ID, '_publicacao_banner_artigo_id', true ) );
	$selo_texto_artigo     = get_post_meta( $post->ID, '_publicacao_selo_texto_artigo', true );
	$publicado_nome_artigo = get_post_meta( $post->ID, '_publicacao_publicado_por_nome_artigo', true );
	$publicado_data_artigo = get_post_meta( $post->ID, '_publicacao_publicado_por_data_artigo', true );
	$indicado_numero_artigo = get_post_meta( $post->ID, '_publicacao_indicado_numero_artigo', true );
	$indicado_texto_artigo  = get_post_meta( $post->ID, '_publicacao_indicado_texto_artigo', true );

	// Revista (exclusivo).
	$banner_revista_id      = absint( get_post_meta( $post->ID, '_publicacao_banner_revista_id', true ) );
	$selo_texto_revista     = get_post_meta( $post->ID, '_publicacao_selo_texto_revista', true );
	$publicado_nome_revista = get_post_meta( $post->ID, '_publicacao_publicado_por_nome_revista', true );
	$publicado_data_revista = get_post_meta( $post->ID, '_publicacao_publicado_por_data_revista', true );
	$indicado_numero_revista = get_post_meta( $post->ID, '_publicacao_indicado_numero_revista', true );
	$indicado_texto_revista  = get_post_meta( $post->ID, '_publicacao_indicado_texto_revista', true );

	// Livro / Capítulo de Livro (exclusivo).
	$banner_livro_id = absint( get_post_meta( $post->ID, '_publicacao_banner_livro_id', true ) );
	$subtitulo       = get_post_meta( $post->ID, '_publicacao_subtitulo', true );
	$organizadores   = get_post_meta( $post->ID, '_publicacao_organizadores', true );
	$editora         = get_post_meta( $post->ID, '_publicacao_editora', true );
	$paginas         = get_post_meta( $post->ID, '_publicacao_paginas', true );
	$isbn            = get_post_meta( $post->ID, '_publicacao_isbn', true );
	$evento_titulo   = get_post_meta( $post->ID, '_publicacao_evento_titulo', true );
	$evento_texto    = get_post_meta( $post->ID, '_publicacao_evento_texto', true );
	$evento_img_id   = absint( get_post_meta( $post->ID, '_publicacao_evento_imagem_id', true ) );

	// Compartilhados (independem do tipo).
	$texto_final  = get_post_meta( $post->ID, '_publicacao_texto_final', true );
	$cta_url      = get_post_meta( $post->ID, '_publicacao_cta_url', true );
	$whatsapp_url = get_post_meta( $post->ID, '_publicacao_whatsapp_url', true );
	if ( '' === $whatsapp_url ) {
		$whatsapp_url = 'https://wa.me/5571831168820';
	}
	$gratuito     = (bool) get_post_meta( $post->ID, '_publicacao_gratuito', true );
	$download_url = get_post_meta( $post->ID, '_publicacao_download_url', true );
	?>
	<div class="andrewp-modal-fields">

		<h4><?php esc_html_e( 'Resumo', 'andrewp' ); ?></h4>
		<p class="description">
			<?php esc_html_e( 'O texto do "Corpo" do post (editor principal, acima) é usado como resumo/descrição em todos os modais.', 'andrewp' ); ?>
		</p>

		<hr />

		<h4><?php esc_html_e( 'Sobre o autor', 'andrewp' ); ?></h4>
		<p class="description"><?php esc_html_e( 'Compartilhado por todos os tipos de publicação.', 'andrewp' ); ?></p>
		<table class="form-table">
			<tr>
				<th><label for="publicacao_autor_nome"><?php esc_html_e( 'Nome', 'andrewp' ); ?></label></th>
				<td><input type="text" id="publicacao_autor_nome" name="publicacao_autor_nome" class="large-text" value="<?php echo esc_attr( $autor_nome ); ?>" /></td>
			</tr>
			<tr>
				<th><label for="publicacao_autor_bio"><?php esc_html_e( 'Bio curta', 'andrewp' ); ?></label></th>
				<td><textarea id="publicacao_autor_bio" name="publicacao_autor_bio" class="large-text" rows="3" placeholder="Economista, Mestre e Doutorando em Desenvolvimento Regional e Urbano. Pesquisador em política econômica, indústria e finanças públicas."><?php echo esc_textarea( $autor_bio ); ?></textarea></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Foto', 'andrewp' ); ?></th>
				<td>
					<input type="hidden" id="publicacao_autor_avatar_id" name="publicacao_autor_avatar_id" value="<?php echo esc_attr( $autor_avatar ); ?>" />
					<div id="andrewp-publicacao-avatar-preview" style="margin-bottom:8px;">
						<?php if ( $autor_avatar ) : ?>
							<?php echo wp_get_attachment_image( $autor_avatar, 'thumbnail' ); ?>
						<?php endif; ?>
					</div>
					<button type="button" class="button" id="andrewp-publicacao-avatar-selecionar"><?php esc_html_e( '+ Selecionar foto', 'andrewp' ); ?></button>
				</td>
			</tr>
		</table>

		<hr style="border-top: 2px solid #c9962c; margin: 24px 0;" />

		<h4 class="andrewp-titulo-exclusivo"><?php esc_html_e( 'Campos exclusivos de Artigo', 'andrewp' ); ?></h4>
		<p class="description"><?php esc_html_e( 'Só são usados quando o "Tipo de Publicação" (taxonomia, coluna à direita) for Artigo.', 'andrewp' ); ?></p>

		<?php
		andrewp_publicacao_campo_imagem_html( array(
			'hidden_id'   => 'publicacao_banner_artigo_id',
			'hidden_name' => 'publicacao_banner_artigo_id',
			'value_id'    => $banner_artigo_id,
			'preview_id'  => 'andrewp-publicacao-banner-artigo-preview',
			'select_id'   => 'andrewp-publicacao-banner-artigo-selecionar',
			'remove_id'   => 'andrewp-publicacao-banner-artigo-remover',
			'label'       => __( 'Banner / Capa do modal (Artigo)', 'andrewp' ),
			'description' => __( 'Se vazio, usa a "Imagem destacada" (logo/capa) do post. É o banner de fundo do modal de Artigo.', 'andrewp' ),
		) );
		?>

		<p>
			<label for="publicacao_selo_texto_artigo" style="display:block; font-weight:600; margin-bottom:4px;"><?php esc_html_e( 'Selo do topo direito', 'andrewp' ); ?></label>
			<input type="text" id="publicacao_selo_texto_artigo" name="publicacao_selo_texto_artigo" class="large-text" value="<?php echo esc_attr( $selo_texto_artigo ); ?>" placeholder="Ex: Artigo Publicado" />
			<span class="description"><?php esc_html_e( 'Deixe em branco para gerar automaticamente a partir do Tipo de Publicação.', 'andrewp' ); ?></span>
		</p>

		<table class="form-table">
			<tr>
				<th><label for="publicacao_publicado_por_nome_artigo"><?php esc_html_e( 'Publicado por (nome)', 'andrewp' ); ?></label></th>
				<td><input type="text" id="publicacao_publicado_por_nome_artigo" name="publicacao_publicado_por_nome_artigo" class="large-text" value="<?php echo esc_attr( $publicado_nome_artigo ); ?>" placeholder="Ex: Rede Estação Democracia" /></td>
			</tr>
			<tr>
				<th><label for="publicacao_publicado_por_data_artigo"><?php esc_html_e( 'Publicado por (data, texto livre)', 'andrewp' ); ?></label></th>
				<td>
					<input type="text" id="publicacao_publicado_por_data_artigo" name="publicacao_publicado_por_data_artigo" class="large-text" value="<?php echo esc_attr( $publicado_data_artigo ); ?>" placeholder="<?php echo esc_attr( get_the_date( 'd \d\e F \d\e Y', $post ) ); ?>" />
					<span class="description"><?php esc_html_e( 'Deixe em branco para usar a data de publicação do post.', 'andrewp' ); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="publicacao_indicado_numero_artigo"><?php esc_html_e( 'Conteúdo indicado para (número / selo)', 'andrewp' ); ?></label></th>
				<td><input type="text" id="publicacao_indicado_numero_artigo" name="publicacao_indicado_numero_artigo" value="<?php echo esc_attr( $indicado_numero_artigo ); ?>" placeholder="99" /></td>
			</tr>
			<tr>
				<th><label for="publicacao_indicado_texto_artigo"><?php esc_html_e( 'Conteúdo indicado para (texto)', 'andrewp' ); ?></label></th>
				<td><textarea id="publicacao_indicado_texto_artigo" name="publicacao_indicado_texto_artigo" class="large-text" rows="2" placeholder="Estudantes, pesquisadores e profissionais interessados em entender a política econômica do Brasil."><?php echo esc_textarea( $indicado_texto_artigo ); ?></textarea></td>
			</tr>
		</table>

		<hr style="border-top: 2px solid #c9962c; margin: 24px 0;" />

		<h4 class="andrewp-titulo-exclusivo"><?php esc_html_e( 'Campos exclusivos de Revista', 'andrewp' ); ?></h4>
		<p class="description"><?php esc_html_e( 'Só são usados quando o "Tipo de Publicação" (taxonomia, coluna à direita) for Revista.', 'andrewp' ); ?></p>

		<?php
		andrewp_publicacao_campo_imagem_html( array(
			'hidden_id'   => 'publicacao_banner_revista_id',
			'hidden_name' => 'publicacao_banner_revista_id',
			'value_id'    => $banner_revista_id,
			'preview_id'  => 'andrewp-publicacao-banner-revista-preview',
			'select_id'   => 'andrewp-publicacao-banner-revista-selecionar',
			'remove_id'   => 'andrewp-publicacao-banner-revista-remover',
			'label'       => __( 'Banner / Capa do modal (Revista)', 'andrewp' ),
			'description' => __( 'Se vazio, usa a "Imagem destacada" (logo/capa) do post. É o banner de fundo do modal de Revista.', 'andrewp' ),
		) );
		?>

		<p>
			<label for="publicacao_selo_texto_revista" style="display:block; font-weight:600; margin-bottom:4px;"><?php esc_html_e( 'Selo do topo direito', 'andrewp' ); ?></label>
			<input type="text" id="publicacao_selo_texto_revista" name="publicacao_selo_texto_revista" class="large-text" value="<?php echo esc_attr( $selo_texto_revista ); ?>" placeholder="Ex: Publicação em Revista" />
			<span class="description"><?php esc_html_e( 'Deixe em branco para gerar automaticamente a partir do Tipo de Publicação.', 'andrewp' ); ?></span>
		</p>

		<table class="form-table">
			<tr>
				<th><label for="publicacao_publicado_por_nome_revista"><?php esc_html_e( 'Publicado por (nome)', 'andrewp' ); ?></label></th>
				<td><input type="text" id="publicacao_publicado_por_nome_revista" name="publicacao_publicado_por_nome_revista" class="large-text" value="<?php echo esc_attr( $publicado_nome_revista ); ?>" placeholder="Ex: Revista da UNICAMP" /></td>
			</tr>
			<tr>
				<th><label for="publicacao_publicado_por_data_revista"><?php esc_html_e( 'Publicado por (data, texto livre)', 'andrewp' ); ?></label></th>
				<td>
					<input type="text" id="publicacao_publicado_por_data_revista" name="publicacao_publicado_por_data_revista" class="large-text" value="<?php echo esc_attr( $publicado_data_revista ); ?>" placeholder="<?php echo esc_attr( get_the_date( 'd \d\e F \d\e Y', $post ) ); ?>" />
					<span class="description"><?php esc_html_e( 'Deixe em branco para usar a data de publicação do post.', 'andrewp' ); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="publicacao_indicado_numero_revista"><?php esc_html_e( 'Conteúdo indicado para (número / selo)', 'andrewp' ); ?></label></th>
				<td><input type="text" id="publicacao_indicado_numero_revista" name="publicacao_indicado_numero_revista" value="<?php echo esc_attr( $indicado_numero_revista ); ?>" placeholder="99" /></td>
			</tr>
			<tr>
				<th><label for="publicacao_indicado_texto_revista"><?php esc_html_e( 'Conteúdo indicado para (texto)', 'andrewp' ); ?></label></th>
				<td><textarea id="publicacao_indicado_texto_revista" name="publicacao_indicado_texto_revista" class="large-text" rows="2" placeholder="Estudantes, pesquisadores e profissionais interessados em entender a política econômica do Brasil."><?php echo esc_textarea( $indicado_texto_revista ); ?></textarea></td>
			</tr>
		</table>

		<hr style="border-top: 2px solid #c9962c; margin: 24px 0;" />

		<h4 class="andrewp-titulo-exclusivo"><?php esc_html_e( 'Campos exclusivos de Livro / Capítulo de Livro', 'andrewp' ); ?></h4>
		<p class="description">
			<?php esc_html_e( 'Só são usados quando o "Tipo de Publicação" (taxonomia, coluna à direita) for Livro ou Capítulo de Livro — nesse caso o modal usa um layout diferente (capa + ficha técnica), com estes dados.', 'andrewp' ); ?>
		</p>

		<?php
		andrewp_publicacao_campo_imagem_html( array(
			'hidden_id'   => 'publicacao_banner_livro_id',
			'hidden_name' => 'publicacao_banner_livro_id',
			'value_id'    => $banner_livro_id,
			'preview_id'  => 'andrewp-publicacao-banner-livro-preview',
			'select_id'   => 'andrewp-publicacao-banner-livro-selecionar',
			'remove_id'   => 'andrewp-publicacao-banner-livro-remover',
			'label'       => __( 'Banner / Capa do modal (Livro / Capítulo)', 'andrewp' ),
			'description' => __( 'Se vazio, usa a "Imagem destacada" (logo/capa) do post. É a capa do livro exibida à esquerda no modal.', 'andrewp' ),
		) );
		?>

		<table class="form-table">
			<tr>
				<th><label for="publicacao_subtitulo"><?php esc_html_e( 'Subtítulo', 'andrewp' ); ?></label></th>
				<td>
					<input type="text" id="publicacao_subtitulo" name="publicacao_subtitulo" class="large-text" value="<?php echo esc_attr( $subtitulo ); ?>" placeholder="Ex: O papel do RH na promoção da saúde integral nas organizações" />
					<p class="description"><?php esc_html_e( 'Linha dourada logo abaixo do título.', 'andrewp' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="publicacao_organizadores"><?php esc_html_e( 'Organizadores(as) / Autores', 'andrewp' ); ?></label></th>
				<td><input type="text" id="publicacao_organizadores" name="publicacao_organizadores" class="large-text" value="<?php echo esc_attr( $organizadores ); ?>" placeholder="Ex: Organizadoras: Sueli Coelho e Marcely Santos" /></td>
			</tr>
			<tr>
				<th><label for="publicacao_editora"><?php esc_html_e( 'Editora', 'andrewp' ); ?></label></th>
				<td><input type="text" id="publicacao_editora" name="publicacao_editora" class="large-text" value="<?php echo esc_attr( $editora ); ?>" placeholder="Ex: BK Books" /></td>
			</tr>
			<tr>
				<th><label for="publicacao_paginas"><?php esc_html_e( 'Páginas', 'andrewp' ); ?></label></th>
				<td><input type="text" id="publicacao_paginas" name="publicacao_paginas" value="<?php echo esc_attr( $paginas ); ?>" placeholder="Ex: 328" /></td>
			</tr>
			<tr>
				<th><label for="publicacao_isbn"><?php esc_html_e( 'ISBN', 'andrewp' ); ?></label></th>
				<td><input type="text" id="publicacao_isbn" name="publicacao_isbn" class="large-text" value="<?php echo esc_attr( $isbn ); ?>" placeholder="Ex: 978-65-85556-02-1" /></td>
			</tr>
		</table>

		<h5 style="margin-top:20px;"><?php esc_html_e( 'Selo de evento (opcional)', 'andrewp' ); ?></h5>
		<p class="description"><?php esc_html_e( 'Ex: caixa "Apresentação na Bienal do Livro Bahia 2026". Deixe os campos vazios para não exibir essa caixa.', 'andrewp' ); ?></p>
		<table class="form-table">
			<tr>
				<th><label for="publicacao_evento_titulo"><?php esc_html_e( 'Título do evento', 'andrewp' ); ?></label></th>
				<td><input type="text" id="publicacao_evento_titulo" name="publicacao_evento_titulo" class="large-text" value="<?php echo esc_attr( $evento_titulo ); ?>" placeholder="Ex: Apresentação na Bienal do Livro Bahia 2026" /></td>
			</tr>
			<tr>
				<th><label for="publicacao_evento_texto"><?php esc_html_e( 'Texto do evento', 'andrewp' ); ?></label></th>
				<td><textarea id="publicacao_evento_texto" name="publicacao_evento_texto" class="large-text" rows="2" placeholder="Ex: Este capítulo faz parte da coletânea apresentada por Bruno Mota na Bienal do Livro Bahia 2026, um dos maiores eventos literários do país."><?php echo esc_textarea( $evento_texto ); ?></textarea></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Logo / selo do evento', 'andrewp' ); ?></th>
				<td>
					<input type="hidden" id="publicacao_evento_imagem_id" name="publicacao_evento_imagem_id" value="<?php echo esc_attr( $evento_img_id ); ?>" />
					<div id="andrewp-publicacao-evento-imagem-preview" style="margin-bottom:8px;">
						<?php if ( $evento_img_id ) : ?>
							<?php echo wp_get_attachment_image( $evento_img_id, 'thumbnail' ); ?>
						<?php endif; ?>
					</div>
					<button type="button" class="button" id="andrewp-publicacao-evento-imagem-selecionar"><?php esc_html_e( '+ Selecionar imagem', 'andrewp' ); ?></button>
					<button type="button" class="button" id="andrewp-publicacao-evento-imagem-remover" <?php echo $evento_img_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'Remover', 'andrewp' ); ?></button>
				</td>
			</tr>
		</table>

		<hr style="border-top: 2px solid #c9962c; margin: 24px 0;" />

		<h4><?php esc_html_e( 'Texto de destaque final', 'andrewp' ); ?></h4>
		<p class="description"><?php esc_html_e( 'Compartilhado por todos os tipos de publicação.', 'andrewp' ); ?></p>
		<textarea id="publicacao_texto_final" name="publicacao_texto_final" class="large-text" rows="2" placeholder="Ex: Garanta seu exemplar e conheça essa importante contribuição para o debate sobre saúde financeira e capital humano."><?php echo esc_textarea( $texto_final ); ?></textarea>
		<p class="description"><?php esc_html_e( 'Aparece como uma citação em destaque, acima dos botões.', 'andrewp' ); ?></p>

		<hr />

		<h4><?php esc_html_e( 'Botões do modal', 'andrewp' ); ?></h4>
		<p class="description">
			<?php esc_html_e( 'Artigos e Revistas usam sempre "Acessar publicação" + "Falar com o autor". Para Livros e Capítulos de Livro, o botão principal muda conforme "Livro/capítulo gratuito?" abaixo:', 'andrewp' ); ?>
			<br />
			&bull; <?php esc_html_e( 'Desmarcado (pago): "Solicitar exemplar" (usa o Link do botão principal) + "Falar com o autor".', 'andrewp' ); ?>
			<br />
			&bull; <?php esc_html_e( 'Marcado (gratuito): "Baixar exemplar gratuitamente" (usa o Link de download) + "Acessar publicação" (usa o Link do botão principal).', 'andrewp' ); ?>
		</p>
		<table class="form-table">
			<tr>
				<th><label for="publicacao_cta_url"><?php esc_html_e( 'Link do botão principal (Acessar publicação / Solicitar exemplar)', 'andrewp' ); ?></label></th>
				<td><input type="url" id="publicacao_cta_url" name="publicacao_cta_url" class="large-text" value="<?php echo esc_attr( $cta_url ); ?>" placeholder="https://" /></td>
			</tr>
			<tr>
				<th><label for="publicacao_whatsapp_url"><?php esc_html_e( 'Link "Falar com Bruno Mota"', 'andrewp' ); ?></label></th>
				<td><input type="url" id="publicacao_whatsapp_url" name="publicacao_whatsapp_url" class="large-text" value="<?php echo esc_attr( $whatsapp_url ); ?>" /></td>
			</tr>
			<tr>
				<th><label for="publicacao_gratuito"><?php esc_html_e( 'Livro/capítulo gratuito?', 'andrewp' ); ?></label></th>
				<td>
					<label>
						<input type="checkbox" id="publicacao_gratuito" name="publicacao_gratuito" value="1" <?php checked( $gratuito, true ); ?> />
						<?php esc_html_e( 'Marque para trocar "Solicitar exemplar" por "Baixar exemplar gratuitamente" + "Acessar publicação". Só tem efeito em Livros e Capítulos de Livro.', 'andrewp' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th><label for="publicacao_download_url"><?php esc_html_e( 'Link de download gratuito', 'andrewp' ); ?></label></th>
				<td>
					<input type="url" id="publicacao_download_url" name="publicacao_download_url" class="large-text" value="<?php echo esc_attr( $download_url ); ?>" placeholder="https://" />
					<span class="description"><?php esc_html_e( 'Usado no botão "Baixar exemplar gratuitamente" quando marcado acima.', 'andrewp' ); ?></span>
				</td>
			</tr>
		</table>

	</div>
	<?php
}

function andrewp_salvar_publicacao_modal( $post_id ) {
	if ( ! isset( $_POST['andrewp_publicacao_modal_nonce'] ) ||
		! wp_verify_nonce( $_POST['andrewp_publicacao_modal_nonce'], 'andrewp_salvar_publicacao_modal' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Sobre o autor (compartilhado).
	update_post_meta( $post_id, '_publicacao_autor_nome', isset( $_POST['publicacao_autor_nome'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_autor_nome'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_autor_bio', isset( $_POST['publicacao_autor_bio'] ) ? sanitize_textarea_field( wp_unslash( $_POST['publicacao_autor_bio'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_autor_avatar_id', isset( $_POST['publicacao_autor_avatar_id'] ) ? absint( $_POST['publicacao_autor_avatar_id'] ) : 0 );

	// Campos exclusivos de Artigo.
	update_post_meta( $post_id, '_publicacao_banner_artigo_id', isset( $_POST['publicacao_banner_artigo_id'] ) ? absint( $_POST['publicacao_banner_artigo_id'] ) : 0 );
	update_post_meta( $post_id, '_publicacao_selo_texto_artigo', isset( $_POST['publicacao_selo_texto_artigo'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_selo_texto_artigo'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_publicado_por_nome_artigo', isset( $_POST['publicacao_publicado_por_nome_artigo'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_publicado_por_nome_artigo'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_publicado_por_data_artigo', isset( $_POST['publicacao_publicado_por_data_artigo'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_publicado_por_data_artigo'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_indicado_numero_artigo', isset( $_POST['publicacao_indicado_numero_artigo'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_indicado_numero_artigo'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_indicado_texto_artigo', isset( $_POST['publicacao_indicado_texto_artigo'] ) ? sanitize_textarea_field( wp_unslash( $_POST['publicacao_indicado_texto_artigo'] ) ) : '' );

	// Campos exclusivos de Revista.
	update_post_meta( $post_id, '_publicacao_banner_revista_id', isset( $_POST['publicacao_banner_revista_id'] ) ? absint( $_POST['publicacao_banner_revista_id'] ) : 0 );
	update_post_meta( $post_id, '_publicacao_selo_texto_revista', isset( $_POST['publicacao_selo_texto_revista'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_selo_texto_revista'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_publicado_por_nome_revista', isset( $_POST['publicacao_publicado_por_nome_revista'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_publicado_por_nome_revista'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_publicado_por_data_revista', isset( $_POST['publicacao_publicado_por_data_revista'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_publicado_por_data_revista'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_indicado_numero_revista', isset( $_POST['publicacao_indicado_numero_revista'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_indicado_numero_revista'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_indicado_texto_revista', isset( $_POST['publicacao_indicado_texto_revista'] ) ? sanitize_textarea_field( wp_unslash( $_POST['publicacao_indicado_texto_revista'] ) ) : '' );

	// Campos exclusivos de Livro / Capítulo de Livro.
	update_post_meta( $post_id, '_publicacao_banner_livro_id', isset( $_POST['publicacao_banner_livro_id'] ) ? absint( $_POST['publicacao_banner_livro_id'] ) : 0 );
	update_post_meta( $post_id, '_publicacao_subtitulo', isset( $_POST['publicacao_subtitulo'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_subtitulo'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_organizadores', isset( $_POST['publicacao_organizadores'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_organizadores'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_editora', isset( $_POST['publicacao_editora'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_editora'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_paginas', isset( $_POST['publicacao_paginas'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_paginas'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_isbn', isset( $_POST['publicacao_isbn'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_isbn'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_evento_titulo', isset( $_POST['publicacao_evento_titulo'] ) ? sanitize_text_field( wp_unslash( $_POST['publicacao_evento_titulo'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_evento_texto', isset( $_POST['publicacao_evento_texto'] ) ? sanitize_textarea_field( wp_unslash( $_POST['publicacao_evento_texto'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_evento_imagem_id', isset( $_POST['publicacao_evento_imagem_id'] ) ? absint( $_POST['publicacao_evento_imagem_id'] ) : 0 );

	// Compartilhados.
	update_post_meta( $post_id, '_publicacao_texto_final', isset( $_POST['publicacao_texto_final'] ) ? sanitize_textarea_field( wp_unslash( $_POST['publicacao_texto_final'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_cta_url', isset( $_POST['publicacao_cta_url'] ) ? esc_url_raw( wp_unslash( $_POST['publicacao_cta_url'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_whatsapp_url', isset( $_POST['publicacao_whatsapp_url'] ) ? esc_url_raw( wp_unslash( $_POST['publicacao_whatsapp_url'] ) ) : '' );
	update_post_meta( $post_id, '_publicacao_gratuito', isset( $_POST['publicacao_gratuito'] ) ? 1 : 0 );
	update_post_meta( $post_id, '_publicacao_download_url', isset( $_POST['publicacao_download_url'] ) ? esc_url_raw( wp_unslash( $_POST['publicacao_download_url'] ) ) : '' );
}
add_action( 'save_post_publicacao', 'andrewp_salvar_publicacao_modal' );

/**
 * Carrega o media picker (seletor de imagens) nos campos de banner/avatar/
 * evento da tela de edição de Publicação, e trava a metabox "Conteúdo do
 * Modal (Página de Publicações)" sempre aberta (sem botão de recolher).
 */
function andrewp_admin_assets_publicacao( $hook ) {
	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}

	global $post;
	if ( ! $post || 'publicacao' !== get_post_type( $post ) ) {
		return;
	}

	wp_enqueue_media();

	wp_add_inline_script( 'jquery-core', andrewp_publicacao_admin_inline_js(), 'after' );
	wp_add_inline_style( 'common', andrewp_publicacao_admin_inline_css() );
}
add_action( 'admin_enqueue_scripts', 'andrewp_admin_assets_publicacao' );

/**
 * CSS: esconde o botão/ícone de recolher (toggle) do cabeçalho da
 * metabox "Conteúdo do Modal (Página de Publicações)", para ela ficar
 * sempre visível e não poder ser fechada acidentalmente — e aplica um
 * destaque visual (navy + dourado) para diferenciá-la das demais caixas.
 */
function andrewp_publicacao_admin_inline_css() {
	ob_start();
	?>
	:root {
		--andrewp-navy-950: #0a0f1c;
		--andrewp-navy-900: #0b0f1e;
		--andrewp-gold: #c9962c;
		--andrewp-gold-accent: #f5a623;
		--andrewp-gold-hover: #e0951a;
		--andrewp-text-light: #ffffff;
		--andrewp-text-soft: #f4efe4;
		--andrewp-text-muted: #b7bdcc;
		--andrewp-text-soft-light: #e0e0e0;
	}

	/* Destaque geral da caixa "Conteúdo do Modal (Página de Publicações)" */
	#andrewp_publicacao_modal {
		border: 1px solid var(--andrewp-gold);
		border-radius: 6px;
		box-shadow: 0 0 0 1px rgba(201, 150, 44, 0.25), 0 4px 14px rgba(10, 15, 28, 0.35);
		overflow: hidden;
	}

	/* Cabeçalho em navy */
	#andrewp_publicacao_modal .postbox-header {
		background: linear-gradient(135deg, var(--andrewp-navy-950) 0%, var(--andrewp-navy-900) 100%);
		display: flex !important;
		align-items: center;
		justify-content: center;
		min-height: 52px;
		height: auto !important;
	}

	#andrewp_publicacao_modal .hndle {
		background: transparent !important;
		cursor: default !important;
		display: flex !important;
		align-items: center;
		justify-content: center;
		width: 100%;
		float: none !important;
		margin: 0 !important;
		padding: 12px 16px !important;
		line-height: 1.4 !important;
		height: auto !important;
		min-height: 0 !important;
	}

	#andrewp_publicacao_modal .hndle,
	#andrewp_publicacao_modal .hndle span,
	#andrewp_publicacao_modal .postbox-header h2 {
		color: var(--andrewp-text-soft) !important;
		font-weight: 600;
		font-size: 14px;
		letter-spacing: 0.2px;
		text-align: center;
	}

	/* Esconde o botão/ícone de recolher (toggle) desta metabox específica */
	#andrewp_publicacao_modal .postbox-header .handle-actions,
	#andrewp_publicacao_modal .hndle .toggle-indicator,
	#andrewp_publicacao_modal button.handlediv {
		display: none !important;
	}

	#andrewp_publicacao_modal.closed .inside {
		display: block !important;
	}

	/* Subtítulos (h4) dentro da caixa ganham um toque dourado */
	#andrewp_publicacao_modal .inside h4 {
		color: var(--andrewp-navy-950);
		border-left: 3px solid var(--andrewp-gold);
		padding-left: 8px;
	}

	/* Títulos "Campos exclusivos de ..." ganham destaque extra */
	#andrewp_publicacao_modal .inside h4.andrewp-titulo-exclusivo {
		background: rgba(201, 150, 44, 0.08);
		padding: 8px 8px 8px 10px;
		border-left: 4px solid var(--andrewp-gold);
		font-size: 15px;
	}

	/* Trava a metabox "Detalhes da Publicação" sempre aberta e sem setas de mover/recolher */
	#andrewp_publicacao_detalhes .postbox-header .handle-actions,
	#andrewp_publicacao_detalhes .hndle .toggle-indicator,
	#andrewp_publicacao_detalhes button.handlediv {
		display: none !important;
	}
	#andrewp_publicacao_detalhes .postbox-header,
	#andrewp_publicacao_detalhes .hndle {
		cursor: default !important;
	}
	#andrewp_publicacao_detalhes.closed .inside {
		display: block !important;
	}
	<?php
	return ob_get_clean();
}

/**
 * JS: garante que a metabox "Conteúdo do Modal (Página de Publicações)"
 * nunca fique com a classe "closed" (recolhida) e impede o clique de
 * recolher, mesmo que o postbox.js do WordPress tente alternar o estado.
 * Também liga o media picker (wp.media) aos três banners exclusivos
 * (Artigo / Revista / Livro), ao avatar do autor e à imagem do evento.
 */
function andrewp_publicacao_admin_inline_js() {
	ob_start();
	?>
	jQuery(function ($) {
		function bindMediaField(buttonId, hiddenId, previewId, removeId) {
			var frame;
			$(document).on('click', '#' + buttonId, function (e) {
				e.preventDefault();
				if (frame) { frame.open(); return; }
				frame = wp.media({ title: 'Selecionar imagem', multiple: false });
				frame.on('select', function () {
					var att = frame.state().get('selection').first().toJSON();
					$('#' + hiddenId).val(att.id);
					$('#' + previewId).html('<img src="' + (att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url) + '" style="max-width:150px;height:auto;" />');
					if (removeId) { $('#' + removeId).show(); }
				});
				frame.open();
			});
			if (removeId) {
				$(document).on('click', '#' + removeId, function (e) {
					e.preventDefault();
					$('#' + hiddenId).val('');
					$('#' + previewId).empty();
					$(this).hide();
				});
			}
		}

		// Banners exclusivos por tipo de publicação.
		bindMediaField('andrewp-publicacao-banner-artigo-selecionar', 'publicacao_banner_artigo_id', 'andrewp-publicacao-banner-artigo-preview', 'andrewp-publicacao-banner-artigo-remover');
		bindMediaField('andrewp-publicacao-banner-revista-selecionar', 'publicacao_banner_revista_id', 'andrewp-publicacao-banner-revista-preview', 'andrewp-publicacao-banner-revista-remover');
		bindMediaField('andrewp-publicacao-banner-livro-selecionar', 'publicacao_banner_livro_id', 'andrewp-publicacao-banner-livro-preview', 'andrewp-publicacao-banner-livro-remover');

		// Avatar do autor e imagem do selo de evento.
		bindMediaField('andrewp-publicacao-avatar-selecionar', 'publicacao_autor_avatar_id', 'andrewp-publicacao-avatar-preview', null);
		bindMediaField('andrewp-publicacao-evento-imagem-selecionar', 'publicacao_evento_imagem_id', 'andrewp-publicacao-evento-imagem-preview', 'andrewp-publicacao-evento-imagem-remover');

		// Trava a metabox "Conteúdo do Modal (Página de Publicações)" sempre aberta.
		var $modalBox = $('#andrewp_publicacao_modal');

		function manterAberta() {
			$modalBox.removeClass('closed');
			$modalBox.find('.inside').show();
			$modalBox.find('.hndle, .postbox-header').attr('aria-expanded', 'true');
		}

		// Estado inicial (caso o WP já tenha salvo como fechada em "Preferências de tela").
		manterAberta();

		// Impede que o clique no cabeçalho (que normalmente recolhe/expande)
		// tenha efeito nesta metabox específica.
		$modalBox.find('.hndle, .handlediv, .postbox-header').on('click.andrewpTrava', function (e) {
			e.stopImmediatePropagation();
			e.preventDefault();
			manterAberta();
			return false;
		});

		// Segurança extra: se algo mudar a classe via JS do próprio WP,
		// devolve para o estado aberto logo em seguida.
		var observer = new MutationObserver(manterAberta);
		observer.observe($modalBox.get(0), { attributes: true, attributeFilter: ['class'] });

		// Trava a metabox "Detalhes da Publicação" (lateral) sempre aberta.
		var $detalhesBox = $('#andrewp_publicacao_detalhes');

		function manterDetalhesAberta() {
			$detalhesBox.removeClass('closed');
			$detalhesBox.find('.inside').show();
			$detalhesBox.find('.hndle, .postbox-header').attr('aria-expanded', 'true');
		}

		manterDetalhesAberta();

		$detalhesBox.find('.hndle, .handlediv, .postbox-header').on('click.andrewpTrava', function (e) {
			e.stopImmediatePropagation();
			e.preventDefault();
			manterDetalhesAberta();
			return false;
		});

		var observerDetalhes = new MutationObserver(manterDetalhesAberta);
		observerDetalhes.observe($detalhesBox.get(0), { attributes: true, attributeFilter: ['class'] });

		// Trava a metabox "Tipos" (taxonomia tipo_publicacao) sempre aberta.
		var $tiposBox = $('#tipo_publicacaodiv');

		function manterTiposAberta() {
			$tiposBox.removeClass('closed');
			$tiposBox.find('.inside').show();
			$tiposBox.find('.hndle, .postbox-header').attr('aria-expanded', 'true');
		}

		if ($tiposBox.length) {
			manterTiposAberta();

			$tiposBox.find('.hndle, .handlediv, .postbox-header').on('click.andrewpTrava', function (e) {
				e.stopImmediatePropagation();
				e.preventDefault();
				manterTiposAberta();
				return false;
			});

			var observerTipos = new MutationObserver(manterTiposAberta);
			observerTipos.observe($tiposBox.get(0), { attributes: true, attributeFilter: ['class'] });
		}
	});
	<?php
	return ob_get_clean();
}