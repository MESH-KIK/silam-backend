
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.testi-card-box');

    cards.forEach(card => {
        // Efek Interaktif 3D Tilt saat kursor berada di atas kartu
        card.addEventListener('mousemove', function (e) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;

            const rotateX = -(y / rect.height) * 16;
            const rotateY = (x / rect.width) * 16;

            card.style.transform = `perspective(800px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-14px) scale(1.05)`;
        });

        // Saat mouse keluar dari kartu, kembalikan ke animasi rotasi bawaannya
        card.addEventListener('mouseleave', function () {
            card.style.transform = '';
        });
    });
});
