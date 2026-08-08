<?php
/**
 * Renderiza o HTML do modal "Ver mais" de uma conquista.
 *
 * Junta os campos cadastrados no metabox "Conteúdo do Modal"
 * (inc/cpt-conquistas.php) com o template visual
 * (conquistas/modal-conquista.php) e devolve o HTML pronto.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function andrewp_render_modal_conquista_html( $post_id ) {
	$post_id = absint( $post_id );

	if ( ! $post_id || 'conquista' !== get_post_type( $post_id ) ) {
		return '';
	}

	ob_start();
	include get_template_directory() . '/conquistas/modal-conquista.php';
	return ob_get_clean();
}