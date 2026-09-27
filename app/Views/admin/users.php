<?php
/**
 * ClickCodex Technologies - Admin User Management & RBAC Console
 * Enterprise Role-Based Access Control, Operator Provisioning, and Security Auditing.
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

$pageTitle = $pageTitle ?? 'User Management & Role-Based Access Control | ClickCodex Studio Console';
$topbarTitle = 'User Management & Access Control';
$activeNav = 'users';

include __DIR__ . '/layout/header.php';
?>

<!-- ========================================================================
     USER MANAGEMENT & RBAC STYLES (OPEN SANS UNIFIED)
     ======================================================================== -->
<style>
:root {
  --usr-primary: #0056d6;
  --usr-primary-glow: rgba(0, 86, 214, 0.25);
  --usr-purple: #8b5cf6;
  --usr-purple-glow: rgba(139, 92, 246, 0.25);
  --usr-emerald: #10b981;
  --usr-emerald-glow: rgba(16, 185, 129, 0.25);
  --usr-amber: #f59e0b;
  --usr-cyan: #00a2ff;
  --usr-red: #ef4444;
  --usr-card-border: #e2e8f0;
}

/* Base Font & Container Standard */
.admin-content, .usr-admin-content, .usr-hero-banner, .crm-modal-card {
  font-family: 'Open Sans', var(--font-body), sans-serif;
}

.usr-admin-content {
  max-width: 1440px;
  margin: 0 auto;
  padding: 32px;
  width: 100%;
  box-sizing: border-box;
}

/* 1. Header Command Banner */
.usr-hero-banner {
  background: linear-gradient(135deg, #090d16 0%, #15162c 50%, #0f172a 100%);
  border-radius: 18px;
  padding: 26px 30px;
  margin-bottom: 24px;
  color: #ffffff;
  position: relative;
  overflow: hidden;
  box-shadow: 0 10px 30px -5px rgba(9, 13, 22, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.08);
}
.usr-hero-banner::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 380px;
  height: 380px;
  background: radial-gradient(circle, rgba(139, 92, 246, 0.2) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.usr-hero-banner::after {
  content: '';
  position: absolute;
  bottom: -40%;
  left: 20%;
  width: 300px;
  height: 300px;
  background: radial-gradient(circle, rgba(0, 162, 255, 0.14) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.usr-badge-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 12px;
  background: rgba(139, 92, 246, 0.15);
  border: 1px solid rgba(139, 92, 246, 0.35);
  border-radius: 9999px;
  font-family: var(--font-mono, monospace);
  font-size: 0.72rem;
  font-weight: 700;
  color: #c4b5fd;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  margin-bottom: 10px;
}
.usr-pulse-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #10b981;
  box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
  animation: usrPulse 2s infinite;
}
@keyframes usrPulse {
  0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
  70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
  100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}
.usr-title-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
  position: relative;
  z-index: 2;
}
.usr-hero-title {
  font-family: var(--font-display, 'Open Sans', sans-serif);
  font-size: clamp(1.3rem, 2.5vw, 1.65rem);
  font-weight: 800;
  color: #ffffff;
  letter-spacing: -0.5px;
  margin: 0;
  line-height: 1.25;
}
.usr-hero-title span {
  background: linear-gradient(135deg, #a78bfa 0%, #38bdf8 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.usr-hero-desc {
  color: #cbd5e1;
  font-size: clamp(0.82rem, 1.2vw, 0.88rem);
  line-height: 1.55;
  margin: 6px 0 0;
  max-width: 720px;
}
.usr-actions-wrap {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}
.usr-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 18px;
  border-radius: 10px;
  font-size: 0.84rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  text-decoration: none;
  border: none;
  outline: none;
  white-space: nowrap;
}
.usr-btn-primary {
  background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
  color: #ffffff;
  box-shadow: 0 4px 14px var(--usr-purple-glow);
}
.usr-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(109, 40, 217, 0.4);
  color: #ffffff;
}
.usr-btn-glass {
  background: rgba(255, 255, 255, 0.1);
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(8px);
}
.usr-btn-glass:hover {
  background: rgba(255, 255, 255, 0.2);
  color: #ffffff;
}

/* 2. Executive KPI Summary Cards */
.usr-kpi-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}
.usr-kpi-card {
  background: #ffffff;
  border: 1px solid var(--usr-card-border);
  border-radius: 14px;
  padding: 18px 20px;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
  transition: all 0.2s ease;
  position: relative;
  overflow: hidden;
  cursor: pointer;
}
.usr-kpi-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
  border-color: #cbd5e1;
}
.usr-kpi-card.purple::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--usr-purple); }
.usr-kpi-card.green::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--usr-emerald); }
.usr-kpi-card.amber::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--usr-amber); }
.usr-kpi-card.cyan::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--usr-cyan); }
.usr-kpi-card.red::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--usr-red); }

.usr-kpi-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
.usr-kpi-label {
  font-size: 0.74rem;
  font-family: var(--font-mono, monospace);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  color: #64748b;
}
.usr-kpi-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.usr-kpi-val {
  font-size: 1.85rem;
  font-weight: 800;
  color: #0f172a;
  line-height: 1;
  letter-spacing: -0.5px;
}
.usr-kpi-sub {
  font-size: 0.74rem;
  color: #94a3b8;
  margin-top: 6px;
}
.usr-kpi-sub strong {
  color: #475569;
}

/* 3. Role Filter Pill Strip */
.usr-filter-bar {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 20px;
  overflow-x: auto;
  padding-bottom: 4px;
}
.usr-filter-pill {
  padding: 8px 16px;
  border-radius: 9999px;
  background: #ffffff;
  border: 1px solid var(--usr-card-border);
  font-size: 0.82rem;
  font-weight: 700;
  color: #475569;
  cursor: pointer;
  transition: all 0.15s ease;
  white-space: nowrap;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}
.usr-filter-pill:hover {
  background: #f8fafc;
  color: #0f172a;
  border-color: #cbd5e1;
}
.usr-filter-pill.active {
  background: #8b5cf6;
  color: #ffffff;
  border-color: #8b5cf6;
  box-shadow: 0 4px 12px var(--usr-purple-glow);
}
.usr-filter-pill .pill-cnt {
  background: rgba(0, 0, 0, 0.08);
  font-size: 0.72rem;
  padding: 2px 7px;
  border-radius: 9999px;
  font-family: var(--font-mono, monospace);
}
.usr-filter-pill.active .pill-cnt {
  background: rgba(255, 255, 255, 0.25);
  color: #ffffff;
}

/* 4. Command Toolbar */
.usr-toolbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}
.usr-search-wrap {
  position: relative;
  flex: 1 1 300px;
  max-width: 440px;
}
.usr-search-icon {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  pointer-events: none;
}
.usr-search-input {
  width: 100%;
  height: 42px;
  padding: 8px 42px 8px 38px;
  border-radius: 10px;
  border: 1px solid var(--usr-card-border);
  background: #ffffff;
  font-size: 0.85rem;
  color: #0f172a;
  transition: all 0.2s ease;
  box-sizing: border-box;
}
.usr-search-input:focus {
  outline: none;
  border-color: #8b5cf6;
  box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
}
.usr-search-kbd {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  background: #f1f5f9;
  border: 1px solid #cbd5e1;
  border-radius: 5px;
  padding: 1px 6px;
  font-size: 0.72rem;
  font-family: var(--font-mono, monospace);
  color: #64748b;
  pointer-events: none;
}
.usr-toolbar-controls {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}
.usr-select {
  height: 42px;
  padding: 8px 14px;
  border-radius: 10px;
  border: 1px solid var(--usr-card-border);
  background: #ffffff;
  font-size: 0.84rem;
  font-weight: 600;
  color: #334155;
  cursor: pointer;
  outline: none;
  transition: all 0.2s ease;
}
.usr-select:focus {
  border-color: #8b5cf6;
  box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
}

