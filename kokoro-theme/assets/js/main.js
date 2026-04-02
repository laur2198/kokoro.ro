/**
 * Kokoro Brașov Academy — Main JavaScript
 * Mobile menu, scroll animations, counter, sakura petals, smooth scroll
 */

(function () {
  'use strict';

  /* ==========================================================================
     1. Mobile Menu Toggle
     ========================================================================== */

  function initMobileMenu() {
    var hamburger = document.querySelector('.navbar__hamburger');
    var mobileMenu = document.querySelector('.navbar__mobile-menu');
    var closeBtn = document.querySelector('.navbar__close');

    if (!hamburger || !mobileMenu) return;

    function openMenu() {
      hamburger.classList.add('navbar__hamburger--active');
      mobileMenu.classList.add('navbar__mobile-menu--active');
      document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
      hamburger.classList.remove('navbar__hamburger--active');
      mobileMenu.classList.remove('navbar__mobile-menu--active');
      document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', function () {
      if (mobileMenu.classList.contains('navbar__mobile-menu--active')) {
        closeMenu();
      } else {
        openMenu();
      }
    });

    // Close button (X)
    if (closeBtn) {
      closeBtn.addEventListener('click', closeMenu);
    }

    // Close on link click
    mobileMenu.querySelectorAll('.kokoro-menu__link').forEach(function (link) {
      link.addEventListener('click', closeMenu);
    });
  }

  /* ==========================================================================
     2. Navbar Scroll Effect
     ========================================================================== */

  function initNavbarScroll() {
    var navbar = document.querySelector('.navbar');
    if (!navbar) return;

    var scrollThreshold = 50;
    var ticking = false;

    window.addEventListener('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(function () {
          if (window.scrollY > scrollThreshold) {
            navbar.classList.add('navbar--scrolled');
          } else {
            navbar.classList.remove('navbar--scrolled');
          }
          ticking = false;
        });
        ticking = true;
      }
    });
  }

  /* ==========================================================================
     3. Scroll Reveal (IntersectionObserver)
     ========================================================================== */

  function initScrollReveal() {
    var elements = document.querySelectorAll('.reveal');
    if (!elements.length) return;

    if (!('IntersectionObserver' in window)) {
      elements.forEach(function (el) {
        el.classList.add('reveal--visible');
      });
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('reveal--visible');
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px',
      }
    );

    elements.forEach(function (el) {
      observer.observe(el);
    });
  }

  /* ==========================================================================
     4. Counter Animation
     ========================================================================== */

  function initCounters() {
    var counters = document.querySelectorAll('[data-counter]');
    if (!counters.length) return;

    if (!('IntersectionObserver' in window)) {
      counters.forEach(function (el) {
        el.textContent = el.getAttribute('data-counter');
      });
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.5 }
    );

    counters.forEach(function (el) {
      observer.observe(el);
    });
  }

  function animateCounter(el) {
    var target = parseInt(el.getAttribute('data-counter'), 10);
    var suffix = el.getAttribute('data-suffix') || '';
    var prefix = el.getAttribute('data-prefix') || '';
    var duration = 2000;
    var start = 0;
    var startTime = null;

    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      var progress = Math.min((timestamp - startTime) / duration, 1);

      // Ease out cubic
      var eased = 1 - Math.pow(1 - progress, 3);
      var current = Math.floor(eased * target);

      el.textContent = prefix + current + suffix;

      if (progress < 1) {
        window.requestAnimationFrame(step);
      } else {
        el.textContent = prefix + target + suffix;
      }
    }

    window.requestAnimationFrame(step);
  }

  /* ==========================================================================
     5. Sakura Petals Animation
     ========================================================================== */

  function initSakuraPetals() {
    var container = document.querySelector('.sakura-container');
    if (!container) return;

    // Only on desktop
    if (window.innerWidth < 768) return;

    // Create petals periodically
    function createPetal() {
      var petal = document.createElement('div');
      petal.className = 'sakura-petal';
      petal.style.left = Math.random() * 100 + '%';
      petal.style.animationDuration = 8 + Math.random() * 7 + 's';
      petal.style.animationDelay = Math.random() * 2 + 's';
      petal.style.width = 8 + Math.random() * 8 + 'px';
      petal.style.height = petal.style.width;

      container.appendChild(petal);

      // Remove petal after animation
      setTimeout(function () {
        if (petal.parentNode) {
          petal.parentNode.removeChild(petal);
        }
      }, 17000);
    }

    // Create a petal every 3 seconds (subtle)
    setInterval(createPetal, 3000);

    // Initial batch of 3
    for (var i = 0; i < 3; i++) {
      setTimeout(createPetal, i * 1000);
    }
  }

  /* ==========================================================================
     6. Smooth Scroll for Anchor Links
     ========================================================================== */

  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
      anchor.addEventListener('click', function (e) {
        var targetId = this.getAttribute('href');
        if (targetId === '#') return;

        var target = document.querySelector(targetId);
        if (!target) return;

        e.preventDefault();

        var navbarHeight = document.querySelector('.navbar')
          ? document.querySelector('.navbar').offsetHeight
          : 0;

        var targetPosition =
          target.getBoundingClientRect().top + window.scrollY - navbarHeight - 20;

        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth',
        });
      });
    });
  }

  /* ==========================================================================
     7. Marquee — Clone items for infinite scroll
     ========================================================================== */

  function initMarquee() {
    var tracks = document.querySelectorAll('.marquee__track');

    tracks.forEach(function (track) {
      var items = track.innerHTML;
      // Duplicate content for seamless loop
      track.innerHTML = items + items;
    });
  }

  /* ==========================================================================
     8. Parallax Scroll
     ========================================================================== */

  function initParallax() {
    var parallaxElements = document.querySelectorAll('.parallax-bg');
    if (!parallaxElements.length || window.innerWidth < 768) return;

    var ticking = false;

    window.addEventListener('scroll', function () {
      if (!ticking) {
        window.requestAnimationFrame(function () {
          var scrollY = window.scrollY;
          parallaxElements.forEach(function (el) {
            var rect = el.parentElement.getBoundingClientRect();
            var speed = 0.3;
            var yPos = (rect.top * speed);
            el.style.transform = 'translateY(' + yPos + 'px)';
          });
          ticking = false;
        });
        ticking = true;
      }
    });
  }

  /* ==========================================================================
     9. Testimonial Carousel
     ========================================================================== */

  function initCarousel() {
    var carousel = document.querySelector('.testimonial-carousel');
    if (!carousel) return;

    var track = carousel.querySelector('.testimonial-carousel__track');
    var slides = carousel.querySelectorAll('.testimonial-carousel__slide');
    var prevBtn = carousel.querySelector('.testimonial-carousel__btn--prev');
    var nextBtn = carousel.querySelector('.testimonial-carousel__btn--next');
    var dots = carousel.querySelectorAll('.testimonial-carousel__dot');

    if (!track || !slides.length) return;

    var currentIndex = 0;
    var slidesPerView = 1;

    function updateSlidesPerView() {
      if (window.innerWidth >= 1024) slidesPerView = 3;
      else if (window.innerWidth >= 768) slidesPerView = 2;
      else slidesPerView = 1;
    }

    function goToSlide(index) {
      var maxIndex = Math.max(0, slides.length - slidesPerView);
      currentIndex = Math.max(0, Math.min(index, maxIndex));
      var offset = -(currentIndex * (100 / slidesPerView));
      track.style.transform = 'translateX(' + offset + '%)';

      dots.forEach(function (dot, i) {
        dot.classList.toggle('testimonial-carousel__dot--active', i === currentIndex);
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', function () {
        goToSlide(currentIndex - 1);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function () {
        goToSlide(currentIndex + 1);
      });
    }

    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () {
        goToSlide(i);
      });
    });

    updateSlidesPerView();
    window.addEventListener('resize', function () {
      updateSlidesPerView();
      goToSlide(currentIndex);
    });

    // Auto-play every 5 seconds
    setInterval(function () {
      var maxIndex = Math.max(0, slides.length - slidesPerView);
      if (currentIndex >= maxIndex) goToSlide(0);
      else goToSlide(currentIndex + 1);
    }, 5000);
  }

  /* ==========================================================================
     10. Button Ripple Effect
     ========================================================================== */

  function initRipple() {
    document.querySelectorAll('.btn').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        var rect = btn.getBoundingClientRect();
        var ripple = document.createElement('span');
        ripple.className = 'btn__ripple';
        var size = Math.max(rect.width, rect.height);
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
        ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
        btn.appendChild(ripple);
        setTimeout(function () {
          ripple.remove();
        }, 600);
      });
    });
  }

  /* ==========================================================================
     11. Page Loader
     ========================================================================== */

  function initPageLoader() {
    var loader = document.querySelector('.page-loader');
    if (!loader) return;

    window.addEventListener('load', function () {
      setTimeout(function () {
        loader.classList.add('page-loader--hidden');
        document.body.classList.add('page-transition');
      }, 1500);
    });
  }

  /* ==========================================================================
     12. Card 3D Tilt
     ========================================================================== */

  function initCardTilt() {
    if (window.innerWidth < 1024) return;

    document.querySelectorAll('.card-tilt').forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var rect = card.getBoundingClientRect();
        var x = e.clientX - rect.left;
        var y = e.clientY - rect.top;
        var centerX = rect.width / 2;
        var centerY = rect.height / 2;
        var rotateX = (y - centerY) / 20;
        var rotateY = (centerX - x) / 20;
        card.style.transform = 'perspective(1000px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) translateY(-4px)';
      });

      card.addEventListener('mouseleave', function () {
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
      });
    });
  }

  /* ==========================================================================
     Initialize All
     ========================================================================== */

  // Page loader runs immediately
  initPageLoader();

  document.addEventListener('DOMContentLoaded', function () {
    initMobileMenu();
    initNavbarScroll();
    initScrollReveal();
    initCounters();
    initSakuraPetals();
    initSmoothScroll();
    initMarquee();
    initParallax();
    initCarousel();
    initRipple();
    initCardTilt();
  });
})();
