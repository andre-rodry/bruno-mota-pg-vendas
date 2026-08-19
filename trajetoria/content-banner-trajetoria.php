<?php
/**
 * Template part: Banner — Página Trajetória -content-banner-trajetoria.php
 * "Uma trajetória de impacto."
 * Foto full-bleed de fundo (mesmo padrão do hero da página Atuação)
 *
 * @package andreWP
 */
?>

<section class="banner-trajetoria">

	<!-- Foto de fundo full-bleed -->
	<div class="banner-trajetoria__media" aria-hidden="true">
		<img
			src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/banner-trajetoria.png' ); ?>"
			alt=""
			class="banner-trajetoria__image"
		/>
	</div>

	<div class="banner-trajetoria__container">

		<div class="banner-trajetoria__content">

			<span class="banner-trajetoria__label">Trajetória</span>

			<h1 class="banner-trajetoria__title">
				Uma trajetória<br>
				<span class="banner-trajetoria__title--highlight">de impacto.</span>
			</h1>

			<span class="banner-trajetoria__divider" aria-hidden="true"></span>

			<p class="banner-trajetoria__text">
				Cada reconhecimento e trajetória reforça meu compromisso com a
				educação econômica, o desenvolvimento e a transformação social.
			</p>

			<div class="banner-trajetoria__stats">

				<div class="banner-trajetoria__stat">
					<span class="banner-trajetoria__stat-number">14+</span>
					<span class="banner-trajetoria__stat-label">Anos de atuação</span>
				</div>

				<div class="banner-trajetoria__stat">
					<span class="banner-trajetoria__stat-number">120+</span>
					<span class="banner-trajetoria__stat-label">Palestras</span>
				</div>

				<div class="banner-trajetoria__stat">
					<span class="banner-trajetoria__stat-number">05</span>
					<span class="banner-trajetoria__stat-label">Marcos históricos</span>
				</div>

			</div>

			<a href="#trajetoria-linha-do-tempo" class="banner-trajetoria__cta">
				<span class="banner-trajetoria__cta-icon" aria-hidden="true">
					<span class="banner-trajetoria__cta-dot"></span>
				</span>
				Role para explorar
			</a>

		</div>

	</div>

</section>