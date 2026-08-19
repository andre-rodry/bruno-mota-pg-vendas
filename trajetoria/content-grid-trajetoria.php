<?php
/**
 * Template part: Grid de Trajetoria
 *
 * Exibe o cabeçalho "Trajetória e Reconhecimentos" e o grid de cards
 * com paginação via "Carregar mais". Sem filtros de categoria, sem
 * pílulas, sem tag de tipo no card — só busca os posts do CPT
 * 'trajetoria' e lista, com os marcados como "Destaque" sempre primeiro.
 *
 * Inclui também o container (shell) do modal "Ver mais": o HTML de
 * cada trajetória é carregado dentro dele sob demanda, via AJAX, quando
 * o visitante clica num card (ver assets/js/content-grid-trajetoria.js).
 *
 * Assumido:
 * - CPT: 'trajetoria'
 * - Meta boolean '_trajetoria_destaque' para o badge "DESTAQUE" e para
 *   a ordenação (posts com '_trajetoria_destaque' = '1' vêm antes).
 *
 * @package andreWP
 */

$cpt_slug = 'trajetoria';

$per_page = 8;
$query = new WP_Query( array(
	'post_type'      => $cpt_slug,
	'posts_per_page' => $per_page,
	'paged'          => 1,
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
) );
?>

<section class="grid-trajetoria" id="grid-trajetoria">
	<div class="grid-trajetoria__container">

		<header class="grid-trajetoria__header">
			<h2 class="grid-trajetoria__title"><?php esc_html_e( 'Trajetória e Reconhecimentos', 'andrewp' ); ?></h2>
			<p class="grid-trajetoria__subtitle">
				<?php esc_html_e( 'Reconhecimentos, convites e marcos legislativos ao longo da trajetória.', 'andrewp' ); ?>
			</p>
		</header>

		<div class="grid-trajetoria__grid" id="grid-trajetoria-lista" data-paged="1" data-per-page="<?php echo esc_attr( $per_page ); ?>">
			<?php if ( $query->have_posts() ) : ?>
				<?php while ( $query->have_posts() ) : $query->the_post();
					get_template_part( 'trajetoria/card', 'trajetoria' );
				endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<p class="grid-trajetoria__empty"><?php esc_html_e( 'Nenhuma trajetória encontrada.', 'andrewp' ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( $query->max_num_pages > 1 ) : ?>
			<div class="grid-trajetoria__load-more-wrap">
				<button type="button" class="grid-trajetoria__load-more" id="carregar-mais-trajetoria" data-max-pages="<?php echo esc_attr( $query->max_num_pages ); ?>">
					<?php esc_html_e( 'Carregar mais itens', 'andrewp' ); ?>
					<span class="dashicons dashicons-update" aria-hidden="true"></span>
				</button>
			</div>
		<?php endif; ?>

	</div>

	<!-- Shell do modal "Ver mais". Fica vazio até o visitante clicar num
	     card; o conteúdo (trajetoria/modal-trajetoria.php) é injetado
	     aqui via AJAX. -->
	<div class="trajetoria-modal-overlay" id="trajetoria-modal-overlay" aria-hidden="true">
		<div class="trajetoria-modal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Detalhes do item', 'andrewp' ); ?>">
			<div class="trajetoria-modal__loading" id="trajetoria-modal-loading">
				<span class="dashicons dashicons-update"></span>
				<?php esc_html_e( 'Carregando...', 'andrewp' ); ?>
			</div>
			<div class="trajetoria-modal__content" id="trajetoria-modal-content"></div>
		</div>
	</div>

</section>