<?php
/**
 * Content: Galeria de Momentos (Trajetória)
 * -------------------------------------------------
 * Carrossel horizontal de fotos com lightbox.
 * Largura do conteúdo: 1200px (ver page-galeria-trajetoria.css)
 *
 * As imagens abaixo usam links de internet (placeholders) apenas
 * para demonstração. Troque o array $galeria_momentos pelas suas
 * fotos reais (pode vir de ACF, post meta, etc).
 */

$galeria_momentos = array(
	array(
		'src'       => 'https://picsum.photos/id/1005/1200/800',
		'alt'       => 'Palestra no palco para plateia',
		'titulo'    => 'Palestra sobre educação financeira',
		'descricao' => 'Encontro aberto ao público com foco em planejamento financeiro pessoal.',
	),
	array(
		'src'       => 'https://picsum.photos/id/1011/1200/800',
		'alt'       => 'Equipe em foto de grupo no escritório',
		'titulo'    => 'Encontro com a equipe institucional',
		'descricao' => 'Alinhamento estratégico entre lideranças do projeto.',
	),
	array(
		'src'       => 'https://picsum.photos/id/1015/1200/800',
		'alt'       => 'Reunião de diretoria em mesa de conferência',
		'titulo'    => 'Reunião de diretoria',
		'descricao' => 'Discussão de metas e resultados do trimestre.',
	),
	array(
		'src'       => 'https://picsum.photos/id/1025/1200/800',
		'alt'       => 'Apresentação em sala de treinamento',
		'titulo'    => 'Treinamento em sala',
		'descricao' => 'Capacitação de equipe com foco em atendimento e processos.',
	),
	array(
		'src'       => 'https://picsum.photos/id/1035/1200/800',
		'alt'       => 'Entrega de certificado em evento institucional',
		'titulo'    => 'Entrega de certificado em evento institucional',
		'descricao' => 'Reconhecimento pelo trabalho em prol da educação financeira e impacto social na Bahia.',
	),
	array(
		'src'       => 'https://picsum.photos/id/1043/1200/800',
		'alt'       => 'Palestrante falando ao microfone',
		'titulo'    => 'Palestra em evento institucional',
		'descricao' => 'Apresentação sobre impacto social e trajetória do projeto.',
	),
);

// Total de fotos: agora é calculado automaticamente a partir do array acima.
// Sempre que você adicionar/remover uma foto de $galeria_momentos, este
// número é atualizado sozinho — não precisa mais editar à mão.
$galeria_total = count( $galeria_momentos );
?>

<section class="galeria-trajetoria" id="galeria-trajetoria" aria-label="Galeria de momentos">
	<div class="galeria-container">

		<h2 class="galeria-titulo">Galeria de Momentos</h2>

		<div class="galeria-carrossel">

			<button type="button" class="galeria-nav galeria-nav--prev" aria-label="Momento anterior">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>

			<div class="galeria-track-viewport">
				<ul class="galeria-track" role="list">
					<?php foreach ( $galeria_momentos as $indice => $momento ) : ?>
						<li class="galeria-item">
							<button type="button"
								class="galeria-thumb"
								data-galeria-index="<?php echo esc_attr( $indice ); ?>"
								data-full="<?php echo esc_url( $momento['src'] ); ?>"
								data-titulo="<?php echo esc_attr( $momento['titulo'] ); ?>"
								data-descricao="<?php echo esc_attr( $momento['descricao'] ); ?>"
								aria-label="Ampliar foto: <?php echo esc_attr( $momento['alt'] ); ?>">
								<img
									src="<?php echo esc_url( $momento['src'] ); ?>"
									alt="<?php echo esc_attr( $momento['alt'] ); ?>"
									loading="lazy"
								/>
								<span class="galeria-thumb-zoom">
									<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/>
										<path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
									</svg>
								</span>
							</button>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<button type="button" class="galeria-nav galeria-nav--next" aria-label="Próximo momento">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>

		</div>

		<p class="galeria-legenda">
			<svg class="galeria-legenda-icone" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/>
				<path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
			</svg>
			Clique para ampliar
			<span class="galeria-legenda-separador">&middot;</span>
			<span class="galeria-legenda-total"><?php echo esc_html( $galeria_total ); ?> momentos</span>
		</p>

	</div>
</section>

<!-- Lightbox -->
<div class="galeria-lightbox" id="galeria-lightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Visualização ampliada">
	<div class="galeria-lightbox-overlay" data-galeria-fechar></div>

	<div class="galeria-lightbox-caixa">

		<div class="galeria-lightbox-topo">
			<span class="galeria-lightbox-contador">
				<span id="galeria-lightbox-atual">1</span> / <span id="galeria-lightbox-max">6</span>
			</span>
			<button type="button" class="galeria-lightbox-fechar" data-galeria-fechar aria-label="Fechar">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
				</svg>
			</button>
		</div>

		<div class="galeria-lightbox-corpo">

			<button type="button" class="galeria-lightbox-nav galeria-lightbox-nav--prev" aria-label="Foto anterior">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>

			<figure class="galeria-lightbox-figura">
				<img src="" alt="" id="galeria-lightbox-img" />
				<figcaption class="galeria-lightbox-legenda">
					<strong id="galeria-lightbox-titulo"></strong>
					<span id="galeria-lightbox-descricao"></span>
				</figcaption>
			</figure>

			<button type="button" class="galeria-lightbox-nav galeria-lightbox-nav--next" aria-label="Próxima foto">
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>

		</div>
	</div>
</div>