/* Dual-View Switcher */
.usr-view-switch {
  display: inline-flex;
  background: #f1f5f9;
  padding: 3px;
  border-radius: 10px;
  border: 1px solid var(--usr-card-border);
}
.usr-view-btn {
  padding: 7px 12px;
  border-radius: 7px;
  border: none;
  background: transparent;
  color: #64748b;
  font-size: 0.8rem;
  font-weight: 700;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.15s ease;
}
.usr-view-btn.active {
  background: #ffffff;
  color: #0f172a;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}

/* 5. Enterprise Data Table View */
.usr-table-card {
  background: #ffffff;
  border: 1px solid var(--usr-card-border);
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
  overflow: hidden;
  margin-bottom: 24px;
}
.usr-table-wrap {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
.usr-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  min-width: 820px;
}
.usr-table thead th {
  background: #f8fafc;
  padding: 13px 18px;
  font-size: 0.74rem;
  font-family: var(--font-mono, monospace);
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  color: #64748b;
  border-bottom: 1px solid #e2e8f0;
  white-space: nowrap;
}
.usr-table tbody td {
  padding: 14px 18px;
  border-bottom: 1px solid #f1f5f9;
  font-size: 0.85rem;
  color: #334155;
  vertical-align: middle;
}
.usr-table tbody tr:hover td {
  background: #fbfcfe;
}

/* Operator Cell Styling */
.usr-operator-cell {
  display: flex;
  align-items: center;
  gap: 12px;
}
.usr-avatar-wrap {
  width: 40px;
  height: 40px;
  min-width: 40px;
  min-height: 40px;
  border-radius: 50%;
  overflow: hidden;
  position: relative;
  background: #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 0.85rem;
  color: #475569;
  border: 2px solid #ffffff;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}
.usr-avatar-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.usr-operator-info {
  display: flex;
  flex-direction: column;
}
.usr-operator-name {
  font-weight: 700;
  color: #0f172a;
  text-decoration: none;
  font-size: 0.88rem;
  cursor: pointer;
  transition: color 0.15s ease;
}
.usr-operator-name:hover {
  color: #8b5cf6;
}
.usr-operator-email {
  font-size: 0.76rem;
  color: #64748b;
  font-family: var(--font-mono, monospace);
}

/* Role Badges */
.usr-role-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 3px 10px;
  border-radius: 9999px;
  font-size: 0.72rem;
  font-weight: 800;
  letter-spacing: 0.4px;
  text-transform: uppercase;
}
.usr-role-badge.super_admin {
  background: rgba(139, 92, 246, 0.12);
  color: #7c3aed;
  border: 1px solid rgba(139, 92, 246, 0.3);
}
.usr-role-badge.admin {
  background: rgba(0, 86, 214, 0.1);
  color: #0056d6;
  border: 1px solid rgba(0, 86, 214, 0.25);
}
.usr-role-badge.editor {
  background: rgba(16, 185, 129, 0.12);
  color: #059669;
  border: 1px solid rgba(16, 185, 129, 0.25);
}
.usr-role-badge.seo_specialist {
  background: rgba(0, 162, 255, 0.12);
  color: #0284c7;
  border: 1px solid rgba(0, 162, 255, 0.25);
}

/* Interactive Status Switch */
.usr-toggle-switch {
  position: relative;
  display: inline-block;
  width: 38px;
  height: 22px;
}
.usr-toggle-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.usr-toggle-slider {
  position: absolute;
  cursor: pointer;
  inset: 0;
  background-color: #cbd5e1;
  transition: 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  border-radius: 22px;
}
.usr-toggle-slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  border-radius: 50%;
  box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}
.usr-toggle-switch input:checked + .usr-toggle-slider {
  background-color: #10b981;
}
.usr-toggle-switch input:checked + .usr-toggle-slider:before {
  transform: translateX(16px);
}

/* Action Control Buttons */
.usr-action-btn-group {
  display: flex;
  align-items: center;
  gap: 6px;
}
.usr-action-btn {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #e2e8f0;
  background: #ffffff;
  color: #64748b;
  cursor: pointer;
  transition: all 0.15s ease;
}
.usr-action-btn:hover {
  background: #f1f5f9;
  color: #0f172a;
  border-color: #cbd5e1;
}
.usr-action-btn.delete:hover {
  background: #fee2e2;
  color: #dc2626;
  border-color: #fca5a5;
}

/* 6. Directory Cards Grid View */
.usr-cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}
.usr-card {
  background: #ffffff;
  border: 1px solid var(--usr-card-border);
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  display: flex;
  flex-direction: column;
}
.usr-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 28px rgba(15, 23, 42, 0.09);
  border-color: #cbd5e1;
}
.usr-card-header {
  height: 72px;
  background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
  position: relative;
  padding: 12px 16px;
  display: flex;
  justify-content: flex-end;
}
.usr-card-avatar-wrap {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  border: 3px solid #ffffff;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  position: absolute;
  left: 20px;
  bottom: -28px;
  background: #e2e8f0;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  color: #475569;
}
.usr-card-body {
  padding: 38px 20px 18px;
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
}
.usr-card-name {
  font-size: 1.05rem;
  font-weight: 800;
  color: #0f172a;
  margin: 0 0 2px;
  cursor: pointer;
}
.usr-card-name:hover {
  color: #8b5cf6;
}
.usr-card-email {
  font-size: 0.78rem;
  color: #64748b;
  font-family: var(--font-mono, monospace);
  margin-bottom: 12px;
}
.usr-card-meta-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 0;
  border-top: 1px solid #f1f5f9;
  font-size: 0.78rem;
  color: #64748b;
}
.usr-card-meta-row strong {
  color: #1e293b;
}
.usr-card-footer {
  padding: 12px 20px;
  background: #f8fafc;
  border-top: 1px solid #f1f5f9;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* ========================================================================
   MODAL DIALOGS (BULLETPROOF CENTERING, SKELETONS & BLURRED BACKDROP)
   ======================================================================== */
.crm-modal-backdrop {
  position: fixed !important;
  top: 0 !important;
  left: 0 !important;
  right: 0 !important;
  bottom: 0 !important;
  width: 100vw !important;
  height: 100vh !important;
  background: rgba(9, 13, 22, 0.82) !important;
  backdrop-filter: blur(10px) !important;
  -webkit-backdrop-filter: blur(10px) !important;
  z-index: 999999 !important;
  display: none;
  align-items: center !important;
  justify-content: center !important;
  padding: clamp(12px, 3vw, 24px) !important;
  box-sizing: border-box !important;
  overflow-y: auto !important;
}
.crm-modal-backdrop.show {
  display: flex !important;
  animation: crmBackdropFade 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes crmBackdropFade {
  from { opacity: 0; }
  to { opacity: 1; }
}
.crm-modal-card {
  background: #ffffff !important;
  border-radius: 20px !important;
  width: 100% !important;
  max-width: 820px !important;
  max-height: min(92vh, 880px) !important;
  display: flex !important;
  flex-direction: column !important;
  box-shadow: 0 25px 60px -10px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.2) !important;
  position: relative !important;
  overflow: hidden !important;
  margin: auto !important;
  animation: crmCardScale 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  box-sizing: border-box !important;
}
.crm-modal-form {
  display: flex !important;
  flex-direction: column !important;
  flex: 1 1 auto !important;
  min-height: 0 !important;
  overflow: hidden !important;
  margin: 0 !important;
}
@keyframes crmCardScale {
  from { opacity: 0; transform: scale(0.96) translateY(12px); }
  to { opacity: 1; transform: scale(1) translateY(0); }
}
@keyframes crmSpinner {
  to { transform: rotate(360deg); }
}

.crm-modal-header {
  padding: clamp(14px, 2.5vw, 20px) clamp(16px, 3vw, 26px);
  background: #ffffff;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: sticky;
  top: 0;
  z-index: 10;
  gap: 12px;
  flex-shrink: 0;
}
.crm-modal-title {
  font-family: var(--font-display, 'Open Sans', sans-serif);
  font-size: clamp(1.1rem, 2.5vw, 1.25rem);
  font-weight: 800;
  color: #0f172a;
  margin: 0;
  line-height: 1.3;
}
.crm-modal-subtitle {
  font-size: 0.8rem;
  color: #64748b;
  margin-top: 3px;
}
.crm-modal-close {
  width: 34px;
  height: 34px;
  border-radius: 9px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f1f5f9;
  color: #475569;
  border: 1px solid #e2e8f0;
  cursor: pointer;
  font-size: 0.95rem;
  font-weight: 700;
  transition: all 0.15s ease;
  flex-shrink: 0;
}
.crm-modal-close:hover {
  background: #e2e8f0;
  color: #0f172a;
}
.crm-modal-body {
  padding: clamp(16px, 3vw, 26px);
  overflow-y: auto;
  flex: 1 1 auto;
  min-height: 0;
  box-sizing: border-box;
}
.crm-modal-body::-webkit-scrollbar {
  width: 6px;
}
.crm-modal-body::-webkit-scrollbar-track {
  background: #f8fafc;
}
.crm-modal-body::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}
.crm-modal-footer {
  padding: clamp(12px, 2vw, 18px) clamp(16px, 3vw, 26px);
  background: #ffffff;
  border-top: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 10px;
  flex-wrap: wrap;
  position: sticky;
  bottom: 0;
  z-index: 10;
  flex-shrink: 0;
}

/* Dedicated Form Controls */
.crm-form-group {
  margin-bottom: 14px;
}
.crm-form-group label {
  display: block;
  font-size: 0.84rem;
  font-weight: 700;
  color: #0f172a;
  margin-bottom: 6px;
}
.crm-form-input, .crm-form-select {
  width: 100%;
  height: 42px;
  padding: 8px 14px;
  border: 1px solid #cbd5e1;
  border-radius: 9px;
  font-size: 0.86rem;
  color: #0f172a;
  background: #ffffff;
  transition: all 0.2s ease;
  box-sizing: border-box;
  font-family: inherit;
}
.crm-form-input:focus, .crm-form-select:focus {
  outline: none;
  border-color: #8b5cf6;
  box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
}

/* Form Responsive Grids */
.usr-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
  margin-bottom: 14px;
}
@media (max-width: 640px) {
  .usr-grid-2 {
    grid-template-columns: 1fr;
    gap: 12px;
  }
}

