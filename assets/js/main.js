/**
 * Glosarium LibreOffice Indonesia - Main Application Logic
 */

(function () {
  'use strict';

  // Section Elements
  const welcomeSection = document.getElementById('welcomeSection');
  const glosariumSection = document.getElementById('glosariumSection');
  const tentangSection = document.getElementById('tentangSection');

  // Interactive Buttons & Links
  const btnExploreGlossary = document.getElementById('btnExploreGlossary');
  const btnExploreAbout = document.getElementById('btnExploreAbout');
  const navBrandLogo = document.getElementById('navBrandLogo');
  const navLinkGlosarium = document.getElementById('navLinkGlosarium');
  const navLinkTentang = document.getElementById('navLinkTentang');
  const mobileLinkGlosarium = document.getElementById('mobileLinkGlosarium');
  const mobileLinkTentang = document.getElementById('mobileLinkTentang');

  // Search & Filter Elements
  const searchInput = document.getElementById('searchGlossary');
  const searchClearBtn = document.getElementById('searchClearBtn');
  const resultsCount = document.getElementById('resultsCount');
  const alphabetContainer = document.getElementById('alphabetNav');
  const groupedView = document.getElementById('groupedView');
  const searchResultsView = document.getElementById('searchResultsView');
  const searchTableBody = document.getElementById('searchTableBody');
  const emptyState = document.getElementById('emptyState');
  const fixedHeader = document.getElementById('fixedHeader');

  // Mobile Drawer
  const mobileNavToggle = document.getElementById('mobileNavToggle');
  const mobileNavClose = document.getElementById('mobileNavClose');
  const mobileNavDrawer = document.getElementById('mobileNavDrawer');
  const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

  // Modal & Toast
  const termModal = document.getElementById('termModal');
  const modalCloseBtn = document.getElementById('modalCloseBtn');
  const modalSource = document.getElementById('modalSource');
  const modalPadanan = document.getElementById('modalPadanan');
  const modalCopyBtn = document.getElementById('modalCopyBtn');
  const toastContainer = document.getElementById('toastContainer');

  // Glossary Data
  let glossaryData = [];
  if (window.__GLOSARIUM_DATA__ && Array.isArray(window.__GLOSARIUM_DATA__)) {
    glossaryData = window.__GLOSARIUM_DATA__.map(item => ({
      source: (item.Source || '').trim(),
      padanan: (item.Padanan || '').trim(),
      letter: ((item.Source || '').trim().charAt(0) || '#').toUpperCase()
    })).filter(item => item.source.length > 0);
  }

  let activeLetter = 'SEMUA';
  let searchQuery = '';
  let currentView = 'WELCOME'; // 'WELCOME' | 'GLOSARIUM' | 'TENTANG'

  // Initialize
  function init() {
    updateHeaderHeight();
    window.addEventListener('resize', updateHeaderHeight);

    setupMobileNav();
    setupAlphabetNav();
    setupSearch();
    setupModalAndCopy();
    setupNavigationRouting();
    
    // Check initial hash
    handleInitialRoute();
  }

  // Adjust content padding based on fixed header height
  function updateHeaderHeight() {
    if (fixedHeader) {
      const height = fixedHeader.offsetHeight;
      document.documentElement.style.setProperty('--header-height', `${height}px`);
    }
  }

  // Route Handlers
  function handleInitialRoute() {
    const hash = window.location.hash;
    if (hash === '#glosarium') {
      showGlosarium('SEMUA', false);
    } else if (hash === '#tentang') {
      showTentang(false);
    } else {
      showWelcome();
    }
  }

  function showWelcome() {
    currentView = 'WELCOME';
    if (welcomeSection) welcomeSection.style.display = 'block';
    if (glosariumSection) glosariumSection.style.display = 'none';
    if (tentangSection) tentangSection.style.display = 'none';

    // Clear active states in nav & alphabet
    setActiveNavLink(null);
    clearActiveAlphabet();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function showGlosarium(letter = 'SEMUA', shouldScroll = true) {
    currentView = 'GLOSARIUM';
    if (welcomeSection) welcomeSection.style.display = 'none';
    if (tentangSection) tentangSection.style.display = 'none';
    if (glosariumSection) glosariumSection.style.display = 'block';

    setActiveNavLink('glosarium');
    activeLetter = letter;
    setActiveAlphabetBtn(letter);
    updateView();

    if (shouldScroll) {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  }

  function showTentang(shouldScroll = true) {
    currentView = 'TENTANG';
    if (welcomeSection) welcomeSection.style.display = 'none';
    if (glosariumSection) glosariumSection.style.display = 'none';
    if (tentangSection) tentangSection.style.display = 'block';

    setActiveNavLink('tentang');
    clearActiveAlphabet();

    if (shouldScroll) {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  }

  function setActiveNavLink(section) {
    [navLinkGlosarium, mobileLinkGlosarium].forEach(el => {
      if (el) el.classList.toggle('active', section === 'glosarium');
    });
    [navLinkTentang, mobileLinkTentang].forEach(el => {
      if (el) el.classList.toggle('active', section === 'tentang');
    });
  }

  function clearActiveAlphabet() {
    if (alphabetContainer) {
      alphabetContainer.querySelectorAll('.alpha-btn').forEach(btn => btn.classList.remove('active'));
    }
  }

  function setActiveAlphabetBtn(letter) {
    if (!alphabetContainer) return;
    alphabetContainer.querySelectorAll('.alpha-btn').forEach(btn => {
      btn.classList.toggle('active', btn.getAttribute('data-letter') === letter);
    });
  }

  // Navigation Click Handlers
  function setupNavigationRouting() {
    if (navBrandLogo) {
      navBrandLogo.addEventListener('click', function (e) {
        e.preventDefault();
        showWelcome();
        closeMobileNav();
      });
    }

    if (btnExploreGlossary) {
      btnExploreGlossary.addEventListener('click', function () {
        showGlosarium('SEMUA');
      });
    }

    if (btnExploreAbout) {
      btnExploreAbout.addEventListener('click', function () {
        showTentang();
      });
    }

    // Daftar Kata link
    [navLinkGlosarium, mobileLinkGlosarium].forEach(link => {
      if (link) {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          showGlosarium('SEMUA');
          closeMobileNav();
        });
      }
    });

    // Tentang link
    [navLinkTentang, mobileLinkTentang].forEach(link => {
      if (link) {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          showTentang();
          closeMobileNav();
        });
      }
    });
  }

  // Mobile Drawer
  function setupMobileNav() {
    if (mobileNavToggle) {
      mobileNavToggle.addEventListener('click', openMobileNav);
    }
    if (mobileNavClose) {
      mobileNavClose.addEventListener('click', closeMobileNav);
    }
    if (mobileMenuOverlay) {
      mobileMenuOverlay.addEventListener('click', closeMobileNav);
    }
  }

  function openMobileNav() {
    if (mobileNavDrawer) mobileNavDrawer.classList.add('show');
    if (mobileMenuOverlay) mobileMenuOverlay.classList.add('show');
    document.body.style.overflow = 'hidden';
  }

  function closeMobileNav() {
    if (mobileNavDrawer) mobileNavDrawer.classList.remove('show');
    if (mobileMenuOverlay) mobileMenuOverlay.classList.remove('show');
    document.body.style.overflow = '';
  }

  // Alphabet Filter
  function setupAlphabetNav() {
    if (!alphabetContainer) return;

    const availableLetters = new Set(glossaryData.map(item => item.letter));
    const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
    let html = `<li><button type="button" class="alpha-btn" data-letter="SEMUA">Semua</button></li>`;

    alphabet.forEach(letter => {
      const hasTerms = availableLetters.has(letter);
      const disabledClass = hasTerms ? '' : 'disabled';
      html += `<li><button type="button" class="alpha-btn ${disabledClass}" data-letter="${letter}">${letter}</button></li>`;
    });

    alphabetContainer.innerHTML = html;

    alphabetContainer.addEventListener('click', function (e) {
      const btn = e.target.closest('.alpha-btn');
      if (!btn || btn.classList.contains('disabled')) return;

      const letter = btn.getAttribute('data-letter');
      
      // Clear search when clicking letter filter
      if (searchQuery && searchInput) {
        searchInput.value = '';
        searchQuery = '';
        if (searchClearBtn) searchClearBtn.style.display = 'none';
      }

      showGlosarium(letter);

      // Scroll to specific letter group if not SEMUA
      if (letter !== 'SEMUA') {
        const targetGroup = document.getElementById(`letter-group-${letter}`);
        if (targetGroup) {
          setTimeout(() => {
            const headerHeight = fixedHeader ? fixedHeader.offsetHeight : 160;
            const elementPosition = targetGroup.getBoundingClientRect().top + window.pageYOffset;
            window.scrollTo({
              top: elementPosition - headerHeight - 15,
              behavior: 'smooth'
            });
          }, 50);
        }
      }
    });
  }

  // Setup Search Input
  function setupSearch() {
    if (!searchInput) return;

    // Keyboard shortcut '/' to search, 'Esc' to clear
    window.addEventListener('keydown', function (e) {
      if (e.key === '/' && document.activeElement !== searchInput) {
        e.preventDefault();
        searchInput.focus();
      } else if (e.key === 'Escape') {
        if (termModal && termModal.classList.contains('show')) {
          closeModal();
        } else if (mobileNavDrawer && mobileNavDrawer.classList.contains('show')) {
          closeMobileNav();
        } else if (searchInput === document.activeElement || searchQuery) {
          clearSearch();
        }
      }
    });

    searchInput.addEventListener('input', function (e) {
      searchQuery = e.target.value.trim().toLowerCase();
      if (searchClearBtn) {
        searchClearBtn.style.display = searchQuery ? 'flex' : 'none';
      }

      if (searchQuery.length > 0) {
        if (currentView !== 'GLOSARIUM') {
          showGlosarium('SEMUA', false);
        } else {
          updateView();
        }
      } else {
        updateView();
      }
    });

    if (searchClearBtn) {
      searchClearBtn.addEventListener('click', clearSearch);
    }
  }

  function clearSearch() {
    if (searchInput) {
      searchInput.value = '';
      searchInput.focus();
    }
    searchQuery = '';
    if (searchClearBtn) searchClearBtn.style.display = 'none';
    updateView();
  }

  // Update View based on Search & Letter Filter
  function updateView() {
    if (currentView !== 'GLOSARIUM') return;

    if (searchQuery.length > 0) {
      // Search Mode: Show results table
      if (groupedView) groupedView.style.display = 'none';
      if (searchResultsView) searchResultsView.style.display = 'block';

      const filtered = glossaryData.filter(item =>
        item.source.toLowerCase().includes(searchQuery) ||
        item.padanan.toLowerCase().includes(searchQuery)
      );

      if (resultsCount) resultsCount.textContent = `${filtered.length} ditemukan`;

      if (filtered.length === 0) {
        if (searchTableBody) searchTableBody.innerHTML = '';
        if (emptyState) emptyState.style.display = 'block';
      } else {
        if (emptyState) emptyState.style.display = 'none';
        renderSearchResults(filtered);
      }
    } else {
      // Grouped Mode: Show alphabetical groups
      if (searchResultsView) searchResultsView.style.display = 'none';
      if (groupedView) groupedView.style.display = 'block';
      if (emptyState) emptyState.style.display = 'none';

      let visibleCount = 0;
      const groups = document.querySelectorAll('.letter-group');
      groups.forEach(group => {
        const letter = group.getAttribute('data-letter');
        if (activeLetter === 'SEMUA' || activeLetter === letter) {
          group.style.display = 'block';
          const termsInGroup = group.querySelectorAll('.term-chip').length;
          visibleCount += termsInGroup;
        } else {
          group.style.display = 'none';
        }
      });

      if (resultsCount) {
        resultsCount.textContent = activeLetter === 'SEMUA' ? `${glossaryData.length} padanan kata` : `${visibleCount} padanan kata (${activeLetter})`;
      }
    }
  }

  // Render highlighted search results table
  function renderSearchResults(items) {
    if (!searchTableBody) return;

    let html = '';
    items.forEach(item => {
      const highlightedSource = highlightText(item.source, searchQuery);
      const highlightedPadanan = highlightText(item.padanan, searchQuery);

      html += `
        <tr>
          <td class="col-letter">${item.letter}</td>
          <td class="col-source">
            <span class="source-link" data-source="${escapeHtml(item.source)}" data-padanan="${escapeHtml(item.padanan)}" style="cursor: pointer;">${highlightedSource}</span>
          </td>
          <td class="col-padanan">${highlightedPadanan}</td>
          <td class="col-action">
            <button type="button" class="btn-copy" data-copy="${escapeHtml(item.padanan)}" title="Salin Padanan">
              <i class="far fa-copy"></i> Salin
            </button>
          </td>
        </tr>
      `;
    });

    searchTableBody.innerHTML = html;
  }

  function highlightText(text, query) {
    if (!query) return escapeHtml(text);
    const escaped = escapeHtml(text);
    const regex = new RegExp(`(${escapeRegex(query)})`, 'gi');
    return escaped.replace(regex, '<mark class="bg-success text-white px-1 rounded" style="background-color: #17a204; color: #fff; padding: 0.1rem 0.3rem; border-radius: 4px;">$1</mark>');
  }

  function escapeHtml(str) {
    return (str || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  function escapeRegex(str) {
    return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }

  // Modal and Clipboard
  function setupModalAndCopy() {
    document.addEventListener('click', function (e) {
      const copyBtn = e.target.closest('[data-copy]');
      if (copyBtn) {
        e.stopPropagation();
        const textToCopy = copyBtn.getAttribute('data-copy');
        copyToClipboard(textToCopy);
        return;
      }

      const termChip = e.target.closest('.term-chip') || e.target.closest('.source-link');
      if (termChip) {
        const source = termChip.getAttribute('data-source');
        const padanan = termChip.getAttribute('data-padanan');
        openModal(source, padanan);
        return;
      }
    });

    if (modalCloseBtn) {
      modalCloseBtn.addEventListener('click', closeModal);
    }

    if (termModal) {
      termModal.addEventListener('click', function (e) {
        if (e.target === termModal) closeModal();
      });
    }

    if (modalCopyBtn) {
      modalCopyBtn.addEventListener('click', function () {
        const text = modalPadanan ? modalPadanan.textContent : '';
        copyToClipboard(text);
      });
    }
  }

  function openModal(source, padanan) {
    if (!termModal) return;
    if (modalSource) modalSource.textContent = source;
    if (modalPadanan) modalPadanan.textContent = padanan;
    termModal.classList.add('show');
  }

  function closeModal() {
    if (!termModal) return;
    termModal.classList.remove('show');
  }

  function copyToClipboard(text) {
    if (!text) return;
    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(text).then(() => {
        showToast(`Padanan "${text}" berhasil disalin!`);
      }).catch(() => {
        fallbackCopy(text);
      });
    } else {
      fallbackCopy(text);
    }
  }

  function fallbackCopy(text) {
    const tempInput = document.createElement('textarea');
    tempInput.value = text;
    tempInput.style.position = 'fixed';
    tempInput.style.opacity = '0';
    document.body.appendChild(tempInput);
    tempInput.focus();
    tempInput.select();
    try {
      document.execCommand('copy');
      showToast(`Padanan "${text}" berhasil disalin!`);
    } catch (err) {
      showToast('Gagal menyalin teks');
    }
    document.body.removeChild(tempInput);
  }

  function showToast(message) {
    if (!toastContainer) return;
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `<i class="fas fa-check-circle" style="color: #4ade80"></i> <span>${escapeHtml(message)}</span>`;
    toastContainer.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(10px)';
      toast.style.transition = 'all 0.3s ease';
      setTimeout(() => toast.remove(), 300);
    }, 2500);
  }

  // Execute on DOM Ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
