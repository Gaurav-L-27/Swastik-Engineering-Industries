/* Requires jQuery, GSAP and ScrollTrigger, loaded in that order in index.html. */
(function () {
  'use strict';

  function initMenu() {
    var $button = $('.menu-toggle');
    var $menu = $('#mobile-nav');

    $button.on('click', function () {
      var open = $(this).attr('aria-expanded') !== 'true';

      $(this)
        .attr('aria-expanded', String(open))
        .attr('aria-label', open ? 'Close menu' : 'Open menu');

      $menu.prop('hidden', !open);
    });

    $menu.find('a').on('click', function () {
      $button
        .attr('aria-expanded', 'false')
        .attr('aria-label', 'Open menu');

      $menu.prop('hidden', true);
    });

    $(window).on('resize', function () {
      if (window.innerWidth >= 1024) {
        $button
          .attr('aria-expanded', 'false')
          .attr('aria-label', 'Open menu');

        $menu.prop('hidden', true);
      }
    });
  }

  function initAnimations() {
    if (
      window.matchMedia('(prefers-reduced-motion: reduce)').matches ||
      !window.gsap ||
      !window.ScrollTrigger
    ) {
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    gsap.from('[data-hero]', {
      y: 24,
      opacity: 0,
      duration: 0.9,
      stagger: 0.12,
      ease: 'power3.out',
      clearProps: 'all'
    });

    gsap.utils.toArray('[data-reveal]').forEach(function (element) {
      gsap.from(element, {
        y: 35,
        opacity: 0,
        duration: 0.8,
        ease: 'power2.out',
        clearProps: 'all',
        scrollTrigger: {
          trigger: element,
          start: 'top 88%',
          once: true
        }
      });
    });

    gsap.utils.toArray('[data-stagger]').forEach(function (group) {
      gsap.from(group.children, {
        y: 30,
        opacity: 0,
        duration: 0.65,
        stagger: 0.09,
        ease: 'power2.out',
        clearProps: 'all',
        scrollTrigger: {
          trigger: group,
          start: 'top 85%',
          once: true
        }
      });
    });

    gsap.utils.toArray('[data-rule]').forEach(function (element) {
      gsap.from(element, {
        scaleX: 0,
        transformOrigin: 'left center',
        duration: 1,
        ease: 'power2.out',
        clearProps: 'all',
        scrollTrigger: {
          trigger: element,
          start: 'top 90%',
          once: true
        }
      });
    });
  }

  if (window.jQuery) {
    $(function () {
      initMenu();
      initAnimations();
    });
  } else {
    document.addEventListener('DOMContentLoaded', function () {
      initAnimations();
    });
  }
}());