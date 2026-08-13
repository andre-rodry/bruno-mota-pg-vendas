<?php
/**
 * Content: Seção TV - Página Mídia
 * Exibe os destaques de participações em TV
 */

$tv_items = [
	[
		'img'   => 'jornal-da-band.webp',
		'title' => 'Jornal da Band',
		'desc'  => 'Participação nacional',
		'date'  => '27 de março de 2025',
	],
	[
		'img'   => 'agro-band-programa.webp',
		'title' => 'Agro Band Bahia',
		'desc'  => 'Tarifas dos EUA e agronegócio',
		'date'  => '21 de novembro de 2024',
	],
	[
		'img'   => 'tv-aratu.webp',
		'title' => 'TV Aratu',
		'desc'  => 'Aumento dos combustíveis',
		'date'  => '10 de março de 2025',
	],
	[
		'img'   => 'tv-resistencia.webp',
		'title' => 'TV Resistência',
		'desc'  => 'Simples Nacional',
		'date'  => '08 de setembro de 2024',
	],
	[
		'img'   => 'tve-bahia.webp',
		'title' => 'TV Bahia',
		'desc'  => 'Economia e notícias',
		'date'  => '15 de agosto de 2024',
	],
];
?>

<section class="tv-midia-section">
	<div class="tv-midia-container">

		<div class="tv-midia-header">
			<h2 class="tv-midia-title">TV</h2>
			<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'midia' ) ) ); ?>#tv" class="tv-midia-ver-todas">
				VER TODAS <span class="icon-arrow">&rarr;</span>
			</a>
		</div>

		<div class="tv-midia-grid">
			<?php foreach ( $tv_items as $item ) : ?>
				<div class="tv-midia-card">
					<div class="tv-midia-card-img">
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/midia/' . $item['img'] ); ?>"
							alt="<?php echo esc_attr( $item['title'] ); ?>"
							loading="lazy"
						>
					</div>
					<div class="tv-midia-card-body">
						<h3 class="tv-midia-card-title"><?php echo esc_html( $item['title'] ); ?></h3>
						<p class="tv-midia-card-desc"><?php echo esc_html( $item['desc'] ); ?></p>
						<span class="tv-midia-card-date"><?php echo esc_html( $item['date'] ); ?></span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>