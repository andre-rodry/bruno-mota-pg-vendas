<?php
/**
 * publicacoes/modal-publicacao.php
 *
 * Template VISUAL (HTML) do modal "Ler artigo" / "Ler publicação" usado
 * para Artigos e Revistas. É incluído dinamicamente por
 * inc/modal-publicacao.php (função andrewp_render_modal_publicacao_html),
 * que já deixa disponíveis as variáveis $post_id e $termo.
 *
 * Não declara nenhuma função aqui — apenas imprime HTML/PHP direto,
 * igual a um template part comum do WordPress.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$termo_slug = $termo ? $termo->slug : 'artigo';

/* Campos exclusivos: Artigo ou Revista, conforme o Tipo de Publicação. */
if ( 'revista' === $termo_slug ) {
	$banner_id       = absint( get_post_meta( $post_id, '_publicacao_banner_revista_id', true ) );
	$selo_texto      = get_post_meta( $post_id, '_publicacao_selo_texto_revista', true );
	$publicado_nome  = get_post_meta( $post_id, '_publicacao_publicado_por_nome_revista', true );
	$publicado_data  = get_post_meta( $post_id, '_publicacao_publicado_por_data_revista', true );
	$indicado_numero = get_post_meta( $post_id, '_publicacao_indicado_numero_revista', true );
	$indicado_texto  = get_post_meta( $post_id, '_publicacao_indicado_texto_revista', true );
} else {
	$banner_id       = absint( get_post_meta( $post_id, '_publicacao_banner_artigo_id', true ) );
	$selo_texto      = get_post_meta( $post_id, '_publicacao_selo_texto_artigo', true );
	$publicado_nome  = get_post_meta( $post_id, '_publicacao_publicado_por_nome_artigo', true );
	$publicado_data  = get_post_meta( $post_id, '_publicacao_publicado_por_data_artigo', true );
	$indicado_numero = get_post_meta( $post_id, '_publicacao_indicado_numero_artigo', true );
	$indicado_texto  = get_post_meta( $post_id, '_publicacao_indicado_texto_artigo', true );
}

if ( '' === $selo_texto ) {
	$selo_texto = andrewp_publicacao_selo_padrao( $termo_slug );
}

if ( ! $banner_id ) {
	$banner_id = get_post_thumbnail_id( $post_id );
}
$banner_url = $banner_id ? wp_get_attachment_image_url( $banner_id, 'large' ) : '';

/* Sobre o autor (compartilhado). */
$autor_nome = get_post_meta( $post_id, '_publicacao_autor_nome', true );
if ( '' === $autor_nome ) {
	$autor_nome = 'Bruno Mota';
}
$autor_bio        = get_post_meta( $post_id, '_publicacao_autor_bio', true );
$autor_avatar_id  = absint( get_post_meta( $post_id, '_publicacao_autor_avatar_id', true ) );
$autor_avatar_url = $autor_avatar_id ? wp_get_attachment_image_url( $autor_avatar_id, 'thumbnail' ) : '';

if ( '' === $publicado_nome ) {
	$publicado_nome = get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) );
}
if ( '' === $publicado_data ) {
	$publicado_data = get_the_date( 'd \d\e F \d\e Y', $post_id );
}

$veiculo     = get_post_meta( $post_id, '_publicacao_veiculo_nome', true );
$texto_final = get_post_meta( $post_id, '_publicacao_texto_final', true );

$cta_url      = get_post_meta( $post_id, '_publicacao_cta_url', true );
$whatsapp_url = get_post_meta( $post_id, '_publicacao_whatsapp_url', true );
if ( '' === $whatsapp_url ) {
	$whatsapp_url = 'https://wa.me/5571831168820';
}

$verbo_ler = andrewp_publicacoes_verbo_ler( $termo_slug );
?>

