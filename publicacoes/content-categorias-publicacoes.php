<?php
/**
 * Categorias de Publicações
 * Cards de filtro (Livros, Artigos, Publicações em Revistas, Capítulos de Livros)
 * Sobrepõe o rodapé do banner de Publicações.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança: evita acesso direto ao arquivo.
}

$categorias_publicacoes = array(
	array(
		'slug'  => 'livros',
		'label' => 'Livros',
		'total' => 8,
		'icon'  => 'livro',
	),
	array(
		'slug'  => 'artigos',
		'label' => 'Artigos',
		'total' => 63,
		'icon'  => 'artigo',
	),
	array(
		'slug'  => 'revistas',
		'label' => 'Publicações em Revistas',
		'total' => 12,
		'icon'  => 'revista',
	),
	array(
		'slug'  => 'capitulos',
		'label' => 'Capítulos de Livros',
		'total' => 15,
		'icon'  => 'capitulo',
	),
);

// Categoria ativa por padrão (nenhuma selecionada até o usuário escolher).
$categoria_ativa = '';
?>

<section class="categorias-publicacoes">
	<div class="categorias-publicacoes__container">
		<div class="categorias-publicacoes__grid" role="tablist" aria-label="Filtrar publicações por categoria">

			<?php foreach ( $categorias_publicacoes as $categoria ) : ?>
				<?php $is_ativa = ( $categoria['slug'] === $categoria_ativa ); ?>

				<button
					type="button"
					class="categoria-publicacao-card<?php echo $is_ativa ? ' is-active' : ''; ?>"
					data-categoria="<?php echo esc_attr( $categoria['slug'] ); ?>"
					role="tab"
					aria-selected="<?php echo $is_ativa ? 'true' : 'false'; ?>"
				>
					<span class="categoria-publicacao-card__icon">
						<?php switch ( $categoria['icon'] ) :
							case 'livro' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M2 5.5C2 4.67 2.67 4 3.5 4H10a2 2 0 0 1 2 2v14a1.5 1.5 0 0 0-1.5-1.5H3.5A1.5 1.5 0 0 1 2 17V5.5z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
									<path d="M22 5.5c0-.83-.67-1.5-1.5-1.5H14a2 2 0 0 0-2 2v14a1.5 1.5 0 0 1 1.5-1.5h6.5a1.5 1.5 0 0 0 1.5-1.5V5.5z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
								</svg>
							<?php break;

							case 'artigo' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M14 2v6h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
									<line x1="8" y1="13" x2="16" y2="13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<line x1="8" y1="17" x2="13" y2="17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
								</svg>
							<?php break;

							case 'revista' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect x="3" y="4" width="14" height="17" rx="1.5" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
									<path d="M17 8h2.5A1.5 1.5 0 0 1 21 9.5V19a2 2 0 0 1-2 2h-2" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
									<line x1="6" y1="9" x2="14" y2="9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<line x1="6" y1="13" x2="14" y2="13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<line x1="6" y1="17" x2="11" y2="17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
								</svg>
							<?php break;

							case 'capitulo' : ?>
								<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect x="4" y="3" width="16" height="18" rx="1.5" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
									<line x1="8" y1="8" x2="16" y2="8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<line x1="8" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
									<line x1="8" y1="16" x2="13" y2="16" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
								</svg>
							<?php break;
						endswitch; ?>
					</span>

					<span class="categoria-publicacao-card__label"><?php echo esc_html( $categoria['label'] ); ?></span>
					<span class="categoria-publicacao-card__total"><?php echo esc_html( $categoria['total'] ); ?> publicações</span>
				</button>

			<?php endforeach; ?>

		</div>
	</div>
</section>