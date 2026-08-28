<?php
/**
 * Template Part: CTA Mídia
 */

$cta_midia_eyebrow     = $cta_midia_eyebrow     ?? 'Vamos conversar?';
$cta_midia_titulo      = $cta_midia_titulo      ?? 'Quer levar uma visão';
$cta_midia_titulo_gold = $cta_midia_titulo_gold ?? 'econômica para o seu público?';
$cta_midia_descricao   = $cta_midia_descricao   ?? 'Bruno Mota participa de entrevistas, programas, podcasts e projetos de mídia, levando análises econômicas claras, relevantes e conectadas aos desafios do Brasil.';
$cta_midia_botao_texto = $cta_midia_botao_texto ?? 'Convide para uma participação';
$cta_midia_botao_link  = $cta_midia_botao_link  ?? '#contato';

$cta_midia_imagem      = $cta_midia_imagem      ?? get_template_directory_uri() . '/assets/img/midia/bruno-mota-economista-podcast-entrevista-microfone.webp';
?>

<section class="cta-midia-section">

	<img
		src="<?php echo esc_url( $cta_midia_imagem ); ?>"
		alt="Bruno Mota em entrevista de podcast com microfone"
		class="cta-midia__bg-img"
		loading="lazy"
	>

	<div class="cta-midia__overlay"></div>

	<div class="cta-midia__container">
		<div class="cta-midia__conteudo">

			<p class="cta-midia__eyebrow"><?php echo esc_html( $cta_midia_eyebrow ); ?></p>

			<h2 class="cta-midia__titulo">
				<?php echo esc_html( $cta_midia_titulo ); ?><br>
				<span class="cta-midia__titulo--gold"><?php echo esc_html( $cta_midia_titulo_gold ); ?></span>
			</h2>

			<p class="cta-midia__descricao"><?php echo esc_html( $cta_midia_descricao ); ?></p>

			<a href="<?php echo esc_url( $cta_midia_botao_link ); ?>" class="cta-midia__botao">
				<svg class="cta-midia__botao-icone" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12 15a3 3 0 0 0 3-3V6a3 3 0 0 0-6 0v6a3 3 0 0 0 3 3Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M19 11v1a7 7 0 0 1-14 0v-1M12 19v3M9 22h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<span><?php echo esc_html( strtoupper( $cta_midia_botao_texto ) ); ?></span>
				<svg class="cta-midia__botao-seta" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</a>

		</div>
	</div>

</section>