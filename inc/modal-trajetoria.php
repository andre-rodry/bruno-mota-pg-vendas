<?php
/**
 * Renderiza o HTML do modal "Ver mais" de uma trajetoria.
 *
 * Junta os campos cadastrados no metabox "Conteúdo do Modal"
 * (inc/cpt-trajetoria.php) com o template visual
 * (trajetoria/modal-trajetoria.php) e devolve o HTML pronto.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function andrewp_render_modal_trajetoria_html( $post_id ) {
	$post_id = absint( $post_id );

	if ( ! $post_id || 'trajetoria' !== get_post_type( $post_id ) ) {
		return '';
	}

	ob_start();
	include get_template_directory() . '/trajetoria/modal-trajetoria.php';
	return ob_get_clean();
}