<?php
/**
 * Seção de números (cards) da página de Trajetória
 * Exibida logo abaixo do banner
 * Sobrepõe o rodapé do banner, mesmo padrão de Mídia e Publicações.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança: evita acesso direto ao arquivo.
}

$numeros_trajetoria = array(
	array(
		'numero'      => '10 MIL+',
		'label'       => 'Operações de Crédito',
		'descricao'   => 'Experiência prática com empreendedores, micro e pequenos empresários no CEAPE (1995-2002).',
		'icon'        => 'calendario',
	),
	array(
		'numero'      => '2009-2015',
		'label'       => 'Docência na UNIFACS',
		'descricao'   => 'Atuou como professor visitante e tutor da disciplina Conjuntura Econômica.',
		'icon'        => 'palestra',
	),
	array(
		'numero'      => '4 PAÍSES',
		'label'       => 'Atuação Internacional',
		'descricao'   => 'Artigos apresentados em congressos na Argentina, Portugal, Espanha e Cuba.',
		'icon'        => 'artigo',
	),
	array(
		'numero'      => '4.000+',
		'label'       => 'Horas de Conteúdo Digital',
		'descricao'   => 'Entrevistas e conteúdos sobre educação financeira no canal Finanças para Jovens Oficial.',
		'icon'        => 'alunos',
	),
);
?>

<section class="numeros-trajetoria">
	<div class="numeros-trajetoria__container">
		<div class="numeros-trajetoria__grid">

			<?php foreach ( $numeros_trajetoria as $numero ) : ?>

				<div class="numeros-trajetoria__card">
					<span class="numeros-trajetoria__card-icon">
						<?php switch ( $numero['icon'] ) :
							case 'calendario' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/>
									<line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="1.6"/>
									<line x1="8" y1="3" x2="8" y2="7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<line x1="16" y1="3" x2="16" y2="7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<line x1="7" y1="14" x2="9" y2="14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<line x1="11" y1="14" x2="13" y2="14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<line x1="15" y1="14" x2="17" y2="14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
								</svg>
							<?php break;

							case 'palestra' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect x="3" y="4" width="18" height="12" rx="1.5" stroke="currentColor" stroke-width="1.6"/>
									<line x1="8" y1="20" x2="16" y2="20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<line x1="12" y1="16" x2="12" y2="20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<circle cx="9" cy="9" r="1.6" stroke="currentColor" stroke-width="1.4"/>
									<path d="M6.3 12.4c0-1.7 1.3-2.9 2.7-2.9s2.7 1.2 2.7 2.9" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
									<circle cx="16" cy="8.5" r="1.3" stroke="currentColor" stroke-width="1.3"/>
									<path d="M13.8 11.6c.2-1.3 1.2-2.2 2.2-2.2s2.1.9 2.2 2.2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
								</svg>
							<?php break;

							case 'artigo' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M14 2v6h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M9.5 17.5l3.8-3.8a1 1 0 0 1 1.4 0l.6.6a1 1 0 0 1 0 1.4l-3.8 3.8-2 .4.4-2z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							<?php break;

							case 'alunos' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="8.5" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/>
									<path d="M2.5 19c0-3 2.7-5.2 6-5.2s6 2.2 6 5.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<circle cx="17" cy="8.5" r="2.4" stroke="currentColor" stroke-width="1.6"/>
									<path d="M15.5 13.6c2.6.3 4.5 2.2 4.5 4.9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
								</svg>
							<?php break;
						endswitch; ?>
					</span>

					<strong class="numeros-trajetoria__card-number"><?php echo esc_html( $numero['numero'] ); ?></strong>
					<span class="numeros-trajetoria__card-label"><?php echo esc_html( $numero['label'] ); ?></span>
					<p class="numeros-trajetoria__card-description"><?php echo esc_html( $numero['descricao'] ); ?></p>
				</div>

			<?php endforeach; ?>

		</div>
	</div>
</section>