/* Dossier Modal Dark Header */
.usr-dossier-hero {
  background: linear-gradient(135deg, #090d16 0%, #1e1b4b 100%);
  color: #ffffff;
  padding: 24px 28px;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
}
.usr-dossier-glow {
  position: absolute;
  right: -50px;
  top: -50px;
  width: 220px;
  height: 220px;
  background: radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
</style>

<!-- ========================================================================
     MAIN VIEWPORT CONTAINER
     ======================================================================== -->
<div class="admin-content usr-admin-content">

  <!-- Flash Feedback Alerts -->
  <?php if (!empty($flashSuccess)): ?>
    <div class="admin-alert success" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #065f46; font-weight: 600; margin-bottom: 20px; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 10px;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
      <span><?= htmlspecialchars($flashSuccess) ?></span>
    </div>
  <?php endif; ?>

  <?php if (!empty($flashError)): ?>
    <div class="admin-alert error" style="background: rgba(220, 38, 38, 0.1); border: 1px solid rgba(220, 38, 38, 0.3); color: #991b1b; font-weight: 600; margin-bottom: 20px; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 10px;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
      <span><?= htmlspecialchars($flashError) ?></span>
    </div>
  <?php endif; ?>

  <!-- 1. EXECUTIVE HERO COMMAND BANNER -->
  <div class="usr-hero-banner">
    <div class="usr-title-row">
      <div>
        <div class="usr-badge-pill">
          <span class="usr-pulse-dot"></span>
          <span>RBAC DIRECTORY • PRODUCTION CONSOLE</span>
        </div>
        <h1 class="usr-hero-title">Team & <span>User Management</span></h1>
        <p class="usr-hero-desc">
          Enforce Role-Based Access Control, provision platform operators, review authentication telemetry, and inspect real-time security audit trails across ClickCodex Studio.
        </p>
      </div>

      <!-- Action Buttons -->
      <div class="usr-actions-wrap">
        <a href="<?= BASE_URL ?>/admin/users/export" class="usr-btn usr-btn-glass" title="Export Directory as CSV">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
          <span>Export CSV</span>
        </a>

        <button type="button" class="usr-btn usr-btn-primary" onclick="openCreateUserModal()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          <span>Provision New Operator</span>
        </button>
      </div>
    </div>
  </div>

  <!-- 2. INTERACTIVE EXECUTIVE KPI SUMMARY CARDS -->
  <div class="usr-kpi-row">
    <!-- KPI 1: Total Users -->
    <div class="usr-kpi-card purple" onclick="filterByRole('all')">
      <div class="usr-kpi-header">
        <span class="usr-kpi-label">TOTAL OPERATORS</span>
        <div class="usr-kpi-icon" style="background: rgba(139, 92, 246, 0.12); color: var(--usr-purple);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        </div>
      </div>
      <div class="usr-kpi-val" id="kpiTotalUsers"><?= (int)($userStats['total_users'] ?? count($users)) ?></div>
      <div class="usr-kpi-sub">
        <strong>All Team Members</strong> • Provisioned
      </div>
    </div>

    <!-- KPI 2: Active Operators -->
    <div class="usr-kpi-card green" onclick="filterByStatus('1')">
      <div class="usr-kpi-header">
        <span class="usr-kpi-label">ACTIVE OPERATORS</span>
        <div class="usr-kpi-icon" style="background: rgba(16, 185, 129, 0.12); color: var(--usr-emerald);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
      </div>
      <div class="usr-kpi-val" style="color: var(--usr-emerald);"><?= (int)($userStats['active_users'] ?? 0) ?></div>
      <div class="usr-kpi-sub">
        <strong>Enabled Accounts</strong> • Console Ready
      </div>
    </div>

    <!-- KPI 3: Super Admins -->
    <div class="usr-kpi-card amber" onclick="filterByRole('super_admin')">
      <div class="usr-kpi-header">
        <span class="usr-kpi-label">SUPER ADMINS</span>
        <div class="usr-kpi-icon" style="background: rgba(245, 158, 11, 0.12); color: var(--usr-amber);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        </div>
      </div>
      <div class="usr-kpi-val" style="color: var(--usr-amber);"><?= (int)($userStats['super_admins'] ?? 1) ?></div>
      <div class="usr-kpi-sub">
        <strong>Root Authority</strong> • Full Clearance
      </div>
    </div>

    <!-- KPI 4: Content & SEO Staff -->
    <div class="usr-kpi-card cyan" onclick="filterByRole('editor')">
      <div class="usr-kpi-header">
        <span class="usr-kpi-label">EDITORS & SEO</span>
        <div class="usr-kpi-icon" style="background: rgba(0, 162, 255, 0.12); color: var(--usr-cyan);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line></svg>
        </div>
      </div>
      <div class="usr-kpi-val" style="color: var(--usr-cyan);"><?= (int)(($userStats['editors'] ?? 0) + ($userStats['seo_specialists'] ?? 0)) ?></div>
      <div class="usr-kpi-sub">
        <strong>Domain Specialists</strong> • Content Leads
      </div>
    </div>

    <!-- KPI 5: Suspended / Locked -->
    <div class="usr-kpi-card red" onclick="filterByStatus('0')">
      <div class="usr-kpi-header">
        <span class="usr-kpi-label">SUSPENDED</span>
        <div class="usr-kpi-icon" style="background: rgba(239, 68, 68, 0.12); color: var(--usr-red);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
        </div>
      </div>
      <div class="usr-kpi-val" style="color: var(--usr-red);"><?= (int)($userStats['inactive_users'] ?? 0) ?></div>
      <div class="usr-kpi-sub">
        <strong>Locked Access</strong> • Inactive
      </div>
    </div>
  </div>

  <!-- 3. INTERACTIVE ROLE FILTER PILL STRIP -->
  <div class="usr-filter-bar">
    <button type="button" class="usr-filter-pill active" data-role="all" onclick="selectRolePill('all', this)">
      <span>All Roles</span>
      <span class="pill-cnt"><?= count($users) ?></span>
    </button>
    <button type="button" class="usr-filter-pill" data-role="super_admin" onclick="selectRolePill('super_admin', this)">
      <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#7c3aed;"></span>
      <span>Super Admins</span>
      <span class="pill-cnt"><?= (int)($userStats['super_admins'] ?? 1) ?></span>
    </button>
    <button type="button" class="usr-filter-pill" data-role="admin" onclick="selectRolePill('admin', this)">
      <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#0056d6;"></span>
      <span>Administrators</span>
      <span class="pill-cnt"><?= (int)($userStats['admins'] ?? 0) ?></span>
    </button>
    <button type="button" class="usr-filter-pill" data-role="editor" onclick="selectRolePill('editor', this)">
      <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#10b981;"></span>
      <span>Content Editors</span>
      <span class="pill-cnt"><?= (int)($userStats['editors'] ?? 0) ?></span>
    </button>
    <button type="button" class="usr-filter-pill" data-role="seo_specialist" onclick="selectRolePill('seo_specialist', this)">
      <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#0284c7;"></span>
      <span>SEO Specialists</span>
      <span class="pill-cnt"><?= (int)($userStats['seo_specialists'] ?? 0) ?></span>
    </button>
  </div>

  <!-- 4. COMMAND TOOLBAR: SEARCH & SELECTORS & VIEW SWITCHER -->
  <div class="usr-toolbar">
    <!-- Omni-Search Bar -->
    <div class="usr-search-wrap">
      <svg class="usr-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
      <input type="text" id="userSearchInput" class="usr-search-input" placeholder="Search operator name, email, phone, role..." oninput="handleUserSearch(this.value)" />
      <kbd class="usr-search-kbd">/</kbd>
    </div>

    <!-- Selectors & Dual-View Switcher -->
    <div class="usr-toolbar-controls">
      <!-- Role Filter -->
      <select id="roleSelect" class="usr-select" onchange="handleRoleFilter(this.value)">
        <option value="all">All Access Roles</option>
        <option value="super_admin">★ Super Admin</option>
        <option value="admin">● Administrator</option>
        <option value="editor">▲ Content Editor</option>
        <option value="seo_specialist">◆ SEO Specialist</option>
      </select>

      <!-- Status Filter -->
      <select id="statusSelect" class="usr-select" onchange="handleStatusFilter(this.value)">
        <option value="all">All Account Status</option>
        <option value="1">● Active Operators</option>
        <option value="0">○ Suspended / Inactive</option>
      </select>

      <!-- Dual-View Switcher: Table vs Cards -->
      <div class="usr-view-switch">
        <button type="button" class="usr-view-btn active" id="viewBtnTable" onclick="switchUserView('table')" title="Switch to Enterprise Table View">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
          <span>Table</span>
        </button>
        <button type="button" class="usr-view-btn" id="viewBtnCards" onclick="switchUserView('cards')" title="Switch to Directory Cards Grid">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
          <span>Cards</span>
        </button>
      </div>
    </div>
  </div>

  <!-- 5. VIEW A: ENTERPRISE DATA TABLE -->
  <div id="usersTableView" class="usr-table-card">
    <div class="usr-table-wrap">
      <table class="usr-table">
        <thead>
          <tr>
            <th>Operator Identity</th>
            <th>Access Role</th>
            <th style="text-align: center;">Account Status</th>
            <th>Last Active</th>
            <th>Provisioned</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody id="userTableBody">
          <?php if (empty($users)): ?>
            <tr>
              <td colspan="6" style="text-align: center; padding: 48px 20px; color: #64748b;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom: 10px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                <div style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">No Team Members Found</div>
                <div style="font-size: 0.8rem;">Adjust your filter criteria or click "Provision New Operator" to add team members.</div>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($users as $u): ?>
              <?php
                $isActive = (int)$u['is_active'] === 1;
                $isSelf = (int)$u['id'] === (int)($currentUser['id'] ?? 1);
              ?>
              <tr class="user-data-row" 
                  id="userRow-<?= (int)$u['id'] ?>"
                  data-id="<?= (int)$u['id'] ?>"
                  data-role="<?= htmlspecialchars($u['role']) ?>"
                  data-status="<?= $isActive ? '1' : '0' ?>"
                  data-name="<?= htmlspecialchars(strtolower($u['name'])) ?>"
                  data-email="<?= htmlspecialchars(strtolower($u['email'])) ?>"
                  data-phone="<?= htmlspecialchars(strtolower($u['phone'] ?? '')) ?>">
                
                <!-- Operator -->
                <td>
                  <div class="usr-operator-cell">
                    <div class="usr-avatar-wrap">
                      <?php if (!empty($u['avatar_url'])): ?>
                        <img src="<?= htmlspecialchars($u['avatar_url']) ?>" alt="<?= htmlspecialchars($u['name']) ?>" class="usr-avatar-img" />
                      <?php else: ?>
                        <span><?= htmlspecialchars($u['initials']) ?></span>
                      <?php endif; ?>
                    </div>
                    <div class="usr-operator-info">
                      <span class="usr-operator-name" id="userTableName-<?= (int)$u['id'] ?>" onclick="viewUserDossier(<?= (int)$u['id'] ?>)">
                        <?= htmlspecialchars($u['name']) ?>
                        <?php if ($isSelf): ?>
                          <span style="background: rgba(139, 92, 246, 0.12); color: #7c3aed; font-size: 0.65rem; padding: 1px 6px; border-radius: 4px; font-weight: 800; margin-left: 4px;">YOU</span>
                        <?php endif; ?>
                      </span>
                      <span class="usr-operator-email"><?= htmlspecialchars($u['email']) ?></span>
                      <?php if (!empty($u['phone'])): ?>
                        <span style="font-size: 0.7rem; color: #94a3b8;"><?= htmlspecialchars($u['phone']) ?></span>
                      <?php endif; ?>
                    </div>
                  </div>
                </td>

                <!-- Role -->
                <td>
                  <span class="usr-role-badge <?= htmlspecialchars($u['role']) ?>">
                    <?= htmlspecialchars($u['role_label']) ?>
                  </span>
                </td>

                <!-- Status Toggle -->
                <td style="text-align: center;">
                  <label class="usr-toggle-switch" title="<?= $isSelf ? 'Cannot disable current session account' : 'Toggle Active / Suspended Status' ?>">
                    <input type="checkbox" 
                           id="tableStatusToggle-<?= (int)$u['id'] ?>" 
                           <?= $isActive ? 'checked' : '' ?> 
                           <?= $isSelf ? 'disabled' : '' ?>
                           onchange="toggleUserStatusAjax(<?= (int)$u['id'] ?>, this.checked)" />
                    <span class="usr-toggle-slider" style="<?= $isSelf ? 'opacity: 0.6; cursor: not-allowed;' : '' ?>"></span>
                  </label>
                </td>

                <!-- Last Active -->
                <td>
                  <div style="font-weight: 600; color: #0f172a; font-size: 0.82rem;"><?= htmlspecialchars($u['last_login_human']) ?></div>
                  <div style="font-size: 0.72rem; color: #94a3b8;"><?= !empty($u['last_login_at']) ? date('M d, Y H:i', strtotime($u['last_login_at'])) : 'Never active' ?></div>
                </td>

                <!-- Provisioned -->
                <td>
                  <div style="font-size: 0.8rem; color: #475569;"><?= date('M d, Y', strtotime($u['created_at'])) ?></div>
                  <div style="font-size: 0.7rem; color: #94a3b8; font-family: var(--font-mono, monospace);">ID: #<?= (int)$u['id'] ?></div>
                </td>

                <!-- Actions -->
                <td style="text-align: right;">
                  <div class="usr-action-btn-group" style="justify-content: flex-end;">
                    <!-- View Dossier -->
                    <button type="button" class="usr-action-btn" onclick="viewUserDossier(<?= (int)$u['id'] ?>)" title="Security Profile & Audit Dossier">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>

                    <!-- Edit User -->
                    <button type="button" class="usr-action-btn" onclick="editUser(<?= (int)$u['id'] ?>)" title="Edit Operator Profile">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>

                    <!-- Reset Password -->
                    <button type="button" class="usr-action-btn" onclick="openResetPasswordModal(<?= (int)$u['id'] ?>)" title="Reset Access Passphrase">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    </button>

                    <!-- Delete User -->
                    <button type="button" class="usr-action-btn delete" onclick="confirmDeleteUser(<?= (int)$u['id'] ?>)" title="Delete Account" <?= $isSelf ? 'disabled style="opacity:0.4; cursor:not-allowed;"' : '' ?>>
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- 6. VIEW B: DIRECTORY CARDS GRID -->
  <div id="usersCardsView" class="usr-cards-grid" style="display: none;">
    <?php foreach ($users as $u): ?>
      <?php
        $isActive = (int)$u['is_active'] === 1;
        $isSelf = (int)$u['id'] === (int)($currentUser['id'] ?? 1);
      ?>
      <div id="userCard-<?= (int)$u['id'] ?>" 
           class="usr-card user-card-item"
           data-id="<?= (int)$u['id'] ?>"
           data-role="<?= htmlspecialchars($u['role']) ?>"
           data-status="<?= $isActive ? '1' : '0' ?>"
           data-name="<?= htmlspecialchars(strtolower($u['name'])) ?>"
           data-email="<?= htmlspecialchars(strtolower($u['email'])) ?>"
           data-phone="<?= htmlspecialchars(strtolower($u['phone'] ?? '')) ?>">
        
        <!-- Header Banner with Avatar -->
        <div class="usr-card-header">
          <span class="usr-role-badge <?= htmlspecialchars($u['role']) ?>" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(4px);">
            <?= htmlspecialchars($u['role_label']) ?>
          </span>
          <div class="usr-card-avatar-wrap">
            <?php if (!empty($u['avatar_url'])): ?>
              <img src="<?= htmlspecialchars($u['avatar_url']) ?>" alt="<?= htmlspecialchars($u['name']) ?>" class="usr-avatar-img" />
            <?php else: ?>
              <span><?= htmlspecialchars($u['initials']) ?></span>
            <?php endif; ?>
          </div>
        </div>

        <!-- Card Body -->
        <div class="usr-card-body">
          <h3 class="usr-card-name" id="userCardName-<?= (int)$u['id'] ?>" onclick="viewUserDossier(<?= (int)$u['id'] ?>)">
            <?= htmlspecialchars($u['name']) ?>
            <?php if ($isSelf): ?>
              <span style="background: rgba(139, 92, 246, 0.12); color: #7c3aed; font-size: 0.65rem; padding: 1px 6px; border-radius: 4px; font-weight: 800; margin-left: 4px;">YOU</span>
            <?php endif; ?>
          </h3>
          <div class="usr-card-email"><?= htmlspecialchars($u['email']) ?></div>

          <div class="usr-card-meta-row">
            <span>Contact Phone:</span>
            <strong><?= htmlspecialchars($u['phone'] ?: 'None registered') ?></strong>
          </div>

          <div class="usr-card-meta-row">
            <span>Last Activity:</span>
            <strong><?= htmlspecialchars($u['last_login_human']) ?></strong>
          </div>

          <div class="usr-card-meta-row">
            <span>Account Status:</span>
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 0.72rem; font-weight: 700; color: <?= $isActive ? '#059669' : '#dc2626' ?>;">
                <?= $isActive ? '● Active' : '○ Suspended' ?>
              </span>
              <label class="usr-toggle-switch" style="transform: scale(0.85);" title="<?= $isSelf ? 'Cannot disable current session account' : 'Toggle status' ?>">
                <input type="checkbox" 
                       id="cardStatusToggle-<?= (int)$u['id'] ?>" 
                       <?= $isActive ? 'checked' : '' ?> 
                       <?= $isSelf ? 'disabled' : '' ?>
                       onchange="toggleUserStatusAjax(<?= (int)$u['id'] ?>, this.checked)" />
                <span class="usr-toggle-slider" style="<?= $isSelf ? 'opacity: 0.6; cursor: not-allowed;' : '' ?>"></span>
              </label>
            </div>
          </div>
        </div>

        <!-- Card Footer -->
        <div class="usr-card-footer">
          <button type="button" class="usr-btn" onclick="viewUserDossier(<?= (int)$u['id'] ?>)" style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; padding: 6px 12px; font-size: 0.76rem;">
            <span>Audit Dossier</span>
          </button>

          <div style="display: flex; gap: 6px;">
            <button type="button" class="usr-action-btn" onclick="editUser(<?= (int)$u['id'] ?>)" title="Edit Profile">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            </button>
            <button type="button" class="usr-action-btn" onclick="openResetPasswordModal(<?= (int)$u['id'] ?>)" title="Reset Password">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            </button>
            <button type="button" class="usr-action-btn delete" onclick="confirmDeleteUser(<?= (int)$u['id'] ?>)" title="Delete User" <?= $isSelf ? 'disabled style="opacity:0.4; cursor:not-allowed;"' : '' ?>>
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div><!-- /admin-content -->


<!-- ========================================================================
     MODAL 1: USER DOSSIER & SECURITY AUDIT (POPUP DIALOG)
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="viewUserModalBackdrop" style="display: none;" onclick="closeViewUserModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 820px;" onclick="event.stopPropagation()">
    
    <!-- Hero Header -->
    <div class="usr-dossier-hero">
      <div class="usr-dossier-glow"></div>
      <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; position: relative; z-index: 2;">
        <div style="display: flex; gap: 16px; align-items: center;">
          <div style="width: 58px; height: 58px; border-radius: 50%; overflow: hidden; background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <img id="viewUserAvatar" src="" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; display: none;" />
            <span id="viewUserInitials" style="font-weight: 800; font-size: 1.3rem; color: #ffffff;">CC</span>
          </div>
          <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
              <span id="viewUserRoleBadge" class="usr-role-badge super_admin" style="background: rgba(139, 92, 246, 0.25); color: #c4b5fd; border-color: rgba(139, 92, 246, 0.4);">
                SUPER ADMIN
              </span>
              <span id="viewUserStatusPill" style="font-size: 0.72rem; font-weight: 700; padding: 2px 8px; border-radius: 4px; background: rgba(16, 185, 129, 0.25); color: #34d399;">
                ● ACTIVE
              </span>
            </div>
            <h2 id="viewUserName" style="font-size: 1.35rem; font-weight: 800; margin: 0; color: #ffffff;">
              User Name
            </h2>
            <div id="viewUserEmail" style="font-size: 0.82rem; color: #cbd5e1; font-family: var(--font-mono, monospace); margin-top: 2px;">
              user@clickcodex.com
            </div>
          </div>
        </div>

        <button type="button" class="crm-modal-close" onclick="closeViewUserModal()" aria-label="Close dialog" style="background: rgba(255, 255, 255, 0.12); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.2);">✕</button>
      </div>
    </div>

    <!-- Modal Body -->
    <div class="crm-modal-body" style="padding: 24px;">
      
      <!-- Telemetry Matrix -->
      <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #8b5cf6; font-weight: 800; margin-bottom: 12px;">
        1. Security Telemetry & Credentials
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 24px;">
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
          <div style="font-size: 0.72rem; color: #64748b; font-weight: 600;">OPERATOR ID</div>
          <div style="font-size: 1rem; font-weight: 800; color: #0f172a; font-family: var(--font-mono, monospace); margin-top: 2px;">#<span id="viewUserId">0</span></div>
        </div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
          <div style="font-size: 0.72rem; color: #64748b; font-weight: 600;">PHONE NUMBER</div>
          <div id="viewUserPhone" style="font-size: 0.9rem; font-weight: 700; color: #0f172a; margin-top: 2px;">--</div>
        </div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
          <div style="font-size: 0.72rem; color: #64748b; font-weight: 600;">LAST LOGIN</div>
          <div id="viewUserLastLogin" style="font-size: 0.88rem; font-weight: 700; color: #0f172a; margin-top: 2px;">--</div>
        </div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
          <div style="font-size: 0.72rem; color: #64748b; font-weight: 600;">ACCOUNT PROVISIONED</div>
          <div id="viewUserCreatedAt" style="font-size: 0.88rem; font-weight: 700; color: #0f172a; margin-top: 2px;">--</div>
        </div>
      </div>

      <!-- RBAC Permissions Matrix -->
      <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #8b5cf6; font-weight: 800; margin-bottom: 12px;">
        2. Role-Based Access Scope
      </div>
      <div id="viewUserRbacScope" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 24px;">
        <!-- Injected dynamically via JS based on role -->
      </div>

      <!-- Recent Audit Trail Logs -->
      <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #8b5cf6; font-weight: 800; margin-bottom: 12px;">
        3. Recent Audit Trail & Actions
      </div>
      <div id="viewUserAuditTrail" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; max-height: 220px; overflow-y: auto;">
        <!-- Injected via JS -->
      </div>

    </div>

    <!-- Modal Footer -->
    <div class="crm-modal-footer">
      <button type="button" class="usr-btn usr-btn-glass" onclick="closeViewUserModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
        Close
      </button>
      <button type="button" class="usr-btn" id="viewUserResetPwBtn" style="background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        <span>Reset Password</span>
      </button>
      <button type="button" class="usr-btn usr-btn-primary" id="viewUserEditBtn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        <span>Edit Account</span>
      </button>
    </div>

  </div>
</div>


<!-- ========================================================================
     MODAL 2: PROVISION / EDIT USER STUDIO (POPUP DIALOG)
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="editUserModalBackdrop" style="display: none;" onclick="closeEditUserModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 780px;" onclick="event.stopPropagation()">
    
    <!-- Modal Header -->
    <div class="crm-modal-header">
      <div>
        <h3 class="crm-modal-title" id="editUserModalTitle">Provision Platform Operator</h3>
        <p class="crm-modal-subtitle">Configure administrator identity, access role, contact numbers, and security credentials.</p>
      </div>
      <button type="button" class="crm-modal-close" onclick="closeEditUserModal()" aria-label="Close dialog">✕</button>
    </div>

    <!-- Modal Form -->
    <form id="userForm" class="crm-modal-form" onsubmit="submitUserForm(event)">
      <input type="hidden" id="usrFieldId" name="id" value="0" />

      <div class="crm-modal-body">

        <!-- SECTION 1: IDENTITY -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #8b5cf6; font-weight: 800; margin: 0 0 14px; border-bottom: 2px solid #f5f3ff; padding-bottom: 6px;">
          1. Operator Identity & Contact Information
        </div>

        <div class="usr-grid-2">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="usrFieldName">Full Name *</label>
            <input type="text" id="usrFieldName" name="name" class="crm-form-input" placeholder="e.g. Sophia Sterling" required />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="usrFieldEmail">Corporate Email Address *</label>
            <input type="email" id="usrFieldEmail" name="email" class="crm-form-input" placeholder="e.g. sophia.s@clickcodex.com" required />
          </div>
        </div>

        <div class="usr-grid-2">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="usrFieldPhone">Direct Contact Phone</label>
            <input type="text" id="usrFieldPhone" name="phone" class="crm-form-input" placeholder="e.g. +1 (555) 234-8901" />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="usrFieldRole">Access Role & Clearance *</label>
            <select id="usrFieldRole" name="role" class="crm-form-select" required>
              <option value="admin">Administrator (Full operational control)</option>
              <option value="super_admin">Super Admin (System root authority)</option>
              <option value="editor">Content Editor (Articles, Portfolio & Case Studies)</option>
              <option value="seo_specialist">SEO Specialist (Search metadata & keywords)</option>
            </select>
          </div>
        </div>

        <!-- SECTION 2: AVATAR & VISUALS -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #8b5cf6; font-weight: 800; margin: 20px 0 14px; border-bottom: 2px solid #f5f3ff; padding-bottom: 6px;">
          2. Operator Avatar & Photo
        </div>

        <div class="crm-form-group">
          <label for="usrFieldAvatar">Avatar Image URL</label>
          <div style="display: flex; gap: 10px; align-items: center;">
            <input type="url" id="usrFieldAvatar" name="avatar_url" class="crm-form-input" style="flex: 1;" placeholder="https://images.unsplash.com/..." oninput="updateAvatarPreview(this.value)" />
            <img id="usrAvatarPreview" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&h=120&fit=crop&crop=face" alt="Preview" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #cbd5e1; flex-shrink: 0;" />
          </div>

          <!-- Quick Presets -->
          <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px;">
            <span style="font-size: 0.72rem; color: #64748b; font-weight: 600;">Avatar Presets:</span>
            <button type="button" onclick="setAvatarPreset('https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=120&h=120&fit=crop&crop=face')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">Executive F</button>
            <button type="button" onclick="setAvatarPreset('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&h=120&fit=crop&crop=face')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">Executive M</button>
            <button type="button" onclick="setAvatarPreset('https://images.unsplash.com/photo-1580489944761-15a19d654956?w=120&h=120&fit=crop&crop=face')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">Analyst F</button>
            <button type="button" onclick="setAvatarPreset('https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=120&h=120&fit=crop&crop=face')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">Engineer M</button>
          </div>
        </div>

        <!-- SECTION 3: CREDENTIALS & STATUS -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #8b5cf6; font-weight: 800; margin: 20px 0 14px; border-bottom: 2px solid #f5f3ff; padding-bottom: 6px;">
          3. Authentication Passphrase & Activation
        </div>

        <div class="usr-grid-2">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
              <label for="usrFieldPassword" style="margin-bottom: 0;">Passphrase <span id="usrPasswordRequiredBadge">*</span></label>
              <button type="button" onclick="generateRandomPassword('usrFieldPassword')" style="font-size: 0.7rem; color: #8b5cf6; background: none; border: none; font-weight: 700; cursor: pointer;">Generate Secure</button>
            </div>
            <input type="password" id="usrFieldPassword" name="password" class="crm-form-input" placeholder="Minimum 8 characters" />
            <div id="usrPasswordHelpText" style="font-size: 0.72rem; color: #64748b; margin-top: 4px; display: none;">
              Leave blank to preserve existing passphrase.
            </div>
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="usrFieldActive" style="display: block; margin-bottom: 8px;">Account Status</label>
            <div style="display: flex; align-items: center; gap: 8px; height: 42px;">
              <input type="checkbox" id="usrFieldActive" name="is_active" value="1" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #10b981;" />
              <label for="usrFieldActive" style="margin-bottom: 0; cursor: pointer; font-size: 0.86rem; font-weight: 700; color: #0f172a;">
                ● Active & Verified Account
              </label>
            </div>
          </div>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="crm-modal-footer">
        <button type="button" class="usr-btn usr-btn-glass" onclick="closeEditUserModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
          Cancel
        </button>
        <button type="submit" class="usr-btn usr-btn-primary" id="btnSubmitUser">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span id="btnSubmitUserText">Save Operator</span>
        </button>
      </div>

    </form>
  </div>
</div>


<!-- ========================================================================
     MODAL 3: RESET PASSWORD SECURITY MODAL (POPUP DIALOG)
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="resetPasswordModalBackdrop" style="display: none;" onclick="closeResetPasswordModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 480px;" onclick="event.stopPropagation()">
    
    <div class="crm-modal-header" style="align-items: flex-start;">
      <div style="display: flex; gap: 12px; align-items: flex-start; flex: 1;">
        <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(139, 92, 246, 0.12); color: #7c3aed; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        </div>
        <div>
          <h3 class="crm-modal-title" style="font-size: 1.15rem;">Reset Passphrase</h3>
          <p class="crm-modal-subtitle" style="margin-top: 3px;">Update security credentials for <strong id="resetTargetName" style="color: #0f172a;">Operator</strong>.</p>
        </div>
      </div>
      <button type="button" class="crm-modal-close" onclick="closeResetPasswordModal()" aria-label="Close dialog">✕</button>
    </div>

    <form onsubmit="submitResetPasswordForm(event)">
      <input type="hidden" id="resetTargetUserId" value="0" />

      <div class="crm-modal-body" style="padding: 20px 26px;">
        <div class="crm-form-group">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
            <label for="newPassphraseInput" style="margin-bottom: 0;">New Passphrase *</label>
            <button type="button" onclick="generateRandomPassword('newPassphraseInput')" style="font-size: 0.72rem; color: #8b5cf6; background: none; border: none; font-weight: 700; cursor: pointer;">Generate Secure</button>
          </div>
          <div style="display: flex; gap: 8px;">
            <input type="text" id="newPassphraseInput" class="crm-form-input" placeholder="Enter or generate strong passphrase" required style="font-family: var(--font-mono, monospace);" />
            <button type="button" onclick="copyPasswordToClipboard()" class="usr-btn" style="background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1; padding: 0 14px;" title="Copy to Clipboard">
              Copy
            </button>
          </div>
          <div style="font-size: 0.74rem; color: #64748b; margin-top: 6px;">
            Ensure the operator receives this passphrase via a secure channel. Minimum 8 characters.
          </div>
        </div>
      </div>

      <div class="crm-modal-footer" style="padding: 16px 26px;">
        <button type="button" class="usr-btn usr-btn-glass" onclick="closeResetPasswordModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
          Cancel
        </button>
        <button type="submit" class="usr-btn usr-btn-primary" id="btnSubmitResetPass">
          Update Passphrase
        </button>
      </div>
    </form>

  </div>
</div>


<!-- ========================================================================
     MODAL 4: DELETE CONFIRMATION DIALOG (POPUP)
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="deleteUserModalBackdrop" style="display: none;" onclick="closeDeleteUserModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 460px;" onclick="event.stopPropagation()">
    
    <div class="crm-modal-header" style="border-bottom: none; padding-bottom: 0; align-items: flex-start;">
      <div style="display: flex; gap: 14px; align-items: flex-start; flex: 1;">
        <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(220, 38, 38, 0.1); color: #dc2626; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        </div>
        <div style="flex: 1;">
          <h3 class="crm-modal-title" style="color: #0f172a; font-size: 1.15rem; margin: 0;">Remove Platform Operator</h3>
          <p class="crm-modal-subtitle" style="margin-top: 4px; font-size: 0.84rem; line-height: 1.4;">Are you sure you want to permanently delete <strong id="deleteTargetUserName" style="color: #0f172a; word-break: break-word;"></strong>?</p>
        </div>
      </div>
      <button type="button" class="crm-modal-close" onclick="closeDeleteUserModal()" aria-label="Close dialog">✕</button>
    </div>

    <div class="crm-modal-body" style="padding: 16px 26px; font-size: 0.84rem; color: #64748b; line-height: 1.5;">
      This action will revoke all security credentials, terminate active sessions, and remove this operator record from ClickCodex. This action cannot be undone.
    </div>

    <div class="crm-modal-footer" style="padding: 16px 26px; border-top: 1px solid #f1f5f9;">
      <button type="button" class="usr-btn usr-btn-glass" onclick="closeDeleteUserModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
        Cancel
      </button>
      <button type="button" class="usr-btn" id="btnConfirmDeleteUserAction" style="background: #dc2626; color: #ffffff; border: none; font-weight: 700;">
        Yes, Remove Operator
      </button>
    </div>

  </div>
</div>


<!-- Toast Notifications Overlay -->
<div id="adminToastContainer" style="position: fixed; bottom: 24px; right: 24px; z-index: 1000000; display: flex; flex-direction: column; gap: 8px; pointer-events: none;"></div>


<!-- ========================================================================
     USER MANAGEMENT JAVASCRIPT CONTROLLER
     ======================================================================== -->
<script>
/**
 * ClickCodex Studio - User Management & RBAC Controller
 */
const BASE_URL = '<?= BASE_URL ?>';
let currentUserId = <?= (int)($currentUser['id'] ?? 1) ?>;
let deleteTargetId = 0;
let currentViewMode = 'table'; // 'table' or 'cards'

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', () => {
  // Restore view mode preference from localStorage
  const savedView = localStorage.getItem('cc_users_view');
  if (savedView === 'cards') {
    switchUserView('cards');
  }

  // Keyboard shortcut '/' to focus search & Esc to close modals
  document.addEventListener('keydown', (e) => {
    if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
      e.preventDefault();
      const s = document.getElementById('userSearchInput');
      if (s) { s.focus(); s.select(); }
    } else if (e.key === 'Escape') {
      closeViewUserModal();
      closeEditUserModal();
      closeResetPasswordModal();
      closeDeleteUserModal();
    }
  });
});

