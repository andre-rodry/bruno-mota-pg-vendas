<?php
/**
 * Section: Instituições e Parceiros
 * Exibe o grid estático de logos de instituições parceiras.
 */

$parceiros = [
    ['img' => 'parceiro-1.PNG',  'alt' => 'CORECON - Conselho Regional de Economia'],
    ['img' => 'parceiro-2.PNG',  'alt' => 'COFECON - Conselho Federal de Economia'],
    ['img' => 'parceiro-3.PNG',  'alt' => 'Banco do Nordeste'],
    ['img' => 'parceiro-4.PNG',  'alt' => 'Câmara Municipal de Salvador'],
    ['img' => 'parceiro-5.PNG',  'alt' => 'UNISC - Universidade de Santa Cruz do Sul'],
    ['img' => 'parceiro-6.PNG',  'alt' => 'Unioeste - Universidade Estadual do Oeste do Paraná'],
    ['img' => 'parceiro-7.PNG',  'alt' => 'APDR - Associação Portuguesa para o Desenvolvimento Regional'],
    ['img' => 'parceiro-8.PNG',  'alt' => 'UNIFACS - Laureate International Universities'],
    ['img' => 'parceiro-9.PNG',  'alt' => 'SBPC - Sociedade Brasileira para o Progresso da Ciência'],
    ['img' => 'parceiro-10.PNG', 'alt' => 'ALIANZA - Alianza Latinoamericana de Estudios Críticos sobre el Desarrollo'],
];
?>

<section class="section-parceiros-conquistas">
    <div class="parceiros-container">

        <h2 class="parceiros-titulo">Instituições e Parceiros</h2>

        <div class="parceiros-grid">
            <?php foreach ($parceiros as $parceiro): ?>
                <div class="parceiro-item">
                    <img
                        src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/' . $parceiro['img']); ?>"
                        alt="<?php echo esc_attr($parceiro['alt']); ?>"
                        loading="lazy"
                    >
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>