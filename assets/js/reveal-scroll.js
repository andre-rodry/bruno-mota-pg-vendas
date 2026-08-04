document.addEventListener('DOMContentLoaded', function () {
    const elements = document.querySelectorAll('.reveal');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
            // Se quiser que a animação repita toda vez que rolar, use:
            // else { entry.target.classList.remove('active'); }
        });
    }, {
        threshold: 0.15 // ativa quando 15% do elemento aparece na tela
    });

    elements.forEach(el => observer.observe(el));
});