// Toast notification helper
function showToast(message, type = 'success') {
  if (typeof window.showToast === 'function') {
    window.showToast(message, type);
    return;
  }
  const container = document.getElementById('adminToastContainer');
  if (!container) return;

  const toast = document.createElement('div');
  toast.style.padding = '12px 18px';
  toast.style.borderRadius = '10px';
  toast.style.fontSize = '0.85rem';
  toast.style.fontWeight = '600';
  toast.style.boxShadow = '0 10px 25px -5px rgba(0,0,0,0.18)';
  toast.style.display = 'flex';
  toast.style.alignItems = 'center';
  toast.style.gap = '9px';
  toast.style.pointerEvents = 'auto';
  toast.style.transition = 'all 0.3s cubic-bezier(0.16, 1, 0.3, 1)';
  toast.style.transform = 'translateY(12px)';
  toast.style.opacity = '0';

  if (type === 'success') {
    toast.style.background = '#065f46';
    toast.style.color = '#ffffff';
    toast.innerHTML = `✓ <span>${escapeHtml(message)}</span>`;
  } else {
    toast.style.background = '#991b1b';
    toast.style.color = '#ffffff';
    toast.innerHTML = `✕ <span>${escapeHtml(message)}</span>`;
  }

  container.appendChild(toast);
  requestAnimationFrame(() => {
    toast.style.transform = 'translateY(0)';
    toast.style.opacity = '1';
  });

  setTimeout(() => {
    toast.style.transform = 'translateY(-8px)';
    toast.style.opacity = '0';
    setTimeout(() => toast.remove(), 300);
  }, 4000);
}

