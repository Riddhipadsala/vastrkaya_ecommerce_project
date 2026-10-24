import './bootstrap';

// Global Toast Notification Utility for customer & admin
window.showToast = window.showToastr = function (message, type = 'success') {
    let container = document.getElementById('vkToastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'vkToastContainer';
        container.className = 'vk-toast-container';
        document.body.appendChild(container);
    }

    // Limit maximum visible toasts to 3 so it doesn't take up full window height
    const MAX_VISIBLE_TOASTS = 3;
    while (container.children.length >= MAX_VISIBLE_TOASTS) {
        container.firstElementChild.remove();
    }

    const toast = document.createElement('div');
    toast.className = 'vk-toast';

    let icon = 'bi-check-circle-fill text-success';
    if (type === 'error' || type === 'danger') {
        toast.style.borderLeftColor = '#ef4444';
        icon = 'bi-exclamation-octagon-fill text-danger';
    } else if (type === 'warning') {
        toast.style.borderLeftColor = '#f59e0b';
        icon = 'bi-exclamation-triangle-fill text-warning';
    } else if (type === 'info') {
        toast.style.borderLeftColor = '#3b82f6';
        icon = 'bi-info-circle-fill text-info';
    }

    toast.innerHTML = `
        <i class="bi ${icon} fs-5"></i>
        <div class="flex-grow-1 font-13 fw-semibold">${message}</div>
        <button type="button" class="btn-close ms-2" style="font-size: 0.75rem;" aria-label="Close"></button>
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
    }, 2800);
};
