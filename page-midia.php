<?php
/**
 * page-midia.php
 * Template Name: Mídia
 *
 * Página que reúne a presença do economista Bruno Mota na mídia:
 * destaques, emissoras/veículos, TV, rádio, podcasts e imprensa.
 *
 * @package andreWP
 */

get_header();

get_template_part( 'midia/content-banner-midia' );
get_template_part( 'midia/content-midia-stats' );
get_template_part( 'midia/content-destaques-midia' );
get_template_part( 'midia/content-emissoras-midia' );
get_template_part( 'midia/content-tv-midia' );
get_template_part( 'midia/content-canais-midia' );

get_footer();