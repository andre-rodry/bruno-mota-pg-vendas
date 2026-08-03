<?php
/**
 * O template do rodapé
 *
 * Contém o CTA "Vamos conversar?" e o footer institucional
 * (navegação, contato e redes sociais).
 *
 * @package andreWP
 */

// Bloco de ícones reaproveitado nas duas listas de redes sociais do footer.
$andrewp_social_icons = array(
	'instagram' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>',
	'whatsapp'  => '<svg width="18" height="18" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M16.004 3C9.377 3 4 8.373 4 15c0 2.34.63 4.53 1.72 6.42L4 29l7.77-1.68A11.9 11.9 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm0 21.7a9.63 9.63 0 0 1-4.93-1.35l-.353-.21-4.61 1 1.02-4.5-.23-.36A9.64 9.64 0 1 1 25.64 15a9.65 9.65 0 0 1-9.636 9.7Zm5.3-7.25c-.29-.145-1.71-.845-1.976-.94-.265-.097-.458-.145-.65.145-.19.29-.746.94-.915 1.133-.168.194-.336.218-.626.073-.29-.145-1.223-.451-2.33-1.437-.86-.767-1.44-1.715-1.61-2.005-.168-.29-.018-.447.127-.591.13-.13.29-.338.435-.508.145-.17.193-.29.29-.483.096-.194.048-.363-.024-.508-.073-.145-.65-1.567-.892-2.146-.235-.564-.474-.487-.65-.496l-.554-.01c-.194 0-.508.073-.774.363-.265.29-1.014.99-1.014 2.415 0 1.425 1.038 2.803 1.183 2.997.145.194 2.043 3.12 4.95 4.376.692.298 1.232.476 1.653.61.694.221 1.325.19 1.824.115.556-.083 1.71-.699 1.951-1.373.242-.674.242-1.252.169-1.373-.072-.121-.265-.194-.554-.34Z"/></svg>',
	'facebook'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12Z"/></svg>',
	'youtube'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.4 3.5 12 3.5 12 3.5s-7.4 0-9.4.6A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c2 .6 9.4.6 9.4.6s7.4 0 9.4-.6a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8ZM9.6 15.6V8.4L15.8 12l-6.2 3.6Z"/></svg>',
	'spotify'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm4.59 14.4a.62.62 0 0 1-.85.21c-2.34-1.43-5.29-1.75-8.76-.96a.62.62 0 1 1-.28-1.21c3.8-.87 7.06-.5 9.68 1.1.3.18.39.57.21.86Zm1.22-2.72a.78.78 0 0 1-1.07.26c-2.68-1.65-6.77-2.13-9.94-1.16a.78.78 0 1 1-.45-1.49c3.63-1.1 8.14-.57 11.2 1.32.37.23.49.72.26 1.07Zm.1-2.83C14.98 8.98 9.9 8.8 6.9 9.7a.93.93 0 1 1-.54-1.79c3.46-1.04 9.11-.83 12.7 1.3a.94.94 0 0 1-.95 1.62Z"/></svg>',
	'linkedin'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5ZM.5 8.98h4.9V23H.5V8.98ZM8.5 8.98h4.7v1.92h.07c.65-1.23 2.25-2.53 4.63-2.53 4.95 0 5.86 3.26 5.86 7.5V23h-4.9v-6.36c0-1.52-.03-3.47-2.11-3.47-2.12 0-2.44 1.65-2.44 3.36V23H8.5V8.98Z"/></svg>',
	'tiktok'    => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M16.5 2h-3.1v13.6c0 1.4-1.1 2.5-2.5 2.5a2.5 2.5 0 0 1-2.5-2.5c0-1.38 1.12-2.5 2.5-2.5.24 0 .47.03.69.1V9.9a5.7 5.7 0 0 0-.69-.04A5.7 5.7 0 0 0 5.2 15.6 5.7 5.7 0 0 0 10.9 21.3a5.7 5.7 0 0 0 5.7-5.7V8.4a8.1 8.1 0 0 0 4.7 1.5V6.8a4.9 4.9 0 0 1-4.8-4.8Z"/></svg>',
);

/**
 * Imprime a lista de ícones de redes sociais do footer.
 */
