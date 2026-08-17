<?php
/**
 * Template Name: Atuação
 */

get_header();
?>

<main id="main-content">
	<?php get_template_part( 'atuacao/content-banner-atuacao' ); ?>
	<?php get_template_part( 'atuacao/content-areas-atuacao' ); ?>
	<?php get_template_part( 'atuacao/content-especializacao-atuacao' ); ?>
	<?php get_template_part( 'atuacao/content-cta-atuacao' ); ?>
</main>

<?php
get_footer();