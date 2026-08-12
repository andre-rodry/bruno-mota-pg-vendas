<?php
/**
 * Template Name: Página Contato
 * page-contato.php
 * Template da página com slug "contato".
 */

get_header();
?>

<main id="main-content" class="contato-page">
    <?php get_template_part( 'contato/content-banner-contato' ); ?>
    <?php get_template_part( 'contato/content-form-contato' ); ?>
    <?php get_template_part( 'contato/content-faq-contato' ); ?>
</main>

<?php
get_footer();