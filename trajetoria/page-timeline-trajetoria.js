/* ==========================================================================
   PAGE — TIMELINE TRAJETORIA (somente a seção pinada de trajetória)
   Reproduz o efeito de "scroll storytelling" pinado usando position:sticky
   + rAF scroll tracking, sem GSAP, ScrollTrigger ou Lenis.

   Em telas estreitas (tablet/celular) OU em qualquer janela com pouca
   altura (mesmo em desktop), o modo pinado é desligado e os 5 marcos
   passam a ser exibidos empilhados, em fluxo normal — sem scroll-jacking,
   sem altura extra reservada e com melhor performance/responsividade.

   CORREÇÃO: o breakpoint que desliga o pin agora combina LARGURA e ALTURA
   (max-width: 1024px OU max-height: 700px), e é o MESMO usado no CSS.
   Antes só a largura era considerada, então uma janela desktop baixa
   (ex.: notebook com pouco espaço vertical, split-screen) continuava no
   modo pinado, reservando altura extra de scroll e deixando o ponto
   "ativo" da timeline sem relação com o que estava visível na tela.
   Efeito pinado agora é exclusivo de desktop com altura suficiente.
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
    const IMG = {
      podium:   'https://images.unsplash.com/photo-1762968274962-20c12e6e8ecd?auto=format&fit=crop&w=1400&q=80',
      meeting:  'https://images.pexels.com/photos/3183183/pexels-photo-3183183.jpeg?auto=compress&cs=tinysrgb&w=1400',
      table:    'https://images.pexels.com/photos/7993894/pexels-photo-7993894.jpeg?auto=compress&cs=tinysrgb&w=1400'
    };

    const STORY = [
      { year:'2025', tag:'Lei Municipal', img:IMG.podium, eyebrow:'Destaque · Legislação',
        title:'Lei Municipal 9838/2025', sub:'Educação financeira nas escolas municipais de Salvador.',
        desc:'Projeto de lei que instituiu a educação financeira na rede municipal de ensino, fortalecendo a base do conhecimento econômico desde cedo.',
        cards:[['Impacto','+45 mil alunos'],['Categoria','Legislação'],['Ano','2025'],['Local','Salvador, BA']] },
      { year:'2025', tag:'Mesa Internacional', img:IMG.meeting, eyebrow:'Destaque · Palestra',
        title:'Mesa Internacional na Argentina', sub:'Debate sobre gestão econômica e impacto social.',
        desc:'Convite para integrar o painel internacional em Buenos Aires, discutindo modelos de desenvolvimento e competitividade regional.',
        cards:[['Impacto','3 países'],['Categoria','Palestra'],['Ano','2025'],['Local','Buenos Aires']] },
      { year:'2025', tag:'Palestra na UNEB', img:IMG.table, eyebrow:'Destaque · Academia',
        title:'Palestra Magna na UNEB', sub:'Os desafios da economia brasileira ao futuro.',
        desc:'Aula magna sobre desenvolvimento regional e humano, marcando abertura do ano acadêmico na Universidade.',
        cards:[['Impacto','800 presentes'],['Categoria','Palestra'],['Ano','2025'],['Local','Salvador, BA']] },
      { year:'2025', tag:'Artigo Científico', img:IMG.podium, eyebrow:'Destaque · Publicação',
        title:'Artigo aprovado no XII SIER', sub:'Novos índices fiscais e planejamento estratégico.',
        desc:'Publicação científica sobre indicadores fiscais e sua correlação com o desenvolvimento social em municípios de médio porte.',
        cards:[['Impacto','Citado 30x'],['Categoria','Artigo'],['Ano','2025'],['Local','UNICSAL']] },
      { year:'2024', tag:'Reconhecimento', img:IMG.table, eyebrow:'Destaque · Premiação',
        title:'Reconhecimento CORECON-BA', sub:'Homenagem pela contribuição à economia.',
        desc:'Honraria concedida pelo Conselho Regional de Economia da Bahia em reconhecimento à contribuição contínua ao setor.',
        cards:[['Impacto','Honraria estadual'],['Categoria','Premiação'],['Ano','2024'],['Local','Salvador, BA']] }
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
        '<div class="stage-visual"><img src="'+s.img+'" alt="'+s.title+'"></div>'+
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
       CORRIGIDO: o pin agora é desligado por LARGURA (tablet/celular) E
       por ALTURA (qualquer janela curta, inclusive desktop). Isso evita
       reservar altura extra de scroll em telas sem espaço vertical
       suficiente para o efeito, e melhora performance/responsividade
       em tablet e celular, onde o efeito é sempre desligado. A mesma
       condição é usada no CSS (ver page-timeline-trajetoria.css) para
       que não haja dessincronia entre o estado visual e o JS. */
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