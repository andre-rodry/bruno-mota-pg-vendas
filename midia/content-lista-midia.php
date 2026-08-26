<?php
/**
 * content-lista-midia.php
 * Conteúdo da página de listagem de mídia (TV / Rádio / Podcasts / Imprensa)
 * Layout estático replicado da referência - sem JavaScript.
 */

// Dados de exemplo (substitua pela sua fonte real - banco de dados, CMS, etc.)
$itens = [
    [
        'canal'      => 'CNN Brasil',
        'canal_logo' => 'cnn',
        'titulo'     => 'CNN Brasil – Live',
        'destaque'   => 'Perspectivas econômicas para 2025',
        'descricao'  => 'Análise do cenário econômico global e os impactos no Brasil.',
        'data'       => '16 de abril de 2025',
        'duracao'    => '32 min',
    ],
    [
        'canal'      => 'Band News TV',
        'canal_logo' => 'band',
        'titulo'     => 'Band News TV',
        'destaque'   => 'Reforma tributária e cenário fiscal',
        'descricao'  => 'Discussão sobre os principais pontos da reforma tributária e seus efeitos.',
        'data'       => '09 de abril de 2025',
        'duracao'    => '28 min',
    ],
    [
        'canal'      => 'Poder360',
        'canal_logo' => 'poder360',
        'titulo'     => 'Poder360 Entrevista',
        'destaque'   => 'Desenvolvimento regional e investimentos',
        'descricao'  => 'O papel dos investimentos públicos e privados no desenvolvimento regional.',
        'data'       => '02 de abril de 2025',
        'duracao'    => '26 min',
    ],
    [
        'canal'      => 'Record News',
        'canal_logo' => 'record',
        'titulo'     => 'Record News',
        'destaque'   => 'Emprego e geração de renda no Brasil',
        'descricao'  => 'Panorama do mercado de trabalho e os desafios para 2025.',
        'data'       => '28 de março de 2025',
        'duracao'    => '24 min',
    ],
];

$canais_filtro = [
    'Todos os canais',
    'CNN Brasil',
    'Band News TV',
    'Poder360',
    'Record News',
    'SBT News',
    'Outros',
];

$abas_ano = ['TODAS', '2025', '2024', '2023', 'MAIS ANTIGAS'];
?>

