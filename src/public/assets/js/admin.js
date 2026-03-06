/**
 * VOX - UI Dynamics (Admin)
 */

document.addEventListener('DOMContentLoaded', () => {
    console.log("VOX Admin UI Initialized");

    // Auto-hide alerts after 5s
    const alerts = document.querySelectorAll('[style*="background: #dcfce7"], [style*="background: #fee2e2"]');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Handle Active Nav via JS if PHP fails (redundancy)
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-links a').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
});

/**
 * Global Modal Controls
 */
function closeOverlay() {
    const overlay = document.getElementById('overlay');
    if (overlay) overlay.style.display = 'none';
}

// Close on ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeOverlay();
});
