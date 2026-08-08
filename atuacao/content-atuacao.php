<?php
/**
 * Template Part: Áreas de Atuação
 * Uso: get_template_part( 'atuacao/content-atuacao' );
 */

if ( ! function_exists( 'bm_atuacao_icon' ) ) {
    /**
     * Retorna o SVG (monoline, cor herdada via currentColor) de cada ícone
     * usado nos cards.
     */
    function bm_atuacao_icon( $type ) {
        $icons = array(
            'chart' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M4 20V13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M9.5 20V9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M15 20V11.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M20.5 20V5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M4 9.5 9.5 5l5.5 3.5L20.5 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>',
            'mic' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <rect x="9" y="2.5" width="6" height="12" rx="3" stroke="currentColor" stroke-width="1.6"/>
                <path d="M5.5 11a6.5 6.5 0 0 0 13 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M12 17.5v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M8.5 21.5h7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>',
            'cap' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M12 3 2 8l10 5 10-5-10-5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                <path d="M6.5 10.5V16c0 1.5 2.7 3 5.5 3s5.5-1.5 5.5-3v-5.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21.5 8.5v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>',
            'people' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="8.5" cy="7.5" r="3" stroke="currentColor" stroke-width="1.6"/>
                <circle cx="17" cy="9" r="2.4" stroke="currentColor" stroke-width="1.6"/>
                <path d="M2.5 20.5c0-3.3 2.7-6 6-6s6 2.7 6 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M15 14.6c2.9.3 5.5 2.6 5.5 5.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>',
        );

        return isset( $icons[ $type ] ) ? $icons[ $type ] : '';
    }
}
?>

<section class="atuacao-hero">
  <div class="atuacao-hero__media">
    <picture>
      <!-- Tablet e celular (até 960px) → imagem centralizada -->
      <source
        media="(max-width: 960px)"
        srcset="https://i.ibb.co/7JdHR8t6/1b6fd3c0-a541-4c4b-94f2-308a0572da14.png"
      >
      <!-- Notebook/desktop (padrão) -->
      <img
        src="https://i.ibb.co/jPtVVVSb/eb8889bc-eba2-4ede-9c09-2be04cb9c7f9.png"
        alt="Bruno Mota, economista"
        class="atuacao-hero__photo reveal"
        loading="eager"
      >
    </picture>
  </div>

  <div class="atuacao-container atuacao-hero__container">
    <div class="atuacao-hero__text reveal">
      <h1 class="atuacao-hero__title">
        Áreas de<br>
        <span class="is-gold">Atuação</span>
      </h1>
      <span class="atuacao-hero__underline"></span>

      <p class="atuacao-hero__lead">
        Conhecimento aplicado para transformar pessoas, empresas e o Brasil.
      </p>

      <p class="atuacao-hero__desc">
        Atuo em diferentes frentes que se complementam: consultoria, palestras,
        educação financeira e projetos de impacto social. Sempre com o propósito
        de tornar a economia compreensível, acessível e transformadora.
      </p>
    </div>
  </div>
</section>

