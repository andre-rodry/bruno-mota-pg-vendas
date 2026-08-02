/**
 * BML-HOME-BANNER — ANIMAÇÃO DE ENTRADA (JS PURO, sem GSAP)
 *
 * Revela com fade/slide os elementos marcados com a classe
 * .bml-gsap-init (que nascem com opacity:0 via CSS puro para
 * evitar o "flash" de conteúdo antes da animação).
 *
 * A transição em si é feita via CSS (transition), o JS só
 * adiciona a classe .bml-reveal em sequência, com pequenos delays.
 */
(function () {
  function boot() {
    var section = document.querySelector(".bml-home-banner");
    if (!section) return false;

    var title = section.querySelector('[data-gsap="title"]');
    var subtitle = section.querySelector('[data-gsap="subtitle"]');
    var buttons = section.querySelectorAll('[data-gsap="btn"]');
    var scroll = section.querySelector('[data-gsap="scroll"]');
    var socialLabel = section.querySelector(".bml-social-label");
    var socialIcons = section.querySelectorAll(".bml-social-icons a");

    function reveal(el, delay) {
      if (!el) return;
      setTimeout(function () {
        el.classList.add("bml-reveal");
      }, delay);
    }

    reveal(title, 0);
    reveal(subtitle, 150);

    buttons.forEach(function (btn, i) {
      reveal(btn, 300 + i * 100);
    });

    reveal(scroll, 500);
    reveal(socialLabel, 400);

    socialIcons.forEach(function (icon, i) {
      reveal(icon, 450 + i * 60);
    });

    return true;
  }

  // Fallback de segurança: se por algum motivo o JS falhar em
  // rodar a tempo, revela tudo depois de 2s sem animação, para
  // nunca deixar o conteúdo escondido.
  function fallbackReveal() {
    document.querySelectorAll(".bml-home-banner .bml-gsap-init").forEach(function (el) {
      el.classList.add("bml-reveal");
    });
  }

  function waitAndBoot() {
    boot();
    setTimeout(fallbackReveal, 2000);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", waitAndBoot);
  } else {
    waitAndBoot();
  }
})();