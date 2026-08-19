<?php
/**
 * Partial: um card de conquista.
 * Espera estar dentro de um loop com the_post() já chamado (usa globais do post atual).
 *
 * O "Ver mais" agora abre o modal (conquistas/modal-conquista.php)
 * via AJAX em vez de navegar para o permalink do post — ver
 * assets/js/content-grid-conquistas.js (classe .js-abrir-conquista-modal).
 *
 * @package andreWP
 */

$is_destaque = get_post_meta( get_the_ID(), '_conquista_destaque', true );
$ano_manual  = get_post_meta( get_the_ID(), '_conquista_ano', true );
$ano_exibido = $ano_manual ? $ano_manual : get_the_date( 'Y' );
?>
<article class="grid-conquistas__card">
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
			<?php the_title(); ?>
		</h3>

		<div class="grid-conquistas__card-meta">
			<span class="grid-conquistas__card-year"><?php echo esc_html( $ano_exibido ); ?></span>
		</div>

		<p class="grid-conquistas__card-excerpt">
			<?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?>
		</p>

		<button
			type="button"
			class="grid-conquistas__card-link js-abrir-conquista-modal"
			data-post-id="<?php echo esc_attr( get_the_ID() ); ?>"
		>
			<?php esc_html_e( 'Ver mais', 'andrewp' ); ?>
			<span class="grid-conquistas__card-arrow" aria-hidden="true">&rarr;</span>
		</button>
	</div>
</article>