function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

// ============================================================================
// VIEW SWITCHER: TABLE VS CARDS
// ============================================================================
function switchUserView(mode) {
  currentViewMode = mode;
  localStorage.setItem('cc_users_view', mode);

  const tableView = document.getElementById('usersTableView');
  const cardsView = document.getElementById('usersCardsView');
  const btnTable = document.getElementById('viewBtnTable');
  const btnCards = document.getElementById('viewBtnCards');

  if (mode === 'cards') {
    if (tableView) tableView.style.display = 'none';
    if (cardsView) cardsView.style.display = 'grid';
    if (btnTable) btnTable.classList.remove('active');
    if (btnCards) btnCards.classList.add('active');
  } else {
    if (tableView) tableView.style.display = 'block';
    if (cardsView) cardsView.style.display = 'none';
    if (btnTable) btnTable.classList.add('active');
    if (btnCards) btnCards.classList.remove('active');
  }
}

// ============================================================================
// DYNAMIC CLIENT-SIDE FILTERING & SEARCH
// ============================================================================
let activeRoleFilter = 'all';
let activeStatusFilter = 'all';

function selectRolePill(role, btnEl) {
  activeRoleFilter = role;
  document.querySelectorAll('.usr-filter-pill').forEach(p => p.classList.remove('active'));
  btnEl.classList.add('active');
  const sel = document.getElementById('roleSelect');
  if (sel) sel.value = role;
  applyUserFilters();
}

