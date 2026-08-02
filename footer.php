<?php
/**
 * footer.php
 * Fim do documento HTML, carregado em toda página via get_footer().
 */
?>
    </div><!-- fecha .container do main -->
</main>

<footer class="site-footer">
    <div class="container">
        <nav class="footer-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'container'      => false,
                'fallback_cb'    => false,
            ) );
            ?>
        </nav>

        <p>
            &copy; <?php echo date( 'Y' ); ?>
            <?php bloginfo( 'name' ); ?> — Todos os direitos reservados.
        </p>
    </div>
</footer>

<?php wp_footer(); // OBRIGATÓRIO: plugins e o próprio WP dependem disso ?>
</body>
</html>
