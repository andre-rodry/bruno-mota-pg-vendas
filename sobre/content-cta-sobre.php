<?php
/**
 * Section: CTA / Acompanhe o trabalho
 * content-cta-sobre.php
 *
 * Faixa de call-to-action com ícone + texto à esquerda e dois botões
 * (Currículo Lattes / Canal no Youtube) à direita.
 *
 * Uso: get_template_part( 'template-parts/content', 'cta-sobre' );
 * (ajuste o caminho conforme a organização de template-parts do tema)
 *
 * @package andreWP
 */
?>

<section class="sobre-cta" aria-label="Acompanhe o trabalho">
	<div class="sobre-cta__container">

		<div class="sobre-cta__info">
			<span class="sobre-cta__icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12 3.5c4.7 0 8.5 3.13 8.5 7s-3.8 7-8.5 7c-.82 0-1.62-.1-2.36-.28L5.5 19l1.02-3.06C5.24 14.64 3.5 12.5 3.5 10.5c0-3.87 3.8-7 8.5-7Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
					<path d="M8.25 9.75h7.5M8.25 12.75h4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
				</svg>
			</span>

			<div class="sobre-cta__text">
				<h3 class="sobre-cta__title">Acompanhe o trabalho</h3>
				<p class="sobre-cta__desc">Palestras, análises e conteúdos exclusivos sobre economia e finanças.</p>
			</div>
		</div>

		<div class="sobre-cta__actions">

			<a href="#" class="sobre-cta__btn sobre-cta__btn--outline" target="_blank" rel="noopener">
				Currículo Lattes
			</a>

			<a href="#" class="sobre-cta__btn sobre-cta__btn--fill" target="_blank" rel="noopener">
				<span class="sobre-cta__btn-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M9 7.5v9l8-4.5-8-4.5Z" fill="currentColor"/>
					</svg>
				</span>
				Canal no Youtube
			</a>

		</div>

	</div>
</section>