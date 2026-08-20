<?php
/**
 * Content: CTA Vamos Conversar (Trajetória)
 * -------------------------------------------------
 * Faixa de contato/CTA final da página.
 * Largura do conteúdo: 1200px (ver page-cta-trajetoria.css)
 *
 * Troque o link do botão pelo destino real (WhatsApp, formulário, e-mail, etc).
 */

$cta_link = '#'; // ex: 'https://wa.me/55XXXXXXXXXXX' ou link do formulário de contato
?>

<section class="cta-trajetoria" id="cta-trajetoria" aria-label="Chamada para contato">
	<div class="cta-container">

		<div class="cta-caixa">

			<div class="cta-info">
				<span class="cta-icone" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M21 12C21 16.4183 16.9706 20 12 20C10.6866 20 9.44012 19.7473 8.31462 19.2893L4 20L5.13333 16.7373C4.41985 15.5217 4 14.1027 4 12.6667C4 8.24837 8.02944 4.66667 12 4.66667C16.9706 4.66667 21 7.58172 21 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</span>

				<div class="cta-textos">
					<h2 class="cta-titulo">Vamos conversar?</h2>
					<p class="cta-descricao">Disponível para entrevistas, análises econômicas, programas de TV, rádio, podcasts e eventos.</p>
				</div>
			</div>

			<a href="<?php echo esc_url( $cta_link ); ?>" class="cta-botao">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M14 3H21V10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M21 3L10 14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M19 14V19C19 20.1046 18.1046 21 17 21H5C3.89543 21 3 20.1046 3 19V7C3 5.89543 3.89543 5 5 5H10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				Entrar em contato
			</a>

		</div>

	</div>
</section>