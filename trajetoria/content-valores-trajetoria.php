<?php
/**
 * Faixa de Valores da página de Trajetória
 * Exibida como uma tira horizontal com ícones e labels.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança: evita acesso direto ao arquivo.
}

$valores_trajetoria = array(
	array(
		'label' => 'Autenticidade',
		'icon'  => 'autenticidade',
	),
	array(
		'label' => 'Credibilidade',
		'icon'  => 'credibilidade',
	),
	array(
		'label' => 'Impacto',
		'icon'  => 'impacto',
	),
	array(
		'label' => 'Reconhecimento',
		'icon'  => 'reconhecimento',
	),
	array(
		'label' => 'Inovação',
		'icon'  => 'inovacao',
	),
	array(
		'label' => 'Compromisso',
		'icon'  => 'compromisso',
	),
);
?>

<section class="valores-trajetoria">
	<div class="valores-trajetoria__container">
		<div class="valores-trajetoria__box">

			<?php foreach ( $valores_trajetoria as $valor ) : ?>

				<div class="valores-trajetoria__item">
					<span class="valores-trajetoria__item-icon">
						<?php switch ( $valor['icon'] ) :
							case 'autenticidade' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12 3l7 3v5c0 4.5-3 8-7 10-4-2-7-5.5-7-10V6l7-3z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M9 12.3l2 2 4-4.3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							<?php break;

							case 'credibilidade' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="12" cy="8" r="3.4" stroke="currentColor" stroke-width="1.6"/>
									<path d="M5.5 20c0-3.6 2.9-6 6.5-6s6.5 2.4 6.5 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
								</svg>
							<?php break;

							case 'impacto' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
									<circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.6"/>
									<path d="M9.8 12.4l1.7 1.7 3.2-3.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							<?php break;

							case 'reconhecimento' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="12" cy="8" r="5" stroke="currentColor" stroke-width="1.6"/>
									<path d="M8.5 12.5L7 21l5-2.6L17 21l-1.5-8.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							<?php break;

							case 'inovacao' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M9 18h6M10 21h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<path d="M12 3a6 6 0 0 0-3.5 10.9c.6.4.9 1 .9 1.7v.4h5.2v-.4c0-.7.3-1.3.9-1.7A6 6 0 0 0 12 3z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
									<line x1="12" y1="1" x2="12" y2="2.2" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-dasharray="0.1 2.2"/>
								</svg>
							<?php break;

							case 'compromisso' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12 20.3s-7.5-4.4-7.5-10a4.4 4.4 0 0 1 7.5-3.1A4.4 4.4 0 0 1 19.5 10.3c0 5.6-7.5 10-7.5 10z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M6 11.3h2.3l1.4-2 1.6 3.4 1.2-1.8H15" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							<?php break;
						endswitch; ?>
					</span>

					<span class="valores-trajetoria__item-label"><?php echo esc_html( $valor['label'] ); ?></span>
				</div>

			<?php endforeach; ?>

		</div>
	</div>
</section>