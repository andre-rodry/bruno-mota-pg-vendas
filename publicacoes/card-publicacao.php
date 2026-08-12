<?php
/**
 * Template part: linha de publicação na lista
 * (usado por publicacoes/content-lista-publicacoes.php e pelo AJAX
 * em inc/ajax-publicacoes.php)
 *
 * @package andreWP
 */

$post_id  = get_the_ID();
$veiculo  = get_post_meta( $post_id, '_publicacao_veiculo_nome', true );
$ano      = get_post_meta( $post_id, '_publicacao_ano', true );
$ano      = $ano ? $ano : get_the_date( 'Y' );
$termo    = andrewp_publicacao_termo_principal( $post_id );
$tipo_lbl = $termo ? $termo->name : '';
?>
<article class="lista-publicacoes__item" data-post-id="<?php echo esc_attr( $post_id ); ?>">

	<div class="lista-publicacoes__logo">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'thumbnail', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="lista-publicacoes__logo-fallback"><?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></span>
		<?php endif; ?>
	</div>

	<div class="lista-publicacoes__info">
		<h3 class="lista-publicacoes__titulo"><?php the_title(); ?></h3>
		<p class="lista-publicacoes__meta">
			<?php if ( $veiculo ) : ?>
				<span class="lista-publicacoes__veiculo"><?php echo esc_html( $veiculo ); ?></span>
			<?php elseif ( $tipo_lbl ) : ?>
				<span class="lista-publicacoes__veiculo"><?php echo esc_html( $tipo_lbl ); ?></span>
			<?php endif; ?>
			<span class="lista-publicacoes__ano"><?php echo esc_html( $ano ); ?></span>
		</p>
	</div>

	<button type="button" class="lista-publicacoes__ler js-abrir-publicacao" data-post-id="<?php echo esc_attr( $post_id ); ?>">
		<?php
		/* translators: %s = tipo de publicação (ex: "artigo", "livro") */
		echo esc_html( sprintf( __( 'Ler %s', 'andrewp' ), $termo ? andrewp_publicacoes_verbo_ler( $termo->slug ) : 'publicação' ) );
		?>
		<span class="dashicons dashicons-arrow-right-alt2" aria-hidden="true"></span>
	</button>

</article>