<section class="atuacao-cards">
  <div class="atuacao-container atuacao-cards__grid">

    <?php
    $atuacao_cards = array(
      array(
        'icon'     => 'chart',
        'title'    => 'Consultoria e Mentoria',
        'subtitle' => 'Estratégia financeira com propósito.',
        'desc'     => 'Consultoria para empresas, empreendedores e pessoas físicas com foco em planejamento financeiro, gestão de riscos, investimentos, organização das finanças e tomada de decisões.',
        'image'    => 'https://images.unsplash.com/photo-1707157284454-553ef0a4ed0d?q=80&w=1200&auto=format&fit=crop',
        'items'    => array(
          'Planejamento financeiro pessoal e familiar',
          'Gestão de dívidas e reestruturação financeira',
          'Planejamento financeiro empresarial',
          'Investimentos e alocação de recursos',
          'Análise econômica e estratégias de negócios',
        ),
      ),
      array(
        'icon'     => 'mic',
        'title'    => 'Palestras e Workshops',
        'subtitle' => 'Conteúdo que inspira e transforma.',
        'desc'     => 'Palestras e workshops dinâmicos e práticos para empresas, instituições de ensino, eventos corporativos e organizações que desejam levar conhecimento econômico de qualidade ao seu público.',
        'image'    => 'https://images.unsplash.com/photo-1769755449087-464156398537?q=80&w=1200&auto=format&fit=crop',
        'items'    => array(
          'Economia e conjuntura',
          'Educação financeira e investimentos',
          'Gestão de dívidas e consumo consciente',
          'Desenvolvimento econômico e regional',
          'Finanças comportamentais',
        ),
      ),
      array(
        'icon'     => 'cap',
        'title'    => 'Educação Financeira',
        'subtitle' => 'Educar hoje para transformar o amanhã.',
        'desc'     => 'Criador do canal "Finanças para Jovens Oficial", dedicado a levar educação financeira de forma simples e acessível para jovens, famílias e toda a sociedade.',
        'image'    => 'https://images.unsplash.com/photo-1761546571631-a4d61b55cd2f?q=80&w=1200&auto=format&fit=crop',
        'items'    => array(
          'Conteúdo para jovens e adolescentes',
          'Educação financeira nas escolas',
          'Consumo consciente e controle de dívidas',
          'Investimentos e planejamento de vida',
          'Cursos, e-books e materiais educativos',
        ),
      ),
      array(
        'icon'     => 'people',
        'title'    => 'Projetos e Impacto Social',
        'subtitle' => 'Economia a serviço das pessoas.',
        'desc'     => 'Desenvolvimento de projetos e iniciativas que promovem inclusão financeira, cidadania e desenvolvimento socioeconômico.',
        'image'    => 'https://images.unsplash.com/photo-1651372381086-9861c9c81db5?q=80&w=1200&auto=format&fit=crop',
        'items'    => array(
          'Idealizador da Lei nº 9.838/2025 – que instituiu a Semana de Educação Financeira nas escolas municipais de Salvador',
          'Projetos de inclusão e educação financeira para comunidades',
          'Parcerias com instituições públicas e privadas',
          'Pesquisa e estudos sobre desenvolvimento regional e políticas públicas',
        ),
      ),
    );

    // Delays em cascata: 1º card sem delay, 2º/3º/4º com delay crescente,
    // repetindo o ciclo (1,2,3) a cada 3 cards.
    $delay_classes = array( '', 'reveal-delay-1', 'reveal-delay-2', 'reveal-delay-3' );

    foreach ( $atuacao_cards as $index => $card ) :
      $delay_class = $delay_classes[ ( $index % 3 ) + 1 ];
    ?>
      <article class="atuacao-card reveal <?php echo esc_attr( $delay_class ); ?>">
        <div class="atuacao-card__bg" style="background-image:url('<?php echo esc_url( $card['image'] ); ?>');"></div>

        <div class="atuacao-card__content">
          <div class="atuacao-card__head">
            <span class="atuacao-card__icon" aria-hidden="true"><?php echo bm_atuacao_icon( $card['icon'] ); ?></span>
            <div class="atuacao-card__head-text">
              <h3 class="atuacao-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
              <p class="atuacao-card__subtitle"><?php echo esc_html( $card['subtitle'] ); ?></p>
            </div>
          </div>

          <p class="atuacao-card__desc"><?php echo esc_html( $card['desc'] ); ?></p>

          <span class="atuacao-card__divider"></span>

          <ul class="atuacao-card__list">
            <?php foreach ( $card['items'] as $item ) : ?>
              <li>
                <span class="atuacao-check" aria-hidden="true">✓</span>
                <span><?php echo esc_html( $item ); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </article>
    <?php endforeach; ?>

  </div>
</section>