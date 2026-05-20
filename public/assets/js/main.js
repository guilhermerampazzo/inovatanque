document.addEventListener('DOMContentLoaded', function() {
    // Menu mobile toggle
    const menuToggle = document.querySelector('.menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            document.body.classList.toggle('nav-mobile-open');
        });
    }

    // Hero carousel com texto por slide
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');
    if (slides.length > 1) {
        let current = 0;
        let interval;

        function goToSlide(index) {
            slides[current].classList.remove('active');
            if (dots[current]) dots[current].classList.remove('active');
            current = index;
            slides[current].classList.add('active');
            if (dots[current]) dots[current].classList.add('active');
        }

        function nextSlide() {
            goToSlide((current + 1) % slides.length);
        }

        function startAutoplay() {
            interval = setInterval(nextSlide, 5000);
        }

        // Indicadores clicáveis
        dots.forEach(function(dot, i) {
            dot.addEventListener('click', function() {
                clearInterval(interval);
                goToSlide(i);
                startAutoplay();
            });
        });

        startAutoplay();
    }

    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.3s';
            setTimeout(function() { alert.remove(); }, 300);
        }, 4000);
    });

    // Gallery - product page
    window.changeImage = function(thumb, src) {
        var mainImg = document.getElementById('mainImg');
        if (mainImg) {
            mainImg.src = src;
            document.querySelectorAll('.thumbnails img').forEach(function(t) {
                t.classList.remove('active');
            });
            thumb.classList.add('active');
        }
    };
});
