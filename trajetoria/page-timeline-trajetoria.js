/* ==========================================================================
   PAGE — TIMELINE TRAJETORIA (somente a seção pinada de trajetória)
   Reproduz o efeito de "scroll storytelling" pinado usando position:sticky
   + rAF scroll tracking, sem GSAP, ScrollTrigger ou Lenis.

   Em telas estreitas (tablet/celular) OU em qualquer janela com pouca
   altura (mesmo em desktop), o modo pinado é desligado e os 5 marcos
   passam a ser exibidos empilhados, em fluxo normal — sem scroll-jacking,
   sem altura extra reservada e com melhor performance/responsividade.

   Imagens: vêm 100% do PHP via data-img-desktop / data-img-mobile
   (definidos em content-timeline-trajetoria.php usando
   get_template_directory_uri()). O JS não define mais nenhum caminho de
   arquivo — apenas monta um <picture> com <source media> para o browser
   escolher a imagem certa (mesmo breakpoint de 1024px usado no
   modo pinado x empilhado, para tudo ficar sincronizado).
   ========================================================================== */
(function(){
  'use strict';

  document.addEventListener('DOMContentLoaded', init);

  function init(){
    const root = document.querySelector('.tlc');
    if(!root) return;

    /* ================= HEADER HEIGHT SYNC ================= */
    function findHeader(){
      const candidates = [
        'header.site-header', 'header#header', '.site-header',
        '#masthead', 'header.header', '.header-main',
        'header[class*="header"]', 'header'
      ];
      for(const sel of candidates){
        const el = document.querySelector(sel);
        if(el){
          const pos = getComputedStyle(el).position;
          if(pos === 'fixed' || pos === 'sticky'){
            return el;
          }
        }
      }
      return document.querySelector('header');
    }

    const headerEl = findHeader();

    function syncHeaderHeight(){
      const headerBottom = headerEl ? headerEl.getBoundingClientRect().bottom : 0;
      const adminBar = document.getElementById('wpadminbar');
      const adminBarBottom = adminBar ? adminBar.getBoundingClientRect().bottom : 0;
      const h = Math.max(headerBottom, adminBarBottom, 0);
      if(h > 0){
        document.documentElement.style.setProperty('--header-h', h + 'px');
      }
    }

    syncHeaderHeight();
    window.addEventListener('resize', syncHeaderHeight);
    window.addEventListener('load', syncHeaderHeight);
    window.addEventListener('scroll', syncHeaderHeight, {passive:true});
    setTimeout(syncHeaderHeight, 300);
    setTimeout(syncHeaderHeight, 1000);

    /* ================= DATA ================= */
    // Imagens 100% via PHP (data-img-desktop / data-img-mobile no <div class="tlc">).
    const imgDesktop = root.dataset.imgDesktop || '';
    const imgMobile  = root.dataset.imgMobile  || '';

    /* -----------------------------------------------------------------------
       STORY — conteúdo de cada marco da timeline.
       Revisado com base no Currículo Lattes (atualizado em 20/06/2026) e no
       e-mail do Bruno de 22/07/2026. Itens sinalizados como "a confirmar"
       têm o fato confirmado por alguma fonte, mas a data exata ainda não.
       "Palestra na UNEB" foi removida por falta de qualquer fonte (nem
       Lattes, nem e-mail) e substituída por "Mídia Nacional" (Jornal da
       Band), que está confirmada no e-mail.
       ----------------------------------------------------------------------- */
    const STORY = [
      { year:'2025', tag:'Lei Municipal', eyebrow:'Destaque · Legislação',
        title:'Lei Municipal nº 9.838/2025', sub:'Educação financeira nas escolas municipais de Salvador.',
        desc:'Projeto que deu origem à lei que institui a educação financeira na rede municipal de ensino de Salvador.',
        cards:[['Impacto','Rede municipal de Salvador'],['Categoria','Legislação'],['Ano','2025'],['Local','Salvador, BA']] },
      { year:'2025', tag:'Mesa Internacional', eyebrow:'Destaque · Palestra',
        title:'Mesa Internacional na Argentina', sub:'Desenvolvimento Econômico na América Latina.',
        desc:'Convite para integrar mesa internacional na Argentina, discutindo desenvolvimento econômico e cooperação regional latino-americana.',
        cards:[['Impacto','Reconhecimento internacional'],['Categoria','Palestra'],['Ano','2025*'],['Local','Argentina']] },
      { year:'2025', tag:'Artigo Científico', eyebrow:'Destaque · Publicação',
        title:'Artigo aprovado no XII SIDR', sub:'Crise econômica e cidades médias baianas.',
        desc:'Publicação nos Anais do XII Seminário Internacional de Desenvolvimento Regional (UNISC), analisando o impacto da crise econômica sobre cidades médias baianas, com dados de PIB e migração via REGIC.',
        cards:[['Impacto','Anais UNISC 2025'],['Categoria','Artigo'],['Ano','2025'],['Local','Santa Cruz do Sul, RS']] },
      { year:'2025', tag:'Mídia Nacional', eyebrow:'Destaque · Mídia',
        title:'Participação no Jornal da Band', sub:'Alcance nacional de mais de 100 mil pessoas.',
        desc:'Entrevista exibida no Jornal da Band, levando análises sobre economia e desenvolvimento regional a um público nacional.',
        cards:[['Impacto','+100 mil espectadores'],['Categoria','Mídia'],['Ano','2025*'],['Local','Nacional']] },
      { year:'2026', tag:'Reconhecimento', eyebrow:'Destaque · Atuação Institucional',
        title:'Conselheiro do Corecon-BA', sub:'Mandato no Conselho Regional de Economia da Bahia.',
        desc:'Eleito conselheiro do Conselho Regional de Economia da Bahia (Corecon-BA) para o mandato de 2026.',
        cards:[['Impacto','Mandato institucional'],['Categoria','Conselho Profissional'],['Ano','2026'],['Local','Salvador, BA']] }
    ];

    /* ================= ICONS ================= */
    const icoCheck = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5"/></svg>';
    const icoArr   = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>';

    /* ================= STORY BUILD ================= */
    const stageBody   = root.querySelector('#tlcStageBody');
    const tlPoints    = root.querySelector('#tlcPoints');
    const storySection= root.querySelector('#tlcStory');
    const progressBar = root.querySelector('#tlcProgress');

    if(!stageBody || !tlPoints || !storySection || !progressBar){
      console.warn('[tlc] Elemento(s) essencial(is) não encontrado(s) no DOM — verifique se o PHP corresponde a este JS.');
      return;
    }

    const itemEls = [], dotEls = [];

    STORY.forEach(function(s, i){
      const item = document.createElement('div');
      item.className = 'story-item' + (i===0 ? ' active' : '');
      item.innerHTML =
        '<div class="stage-visual">'+
          '<picture>'+
            '<source media="(max-width: 1024px)" srcset="'+imgMobile+'">'+
            '<img src="'+imgDesktop+'" alt="'+s.title+'" loading="lazy">'+
          '</picture>'+
        '</div>'+
        '<div class="stage-text">'+
          '<span class="eyebrow">'+s.eyebrow+'</span>'+
          '<h2>'+s.title+'</h2>'+
          '<div class="sub">'+s.sub+'</div>'+
          '<p class="desc">'+s.desc+'</p>'+
          '<div class="mini-cards">'+ s.cards.map(function(c){ return '<div class="mini-card"><div class="k">'+icoCheck+' '+c[0]+'</div><div class="v">'+c[1]+'</div></div>'; }).join('') +'</div>'+
          '<button class="btn-premium"><span>Ver detalhes do projeto</span> '+icoArr+'</button>'+
        '</div>';
      stageBody.appendChild(item);
      itemEls.push(item);

      const pt = document.createElement('div');
      pt.className = 'tl-point' + (i===0 ? ' active' : '');
      pt.innerHTML = '<div class="tl-dot"></div><div class="tl-year">'+s.year+'</div><div class="tl-name">'+s.tag+'</div>';
      tlPoints.appendChild(pt);
      dotEls.push(pt);
    });

    let currentIdx = 0;
    function goToSlide(idx){
      if(idx === currentIdx && itemEls[idx].classList.contains('active')) return;
      currentIdx = idx;
      itemEls.forEach(function(el,i){ el.classList.toggle('active', i===idx); });
      dotEls.forEach(function(pt,i){ pt.classList.toggle('active', i===idx); pt.classList.toggle('done', i<idx); });
    }

    /* ================= MODO PINADO x MODO EMPILHADO =================
       O pin é desligado por LARGURA (tablet/celular) E por ALTURA
       (qualquer janela curta, inclusive desktop). A mesma condição é
       usada no CSS (page-timeline-trajetoria.css) para não haver
       dessincronia entre o estado visual e o JS. */
    const disablePinMQ = window.matchMedia('(max-width: 1024px), (max-height: 700px)');

    function isPinDisabled(){
      return disablePinMQ.matches;
    }

    function applyPinMode(){
      const disabled = isPinDisabled();
      stageBody.classList.toggle('pin-disabled', disabled);
      storySection.classList.toggle('pin-disabled', disabled);

      if(disabled){
        // Fluxo normal: sem altura extra reservada para scroll-jacking.
        storySection.style.height = 'auto';
        progressBar.style.width = '0%';
      } else {
        storySection.style.height = (STORY.length * 100) + 'vh';
      }
    }

    applyPinMode();
    if(disablePinMQ.addEventListener){
      disablePinMQ.addEventListener('change', applyPinMode);
    } else if(disablePinMQ.addListener){
      // Fallback para navegadores antigos.
      disablePinMQ.addListener(applyPinMode);
    }

    let ticking = false;
    function handleScroll(){
      if(isPinDisabled()) return; // modo empilhado: todos os marcos já ficam visíveis via CSS
      if(!ticking){
        ticking = true;
        requestAnimationFrame(function(){
          const rect = storySection.getBoundingClientRect();
          const scrollable = storySection.offsetHeight - window.innerHeight;
          const scrolled = -rect.top;
          const progress = Math.min(1, Math.max(0, scrollable > 0 ? scrolled/scrollable : 0));
          const idx = Math.min(STORY.length-1, Math.round(progress * (STORY.length-1)));
          goToSlide(idx);
          progressBar.style.width = (progress*100) + '%';
          ticking = false;
        });
      }
    }
    window.addEventListener('scroll', handleScroll, {passive:true});
    window.addEventListener('resize', applyPinMode);
    handleScroll();
  }
})();