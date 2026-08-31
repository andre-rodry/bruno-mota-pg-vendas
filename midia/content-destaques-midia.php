<?php
/**
 * Template Part: Destaques de Mídia
 *
 * Exibe a seção "Em Destaque" com uma entrevista principal (card grande)
 * e duas entrevistas secundárias (cards pequenos) à direita.
 *
 * Caminho correto dos assets (confirmado na pasta do tema):
 * wp-content/themes/andreWP/assets/img/midia/
 *
 * Uso: get_template_part( 'content', 'destaques-midia' );
 */

// Caminho base dos assets de mídia (imagens/logos) — usado nas tags <img>
$midia_base = get_template_directory_uri() . '/assets/img/midia/';
// Caminho em disco (sem URL) — usado só para ler as dimensões reais do arquivo
$midia_dir  = get_template_directory() . '/assets/img/midia/';

/**
 * Calcula o aspect-ratio real de uma imagem a partir do arquivo em disco.
 * Isso garante que o card use exatamente a proporção da foto,
 * então object-fit: cover nunca precisa cortar nada (como a logo do
 * canal no canto), nem sobra espaço vazio (letterboxing).
 *
 * @param string $filename Nome do arquivo dentro de assets/img/midia/
 * @param string $midia_dir Caminho em disco da pasta de mídia
 * @return string Ex.: "1681 / 936" (pronto para usar em aspect-ratio)
 */
function andrewp_get_image_ratio( $filename, $midia_dir ) {
	$caminho = $midia_dir . $filename;
	if ( file_exists( $caminho ) ) {
		$tamanho = @getimagesize( $caminho );
		if ( $tamanho && $tamanho[0] > 0 && $tamanho[1] > 0 ) {
			return $tamanho[0] . ' / ' . $tamanho[1];
		}
	}
	return '1681 / 936'; // fallback caso o arquivo não seja encontrado
}

// ---------------------------------------------------------------------
// Dados do destaque principal (card grande à esquerda)
// Ajuste os valores abaixo (imagem, textos e link) conforme a matéria.
//
// Obs.: 'logo_canal' é opcional. Deixe como '' quando a imagem de fundo
// já tiver a logo do canal "impressa" na própria foto (como é o caso do
// Jornal da Band abaixo), evitando a logo duplicada no canto.
// ---------------------------------------------------------------------
$destaque_principal_arquivo = 'economista-entrevista-jornal-da-band.webp';

$destaque_principal = array(
	'imagem_bg'   => $midia_base . $destaque_principal_arquivo,
	'imagem_ratio'=> andrewp_get_image_ratio( $destaque_principal_arquivo, $midia_dir ),
	'logo_canal'  => $midia_base . 'logo-jornal-da-band.webp',
	'logo_alt'    => 'Jornal da Band',
	'tag'         => 'REPERCUSSÃO NACIONAL — 100 MIL PESSOAS',
	'titulo'      => 'Inflação tem menor alta do ano com queda no preço dos alimentos',
	'descricao'   => 'Participação nacional no Jornal da Band, alcançando 100 mil pessoas, sobre a menor alta da inflação no ano, impulsionada pela queda no preço dos alimentos.',
	'botao_texto' => 'ASSISTIR ENTREVISTA',
	'link'        => '#', // substitua pelo link real do vídeo/matéria
);

// Exemplo de outro destaque principal (agronegócio) — troque os dados acima
// por este bloco quando quiser exibi-lo em vez do atual:
//
// $destaque_principal_arquivo = 'agro-negocio-tarifas-impactos-agro-band.png';
// $destaque_principal = array(
// 	'imagem_bg'    => $midia_base . $destaque_principal_arquivo,
// 	'imagem_ratio' => andrewp_get_image_ratio( $destaque_principal_arquivo, $midia_dir ),
// 	'logo_canal'   => $midia_base . 'band-logo.webp',
// 	'logo_alt'     => 'Band',
// 	'tag'          => 'ENTREVISTA EM DESTAQUE',
// 	'titulo'       => 'Impactos das tarifas no agronegócio',
// 	'descricao'    => 'Entrevista à Band sobre os impactos das tarifas no agronegócio e os fatores que influenciam o cenário atual do setor.',
// 	'botao_texto'  => 'ASSISTIR ENTREVISTA',
// 	'link'         => '#',
// );

// ---------------------------------------------------------------------
// Dados dos destaques secundários (cards pequenos à direita)
//
// 'logo_offset' (em px): compensa a margem transparente que existe
// dentro do próprio arquivo da logo, "puxando" o desenho para a
// esquerda até ele começar exatamente na mesma linha vertical do
// título/texto abaixo (como indicado pelas linhas guia no protótipo).
//
// 'logo_height' (em px): altura da caixa da logo. Padrão é 46px caso
// não seja informado. Reduza para logos que aparentam maiores que as
// outras (ex.: BATV), aumente para logos que aparentam menores.
//
// Como calibrar: ajuste os valores aos poucos até a logo ficar do
// mesmo "peso visual" das demais e alinhada com o início do título.
// Cada logo pode precisar de valores diferentes, pois o desenho/
// margem interna varia de arquivo para arquivo.
// ---------------------------------------------------------------------
$destaque_sec_1_arquivo = 'agro-negocio-tarifas-impactos-agro-band.webp';
$destaque_sec_2_arquivo = 'entrevista-tv-globo.webp';

