<?php
/**
 * Partial: um card de trajetoria.
 * Espera estar dentro de um loop com the_post() já chamado (usa globais do post atual).
 *
 * O "Ver mais" agora abre o modal (trajetoria/modal-trajetoria.php)
 * via AJAX em vez de navegar para o permalink do post — ver
 * assets/js/content-grid-trajetoria.js (classe .js-abrir-trajetoria-modal).
 *
 * @package andreWP
 */

$is_destaque = get_post_meta( get_the_ID(), '_trajetoria_destaque', true );
$ano_manual  = get_post_meta( get_the_ID(), '_trajetoria_ano', true );
$ano_exibido = $ano_manual ? $ano_manual : get_the_date( 'Y' );
?>
<article class="grid-trajetoria__card">
	<div class="grid-trajetoria__card-media">
		<?php if ( $is_destaque ) : ?>
			<span class="grid-trajetoria__badge"><?php esc_html_e( 'Destaque', 'andrewp' ); ?></span>
		<?php endif; ?>

		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'medium_large', array( 'class' => 'grid-trajetoria__img', 'loading' => 'lazy' ) ); ?>
		<?php endif; ?>
	</div>

	<div class="grid-trajetoria__card-body">
		<h3 class="grid-trajetoria__card-title">
			<?php the_title(); ?>
		</h3>

		<div class="grid-trajetoria__card-meta">
			<span class="grid-trajetoria__card-year"><?php echo esc_html( $ano_exibido ); ?></span>
		</div>

		<p class="grid-trajetoria__card-excerpt">
			<?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?>
		</p>

		<button
			type="button"
			class="grid-trajetoria__card-link js-abrir-trajetoria-modal"
			data-post-id="<?php echo esc_attr( get_the_ID() ); ?>"
		>
			<?php esc_html_e( 'Ver mais', 'andrewp' ); ?>
			<span class="grid-trajetoria__card-arrow" aria-hidden="true">&rarr;</span>
		</button>
	</div>
</article>