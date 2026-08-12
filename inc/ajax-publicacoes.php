<?php
/**
 * AJAX: filtro por tipo (Artigos/Revistas/Livros/Capítulos de Livros),
 * busca por título e paginação numérica do grid de publicações
 * (publicacoes/content-lista-publicacoes.php), além da busca do
 * modal "Ler artigo" sob demanda.
 *
 * Segue o mesmo padrão de inc/ajax-conquistas.php.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ANDREWP_PUBLICACOES_POR_PAGINA', 6 );

/**
 * Monta a WP_Query da lista de publicações a partir do tipo (slug da
 * taxonomia tipo_publicacao, ou 'todos'), termo de busca, ordenação e página.
 */
function andrewp_query_publicacoes( $tipo, $busca, $orderby, $paged ) {
	$busca = trim( (string) $busca );

	$args = array(
		'post_type'      => 'publicacao',
		'post_status'    => 'publish',
		'posts_per_page' => ANDREWP_PUBLICACOES_POR_PAGINA,
		'paged'          => max( 1, absint( $paged ) ),
	);

	/*
	 * Quando há um termo de busca, ignora o filtro de aba (tipo) e
	 * pesquisa em todos os tipos de publicação — assim o usuário não
	 * precisa adivinhar em qual aba (Artigos/Revistas/Livros/Capítulos)
	 * a publicação está antes de conseguir encontrá-la.
	 */
	if ( '' === $busca && $tipo && 'todos' !== $tipo ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'tipo_publicacao',
				'field'    => 'slug',
				'terms'    => sanitize_key( $tipo ),
			),
		);
	}

	if ( '' !== $busca ) {
		$args['s'] = sanitize_text_field( $busca );
	}

	if ( 'antigos' === $orderby ) {
		$args['orderby'] = 'date';
		$args['order']   = 'ASC';
	} elseif ( 'titulo' === $orderby ) {
		$args['orderby'] = 'title';
		$args['order']   = 'ASC';
	} else {
		$args['orderby'] = 'date';
		$args['order']   = 'DESC';
	}

	return new WP_Query( $args );
}

/**
 * Gera o HTML da paginação numérica no formato:
 * < Anterior  [1] 2 3 4 ... 11  Próxima >
 */
function andrewp_publicacoes_paginacao_html( $total_paginas, $pagina_atual ) {
	if ( $total_paginas <= 1 ) {
		return '';
	}

	$pagina_atual = max( 1, min( $pagina_atual, $total_paginas ) );

	ob_start();
	?>
	<nav class="lista-publicacoes__paginacao" aria-label="<?php esc_attr_e( 'Paginação de publicações', 'andrewp' ); ?>">
		<button type="button" class="lista-publicacoes__pag-btn lista-publicacoes__pag-btn--nav"
			data-pagina="<?php echo esc_attr( $pagina_atual - 1 ); ?>" <?php disabled( 1 === $pagina_atual ); ?>>
			<span class="dashicons dashicons-arrow-left-alt2"></span> <?php esc_html_e( 'Anterior', 'andrewp' ); ?>
		</button>

		<?php
		$paginas = array();
		$paginas[] = 1;
		for ( $i = $pagina_atual - 1; $i <= $pagina_atual + 1; $i++ ) {
			if ( $i > 1 && $i < $total_paginas ) {
				$paginas[] = $i;
			}
		}
		$paginas[] = $total_paginas;
		$paginas   = array_unique( $paginas );
		sort( $paginas );

		$anterior = 0;
		foreach ( $paginas as $num ) {
			if ( $anterior && $num - $anterior > 1 ) {
				echo '<span class="lista-publicacoes__pag-reticencias">&hellip;</span>';
			}
			$classe = ( $num === $pagina_atual ) ? 'lista-publicacoes__pag-btn lista-publicacoes__pag-btn--num is-active' : 'lista-publicacoes__pag-btn lista-publicacoes__pag-btn--num';
			printf(
				'<button type="button" class="%1$s" data-pagina="%2$d">%2$d</button>',
				esc_attr( $classe ),
				(int) $num
			);
			$anterior = $num;
		}
		?>

		<button type="button" class="lista-publicacoes__pag-btn lista-publicacoes__pag-btn--nav"
			data-pagina="<?php echo esc_attr( $pagina_atual + 1 ); ?>" <?php disabled( $pagina_atual === $total_paginas ); ?>>
			<?php esc_html_e( 'Próxima', 'andrewp' ); ?> <span class="dashicons dashicons-arrow-right-alt2"></span>
		</button>
	</nav>
	<?php
	return ob_get_clean();
}

/**
 * Handler principal: recebe tipo/busca/ordenar/paged e devolve o HTML
 * dos cards + paginação + contagem, para o JS trocar no DOM.
 */
function andrewp_ajax_filtrar_publicacoes() {
	check_ajax_referer( 'andrewp_publicacoes_nonce', 'nonce' );

	$tipo    = isset( $_POST['tipo'] ) ? sanitize_key( wp_unslash( $_POST['tipo'] ) ) : 'todos';
	$busca   = isset( $_POST['busca'] ) ? sanitize_text_field( wp_unslash( $_POST['busca'] ) ) : '';
	$orderby = isset( $_POST['orderby'] ) ? sanitize_key( wp_unslash( $_POST['orderby'] ) ) : 'recentes';
	$paged   = isset( $_POST['paged'] ) ? absint( $_POST['paged'] ) : 1;

	$query = andrewp_query_publicacoes( $tipo, $busca, $orderby, $paged );

	ob_start();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'publicacoes/card', 'publicacao' );
		}
		wp_reset_postdata();
	} else {
		echo '<p class="lista-publicacoes__vazio">' . esc_html__( 'Nenhuma publicação encontrada.', 'andrewp' ) . '</p>';
	}
	$cards_html = ob_get_clean();

	$paginacao_html = andrewp_publicacoes_paginacao_html( $query->max_num_pages, $paged );

	wp_send_json_success( array(
		'html'        => $cards_html,
		'paginacao'   => $paginacao_html,
		'total'       => (int) $query->found_posts,
		'max_paginas' => (int) $query->max_num_pages,
		'pagina'      => max( 1, min( $paged, max( 1, $query->max_num_pages ) ) ),
	) );
}
add_action( 'wp_ajax_andrewp_filtrar_publicacoes', 'andrewp_ajax_filtrar_publicacoes' );
add_action( 'wp_ajax_nopriv_andrewp_filtrar_publicacoes', 'andrewp_ajax_filtrar_publicacoes' );

/**
 * Devolve o HTML do modal "Ler artigo" de UMA publicação, gerado sob
 * demanda quando o visitante clica no card.
 */
function andrewp_ajax_get_publicacao_modal() {
	check_ajax_referer( 'andrewp_publicacoes_nonce', 'nonce' );

	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

	if ( ! $post_id || 'publicacao' !== get_post_type( $post_id ) || 'publish' !== get_post_status( $post_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Publicação não encontrada.', 'andrewp' ) ) );
	}

	$html = andrewp_render_modal_publicacao_html( $post_id );

	if ( ! $html ) {
		wp_send_json_error( array( 'message' => __( 'Não foi possível carregar os detalhes.', 'andrewp' ) ) );
	}

	wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_andrewp_get_publicacao_modal', 'andrewp_ajax_get_publicacao_modal' );
add_action( 'wp_ajax_nopriv_andrewp_get_publicacao_modal', 'andrewp_ajax_get_publicacao_modal' );