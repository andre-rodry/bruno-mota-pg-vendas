<?php
/**
 * Section: Prévia Exclusiva - Novo site de Bruno Mota Lopes
 * Estrutura de 2 níveis, igual ao componente original de reserva:
 *   Nível 1 -> abas do menu do site (Home, Sobre, Atuação, Trajetória...)
 *   Nível 2 -> miniaturas dos blocos de cada seção (equivalente às categorias
 *              de veículo), que trocam a imagem principal em destaque.
 *
 * As imagens/textos de cada bloco abaixo são FICTÍCIOS (placeholders) —
 * troque pelos prints/nomes reais de cada seção quando estiverem prontos.
 *
 * @package andreWP
 */

$img_base = get_template_directory_uri() . '/assets/img/previa-bruno-blocks/';

$previa_sections = array(
    'home' => array(
        'label'  => 'Home',
        'desc'   => 'Economia que transforma pessoas, instituições e o futuro. A nova home apresenta Bruno Mota com conteúdo, experiência, credibilidade e resultados.',
        'blocks' => array(
            array( 'tag' => 'Seção 1', 'name' => 'Hero Principal',        'img' => $img_base . 'home-1.png' ),
            array( 'tag' => 'Seção 2', 'name' => 'Chamada de Trajetória', 'img' => $img_base . 'home-2.png' ),
            array( 'tag' => 'Seção 3', 'name' => 'Provas Sociais',        'img' => $img_base . 'home-3.png' ),
        ),
    ),
    'sobre' => array(
        'label'  => 'Sobre',
        'desc'   => 'Economista, professor universitário e pesquisador, com atuação voltada ao desenvolvimento regional, educação financeira e políticas públicas.',
        'blocks' => array(
            array( 'tag' => 'Seção 1', 'name' => 'Apresentação',      'img' => $img_base . 'sobre-1.png' ),
            array( 'tag' => 'Seção 2', 'name' => 'Formação',          'img' => $img_base . 'sobre-2.png' ),
            array( 'tag' => 'Seção 3', 'name' => 'Áreas de Atuação',  'img' => $img_base . 'sobre-3.png' ),
        ),
    ),
    'atuacao' => array(
        'label'  => 'Atuação',
        'desc'   => 'Consultoria econômica, docência universitária e palestras internacionais — as frentes em que Bruno Mota atua para gerar impacto real.',
        'blocks' => array(
            array( 'tag' => 'Seção 1', 'name' => 'Consultoria', 'img' => $img_base . 'atuacao-1.png' ),
            array( 'tag' => 'Seção 2', 'name' => 'Docência',    'img' => $img_base . 'atuacao-2.png' ),
            array( 'tag' => 'Seção 3', 'name' => 'Palestras',   'img' => $img_base . 'atuacao-3.png' ),
        ),
    ),
    'trajetoria' => array(
        'label'  => 'Trajetória',
        'desc'   => 'Mais de 20 anos dedicados à economia, ao ensino e ao desenvolvimento de projetos e iniciativas com atuação em 4 países.',
        'blocks' => array(
            array( 'tag' => 'Seção 1', 'name' => 'Linha do Tempo',   'img' => $img_base . 'trajetoria-1.png' ),
            array( 'tag' => 'Seção 2', 'name' => 'Números',          'img' => $img_base . 'trajetoria-2.png' ),
            array( 'tag' => 'Seção 3', 'name' => 'Reconhecimentos',  'img' => $img_base . 'trajetoria-3.png' ),
        ),
    ),
    'publicacoes' => array(
        'label'  => 'Publicações',
        'desc'   => 'Uma ampla contribuição acadêmica que combina teoria e debate sobre economia, desenvolvimento e políticas públicas.',
        'blocks' => array(
            array( 'tag' => 'Seção 1', 'name' => 'Livros',    'img' => $img_base . 'publicacoes-1.png' ),
            array( 'tag' => 'Seção 2', 'name' => 'Artigos',   'img' => $img_base . 'publicacoes-2.png' ),
            array( 'tag' => 'Seção 3', 'name' => 'Capítulos', 'img' => $img_base . 'publicacoes-3.png' ),
        ),
    ),
    'midia' => array(
        'label'  => 'Mídia',
        'desc'   => 'Entrevistas, análises econômicas e participações em TV, rádio, podcasts e imprensa em destaque na mídia nacional e regional.',
        'blocks' => array(
            array( 'tag' => 'Seção 1', 'name' => 'Entrevistas', 'img' => $img_base . 'midia-1.png' ),
            array( 'tag' => 'Seção 2', 'name' => 'Imprensa',    'img' => $img_base . 'midia-2.png' ),
            array( 'tag' => 'Seção 3', 'name' => 'Podcasts',    'img' => $img_base . 'midia-3.png' ),
        ),
    ),
    'contato' => array(
        'label'  => 'Contato',
        'desc'   => 'Entre em contato para palestras, consultorias e convites. Fale diretamente com a equipe de Bruno Mota.',
        'blocks' => array(
            array( 'tag' => 'Seção 1', 'name' => 'Formulário',    'img' => $img_base . 'contato-1.png' ),
            array( 'tag' => 'Seção 2', 'name' => 'Informações',   'img' => $img_base . 'contato-2.png' ),
            array( 'tag' => 'Seção 3', 'name' => 'Localização',   'img' => $img_base . 'contato-3.png' ),
        ),
    ),
);

