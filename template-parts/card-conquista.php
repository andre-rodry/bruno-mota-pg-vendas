<?php
/**
 * Partial: um card de conquista.
 * Espera estar dentro de um loop com the_post() já chamado (usa globais do post atual).
 *
 * @package andreWP
 */

$tax_slug    = 'tipo_conquista';
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