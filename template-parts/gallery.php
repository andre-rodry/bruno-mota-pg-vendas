<?php
/**
 * Template part: Galeria de Momentos
 * Grade estática de fotos + lightbox premium (JS em assets/js/gallery.js)
 *
 * Para tornar dinâmico no futuro (ex.: ACF Repeater ou CPT "momentos"),
 * basta substituir o array $gallery_images abaixo pelo loop do WordPress,
 * mantendo os mesmos atributos data-* em cada <button>.
 */

$gallery_images = array(
	array(
		'full'  => 'https://i.ibb.co/FqYSjMKV/Whats-App-Image-2026-08-01-at-14-26-43-1.jpg',
		'thumb' => 'https://i.ibb.co/FqYSjMKV/Whats-App-Image-2026-08-01-at-14-26-43-1.jpg',
		'title' => 'Palestra',
		'desc'  => 'Momento de fala durante o evento.',
	),
	array(
		'full'  => 'https://i.ibb.co/6cYsYCrp/Whats-App-Image-2026-08-01-at-14-26-43-2.jpg',
		'thumb' => 'https://i.ibb.co/6cYsYCrp/Whats-App-Image-2026-08-01-at-14-26-43-2.jpg',
		'title' => 'Painel de debate',
		'desc'  => 'Participação em mesa redonda sobre finanças.',
	),
	array(
		'full'  => 'https://i.ibb.co/bgKwM9kf/Whats-App-Image-2026-08-01-at-14-26-43-3.jpg',
		'thumb' => 'https://i.ibb.co/bgKwM9kf/Whats-App-Image-2026-08-01-at-14-26-43-3.jpg',
		'title' => 'Apresentação',
		'desc'  => 'Condução de apresentação institucional.',
	),
	array(
		'full'  => 'https://i.ibb.co/MDH2LVGX/Whats-App-Image-2026-08-01-at-14-26-43.jpg',
		'thumb' => 'https://i.ibb.co/MDH2LVGX/Whats-App-Image-2026-08-01-at-14-26-43.jpg',
		'title' => 'Reconhecimento',
		'desc'  => 'Entrega de certificado e homenagem.',
	),
	array(
		'full'  => 'https://i.ibb.co/wrL7Rmjm/livro900.png',
		'thumb' => 'https://i.ibb.co/wrL7Rmjm/livro900.png',
		'title' => 'Lançamento',
		'desc'  => 'Registro de material institucional.',
	),
	array(
		'full'  => 'https://i.ibb.co/DBGFn6G/7980909.png',
		'thumb' => 'https://i.ibb.co/DBGFn6G/7980909.png',
		'title' => 'Entrevista',
		'desc'  => 'Entrevista concedida durante cobertura do evento.',
	),
	array(
		'full'  => 'https://i.ibb.co/Q34WgJ7n/m5656.png',
		'thumb' => 'https://i.ibb.co/Q34WgJ7n/m5656.png',
		'title' => 'Pronunciamento',
		'desc'  => 'Discurso no púlpito do Corecon.',
	),
);
?>

<section class="gallery-section" id="galeria-de-momentos">
	<div class="gallery-section__inner">

		<h2 class="gallery-section__title">
			<span class="gallery-section__title-line" aria-hidden="true"></span>
			<span class="gallery-section__title-text">Galeria de Momentos</span>
			<span class="gallery-section__title-line" aria-hidden="true"></span>
		</h2>

		<div class="gallery-grid-wrap">
			<button type="button" class="gallery-grid__nav gallery-grid__nav--prev" data-grid-prev aria-label="Ver fotos anteriores">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
					<path d="M15 5l-7 7 7 7"/>
				</svg>
			</button>

			<div class="gallery-grid" data-gallery-grid>
				<?php foreach ( $gallery_images as $index => $image ) : ?>
					<button
						type="button"
						class="gallery-grid__item"
						data-gallery-trigger
						data-index="<?php echo esc_attr( $index ); ?>"
						data-full="<?php echo esc_url( $image['full'] ); ?>"
						data-title="<?php echo esc_attr( $image['title'] ); ?>"
						data-desc="<?php echo esc_attr( $image['desc'] ); ?>"
						aria-label="Ampliar foto: <?php echo esc_attr( $image['title'] ); ?>"
					>
						<img
							src="<?php echo esc_url( $image['thumb'] ); ?>"
							alt="<?php echo esc_attr( $image['title'] ); ?>"
							loading="lazy"
						>
					</button>
				<?php endforeach; ?>
			</div>

			<button type="button" class="gallery-grid__nav gallery-grid__nav--next" data-grid-next aria-label="Ver mais fotos">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
					<path d="M9 5l7 7-7 7"/>
				</svg>
			</button>
		</div>

	</div>

	<!-- Lightbox (instância única, populada via JS) -->
	<div class="gallery-lightbox" data-gallery-lightbox aria-hidden="true">
		<div class="gallery-lightbox__backdrop" data-gallery-close></div>

		<div class="gallery-lightbox__dialog" role="dialog" aria-modal="true" aria-label="Visualizador de fotos">

			<button type="button" class="gallery-lightbox__close" data-gallery-close aria-label="Fechar">
				<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
					<path d="M5 5l14 14M19 5L5 19"/>
				</svg>
			</button>

			<button type="button" class="gallery-lightbox__nav gallery-lightbox__nav--prev" data-gallery-prev aria-label="Foto anterior">
				<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
					<path d="M15 5l-7 7 7 7"/>
				</svg>
			</button>

			<button type="button" class="gallery-lightbox__nav gallery-lightbox__nav--next" data-gallery-next aria-label="Próxima foto">
				<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
					<path d="M9 5l7 7-7 7"/>
				</svg>
			</button>

			<div class="gallery-lightbox__stage" data-gallery-stage>
				<img src="" alt="" class="gallery-lightbox__image" data-gallery-image draggable="false">
			</div>

			<div class="gallery-lightbox__footer">
				<div class="gallery-lightbox__caption">
					<p class="gallery-lightbox__caption-title" data-gallery-caption-title></p>
					<p class="gallery-lightbox__caption-desc" data-gallery-caption-desc></p>
				</div>
				<div class="gallery-lightbox__counter" data-gallery-counter>1 / 1</div>
			</div>

		</div>
	</div>
</section>