<div class="lista-midia">
<div class="lm-page">

    <!-- ===================== NAVEGAÇÃO SUPERIOR ===================== -->
    <div class="lm-topnav">
        <nav class="lm-topnav__tabs">
            <a href="#" class="lm-topnav__tab is-active">
                <span class="lm-icon-camera" aria-hidden="true"></span>
                TODAS
            </a>
            <a href="#" class="lm-topnav__tab">
                <span class="lm-icon-tv" aria-hidden="true"></span>
                TV
            </a>
            <a href="#" class="lm-topnav__tab">
                <span class="lm-icon-radio" aria-hidden="true"></span>
                RÁDIO
            </a>
            <a href="#" class="lm-topnav__tab">
                <span class="lm-icon-podcast" aria-hidden="true"></span>
                PODCASTS
            </a>
            <a href="#" class="lm-topnav__tab">
                <span class="lm-icon-imprensa" aria-hidden="true"></span>
                IMPRENSA
            </a>
        </nav>

        <div class="lm-topnav__sort">
            <span class="lm-sort__label">ORDENAR POR</span>
            <div class="lm-select">
                <span>Mais recentes</span>
                <span class="lm-select__arrow" aria-hidden="true">&#9662;</span>
            </div>
        </div>
    </div>

    <!-- ===================== HERO ===================== -->
    <div class="lm-hero">
        <div class="lm-hero__bg" aria-hidden="true">
            <img
                src="https://images.unsplash.com/photo-1495020689067-958852a7765e?w=900&h=400&fit=crop"
                alt=""
                class="lm-hero__img"
            >
        </div>
        <div class="lm-hero__content">
            <h1 class="lm-hero__title">
                <span class="lm-icon-tv lm-icon-tv--lg" aria-hidden="true"></span>
                TV
            </h1>
            <h2 class="lm-hero__subtitle">Entrevistas e participações</h2>
            <p class="lm-hero__desc">
                Assista às participações em canais de TV, análises e comentários sobre economia,
                política e desenvolvimento regional.
            </p>
        </div>
    </div>

    <!-- ===================== CORPO: LISTA + SIDEBAR ===================== -->
    <div class="lm-body">

        <!-- ---------- COLUNA PRINCIPAL ---------- -->
        <div class="lm-main">

            <div class="lm-filterbar">
                <div class="lm-yeartabs">
                    <?php foreach ($abas_ano as $i => $ano): ?>
                        <a href="#" class="lm-yeartabs__tab <?php echo $i === 0 ? 'is-active' : ''; ?>">
                            <?php echo htmlspecialchars($ano); ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="lm-filterbar__sort">
                    <span class="lm-sort__label">ORDENAR POR</span>
                    <div class="lm-select">
                        <span>Mais recentes</span>
                        <span class="lm-select__arrow" aria-hidden="true">&#9662;</span>
                    </div>
                </div>
            </div>

            <ul class="lm-list">
                <?php foreach ($itens as $item): ?>
                    <li class="lm-card">
                        <div class="lm-card__logo lm-card__logo--<?php echo htmlspecialchars($item['canal_logo']); ?>">
                            <?php echo htmlspecialchars($item['canal']); ?>
                        </div>

                        <div class="lm-card__info">
                            <h3 class="lm-card__titulo"><?php echo htmlspecialchars($item['titulo']); ?></h3>
                            <p class="lm-card__destaque"><?php echo htmlspecialchars($item['destaque']); ?></p>
                            <p class="lm-card__descricao"><?php echo htmlspecialchars($item['descricao']); ?></p>
                        </div>

                        <div class="lm-card__meta">
                            <span class="lm-meta__linha">
                                <span class="lm-icon-calendar" aria-hidden="true"></span>
                                <?php echo htmlspecialchars($item['data']); ?>
                            </span>
                            <span class="lm-meta__linha">
                                <span class="lm-icon-clock" aria-hidden="true"></span>
                                <?php echo htmlspecialchars($item['duracao']); ?>
                            </span>
                        </div>

                        <div class="lm-card__acao">
                            <a href="#" class="lm-btn-play">
                                <span class="lm-icon-play" aria-hidden="true"></span>
                                ASSISTIR
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="lm-loadmore">
                <a href="#" class="lm-btn-outline">
                    CARREGAR MAIS
                    <span class="lm-icon-loading" aria-hidden="true"></span>
                </a>
            </div>

        </div>

        <!-- ---------- SIDEBAR ---------- -->
        <aside class="lm-sidebar">

            <div class="lm-sidebar__box">
                <h4 class="lm-sidebar__title">FILTRAR POR CANAL</h4>
                <ul class="lm-radiolist">
                    <?php foreach ($canais_filtro as $i => $canal): ?>
                        <li class="lm-radiolist__item">
                            <label>
                                <span class="lm-radio <?php echo $i === 0 ? 'is-checked' : ''; ?>" aria-hidden="true"></span>
                                <?php echo htmlspecialchars($canal); ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="lm-sidebar__box lm-destaque">
                <h4 class="lm-sidebar__title">
                    EM <span class="lm-destaque__accent">DESTAQUE</span>
                </h4>
                <div class="lm-destaque__card">
                    <div class="lm-destaque__thumb">
                        <img
                            src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=220&fit=crop"
                            alt=""
                            class="lm-destaque__img"
                        >
                        <span class="lm-destaque__play" aria-hidden="true">
                            <span class="lm-icon-play" aria-hidden="true"></span>
                        </span>
                    </div>
                    <p class="lm-destaque__titulo">Perspectivas econômicas para 2025</p>
                    <p class="lm-destaque__canal">CNN Brasil – Live</p>
                </div>
            </div>

        </aside>

    </div>

</div>
</div>