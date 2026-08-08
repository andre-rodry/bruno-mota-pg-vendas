<?php
/**
 * Template part: Sobre (About)
 * Réplica do layout de referência — seção "Sobre Bruno Mota"
 *
 * @package andreWP
 */

$andrewp_img_base = get_template_directory_uri() . '/assets/img';
?>

<section class="pagination-about-hero pagination-about-midia" id="sobre">

	<div class="pagination-about-hero__media reveal">
		<div class="pagination-about-hero__glow" aria-hidden="true"></div>
		<div class="pagination-about-hero__bars" aria-hidden="true">
			<span></span><span></span><span></span><span></span><span></span>
		</div>

		<picture>
			<!-- Tablet e Mobile (até 899px) -> versão centralizada -->
			<source
				media="(max-width: 899px)"
				srcset="<?php echo esc_url( $andrewp_img_base . '/bruno-mota-economista-banner-sobre-centralizado.webp' ); ?>"
				type="image/webp"
			/>
			<!-- Desktop (>= 900px) -> versão hero -->
			<source
				media="(min-width: 900px)"
				srcset="<?php echo esc_url( $andrewp_img_base . '/bruno-mota-economista-banner-sobre-hero.webp' ); ?>"
				type="image/webp"
			/>
			<!-- Fallback -->
			<img
				class="pagination-about-hero__photo"
				src="<?php echo esc_url( $andrewp_img_base . '/bruno-mota-economista-banner-sobre-hero.webp' ); ?>"
				alt="<?php esc_attr_e( 'Bruno Mota, economista', 'andrewp' ); ?>"
				loading="eager"
				decoding="async"
			/>
		</picture>
	</div>

	<div class="pagination-about-hero__container">

		<div class="pagination-about-hero__content reveal reveal-delay-1">
			<span class="pagination-about-eyebrow">SOBRE</span>
			<h1 class="pagination-about-hero__title">Bruno Mota</h1>

			<p class="pagination-about-hero__subtitle">
				Economista, professor universitário e pesquisador, com atuação voltada ao desenvolvimento regional, educação financeira e políticas públicas.
			</p>

			<div class="pagination-about-badges">
				<span class="pagination-about-badge">Conselheiro Corecon-BA</span>
				<span class="pagination-about-badge">Pesquisador UNIFACS</span>
				<span class="pagination-about-badge">Autor e Palestrante Internacional</span>
			</div>

			<blockquote class="pagination-about-quote">
				<span class="pagination-about-quote__mark" aria-hidden="true">&ldquo;</span>
				<p class="pagination-about-quote__text">
					Não existe país rico com uma população endividada.
				</p>
				<p class="pagination-about-quote__caption">
					Acredita que educação financeira, desenvolvimento econômico e políticas públicas
					caminham juntas para construir uma sociedade mais justa e preparada para o futuro.
				</p>
			</blockquote>
		</div>

	</div>
</section>

<section class="pagination-about-stats">
	<div class="pagination-about-stats__container">

		<div class="stat-card reveal">
			<span class="stat-card__icon">
				<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 34l12-12 8 8 16-18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M32 12h10v10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</span>
			<span class="stat-card__number">+10 Mil</span>
			<p class="stat-card__text">Operações de crédito com empreendedores locais e microempresários.</p>
		</div>

		<div class="stat-card reveal reveal-delay-1">
			<span class="stat-card__icon">
				<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="17" stroke="currentColor" stroke-width="1.8"/><path d="M24 14v10l7 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</span>
			<span class="stat-card__number">+4.000h</span>
			<p class="stat-card__text">De conteúdos e entrevistas gravadas sobre Educação Financeira.</p>
		</div>

		<div class="stat-card reveal reveal-delay-2">
			<span class="stat-card__icon">
				<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="7" y="10" width="34" height="30" rx="3" stroke="currentColor" stroke-width="1.8"/><path d="M7 18h34M15 6v7M33 6v7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
			</span>
			<span class="stat-card__number">Desde 2006</span>
			<p class="stat-card__text">Atuando como Professor Universitário e Palestrante.</p>
		</div>

		<div class="stat-card reveal reveal-delay-3">
			<span class="stat-card__icon">
				<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5h16l8 8v30H12V5z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M28 5v8h8" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M17 26l4 4 10-10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</span>
			<span class="stat-card__number">Lei 93/2024</span>
			<p class="stat-card__text">Idealizador da Educação Financeira nas escolas de Salvador.</p>
			<a href="#" class="stat-card__link">
				Conheça a Lei <span aria-hidden="true">↗</span>
			</a>
		</div>

	</div>
</section>

