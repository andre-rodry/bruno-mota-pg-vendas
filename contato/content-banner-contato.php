<?php
/**
 * Template part: Banner de Contato
 *
 * Uso: get_template_part( 'template-parts/content', 'banner-contato' );
 * (ajuste o caminho conforme a organização de template-parts do tema)
 *
 * @package andreWP
 */
?>

<section class="banner-contato">

	<!-- Decoração de fundo (pontos dourados + brilhos) -->
	<div class="banner-contato__decor" aria-hidden="true">
		<span class="banner-contato__dots"></span>
	</div>

	<div class="banner-contato__container">

		<!-- Coluna de conteúdo -->
		<div class="banner-contato__content">

			<span class="banner-contato__label">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M4 5.5C4 4.67157 4.67157 4 5.5 4H18.5C19.3284 4 20 4.67157 20 5.5V15.5C20 16.3284 19.3284 17 18.5 17H9L5 20.5V17H5.5C4.67157 17 4 16.3284 4 15.5V5.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
				</svg>
				Contato
			</span>

			<h1 class="banner-contato__title">
				Vamos conversar<br>
				<span class="banner-contato__title-highlight">sobre o futuro.</span>
			</h1>

			<span class="banner-contato__divider"></span>

			<p class="banner-contato__text">
				Entre em contato para palestras, consultorias, entrevistas
				ou parcerias. Estou à disposição para contribuir com ideias
				e soluções que geram impacto real.
			</p>

			<div class="banner-contato__grid">

				<div class="banner-contato__item">
					<span class="banner-contato__icon">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M3 6.5C3 5.67157 3.67157 5 4.5 5H19.5C20.3284 5 21 5.67157 21 6.5V17.5C21 18.3284 20.3284 19 19.5 19H4.5C3.67157 19 3 18.3284 3 17.5V6.5Z" stroke="currentColor" stroke-width="1.5"/>
							<path d="M4 6.5L12 13L20 6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>
					<div class="banner-contato__item-text">
						<strong>E-mail</strong>
						<span><a href="mailto:contato@brunomota.com.br">contato@brunomota.com.br</a></span>
					</div>
				</div>

				<div class="banner-contato__item">
					<span class="banner-contato__icon">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M6.5 3H9L10.5 7L8.25 8.5C9.15 10.5 10.5 11.85 12.5 12.75L14 10.5L18 12V14.5C18 16.4 16.4 18 14.5 18C8.7 18 3 12.3 3 6.5C3 4.6 4.6 3 6.5 3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
						</svg>
					</span>
					<div class="banner-contato__item-text">
						<strong>Telefone</strong>
						<span><a href="tel:+5571999999999">(71) 99999-9999</a></span>
					</div>
				</div>

				<div class="banner-contato__item">
					<span class="banner-contato__icon">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 21C12 21 19 14.6 19 9.5C19 5.63401 15.866 2.5 12 2.5C8.13401 2.5 5 5.63401 5 9.5C5 14.6 12 21 12 21Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
							<circle cx="12" cy="9.5" r="2.25" stroke="currentColor" stroke-width="1.5"/>
						</svg>
					</span>
					<div class="banner-contato__item-text">
						<strong>Localização</strong>
						<span>Salvador, Bahia - Brasil</span>
					</div>
				</div>

				<div class="banner-contato__item">
					<span class="banner-contato__icon">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/>
							<path d="M12 7.5V12L15 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>
					<div class="banner-contato__item-text">
						<strong>Tempo de resposta</strong>
						<span>Retorno em até 24h úteis</span>
					</div>
				</div>

			</div>

			<div class="banner-contato__cta">
				<span class="banner-contato__cta-icon">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="3.5" y="5" width="17" height="15.5" rx="2" stroke="currentColor" stroke-width="1.5"/>
						<path d="M3.5 9.5H20.5" stroke="currentColor" stroke-width="1.5"/>
						<path d="M8 3V6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
						<path d="M16 3V6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
					</svg>
				</span>
				<div class="banner-contato__cta-text">
					<strong>Palestras e Eventos</strong>
					<p>Para convites, palestras e eventos, fale diretamente comigo.</p>
					<a href="#" class="banner-contato__cta-link">
						Quero convidar o Bruno
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5 12H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
							<path d="M13 6L19 12L13 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
				</div>
			</div>

		</div>

		<!-- Coluna de imagem -->
		<div class="banner-contato__media">
			<div class="banner-contato__glow" aria-hidden="true"></div>
			<img
				src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/contato/bruno-mota-economista-hero-contato.webp' ); ?>"
				alt="<?php esc_attr_e( 'Bruno Mota - Economista', 'andreWP' ); ?>"
				class="banner-contato__image"
				width="560"
				height="680"
				loading="eager"
				fetchpriority="high"
			>
		</div>

	</div>
</section>