<?php
/**
 * tracker.php
 * Sistema próprio de estatísticas: visitas e cliques.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Cria a tabela no banco de dados (roda só uma vez)
function meu_tracker_criar_tabela() {
    global $wpdb;
    $tabela = $wpdb->prefix . 'meu_tracker';
    $charset = $wpdb->get_charset_collate();

    if ( $wpdb->get_var( "SHOW TABLES LIKE '$tabela'" ) != $tabela ) {
        $sql = "CREATE TABLE $tabela (
            id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            tipo VARCHAR(20) NOT NULL,
            pagina VARCHAR(255) NOT NULL,
            elemento VARCHAR(255) DEFAULT NULL,
            ip VARCHAR(45) DEFAULT NULL,
            data_hora DATETIME NOT NULL
        ) $charset;";
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }
}
add_action( 'init', 'meu_tracker_criar_tabela' );

// 2. Carrega o JS de rastreamento no rodapé de todas as páginas
function meu_tracker_carregar_script() {
    ?>
    <script>
    (function() {
        function enviar(tipo, elemento) {
            fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'action=meu_tracker_registrar&tipo=' + encodeURIComponent(tipo) +
                      '&pagina=' + encodeURIComponent(window.location.pathname) +
                      '&elemento=' + encodeURIComponent(elemento || '')
            });
        }
        enviar('pageview');

        document.addEventListener('click', function(e) {
            var alvo = e.target.closest('[data-track]');
            if (alvo) {
                enviar('click', alvo.getAttribute('data-track'));
            }
        });
    })();
    </script>
    <?php
}
add_action( 'wp_footer', 'meu_tracker_carregar_script' );

// 3. Recebe e grava os dados (visitantes logados e não logados)
function meu_tracker_registrar() {
    global $wpdb;
    $tabela = $wpdb->prefix . 'meu_tracker';

    $wpdb->insert( $tabela, array(
        'tipo'      => sanitize_text_field( $_POST['tipo'] ?? '' ),
        'pagina'    => sanitize_text_field( $_POST['pagina'] ?? '' ),
        'elemento'  => sanitize_text_field( $_POST['elemento'] ?? '' ),
        'ip'        => sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' ),
        'data_hora' => current_time( 'mysql' ),
    ) );

    wp_die();
}
add_action( 'wp_ajax_meu_tracker_registrar', 'meu_tracker_registrar' );
add_action( 'wp_ajax_nopriv_meu_tracker_registrar', 'meu_tracker_registrar' );

// 4. Cria o painel de estatísticas no menu do WordPress
function meu_tracker_menu() {
    add_menu_page( 'Estatísticas do Site', 'Estatísticas', 'manage_options', 'meu-tracker', 'meu_tracker_pagina', 'dashicons-chart-bar', 30 );
}
add_action( 'admin_menu', 'meu_tracker_menu' );

// 5. Traduz o nome técnico do data-track para algo que qualquer pessoa entende
function meu_tracker_nome_amigavel( $slug ) {
    $nomes = array(
        'hero-comprar-livro'          => '🛒 Botão "Comprar o livro" (topo da página)',
        'hero-youtube-inscreva'       => '▶️ Botão "Acesse e se inscreva" (YouTube - topo)',
        'secao-comprar-clube-autores' => '🛒 Botão "Comprar agora" (Clube de Autores)',
        'footer-cta-whatsapp'         => '💬 Botão "Fale comigo" (WhatsApp - rodapé)',
        'footer-instagram'            => '📷 Ícone Instagram (rodapé)',
        'footer-whatsapp'             => '💬 Ícone WhatsApp (rodapé)',
        'footer-facebook'             => '📘 Ícone Facebook (rodapé)',
        'footer-youtube'              => '▶️ Ícone YouTube (rodapé)',
        'footer-linkedin'             => '💼 Ícone LinkedIn (rodapé)',
        'footer-tiktok'               => '🎵 Ícone TikTok (rodapé)',
    );

    return isset( $nomes[ $slug ] ) ? $nomes[ $slug ] : esc_html( $slug );
}

// 6. Desenha o painel de estatísticas (versão visual, fácil de ler)
function meu_tracker_pagina() {
    global $wpdb;
    $tabela = $wpdb->prefix . 'meu_tracker';

    $total_visitas = $wpdb->get_var( "SELECT COUNT(*) FROM $tabela WHERE tipo = 'pageview'" );
    $total_cliques = $wpdb->get_var( "SELECT COUNT(*) FROM $tabela WHERE tipo = 'click'" );

    $paginas_populares = $wpdb->get_results( "SELECT pagina, COUNT(*) as total FROM $tabela WHERE tipo = 'pageview' GROUP BY pagina ORDER BY total DESC LIMIT 10" );
    $cliques_populares = $wpdb->get_results( "SELECT elemento, COUNT(*) as total FROM $tabela WHERE tipo = 'click' GROUP BY elemento ORDER BY total DESC LIMIT 10" );
    $recentes          = $wpdb->get_results( "SELECT * FROM $tabela ORDER BY data_hora DESC LIMIT 20" );
    ?>

    <style>
        .mt-wrap { max-width: 1100px; margin-top: 20px; font-family: -apple-system, "Segoe UI", Roboto, sans-serif; }
        .mt-header { margin-bottom: 24px; }
        .mt-header h1 { font-size: 26px; margin-bottom: 4px; }
        .mt-header p { color: #666; font-size: 14px; margin: 0; }

        .mt-cards { display: flex; gap: 16px; margin-bottom: 32px; flex-wrap: wrap; }
        .mt-card {
            flex: 1; min-width: 220px;
            background: #fff; border-radius: 10px; padding: 20px 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            border-left: 5px solid #2271b1;
        }
        .mt-card.mt-card-clicks { border-left-color: #d63384; }
        .mt-card-label { font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
        .mt-card-value { font-size: 34px; font-weight: 700; color: #1d2327; line-height: 1; }
        .mt-card-icon { font-size: 22px; margin-bottom: 8px; display: block; }

        .mt-section { background: #fff; border-radius: 10px; padding: 22px 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        .mt-section h2 { font-size: 17px; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px; }

        .mt-table { width: 100%; border-collapse: collapse; }
        .mt-table th {
            text-align: left; font-size: 12px; text-transform: uppercase; letter-spacing: .5px;
            color: #888; padding: 8px 12px; border-bottom: 2px solid #eee;
        }
        .mt-table td { padding: 10px 12px; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        .mt-table tr:last-child td { border-bottom: none; }
        .mt-table tr:hover td { background: #fafafa; }

        .mt-badge { background: #f0f6fc; color: #2271b1; padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .mt-badge-click { background: #fdf0f5; color: #d63384; }

        .mt-empty { color: #999; font-style: italic; padding: 16px 12px; text-align: center; }

        .mt-tag-pageview { color: #2271b1; font-weight: 600; }
        .mt-tag-click { color: #d63384; font-weight: 600; }
    </style>

    <div class="wrap mt-wrap">

        <div class="mt-header">
            <h1>📊 Estatísticas do Site</h1>
            <p>Acompanhe as visitas e os cliques nos botões do seu site.</p>
        </div>

        <div class="mt-cards">
            <div class="mt-card">
                <span class="mt-card-icon">👀</span>
                <div class="mt-card-label">Visualizações de página</div>
                <div class="mt-card-value"><?php echo intval( $total_visitas ); ?></div>
            </div>
            <div class="mt-card mt-card-clicks">
                <span class="mt-card-icon">🖱️</span>
                <div class="mt-card-label">Cliques em botões</div>
                <div class="mt-card-value"><?php echo intval( $total_cliques ); ?></div>
            </div>
        </div>

        <div class="mt-section">
            <h2>📄 Páginas mais visitadas</h2>
            <table class="mt-table">
                <tr><th>Página</th><th>Visitas</th></tr>
                <?php if ( $paginas_populares ) : ?>
                    <?php foreach ( $paginas_populares as $p ) : ?>
                        <tr>
                            <td><?php echo esc_html( $p->pagina ); ?></td>
                            <td><span class="mt-badge"><?php echo intval( $p->total ); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="2" class="mt-empty">Ainda não há visitas registadas.</td></tr>
                <?php endif; ?>
            </table>
        </div>

        <div class="mt-section">
            <h2>🔗 Botões / links mais clicados</h2>
            <table class="mt-table">
                <tr><th>Botão</th><th>Cliques</th></tr>
                <?php if ( $cliques_populares ) : ?>
                    <?php foreach ( $cliques_populares as $c ) : ?>
                        <tr>
                            <td><?php echo meu_tracker_nome_amigavel( $c->elemento ); ?></td>
                            <td><span class="mt-badge mt-badge-click"><?php echo intval( $c->total ); ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="2" class="mt-empty">Ainda não há cliques registados. Clique em algum botão do site para testar.</td></tr>
                <?php endif; ?>
            </table>
        </div>

        <div class="mt-section">
            <h2>🕒 Atividade recente</h2>
            <table class="mt-table">
                <tr><th>Tipo</th><th>Página</th><th>Botão</th><th>Quando</th></tr>
                <?php if ( $recentes ) : ?>
                    <?php foreach ( $recentes as $r ) : ?>
                        <tr>
                            <td>
                                <?php if ( $r->tipo === 'pageview' ) : ?>
                                    <span class="mt-tag-pageview">👀 Visita</span>
                                <?php else : ?>
                                    <span class="mt-tag-click">🖱️ Clique</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo esc_html( $r->pagina ); ?></td>
                            <td><?php echo $r->elemento ? meu_tracker_nome_amigavel( $r->elemento ) : '—'; ?></td>
                            <td><?php echo esc_html( date( 'd/m/Y H:i', strtotime( $r->data_hora ) ) ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="4" class="mt-empty">Sem atividade ainda.</td></tr>
                <?php endif; ?>
            </table>
        </div>

    </div>
    <?php
}