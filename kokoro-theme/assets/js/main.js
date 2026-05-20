/**
 * Kokoro Brașov Academy — Main JavaScript
 * Mobile menu, scroll animations, counter, sakura petals, smooth scroll
 */

(function () {
  'use strict';

  // Respectă preferința utilizatorului pentru reduced motion (WCAG 2.3.3).
  var prefersReducedMotion =
    window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ==========================================================================
     1. Mobile Menu Toggle
     ========================================================================== */

  function initMobileMenu() {
    var hamburger = document.querySelector('.navbar__hamburger');
    var mobileMenu = document.querySelector('.navbar__mobile-menu');

    if (!hamburger || !mobileMenu) return;

    var lastFocused = null;

    function getFocusable() {
      return mobileMenu.querySelectorAll(
        'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])'
      );
    }

    function openMenu() {
      hamburger.classList.add('navbar__hamburger--active');
      mobileMenu.classList.add('navbar__mobile-menu--active');
      hamburger.setAttribute('aria-expanded', 'true');
      hamburger.setAttribute('aria-label', 'Închide meniu');
      mobileMenu.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      // Move focus to first interactive element în meniu
      lastFocused = document.activeElement;
      var focusable = getFocusable();
      if (focusable.length > 0) {
        focusable[0].focus();
      }
    }

    function closeMenu() {
      hamburger.classList.remove('navbar__hamburger--active');
      mobileMenu.classList.remove('navbar__mobile-menu--active');
      hamburger.setAttribute('aria-expanded', 'false');
      hamburger.setAttribute('aria-label', 'Deschide meniu');
      mobileMenu.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
      // Restore focus la elementul anterior
      if (lastFocused && typeof lastFocused.focus === 'function') {
        lastFocused.focus();
      } else {
        hamburger.focus();
      }
    }

    function isOpen() {
      return mobileMenu.classList.contains('navbar__mobile-menu--active');
    }

    hamburger.addEventListener('click', function () {
      if (isOpen()) closeMenu();
      else openMenu();
    });

    // Close on link click
    mobileMenu.querySelectorAll('.kokoro-menu__link').forEach(function (link) {
      link.addEventListener('click', function () {
        closeMenu();
      });
    });

    // Esc closes menu + Tab focus trap în interiorul meniului
    document.addEventListener('keydown', function (e) {
      if (!isOpen()) return;

      if (e.key === 'Escape' || e.key === 'Esc') {
        e.preventDefault();
        closeMenu();
        return;
      }

      if (e.key === 'Tab') {
        var focusable = getFocusable();
        if (focusable.length === 0) return;
        var first = focusable[0];
        var last = focusable[focusable.length - 1];
        if (e.shiftKey && document.activeElement === first) {
          e.preventDefault();
          last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
          e.preventDefault();
          first.focus();
        }
      }
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

    // Reduced motion: afișează direct valoarea finală, fără număratoare.
    if (prefersReducedMotion) {
      counters.forEach(function (el) {
        var prefix = el.getAttribute('data-prefix') || '';
        var suffix = el.getAttribute('data-suffix') || '';
        el.textContent = prefix + el.getAttribute('data-counter') + suffix;
      });
      return;
    }

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
    // Reduced motion: skip complet — petalele sunt pur decorative.
    if (prefersReducedMotion) return;

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
     Initialize All
     ========================================================================== */

  document.addEventListener('DOMContentLoaded', function () {
    initMobileMenu();
    initNavbarScroll();
    initScrollReveal();
    initCounters();
    initSakuraPetals();
    initSmoothScroll();
    initMarquee();
  });
})();
