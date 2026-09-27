<?php
/**
 * ClickCodex Technologies - Admin Authentication Portal
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($pageTitle ?? 'Admin Console | ClickCodex') ?></title>
  <meta name="robots" content="noindex, nofollow" />

  <!-- Google Fonts: Open Sans, Space Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet" />

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/assets/images/logo.png" />

  <!-- Admin Stylesheet -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/admin.css" />

</head>
<body class="login-body">

  <div class="login-card">
    <!-- Header -->
    <div class="login-header">
      <div class="login-brand-logo">
        <img src="<?= BASE_URL ?>/public/assets/images/logo.png" alt="ClickCodex" />
        <div style="text-align: left;">
          <div class="login-brand-title">Click<span>codex</span></div>
          <span style="font-family: var(--font-mono); font-size: 0.65rem; color: var(--admin-cyan); letter-spacing: 1.5px; text-transform: uppercase;">Studio Console</span>
        </div>
      </div>

      <div class="login-security-pill">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        <span>Restricted Access • 256-Bit SSL</span>
      </div>

      <h1 class="login-title">Administrator Login</h1>
      <p class="login-subtitle">Enter your authorized administrative credentials to manage client inquiries, services, and digital assets.</p>
    </div>

    <!-- Floating Toast Container -->
    <div id="toastContainer" class="toast-container" aria-live="polite"></div>

    <!-- Login Form -->
    <form action="<?= BASE_URL ?>/admin/login" method="POST" id="adminLoginForm">
      <div class="login-form-group">
        <label for="adminEmail">Administrative Email Address</label>
        <div class="login-input-wrap">
          <svg class="login-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          <input type="email" id="adminEmail" name="email" class="login-input" placeholder="admin@clickcodex.com" required autofocus />
        </div>
      </div>

      <div class="login-form-group">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
          <label for="adminPassword" style="margin-bottom: 0;">Password</label>
          <button type="button" onclick="togglePasswordVisibility()" style="font-size: 0.75rem; color: var(--admin-cyan); font-family: var(--font-mono);" id="togglePassBtn">
            Show
          </button>
        </div>
        <div class="login-input-wrap">
          <svg class="login-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
          <input type="password" id="adminPassword" name="password" class="login-input" placeholder="••••••••••••" required />
        </div>
      </div>

      <button type="submit" class="login-btn" id="loginSubmitBtn">
        <span>Sign In to Console</span>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </button>
    </form>

    <!-- 1-Click Credentials Auto-Fill Box -->
    <div class="login-hint-box">
      <div>
        <span>Demo Credentials: </span>
        <code>admin@clickcodex.com</code> / <code>admin123</code>
      </div>
      <button type="button" class="login-fill-btn" onclick="fillDemoCredentials()">Auto-Fill</button>
    </div>

    <div style="text-align: center; margin-top: 24px;">
      <a href="<?= BASE_URL ?>/" style="font-size: 0.85rem; color: var(--text-light); transition: color 0.2s ease;">
        ← Back to Live Website
      </a>
    </div>
  </div>

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
        success: 'Operation Successful',
        error: 'Authentication Error',
        info: 'System Information',
        warning: 'Security Notice'
      };

      const resolvedTitle = title || defaultTitles[type] || 'Notice';

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

    // Auto-trigger Flash messages via Toast
    document.addEventListener('DOMContentLoaded', () => {
      <?php if (!empty($error)): ?>
        window.showToast(<?= json_encode($error) ?>, 'error', 'Sign In Failed');
      <?php endif; ?>
      <?php if (!empty($success)): ?>
        window.showToast(<?= json_encode($success) ?>, 'success', 'Session Update');
      <?php endif; ?>
    });

    function togglePasswordVisibility() {
      const input = document.getElementById('adminPassword');
      const btn = document.getElementById('togglePassBtn');
      if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = 'Hide';
      } else {
        input.type = 'password';
        btn.textContent = 'Show';
      }
    }

    function fillDemoCredentials() {
      document.getElementById('adminEmail').value = 'admin@clickcodex.com';
      document.getElementById('adminPassword').value = 'admin123';
      window.showToast('Demo administrative credentials filled.', 'info', 'Auto-Fill Ready', 2500);
    }
  </script>
</body>
</html>
