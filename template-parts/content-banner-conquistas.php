<?php
/**
 * Template part: Banner — Página Conquistas -content-banner-conquistas.php
 * "Uma trajetória de impacto."
 * Foto full-bleed de fundo (mesmo padrão do hero da página Atuação)
 *
 * @package andreWP
 */
?>

<section class="banner-conquistas">

	<!-- Foto de fundo full-bleed -->
	<div class="banner-conquistas__media" aria-hidden="true">
		<img
			src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/banner-conquistas.png' ); ?>"
			alt=""
			class="banner-conquistas__image"
		/>
	</div>

	<div class="banner-conquistas__container">

		<div class="banner-conquistas__content">

			<span class="banner-conquistas__label">Conquistas</span>

			<h1 class="banner-conquistas__title">
				Uma trajetória<br>
				<span class="banner-conquistas__title--highlight">de impacto.</span>
			</h1>

			<span class="banner-conquistas__divider" aria-hidden="true"></span>

			<p class="banner-conquistas__text">
				Cada reconhecimento e conquista reforça meu compromisso com a
				educação econômica, o desenvolvimento e a transformação social.
			</p>

			<div class="banner-conquistas__stats">

				<div class="banner-conquistas__stat">
					<span class="banner-conquistas__stat-number">14+</span>
					<span class="banner-conquistas__stat-label">Anos de atuação</span>
				</div>

				<div class="banner-conquistas__stat">
					<span class="banner-conquistas__stat-number">120+</span>
					<span class="banner-conquistas__stat-label">Palestras</span>
				</div>

				<div class="banner-conquistas__stat">
					<span class="banner-conquistas__stat-number">05</span>
					<span class="banner-conquistas__stat-label">Marcos históricos</span>
				</div>

			</div>

			<a href="#conquistas-linha-do-tempo" class="banner-conquistas__cta">
				<span class="banner-conquistas__cta-icon" aria-hidden="true">
					<span class="banner-conquistas__cta-dot"></span>
				</span>
				Role para explorar
			</a>

		</div>

	</div>

</section>