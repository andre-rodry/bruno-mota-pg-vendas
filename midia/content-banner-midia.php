<?php
/**
 * Banner (Hero) da página de Mídia
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança: evita acesso direto ao arquivo.
}
?>

<section class="banner-midia" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/assets/img/midia/midia-hero-bg.webp' ); ?>');">
	<div class="banner-midia__container">
		<div class="banner-midia__content">

			<span class="banner-midia__badge">
				<svg class="banner-midia__badge-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M4 6a2 2 0 0 1 2-2h9l5 5v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M15 4v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
					<circle cx="9" cy="14" r="2" stroke="currentColor" stroke-width="1.6"/>
					<line x1="13" y1="12" x2="17" y2="12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
					<line x1="13" y1="16" x2="17" y2="16" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
				</svg>
				Mídia
			</span>

			<h1 class="banner-midia__title">
				Economia em destaque<br>
				<span class="banner-midia__title-gold">na mídia nacional e regional</span>
			</h1>

			<p class="banner-midia__lead">
				Entrevistas, análises econômicas e participações em televisão, rádio, podcasts e imprensa.
			</p>

			<hr class="banner-midia__divider">

			<p class="banner-midia__description">
				Levando educação financeira e economia para milhares de pessoas através de conteúdos relevantes na TV, rádio, podcasts e imprensa nacional e regional.
			</p>

			<div class="banner-midia__stats">

				<div class="banner-midia__stat">
					<span class="banner-midia__stat-icon">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 15a3 3 0 003-3V6a3 3 0 10-6 0v6a3 3 0 003 3z" stroke="currentColor" stroke-width="1.6"/>
							<path d="M19 11a7 7 0 01-14 0M12 18v3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
						</svg>
					</span>
					<span class="banner-midia__stat-info">
						<strong>+100</strong>
						<small>Entrevistas</small>
					</span>
				</div>

				<span class="banner-midia__stat-divider"></span>

				<div class="banner-midia__stat">
					<span class="banner-midia__stat-icon">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect x="3" y="6" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.6"/>
							<path d="M8 21h8M9 3l3 3 3-3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>
					<span class="banner-midia__stat-info">
						<strong>12</strong>
						<small>Emissoras</small>
					</span>
				</div>

				<span class="banner-midia__stat-divider"></span>

				<div class="banner-midia__stat">
					<span class="banner-midia__stat-icon">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="8.5" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/>
							<path d="M2.5 19c0-3 2.7-5.2 6-5.2s6 2.2 6 5.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
							<circle cx="17" cy="8.5" r="2.4" stroke="currentColor" stroke-width="1.6"/>
							<path d="M15.5 13.6c2.6.3 4.5 2.2 4.5 4.9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
						</svg>
					</span>
					<span class="banner-midia__stat-info">
						<strong>100 MIL+</strong>
						<small>Espectadores</small>
					</span>
				</div>

				<span class="banner-midia__stat-divider"></span>

				<div class="banner-midia__stat">
					<span class="banner-midia__stat-icon banner-midia__stat-icon--radio">
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="12" cy="12" r="2.4" stroke="currentColor" stroke-width="1.6"/>
							<path d="M8.5 8.5a5 5 0 000 7M15.5 8.5a5 5 0 010 7M5.5 5.5a9 9 0 000 13M18.5 5.5a9 9 0 010 13" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
						</svg>
					</span>
					<span class="banner-midia__stat-info">
						<strong>TV &bull; RÁDIO</strong>
						<small>Podcasts &bull; Imprensa</small>
					</span>
				</div>

			</div>

		</div>
	</div>
</section>