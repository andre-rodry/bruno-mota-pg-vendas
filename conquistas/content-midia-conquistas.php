<?php
/**
 * Section: Na Mídia
 * Exibe cards com aparições em mídia (TV, rádio, podcast, entrevistas).
 */

$midias = [
    ['img' => 'midia1.PNG', 'alt' => 'BAND'],
    ['img' => 'midia2.PNG', 'alt' => 'Rádio Bahia FM'],
    ['img' => 'midia3.PNG', 'alt' => 'Podcast Outras Palavras'],
    ['img' => 'midia4.PNG', 'alt' => 'Entrevistas e Reportagens'],
];
?>

<section class="section-midia-conquistas">
    <div class="midia-container">

        <h2 class="midia-titulo">Na Mídia</h2>

        <div class="midia-grid">
            <?php foreach ($midias as $midia): ?>
                <div class="midia-item">
                    <img
                        src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/' . $midia['img']); ?>"
                        alt="<?php echo esc_attr($midia['alt']); ?>"
                        loading="lazy"
                    >
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>