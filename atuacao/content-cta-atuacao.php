<?php
/**
 * Section: CTA / Vamos conversar?
 * content-cta-atuacao.php
 *
 * Faixa de call-to-action com ícone + texto à esquerda e um botão
 * (Agendar um contato) à direita.
 *
 * Uso: get_template_part( 'template-parts/content', 'cta-atuacao' );
 * (ajuste o caminho conforme a organização de template-parts do tema)
 *
 * @package andreWP
 */
?>

<section class="atuacao-cta" aria-label="Vamos conversar?">
	<div class="atuacao-cta__container">

		<div class="atuacao-cta__info">
			<span class="atuacao-cta__icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12 3.5c4.7 0 8.5 3.13 8.5 7s-3.8 7-8.5 7c-.82 0-1.62-.1-2.36-.28L5.5 19l1.02-3.06C5.24 14.64 3.5 12.5 3.5 10.5c0-3.87 3.8-7 8.5-7Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
					<circle cx="9" cy="10.5" r=".9" fill="currentColor"/>
					<circle cx="12" cy="10.5" r=".9" fill="currentColor"/>
					<circle cx="15" cy="10.5" r=".9" fill="currentColor"/>
				</svg>
			</span>

			<div class="atuacao-cta__text">
				<h3 class="atuacao-cta__title">Vamos conversar?</h3>
				<p class="atuacao-cta__desc">Leve conhecimento econômico para sua empresa, instituição ou projeto.</p>
			</div>
		</div>

		<div class="atuacao-cta__actions">

			<a href="#" class="atuacao-cta__btn atuacao-cta__btn--fill">
				<span class="atuacao-cta__btn-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="3.5" y="5" width="17" height="15.5" rx="2" stroke="currentColor" stroke-width="1.5"/>
						<path d="M3.5 9.5h17" stroke="currentColor" stroke-width="1.5"/>
						<path d="M8 3v3.5M16 3v3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
					</svg>
				</span>
				Agendar um contato
			</a>

		</div>

	</div>
</section>