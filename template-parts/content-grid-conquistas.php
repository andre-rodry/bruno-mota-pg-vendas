<?php
/**
 * Template part: Grid de Conquistas
 *
 * Exibe o cabeçalho "Todas as Conquistas", as pílulas de categoria
 * e o grid de cards com paginação via "Carregar mais".
 *
 * Assumido:
 * - CPT: 'conquista'
 * - Taxonomia: 'tipo_conquista' (termos: legislacao, palestra, podcast,
 *   entrevista, evento, publicacao, artigo, curso, premiacao)
 * - Meta boolean '_conquista_destaque' para o badge "DESTAQUE"
 *
 * Os filtros de "ano" e "ordenar" foram removidos: com o volume atual de
 * conquistas, a combinação categoria + ano só complicava a navegação sem
 * necessidade. A ordenação padrão (mais recentes primeiro) é aplicada
 * sempre, sem opção de troca.
 *
 * @package andreWP
 */

$tax_slug = 'tipo_conquista';
$cpt_slug = 'conquista';

// Ícones (dashicons) por termo — ajuste os slugs conforme sua taxonomia.
$icons_map = array(
	'legislacao'    => 'dashicons-building',
	'palestra'      => 'dashicons-groups',
	'podcast'       => 'dashicons-format-audio',
	'entrevista'    => 'dashicons-microphone',
	'evento'        => 'dashicons-calendar-alt',
	'publicacao'    => 'dashicons-media-document',
	'artigo'        => 'dashicons-edit-page',
	'curso'         => 'dashicons-welcome-learn-more',
	'premiacao'     => 'dashicons-awards',
);

// Pílulas que devem aparecer no grid (nesta ordem), além de "Todas".
// Critério: só entram categorias que representam mérito/reconhecimento
// direto (não simples participação). Publicações e Entrevistas já têm
// páginas próprias (Publicações e Mídia), por isso não entram aqui.
$pills_permitidas = array(
	'legislacao',
	'palestra',
	'premiacao',
);

$terms = get_terms( array(
	'taxonomy'   => $tax_slug,
	'hide_empty' => true,
) );

// Blindagem: se a taxonomia não existir ou get_terms() retornar erro,
// $terms vira um array vazio em vez de quebrar o foreach lá embaixo.
if ( is_wp_error( $terms ) || ! is_array( $terms ) ) {
	$terms = array();
}

// Mantém só os termos que estão na lista de pílulas permitidas,
// e já ordena na mesma ordem definida em $pills_permitidas.
$terms_filtrados = array();
foreach ( $pills_permitidas as $slug_permitido ) {
	foreach ( $terms as $term ) {
		if ( is_object( $term ) && isset( $term->slug ) && $term->slug === $slug_permitido ) {
			$terms_filtrados[] = $term;
			break;
		}
	}
}
$terms = $terms_filtrados;

// Primeira leva de posts (grid inicial), sempre por mais recentes primeiro.
$per_page = 8;
$query = new WP_Query( array(
	'post_type'      => $cpt_slug,
	'posts_per_page' => $per_page,
	'paged'          => 1,
	'orderby'        => 'date',
	'order'          => 'DESC',
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

		<div class="grid-conquistas__pills" role="tablist">
			<button type="button" class="grid-conquistas__pill is-active" data-tipo="">
				<span class="dashicons dashicons-list-view"></span>
				<?php esc_html_e( 'Todas', 'andrewp' ); ?>
			</button>
			<?php foreach ( $terms as $term ) :
				if ( ! is_object( $term ) || ! isset( $term->slug ) ) {
					continue; // pula item malformado em vez de quebrar a página
				}
				$icon = isset( $icons_map[ $term->slug ] ) ? $icons_map[ $term->slug ] : 'dashicons-tag';
				?>
				<button type="button" class="grid-conquistas__pill" data-tipo="<?php echo esc_attr( $term->slug ); ?>">
					<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span>
					<?php echo esc_html( $term->name ); ?>
				</button>
			<?php endforeach; ?>
		</div>

		<div class="grid-conquistas__grid" id="grid-conquistas-lista" data-paged="1" data-per-page="<?php echo esc_attr( $per_page ); ?>">
			<?php if ( $query->have_posts() ) : ?>
				<?php while ( $query->have_posts() ) : $query->the_post();
					$post_terms  = get_the_terms( get_the_ID(), $tax_slug );
					$term_obj    = ( $post_terms && ! is_wp_error( $post_terms ) ) ? $post_terms[0] : null;
					$is_destaque = get_post_meta( get_the_ID(), '_conquista_destaque', true );
					?>
					<article class="grid-conquistas__card" data-tipo="<?php echo esc_attr( $term_obj ? $term_obj->slug : '' ); ?>" data-ano="<?php echo esc_attr( get_the_date( 'Y' ) ); ?>">
						<div class="grid-conquistas__card-media">
							<?php if ( $is_destaque ) : ?>
								<span class="grid-conquistas__badge"><?php esc_html_e( 'Destaque', 'andrewp' ); ?></span>
							<?php endif; ?>

							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium_large', array( 'class' => 'grid-conquistas__img', 'loading' => 'lazy' ) ); ?>
							<?php endif; ?>
						</div>

						<div class="grid-conquistas__card-body">
							<h3 class="grid-conquistas__card-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>

							<div class="grid-conquistas__card-meta">
								<?php if ( $term_obj ) : ?>
									<span class="grid-conquistas__card-tag"><?php echo esc_html( mb_strtoupper( $term_obj->name ) ); ?></span>
								<?php endif; ?>
								<span class="grid-conquistas__card-year"><?php echo esc_html( get_the_date( 'Y' ) ); ?></span>
							</div>

							<p class="grid-conquistas__card-excerpt">
								<?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?>
							</p>

							<a href="<?php the_permalink(); ?>" class="grid-conquistas__card-link">
								<?php esc_html_e( 'Ver mais', 'andrewp' ); ?>
								<span class="grid-conquistas__card-arrow" aria-hidden="true">&rarr;</span>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
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
</section>