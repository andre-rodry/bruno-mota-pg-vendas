<?php
/**
 * AJAX: filtro por categoria e "carregar mais" do grid de conquistas.
 *
 * Os parâmetros de ano e ordenação foram removidos junto com os selects
 * correspondentes no template (ver content-grid-conquistas.php) — a
 * listagem agora é sempre por mais recentes primeiro, filtrada só por tipo.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function andrewp_ajax_load_conquistas() {
	check_ajax_referer( 'andrewp_conquistas_nonce', 'nonce' );

	$paged = isset( $_POST['paged'] ) ? max( 1, absint( $_POST['paged'] ) ) : 1;
	$tipo  = isset( $_POST['tipo'] ) ? sanitize_title( wp_unslash( $_POST['tipo'] ) ) : '';

	$args = array(
		'post_type'      => 'conquista',
		'post_status'    => 'publish',
		'posts_per_page' => 8,
		'paged'          => $paged,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	if ( $tipo ) {
		$args['tax_query'] = array( array(
			'taxonomy' => 'tipo_conquista',
			'field'    => 'slug',
			'terms'    => $tipo,
		) );
	}

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