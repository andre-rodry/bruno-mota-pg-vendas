<?php
/**
 * Section: Perfil / Sobre + Conquistas em destaque
 * content-perfil-sobre.php
 *
 * Duas colunas: texto institucional (Sobre) à esquerda e lista de
 * conquistas em destaque à direita, com divisor vertical entre elas.
 *
 * @package andreWP
 */

// Lista de conquistas em destaque. Cada item pode (opcionalmente) ter um link.
$andrewp_conquistas = array(
	array(
		'icone' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3.5l7 2.5v5.2c0 4.7-3 8.9-7 10.3-4-1.4-7-5.6-7-10.3V6L12 3.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M12 8.7l1.05 2.13 2.35.34-1.7 1.66.4 2.34L12 14.05l-2.1 1.12.4-2.34-1.7-1.66 2.35-.34L12 8.7Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/></svg>',
		'titulo' => 'Idealizador da Lei 9839/2025',
		'texto'  => 'Que instituiu educação financeira nas escolas públicas de Salvador.',
		'link'   => array(
			'texto' => 'Conheça a Lei',
			'url'   => '#',
		),
	),
	array(
		'icone' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.5"/><path d="M3.5 12h17M12 3.5c2.2 2.3 3.4 5.3 3.4 8.5s-1.2 6.2-3.4 8.5c-2.2-2.3-3.4-5.3-3.4-8.5S9.8 5.8 12 3.5Z" stroke="currentColor" stroke-width="1.5"/></svg>',
		'titulo' => 'Representação Internacional',
		'texto'  => 'Reconhecimento internacional ao ser convidado para participar de Mesa Internacional na Argentina para discutir Desenvolvimento Econômico na América Latina.',
		'link'   => null,
	),
	array(
		'icone' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 6.5c-1.8-1.3-4.2-1.8-6.5-1.5v11.8c2.3-.3 4.7.2 6.5 1.5 1.8-1.3 4.2-1.8 6.5-1.5V5c-2.3-.3-4.7.2-6.5 1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M12 6.5v11.8" stroke="currentColor" stroke-width="1.5"/></svg>',
		'titulo' => 'Revista do Cofecon',
		'texto'  => 'Artigo publicado na maior revista para os Economistas &ndash; Revista do Cofecon (Conselho Federal de Economia do Brasil).',
		'link'   => null,
	),
	array(
		'icone' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M8 7l2.5-3.5M16 7l-2.5-3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="12" cy="13.3" r="3.1" stroke="currentColor" stroke-width="1.3"/></svg>',
		'titulo' => 'Jornal da Band',
		'texto'  => 'Participação nacional no Jornal da Band para aproximadamente 100 mil pessoas.',
		'link'   => null,
	),
);
?>

<section class="sobre-perfil" aria-label="Sobre e conquistas em destaque">
	<div class="sobre-perfil__container">

		<!-- Coluna: Sobre -->
		<div class="sobre-perfil__col sobre-perfil__col--info">
			<span class="sobre-perfil__label">Sobre Bruno Mota</span>

			<h2 class="sobre-perfil__title">
				Economia que gera<br>impacto real.
			</h2>
			<span class="sobre-perfil__title-underline" aria-hidden="true"></span>

			<p class="sobre-perfil__text">
				Pai e economista, Bruno Mota Lopes destaca-se por sua atuação
				multifacetada e pelo impacto relevante no desenvolvimento
				regional e urbano. Sua trajetória iniciou-se em uma ONG de
				microcrédito, onde participou diretamente de mais de 10 mil
				operações voltadas a empreendedores informais, micro e
				pequenas empresas.
			</p>

			<p class="sobre-perfil__text">
				Essa vivência prática permitiu uma compreensão aprofundada da
				microeconomia do crédito e de seu impacto transformador nas
				famílias e comunidades.
			</p>

			<p class="sobre-perfil__text">
				No ambiente digital, criou o canal Finanças para Jovens Oficial
				(Instagram, LinkedIn, YouTube e TikTok), acumulando mais de
				4.000 horas de entrevistas e conteúdos focados em educação
				financeira e desenvolvimento econômico.
			</p>
		</div>

		<!-- Divisor vertical entre as colunas -->
		<div class="sobre-perfil__divider" aria-hidden="true"></div>

		<!-- Coluna: Conquistas em destaque -->
		<div class="sobre-perfil__col sobre-perfil__col--conquistas">
			<span class="sobre-perfil__label">Conquistas em destaque</span>

			<ul class="sobre-perfil__conquistas-list">
				<?php foreach ( $andrewp_conquistas as $item ) : ?>
					<li class="sobre-perfil__conquista-item">
						<span class="sobre-perfil__conquista-icon" aria-hidden="true">
							<?php echo $item['icone']; // já é SVG estático, controlado pelo tema. ?>
						</span>

						<div class="sobre-perfil__conquista-content">
							<h3 class="sobre-perfil__conquista-title"><?php echo esc_html( $item['titulo'] ); ?></h3>
							<p class="sobre-perfil__conquista-desc"><?php echo wp_kses_post( $item['texto'] ); ?></p>
						</div>

						<?php if ( ! empty( $item['link'] ) ) : ?>
							<a href="<?php echo esc_url( $item['link']['url'] ); ?>" class="sobre-perfil__conquista-link">
								<?php echo esc_html( $item['link']['texto'] ); ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M7 17L17 7M17 7H9M17 7V15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

	</div>
</section>