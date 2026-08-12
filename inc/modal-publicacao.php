<?php
/**
 * Renderiza o HTML do modal "Ler artigo" / "Ler livro" de uma publicação.
 *
 * Junta os campos cadastrados nos metaboxes (inc/cpt-publicacoes.php)
 * com o template visual certo:
 * - publicacoes/modal-publicacao.php        -> Artigos e Revistas
 * - publicacoes/modal-publicacao-livro.php  -> Livros e Capítulos de Livro
 * e devolve o HTML pronto para ser injetado via AJAX.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function andrewp_render_modal_publicacao_html( $post_id ) {
	$post_id = absint( $post_id );

	if ( ! $post_id || 'publicacao' !== get_post_type( $post_id ) ) {
		return '';
	}

	$termo    = andrewp_publicacao_termo_principal( $post_id );
	$eh_livro = $termo && andrewp_publicacao_eh_livro( $termo->slug );

	$template = $eh_livro ? '/publicacoes/modal-publicacao-livro.php' : '/publicacoes/modal-publicacao.php';

	ob_start();
	include get_template_directory() . $template;
	return ob_get_clean();
}