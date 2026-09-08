<?php
/**
 * Section: Prévia Exclusiva - Novo site de Bruno Mota Lopes
 * Estrutura de 2 níveis:
 *   Nível 1 -> abas do menu do site (Home, Sobre, Atuação, Trajetória...)
 *   Nível 2 -> miniaturas dos prints de cada seção, que trocam a imagem
 *              principal em destaque.
 *
 * Imagens reais em: assets/img/previa-site/{secao}/{secao}-N.png
 *
 * @package andreWP
 */

$img_root = get_template_directory_uri() . '/assets/img/previa-site/';

$previa_sections = array(
    'home' => array(
        'label'  => 'Home',
        'desc'   => 'Economia que transforma pessoas, instituições e o futuro. A nova home apresenta Bruno Mota com conteúdo, experiência, credibilidade e resultados.',
        'blocks' => array(
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'home/home-1.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'home/home-2.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'home/home-3.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'home/home-4.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'home/home-5.png' ),
        ),
    ),
    'sobre' => array(
        'label'  => 'Sobre',
        'desc'   => 'Economista, professor universitário e pesquisador, com atuação voltada ao desenvolvimento regional, educação financeira e políticas públicas.',
        'blocks' => array(
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'sobre/sobre-1.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'sobre/sobre-2.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'sobre/sobre-3.png' ),
        ),
    ),
    'atuacao' => array(
        'label'  => 'Atuação',
        'desc'   => 'Consultoria econômica, docência universitária e palestras internacionais — as frentes em que Bruno Mota atua para gerar impacto real.',
        'blocks' => array(
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'atuacao/atuacao-1.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'atuacao/atuacao-2.png' ),
        ),
    ),
    'trajetoria' => array(
        'label'  => 'Trajetória',
        'desc'   => 'Mais de 20 anos dedicados à economia, ao ensino e ao desenvolvimento de projetos e iniciativas com atuação em 4 países.',
        'blocks' => array(
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'trajetoria/trajetoria-1.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'trajetoria/trajetoria-2.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'trajetoria/trajetoria-3.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'trajetoria/trajetoria-4.png' ),
        ),
    ),
    'publicacoes' => array(
        'label'  => 'Publicações',
        'desc'   => 'Uma ampla contribuição acadêmica que combina teoria e debate sobre economia, desenvolvimento e políticas públicas.',
        'blocks' => array(
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'publicacoes/publicacoes-1.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'publicacoes/publicacoes-2.png' ),
        ),
    ),
    'midia' => array(
        'label'  => 'Mídia',
        'desc'   => 'Entrevistas, análises econômicas e participações em TV, rádio, podcasts e imprensa em destaque na mídia nacional e regional.',
        'blocks' => array(
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'midia/midia-1.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'midia/midia-2.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'midia/midia-3.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'midia/midia-4.png' ),
        ),
    ),
    'contato' => array(
        'label'  => 'Contato',
        'desc'   => 'Entre em contato para palestras, consultorias e convites. Fale diretamente com a equipe de Bruno Mota.',
        'blocks' => array(
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'contato/contato-1.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'contato/contato-2.png' ),
            array( 'tag' => '', 'name' => '', 'img' => $img_root . 'contato/contato-3.png' ),
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
            <img id="pb-main-view-img" src="<?php echo esc_url( $first['blocks'][0]['img'] ); ?>" alt="Prévia da seção <?php echo esc_attr( $first['label'] ); ?>" onclick="pbOpenModal()">
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

    <div class="pb-modal" id="pb-modal" onclick="pbModalBackdropClick(event)">
        <button class="pb-modal-close" onclick="pbCloseModal()" aria-label="Fechar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"></path></svg>
        </button>

        <div class="pb-modal-arrow pb-modal-arrow-left" onclick="pbModalMove(-1, event)" aria-label="Anterior">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"></path></svg>
        </div>

        <div class="pb-modal-content" onclick="event.stopPropagation()">
            <div class="pb-modal-viewport" id="pb-modal-viewport">
                <img id="pb-modal-img" src="" alt="" draggable="false">
            </div>
            <p class="pb-modal-caption" id="pb-modal-caption"></p>
        </div>

        <div class="pb-modal-arrow pb-modal-arrow-right" onclick="pbModalMove(1, event)" aria-label="Próximo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"></path></svg>
        </div>

        <div class="pb-zoom-controls" onclick="event.stopPropagation()">
            <button class="pb-zoom-btn" onclick="pbZoomOut()" aria-label="Diminuir zoom">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"></circle><path d="M21 21l-4.3-4.3M8 11h6"></path></svg>
            </button>
            <span class="pb-zoom-level" id="pb-zoom-level">100%</span>
            <button class="pb-zoom-btn" onclick="pbZoomIn()" aria-label="Aumentar zoom">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"></circle><path d="M21 21l-4.3-4.3M11 8v6M8 11h6"></path></svg>
            </button>
            <button class="pb-zoom-btn pb-zoom-reset" onclick="pbResetZoom()" aria-label="Restaurar zoom">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 3-6.7"></path><path d="M3 4v5h5"></path></svg>
            </button>
        </div>
    </div>
</div>
</section>

<script>
    window.pbPreviaData = <?php echo wp_json_encode( $previa_sections ); ?>;
    window.pbPreviaOrder = <?php echo wp_json_encode( $section_keys ); ?>;
</script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/previa.js"></script>