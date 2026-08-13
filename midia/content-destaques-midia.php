<?php
/**
 * Destaques na Mídia
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança: evita acesso direto ao arquivo.
}

$destaques_midia = array(
	array(
		'imagem'     => 'bruno-mota-revogacao-tarifas-agronegocio.webp',
		'titulo'     => 'Revogação das Tarifas pelos EUA: Impactos no Agronegócio com o Economista Bruno Mota',
		'descricao'  => 'Entrevista sobre os impactos da revogação das tarifas pelo EUA e seus reflexos no agronegócio baiano.',
		'link'       => '#',
	),
	array(
		'imagem'     => 'bruno-mota-credito-rotativo-cartao.webp',
		'titulo'     => 'O economista Bruno Mota fala dos Juros do Crédito Rotativo do Cartão',
		'descricao'  => 'Análise sobre os juros do crédito rotativo do cartão, seus impactos no consumidor e na economia.',
		'link'       => '#',
	),
	array(
		'imagem'     => 'bruno-mota-entrevista-economia.webp',
		'titulo'     => 'Alimentos e bebidas têm queda de preço',
		'descricao'  => 'Análise sobre a queda de preços de alimentos e bebidas e os reflexos para o bolso do consumidor.',
		'link'       => '#',
	),
);
?>

<section class="destaques-midia">
	<div class="destaques-midia__container">

		<div class="destaques-midia__header">
			<div class="destaques-midia__heading">
				<span class="destaques-midia__kicker">Destaques na Mídia</span>
				<h2 class="destaques-midia__heading-title">Presença que gera impacto.</h2>
				<p class="destaques-midia__heading-desc">
					Reportagens, entrevistas e participações que mostram nosso compromisso com a educação financeira e o desenvolvimento do Brasil.
				</p>
			</div>

			<a href="#" class="destaques-midia__cta">
				Ver todos
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</a>
		</div>

		<div class="destaques-midia__grid">
			<?php foreach ( $destaques_midia as $item ) : ?>
				<article class="destaques-midia__card">

					<div class="destaques-midia__media">
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/midia/' . $item['imagem'] ); ?>"
							alt="<?php echo esc_attr( $item['titulo'] ); ?>"
							class="destaques-midia__img"
							loading="lazy"
						>
						<span class="destaques-midia__media-overlay"></span>
						<span class="destaques-midia__media-fade"></span>

						<span class="destaques-midia__play">
							<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M8 5v14l11-7L8 5z" fill="currentColor"/>
							</svg>
						</span>
					</div>

					<div class="destaques-midia__body">
						<h3 class="destaques-midia__title"><?php echo esc_html( $item['titulo'] ); ?></h3>
						<p class="destaques-midia__text"><?php echo esc_html( $item['descricao'] ); ?></p>

						<a href="<?php echo esc_url( $item['link'] ); ?>" class="destaques-midia__link">
							Ver reportagem
							<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</a>
					</div>

				</article>
			<?php endforeach; ?>
		</div>

	</div>
</section>