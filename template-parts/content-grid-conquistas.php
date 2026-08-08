<?php
/**
 * Template part: Grid de Conquistas
 *
 * Exibe o cabeçalho "Trajetória e Reconhecimentos" e o grid de cards
 * com paginação via "Carregar mais". Sem filtros de categoria, sem
 * pílulas, sem tag de tipo no card — só busca os posts do CPT
 * 'conquista' e lista, com os marcados como "Destaque" sempre primeiro.
 *
 * Inclui também o container (shell) do modal "Ver mais": o HTML de
 * cada conquista é carregado dentro dele sob demanda, via AJAX, quando
 * o visitante clica num card (ver assets/js/content-grid-conquistas.js).
 *
 * Assumido:
 * - CPT: 'conquista'
 * - Meta boolean '_conquista_destaque' para o badge "DESTAQUE" e para
 *   a ordenação (posts com '_conquista_destaque' = '1' vêm antes).
 *
 * @package andreWP
 */

$cpt_slug = 'conquista';

$per_page = 8;
$query = new WP_Query( array(
	'post_type'      => $cpt_slug,
	'posts_per_page' => $per_page,
	'paged'          => 1,
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
) );
?>

<section class="grid-conquistas" id="grid-conquistas">
	<div class="grid-conquistas__container">

		<header class="grid-conquistas__header">
			<h2 class="grid-conquistas__title"><?php esc_html_e( 'Trajetória e Reconhecimentos', 'andrewp' ); ?></h2>
			<p class="grid-conquistas__subtitle">
				<?php esc_html_e( 'Reconhecimentos, convites e conquistas legislativas ao longo da trajetória.', 'andrewp' ); ?>
			</p>
		</header>

		<div class="grid-conquistas__grid" id="grid-conquistas-lista" data-paged="1" data-per-page="<?php echo esc_attr( $per_page ); ?>">
			<?php if ( $query->have_posts() ) : ?>
				<?php while ( $query->have_posts() ) : $query->the_post();
					get_template_part( 'template-parts/card', 'conquista' );
				endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<p class="grid-conquistas__empty"><?php esc_html_e( 'Nenhuma conquista encontrada.', 'andrewp' ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( $query->max_num_pages > 1 ) : ?>
			<div class="grid-conquistas__load-more-wrap">
				<button type="button" class="grid-conquistas__load-more" id="carregar-mais-conquistas" data-max-pages="<?php echo esc_attr( $query->max_num_pages ); ?>">
					<?php esc_html_e( 'Carregar mais conquistas', 'andrewp' ); ?>
					<span class="dashicons dashicons-update" aria-hidden="true"></span>
				</button>
			</div>
		<?php endif; ?>

	</div>

	<!-- Shell do modal "Ver mais". Fica vazio até o visitante clicar num
	     card; o conteúdo (template-parts/modal-conquista.php) é injetado
	     aqui via AJAX. -->
	<div class="conquista-modal-overlay" id="conquista-modal-overlay" aria-hidden="true">
		<div class="conquista-modal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Detalhes da conquista', 'andrewp' ); ?>">
			<div class="conquista-modal__loading" id="conquista-modal-loading">
				<span class="dashicons dashicons-update"></span>
				<?php esc_html_e( 'Carregando...', 'andrewp' ); ?>
			</div>
			<div class="conquista-modal__content" id="conquista-modal-content"></div>
		</div>
	</div>

</section>