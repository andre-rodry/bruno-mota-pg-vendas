<?php
/**
 * Template part: Especialização & Atuação
 * Cards com ícone, título, descrição e imagem (Consultoria e Mentoria,
 * Palestras e Workshops, Educação Financeira, Projetos de Impacto Social).
 * As imagens ficam em assets/img/atuacao/.
 *
 * Layout: a imagem ocupa o card inteiro (full-bleed) e o conteúdo
 * (ícone + título + divisor + descrição) fica sobreposto por cima,
 * alinhado à esquerda, com um degradê escurecendo esse lado — igual
 * ao banner de referência.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança: evita acesso direto ao arquivo.
}

$cards_especializacao_atuacao = array(
	array(
		'icon'      => 'grafico-crescimento',
		'titulo'    => 'Consultoria e Mentoria',
		'descricao' => 'Apoio estratégico para empresas, empreendedores e pessoas físicas em finanças e investimentos.',
		'imagem'    => 'planejamento-financeiro-documentos-calculadora.webp',
		'posicao'   => 'center',
	),
	array(
		'icon'      => 'microfone',
		'titulo'    => 'Palestras e Workshops',
		'descricao' => 'Conteúdo claro e dinâmico sobre economia, finanças e desenvolvimento.',
		'imagem'    => 'palestra-evento-publico-auditorio.webp',
		'posicao'   => 'center',
	),
	array(
		'icon'      => 'livro-aberto',
		'titulo'    => 'Educação Financeira',
		'descricao' => 'Programas e cursos que promovem educação financeira e formação cidadã para todas as idades.',
		'imagem'    => 'investimento-crescimento-financeiro-lampada-moedas.webp',
		'posicao'   => '80% center',
	),
	array(
		'icon'      => 'pessoas',
		'titulo'    => 'Projetos de Impacto Social',
		'descricao' => 'Desenvolvimento de projetos que geram valor social, promovem inclusão e fortalecem comunidades.',
		'imagem'    => 'parceria-negocios-conexao-quebra-cabeca.webp',
		'posicao'   => '65% center',
	),
);

/**
 * Imprime um ícone SVG inline pelo slug.
 *
 * @param string $icon Slug do ícone.
 */
if ( ! function_exists( 'andrewp_icon_especializacao_atuacao' ) ) :
	function andrewp_icon_especializacao_atuacao( $icon ) {
		switch ( $icon ) :

			case 'grafico-crescimento' : ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<line x1="5" y1="19" x2="5" y2="14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
					<line x1="10.5" y1="19" x2="10.5" y2="9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
					<line x1="16" y1="19" x2="16" y2="4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
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

			case 'livro-aberto' : ?>
				<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M12 6.5c-1.6-1.3-3.8-2-6.5-2C4.7 4.5 4 5.2 4 6v11.5c0 .8.7 1.4 1.5 1.3 2.5-.3 4.6.3 6.1 1.6 1.5-1.3 3.6-1.9 6.1-1.6.8.1 1.5-.5 1.5-1.3V6c0-.8-.7-1.5-1.5-1.5-2.7 0-4.9.7-6.5 2z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
					<line x1="12" y1="6.5" x2="12" y2="19" stroke="currentColor" stroke-width="1.6"/>
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

<section class="especializacao-atuacao">
	<div class="especializacao-atuacao__container">
		<div class="especializacao-atuacao__grid">

			<?php foreach ( $cards_especializacao_atuacao as $card ) : ?>
				<article class="especializacao-atuacao__card">

					<div class="especializacao-atuacao__imagem">
						<img
							src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/atuacao/' . $card['imagem'] ); ?>"
							alt="<?php echo esc_attr( $card['titulo'] ); ?>"
							loading="lazy"
							style="object-position: <?php echo esc_attr( isset( $card['posicao'] ) ? $card['posicao'] : 'center' ); ?>;"
						/>
					</div>

					<div class="especializacao-atuacao__conteudo">
						<span class="especializacao-atuacao__icone">
							<?php andrewp_icon_especializacao_atuacao( $card['icon'] ); ?>
						</span>
						<h3 class="especializacao-atuacao__titulo"><?php echo esc_html( $card['titulo'] ); ?></h3>
						<span class="especializacao-atuacao__divisor"></span>
						<p class="especializacao-atuacao__descricao"><?php echo esc_html( $card['descricao'] ); ?></p>
					</div>

				</article>
			<?php endforeach; ?>

		</div>
	</div>
</section>