<?php
/**
 * publicacoes/modal-publicacao-livro.php
 *
 * Template VISUAL (HTML) do modal "Ler livro" / "Ler capítulo" usado
 * para Livros e Capítulos de Livro. É incluído dinamicamente por
 * inc/modal-publicacao.php (função andrewp_render_modal_publicacao_html),
 * que já deixa disponíveis as variáveis $post_id e $termo.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$termo_slug = $termo ? $termo->slug : 'livro';

/* Campos exclusivos de Livro / Capítulo de Livro. */
$banner_id = absint( get_post_meta( $post_id, '_publicacao_banner_livro_id', true ) );
if ( ! $banner_id ) {
	$banner_id = get_post_thumbnail_id( $post_id );
}
$banner_url = $banner_id ? wp_get_attachment_image_url( $banner_id, 'large' ) : '';

$subtitulo     = get_post_meta( $post_id, '_publicacao_subtitulo', true );
$organizadores = get_post_meta( $post_id, '_publicacao_organizadores', true );
$editora       = get_post_meta( $post_id, '_publicacao_editora', true );
$paginas       = get_post_meta( $post_id, '_publicacao_paginas', true );
$isbn          = get_post_meta( $post_id, '_publicacao_isbn', true );

$ano = get_post_meta( $post_id, '_publicacao_ano', true );
if ( '' === $ano ) {
	$ano = get_the_date( 'Y', $post_id );
}

$evento_titulo  = get_post_meta( $post_id, '_publicacao_evento_titulo', true );
$evento_texto   = get_post_meta( $post_id, '_publicacao_evento_texto', true );
$evento_img_id  = absint( get_post_meta( $post_id, '_publicacao_evento_imagem_id', true ) );
$evento_img_url = $evento_img_id ? wp_get_attachment_image_url( $evento_img_id, 'thumbnail' ) : '';

$texto_final = get_post_meta( $post_id, '_publicacao_texto_final', true );

$gratuito     = (bool) get_post_meta( $post_id, '_publicacao_gratuito', true );
$cta_url      = get_post_meta( $post_id, '_publicacao_cta_url', true );
$whatsapp_url = get_post_meta( $post_id, '_publicacao_whatsapp_url', true );
if ( '' === $whatsapp_url ) {
	$whatsapp_url = 'https://wa.me/5571831168820';
}
$download_url = get_post_meta( $post_id, '_publicacao_download_url', true );
?>

<div class="publicacao-modal__grid">

	<div class="publicacao-modal__banner">
		<?php if ( $banner_url ) : ?>
			<img class="publicacao-modal__banner-img" src="<?php echo esc_url( $banner_url ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" />
		<?php endif; ?>
	</div>

	<div class="publicacao-modal__conteudo">

		<h2 class="publicacao-modal__titulo"><?php echo esc_html( get_the_title( $post_id ) ); ?></h2>

		<?php if ( $subtitulo ) : ?>
			<p class="publicacao-modal__autor" style="border-left:3px solid var(--gold-accent); padding-left:10px;">
				<?php echo esc_html( $subtitulo ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $organizadores ) : ?>
			<p style="color:var(--text-soft-light); font-family:var(--font-body); font-size:14px; margin:8px 0 0;">
				<?php echo esc_html( $organizadores ); ?>
			</p>
		<?php endif; ?>

		<div class="publicacao-modal__resumo">
			<?php echo wpautop( wp_kses_post( get_post_field( 'post_content', $post_id ) ) ); ?>
		</div>

		<div class="publicacao-modal__metas" style="grid-template-columns: repeat(4, 1fr);">
			<div class="publicacao-modal__meta">
				<span class="dashicons dashicons-calendar-alt"></span>
				<span>
					<strong><?php esc_html_e( 'Ano', 'andrewp' ); ?></strong>
					<small><?php echo esc_html( $ano ); ?></small>
				</span>
			</div>
			<?php if ( $editora ) : ?>
				<div class="publicacao-modal__meta">
					<span class="dashicons dashicons-building"></span>
					<span>
						<strong><?php esc_html_e( 'Editora', 'andrewp' ); ?></strong>
						<small><?php echo esc_html( $editora ); ?></small>
					</span>
				</div>
			<?php endif; ?>
			<?php if ( $paginas ) : ?>
				<div class="publicacao-modal__meta">
					<span class="dashicons dashicons-media-document"></span>
					<span>
						<strong><?php esc_html_e( 'Páginas', 'andrewp' ); ?></strong>
						<small><?php echo esc_html( $paginas ); ?></small>
					</span>
				</div>
			<?php endif; ?>
			<?php if ( $isbn ) : ?>
				<div class="publicacao-modal__meta">
					<span class="dashicons dashicons-tag"></span>
					<span>
						<strong><?php esc_html_e( 'ISBN', 'andrewp' ); ?></strong>
						<small><?php echo esc_html( $isbn ); ?></small>
					</span>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $evento_titulo || $evento_texto ) : ?>
			<div class="publicacao-modal__linha">
				<div class="publicacao-modal__linha-icone">
					<span class="dashicons dashicons-star-filled"></span>
				</div>
				<div class="publicacao-modal__linha-texto">
					<?php if ( $evento_titulo ) : ?>
						<strong><?php echo esc_html( $evento_titulo ); ?></strong>
					<?php endif; ?>
					<?php if ( $evento_texto ) : ?>
						<span><?php echo esc_html( $evento_texto ); ?></span>
					<?php endif; ?>
				</div>
				<?php if ( $evento_img_url ) : ?>
					<img src="<?php echo esc_url( $evento_img_url ); ?>" alt="" style="width:56px; height:56px; object-fit:contain; flex:0 0 auto;" />
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $texto_final ) : ?>
			<blockquote class="publicacao-modal__resumo" style="border-left:3px solid var(--gold-accent); padding-left:14px; font-style:italic; margin:20px 0;">
				<?php echo esc_html( $texto_final ); ?>
			</blockquote>
		<?php endif; ?>

		<div class="publicacao-modal__botoes">
			<?php if ( $gratuito ) : ?>
				<?php if ( $download_url ) : ?>
					<a href="<?php echo esc_url( $download_url ); ?>" target="_blank" rel="noopener" class="publicacao-modal__botao publicacao-modal__botao--principal">
						<span class="dashicons dashicons-download"></span>
						<?php esc_html_e( 'Baixar exemplar gratuitamente', 'andrewp' ); ?>
					</a>
				<?php endif; ?>
				<?php if ( $cta_url ) : ?>
					<a href="<?php echo esc_url( $cta_url ); ?>" target="_blank" rel="noopener" class="publicacao-modal__botao publicacao-modal__botao--secundario">
						<span class="dashicons dashicons-external"></span>
						<?php esc_html_e( 'Acessar publicação', 'andrewp' ); ?>
					</a>
				<?php endif; ?>
			<?php else : ?>
				<?php if ( $cta_url ) : ?>
					<a href="<?php echo esc_url( $cta_url ); ?>" target="_blank" rel="noopener" class="publicacao-modal__botao publicacao-modal__botao--principal">
						<span class="dashicons dashicons-cart"></span>
						<?php esc_html_e( 'Solicitar exemplar', 'andrewp' ); ?>
					</a>
				<?php endif; ?>
			<?php endif; ?>
			<a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener" class="publicacao-modal__botao publicacao-modal__botao--secundario">
				<span class="dashicons dashicons-whatsapp"></span>
				<?php esc_html_e( 'Falar com o autor', 'andrewp' ); ?>
			</a>
		</div>

	</div>

</div>