function andrewp_print_social_icons( $icons ) {
	echo '<ul class="footer-social">';
	foreach ( $icons as $rede => $svg ) {
		printf(
			'<li><a href="#" aria-label="%s">%s</a></li>',
			esc_attr( ucfirst( $rede ) ),
			$svg // já é SVG estático, controlado pelo tema.
		);
	}
	echo '</ul>';
}
?>

	<footer class="site-footer">

		<!-- ==================== CTA: Vamos conversar? ==================== -->
		<div class="footer-cta">
			<span class="footer-cta__icon" aria-hidden="true">
				<svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12 3C6.48 3 2 6.87 2 11.5C2 13.86 3.16 15.99 5.03 17.5C5.03 18.5 4.5 19.8 3.5 21C5.5 20.7 7.24 19.9 8.5 19C9.6 19.36 10.78 19.5 12 19.5C17.52 19.5 22 15.63 22 11.5C22 6.87 17.52 3 12 3Z" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
					<circle cx="8" cy="11.5" r="1.1" fill="currentColor"/>
					<circle cx="12" cy="11.5" r="1.1" fill="currentColor"/>
					<circle cx="16" cy="11.5" r="1.1" fill="currentColor"/>
				</svg>
			</span>

			<div class="footer-cta__text">
				<h2 class="footer-cta__title">Vamos conversar?</h2>
				<p class="footer-cta__subtitle">
					Disponível para entrevistas, análises econômicas,
					programas de TV, rádio, podcasts, imprensa e eventos.
				</p>
			</div>

			<a href="<?php echo esc_url( home_url( '/contato' ) ); ?>" class="footer-cta__button">
				<svg class="footer-cta__button-icon" width="16" height="16" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path fill="currentColor" d="M16.004 3C9.377 3 4 8.373 4 15c0 2.34.63 4.53 1.72 6.42L4 29l7.77-1.68A11.9 11.9 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm0 21.7a9.63 9.63 0 0 1-4.93-1.35l-.353-.21-4.61 1 1.02-4.5-.23-.36A9.64 9.64 0 1 1 25.64 15a9.65 9.65 0 0 1-9.636 9.7Zm5.3-7.25c-.29-.145-1.71-.845-1.976-.94-.265-.097-.458-.145-.65.145-.19.29-.746.94-.915 1.133-.168.194-.336.218-.626.073-.29-.145-1.223-.451-2.33-1.437-.86-.767-1.44-1.715-1.61-2.005-.168-.29-.018-.447.127-.591.13-.13.29-.338.435-.508.145-.17.193-.29.29-.483.096-.194.048-.363-.024-.508-.073-.145-.65-1.567-.892-2.146-.235-.564-.474-.487-.65-.496l-.554-.01c-.194 0-.508.073-.774.363-.265.29-1.014.99-1.014 2.415 0 1.425 1.038 2.803 1.183 2.997.145.194 2.043 3.12 4.95 4.376.692.298 1.232.476 1.653.61.694.221 1.325.19 1.824.115.556-.083 1.71-.699 1.951-1.373.242-.674.242-1.252.169-1.373-.072-.121-.265-.194-.554-.34Z"/>
				</svg>
				ENTRAR EM CONTATO
				<span class="footer-cta__arrow" aria-hidden="true">&rarr;</span>
			</a>
		</div>

		<!-- ==================== Footer institucional ==================== -->
		<div class="site-footer__main">
			<div class="site-footer__container">

				<!-- Coluna 1: Marca -->
				<div class="footer-col footer-col--brand">
					<div class="footer-brand">
						<span class="footer-brand__logo">BM</span>
						<div class="footer-brand__name">
							<span class="footer-brand__title">BRUNO MOTA</span>
							<span class="footer-brand__subtitle">ECONOMISTA</span>
						</div>
					</div>
					<p class="footer-brand__desc">
						Economia com propósito para transformar
						vidas, empresas e o Brasil.
					</p>

					<?php andrewp_print_social_icons( $andrewp_social_icons ); ?>
				</div>

				<!-- Coluna 2: Navegação -->
				<div class="footer-col footer-col--nav">
					<h3 class="footer-col__title">NAVEGAÇÃO</h3>
					<div class="footer-nav-grid">
						<ul>
							<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a></li>
							<li><a href="<?php echo esc_url( home_url( '/sobre' ) ); ?>">Sobre</a></li>
							<li><a href="<?php echo esc_url( home_url( '/atuacao' ) ); ?>">Atuação</a></li>
							<li><a href="<?php echo esc_url( home_url( '/conquistas' ) ); ?>">Conquistas</a></li>
						</ul>
						<ul>
							<li><a href="<?php echo esc_url( home_url( '/publicacoes' ) ); ?>">Publicações</a></li>
							<li><a href="<?php echo esc_url( home_url( '/midia' ) ); ?>">Mídia</a></li>
							<li><a href="<?php echo esc_url( home_url( '/contato' ) ); ?>">Contato</a></li>
						</ul>
					</div>
				</div>

				<!-- Coluna 3: Contato -->
				<div class="footer-col footer-col--contact">
					<h3 class="footer-col__title">CONTATO</h3>
					<ul class="footer-contact">
						<li>
							<span class="footer-contact__icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3.1-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 3a2 2 0 0 1-.5 2.1L8 10a16 16 0 0 0 6 6l1.2-1.3a2 2 0 0 1 2.1-.5c1 .3 2 .5 3 .7a2 2 0 0 1 1.7 2Z"/></svg></span>
							<a href="tel:+557183116882">+55 (71) 8311-6882</a>
						</li>
						<li>
							<span class="footer-contact__icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M16.004 3C9.377 3 4 8.373 4 15c0 2.34.63 4.53 1.72 6.42L4 29l7.77-1.68A11.9 11.9 0 0 0 16.004 27C22.63 27 28 21.627 28 15S22.63 3 16.004 3Zm0 21.7a9.63 9.63 0 0 1-4.93-1.35l-.353-.21-4.61 1 1.02-4.5-.23-.36A9.64 9.64 0 1 1 25.64 15a9.65 9.65 0 0 1-9.636 9.7Zm5.3-7.25c-.29-.145-1.71-.845-1.976-.94-.265-.097-.458-.145-.65.145-.19.29-.746.94-.915 1.133-.168.194-.336.218-.626.073-.29-.145-1.223-.451-2.33-1.437-.86-.767-1.44-1.715-1.61-2.005-.168-.29-.018-.447.127-.591.13-.13.29-.338.435-.508.145-.17.193-.29.29-.483.096-.194.048-.363-.024-.508-.073-.145-.65-1.567-.892-2.146-.235-.564-.474-.487-.65-.496l-.554-.01c-.194 0-.508.073-.774.363-.265.29-1.014.99-1.014 2.415 0 1.425 1.038 2.803 1.183 2.997.145.194 2.043 3.12 4.95 4.376.692.298 1.232.476 1.653.61.694.221 1.325.19 1.824.115.556-.083 1.71-.699 1.951-1.373.242-.674.242-1.252.169-1.373-.072-.121-.265-.194-.554-.34Z"/></svg></span>
							<a href="https://wa.me/557183116882" target="_blank" rel="noopener">+55 (71) 8311-6882</a>
						</li>
						<li>
							<span class="footer-contact__icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m3 6 9 7 9-7"/></svg></span>
							<a href="mailto:atendimento@economistabrunomota.com.br">atendimento@economistabrunomota.com.br</a>
						</li>
						<li>
							<span class="footer-contact__icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg></span>
							<span>Salvador, Bahia - Brasil</span>
						</li>
					</ul>
				</div>

				<!-- Coluna 4: Me acompanhe -->
				<div class="footer-col footer-col--follow">
					<h3 class="footer-col__title">ME ACOMPANHE</h3>
					<p class="footer-follow__desc">
						Conteúdo diário sobre economia,
						finanças e desenvolvimento.
					</p>
					<?php andrewp_print_social_icons( $andrewp_social_icons ); ?>
				</div>

			</div>
		</div>

		<!-- ==================== Barra inferior ==================== -->
		<div class="site-footer__bottom">
			<div class="site-footer__container site-footer__bottom-inner">
				<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Bruno Mota - Todos os direitos reservados.</p>
				<p>Desenvolvido com <a href="#" class="footer-highlight">propósito</a> para transformar.</p>
			</div>
		</div>

	</footer>

<?php wp_footer(); ?>

</body>
</html>