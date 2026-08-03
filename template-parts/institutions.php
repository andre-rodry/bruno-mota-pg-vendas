<?php
/**
 * template-parts/institutions.php
 * Barra "Atuação reconhecida por importantes instituições".
 *
 * Pra editar/adicionar logos, mexa no array $instituicoes abaixo.
 */

$instituicoes = array(
    array( 'nome' => 'CORECON', 'logo' => 'https://i.ibb.co/mFyRrqTW/1.png' ),
    array( 'nome' => 'COFECON', 'logo' => 'https://i.ibb.co/pjtRjBFP/2.png' ),
    array( 'nome' => 'UNICAMP', 'logo' => 'https://i.ibb.co/392nqFDY/3.png' ),
    array( 'nome' => 'BAND', 'logo' => 'https://i.ibb.co/7NL6C7sv/4.png' ),
    array( 'nome' => 'OUTRAS PALAVRAS', 'logo' => 'https://i.ibb.co/Wv3byZWx/5.png' ),
    array( 'nome' => 'RED', 'logo' => 'https://i.ibb.co/h17YTMvg/6.png' ),
    array( 'nome' => 'Expert', 'logo' => 'https://i.ibb.co/pr1ryqQy/7.png' ),
);
?>

<section class="bml-instituicoes">
    <div class="bml-instituicoes__inner">

        <p class="bml-instituicoes__titulo">Atuação reconhecida por importantes instituições</p>

        <div class="bml-instituicoes__logos">
            <?php foreach ( $instituicoes as $inst ) : ?>
                <img
                    src="<?php echo esc_url( $inst['logo'] ); ?>"
                    alt="<?php echo esc_attr( $inst['nome'] ); ?>"
                    class="bml-instituicoes__logo"
                    loading="lazy"
                >
            <?php endforeach; ?>
        </div>

    </div>
</section>