document.addEventListener('DOMContentLoaded', function() {
    // Menu mobile toggle
    var menuToggle = document.querySelector('.menu-toggle');
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            document.body.classList.toggle('nav-mobile-open');
        });
    }

    // Search overlay
    var searchToggle = document.querySelector('.search-toggle');
    var searchOverlay = document.getElementById('searchOverlay');
    var searchClose = document.getElementById('searchClose');
    if (searchToggle && searchOverlay) {
        searchToggle.addEventListener('click', function() {
            searchOverlay.classList.add('open');
            var inp = searchOverlay.querySelector('input');
            if (inp) setTimeout(function() { inp.focus(); }, 50);
        });
        if (searchClose) {
            searchClose.addEventListener('click', function() {
                searchOverlay.classList.remove('open');
            });
        }
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === searchOverlay) searchOverlay.classList.remove('open');
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') searchOverlay.classList.remove('open');
        });
    }

    // Hero carousel with per-slide duration
    var heroContainer = document.querySelector('.hero-ecommerce') || document.querySelector('.hero');
    if (heroContainer) {
        var slides = heroContainer.querySelectorAll('.hero-slide');
        var dots = heroContainer.querySelectorAll('.hero-dot');

        if (slides.length > 1) {
            var current = 0;
            var interval;
            var progressBar = null;
            var progressAnim = null;

            // Create progress bar
            progressBar = document.createElement('div');
            progressBar.className = 'hero-progress-bar';
            heroContainer.appendChild(progressBar);

            function getSlideDuration(index) {
                var dur = parseInt(slides[index].getAttribute('data-duration'));
                return isNaN(dur) ? 5000 : dur;
            }

            function startProgress(duration) {
                if (!progressBar) return;
                progressBar.style.transition = 'none';
                progressBar.style.width = '0%';
                // force reflow
                progressBar.offsetWidth;
                progressBar.style.transition = 'width ' + duration + 'ms linear';
                progressBar.style.width = '100%';
            }

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
                clearInterval(interval);
                var dur = getSlideDuration(current);
                startProgress(dur);
                interval = setInterval(function() {
                    nextSlide();
                    dur = getSlideDuration(current);
                    startProgress(dur);
                    clearInterval(interval);
                    interval = setInterval(arguments.callee, dur);
                }, dur);
            }

            dots.forEach(function(dot, i) {
                dot.addEventListener('click', function() {
                    clearInterval(interval);
                    goToSlide(i);
                    startAutoplay();
                });
            });

            var prevBtn = heroContainer.querySelector('.hero-prev');
            var nextBtn = heroContainer.querySelector('.hero-next');
            if (prevBtn) prevBtn.addEventListener('click', function() {
                clearInterval(interval);
                goToSlide((current - 1 + slides.length) % slides.length);
                startAutoplay();
            });
            if (nextBtn) nextBtn.addEventListener('click', function() {
                clearInterval(interval);
                goToSlide((current + 1) % slides.length);
                startAutoplay();
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

// Catalogo filter toggle (global for onclick)
function toggleCatalogoFilter() {
    var sidebar = document.getElementById('filterSidebar');
    var overlay = document.getElementById('filterOverlay');
    if (sidebar) sidebar.classList.toggle('open');
    if (overlay) overlay.classList.toggle('open');
}