function handleRoleFilter(role) {
  activeRoleFilter = role;
  document.querySelectorAll('.usr-filter-pill').forEach(p => {
    if (p.getAttribute('data-role') === role) p.classList.add('active');
    else p.classList.remove('active');
  });
  applyUserFilters();
}

function handleStatusFilter(status) {
  activeStatusFilter = status;
  applyUserFilters();
}

function filterByRole(role) {
  const pill = document.querySelector(`.usr-filter-pill[data-role="${role}"]`);
  if (pill) selectRolePill(role, pill);
  else handleRoleFilter(role);
}

function filterByStatus(status) {
  const sel = document.getElementById('statusSelect');
  if (sel) sel.value = status;
  activeStatusFilter = status;
  applyUserFilters();
}

function handleUserSearch(val) {
  applyUserFilters();
}

function applyUserFilters() {
  const query = (document.getElementById('userSearchInput')?.value || '').toLowerCase().trim();

  const rows = document.querySelectorAll('.user-data-row');
  const cards = document.querySelectorAll('.user-card-item');

  const matches = (el) => {
    const role = el.getAttribute('data-role');
    const status = el.getAttribute('data-status');
    const name = el.getAttribute('data-name') || '';
    const email = el.getAttribute('data-email') || '';
    const phone = el.getAttribute('data-phone') || '';

    // Role filter
    if (activeRoleFilter !== 'all' && role !== activeRoleFilter) return false;

    // Status filter
    if (activeStatusFilter !== 'all' && status !== activeStatusFilter) return false;

    // Search query
    if (query !== '') {
      const matchText = `${name} ${email} ${phone} ${role}`;
      if (!matchText.includes(query)) return false;
    }

    return true;
  };

  rows.forEach(r => { r.style.display = matches(r) ? '' : 'none'; });
  cards.forEach(c => { c.style.display = matches(c) ? '' : 'none'; });
}

