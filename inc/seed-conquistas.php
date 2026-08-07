<?php
/**
 * Seed: 20 conquistas fictícias (dados de teste)
 *
 * COMO USAR:
 * 1) Salve este arquivo em /inc/seed-conquistas.php
 * 2) No functions.php, adicione temporariamente (logo abaixo do require do cpt-conquistas.php):
 *    require_once get_template_directory() . '/inc/seed-conquistas.php';
 * 3) Acesse no navegador, logado como administrador:
 *    https://SEU-SITE/wp-admin/?andrewp_seed_conquistas=1
 * 4) Depois que aparecer a mensagem de sucesso, REMOVA o require_once do functions.php
 *    (ou apague este arquivo) — ele só deve rodar uma vez.
 *
 * As imagens vêm do Picsum (picsum.photos), um serviço de fotos placeholder
 * genéricas e gratuitas — não são fotos reais da pessoa, só pra preencher
 * os cards durante o desenvolvimento. Troque pelas imagens reais depois.
 *
 * @package andreWP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function andrewp_seed_conquistas() {
	if ( ! isset( $_GET['andrewp_seed_conquistas'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Evita rodar duas vezes sem querer.
	if ( get_option( 'andrewp_seed_conquistas_done' ) ) {
		wp_die( 'Seed já foi executado antes. Apague a opção "andrewp_seed_conquistas_done" no banco se quiser rodar de novo.' );
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$itens = array(
		array( 'titulo' => 'Lei Municipal 4521/2024 - Educação Financeira nas Escolas', 'tipo' => 'legislacao', 'ano' => 2024, 'resumo' => 'Institui a educação financeira obrigatória na rede municipal de ensino.', 'destaque' => true ),
		array( 'titulo' => 'Fórum Ibero-Americano de Economia Digital', 'tipo' => 'palestra', 'ano' => 2025, 'resumo' => 'Debate sobre inovação financeira e inclusão bancária na América Latina.', 'destaque' => false ),
		array( 'titulo' => 'Palestra na FGV sobre Política Monetária', 'tipo' => 'palestra', 'ano' => 2023, 'resumo' => 'Aula aberta sobre os desafios da política monetária pós-pandemia.', 'destaque' => false ),
		array( 'titulo' => 'Artigo Publicado na Revista Brasileira de Economia', 'tipo' => 'artigo', 'ano' => 2024, 'resumo' => 'Estudo sobre os limites fiscais dos municípios de pequeno porte.', 'destaque' => true ),
		array( 'titulo' => 'Participação no Podcast Economia Sem Rodeios', 'tipo' => 'podcast', 'ano' => 2025, 'resumo' => 'Discussão sobre cenário econômico e tomada de decisão em tempos de incerteza.', 'destaque' => false ),
		array( 'titulo' => 'Entrevista na Rádio CBN Regional', 'tipo' => 'entrevista', 'ano' => 2025, 'resumo' => 'Análise sobre inflação, mercado e perspectivas para o próximo semestre.', 'destaque' => false ),
		array( 'titulo' => 'Congresso Nacional de Finanças Públicas', 'tipo' => 'evento', 'ano' => 2023, 'resumo' => 'Participação como palestrante convidado no maior evento do setor.', 'destaque' => false ),
		array( 'titulo' => 'Reconhecimento CORECON Regional', 'tipo' => 'premiacao', 'ano' => 2022, 'resumo' => 'Homenagem por contribuição ao desenvolvimento econômico regional.', 'destaque' => true ),
		array( 'titulo' => 'Curso de Extensão em Finanças Públicas Municipais', 'tipo' => 'curso', 'ano' => 2024, 'resumo' => 'Conclusão do curso de especialização voltado a gestores públicos.', 'destaque' => false ),
		array( 'titulo' => 'Mesa Redonda sobre Reforma Tributária', 'tipo' => 'evento', 'ano' => 2024, 'resumo' => 'Debate técnico com especialistas sobre os impactos da reforma nos municípios.', 'destaque' => false ),
		array( 'titulo' => 'Lei Municipal 3987/2023 - Transparência Orçamentária', 'tipo' => 'legislacao', 'ano' => 2023, 'resumo' => 'Estabelece novos critérios de transparência nas contas públicas municipais.', 'destaque' => false ),
		array( 'titulo' => 'Publicação no Boletim de Conjuntura Econômica', 'tipo' => 'publicacao', 'ano' => 2025, 'resumo' => 'Análise trimestral sobre o comportamento do mercado de trabalho local.', 'destaque' => false ),
		array( 'titulo' => 'Palestra na Universidade Federal sobre Gestão Pública', 'tipo' => 'palestra', 'ano' => 2022, 'resumo' => 'Aula magna sobre eficiência do gasto público em pequenos municípios.', 'destaque' => false ),
		array( 'titulo' => 'Entrevista para o Jornal Econômico Nacional', 'tipo' => 'entrevista', 'ano' => 2023, 'resumo' => 'Comentários sobre o cenário fiscal e as projeções para o ano seguinte.', 'destaque' => false ),
		array( 'titulo' => 'Artigo Científico Apresentado no XIV Encontro de Economistas', 'tipo' => 'artigo', 'ano' => 2022, 'resumo' => 'Abordagem sobre planejamento estratégico e limites fiscais.', 'destaque' => false ),
		array( 'titulo' => 'Prêmio Destaque em Gestão Fiscal Responsável', 'tipo' => 'premiacao', 'ano' => 2024, 'resumo' => 'Reconhecimento nacional por boas práticas em responsabilidade fiscal.', 'destaque' => true ),
		array( 'titulo' => 'Podcast Café com Economia - Episódio Especial', 'tipo' => 'podcast', 'ano' => 2024, 'resumo' => 'Conversa sobre educação financeira e o papel do economista na sociedade.', 'destaque' => false ),
		array( 'titulo' => 'Curso Livre de Introdução à Macroeconomia', 'tipo' => 'curso', 'ano' => 2023, 'resumo' => 'Ministrante convidado em curso de formação continuada.', 'destaque' => false ),
		array( 'titulo' => 'Seminário Internacional de Desenvolvimento Regional', 'tipo' => 'evento', 'ano' => 2025, 'resumo' => 'Apresentação de estudo de caso sobre desenvolvimento econômico regional.', 'destaque' => false ),
		array( 'titulo' => 'Publicação no Portal de Estudos Econômicos', 'tipo' => 'publicacao', 'ano' => 2022, 'resumo' => 'Artigo técnico sobre indicadores sociais e crescimento econômico.', 'destaque' => false ),
	);

	$criados = 0;
	$erros   = array();

	foreach ( $itens as $i => $item ) {
		$post_id = wp_insert_post( array(
			'post_type'    => 'conquista',
			'post_title'   => $item['titulo'],
			'post_excerpt' => $item['resumo'],
			'post_content' => $item['resumo'],
			'post_status'  => 'publish',
			'post_date'    => sprintf( '%d-%02d-%02d 10:00:00', $item['ano'], wp_rand( 1, 12 ), wp_rand( 1, 28 ) ),
		) );

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			$erros[] = $item['titulo'];
			continue;
		}

		// Vincula o tipo (taxonomia).
		wp_set_object_terms( $post_id, $item['tipo'], 'tipo_conquista' );

		// Marca destaque.
		if ( $item['destaque'] ) {
			update_post_meta( $post_id, '_conquista_destaque', '1' );
		}

		// Sideload de imagem placeholder (Picsum) como imagem destacada.
		$img_url = 'https://picsum.photos/seed/conquista' . $i . '/900/675';
		$media_id = media_sideload_image( $img_url, $post_id, $item['titulo'], 'id' );

		if ( ! is_wp_error( $media_id ) ) {
			set_post_thumbnail( $post_id, $media_id );
		}

		$criados++;
	}

	update_option( 'andrewp_seed_conquistas_done', 1 );

	$msg = "Seed concluído: {$criados} conquistas criadas.";
	if ( $erros ) {
		$msg .= ' Falharam: ' . implode( ', ', $erros );
	}

	wp_die( esc_html( $msg ) . '<br><br><a href="' . esc_url( home_url( '/conquistas/' ) ) . '">Ver página de Conquistas</a>' );
}
add_action( 'admin_init', 'andrewp_seed_conquistas' );