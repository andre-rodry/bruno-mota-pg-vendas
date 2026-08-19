<?php
/**
 * Template visual do modal "Ver mais" de uma trajetoria.
 * Sem abas — tudo exibido numa única tela, na ordem do mockup original.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$badge_label = get_post_meta( $post_id, '_trajetoria_badge_label', true );
$icone_slug  = get_post_meta( $post_id, '_trajetoria_icone', true );
$local       = get_post_meta( $post_id, '_trajetoria_local', true );
$subtitulo   = get_post_meta( $post_id, '_trajetoria_subtitulo', true );
$resumo      = get_post_field( 'post_content', $post_id );
$resumo      = wp_strip_all_tags( $resumo ); // remove marcações de bloco (wp:paragraph etc).

$destaques_icone     = (array) get_post_meta( $post_id, '_trajetoria_destaques_icone', true );
$destaques_titulo    = (array) get_post_meta( $post_id, '_trajetoria_destaques_titulo', true );
$destaques_descricao = (array) get_post_meta( $post_id, '_trajetoria_destaques_descricao', true );

// Galeria: URLs de teste têm prioridade; se vazio, usa attachment IDs.
$galeria_urls_raw = get_post_meta( $post_id, '_trajetoria_galeria_urls', true );
$galeria_urls     = $galeria_urls_raw ? array_filter( array_map( 'trim', explode( "\n", $galeria_urls_raw ) ) ) : array();

$imagens = array();
if ( ! empty( $galeria_urls ) ) {
	$imagens = array_values( $galeria_urls );
} else {
	$galeria_ids = get_post_meta( $post_id, '_trajetoria_galeria', true );
	$galeria_ids = $galeria_ids ? array_filter( array_map( 'absint', explode( ',', $galeria_ids ) ) ) : array();
	foreach ( $galeria_ids as $img_id ) {
		$src = wp_get_attachment_image_url( $img_id, 'large' );
		if ( $src ) {
			$imagens[] = $src;
		}
	}
}

$doc_titulo    = (array) get_post_meta( $post_id, '_trajetoria_doc_titulo', true );
$doc_descricao = (array) get_post_meta( $post_id, '_trajetoria_doc_descricao', true );
$doc_arquivo   = (array) get_post_meta( $post_id, '_trajetoria_doc_arquivo_id', true );

$impacto = (array) get_post_meta( $post_id, '_trajetoria_impacto', true );

$cta_texto = get_post_meta( $post_id, '_trajetoria_cta_texto', true );
$cta_url   = get_post_meta( $post_id, '_trajetoria_cta_url', true );

$icone_dashicon = andrewp_trajetoria_icone_dashicon( $icone_slug );
?>

<button class="trajetoria-modal__fechar" aria-label="<?php esc_attr_e( 'Fechar', 'andrewp' ); ?>">
	<span class="dashicons dashicons-no-alt"></span>
</button>

<div class="trajetoria-modal__inner">

	<!-- Header -->
	<div class="trajetoria-modal__header">
		<div class="trajetoria-modal__icone">
			<span class="dashicons <?php echo esc_attr( $icone_dashicon ); ?>"></span>
		</div>
		<div>
			<?php if ( $badge_label ) : ?>
				<span class="trajetoria-modal__badge"><?php echo esc_html( $badge_label ); ?></span>
			<?php endif; ?>
			<h2 class="trajetoria-modal__titulo"><?php echo esc_html( get_the_title( $post_id ) ); ?></h2>
			<?php if ( $local ) : ?>
				<p class="trajetoria-modal__local">
					<span class="dashicons dashicons-location"></span>
					<?php echo esc_html( $local ); ?>
				</p>
			<?php endif; ?>
			<?php if ( $subtitulo ) : ?>
				<p class="trajetoria-modal__subtitulo"><?php echo esc_html( $subtitulo ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( $resumo ) : ?>
		<p class="trajetoria-modal__resumo-texto"><?php echo esc_html( $resumo ); ?></p>
	<?php endif; ?>

	<!-- Destaques (moldura dourada) + Fotos, lado a lado -->
	<div class="trajetoria-modal__resumo-grid">

		<?php if ( ! empty( $destaques_titulo ) ) : ?>
			<div class="trajetoria-modal__destaques-box">
				<ul class="trajetoria-modal__destaques">
					<?php foreach ( $destaques_titulo as $i => $titulo ) : ?>
						<?php
						$d_icone = isset( $destaques_icone[ $i ] ) ? andrewp_trajetoria_icone_dashicon( $destaques_icone[ $i ] ) : 'dashicons-tag';
						$d_desc  = isset( $destaques_descricao[ $i ] ) ? $destaques_descricao[ $i ] : '';
						?>
						<li class="trajetoria-modal__destaque-item">
							<span class="trajetoria-modal__destaque-icone">
								<span class="dashicons <?php echo esc_attr( $d_icone ); ?>"></span>
							</span>
							<div>
								<strong><?php echo esc_html( $titulo ); ?></strong>
								<?php if ( $d_desc ) : ?>
									<p><?php echo esc_html( $d_desc ); ?></p>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $imagens ) ) : ?>
			<div class="trajetoria-modal__resumo-col-fotos">
				<div class="trajetoria-modal__galeria-grid">
					<?php foreach ( array_slice( $imagens, 0, 4 ) as $src ) : ?>
						<div class="trajetoria-modal__galeria-item">
							<img src="<?php echo esc_url( $src ); ?>" alt="" loading="lazy" />
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

	</div>

	<!-- Impacto: abaixo das fotos, full width -->
	<?php if ( ! empty( $impacto ) ) : ?>
		<div class="trajetoria-modal__impacto-bar">
			<div class="trajetoria-modal__impacto-label">
				<span class="dashicons dashicons-star-filled"></span>
				<?php esc_html_e( 'Impacto deste marco', 'andrewp' ); ?>
			</div>
			<div class="trajetoria-modal__impacto-grid">
				<?php foreach ( $impacto as $item ) : ?>
					<div class="trajetoria-modal__impacto-item">
						<span class="dashicons dashicons-yes-alt"></span>
						<?php echo esc_html( $item ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Documentos: lado a lado, uma linha -->
	<?php if ( ! empty( $doc_titulo ) ) : ?>
		<p class="trajetoria-modal__docs-section-title"><?php esc_html_e( 'Documentos e materiais', 'andrewp' ); ?></p>
		<div class="trajetoria-modal__docs-grid">
			<?php foreach ( $doc_titulo as $i => $titulo ) : ?>
				<?php
				$desc = isset( $doc_descricao[ $i ] ) ? $doc_descricao[ $i ] : '';
				$arq  = isset( $doc_arquivo[ $i ] ) ? absint( $doc_arquivo[ $i ] ) : 0;
				$url  = $arq ? wp_get_attachment_url( $arq ) : '#';
				?>
				<a class="trajetoria-modal__doc-card" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener">
					<span class="dashicons dashicons-media-document trajetoria-modal__doc-icone"></span>
					<span class="trajetoria-modal__doc-info">
						<strong><?php echo esc_html( $titulo ); ?></strong>
						<?php if ( $desc ) : ?>
							<span class="trajetoria-modal__doc-desc"><?php echo esc_html( $desc ); ?></span>
						<?php endif; ?>
					</span>
					<span class="dashicons dashicons-download trajetoria-modal__doc-baixar"></span>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>


</div>