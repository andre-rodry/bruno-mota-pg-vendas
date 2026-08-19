<?php
/**
 * AJAX: "carregar mais" do grid de trajetória + busca do modal "Ver mais".
 *
 * Sem filtro por categoria — só pagina os posts do CPT 'trajetoria',
 * com destaques primeiro (ver trajetoria/content-grid-trajetoria.php).
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function andrewp_ajax_load_trajetoria() {
	check_ajax_referer( 'andrewp_trajetoria_nonce', 'nonce' );

	$paged = isset( $_POST['paged'] ) ? max( 1, absint( $_POST['paged'] ) ) : 1;

	$args = array(
		'post_type'      => 'trajetoria',
		'post_status'    => 'publish',
		'posts_per_page' => 8,
		'paged'          => $paged,
		'meta_query'     => array(
			'relation'        => 'OR',
			'destaque_clause' => array(
				'key'     => '_trajetoria_destaque',
				'compare' => 'EXISTS',
			),
			array(
				'key'     => '_trajetoria_destaque',
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
			get_template_part( 'trajetoria/card', 'trajetoria' );
		}
		wp_reset_postdata();
	} else {
		echo '<p class="grid-trajetoria__empty">' . esc_html__( 'Nenhum item de trajetória encontrado.', 'andrewp' ) . '</p>';
	}

	$html = ob_get_clean();

	wp_send_json_success( array(
		'html'        => $html,
		'has_more'    => $paged < $query->max_num_pages,
		'max_pages'   => $query->max_num_pages,
		'found_posts' => $query->found_posts,
	) );
}
add_action( 'wp_ajax_andrewp_load_trajetoria', 'andrewp_ajax_load_trajetoria' );
add_action( 'wp_ajax_nopriv_andrewp_load_trajetoria', 'andrewp_ajax_load_trajetoria' );

/**
 * Devolve o HTML do modal "Ver mais" de UM item de trajetória, gerado sob
 * demanda quando o visitante clica no card. Evita renderizar todos os
 * modais (com galerias e listas de documentos) de uma vez na página inicial.
 */
function andrewp_ajax_get_trajetoria_modal() {
	check_ajax_referer( 'andrewp_trajetoria_nonce', 'nonce' );

	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

	if ( ! $post_id || 'trajetoria' !== get_post_type( $post_id ) || 'publish' !== get_post_status( $post_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Item de trajetória não encontrado.', 'andrewp' ) ) );
	}

	$html = andrewp_render_modal_trajetoria_html( $post_id );

	if ( ! $html ) {
		wp_send_json_error( array( 'message' => __( 'Não foi possível carregar os detalhes.', 'andrewp' ) ) );
	}

	wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_andrewp_get_trajetoria_modal', 'andrewp_ajax_get_trajetoria_modal' );
add_action( 'wp_ajax_nopriv_andrewp_get_trajetoria_modal', 'andrewp_ajax_get_trajetoria_modal' );