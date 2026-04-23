import './bootstrap';

const revealElements = document.querySelectorAll('.reveal');

if (revealElements.length) {
    const revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.14,
            rootMargin: '0px 0px -8% 0px',
        },
    );

    revealElements.forEach((element, index) => {
        element.style.transitionDelay = `${Math.min(index * 70, 280)}ms`;
        revealObserver.observe(element);
    });
}