// ============================================================================
// MODAL 1: VIEW USER DOSSIER & SECURITY AUDIT
// ============================================================================
async function viewUserDossier(id) {
  const backdrop = document.getElementById('viewUserModalBackdrop');
  if (!backdrop) return;

  // 1. Immediately open modal with loading feedback
  backdrop.style.display = 'flex';
  backdrop.classList.add('show');
  document.body.style.overflow = 'hidden';

  // Loading state
  document.getElementById('viewUserId').textContent = id;
  document.getElementById('viewUserName').textContent = 'Loading Operator Dossier...';
  document.getElementById('viewUserEmail').textContent = 'Retrieving credentials...';
  document.getElementById('viewUserInitials').textContent = '..';
  document.getElementById('viewUserAvatar').style.display = 'none';
  document.getElementById('viewUserInitials').style.display = 'block';
  document.getElementById('viewUserPhone').textContent = '--';
  document.getElementById('viewUserLastLogin').textContent = 'Fetching telemetry...';
  document.getElementById('viewUserCreatedAt').textContent = 'Fetching records...';
  document.getElementById('viewUserRbacScope').innerHTML = `
    <div style="display:flex; align-items:center; gap:10px; color:#64748b; font-size:0.84rem;">
      <div style="width:20px; height:20px; border:2px solid #e2e8f0; border-top-color:#8b5cf6; border-radius:50%; animation:crmSpinner 0.8s linear infinite;"></div>
      <span>Inspecting Role-Based Access Control matrix...</span>
    </div>
  `;
  document.getElementById('viewUserAuditTrail').innerHTML = `
    <div style="display:flex; align-items:center; gap:10px; color:#64748b; font-size:0.84rem;">
      <div style="width:20px; height:20px; border:2px solid #e2e8f0; border-top-color:#8b5cf6; border-radius:50%; animation:crmSpinner 0.8s linear infinite;"></div>
      <span>Scanning audit logs...</span>
    </div>
  `;

  try {
    const res = await fetch(`${BASE_URL}/admin/user/detail?id=${id}`);
    const data = await res.json();

    if (!data.success || !data.user) {
      showToast(data.error || 'Failed to load user profile.', 'error');
      closeViewUserModal();
      return;
    }

    const u = data.user;

    document.getElementById('viewUserId').textContent = u.id;
    document.getElementById('viewUserName').textContent = u.name;
    document.getElementById('viewUserEmail').textContent = u.email;
    document.getElementById('viewUserPhone').textContent = u.phone || 'None Registered';
    document.getElementById('viewUserLastLogin').textContent = u.last_login_at ? `${u.last_login_human} (${u.last_login_at})` : 'Never Logged In';
    document.getElementById('viewUserCreatedAt').textContent = u.created_at;

    // Avatar
    const imgEl = document.getElementById('viewUserAvatar');
    const initEl = document.getElementById('viewUserInitials');
    if (u.avatar_url) {
      imgEl.src = u.avatar_url;
      imgEl.style.display = 'block';
      initEl.style.display = 'none';
    } else {
      initEl.textContent = u.initials || 'U';
      initEl.style.display = 'block';
      imgEl.style.display = 'none';
    }

    // Role badge
    const roleBadge = document.getElementById('viewUserRoleBadge');
    roleBadge.className = `usr-role-badge ${u.role}`;
    roleBadge.textContent = u.role_label;

    // Status pill
    const statusPill = document.getElementById('viewUserStatusPill');
    if (parseInt(u.is_active, 10) === 1) {
      statusPill.style.background = 'rgba(16, 185, 129, 0.25)';
      statusPill.style.color = '#34d399';
      statusPill.textContent = '● ACTIVE';
    } else {
      statusPill.style.background = 'rgba(239, 68, 68, 0.25)';
      statusPill.style.color = '#f87171';
      statusPill.textContent = '○ SUSPENDED';
    }

    // Render RBAC Scope Matrix
    const rbacContainer = document.getElementById('viewUserRbacScope');
    rbacContainer.innerHTML = getRbacMatrixHtml(u.role);

    // Render Audit Logs
    const auditContainer = document.getElementById('viewUserAuditTrail');
    auditContainer.innerHTML = '';
    if (u.audit_logs && u.audit_logs.length > 0) {
      u.audit_logs.forEach(l => {
        const item = document.createElement('div');
        item.style.padding = '8px 0';
        item.style.borderBottom = '1px solid #f1f5f9';
        item.style.display = 'flex';
        item.style.justifyContent = 'space-between';
        item.style.alignItems = 'center';
        item.style.fontSize = '0.78rem';
        item.innerHTML = `
          <div>
            <span style="font-family:var(--font-mono, monospace); font-weight:700; color:#8b5cf6;">${escapeHtml(l.action)}</span>
            <span style="color:#64748b; margin-left:6px;">on ${escapeHtml(l.entity_type || 'system')} #${l.entity_id || 0}</span>
          </div>
          <div style="color:#94a3b8; font-size:0.72rem;">${escapeHtml(l.created_at)}</div>
        `;
        auditContainer.appendChild(item);
      });
    } else {
      auditContainer.innerHTML = '<div style="font-size:0.78rem; color:#94a3b8; text-align:center; padding:10px;">No audit trail events logged for this operator yet.</div>';
    }

    // Wire buttons
    document.getElementById('viewUserEditBtn').onclick = () => {
      closeViewUserModal();
      editUser(u.id);
    };
    document.getElementById('viewUserResetPwBtn').onclick = () => {
      closeViewUserModal();
      openResetPasswordModal(u.id, u.name);
    };

  } catch (err) {
    showToast('Failed to load user profile.', 'error');
    closeViewUserModal();
  }
}

function getRbacMatrixHtml(role) {
  const permissions = {
    super_admin: [
      { name: 'Root System Configuration & Cache', granted: true },
      { name: 'Operator Provisioning & RBAC Management', granted: true },
      { name: 'Client Inquiries & CRM Leads Administration', granted: true },
      { name: 'Technical Articles & Editorial Dispatch', granted: true },
      { name: 'Capabilities & Solution Advisor Archetypes', granted: true },
      { name: 'Security Audit Logs & Telemetry Inspection', granted: true }
    ],
    admin: [
      { name: 'Root System Configuration & Cache', granted: false },
      { name: 'Operator Provisioning & RBAC Management', granted: true },
      { name: 'Client Inquiries & CRM Leads Administration', granted: true },
      { name: 'Technical Articles & Editorial Dispatch', granted: true },
      { name: 'Capabilities & Solution Advisor Archetypes', granted: true },
      { name: 'Security Audit Logs & Telemetry Inspection', granted: true }
    ],
    editor: [
      { name: 'Root System Configuration & Cache', granted: false },
      { name: 'Operator Provisioning & RBAC Management', granted: false },
      { name: 'Client Inquiries & CRM Leads Administration', granted: false },
      { name: 'Technical Articles & Editorial Dispatch', granted: true },
      { name: 'Portfolio & Case Studies Showroom', granted: true },
      { name: 'Security Audit Logs & Telemetry Inspection', granted: false }
    ],
    seo_specialist: [
      { name: 'Root System Configuration & Cache', granted: false },
      { name: 'Operator Provisioning & RBAC Management', granted: false },
      { name: 'Technical Keywords & Search SERP Tuning', granted: true },
      { name: 'Article Metadata & Social Preview OpenGraph', granted: true },
      { name: 'Capabilities SEO Tags & Sitemaps', granted: true },
      { name: 'Security Audit Logs & Telemetry Inspection', granted: false }
    ]
  };

  const list = permissions[role] || permissions.admin;
  return `
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 8px;">
      ${list.map(p => `
        <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: ${p.granted ? '#0f172a' : '#94a3b8'};">
          <span style="display: inline-flex; align-items: center; justify-content: center; width: 18px; height: 18px; border-radius: 50%; font-size: 0.7rem; font-weight: 800; background: ${p.granted ? '#dcfce7' : '#f1f5f9'}; color: ${p.granted ? '#16a34a' : '#94a3b8'};">
            ${p.granted ? '✓' : '✕'}
          </span>
          <span>${escapeHtml(p.name)}</span>
        </div>
      `).join('')}
    </div>
  `;
}

function closeViewUserModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close')) return;
  const backdrop = document.getElementById('viewUserModalBackdrop');
  if (backdrop) {
    backdrop.classList.remove('show');
    backdrop.style.display = 'none';
  }
  document.body.style.overflow = '';
}

// ============================================================================
// MODAL 2: CREATE & EDIT USER STUDIO
// ============================================================================
function openCreateUserModal() {
  const form = document.getElementById('userForm');
  if (form) form.reset();

  document.getElementById('usrFieldId').value = '0';
  document.getElementById('editUserModalTitle').textContent = 'Provision Platform Operator';
  document.getElementById('btnSubmitUserText').textContent = 'Provision Operator';
  document.getElementById('btnSubmitUser').disabled = false;

  const pwField = document.getElementById('usrFieldPassword');
  pwField.required = true;
  document.getElementById('usrPasswordRequiredBadge').style.display = 'inline';
  document.getElementById('usrPasswordHelpText').style.display = 'none';

  setAvatarPreset('https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&h=120&fit=crop&crop=face');

  const backdrop = document.getElementById('editUserModalBackdrop');
  if (backdrop) {
    backdrop.style.display = 'flex';
    backdrop.classList.add('show');
  }
  document.body.style.overflow = 'hidden';
}

