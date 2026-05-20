document.addEventListener('DOMContentLoaded', function() {
    // Menu mobile toggle
    var menuToggle = document.querySelector('.menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            document.body.classList.toggle('nav-mobile-open');
        });
    }

    // Hero carousel
    var heroContainer = document.querySelector('.hero-ecommerce') || document.querySelector('.hero');
    if (heroContainer) {
        var slides = heroContainer.querySelectorAll('.hero-slide');
        var dots = heroContainer.querySelectorAll('.hero-dot');

        if (slides.length > 1) {
            var current = 0;
            var interval;

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

            dots.forEach(function(dot, i) {
                dot.addEventListener('click', function() {
                    clearInterval(interval);
                    goToSlide(i);
                    startAutoplay();
                });
            });

            startAutoplay();
        }
    }

    // Auto-dismiss alerts
    var alerts = document.querySelectorAll('.alert');
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
