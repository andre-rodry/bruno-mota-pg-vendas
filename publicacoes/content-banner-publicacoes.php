<?php
/**
 * Banner (Hero) da página de Publicações
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança: evita acesso direto ao arquivo.
}
?>

<section class="banner-publicacoes">
	<div class="banner-publicacoes__container">
		<div class="banner-publicacoes__content">

			<span class="banner-publicacoes__badge">
				<svg class="banner-publicacoes__badge-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M14 2v6h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
					<line x1="8" y1="13" x2="16" y2="13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
					<line x1="8" y1="17" x2="13" y2="17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
				</svg>
				Publicações
			</span>

			<h1 class="banner-publicacoes__title">
				Produção Acadêmica<br>
				<span class="banner-publicacoes__title-gold">e Intelectual</span>
			</h1>

			<p class="banner-publicacoes__lead">
				Livros, artigos científicos e publicações que contribuem para o debate sobre economia, desenvolvimento e políticas públicas.
			</p>

			<hr class="banner-publicacoes__divider">

			<p class="banner-publicacoes__description">
				Um acervo construído ao longo de anos de pesquisa e atuação no mercado financeiro.
			</p>

		</div>
	</div>
</section>