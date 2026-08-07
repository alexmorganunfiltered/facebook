/**
 * Language preference for static pages (localStorage — no server required).
 */
(function () {
  'use strict';

  var STORAGE_KEY = 'amd-lang';
  var VALID = { en: true, si: true };

  function readQueryLang() {
    try {
      var params = new URLSearchParams(window.location.search);
      var fromQuery = params.get('lang');
      if (fromQuery && VALID[fromQuery]) {
        return fromQuery;
      }
    } catch (e) {
      /* ignore */
    }
    return '';
  }

  function detectDefaultLang() {
    var nav = navigator.language || '';
    if (nav.toLowerCase().indexOf('si') === 0) {
      return 'si';
    }
    return 'en';
  }

  function getStoredLang() {
    try {
      var stored = localStorage.getItem(STORAGE_KEY);
      if (stored && VALID[stored]) {
        return stored;
      }
    } catch (e) {
      /* private browsing */
    }
    return '';
  }

  function applyLang(lang) {
    if (!VALID[lang]) {
      return;
    }
    document.documentElement.setAttribute('data-lang', lang);
    document.documentElement.lang = lang === 'si' ? 'si' : 'en';
  }

  function setLang(lang) {
    if (!VALID[lang]) {
      return;
    }
    try {
      localStorage.setItem(STORAGE_KEY, lang);
    } catch (e) {
      /* ignore */
    }
    applyLang(lang);
    updateButtons();
  }

  function updateButtons() {
    var current = document.documentElement.getAttribute('data-lang') || 'en';
    document.querySelectorAll('[data-lang-switch]').forEach(function (btn) {
      var value = btn.getAttribute('data-lang-switch');
      var active = value === current;
      btn.setAttribute('aria-pressed', active ? 'true' : 'false');
      btn.classList.toggle('amd-lang-switch__btn--active', active);
    });
  }

  function init() {
    var lang = readQueryLang() || getStoredLang() || detectDefaultLang();
    applyLang(lang);
    if (readQueryLang()) {
      try {
        localStorage.setItem(STORAGE_KEY, lang);
      } catch (e) {
        /* ignore */
      }
    }
    updateButtons();

    document.addEventListener('click', function (event) {
      var btn = event.target.closest('[data-lang-switch]');
      if (!btn) {
        return;
      }
      event.preventDefault();
      setLang(btn.getAttribute('data-lang-switch'));
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
