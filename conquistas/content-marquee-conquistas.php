<?php
/**
 * Template part: Marquee — Página Conquistas - content-marquee-conquistas.php
 * Faixa horizontal com palavras rolando em loop infinito.
 *
 * @package andreWP
 */

$marquee_palavras = array(
	'Legado',
	'Excelência',
	'Autoridade',
	'Credibilidade',
	'Exclusividade',
	'Impacto',
	'Reconhecimento',
	'Inovação',
	'Compromisso',
	'Transparência',
	'Confiança',
	'Resultados',
	'Visão',
	'Propósito',
);

// Quantas vezes a lista se repete DENTRO de cada metade da faixa.
// A faixa é sempre formada por 2 metades idênticas (necessário para o
// loop infinito em CSS via translateX(-50%)) — mas cada metade agora
// contém a lista repetida algumas vezes, para garantir que ela seja
// mais larga que a tela. Assim, as duas metades nunca ficam visíveis
// ao mesmo tempo (o que antes dava a impressão de "repetição colada").
// Com a lista maior (14 palavras), 2 repetições por metade já bastam.
$marquee_repeticoes_por_metade = 2;
?>

<section class="marquee-conquistas">

	<div class="marquee-conquistas__track">

		<?php for ( $metade = 0; $metade < 2; $metade++ ) : ?>
			<div class="marquee-conquistas__group" aria-hidden="<?php echo $metade === 0 ? 'false' : 'true'; ?>">
				<?php for ( $rep = 0; $rep < $marquee_repeticoes_por_metade; $rep++ ) : ?>
					<?php foreach ( $marquee_palavras as $palavra ) : ?>
						<span class="marquee-conquistas__word"><?php echo esc_html( $palavra ); ?></span>
						<span class="marquee-conquistas__dot" aria-hidden="true">&middot;</span>
					<?php endforeach; ?>
				<?php endfor; ?>
			</div>
		<?php endfor; ?>

	</div>

</section>