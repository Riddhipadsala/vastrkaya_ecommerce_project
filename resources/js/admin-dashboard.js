/**
 * Vastrkaya Admin Dashboard - UI Helper Logic
 * Light & Dark Theme Management, Mobile Sidebar Toggle, Toast Utility
 */

(function () {
    'use strict';

    // =========================================================================
    // 1. Theme Management (Light / Dark)
    // =========================================================================
    const THEME_KEY = 'vk_admin_theme';
    const THEME_LIGHT = 'light';
    const THEME_DARK = 'dark';

    function getPreferredTheme() {
        const stored = localStorage.getItem(THEME_KEY);
        if (stored) {
            return stored;
        }
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
            ? THEME_DARK
            : THEME_LIGHT;
    }

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        document.body.setAttribute('data-theme', theme);
        localStorage.setItem(THEME_KEY, theme);

        const themeBtn = document.getElementById('themeToggleBtn');
        if (themeBtn) {
            const icon = themeBtn.querySelector('i');
            if (icon) {
                if (theme === THEME_DARK) {
                    icon.className = 'bi bi-sun-fill text-warning';
                    themeBtn.setAttribute('title', 'Switch to Light Mode');
                } else {
                    icon.className = 'bi bi-moon-stars-fill text-secondary';
                    themeBtn.setAttribute('title', 'Switch to Dark Mode');
                }
            }
        }
    }

    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme') || THEME_LIGHT;
        const target = current === THEME_DARK ? THEME_LIGHT : THEME_DARK;
        applyTheme(target);
        showToast(`Theme switched to ${target.charAt(0).toUpperCase() + target.slice(1)} mode`, 'info');
    }

    // Apply preferred theme on initial load
    applyTheme(getPreferredTheme());

    // =========================================================================
    // 2. DOM Ready Initializations
    // =========================================================================
    document.addEventListener('DOMContentLoaded', function () {
        // Theme toggle button click
        const themeBtn = document.getElementById('themeToggleBtn');
        if (themeBtn) {
            themeBtn.addEventListener('click', toggleTheme);
            applyTheme(getPreferredTheme());
        }

        // Mobile Sidebar toggler
        const sidebarToggle = document.getElementById('sidebarToggleBtn');
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');

        function toggleSidebar() {
            if (sidebar) sidebar.classList.toggle('show');
            if (backdrop) backdrop.classList.toggle('show');
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }
        if (backdrop) {
            backdrop.addEventListener('click', toggleSidebar);
        }

        // Profile Avatar Preview
        const avatarInput = document.getElementById('adminAvatarInput');
        const avatarPreview = document.getElementById('adminAvatarPreview');
        if (avatarInput && avatarPreview) {
            avatarInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        avatarPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });

    // =========================================================================
    // 3. Global Toast Utility
    // =========================================================================
    window.showToast = function (message, type = 'success') {
        let container = document.getElementById('vkToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'vkToastContainer';
            container.className = 'vk-toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'vk-toast';

        let icon = 'bi-check-circle-fill text-success';
        if (type === 'error' || type === 'danger') {
            toast.style.borderLeftColor = 'var(--vk-danger)';
            icon = 'bi-exclamation-octagon-fill text-danger';
        } else if (type === 'warning') {
            toast.style.borderLeftColor = 'var(--vk-warning)';
            icon = 'bi-exclamation-triangle-fill text-warning';
        } else if (type === 'info') {
            toast.style.borderLeftColor = 'var(--vk-info)';
            icon = 'bi-info-circle-fill text-info';
        }

        toast.innerHTML = `
            <i class="bi ${icon} fs-5"></i>
            <div class="flex-grow-1 font-13 fw-semibold">${message}</div>
            <button type="button" class="btn-close ms-2" style="font-size: 0.75rem;"></button>
        `;

        toast.querySelector('.btn-close').addEventListener('click', () => {
            toast.remove();
        });

        container.appendChild(toast);

        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                setTimeout(() => toast.remove(), 300);
            }
        }, 4000);
    };

    window.toggleTheme = toggleTheme;

})();