$section_keys = array_keys( $previa_sections );
$first_key    = $section_keys[0];
$first        = $previa_sections[ $first_key ];
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/home/page-previa-bruno.css">

<section class="previa-section previa-bruno-section">
<div class="previa-bruno">
    <div class="section-main-heading">
        <span class="brand-accent"><span class="brand-accent-text">✦ Prévia Exclusiva</span></span>
        <div class="headline-divider">
            <span class="divider-line divider-line-left"></span>
            <h2 class="main-headline">CONHEÇA O <span>NOVO SITE</span></h2>
            <span class="divider-line divider-line-right"></span>
        </div>
        <p class="main-sub">Em breve, um novo espaço para reunir <strong>publicações, participações na mídia, projetos e conteúdos exclusivos</strong> sobre economia e desenvolvimento.</p>
    </div>

    <div class="tabs-container">
        <div class="service-tabs" id="pb-service-tabs">
            <?php foreach ( $section_keys as $i => $key ) : ?>
            <div class="service-tab<?php echo 0 === $i ? ' active' : ''; ?>" onclick="pbSetSection('<?php echo esc_js( $key ); ?>', this)">
                <?php echo esc_html( $previa_sections[ $key ]['label'] ); ?>
            </div>
            <?php endforeach; ?>
            <div class="tab-slider" id="pb-tab-slider" style="width: <?php echo round( 100 / count( $section_keys ), 4 ); ?>%;"></div>
        </div>
    </div>

    <div class="fleet-card">
        <div class="content-area">
            <h1 class="display-title" id="pb-main-title"><?php echo esc_html( strtoupper( $first['label'] ) ); ?></h1>
            <p class="display-desc" id="pb-main-desc"><?php echo esc_html( $first['desc'] ); ?></p>

            <div class="block-thumb-group" id="pb-block-group">
                <?php foreach ( $first['blocks'] as $bi => $block ) : ?>
                <div class="block-thumb<?php echo 0 === $bi ? ' active' : ''; ?>" onclick="pbSetBlock('<?php echo esc_js( $first_key ); ?>', <?php echo (int) $bi; ?>, this)">
                    <img src="<?php echo esc_url( $block['img'] ); ?>" alt="<?php echo esc_attr( $block['name'] ); ?>" loading="lazy">
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="car-img-box" id="pb-image-container">
            <img id="pb-main-view-img" src="<?php echo esc_url( $first['blocks'][0]['img'] ); ?>" alt="Prévia da seção <?php echo esc_attr( $first['label'] ); ?>">
        </div>

        <div class="nav-arrows">
            <div class="nav-arrow" onclick="pbMoveBlock(-1)" aria-label="Bloco anterior">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"></path></svg>
            </div>
            <div class="nav-arrow" onclick="pbMoveBlock(1)" aria-label="Próximo bloco">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"></path></svg>
            </div>
        </div>

    </div>

    <div class="feature-bar">
        <div class="feature-item">
            <span class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M14 3v5h5"></path><path d="M6 3h8l5 5v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"></path><path d="M9 13h6M9 17h6"></path></svg></span>
            <span class="feature-text">Publicações e artigos<br>exclusivos</span>
        </div>
        <div class="feature-item">
            <span class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="9" y="2" width="6" height="12" rx="3"></rect><path d="M5 11a7 7 0 0 0 14 0M12 18v4M9 22h6"></path></svg></span>
            <span class="feature-text">Participações na mídia<br>e entrevistas</span>
        </div>
        <div class="feature-item">
            <span class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="7" width="18" height="13" rx="1.5"></rect><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18"></path></svg></span>
            <span class="feature-text">Projetos e iniciativas<br>em destaque</span>
        </div>
        <div class="feature-item">
            <span class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 20V10M12 20V4M20 20v-7"></path></svg></span>
            <span class="feature-text">Análises sobre economia<br>e desenvolvimento</span>
        </div>
    </div>
</div>
</section>

<script>
    // Dados completos (título, descrição e blocos) gerados pelo PHP para o JS.
    window.pbPreviaData = <?php echo wp_json_encode( $previa_sections ); ?>;
    window.pbPreviaOrder = <?php echo wp_json_encode( $section_keys ); ?>;
</script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/previa.js"></script>