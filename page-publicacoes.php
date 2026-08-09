<?php
/**
 * Template: Publicações
 *
 * @package andreWP
 */

get_header();
?>

<?php get_template_part( 'publicacoes/content-banner', 'publicacoes' ); ?>
<?php get_template_part( 'publicacoes/content-categorias', 'publicacoes' ); ?>
<?php get_template_part( 'publicacoes/content-lista', 'publicacoes' ); ?>
<!-- próximas seções entram aqui, uma get_template_part por vez -->

<?php
get_footer();