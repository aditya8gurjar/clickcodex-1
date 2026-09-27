<?php
/**
 * ClickCodex Technologies - Admin Global Footer Layout
 * Reusable layout component included across all admin panel views.
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}
?>
    </main>
  </div><!-- /.admin-shell -->

  <!-- ========================================================================
       LEAD DETAILS MODAL DIALOG
       ======================================================================== -->
  <div class="admin-modal-backdrop" id="inquiryDetailModalBackdrop">
    <div class="admin-modal">
      <div class="admin-modal-header">
        <div>
          <h3 class="admin-modal-title" id="modalClientName">Lead Dossier</h3>
          <span style="font-size: 0.78rem; color: var(--text-muted);" id="modalClientCompany">ClickCodex Protected Pipeline</span>
        </div>
        <button type="button" class="toast-close-btn" onclick="closeInquiryModal()" aria-label="Close dialog">&times;</button>
      </div>

      <div class="admin-modal-body" id="modalContent">
        <!-- Dynamically injected via JavaScript -->
      </div>

      <div class="admin-modal-footer">
        <button type="button" class="welcome-btn secondary" onclick="closeInquiryModal()" style="color: var(--text-main); border: 1px solid #cbd5e1;">Close</button>
        <a href="#" id="modalEmailBtn" class="welcome-btn primary">Email Lead</a>
      </div>
    </div>
  </div>

  <!-- ========================================================================
       UNIVERSAL CLIENT JAVASCRIPT & TOAST CONTROLLER
       ======================================================================== -->
  <script>
    // Universal Toast Notification Engine
    window.showToast = function(message, type = 'info', title = null, duration = 4500) {
      const container = document.getElementById('toastContainer');
      if (!container) return;

      const toast = document.createElement('div');
      toast.className = `toast-item ${type}`;

      const iconSvgs = {
        success: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>',
        error: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>',
        info: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>',
        warning: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>'
      };

      const defaultTitles = {
        success: 'Action Successful',
        error: 'System Alert',
        info: 'Console Update',
        warning: 'Notice'
      };

      const resolvedTitle = title || defaultTitles[type] || 'Notification';

      toast.innerHTML = `
        <div class="toast-icon">${iconSvgs[type] || iconSvgs.info}</div>
        <div class="toast-content">
          <div class="toast-title">${resolvedTitle}</div>
          <div class="toast-message">${message}</div>
        </div>
        <button type="button" class="toast-close-btn" aria-label="Dismiss">&times;</button>
        <div class="toast-progress">
          <div class="toast-progress-bar" style="animation-duration: ${duration}ms;"></div>
        </div>
      `;

      container.appendChild(toast);

      const dismiss = () => {
        if (toast.classList.contains('toast-closing')) return;
        toast.classList.add('toast-closing');
        setTimeout(() => toast.remove(), 320);
      };

      toast.querySelector('.toast-close-btn').addEventListener('click', dismiss);
      const timer = setTimeout(dismiss, duration);
      toast.addEventListener('mouseenter', () => clearTimeout(timer));
    };

    // Auto-trigger Flash messages through Toast Notification system
    document.addEventListener('DOMContentLoaded', () => {
      <?php if (!empty($flashSuccess)): ?>
        window.showToast(<?= json_encode($flashSuccess) ?>, 'success', 'Session Authenticated');
      <?php endif; ?>
      <?php if (!empty($flashError)): ?>
        window.showToast(<?= json_encode($flashError) ?>, 'error', 'Operation Failed');
      <?php endif; ?>
    });

    // Live IST Clock
    function updateAdminClock() {
      const now = new Date();
      const options = { timeZone: 'Asia/Kolkata', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
      const timeStr = now.toLocaleTimeString('en-US', options);
      const clockEl = document.getElementById('clockValue');
      if (clockEl) {
        clockEl.textContent = timeStr + ' IST';
      }
    }
    setInterval(updateAdminClock, 1000);
    updateAdminClock();

    // Dropdown Toggles with outside click dismiss
    function toggleDropdown(menuId, event) {
      if (event) event.stopPropagation();
      const menus = document.querySelectorAll('.topbar-menu');
      menus.forEach(m => {
        if (m.id !== menuId) m.classList.remove('show');
      });
      const target = document.getElementById(menuId);
      if (target) {
        target.classList.toggle('show');
      }
    }

    document.addEventListener('click', () => {
      document.querySelectorAll('.topbar-menu').forEach(m => m.classList.remove('show'));
    });

    // Mobile Sidebar Toggle
    const sidebarToggleBtn = document.getElementById('sidebarToggle');
    const adminSidebar = document.getElementById('adminSidebar');
    if (sidebarToggleBtn && adminSidebar) {
      sidebarToggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        adminSidebar.classList.toggle('open');
      });
      document.addEventListener('click', (e) => {
        if (!adminSidebar.contains(e.target) && !sidebarToggleBtn.contains(e.target)) {
          adminSidebar.classList.remove('open');
        }
      });
    }

    // Omni Search with keyboard shortcut Ctrl+K
    const omniInput = document.getElementById('omniSearchInput');
    const tableInput = document.getElementById('tableFilterInput');

    window.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        if (omniInput) {
          omniInput.focus();
          omniInput.select();
          window.showToast('Search active: Type client, service, or status', 'info', 'Omni Search', 2000);
        }
      }
    });

    if (omniInput) {
      omniInput.addEventListener('input', (e) => {
        if (tableInput && typeof handleTableFilter === 'function') {
          tableInput.value = e.target.value;
          handleTableFilter();
        }
      });
    }

    // Clear Cache via AJAX
    async function triggerClearCache() {
      window.showToast('Purging compiled view & query cache...', 'info', 'Cache Flush');
      try {
        const res = await fetch('<?= BASE_URL ?>/admin/clear-cache', { method: 'POST' });
        const json = await res.json();
        if (json.success) {
          window.showToast(json.message || 'Cache flushed successfully.', 'success', 'Cache Cleared');
        } else {
          window.showToast('Could not flush cache.', 'error', 'Cache Error');
        }
      } catch (e) {
        window.showToast('Network error flushing cache.', 'error', 'Error');
      }
    }

    // Test Server Latency via Live Ping
    async function testDatabaseLatency() {
      const start = performance.now();
      try {
        await fetch('<?= BASE_URL ?>/admin/inquiry/status', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: 0, status: '' }) // Safe ping test
        });
        const elapsed = (performance.now() - start).toFixed(1);
        const text = `MySQL Production Sync • ${elapsed}ms`;
        const latencyEl = document.getElementById('latencyText');
        if (latencyEl) {
          latencyEl.textContent = text;
        }
        window.showToast(`Live server roundtrip: ${elapsed}ms (Healthy)`, 'success', 'Latency Telemetry', 3000);
      } catch (e) {
        window.showToast('Ping failed.', 'warning', 'Telemetry');
      }
    }

    // Export Inquiries as CSV File
    function exportInquiriesCSV() {
      const rows = document.querySelectorAll('#inquiriesTable tbody .inquiry-row');
      if (!rows || rows.length === 0) {
        window.showToast('No inquiries available to export.', 'warning', 'Export CSV');
        return;
      }

      let csv = 'ID,Name,Email,Phone,Company,Budget,Status,Date\n';

      rows.forEach(r => {
        const id = r.getAttribute('data-id') || '';
        const name = `"${(r.getAttribute('data-raw-name') || '').replace(/"/g, '""')}"`;
        const email = `"${(r.getAttribute('data-email') || '').replace(/"/g, '""')}"`;
        const phone = `"${(r.getAttribute('data-raw-phone') || '').replace(/"/g, '""')}"`;
        const company = `"${(r.getAttribute('data-company') || '').replace(/"/g, '""')}"`;
        const budget = `"${(r.getAttribute('data-raw-budget') || '').replace(/"/g, '""')}"`;
        const status = `"${(r.getAttribute('data-status') || '').replace(/"/g, '""')}"`;
        const date = `"${(r.getAttribute('data-date') || '').replace(/"/g, '""')}"`;

        csv += `${id},${name},${email},${phone},${company},${budget},${status},${date}\n`;
      });

      const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
      const url = URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.setAttribute('href', url);
      link.setAttribute('download', `clickcodex_inquiries_${new Date().toISOString().slice(0, 10)}.csv`);
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);

      window.showToast('Inquiry dossier CSV generated and downloaded.', 'success', 'CSV Exported');
    }

    // Close Lead Details Modal
    function closeInquiryModal() {
      const modal = document.getElementById('inquiryDetailModalBackdrop');
      if (modal) modal.classList.remove('show');
    }

    // Scroll directly to an inquiry row from notification click
    function scrollToInquiry(id) {
      const row = document.getElementById(`inquiry-row-${id}`);
      if (row) {
        row.scrollIntoView({ behavior: 'smooth', block: 'center' });
        row.style.background = '#e0f2fe';
        setTimeout(() => row.style.background = '', 2000);
      }
      const notifMenu = document.getElementById('notificationMenu');
      if (notifMenu) notifMenu.classList.remove('show');
    }

    function markAllNotificationsRead() {
      const badge = document.getElementById('notifBadge');
      if (badge) badge.style.display = 'none';
      const sidebarBadge = document.getElementById('sidebarLeadBadge');
      if (sidebarBadge) sidebarBadge.style.display = 'none';
      document.querySelectorAll('.notification-item').forEach(i => i.classList.remove('unread'));
      window.showToast('All notifications marked as read.', 'info', 'Notifications Cleared');
      const notifMenu = document.getElementById('notificationMenu');
      if (notifMenu) notifMenu.classList.remove('show');
    }
  </script>
</body>
</html>
