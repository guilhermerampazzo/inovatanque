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

    // Testimonials carousel
    var depCarousel = document.getElementById('testimonialsCarousel');
    if (depCarousel) {
        var depSlides = depCarousel.querySelectorAll('.testimonial-card');
        var depDots = document.querySelectorAll('.testimonials-dot');
        var depCurrent = 0;
        var depInterval;

        function goToDep(index) {
            depSlides[depCurrent].classList.remove('active');
            if (depDots[depCurrent]) depDots[depCurrent].classList.remove('active');
            depCurrent = (index + depSlides.length) % depSlides.length;
            depSlides[depCurrent].classList.add('active');
            if (depDots[depCurrent]) depDots[depCurrent].classList.add('active');
        }

        function startDepAutoplay() {
            depInterval = setInterval(function() { goToDep(depCurrent + 1); }, 5000);
        }

        depDots.forEach(function(dot, i) {
            dot.addEventListener('click', function() {
                clearInterval(depInterval);
                goToDep(i);
                startDepAutoplay();
            });
        });

        var prevBtn = document.getElementById('depPrev');
        var nextBtn = document.getElementById('depNext');
        if (prevBtn) prevBtn.addEventListener('click', function() { clearInterval(depInterval); goToDep(depCurrent - 1); startDepAutoplay(); });
        if (nextBtn) nextBtn.addEventListener('click', function() { clearInterval(depInterval); goToDep(depCurrent + 1); startDepAutoplay(); });

        if (depSlides.length > 1) startDepAutoplay();
    }

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
