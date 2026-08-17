<?php
/**
 * Section: Destaques da Carreira (Pilares)
 * content-pilares-sobre.php
 *
 * Três cards com imagem de destaque, ícone, título e lista de
 * conquistas/atuação (Formação Acadêmica, Atuação Acadêmica e
 * Internacional, Impacto e Políticas Públicas).
 *
 * Uso: get_template_part( 'template-parts/content', 'pilares-sobre' );
 * (ajuste o caminho conforme a organização de template-parts do tema)
 *
 * @package andreWP
 */

// Lista de pilares. Cada item tem imagem de fundo, ícone, título (2 linhas)
// e uma lista de conquistas/pontos (com trecho em destaque opcional).
$andrewp_pilares = array(
	array(
		'imagem'   => 'unifacs-universidade-salvador-ba.webp',
		'icone'    => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.5l8.5 3.9L12 12.3 3.5 8.4 12 4.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M7 10.4v4.2c0 1.6 2.24 3 5 3s5-1.4 5-3v-4.2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M20.5 8.4v5.6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
		'titulo'   => 'Formação<br>Acadêmica',
		'itens'    => array(
			array(
				'destaque' => 'Doutorado (em andamento):',
				'texto'    => 'Desenvolvimento Regional e Urbano (UNIFACS).',
			),
			array(
				'destaque' => 'Mestrado:',
				'texto'    => 'Desenvolvimento Regional e Urbano (UNIFACS).',
			),
			array(
				'destaque' => 'Graduação:',
				'texto'    => 'Ciências Econômicas (UNIFACS).',
			),
		),
	),
	array(
		'imagem'   => 'mapa-mundial-conexoes-internacionais.webp',
		'icone'    => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.5"/><path d="M3.5 12h17M12 3.5c2.2 2.3 3.4 5.3 3.4 8.5s-1.2 6.2-3.4 8.5c-2.2-2.3-3.4-5.3-3.4-8.5S9.8 5.8 12 3.5Z" stroke="currentColor" stroke-width="1.5"/></svg>',
		'titulo'   => 'Atuação Acadêmica<br>e Internacional',
		'itens'    => array(
			array(
				'destaque' => 'Docência:',
				'texto'    => 'Professor universitário atuante em diversas graduações desde 2006.',
			),
			array(
				'destaque' => 'Presença internacional:',
				'texto'    => 'Apresentação de artigos em congressos na Argentina, Portugal, Espanha e Cuba.',
			),
			array(
				'destaque' => 'Palestras:',
				'texto'    => 'Conferencista em eventos nacionais e internacionais sobre economia e inclusão.',
			),
		),
	),
	array(
		'imagem'   => 'predio-historico-arquitetura-institucional.webp',
		'icone'    => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 9.5 12 4l8 5.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 9.5V19M9 9.5V19M15 9.5V19M19 9.5V19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M3.5 19h17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
		'titulo'   => 'Impacto e<br>Políticas Públicas',
		'itens'    => array(
			array(
				'destaque' => 'Lei 9839/2025:',
				'texto'    => 'Institui a Educação Financeira nas escolas públicas de Salvador.',
			),
			array(
				'destaque' => 'Desenvolvimento Local:',
				'texto'    => 'Foco constante em projetos de microcrédito e fortalecimento da economia regional.',
			),
		),
	),
);
?>

<section class="sobre-pilares" aria-label="Destaques da carreira">
	<div class="sobre-pilares__container">

		<div class="sobre-pilares__header">
			<span class="sobre-pilares__label">Destaques da Carreira</span>
			<h2 class="sobre-pilares__title">
				Formação, atuação e impacto<br>em constante evolução.
			</h2>
			<span class="sobre-pilares__title-underline" aria-hidden="true"></span>
		</div>

		<div class="sobre-pilares__grid">
			<?php foreach ( $andrewp_pilares as $pilar ) : ?>
				<div class="sobre-pilares__card">

					<div class="sobre-pilares__media">
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/sobre/' . $pilar['imagem'] ); ?>"
							alt=""
							class="sobre-pilares__media-img"
							loading="lazy"
						>
						<span class="sobre-pilares__media-overlay" aria-hidden="true"></span>
						<span class="sobre-pilares__icon" aria-hidden="true">
							<?php echo $pilar['icone']; // já é SVG estático, controlado pelo tema. ?>
						</span>
					</div>

					<div class="sobre-pilares__content">
						<h3 class="sobre-pilares__card-title"><?php echo wp_kses_post( $pilar['titulo'] ); ?></h3>

						<ul class="sobre-pilares__list">
							<?php foreach ( $pilar['itens'] as $item ) : ?>
								<li class="sobre-pilares__list-item">
									<span class="sobre-pilares__check" aria-hidden="true">
										<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M5 12.5l4.5 4.5L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</span>
									<span class="sobre-pilares__list-text">
										<?php if ( ! empty( $item['destaque'] ) ) : ?>
											<strong><?php echo esc_html( $item['destaque'] ); ?></strong>
										<?php endif; ?>
										<?php echo esc_html( ' ' . $item['texto'] ); ?>
									</span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>

				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>