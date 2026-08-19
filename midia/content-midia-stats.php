<?php
/**
 * Seção de estatísticas (cards) da página de Mídia
 * Exibida logo abaixo do banner
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança: evita acesso direto ao arquivo.
}
?>

<section class="midia-stats">
	<div class="midia-stats__container">
		<div class="midia-stats__grid">

			<div class="midia-stats__card">
				<span class="midia-stats__card-icon">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12 15a3 3 0 003-3V6a3 3 0 10-6 0v6a3 3 0 003 3z" stroke="currentColor" stroke-width="1.6"/>
						<path d="M19 11a7 7 0 01-14 0M12 18v3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
					</svg>
				</span>
				<strong class="midia-stats__card-number">+100</strong>
				<span class="midia-stats__card-label">Entrevistas</span>
			</div>

			<div class="midia-stats__card">
				<span class="midia-stats__card-icon">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="3" y="6" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.6"/>
						<path d="M8 21h8M9 3l3 3 3-3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</span>
				<strong class="midia-stats__card-number">12</strong>
				<span class="midia-stats__card-label">Emissoras</span>
			</div>

			<div class="midia-stats__card">
				<span class="midia-stats__card-icon">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="8.5" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/>
						<path d="M2.5 19c0-3 2.7-5.2 6-5.2s6 2.2 6 5.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
						<circle cx="17" cy="8.5" r="2.4" stroke="currentColor" stroke-width="1.6"/>
						<path d="M15.5 13.6c2.6.3 4.5 2.2 4.5 4.9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
					</svg>
				</span>
				<strong class="midia-stats__card-number">100 MIL+</strong>
				<span class="midia-stats__card-label">Espectadores</span>
			</div>

			<div class="midia-stats__card">
				<span class="midia-stats__card-icon">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="12" cy="12" r="2.4" stroke="currentColor" stroke-width="1.6"/>
						<path d="M8.5 8.5a5 5 0 000 7M15.5 8.5a5 5 0 010 7M5.5 5.5a9 9 0 000 13M18.5 5.5a9 9 0 010 13" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
					</svg>
				</span>
				<strong class="midia-stats__card-number">TV &bull; RÁDIO</strong>
				<span class="midia-stats__card-label">Podcasts &bull; Imprensa</span>
			</div>

		</div>
	</div>
</section>