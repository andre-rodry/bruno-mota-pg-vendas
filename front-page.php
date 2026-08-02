<?php
/**
 * front-page.php
 * Template usado especificamente para a página inicial do site.
 */

get_header();
?>

<?php get_template_part( 'template-parts/banner' ); ?>

<main id="main-content">

    <!-- Aqui entram as próximas seções: sobre, atuação, conquistas, publicações, mídia, contato -->

    <!-- ===== INÍCIO DO CONTEÚDO DE TESTE (apagar depois) ===== -->
    <div style="max-width: 800px; margin: 0 auto; padding: 60px 24px 120px; font-family: sans-serif; line-height: 1.7;">

        <h2 style="margin-bottom: 24px;">Conteúdo de teste — role a página</h2>

        <?php for ( $i = 1; $i <= 25; $i++ ) : ?>
            <section style="margin-bottom: 48px;">
                <h3>Seção <?php echo $i; ?></h3>
                <p>
                    Este é um parágrafo de teste (bloco <?php echo $i; ?> de 25), usado apenas
                    para gerar altura suficiente na página e testar o comportamento de
                    aparecer/sumir do header durante o scroll. Role a página para baixo e
                    para cima para conferir o efeito.
                </p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                    veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                    commodo consequat.
                </p>
            </section>
        <?php endfor; ?>

        <p style="text-align: center; opacity: 0.6;">— fim do conteúdo de teste —</p>

    </div>
    <!-- ===== FIM DO CONTEÚDO DE TESTE ===== -->

</main>

<?php
get_footer();