$destaques_secundarios = array(
	array(
		'imagem_bg'    => $midia_base . $destaque_sec_2_arquivo,
		'imagem_ratio' => andrewp_get_image_ratio( $destaque_sec_2_arquivo, $midia_dir ),
		'logo'         => $midia_base . 'globo-logo.webp',
		'logo_alt'     => 'TV Globo',
		'logo_offset'  => 6, // ajuste este valor até a logo alinhar com o texto
		'logo_height'  => 42, // aumentada mais um pouco
		'titulo'       => 'Bom Dia Brasil: queda no preço do café',
		'descricao'    => 'Dólar, oferta internacional e os preços do café.',
		'link'         => '#', // substitua pelo link real do vídeo/matéria
	),
	array(
		'imagem_bg'    => $midia_base . $destaque_sec_1_arquivo,
		'imagem_ratio' => andrewp_get_image_ratio( $destaque_sec_1_arquivo, $midia_dir ),
		'logo'         => $midia_base . 'agro-band-logo.webp',
		'logo_alt'     => 'AgroBand',
		'logo_offset'  => 10, // ajuste este valor até a logo alinhar com o texto
		'logo_height'  => 46, // altura da logo em px
		'titulo'       => 'Perspectivas do agronegócio para 2024',
		'descricao'    => 'Análise sobre o cenário do agro e os desafios do setor.',
		'link'         => '#', // substitua pelo link real do vídeo/matéria
	),
);
?>

<section class="destaques-midia">
	<div class="destaques-midia__container">

		<h2 class="destaques-midia__eyebrow">Entrevistas em Destaque</h2>

		<div class="destaques-midia__grid">

			<!-- Card principal -->
			<a
				href="<?php echo esc_url( $destaque_principal['link'] ); ?>"
				class="destaque-card destaque-card--principal"
				style="--img-ratio: <?php echo esc_attr( $destaque_principal['imagem_ratio'] ); ?>;"
			>
				<img
					class="destaque-card__bg-img"
					src="<?php echo esc_url( $destaque_principal['imagem_bg'] ); ?>"
					alt=""
					loading="lazy"
				/>
				<span class="destaque-card__overlay" aria-hidden="true"></span>

				<?php if ( ! empty( $destaque_principal['logo_canal'] ) ) : ?>
					<span class="destaque-card__logo-canto">
						<img
							src="<?php echo esc_url( $destaque_principal['logo_canal'] ); ?>"
							alt="<?php echo esc_attr( $destaque_principal['logo_alt'] ); ?>"
							loading="lazy"
						/>
					</span>
				<?php endif; ?>

				<div class="destaque-card__conteudo">
					<span class="destaque-card__tag"><?php echo esc_html( $destaque_principal['tag'] ); ?></span>
					<h3 class="destaque-card__titulo"><?php echo esc_html( $destaque_principal['titulo'] ); ?></h3>
					<p class="destaque-card__descricao"><?php echo esc_html( $destaque_principal['descricao'] ); ?></p>

					<span class="destaque-card__botao">
						<?php echo esc_html( $destaque_principal['botao_texto'] ); ?>
						<svg class="destaque-card__botao-icone" viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true">
							<path d="M8 5v14l11-7z"></path>
						</svg>
					</span>
				</div>
			</a>

			<!-- Coluna de cards secundários -->
			<div class="destaques-midia__coluna-secundaria">
				<?php foreach ( $destaques_secundarios as $item ) : ?>
					<?php
					$logo_offset = isset( $item['logo_offset'] ) ? (int) $item['logo_offset'] : 0;
					$logo_height = isset( $item['logo_height'] ) ? (int) $item['logo_height'] : 46;
					?>
					<a
						href="<?php echo esc_url( $item['link'] ); ?>"
						class="destaque-card destaque-card--secundario"
						style="--img-ratio: <?php echo esc_attr( $item['imagem_ratio'] ); ?>;"
					>
						<img
							class="destaque-card__bg-img"
							src="<?php echo esc_url( $item['imagem_bg'] ); ?>"
							alt=""
							loading="lazy"
						/>
						<span class="destaque-card__overlay" aria-hidden="true"></span>

						<div class="destaque-card__conteudo-secundario">
							<span
								class="destaque-card__logo-secundario"
								style="--logo-trim: <?php echo esc_attr( $logo_offset ); ?>px; --logo-height: <?php echo esc_attr( $logo_height ); ?>px;"
							>
								<img
									src="<?php echo esc_url( $item['logo'] ); ?>"
									alt="<?php echo esc_attr( $item['logo_alt'] ); ?>"
									loading="lazy"
								/>
							</span>
							<h4 class="destaque-card__titulo-secundario"><?php echo esc_html( $item['titulo'] ); ?></h4>
							<p class="destaque-card__descricao-secundaria"><?php echo esc_html( $item['descricao'] ); ?></p>
						</div>

						<span class="destaque-card__play-secundario" aria-hidden="true">
							<svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
								<path d="M8 5v14l11-7z"></path>
							</svg>
						</span>
					</a>
				<?php endforeach; ?>
			</div>

		</div>
	</div>
</section>