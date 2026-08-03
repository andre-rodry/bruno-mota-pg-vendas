<?php
/**
 * Template part: Publicações e Artigos
 * Seção com Livros, Artigos (via REST API do WordPress) e Entrevistas e Colunas (carrossel).
 */
?>

<section class="publications-section">
  <div class="publications-section__inner">

    <p class="publications-section__title">Publicações e Artigos</p>

    <div class="publications-cols">

      <!-- LIVROS -->
      <div>
        <div class="publications-col-head">
          <h3>Livros</h3>
          <a class="publications-ver-todos" href="https://economistabrunomota.com.br/ebooks/" target="_blank" rel="noopener">Ver todos</a>
        </div>
        <div class="publications-livros-grid" id="publications-livros-grid">
          <!-- Conteúdo fixo: a página /ebooks/ não usa a REST API do WordPress,
               é montada manualmente no Elementor, sem post type próprio.
               Os dados abaixo foram tirados direto do conteúdo real da página. -->
          <a class="publications-livro-card" href="https://suasfinancasnoazul.com.br/" target="_blank" rel="noopener">
            <img src="https://economistabrunomota.com.br/wp-content/uploads/2025/02/Ebooks-Suas-Financas-no-Azul-1024x1024.webp" alt="Suas Finanças no Azul">
          </a>
          <a class="publications-livro-card" href="https://drive.google.com/file/d/1Z3saHfUhChx-OmAA-pJh1lkVzuuR1JJN/view?usp=drive_link" target="_blank" rel="noopener">
            <img src="https://economistabrunomota.com.br/wp-content/uploads/2025/02/saia-das-dividas-1024x1024.webp" alt="Saia das Dívidas">
          </a>
          <a class="publications-livro-card" href="https://bnb.gov.br/s482-dspace/bitstream/123456789/800/1/2011_LIV_AEMB.pdf" target="_blank" rel="noopener">
            <img src="https://economistabrunomota.com.br/wp-content/uploads/2025/02/Analise-da-Evolucao-do-Microcredito-na-Bahia-1024x1024.webp" alt="Análise da Evolução do Microcrédito na Bahia">
          </a>
        </div>
      </div>

      <!-- ARTIGOS -->
      <div>
        <div class="publications-col-head">
          <h3>Artigos</h3>
          <a class="publications-ver-todos" href="https://economistabrunomota.com.br/blog/" target="_blank" rel="noopener">Ver todos</a>
        </div>
        <div id="publications-artigos-list">
          <p class="publications-status">Carregando artigos...</p>
        </div>
      </div>

      <!-- ENTREVISTAS E COLUNAS -->
      <div>
        <div class="publications-col-head">
          <h3>Entrevistas e Colunas</h3>
          <a class="publications-ver-todos" href="#" id="publications-entrevistas-ver-todas">Ver todas</a>
        </div>
        <div class="publications-entrevistas-carousel">
          <div class="publications-entrevistas-track" id="publications-entrevistas-track"></div>
        </div>
        <div class="publications-entrevistas-dots" id="publications-entrevistas-dots"></div>
      </div>

    </div>
  </div>
</section>