document.addEventListener('DOMContentLoaded', function () {

    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    /*
    $(function () { // Mascara de Preço
        $("#inputValor").maskMoney({
            prefix: '',
            allowNegative: true,
            thousands: '.',
            decimal: ',',
            affixesStay: false
        });
    })
  */
})
///////////////////// Faz com que os efeitos de animação so ocorram quando o elemento estiver a tela
document.addEventListener('DOMContentLoaded', () => {
    const elements = document.querySelectorAll('.animate__animated');

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const animationClass = entry.target.dataset.animation;
                entry.target.classList.add(animationClass);
                observer.unobserve(entry.target); // Remove observer after animation
            }
        });
    }, {
        threshold: 0.05 // Adjust threshold as needed
    });

    elements.forEach(element => {
        observer.observe(element);
    });
});