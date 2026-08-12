<?php
/**
 * Template part: Lista de Publicações
 *
 * Busca + abas de filtro (Artigos / Revistas / Livros / Capítulos de
 * Livros) + lista paginada + shell do modal "Ler artigo".
 *
 * O conteúdo da lista e da paginação é recarregado via AJAX
 * (inc/ajax-publicacoes.php) sempre que o visitante troca de aba,
 * pesquisa, ordena ou muda de página — sem recarregar a página inteira.
 *
 * @package andreWP
 */

$per_page = defined( 'ANDREWP_PUBLICACOES_POR_PAGINA' ) ? ANDREWP_PUBLICACOES_POR_PAGINA : 6;

$abas = array(
	'todos'             => __( 'Todos', 'andrewp' ),
	'artigo'            => __( 'Artigos', 'andrewp' ),
	'revista'           => __( 'Revistas', 'andrewp' ),
	'livro'             => __( 'Livros', 'andrewp' ),
	'capitulo-de-livro' => __( 'Capítulos de Livros', 'andrewp' ),
);

// Contagem de publicações publicadas por tipo, pra mostrar "(63)" em cada aba.
$contagens = array();
foreach ( $abas as $slug => $label ) {
	if ( 'todos' === $slug ) {
		$contagens[ $slug ] = wp_count_posts( 'publicacao' )->publish;
		continue;
	}
	$termo = get_term_by( 'slug', $slug, 'tipo_publicacao' );
	$contagens[ $slug ] = $termo ? (int) $termo->count : 0;
}

// Aba inicial: Artigos (se existir pelo menos um), senão "Todos".
$aba_inicial = $contagens['artigo'] > 0 ? 'artigo' : 'todos';

$query_inicial = andrewp_query_publicacoes( $aba_inicial, '', 'recentes', 1 );
?>

<section class="lista-publicacoes" id="lista-publicacoes">
	<div class="lista-publicacoes__container">

		<div class="lista-publicacoes__busca-wrap">
			<div class="lista-publicacoes__busca">
				<span class="dashicons dashicons-search"></span>
				<input
					type="search"
					id="lista-publicacoes-busca"
					class="lista-publicacoes__busca-input"
					placeholder="<?php esc_attr_e( 'Buscar publicação...', 'andrewp' ); ?>"
					autocomplete="off"
				/>
			</div>
			<button type="button" id="lista-publicacoes-limpar" class="lista-publicacoes__limpar">
				<?php esc_html_e( 'Limpar filtros', 'andrewp' ); ?>
				<span class="dashicons dashicons-trash"></span>
			</button>
		</div>

		<div class="lista-publicacoes__abas" id="lista-publicacoes-abas" role="tablist">
			<?php foreach ( $abas as $slug => $label ) :
				if ( 'todos' === $slug ) {
					continue;
				}
				?>
				<button
					type="button"
					class="lista-publicacoes__aba <?php echo ( $slug === $aba_inicial ) ? 'is-active' : ''; ?>"
					data-tipo="<?php echo esc_attr( $slug ); ?>"
					role="tab"
					aria-selected="<?php echo ( $slug === $aba_inicial ) ? 'true' : 'false'; ?>"
				>
					<?php echo esc_html( mb_strtoupper( $label ) ); ?>
				</button>
			<?php endforeach; ?>
		</div>

		<div class="lista-publicacoes__topo">
			<h2 class="lista-publicacoes__titulo-secao">
				<span id="lista-publicacoes-label"><?php echo esc_html( $abas[ $aba_inicial ] ); ?></span>
				(<span id="lista-publicacoes-total"><?php echo esc_html( $query_inicial->found_posts ); ?></span>)
			</h2>

			<label class="lista-publicacoes__ordenar">
				<?php esc_html_e( 'Ordenar:', 'andrewp' ); ?>
				<select id="lista-publicacoes-ordenar">
					<option value="recentes"><?php esc_html_e( 'Mais recentes', 'andrewp' ); ?></option>
					<option value="antigos"><?php esc_html_e( 'Mais antigos', 'andrewp' ); ?></option>
					<option value="titulo"><?php esc_html_e( 'Título (A-Z)', 'andrewp' ); ?></option>
				</select>
			</label>
		</div>

		<div class="lista-publicacoes__lista" id="lista-publicacoes-resultados" data-tipo="<?php echo esc_attr( $aba_inicial ); ?>" data-pagina="1">
			<?php
			if ( $query_inicial->have_posts() ) {
				while ( $query_inicial->have_posts() ) {
					$query_inicial->the_post();
					get_template_part( 'publicacoes/card', 'publicacao' );
				}
				wp_reset_postdata();
			} else {
				echo '<p class="lista-publicacoes__vazio">' . esc_html__( 'Nenhuma publicação encontrada.', 'andrewp' ) . '</p>';
			}
			?>
		</div>

		<div class="lista-publicacoes__paginacao-wrap" id="lista-publicacoes-paginacao">
			<?php echo andrewp_publicacoes_paginacao_html( $query_inicial->max_num_pages, 1 ); ?>
		</div>

	</div>

	<!-- Shell do modal "Ler artigo". Fica vazio até o visitante clicar num
	     card; o conteúdo (publicacoes/modal-publicacao.php) é injetado
	     aqui via AJAX (publicacoes/page-lista-publicacoes.js). -->
	<div class="publicacao-modal-overlay" id="publicacao-modal-overlay" aria-hidden="true">
		<div class="publicacao-modal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Detalhes da publicação', 'andrewp' ); ?>">
			<div class="publicacao-modal__loading" id="publicacao-modal-loading">
				<span class="dashicons dashicons-update"></span>
				<?php esc_html_e( 'Carregando...', 'andrewp' ); ?>
			</div>
			<div class="publicacao-modal__content" id="publicacao-modal-content"></div>
		</div>
	</div>

</section>