async function editUser(id) {
  const backdrop = document.getElementById('editUserModalBackdrop');
  if (backdrop) {
    backdrop.style.display = 'flex';
    backdrop.classList.add('show');
  }
  document.body.style.overflow = 'hidden';

  const titleEl = document.getElementById('editUserModalTitle');
  const submitBtn = document.getElementById('btnSubmitUser');
  const btnText = document.getElementById('btnSubmitUserText');

  titleEl.textContent = `Loading Operator Profile #${id}...`;
  submitBtn.disabled = true;
  btnText.textContent = 'Loading...';

  try {
    const res = await fetch(`${BASE_URL}/admin/user/detail?id=${id}`);
    const data = await res.json();

    if (!data.success || !data.user) {
      showToast(data.error || 'Failed to load user profile.', 'error');
      closeEditUserModal();
      return;
    }

    const u = data.user;

    document.getElementById('usrFieldId').value = u.id;
    document.getElementById('usrFieldName').value = u.name || '';
    document.getElementById('usrFieldEmail').value = u.email || '';
    document.getElementById('usrFieldPhone').value = u.phone || '';
    document.getElementById('usrFieldRole').value = u.role || 'admin';
    document.getElementById('usrFieldAvatar').value = u.avatar_url || '';
    updateAvatarPreview(u.avatar_url);

    document.getElementById('usrFieldActive').checked = (parseInt(u.is_active, 10) === 1);

    const pwField = document.getElementById('usrFieldPassword');
    pwField.value = '';
    pwField.required = false;
    document.getElementById('usrPasswordRequiredBadge').style.display = 'none';
    document.getElementById('usrPasswordHelpText').style.display = 'block';

    titleEl.textContent = `Edit Operator Profile #${u.id}`;
    btnText.textContent = 'Update Operator';
    submitBtn.disabled = false;

  } catch (err) {
    showToast('Failed to load user for editing.', 'error');
    closeEditUserModal();
  }
}

function closeEditUserModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close')) return;
  const backdrop = document.getElementById('editUserModalBackdrop');
  if (backdrop) {
    backdrop.classList.remove('show');
    backdrop.style.display = 'none';
  }
  document.body.style.overflow = '';
}

function updateAvatarPreview(url) {
  const preview = document.getElementById('usrAvatarPreview');
  if (url && preview) {
    preview.src = url;
  }
}

function setAvatarPreset(url) {
  document.getElementById('usrFieldAvatar').value = url;
  updateAvatarPreview(url);
}

function generateRandomPassword(targetFieldId) {
  const chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789!@#$%&*';
  let pass = '';
  for (let i = 0; i < 14; i++) {
    pass += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  const field = document.getElementById(targetFieldId);
  if (field) {
    field.value = pass;
    field.type = 'text'; // Show generated value
  }
}

// Form Submit Handler via AJAX
async function submitUserForm(e) {
  e.preventDefault();

  const form = document.getElementById('userForm');
  const btn = document.getElementById('btnSubmitUser');
  const btnText = document.getElementById('btnSubmitUserText');
  const origText = btnText.textContent;

  btn.disabled = true;
  btnText.textContent = 'Saving...';

  try {
    const formData = new FormData(form);
    const res = await fetch(`${BASE_URL}/admin/user/save`, {
      method: 'POST',
      body: formData
    });

    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Operator profile saved successfully!', 'success');
      closeEditUserModal();
      setTimeout(() => window.location.reload(), 600);
    } else {
      showToast(data.error || 'Failed to save operator profile.', 'error');
    }
  } catch (err) {
    showToast('Network error while saving user profile.', 'error');
  } finally {
    btn.disabled = false;
    btnText.textContent = origText;
  }
}

// ============================================================================
// AJAX TOGGLE: ACCOUNT STATUS (ACTIVE / SUSPENDED)
// ============================================================================
async function toggleUserStatusAjax(id, isActive) {
  try {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('is_active', isActive ? 1 : 0);

    const res = await fetch(`${BASE_URL}/admin/user/toggle-status`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message, 'success');
      // Update DOM data attributes
      const row = document.getElementById(`userRow-${id}`);
      if (row) row.setAttribute('data-status', isActive ? '1' : '0');
      const card = document.getElementById(`userCard-${id}`);
      if (card) card.setAttribute('data-status', isActive ? '1' : '0');

      // Keep both toggles in sync
      const tToggle = document.getElementById(`tableStatusToggle-${id}`);
      if (tToggle) tToggle.checked = isActive;
      const cToggle = document.getElementById(`cardStatusToggle-${id}`);
      if (cToggle) cToggle.checked = isActive;

    } else {
      showToast(data.error || 'Status update failed.', 'error');
      // Revert checkbox state
      const tToggle = document.getElementById(`tableStatusToggle-${id}`);
      if (tToggle) tToggle.checked = !isActive;
      const cToggle = document.getElementById(`cardStatusToggle-${id}`);
      if (cToggle) cToggle.checked = !isActive;
    }
  } catch (err) {
    showToast('Network error during status update.', 'error');
  }
}

// ============================================================================
// MODAL 3: RESET PASSWORD SECURITY MODAL
// ============================================================================
function openResetPasswordModal(id, name = '') {
  if (!name) {
    const tableEl = document.getElementById(`userTableName-${id}`);
    const cardEl = document.getElementById(`userCardName-${id}`);
    name = (tableEl ? tableEl.innerText : (cardEl ? cardEl.innerText : '')).trim();
  }

  document.getElementById('resetTargetUserId').value = id;
  document.getElementById('resetTargetName').textContent = name ? `"${name}"` : `#${id}`;
  generateRandomPassword('newPassphraseInput');

  const backdrop = document.getElementById('resetPasswordModalBackdrop');
  if (backdrop) {
    backdrop.style.display = 'flex';
    backdrop.classList.add('show');
  }
  document.body.style.overflow = 'hidden';
}

function closeResetPasswordModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close')) return;
  const backdrop = document.getElementById('resetPasswordModalBackdrop');
  if (backdrop) {
    backdrop.classList.remove('show');
    backdrop.style.display = 'none';
  }
  document.body.style.overflow = '';
}

function copyPasswordToClipboard() {
  const input = document.getElementById('newPassphraseInput');
  if (input && input.value) {
    navigator.clipboard.writeText(input.value).then(() => {
      showToast('Passphrase copied to clipboard!', 'success');
    }).catch(() => {
      input.select();
      document.execCommand('copy');
      showToast('Passphrase copied to clipboard!', 'success');
    });
  }
}

async function submitResetPasswordForm(e) {
  e.preventDefault();

  const id = document.getElementById('resetTargetUserId').value;
  const newPass = document.getElementById('newPassphraseInput').value;
  const btn = document.getElementById('btnSubmitResetPass');

  btn.disabled = true;
  btn.textContent = 'Updating...';

  try {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('new_password', newPass);

    const res = await fetch(`${BASE_URL}/admin/user/reset-password`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Passphrase updated successfully!', 'success');
      closeResetPasswordModal();
    } else {
      showToast(data.error || 'Failed to update passphrase.', 'error');
    }
  } catch (err) {
    showToast('Network error during password update.', 'error');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Update Passphrase';
  }
}

// ============================================================================
// MODAL 4: DELETE CONFIRMATION & EXECUTION
// ============================================================================
function confirmDeleteUser(id, name = '') {
  deleteTargetId = id;
  if (!name) {
    const tableEl = document.getElementById(`userTableName-${id}`);
    const cardEl = document.getElementById(`userCardName-${id}`);
    name = (tableEl ? tableEl.innerText : (cardEl ? cardEl.innerText : '')).trim();
  }
  document.getElementById('deleteTargetUserName').textContent = name ? `"${name}"` : `#${id}`;

  const backdrop = document.getElementById('deleteUserModalBackdrop');
  if (backdrop) {
    backdrop.style.display = 'flex';
    backdrop.classList.add('show');
  }
  document.body.style.overflow = 'hidden';

  const btnConfirm = document.getElementById('btnConfirmDeleteUserAction');
  if (btnConfirm) {
    btnConfirm.disabled = false;
    btnConfirm.textContent = 'Yes, Remove Operator';
    btnConfirm.onclick = executeDeleteUser;
  }
}

function closeDeleteUserModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close')) return;
  const backdrop = document.getElementById('deleteUserModalBackdrop');
  if (backdrop) {
    backdrop.classList.remove('show');
    backdrop.style.display = 'none';
  }
  document.body.style.overflow = '';
  deleteTargetId = 0;
}

async function executeDeleteUser() {
  if (!deleteTargetId) return;

  const btn = document.getElementById('btnConfirmDeleteUserAction');
  btn.disabled = true;
  btn.textContent = 'Removing...';

  try {
    const formData = new FormData();
    formData.append('id', deleteTargetId);

    const res = await fetch(`${BASE_URL}/admin/user/delete`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Operator permanently removed.', 'success');
      closeDeleteUserModal();

      const row = document.getElementById(`userRow-${deleteTargetId}`);
      if (row) row.remove();
      const card = document.getElementById(`userCard-${deleteTargetId}`);
      if (card) card.remove();

      // Decrement counter
      const kpi = document.getElementById('kpiTotalUsers');
      if (kpi) {
        const cur = parseInt(kpi.textContent, 10);
        if (cur > 0) kpi.textContent = cur - 1;
      }
    } else {
      showToast(data.error || 'Failed to remove operator.', 'error');
    }
  } catch (err) {
    showToast('Network error during operator deletion.', 'error');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Yes, Remove Operator';
  }
}
</script>

<?php
include __DIR__ . '/layout/footer.php';
?>
