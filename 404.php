<?php
/**
 * 404.php
 * Template exibido quando o WordPress não encontra a página/post
 * que corresponde à URL acessada (link quebrado, conteúdo removido etc.)
 */

get_header();
?>

<article class="error-404 not-found">

    <h1 class="entry-title">
        <?php esc_html_e( 'Página não encontrada', 'meu-tema' ); ?>
    </h1>

    <div class="entry-content">
        <p>
            <?php esc_html_e( 'Ops! O conteúdo que você procura não existe ou foi movido.', 'meu-tema' ); ?>
        </p>

        <p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php esc_html_e( '← Voltar para a página inicial', 'meu-tema' ); ?>
            </a>
        </p>

        <?php // Formulário de busca, ajuda o visitante a encontrar o que precisa. ?>
        <?php get_search_form(); ?>
    </div>

</article>

<?php
get_footer();