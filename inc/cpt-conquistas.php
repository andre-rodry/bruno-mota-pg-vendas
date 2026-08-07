<?php
/**
 * CPT "Conquista" + taxonomia "Tipo de Conquista"
 *
 * Registra o tipo de conteúdo usado pela página /conquistas/
 * (template-parts/content-grid-conquistas.php + content-timeline-conquistas.php).
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Post Type: Conquista
 */
function andrewp_register_cpt_conquista() {
	$labels = array(
		'name'                  => __( 'Conquistas', 'andrewp' ),
		'singular_name'         => __( 'Conquista', 'andrewp' ),
		'menu_name'             => __( 'Conquistas', 'andrewp' ),
		'add_new'               => __( 'Adicionar Nova', 'andrewp' ),
		'add_new_item'          => __( 'Adicionar Nova Conquista', 'andrewp' ),
		'edit_item'             => __( 'Editar Conquista', 'andrewp' ),
		'new_item'              => __( 'Nova Conquista', 'andrewp' ),
		'view_item'             => __( 'Ver Conquista', 'andrewp' ),
		'search_items'          => __( 'Buscar Conquistas', 'andrewp' ),
		'not_found'             => __( 'Nenhuma conquista encontrada', 'andrewp' ),
		'not_found_in_trash'    => __( 'Nenhuma conquista na lixeira', 'andrewp' ),
		'all_items'             => __( 'Todas as Conquistas', 'andrewp' ),
		'featured_image'        => __( 'Imagem da Conquista', 'andrewp' ),
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
		'rewrite'            => array( 'slug' => 'conquista' ),
		'capability_type'    => 'post',
		'has_archive'        => false, // a listagem já é feita pela página /conquistas/
		'hierarchical'       => false,
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-awards',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'show_in_rest'       => true, // habilita editor em blocos / REST API
	);

	register_post_type( 'conquista', $args );
}
add_action( 'init', 'andrewp_register_cpt_conquista' );

/**
 * Taxonomia: Tipo de Conquista
 * (Legislação/Lei Municipal, Palestra, Podcast, Entrevista, Evento,
 * Publicação, Artigo, Curso, Premiação)
 */
function andrewp_register_tax_tipo_conquista() {
	$labels = array(
		'name'          => __( 'Tipos de Conquista', 'andrewp' ),
		'singular_name' => __( 'Tipo de Conquista', 'andrewp' ),
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
		'hierarchical'      => true, // funciona como categoria (checkbox), não como tag
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'tipo-conquista' ),
	);

	register_taxonomy( 'tipo_conquista', array( 'conquista' ), $args );
}
add_action( 'init', 'andrewp_register_tax_tipo_conquista' );

/**
 * Cria os termos padrão automaticamente na primeira vez que o tema roda
 * (evita você ter que criar cada categoria manualmente no admin).
 */
function andrewp_criar_termos_padrao_conquista() {
	// Já rodou antes? Não roda de novo.
	if ( get_option( 'andrewp_termos_conquista_criados' ) ) {
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
		if ( ! term_exists( $slug, 'tipo_conquista' ) ) {
			wp_insert_term( $nome, 'tipo_conquista', array( 'slug' => $slug ) );
		}
	}

	update_option( 'andrewp_termos_conquista_criados', 1 );
}
add_action( 'init', 'andrewp_criar_termos_padrao_conquista', 20 ); // depois de registrar a taxonomia

/**
 * Renomeia o termo "Premiação" (slug: premiacao) para "Reconhecimento".
 * O slug não muda — só o nome exibido — então os posts já vinculados a
 * esse termo, o $icons_map e a lista de pílulas em content-grid-conquistas.php
 * continuam funcionando sem precisar de nenhum outro ajuste.
 *
 * Roda uma única vez, igual ao padrão usado em
 * andrewp_criar_termos_padrao_conquista() acima.
 */
function andrewp_renomear_termo_premiacao() {
	if ( get_option( 'andrewp_termo_premiacao_renomeado' ) ) {
		return;
	}

	$termo = get_term_by( 'slug', 'premiacao', 'tipo_conquista' );

	if ( $termo && ! is_wp_error( $termo ) ) {
		wp_update_term( $termo->term_id, 'tipo_conquista', array(
			'name' => 'Reconhecimento',
		) );
	}

	update_option( 'andrewp_termo_premiacao_renomeado', 1 );
}
add_action( 'init', 'andrewp_renomear_termo_premiacao', 21 ); // depois de criar os termos padrão

/**
 * Metabox: "Destaque" — checkbox que controla o badge "DESTAQUE" no card
 * (usado em content-grid-conquistas.php via get_post_meta( '_conquista_destaque' )).
 */
function andrewp_metabox_destaque() {
	add_meta_box(
		'andrewp_conquista_destaque',
		__( 'Destaque', 'andrewp' ),
		'andrewp_metabox_destaque_html',
		'conquista',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'andrewp_metabox_destaque' );

function andrewp_metabox_destaque_html( $post ) {
	wp_nonce_field( 'andrewp_salvar_destaque', 'andrewp_destaque_nonce' );
	$valor = get_post_meta( $post->ID, '_conquista_destaque', true );
	?>
	<label>
		<input type="checkbox" name="conquista_destaque" value="1" <?php checked( $valor, '1' ); ?> />
		<?php esc_html_e( 'Marcar como destaque (mostra a faixa "DESTAQUE" no card)', 'andrewp' ); ?>
	</label>
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

	$valor = isset( $_POST['conquista_destaque'] ) ? '1' : '';
	update_post_meta( $post_id, '_conquista_destaque', $valor );
}
add_action( 'save_post_conquista', 'andrewp_salvar_destaque' );