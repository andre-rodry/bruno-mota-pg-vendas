<?php
/**
 * AJAX: "carregar mais" do grid de conquistas + busca do modal "Ver mais".
 *
 * Sem filtro por categoria — só pagina os posts do CPT 'conquista',
 * com destaques primeiro (ver template-parts/content-grid-conquistas.php).
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function andrewp_ajax_load_conquistas() {
	check_ajax_referer( 'andrewp_conquistas_nonce', 'nonce' );

	$paged = isset( $_POST['paged'] ) ? max( 1, absint( $_POST['paged'] ) ) : 1;

	$args = array(
		'post_type'      => 'conquista',
		'post_status'    => 'publish',
		'posts_per_page' => 8,
		'paged'          => $paged,
		'meta_query'     => array(
			'relation'        => 'OR',
			'destaque_clause' => array(
				'key'     => '_conquista_destaque',
				'compare' => 'EXISTS',
			),
			array(
				'key'     => '_conquista_destaque',
				'compare' => 'NOT EXISTS',
			),
		),
		'orderby' => array(
			'destaque_clause' => 'DESC',
			'date'            => 'DESC',
		),
	);

	$query = new WP_Query( $args );

	ob_start();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'template-parts/card', 'conquista' );
		}
		wp_reset_postdata();
	} else {
		echo '<p class="grid-conquistas__empty">' . esc_html__( 'Nenhuma conquista encontrada.', 'andrewp' ) . '</p>';
	}

	$html = ob_get_clean();

	wp_send_json_success( array(
		'html'        => $html,
		'has_more'    => $paged < $query->max_num_pages,
		'max_pages'   => $query->max_num_pages,
		'found_posts' => $query->found_posts,
	) );
}
add_action( 'wp_ajax_andrewp_load_conquistas', 'andrewp_ajax_load_conquistas' );
add_action( 'wp_ajax_nopriv_andrewp_load_conquistas', 'andrewp_ajax_load_conquistas' );

/**
 * Devolve o HTML do modal "Ver mais" de UMA conquista, gerado sob demanda
 * quando o visitante clica no card. Evita renderizar todos os modais
 * (com galerias e listas de documentos) de uma vez na página inicial.
 */
function andrewp_ajax_get_conquista_modal() {
	check_ajax_referer( 'andrewp_conquistas_nonce', 'nonce' );

	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

	if ( ! $post_id || 'conquista' !== get_post_type( $post_id ) || 'publish' !== get_post_status( $post_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Conquista não encontrada.', 'andrewp' ) ) );
	}

	$html = andrewp_render_modal_conquista_html( $post_id );

	if ( ! $html ) {
		wp_send_json_error( array( 'message' => __( 'Não foi possível carregar os detalhes.', 'andrewp' ) ) );
	}

	wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_andrewp_get_conquista_modal', 'andrewp_ajax_get_conquista_modal' );
add_action( 'wp_ajax_nopriv_andrewp_get_conquista_modal', 'andrewp_ajax_get_conquista_modal' );