<?php
/**
 * Template part: Seção "O que este livro vai fazer por você"
 * Home - andreWP
 */

$beneficios = array(
	array(
		'icon'  => 'produtividade',
		'title' => 'Mais Produtividade',
		'desc'  => 'Automatize tarefas e ganhe tempo para o que realmente importa.',
	),
	array(
		'icon'  => 'decisoes',
		'title' => 'Decisões Mais Estratégicas',
		'desc'  => 'Use IA para analisar, prever e agir com mais precisão.',
	),
	array(
		'icon'  => 'seguranca',
		'title' => 'Segurança, Ética e Responsabilidade',
		'desc'  => 'Use com consciência e colha resultados sustentáveis.',
	),
	array(
		'icon'  => 'aplique',
		'title' => 'Aplique a IA no Seu Dia a Dia',
		'desc'  => 'De relatórios à análise, do planejamento ao atendimento.',
	),
	array(
		'icon'  => 'valor',
		'title' => 'Entregue Mais Valor e Se Destaque',
		'desc'  => 'Eleve sua atuação e destaque-se no mercado.',
	),
);

/**
 * Ícones inline (stroke = currentColor, herdam a cor via CSS)
 */
function beneficios_icon_svg( $key ) {
	$icons = array(
		'produtividade' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 20h18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><rect x="6" y="12" width="3" height="6" rx="0.5" fill="currentColor"/><rect x="11" y="8" width="3" height="10" rx="0.5" fill="currentColor"/><rect x="16" y="4" width="3" height="14" rx="0.5" fill="currentColor"/></svg>',
		'decisoes'      => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="4.5" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/></svg>',
		'seguranca'     => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3.5l7 2.6v5.4c0 4.6-3 8.4-7 9.5-4-1.1-7-4.9-7-9.5V6.1l7-2.6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12l2 2 4-4.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'aplique'       => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="3.5" width="14" height="17" rx="1.6" stroke="currentColor" stroke-width="1.6"/><rect x="7.5" y="6" width="9" height="3" rx="0.4" fill="currentColor"/><circle cx="8.6" cy="12.3" r="1" fill="currentColor"/><circle cx="12" cy="12.3" r="1" fill="currentColor"/><circle cx="15.4" cy="12.3" r="1" fill="currentColor"/><circle cx="8.6" cy="15.8" r="1" fill="currentColor"/><circle cx="12" cy="15.8" r="1" fill="currentColor"/><circle cx="15.4" cy="15.8" r="1" fill="currentColor"/></svg>',
		'valor'         => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.5 15.5c2.5 2.7 5.3 3.8 7.7 3.8 2 0 3.6-.5 6-1.8l3.3-1.9c.7-.4.9-1.3.4-1.9-.5-.6-1.3-.7-2-.3l-3.4 1.9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 14.2h3.4c.9 0 1.6-.7 1.6-1.6 0-.8-.6-1.5-1.4-1.6l-3.1-.5c-1.1-.2-2.2-.6-3.1-1.3L6 8.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="14" cy="6.5" r="3" stroke="currentColor" stroke-width="1.6"/><path d="M14 5.1v2.8M13 6.1h2" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>',
	);

	echo $icons[ $key ] ?? '';
}
?>

<section class="beneficios">
	<div class="beneficios__container">

		<div class="beneficios__header reveal">
			<span class="beneficios__line beneficios__line--left"></span>
			<h2 class="beneficios__title">
				O que este livro vai fazer<br>
				<span class="beneficios__highlight">por você</span>
			</h2>
			<span class="beneficios__line beneficios__line--right"></span>
		</div>

		<div class="beneficios__grid">
			<?php foreach ( $beneficios as $index => $item ) :
				$delay_class = 'reveal-delay-' . ( ( $index % 3 ) + 1 );
			?>
				<div class="beneficios__item reveal <?php echo esc_attr( $delay_class ); ?>">
					<span class="beneficios__icon">
						<?php beneficios_icon_svg( $item['icon'] ); ?>
					</span>
					<h3 class="beneficios__item-title"><?php echo esc_html( $item['title'] ); ?></h3>
					<p class="beneficios__item-desc"><?php echo esc_html( $item['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>