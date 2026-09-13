<?php
/**
 * tracker.php
 * Sistema próprio de estatísticas: visitas e cliques.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Configurações: por quantos dias manter o histórico, e a janela de
// tempo (em minutos) usada para não contar a mesma visita repetida
if ( ! defined( 'MEU_TRACKER_RETENCAO_DIAS' ) ) {
    define( 'MEU_TRACKER_RETENCAO_DIAS', 90 );
}
if ( ! defined( 'MEU_TRACKER_JANELA_DEDUP_MINUTOS' ) ) {
    define( 'MEU_TRACKER_JANELA_DEDUP_MINUTOS', 5 );
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
            data_hora DATETIME NOT NULL,
            KEY tipo_pagina_data (tipo, pagina, data_hora)
        ) $charset;";
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }
}
add_action( 'init', 'meu_tracker_criar_tabela' );

// 1b. Agenda a limpeza automática diária (evita que a tabela cresça pra sempre)
function meu_tracker_agendar_limpeza() {
    if ( ! wp_next_scheduled( 'meu_tracker_evento_limpeza' ) ) {
        wp_schedule_event( time(), 'daily', 'meu_tracker_evento_limpeza' );
    }
}
add_action( 'init', 'meu_tracker_agendar_limpeza' );

// 1c. Executa a limpeza: apaga registros mais antigos que MEU_TRACKER_RETENCAO_DIAS
function meu_tracker_limpar_antigos() {
    global $wpdb;
    $tabela = $wpdb->prefix . 'meu_tracker';
    $wpdb->query( $wpdb->prepare(
        "DELETE FROM $tabela WHERE data_hora < DATE_SUB(NOW(), INTERVAL %d DAY)",
        MEU_TRACKER_RETENCAO_DIAS
    ) );
}
add_action( 'meu_tracker_evento_limpeza', 'meu_tracker_limpar_antigos' );

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

        // A deduplicação de visitas repetidas acontece no servidor
        // (por IP + janela de tempo), não aqui no navegador. Isso evita
        // que trocas de IP (VPN, rede móvel, etc.) fiquem bloqueadas
        // incorretamente por causa do sessionStorage.
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

    $tipo     = sanitize_text_field( $_POST['tipo'] ?? '' );
    $pagina   = sanitize_text_field( $_POST['pagina'] ?? '' );
    $elemento = sanitize_text_field( $_POST['elemento'] ?? '' );
    $ip       = sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' );

    // Deduplicação: se já existe uma visita do mesmo IP na mesma página
    // dentro da janela de tempo definida, não grava de novo. Isso evita
    // contar vários F5 seguidos como visitas separadas, mas ainda assim
    // conta normalmente quando o IP muda (ex: troca de rede/VPN).
    if ( $tipo === 'pageview' && $ip ) {
        $ja_existe = $wpdb->get_var( $wpdb->prepare(
            "SELECT id FROM $tabela
             WHERE tipo = 'pageview' AND pagina = %s AND ip = %s
             AND data_hora > DATE_SUB(NOW(), INTERVAL %d MINUTE)
             LIMIT 1",
            $pagina,
            $ip,
            MEU_TRACKER_JANELA_DEDUP_MINUTOS
        ) );

        if ( $ja_existe ) {
            wp_die();
        }
    }

    $wpdb->insert( $tabela, array(
        'tipo'      => $tipo,
        'pagina'    => $pagina,
        'elemento'  => $elemento,
        'ip'        => $ip,
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

// 5b. Monta a URL completa a partir do caminho salvo, sem duplicar
// a subpasta quando o WordPress está instalado dentro de um diretório
// (ex: localhost/bm-wp/). Usa só o esquema+domínio de home_url()
// e concatena o caminho salvo, que já vem completo do navegador.
function meu_tracker_montar_url( $caminho ) {
    $partes  = wp_parse_url( home_url() );
    $esquema = isset( $partes['scheme'] ) ? $partes['scheme'] : 'http';
    $host    = isset( $partes['host'] ) ? $partes['host'] : '';
    $porta   = isset( $partes['port'] ) ? ':' . $partes['port'] : '';

    return $esquema . '://' . $host . $porta . $caminho;
}

// 6. Processa o clique no botão "Limpar dados" (roda antes de desenhar a página)
function meu_tracker_processar_reset() {
    if ( ! isset( $_POST['meu_tracker_reset'] ) ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Você não tem permissão para fazer isso.' );
    }

    check_admin_referer( 'meu_tracker_reset_acao', 'meu_tracker_reset_nonce' );

    global $wpdb;
    $tabela = $wpdb->prefix . 'meu_tracker';
    $wpdb->query( "TRUNCATE TABLE $tabela" );

    wp_safe_redirect( add_query_arg( 'meu_tracker_reset', '1', menu_page_url( 'meu-tracker', false ) ) );
    exit;
}
add_action( 'admin_init', 'meu_tracker_processar_reset' );

// 7. Desenha o painel de estatísticas (versão visual, fácil de ler)
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
        .mt-header { margin-bottom: 8px; }
        .mt-header h1 { font-size: 26px; margin-bottom: 4px; }
        .mt-header p { color: #666; font-size: 14px; margin: 0 0 24px 0; }
        .mt-site-link { color: #2271b1; text-decoration: none; }
        .mt-site-link:hover { text-decoration: underline; }

        .mt-reset-form { margin: 32px 0 0 0; text-align: right; }
        .mt-reset-btn {
            background: #fff; color: #d63384; border: 1px solid #d63384;
            padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
        }
        .mt-reset-btn:hover { background: #fdf0f5; }

        .mt-aviso {
            background: #f0f9f0; color: #2a6b2a; border: 1px solid #cfe8cf;
            padding: 10px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 20px;
            opacity: 1; transition: opacity 0.6s ease, margin 0.6s ease, padding 0.6s ease;
        }
        .mt-aviso.mt-aviso-escondido {
            opacity: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; max-height: 0; overflow: hidden;
        }

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
        .mt-table td a { color: #2271b1; text-decoration: none; word-break: break-all; }
        .mt-table td a:hover { text-decoration: underline; }

        .mt-badge { background: #f0f6fc; color: #2271b1; padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .mt-badge-click { background: #fdf0f5; color: #d63384; }

        .mt-empty { color: #999; font-style: italic; padding: 16px 12px; text-align: center; }

        .mt-tag-pageview { color: #2271b1; font-weight: 600; }
        .mt-tag-click { color: #d63384; font-weight: 600; }
    </style>

    <div class="wrap mt-wrap">

        <?php if ( isset( $_GET['meu_tracker_reset'] ) && $_GET['meu_tracker_reset'] === '1' ) : ?>
            <div class="mt-aviso" id="mt-aviso-sucesso">✅ Dados de estatísticas limpos com sucesso.</div>
            <script>
            (function() {
                var aviso = document.getElementById('mt-aviso-sucesso');
                if ( aviso ) {
                    setTimeout( function() {
                        aviso.classList.add( 'mt-aviso-escondido' );
                    }, 3000 );
                }
            })();
            </script>
        <?php endif; ?>

        <div class="mt-header">
            <h1>📊 Estatísticas do Site: <a href="<?php echo esc_url( home_url() ); ?>" target="_blank" rel="noopener noreferrer" class="mt-site-link"><?php echo esc_html( preg_replace( '#^https?://#', '', home_url() ) ); ?></a></h1>
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
                            <td>
                                <a href="<?php echo esc_url( meu_tracker_montar_url( $p->pagina ) ); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php echo esc_html( meu_tracker_montar_url( $p->pagina ) ); ?>
                                </a>
                            </td>
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
                            <td>
                                <a href="<?php echo esc_url( meu_tracker_montar_url( $r->pagina ) ); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php echo esc_html( meu_tracker_montar_url( $r->pagina ) ); ?>
                                </a>
                            </td>
                            <td><?php echo $r->elemento ? meu_tracker_nome_amigavel( $r->elemento ) : '—'; ?></td>
                            <td><?php echo esc_html( date( 'd/m/Y H:i', strtotime( $r->data_hora ) ) ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="4" class="mt-empty">Sem atividade ainda.</td></tr>
                <?php endif; ?>
            </table>
        </div>

        <form class="mt-reset-form" method="post" onsubmit="return confirm('Tem certeza que deseja apagar TODOS os dados de estatísticas? Essa ação não pode ser desfeita.');">
            <?php wp_nonce_field( 'meu_tracker_reset_acao', 'meu_tracker_reset_nonce' ); ?>
            <button type="submit" name="meu_tracker_reset" value="1" class="mt-reset-btn">
                🗑️ Limpar dados
            </button>
        </form>

    </div>
    <?php
}