<?php
/**
 * Template Part: Publicações e Artigos (Home)
 * Arquivo: content-publicacoes-home.php
 *
 * Exibe duas colunas: LIVROS (carrossel) e ARTIGOS (carrossel),
 * usando as imagens de wp-content/themes/andreWP/assets/img/home/
 *
 * Para trocar/editar itens, basta ajustar os arrays $livros e $artigos abaixo.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança: impede acesso direto ao arquivo.
}

$img_base = get_template_directory_uri() . '/assets/img/home/';

/* ------------------------------------------------------------------ */
/* LIVROS                                                             */
/* ------------------------------------------------------------------ */
$livros = array(
	array(
		'img'   => $img_base . 'livro-suas-financas-no-azul-bruno-mota-lopes.webp',
		'title' => 'Suas Finanças no Azul',
		'link'  => '#',
	),
	array(
		'img'   => $img_base . 'saia-das-dividas-bruno-mota-educacao-financeira.webp',
		'title' => 'Saia das Dívidas',
		'link'  => '#',
	),
	array(
		'img'   => $img_base . 'analise-evolucao-microcredito-bahia-bruno-mota-lopes.webp',
		'title' => 'Análise da evolução do microcrédito na Bahia (1975-2008)',
		'link'  => '#',
	),
	array(
		'img'   => $img_base . 'livro-reflexoes-economistas-baianos-bruno-mota-lopes.webp',
		'title' => 'Reflexões de Economistas Baianos',
		'link'  => '#',
	),
);

/* ------------------------------------------------------------------ */
/* ARTIGOS                                                            */
/* Somente imagens que realmente existem em assets/img/home/          */
/* ------------------------------------------------------------------ */
$artigos = array(
	array(
		'img'   => $img_base . 'outras-palavras-jornalismo-economia-investimentos-bruno-mota.webp',
		'title' => 'Economia: Quando o Brasil voltará a ousar?',
		'desc'  => 'O debate sobre a política monetária brasileira não pode ficar restrito ao controle imediato da inflação. Bruno Mota mostra por que a redução de juros é estratégica para o desenvolvimento do país.',
		'link'  => '#',
	),
	array(
		'img'   => $img_base . 'revista-economistas-cofecon-economia-brasil.webp',
		'title' => 'Política Monetária, Financeirização e Desenvolvimento Produtivo no Brasil',
		'desc'  => 'Bruno Mota analisa como os juros elevados e a financeirização da economia contribuíram para a perda de densidade industrial do Brasil.',
		'link'  => '#',
	),
	array(
		'img'   => $img_base . 'rede-estacao-democracia-economia-brasil.webp',
		'title' => 'Política Monetária, Financeirização e Desenvolvimento Produtivo no Brasil',
		'desc'  => 'Bruno Mota mostra como os juros elevados e a financeirização enfraqueceram o investimento produtivo e a indústria brasileira.',
		'link'  => '#',
	),
);
?>

<section class="publicacoes-home">

	<div class="publicacoes-header">
		<span class="publicacoes-icon" aria-hidden="true">
			<svg viewBox="0 0 24 24" width="28" height="28" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M12 6.5C10.4 5.2 8 4.5 5.5 4.5c-1 0-2 .1-3 .4v13c1-.3 2-.4 3-.4 2.5 0 4.9.7 6.5 2 1.6-1.3 4-2 6.5-2 1 0 2 .1 3 .4v-13c-1-.3-2-.4-3-.4-2.5 0-4.9.7-6.5 2Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
				<path d="M12 6.5v13" stroke="currentColor" stroke-width="1.4"/>
			</svg>
		</span>
		<h2 class="publicacoes-title">PUBLICAÇÕES <span class="text-gold">E ARTIGOS</span></h2>
		<div class="publicacoes-divider"><span></span><i class="diamond"></i><span></span></div>
	</div>

	<div class="publicacoes-panel">
		<div class="publicacoes-grid">

			<!-- ===================== LIVROS ===================== -->
			<div class="publicacoes-col col-livros">
				<div class="col-header">
					<h3><span class="col-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 6.5C10.4 5.2 8 4.5 5.5 4.5c-1 0-2 .1-3 .4v13c1-.3 2-.4 3-.4 2.5 0 4.9.7 6.5 2 1.6-1.3 4-2 6.5-2 1 0 2 .1 3 .4v-13c-1-.3-2-.4-3-.4-2.5 0-4.9.7-6.5 2Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
						</svg>
					</span>LIVROS</h3>
					<a href="#" class="ver-todos">VER TODOS</a>
				</div>

				<div class="livros-carousel" data-carousel="livros" data-autoplay="4000">
					<div class="carousel-track">
						<?php foreach ( $livros as $livro ) : ?>
							<div class="livro-card">
								<a href="<?php echo esc_url( $livro['link'] ); ?>" class="livro-cover">
									<img src="<?php echo esc_url( $livro['img'] ); ?>" alt="<?php echo esc_attr( $livro['title'] ); ?>" loading="lazy">
								</a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="carousel-dots" data-dots="livros">
					<?php foreach ( $livros as $i => $livro ) : ?>
						<button type="button" class="dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>" aria-label="Livro <?php echo esc_attr( $i + 1 ); ?>"></button>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- ===================== ARTIGOS ===================== -->
			<div class="publicacoes-col col-artigos">
				<div class="col-header">
					<h3><span class="col-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M4 20l1.2-4.2L15.6 5.4a1.5 1.5 0 0 1 2.1 0l0.9.9a1.5 1.5 0 0 1 0 2.1L8.2 18.8 4 20Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
						</svg>
					</span>ARTIGOS</h3>
					<a href="#" class="ver-todos">VER TODOS</a>
				</div>

				<div class="artigos-carousel" data-carousel="artigos">
					<div class="carousel-track">
						<?php foreach ( $artigos as $artigo ) : ?>
							<article class="artigo-card">
								<a href="<?php echo esc_url( $artigo['link'] ); ?>" class="artigo-thumb">
									<img src="<?php echo esc_url( $artigo['img'] ); ?>" alt="<?php echo esc_attr( $artigo['title'] ); ?>" loading="lazy">
								</a>
								<div class="artigo-body">
									<h4><a href="<?php echo esc_url( $artigo['link'] ); ?>"><?php echo esc_html( $artigo['title'] ); ?></a></h4>
									<p><?php echo esc_html( $artigo['desc'] ); ?></p>
									<a href="<?php echo esc_url( $artigo['link'] ); ?>" class="ler-artigo">LER ARTIGO <span class="arrow">&rarr;</span></a>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				</div>

				<?php
				$artigo_pages = (int) ceil( count( $artigos ) / 3 );
				if ( $artigo_pages > 1 ) :
					?>
					<div class="carousel-dots" data-dots="artigos">
						<?php for ( $i = 0; $i < $artigo_pages; $i++ ) : ?>
							<button type="button" class="dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>" aria-label="Página de artigos <?php echo esc_attr( $i + 1 ); ?>"></button>
						<?php endfor; ?>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>
<?php
/**
 * O JS do carrossel (com autoplay para os livros) fica em:
 * home/page-publicacoes-home.js
 *
 * Enfileire em inc/assets.php, por exemplo:
 *
 * wp_enqueue_script(
 *     'publicacoes-home',
 *     get_template_directory_uri() . '/home/page-publicacoes-home.js',
 *     array(),
 *     '1.0',
 *     true
 * );
 */