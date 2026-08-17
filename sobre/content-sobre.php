<?php
/**
 * Template part: Banner Sobre
 *
 * Uso: get_template_part( 'template-parts/content', 'sobre' );
 * (ajuste o caminho conforme a organização de template-parts do tema)
 *
 * @package andreWP
 */
?>

<section class="sobre-banner">

	<!-- Filtro SVG (invisível): suaviza a borda do recorte da imagem,
	     borrando apenas o canal alpha e recompondo com a imagem nítida. -->
	<svg width="0" height="0" style="position:absolute;overflow:hidden">
		<filter id="feather-cutout-sobre" x="-20%" y="-20%" width="140%" height="140%">
			<feComponentTransfer in="SourceAlpha" result="alpha-solid">
				<feFuncA type="table" tableValues="0 1"/>
			</feComponentTransfer>
			<feGaussianBlur in="alpha-solid" stdDeviation="7" result="alpha-blur"/>
			<feComposite in="SourceGraphic" in2="alpha-blur" operator="in"/>
		</filter>
	</svg>

	<!-- Decoração de fundo (pontos dourados, igual ao banner de Contato) -->
	<div class="sobre-banner__decor" aria-hidden="true">
		<span class="sobre-banner__dots"></span>
	</div>

	<div class="sobre-banner__container">

		<!-- Coluna de conteúdo -->
		<div class="sobre-banner__content">

			<span class="sobre-banner__label">Sobre</span>

			<h1 class="sobre-banner__title">
				Bruno <span class="sobre-banner__title-highlight">Mota</span>
			</h1>

			<p class="sobre-banner__subtitle">
				Economia com propósito para transformar vidas, empresas e o Brasil.
			</p>

			<p class="sobre-banner__text">
				Economista, professor universitário e pesquisador, com atuação
				voltada ao desenvolvimento regional, educação financeira e
				políticas públicas.
			</p>

			<div class="sobre-banner__badges">

				<div class="sobre-banner__badge">
					<span class="sobre-banner__badge-icon">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="12" cy="8" r="3.25" stroke="currentColor" stroke-width="1.5"/>
							<path d="M5 20C5 16.4101 8.13401 13.5 12 13.5C15.866 13.5 19 16.4101 19 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
						</svg>
					</span>
					<span>Conselheiro<br>Corecon-BA</span>
				</div>

				<div class="sobre-banner__badge">
					<span class="sobre-banner__badge-icon">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.5"/>
							<circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/>
						</svg>
					</span>
					<span>Pesquisador<br>UNIFACS</span>
				</div>

				<div class="sobre-banner__badge">
					<span class="sobre-banner__badge-icon">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect x="9.25" y="3" width="5.5" height="10" rx="2.75" stroke="currentColor" stroke-width="1.5"/>
							<path d="M6 11C6 14.3137 8.68629 17 12 17C15.3137 17 18 14.3137 18 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
							<path d="M12 17V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
							<path d="M8.5 21H15.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
						</svg>
					</span>
					<span>Autor e Palestrante<br>Internacional</span>
				</div>

			</div>

			<a href="#trajetoria" class="sobre-banner__cta">
				Conheça a trajetória
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 12H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
					<path d="M13 6L19 12L13 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</a>

		</div>

		<!-- Coluna de imagem -->
		<div class="sobre-banner__media">
			<div class="sobre-banner__glow" aria-hidden="true"></div>
			<img
				src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/sobre/bruno-mota-sobre.webp' ); ?>"
				alt="<?php esc_attr_e( 'Bruno Mota - Economista', 'andreWP' ); ?>"
				class="sobre-banner__image"
				width="560"
				height="680"
				loading="eager"
				fetchpriority="high"
			>
		</div>

	</div>
</section>