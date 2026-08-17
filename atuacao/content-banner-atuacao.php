<?php
/**
 * Template part: Banner Atuação
 * content-banner-atuacao.php
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<svg width="0" height="0" style="position:absolute;overflow:hidden" aria-hidden="true">
	<filter id="feather-cutout">
		<feMorphology operator="erode" radius="0.4" in="SourceAlpha" result="eroded"/>
		<feGaussianBlur in="eroded" stdDeviation="1.2" result="blurred"/>
		<feComposite in="SourceGraphic" in2="blurred" operator="in"/>
	</filter>
</svg>

<section class="atuacao-banner" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/img/atuacao/bruno-mota-economista-areas-de-atuacao.webp' ); ?>');">
	<div class="atuacao-banner__container">

		<div class="atuacao-banner__content">

			<span class="atuacao-banner__badge">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M3 17l6-6 4 4 8-8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				ATUAÇÃO
			</span>

			<h1 class="atuacao-banner__title">
				Economia <span class="atuacao-banner__title-highlight">prática</span>.<br>
				Resultados <span class="atuacao-banner__title-highlight">reais</span>.
			</h1>

			<p class="atuacao-banner__lead">
				Consultoria, palestras, educação financeira e projetos de impacto social.
			</p>

			<hr class="atuacao-banner__divider">

			<a href="#" class="atuacao-banner__cta">
				<span class="atuacao-banner__cta-icon">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="3.5" y="5" width="17" height="15.5" rx="2" stroke="currentColor" stroke-width="1.5"/>
						<path d="M3.5 9.5h17" stroke="currentColor" stroke-width="1.5"/>
						<path d="M8 3v3.5M16 3v3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
					</svg>
				</span>
				Agendar um contato
			</a>

		</div>

		<div class="atuacao-banner__foto">
			<!-- Backer: silhueta escura sólida, mesma foto. Fica atrás de
			     TUDO (inclusive do glow) para tapar qualquer vazamento do
			     fundo através de bordas semitransparentes do recorte. -->
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/atuacao/bruno-mota-sobre.webp' ); ?>"
				 class="atuacao-banner__foto-backer"
				 alt=""
				 aria-hidden="true" />

			<span class="atuacao-banner__foto-glow" aria-hidden="true"></span>

			<!-- Halo: cópia da mesma foto, desfocada, entra ANTES da nítida
			     no markup para ficar atrás dela (z-index menor). -->
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/atuacao/bruno-mota-sobre.webp' ); ?>"
				 class="atuacao-banner__foto-halo"
				 alt=""
				 aria-hidden="true" />

			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/atuacao/bruno-mota-sobre.webp' ); ?>"
				 class="atuacao-banner__foto-img"
				 alt="Bruno Mota, economista" />

			<span class="atuacao-banner__foto-fade" aria-hidden="true"></span>
		</div>

	</div>
</section>