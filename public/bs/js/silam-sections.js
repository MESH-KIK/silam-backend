document.addEventListener('DOMContentLoaded', function () {

    // 1. Scroll Reveal Animation dengan IntersectionObserver
    const revealElements = document.querySelectorAll(
        '.about-image-wrapper, .about-content-col, .service-card-modern, .keutamaan-card-modern'
    );

    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -40px 0px'
    });

    revealElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(35px)';
        el.style.transition = `all 0.6s cubic-bezier(0.16, 1, 0.3, 1) ${(index % 3) * 0.15}s`;
        revealObserver.observe(el);
    });

    // 2. Parallax Mouse Move untuk Gambar Outlet & Floating Badges
    const outletWrapper = document.querySelector('.about-image-wrapper');
    if (outletWrapper) {
        const floatingBadges = outletWrapper.querySelectorAll('.about-floating-badge');

        outletWrapper.addEventListener('mousemove', function (e) {
            const rect = outletWrapper.getBoundingClientRect();
            const x = (e.clientX - rect.left - rect.width / 2) / 20;
            const y = (e.clientY - rect.top - rect.height / 2) / 20;

            floatingBadges.forEach((badge, idx) => {
                const depth = (idx + 1) * 1.5;
                badge.style.transform = `translate(${x * depth}px, ${y * depth}px)`;
            });
        });

        outletWrapper.addEventListener('mouseleave', function () {
            floatingBadges.forEach(badge => {
                badge.style.transform = '';
            });
        });
    }

    // 3. Efek 3D Dynamic Tilt pada Kartu Layanan
    const serviceCards = document.querySelectorAll('.service-card-modern');
    serviceCards.forEach(card => {
        card.addEventListener('mousemove', function (e) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;

            const rotateX = -(y / rect.height) * 8;
            const rotateY = (x / rect.width) * 8;

            card.style.transform = `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-10px)`;
        });

        card.addEventListener('mouseleave', function () {
            card.style.transform = '';
        });
    });
});
