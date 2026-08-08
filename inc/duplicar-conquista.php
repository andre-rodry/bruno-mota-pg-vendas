<?php
/**
 * Duplicar Conquista.
 *
 * Adiciona um link "Duplicar" na listagem de Conquistas (Todas as
 * Conquistas). Ao clicar, cria uma cópia do post como rascunho, com
 * todos os campos personalizados do metabox "Conteúdo do Modal"
 * (destaques, galeria, documentos, impacto, artigo, programação,
 * certificado, CTA), a imagem destacada e os termos de taxonomia,
 * e já abre a cópia na tela de edição pronta pra você trocar os
 * valores.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adiciona o link "Duplicar" nas ações de cada linha da listagem
 * (mesma linha onde já tem "Editar", "Lixeira", "Ver").
 */
function andrewp_conquista_link_duplicar( $actions, $post ) {
	if ( 'conquista' !== $post->post_type ) {
		return $actions;
	}

	if ( ! current_user_can( 'edit_posts' ) ) {
		return $actions;
	}

	$url = wp_nonce_url(
		add_query_arg(
			array(
				'action'  => 'andrewp_duplicar_conquista',
				'post_id' => $post->ID,
			),
			admin_url( 'admin.php' )
		),
		'andrewp_duplicar_conquista_' . $post->ID
	);

	$actions['andrewp_duplicar'] = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Duplicar', 'andrewp' ) . '</a>';

	return $actions;
}
add_filter( 'post_row_actions', 'andrewp_conquista_link_duplicar', 10, 2 );

/**
 * Processa a duplicação: cria o post novo, copia todo o post_meta
 * (_conquista_*), a imagem destacada e os termos da taxonomia
 * 'tipo_conquista', e redireciona para a tela de edição da cópia.
 */
function andrewp_processar_duplicar_conquista() {
	$post_id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : 0;

	if ( ! $post_id ) {
		wp_die( esc_html__( 'Conquista inválida.', 'andrewp' ) );
	}

	check_admin_referer( 'andrewp_duplicar_conquista_' . $post_id );

	$original = get_post( $post_id );

	if ( ! $original || 'conquista' !== $original->post_type ) {
		wp_die( esc_html__( 'Conquista não encontrada.', 'andrewp' ) );
	}

	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( esc_html__( 'Você não tem permissão para fazer isso.', 'andrewp' ) );
	}

	// Cria o novo post como rascunho, com "(cópia)" no título pra
	// ficar fácil de identificar na listagem antes de você renomear.
	$novo_id = wp_insert_post(
		array(
			'post_title'   => $original->post_title . ' (cópia)',
			'post_content' => $original->post_content,
			'post_excerpt' => $original->post_excerpt,
			'post_status'  => 'draft',
			'post_type'    => 'conquista',
			'post_author'  => get_current_user_id(),
		),
		true
	);

	if ( is_wp_error( $novo_id ) ) {
		wp_die( esc_html( $novo_id->get_error_message() ) );
	}

	// Copia todos os meta fields que começam com "_conquista_"
	// (cabeçalho, destaques, artigo, galeria, programação,
	// documentos, impacto, certificado, CTA, ano, destaque).
	$todos_metas = get_post_meta( $post_id );

	foreach ( $todos_metas as $chave => $valores ) {
		if ( 0 !== strpos( $chave, '_conquista_' ) ) {
			continue;
		}

		foreach ( $valores as $valor_serializado ) {
			$valor = maybe_unserialize( $valor_serializado );
			add_post_meta( $novo_id, $chave, $valor );
		}
	}

	// Copia a imagem destacada.
	$thumbnail_id = get_post_thumbnail_id( $post_id );
	if ( $thumbnail_id ) {
		set_post_thumbnail( $novo_id, $thumbnail_id );
	}

	// Copia os termos da taxonomia 'tipo_conquista'.
	$termos = wp_get_object_terms( $post_id, 'tipo_conquista', array( 'fields' => 'ids' ) );
	if ( ! is_wp_error( $termos ) && ! empty( $termos ) ) {
		wp_set_object_terms( $novo_id, $termos, 'tipo_conquista' );
	}

	// Vai direto pra tela de edição da cópia.
	wp_safe_redirect( admin_url( 'post.php?action=edit&post=' . $novo_id ) );
	exit;
}
add_action( 'admin_action_andrewp_duplicar_conquista', 'andrewp_processar_duplicar_conquista' );