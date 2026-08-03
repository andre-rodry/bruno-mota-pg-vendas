/* ===== SEÇÃO: PARTICIPAÇÕES NA MÍDIA — JS (loop infinito SEM clonar) ===== */
/* Técnica: em vez de duplicar os cards no DOM, movemos os elementos REAIS
   de posição (primeiro -> último, ou último -> primeiro) depois de cada
   transição. O track sempre "descansa" em translateX(0), então o reset
   de posição fica invisível pro usuário. */

(function () {
  function initMidiaCarousel(root) {
    var viewport = root.querySelector('.bml-midia-track-viewport');
    var track = root.querySelector('.bml-midia-track');
    var prevBtn = root.querySelector('.bml-midia-seta-prev');
    var nextBtn = root.querySelector('.bml-midia-seta-next');

    if (!track) return;

    var isAnimating = false;

    function getCards() {
      return Array.prototype.slice.call(track.children);
    }

    function getStep() {
      var cards = getCards();
      if (!cards.length) return 0;
      var cardRect = cards[0].getBoundingClientRect();
      var gap = parseFloat(getComputedStyle(track).gap) || 20;
      return cardRect.width + gap;
    }

    function setTransform(px, withTransition) {
      track.style.transition = withTransition ? '' : 'none';
      track.style.transform = 'translateX(' + px + 'px)';
      if (!withTransition) {
        track.getBoundingClientRect();
        track.style.transition = '';
      }
    }

    function goNext() {
      if (isAnimating) return;
      var step = getStep();
      if (!step) return;
      isAnimating = true;

      setTransform(-step, true);

      var onEnd = function (e) {
        if (e.propertyName !== 'transform') return;
        track.removeEventListener('transitionend', onEnd);

        var first = track.firstElementChild;
        track.appendChild(first);

        setTransform(0, false);
        isAnimating = false;
      };
      track.addEventListener('transitionend', onEnd);
    }

    function goPrev() {
      if (isAnimating) return;
      var step = getStep();
      if (!step) return;
      isAnimating = true;

      var last = track.lastElementChild;
      track.insertBefore(last, track.firstElementChild);
      setTransform(-step, false);

      requestAnimationFrame(function () {
        setTransform(0, true);
      });

      var onEnd = function (e) {
        if (e.propertyName !== 'transform') return;
        track.removeEventListener('transitionend', onEnd);
        isAnimating = false;
      };
      track.addEventListener('transitionend', onEnd);
    }

    // ===== Autoplay =====
    var AUTOPLAY_DELAY = 4000;
    var autoplayTimer = null;

    function startAutoplay() {
      stopAutoplay();
      autoplayTimer = setInterval(goNext, AUTOPLAY_DELAY);
    }

    function stopAutoplay() {
      if (autoplayTimer) {
        clearInterval(autoplayTimer);
        autoplayTimer = null;
      }
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', function () {
        goPrev();
        startAutoplay();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function () {
        goNext();
        startAutoplay();
      });
    }

    root.addEventListener('mouseenter', stopAutoplay);
    root.addEventListener('mouseleave', startAutoplay);

    // Swipe touch (mobile)
    var startX = 0;
    var isDragging = false;

    if (viewport) {
      viewport.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
        isDragging = true;
        stopAutoplay();
      }, { passive: true });

      viewport.addEventListener('touchend', function (e) {
        if (!isDragging) return;
        isDragging = false;
        var endX = e.changedTouches[0].clientX;
        var diff = startX - endX;

        if (Math.abs(diff) > 40) {
          if (diff > 0) {
            goNext();
          } else {
            goPrev();
          }
        }
        startAutoplay();
      });
    }

    window.addEventListener('resize', function () {
      if (!isAnimating) setTransform(0, false);
    });

    setTransform(0, false);
    startAutoplay();
  }

  function init() {
    var carousels = document.querySelectorAll('.bml-midia-carousel-wrapper');
    carousels.forEach(function (el) {
      initMidiaCarousel(el);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();