<?php
/**
 * front-page.php
 * Template usado especificamente para a página inicial do site.
 */

get_header();
?>

<?php get_template_part( 'template-parts/banner' ); ?>

<main id="main-content">

    <?php get_template_part( 'template-parts/latest-article' ); ?>

    <?php get_template_part( 'template-parts/stats' ); ?>

    <?php get_template_part( 'template-parts/about' ); ?>

    <!-- Aqui entram as próximas seções: atuação, conquistas, publicações, mídia, contato -->

</main>

<?php
get_footer();