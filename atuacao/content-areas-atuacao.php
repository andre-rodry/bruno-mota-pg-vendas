<?php
/**
 * Template part: Áreas de Atuação
 * Dois painéis lado a lado: "Áreas de Especialização" (campo de
 * conhecimento) e "Atuação Profissional" (como atuo na prática).
 * Cada painel tem um ícone + kicker, título, descrição e uma grade
 * de itens com ícone e rótulo.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança: evita acesso direto ao arquivo.
}

$paineis_areas_atuacao = array(
	array(
		'icon'        => 'graduacao',
		'kicker'      => 'Meu campo de conhecimento',
		'titulo'      => 'Áreas de Especialização',
		'descricao'   => 'Foco em temas que geram conhecimento, desenvolvimento e impacto real.',
		'itens'       => array(
			array(
				'icon'  => 'grafico-barras',
				'label' => 'Economia Regional',
			),
			array(
				'icon'  => 'predios',
				'label' => 'Economia Urbana',
			),
			array(
				'icon'  => 'livro-aberto',
				'label' => 'Teoria Econômica',
			),
		),
	),
	array(
		'icon'        => 'maleta',
		'kicker'      => 'Como atuo na prática',
		'titulo'      => 'Atuação Profissional',
		'descricao'   => 'Levo conhecimento para diferentes públicos, com soluções práticas e eficazes.',
		'itens'       => array(
			array(
				'icon'  => 'microfone',
				'label' => 'Palestras',
			),
			array(
				'icon'  => 'ondas',
				'label' => 'Mentoria',
			),
			array(
				'icon'  => 'documento',
				'label' => 'Cursos',
			),
			array(
				'icon'  => 'pessoas',
				'label' => 'Consultoria Empresarial',
			),
		),
	),
);

/**
 * Imprime um ícone SVG inline pelo slug.
 *
 * @param string $icon Slug do ícone.
 */
if ( ! function_exists( 'andrewp_icon_areas_atuacao' ) ) :
	function andrewp_icon_areas_atuacao( $icon ) {
		switch ( $icon ) :

			case 'graduacao' : ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12 3 1 8l11 5 9-4.09V17h2V8L12 3z" fill="currentColor"/>
					<path d="M5 10.18V15c0 2.21 3.13 4 7 4s7-1.79 7-4v-4.82" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			<?php break;

			case 'maleta' : ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
					<path d="M8 7V5.5A1.5 1.5 0 0 1 9.5 4h5A1.5 1.5 0 0 1 16 5.5V7" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
					<line x1="3" y1="12" x2="21" y2="12" stroke="currentColor" stroke-width="1.6"/>
					<line x1="10.5" y1="12" x2="13.5" y2="12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
				</svg>
			<?php break;

			case 'grafico-barras' : ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<line x1="5" y1="19" x2="5" y2="14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
					<line x1="10.5" y1="19" x2="10.5" y2="9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
					<line x1="16" y1="19" x2="16" y2="4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
				</svg>
			<?php break;

			case 'predios' : ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="3" y="10" width="7" height="10" rx="1" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
					<rect x="12" y="4" width="9" height="16" rx="1" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
					<line x1="5.5" y1="13.5" x2="7.5" y2="13.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
					<line x1="5.5" y1="16.5" x2="7.5" y2="16.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
					<line x1="15" y1="7.5" x2="18" y2="7.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
					<line x1="15" y1="10.5" x2="18" y2="10.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
					<line x1="15" y1="13.5" x2="18" y2="13.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
				</svg>
			<?php break;

			case 'livro-aberto' : ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12 6.5c-1.6-1.3-3.8-2-6.5-2C4.7 4.5 4 5.2 4 6v11.5c0 .8.7 1.4 1.5 1.3 2.5-.3 4.6.3 6.1 1.6 1.5-1.3 3.6-1.9 6.1-1.6.8.1 1.5-.5 1.5-1.3V6c0-.8-.7-1.5-1.5-1.5-2.7 0-4.9.7-6.5 2z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
					<line x1="12" y1="6.5" x2="12" y2="19" stroke="currentColor" stroke-width="1.6"/>
				</svg>
			<?php break;

			case 'microfone' : ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="9" y="2.5" width="6" height="11" rx="3" stroke="currentColor" stroke-width="1.6"/>
					<path d="M5.5 11.5v1a6.5 6.5 0 0 0 13 0v-1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
					<line x1="12" y1="19" x2="12" y2="21.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
					<line x1="8" y1="21.5" x2="16" y2="21.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
				</svg>
			<?php break;

			case 'ondas' : ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<line x1="4" y1="15" x2="4" y2="19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
					<line x1="8.5" y1="10" x2="8.5" y2="19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
					<line x1="13" y1="5" x2="13" y2="19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
					<line x1="17.5" y1="9" x2="17.5" y2="19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
					<line x1="21" y1="13" x2="21" y2="19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
				</svg>
			<?php break;

			case 'documento' : ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M6 3.5h9l3 3V19a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 4 19V5A1.5 1.5 0 0 1 6 3.5z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
					<line x1="8" y1="11" x2="16" y2="11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
					<line x1="8" y1="14.5" x2="16" y2="14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
					<line x1="8" y1="18" x2="12.5" y2="18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
				</svg>
			<?php break;

			case 'pessoas' : ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/>
					<path d="M3.5 19c0-3 2.5-5 5.5-5s5.5 2 5.5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
					<circle cx="17" cy="8.5" r="2.2" stroke="currentColor" stroke-width="1.5"/>
					<path d="M15.2 13.3c2.6.1 4.8 1.9 4.8 4.7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
				</svg>
			<?php break;

		endswitch;
	}
endif;
?>

<section class="areas-atuacao">
	<div class="areas-atuacao__container">
		<div class="areas-atuacao__grid">

			<?php foreach ( $paineis_areas_atuacao as $painel ) : ?>
				<div class="areas-atuacao__panel">

					<div class="areas-atuacao__cabecalho">
						<span class="areas-atuacao__icone-circulo">
							<?php andrewp_icon_areas_atuacao( $painel['icon'] ); ?>
						</span>
						<span class="areas-atuacao__kicker"><?php echo esc_html( mb_strtoupper( $painel['kicker'] ) ); ?></span>
					</div>

					<h3 class="areas-atuacao__titulo"><?php echo esc_html( $painel['titulo'] ); ?></h3>
					<p class="areas-atuacao__descricao"><?php echo esc_html( $painel['descricao'] ); ?></p>

					<div class="areas-atuacao__itens" style="--areas-atuacao-cols: <?php echo esc_attr( count( $painel['itens'] ) ); ?>;">
						<?php foreach ( $painel['itens'] as $item ) : ?>
							<div class="areas-atuacao__item">
								<span class="areas-atuacao__item-icone">
									<?php andrewp_icon_areas_atuacao( $item['icon'] ); ?>
								</span>
								<span class="areas-atuacao__item-label"><?php echo esc_html( $item['label'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>

				</div>
			<?php endforeach; ?>

		</div>
	</div>
</section>