<div class="publicacao-modal__grid">

	<div class="publicacao-modal__banner">
		<?php if ( $banner_url ) : ?>
			<img class="publicacao-modal__banner-img" src="<?php echo esc_url( $banner_url ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>" />
		<?php endif; ?>
		<div class="publicacao-modal__banner-overlay">
			<p class="publicacao-modal__banner-titulo"><?php echo esc_html( get_the_title( $post_id ) ); ?></p>
			<?php if ( $veiculo ) : ?>
				<p class="publicacao-modal__banner-autor"><?php echo esc_html( $veiculo ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<div class="publicacao-modal__conteudo">

		<?php if ( $selo_texto ) : ?>
			<span class="publicacao-modal__selo">
				<span class="dashicons dashicons-yes"></span>
				<?php echo esc_html( strtoupper( $selo_texto ) ); ?>
			</span>
		<?php endif; ?>

		<h2 class="publicacao-modal__titulo"><?php echo esc_html( get_the_title( $post_id ) ); ?></h2>
		<?php if ( $veiculo ) : ?>
			<p class="publicacao-modal__autor"><?php echo esc_html( $veiculo ); ?></p>
		<?php endif; ?>

		<div class="publicacao-modal__resumo">
			<?php echo wpautop( wp_kses_post( get_post_field( 'post_content', $post_id ) ) ); ?>
		</div>

		<?php if ( $publicado_nome || $publicado_data ) : ?>
			<div class="publicacao-modal__linha publicacao-modal__linha--publicado">
				<div class="publicacao-modal__linha-icone">
					<span class="dashicons dashicons-calendar-alt"></span>
				</div>
				<div class="publicacao-modal__linha-texto">
					<small><?php esc_html_e( 'Publicado por', 'andrewp' ); ?></small>
					<strong><?php echo esc_html( $publicado_nome ); ?></strong>
					<span><?php echo esc_html( $publicado_data ); ?></span>
				</div>
			</div>
		<?php endif; ?>

		<div class="publicacao-modal__linha">
			<div class="publicacao-modal__avatar">
				<?php if ( $autor_avatar_url ) : ?>
					<img src="<?php echo esc_url( $autor_avatar_url ); ?>" alt="<?php echo esc_attr( $autor_nome ); ?>" />
				<?php else : ?>
					<?php echo esc_html( mb_substr( $autor_nome, 0, 1 ) ); ?>
				<?php endif; ?>
			</div>
			<div class="publicacao-modal__linha-texto">
				<small><?php esc_html_e( 'Sobre o autor', 'andrewp' ); ?></small>
				<strong><?php echo esc_html( $autor_nome ); ?></strong>
				<?php if ( $autor_bio ) : ?>
					<span><?php echo esc_html( $autor_bio ); ?></span>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $indicado_texto || $indicado_numero ) : ?>
			<div class="publicacao-modal__linha">
				<div class="publicacao-modal__numero"><?php echo esc_html( $indicado_numero ); ?></div>
				<div class="publicacao-modal__linha-texto">
					<small><?php esc_html_e( 'Conteúdo indicado para', 'andrewp' ); ?></small>
					<span><?php echo esc_html( $indicado_texto ); ?></span>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $texto_final ) : ?>
			<blockquote class="publicacao-modal__resumo" style="border-left:3px solid var(--gold-accent); padding-left:14px; font-style:italic; margin:20px 0;">
				<?php echo esc_html( $texto_final ); ?>
			</blockquote>
		<?php endif; ?>

		<div class="publicacao-modal__botoes">
			<?php if ( $cta_url ) : ?>
				<a href="<?php echo esc_url( $cta_url ); ?>" target="_blank" rel="noopener" class="publicacao-modal__botao publicacao-modal__botao--principal">
					<span class="dashicons dashicons-external"></span>
					<?php
					/* translators: %s: "artigo", "publicação", "livro" ou "capítulo" */
					printf( esc_html__( 'Acessar %s', 'andrewp' ), esc_html( $verbo_ler ) );
					?>
				</a>
			<?php endif; ?>
			<a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener" class="publicacao-modal__botao publicacao-modal__botao--secundario">
				<span class="dashicons dashicons-whatsapp"></span>
				<?php esc_html_e( 'Falar com o autor', 'andrewp' ); ?>
			</a>
		</div>

	</div>

</div>