<section class="pagination-about-bio">
	<div class="pagination-about-bio__container">
		<h2 class="pagination-about-bio__title reveal">Sobre Bruno Mota</h2>

		<div class="pagination-about-bio__text reveal reveal-delay-1">
			<p>
				Pai e economista, Bruno Mota Lopes destaca-se por sua atuação multifacetada e pelo
				impacto relevante no desenvolvimento regional e urbano. Sua trajetória iniciou-se em
				uma ONG de microcrédito, onde participou diretamente de mais de
				<strong>10 mil operações</strong> voltadas a empreendedores informais, micro e
				pequenos empresários.
			</p>
			<p>
				Essa vivência prática permitiu uma compreensão aprofundada da microeconomia do
				crédito e de seu impacto transformador nas famílias e comunidades. Unindo a
				experiência de campo a uma sólida formação, tornou-se referência nacional no tema,
				transformando suas pesquisas no premiado livro
				<em>&ldquo;Análise da Evolução do Microcrédito na Bahia (1973-2008)&rdquo;</em>,
				obra de consulta obrigatória na área.
			</p>
			<p>
				No ambiente digital, criou o canal <strong>Finanças para Jovens Oficial</strong>
				(presente no Instagram, LinkedIn, YouTube e TikTok), acumulando mais de 4.000 horas
				de entrevistas e conteúdos focados em educação financeira e desenvolvimento econômico.
			</p>
		</div>
	</div>
</section>

<section class="pagination-about-details">
	<div class="pagination-about-details__container">

		<div class="info-panel reveal">
			<h3 class="info-panel__title">Formação Acadêmica</h3>
			<ul class="info-panel__list">
				<li><strong>Doutorado (em andamento):</strong> Desenvolvimento Regional e Urbano (UNIFACS).</li>
				<li><strong>Mestrado:</strong> Desenvolvimento Regional e Urbano (UNIFACS).</li>
				<li><strong>Graduação:</strong> Ciências Econômicas (UNIFACS).</li>
			</ul>
		</div>

		<div class="info-panel reveal reveal-delay-1">
			<h3 class="info-panel__title">Atuação Acadêmica e Internacional</h3>
			<ul class="info-panel__list">
				<li><strong>Docência:</strong> Professor universitário atuante em diversas graduações desde 2006.</li>
				<li><strong>Presença Internacional:</strong> Apresentação de artigos científicos em congressos na Argentina, Portugal, Espanha e Cuba.</li>
				<li><strong>Palestras:</strong> Conferencista em eventos nacionais e internacionais sobre economia e inclusão.</li>
			</ul>
		</div>

		<div class="info-panel reveal reveal-delay-2">
			<h3 class="info-panel__title">Impacto e Políticas Públicas</h3>
			<ul class="info-panel__list">
				<li>
					<strong>Lei Municipal 93/2024:</strong> Idealizador do projeto de lei que instituiu a educação financeira nas escolas de Salvador.
					<a href="#" class="info-panel__link">Conheça a Lei <span aria-hidden="true">↗</span></a>
				</li>
				<li><strong>Desenvolvimento Local:</strong> Foco constante em projetos de microcrédito e fortalecimento da economia regional.</li>
			</ul>
		</div>

		<div class="info-panel reveal reveal-delay-3">
			<h3 class="info-panel__title">Prêmios e Publicações</h3>
			<ul class="info-panel__list">
				<li><strong>Premiações:</strong> Reconhecido com prêmios de excelência do Corecon-BA e do Banco do Nordeste do Brasil (BNB).</li>
				<li><strong>Livro Publicado:</strong> <em>Análise da Evolução do Microcrédito na Bahia (1973-2008)</em>.</li>
				<li><strong>Artigos Publicados:</strong> Colaborador de obras como <em>Reflexões dos Economistas Baianos</em> (Corecon-BA), <em>Leituras de Economia Política</em> (Unicamp), <em>Panorama das Contas Públicas</em> (SEI), <em>Conjuntura e Planejamento</em> &ndash; Especial Mulher e a <em>Revista de Desenvolvimento Regional</em>.</li>
			</ul>
		</div>

	</div>
</section>

<section class="pagination-about-cta">
	<div class="pagination-about-cta__container reveal">
		<div class="pagination-about-cta__info">
			<span class="pagination-about-cta__icon" aria-hidden="true">
				<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 10h32v22H18l-8 7V10z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M15 18h18M15 25h11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
			</span>
			<div>
				<h3 class="pagination-about-cta__title">Acompanhe o Trabalho</h3>
				<p class="pagination-about-cta__text">Conecte-se para palestras, conteúdos educativos e análises sobre economia e finanças.</p>
			</div>
		</div>
		<div class="pagination-about-cta__actions">
			<a href="#" class="pagination-about-cta__btn pagination-about-cta__btn--outline">Currículo Lattes</a>
			<a href="#" class="pagination-about-cta__btn pagination-about-cta__btn--filled">Canal no YouTube</a>
		</div>
	</div>
</section>