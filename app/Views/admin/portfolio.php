<?php
/**
 * ClickCodex Technologies - Admin Portfolio & Case Studies Showroom Console
 * Executive enterprise management for flagship client dossiers, measurable transformation metrics, and live digital showcases.
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

$pageTitle = $pageTitle ?? 'Portfolio & Case Studies Showroom | ClickCodex Studio Console';
$topbarTitle = 'Portfolio & Case Studies Showroom';
$activeNav = 'portfolio';

include __DIR__ . '/layout/header.php';
?>

<!-- ========================================================================
     PORTFOLIO SHOWROOM EXECUTIVE DESIGN SYSTEM & SCOPED STYLES
     ======================================================================== -->
<style>
:root {
  --pf-primary: #0056d6;
  --pf-primary-glow: rgba(0, 86, 214, 0.25);
  --pf-cyan: #00a2ff;
  --pf-emerald: #10b981;
  --pf-emerald-glow: rgba(16, 185, 129, 0.25);
  --pf-amber: #f59e0b;
  --pf-amber-glow: rgba(245, 158, 11, 0.25);
  --pf-purple: #8b5cf6;
  --pf-red: #ef4444;
  --pf-dark-surface: #0a0f1d;
  --pf-card-border: #e2e8f0;
}

/* Header Banner */
.pf-hero-banner {
  background: linear-gradient(135deg, #090d16 0%, #111a2e 50%, #0f172a 100%);
  border-radius: 18px;
  padding: 26px 30px;
  margin-bottom: 24px;
  color: #ffffff;
  position: relative;
  overflow: hidden;
  box-shadow: 0 10px 30px -5px rgba(9, 13, 22, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.08);
}
.pf-hero-banner::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 380px;
  height: 380px;
  background: radial-gradient(circle, rgba(0, 162, 255, 0.15) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.pf-hero-banner::after {
  content: '';
  position: absolute;
  bottom: -40%;
  left: 20%;
  width: 300px;
  height: 300px;
  background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.pf-badge-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 12px;
  background: rgba(0, 162, 255, 0.15);
  border: 1px solid rgba(0, 162, 255, 0.3);
  border-radius: 9999px;
  font-family: var(--font-mono, monospace);
  font-size: 0.72rem;
  font-weight: 700;
  color: #38bdf8;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  margin-bottom: 10px;
}
.pf-pulse-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #10b981;
  box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
  animation: pfPulse 2s infinite;
}
@keyframes pfPulse {
  0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
  70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
  100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

.pf-title-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
  position: relative;
  z-index: 2;
}
.pf-hero-title {
  font-family: var(--font-display, 'Open Sans', sans-serif);
  font-size: 1.65rem;
  font-weight: 800;
  color: #ffffff;
  letter-spacing: -0.5px;
  margin: 0;
  line-height: 1.25;
}
.pf-hero-title span {
  background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.pf-hero-desc {
  font-size: 0.88rem;
  color: #94a3b8;
  max-width: 680px;
  margin-top: 6px;
  line-height: 1.5;
}

/* Header Quick Actions */
.pf-actions-wrap {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}
.pf-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 9px 16px;
  border-radius: 10px;
  font-size: 0.82rem;
  font-weight: 700;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  border: none;
}
.pf-btn-primary {
  background: linear-gradient(135deg, #0056d6 0%, #0284c7 100%);
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 4px 14px rgba(0, 86, 214, 0.35);
}
.pf-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(0, 86, 214, 0.5);
  color: #ffffff;
}
.pf-btn-glass {
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  color: #f1f5f9;
  border: 1px solid rgba(255, 255, 255, 0.15);
}
.pf-btn-glass:hover {
  background: rgba(255, 255, 255, 0.16);
  color: #ffffff;
  transform: translateY(-2px);
}

/* Interactive Metric Widgets Grid */
.pf-kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}
.pf-kpi-card {
  background: #ffffff;
  border: 1px solid var(--pf-card-border);
  border-radius: 14px;
  padding: 18px 20px;
  box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.04);
  position: relative;
  overflow: hidden;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  cursor: pointer;
}
.pf-kpi-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 24px -4px rgba(15, 23, 42, 0.08);
  border-color: #cbd5e1;
}
.pf-kpi-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 4px;
  height: 100%;
  background: var(--pf-primary);
  border-radius: 14px 0 0 14px;
}
.pf-kpi-card.emerald::before { background: var(--pf-emerald); }
.pf-kpi-card.amber::before { background: var(--pf-amber); }
.pf-kpi-card.purple::before { background: var(--pf-purple); }
.pf-kpi-card.cyan::before { background: var(--pf-cyan); }

.pf-kpi-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}
.pf-kpi-label {
  font-size: 0.76rem;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.pf-kpi-icon {
  width: 34px;
  height: 34px;
  border-radius: 9px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(0, 86, 214, 0.08);
  color: var(--pf-primary);
}
.pf-kpi-card.emerald .pf-kpi-icon { background: rgba(16, 185, 129, 0.1); color: var(--pf-emerald); }
.pf-kpi-card.amber .pf-kpi-icon { background: rgba(245, 158, 11, 0.12); color: var(--pf-amber); }
.pf-kpi-card.purple .pf-kpi-icon { background: rgba(139, 92, 246, 0.1); color: var(--pf-purple); }
.pf-kpi-card.cyan .pf-kpi-icon { background: rgba(0, 162, 255, 0.1); color: var(--pf-cyan); }

.pf-kpi-val {
  font-family: var(--font-display, sans-serif);
  font-size: 1.85rem;
  font-weight: 800;
  color: #0f172a;
  line-height: 1;
}
.pf-kpi-footer {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 10px;
  font-size: 0.74rem;
  color: #64748b;
}
.pf-kpi-pill {
  padding: 2px 7px;
  border-radius: 5px;
  font-weight: 700;
  font-size: 0.7rem;
}

/* Category Filter Bar */
.pf-category-strip {
  background: #ffffff;
  border: 1px solid var(--pf-card-border);
  border-radius: 12px;
  padding: 8px 12px;
  display: flex;
  align-items: center;
  gap: 6px;
  overflow-x: auto;
  margin-bottom: 20px;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
}
.pf-cat-tab {
  padding: 7px 14px;
  border-radius: 8px;
  font-size: 0.8rem;
  font-weight: 600;
  color: #475569;
  background: transparent;
  border: none;
  display: inline-flex;
  align-items: center;
  gap: 7px;
  white-space: nowrap;
  transition: all 0.2s ease;
  cursor: pointer;
}
.pf-cat-tab:hover {
  background: #f1f5f9;
  color: #0f172a;
}
.pf-cat-tab.active {
  background: #0056d6;
  color: #ffffff;
  box-shadow: 0 3px 10px rgba(0, 86, 214, 0.3);
}
.pf-cat-count {
  font-family: var(--font-mono, monospace);
  font-size: 0.7rem;
  padding: 1px 6px;
  border-radius: 10px;
  background: rgba(0, 0, 0, 0.08);
  color: inherit;
}
.pf-cat-tab.active .pf-cat-count {
  background: rgba(255, 255, 255, 0.25);
  color: #ffffff;
}

/* Toolbar Control Panel */
.pf-toolbar {
  background: #ffffff;
  border: 1px solid var(--pf-card-border);
  border-radius: 14px;
  padding: 14px 18px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 14px;
  flex-wrap: wrap;
  margin-bottom: 20px;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
}
.pf-search-wrap {
  position: relative;
  min-width: 280px;
  flex: 1;
  max-width: 420px;
}
.pf-search-icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  pointer-events: none;
}
.pf-search-input {
  width: 100%;
  height: 40px;
  padding: 8px 36px 8px 38px;
  border: 1px solid #cbd5e1;
  border-radius: 9px;
  font-size: 0.85rem;
  background: #f8fafc;
  color: #0f172a;
  transition: all 0.2s ease;
  box-sizing: border-box;
}
.pf-search-input:focus {
  outline: none;
  background: #ffffff;
  border-color: #0056d6;
  box-shadow: 0 0 0 3px rgba(0, 86, 214, 0.12);
}
.pf-search-clear {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: #94a3b8;
  cursor: pointer;
  font-size: 0.85rem;
  display: none;
  padding: 4px;
}
.pf-search-clear:hover { color: #0f172a; }

.pf-select {
  height: 40px;
  padding: 6px 14px;
  border: 1px solid #cbd5e1;
  border-radius: 9px;
  font-size: 0.82rem;
  font-weight: 600;
  color: #334155;
  background: #ffffff;
  cursor: pointer;
  transition: border-color 0.2s;
  box-sizing: border-box;
}
.pf-select:focus {
  outline: none;
  border-color: #0056d6;
}

/* View Mode Switcher */
.pf-view-toggle {
  display: inline-flex;
  background: #f1f5f9;
  padding: 3px;
  border-radius: 9px;
  border: 1px solid #e2e8f0;
}
.pf-toggle-btn {
  padding: 6px 12px;
  border-radius: 7px;
  font-size: 0.78rem;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: #64748b;
  background: transparent;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
}
.pf-toggle-btn.active {
  background: #ffffff;
  color: #0056d6;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
}

/* Master Showroom Table */
.pf-table-panel {
  background: #ffffff;
  border: 1px solid var(--pf-card-border);
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
  margin-bottom: 30px;
}
.pf-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}
.pf-table thead th {
  background: #f8fafc;
  padding: 13px 18px;
  font-size: 0.74rem;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  border-bottom: 1px solid #e2e8f0;
}
.pf-table tbody td {
  padding: 14px 18px;
  font-size: 0.85rem;
  color: #1e293b;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
  transition: background-color 0.15s;
}
.pf-table tbody tr:hover td {
  background-color: #f8fafc;
}

/* Showroom Thumbnail */
.pf-thumb {
  width: 64px;
  height: 48px;
  border-radius: 8px;
  object-fit: cover;
  border: 1px solid #e2e8f0;
  background: #0f172a;
  transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s;
  cursor: pointer;
}
.pf-thumb:hover {
  transform: scale(1.15);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.18);
  z-index: 10;
  position: relative;
}

/* Highlight Benchmarks & Badges */
.pf-benchmark-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 0.74rem;
  font-weight: 800;
  background: rgba(16, 185, 129, 0.1);
  color: #047857;
  border: 1px solid rgba(16, 185, 129, 0.25);
  padding: 3px 9px;
  border-radius: 6px;
  white-space: nowrap;
}
.pf-benchmark-badge.pulse {
  box-shadow: 0 0 10px rgba(16, 185, 129, 0.2);
}

.pf-metric-chip {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  padding: 2px 7px;
  font-size: 0.73rem;
  display: inline-block;
  white-space: nowrap;
}
.pf-metric-chip strong {
  color: #0056d6;
  font-weight: 800;
}

/* Star Featured Toggle */
.pf-star-toggle {
  background: transparent;
  border: 1px solid #cbd5e1;
  color: #94a3b8;
  padding: 5px 9px;
  border-radius: 7px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 0.72rem;
  font-weight: 700;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.pf-star-toggle:hover {
  border-color: #f59e0b;
  color: #d97706;
}
.pf-star-toggle.featured {
  background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(251, 191, 36, 0.15) 100%);
  border-color: #f59e0b;
  color: #b45309;
  box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
}

/* Status Pill Toggle */
.pf-status-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 5px 11px;
  border-radius: 20px;
  font-size: 0.74rem;
  font-weight: 700;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
}
.pf-status-btn.active {
  background: rgba(16, 185, 129, 0.12);
  color: #047857;
}
.pf-status-btn.inactive {
  background: rgba(100, 116, 139, 0.12);
  color: #475569;
}
.pf-status-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: currentColor;
}

/* Action Icons */
.pf-action-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: #f1f5f9;
  color: #475569;
  border: 1px solid #e2e8f0;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
}
.pf-action-icon:hover {
  background: #0056d6;
  color: #ffffff;
  border-color: #0056d6;
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0, 86, 214, 0.25);
}
.pf-action-icon.danger:hover {
  background: #dc2626;
  border-color: #dc2626;
  box-shadow: 0 4px 10px rgba(220, 38, 38, 0.25);
}

/* Visual Cards Grid View */
.pf-cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
  gap: 22px;
  margin-bottom: 30px;
}
.pf-card {
  background: #ffffff;
  border: 1px solid var(--pf-card-border);
  border-radius: 16px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
}
.pf-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 36px -6px rgba(15, 23, 42, 0.12);
  border-color: #cbd5e1;
}

.pf-card-media {
  position: relative;
  height: 180px;
  background: #0f172a;
  overflow: hidden;
}
.pf-card-media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
  opacity: 0.88;
}
.pf-card:hover .pf-card-media img {
  transform: scale(1.06);
}
.pf-card-media-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(15, 23, 42, 0.2) 0%, rgba(15, 23, 42, 0.85) 100%);
}

.pf-card-cat-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background: rgba(255, 255, 255, 0.94);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  color: #0056d6;
  font-size: 0.72rem;
  font-weight: 700;
  padding: 3px 9px;
  border-radius: 6px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.pf-card-top-controls {
  position: absolute;
  top: 12px;
  right: 12px;
  display: flex;
  align-items: center;
  gap: 6px;
}
.pf-card-floating-btn {
  width: 30px;
  height: 30px;
  border-radius: 7px;
  background: rgba(15, 23, 42, 0.65);
  backdrop-filter: blur(6px);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid rgba(255, 255, 255, 0.25);
  cursor: pointer;
  transition: all 0.2s;
}
.pf-card-floating-btn.star.featured {
  background: #f59e0b;
  border-color: #f59e0b;
  color: #ffffff;
}
.pf-card-floating-btn.status {
  width: auto;
  padding: 4px 8px;
  font-size: 0.7rem;
  font-weight: 700;
}
.pf-card-floating-btn.status.live {
  background: rgba(16, 185, 129, 0.9);
}

.pf-card-bench-tag {
  position: absolute;
  bottom: 12px;
  left: 14px;
  background: rgba(16, 185, 129, 0.95);
  backdrop-filter: blur(4px);
  color: #ffffff;
  font-size: 0.74rem;
  font-weight: 800;
  padding: 3px 9px;
  border-radius: 6px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}
.pf-card-duration-tag {
  position: absolute;
  bottom: 12px;
  right: 14px;
  color: #e2e8f0;
  font-size: 0.72rem;
  font-family: var(--font-mono, monospace);
  font-weight: 600;
}

.pf-card-body {
  padding: 18px;
  flex: 1;
  display: flex;
  flex-direction: column;
}
.pf-card-client-meta {
  font-size: 0.74rem;
  color: #0056d6;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  display: flex;
  align-items: center;
  gap: 6px;
}
.pf-card-title {
  font-size: 1.05rem;
  font-weight: 700;
  color: #0f172a;
  margin: 6px 0 8px;
  line-height: 1.35;
}
.pf-card-title a {
  color: inherit;
  text-decoration: none;
  transition: color 0.15s;
}
.pf-card-title a:hover {
  color: #0056d6;
}
.pf-card-excerpt {
  font-size: 0.82rem;
  color: #64748b;
  line-height: 1.5;
  margin-bottom: 14px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.pf-card-metrics-strip {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 6px;
  background: #f8fafc;
  border: 1px solid #f1f5f9;
  border-radius: 8px;
  padding: 8px;
  margin-bottom: 14px;
  text-align: center;
}
.pf-card-metrics-strip .metric-item strong {
  display: block;
  font-size: 0.88rem;
  font-weight: 800;
  color: #0056d6;
}
.pf-card-metrics-strip .metric-item span {
  font-size: 0.65rem;
  color: #64748b;
  line-height: 1.2;
}

.pf-card-tech-pills {
  display: flex;
  gap: 4px;
  flex-wrap: wrap;
  margin-top: auto;
  margin-bottom: 14px;
}
.pf-card-tech-pills span {
  font-size: 0.68rem;
  font-family: var(--font-mono, monospace);
  background: #f1f5f9;
  color: #475569;
  padding: 2px 7px;
  border-radius: 4px;
  border: 1px solid #e2e8f0;
}

.pf-card-footer {
  border-top: 1px solid #f1f5f9;
  padding-top: 12px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

/* ========================================================================
   MODAL OVERLAY SYSTEM (FIXED DIALOG POPUPS)
   ======================================================================== */
.crm-modal-backdrop {
  position: fixed !important;
  inset: 0 !important;
  top: 0 !important;
  left: 0 !important;
  width: 100vw !important;
  height: 100vh !important;
  background: rgba(9, 13, 22, 0.8) !important;
  backdrop-filter: blur(10px) !important;
  -webkit-backdrop-filter: blur(10px) !important;
  z-index: 999999 !important;
  display: none;
  align-items: center !important;
  justify-content: center !important;
  padding: 24px !important;
  box-sizing: border-box !important;
  overflow-y: auto !important;
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
  max-width: 860px !important;
  max-height: 90vh !important;
  display: flex !important;
  flex-direction: column !important;
  box-shadow: 0 25px 60px -10px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.2) !important;
  position: relative !important;
  overflow: hidden !important;
  margin: auto !important;
  animation: crmCardScale 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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

.crm-modal-header {
  padding: 20px 26px;
  background: #ffffff;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: sticky;
  top: 0;
  z-index: 10;
}
.crm-modal-title {
  font-family: var(--font-display, 'Open Sans', sans-serif);
  font-size: 1.25rem;
  font-weight: 800;
  color: #0f172a;
  margin: 0;
  line-height: 1.3;
}
.crm-modal-subtitle {
  font-size: 0.82rem;
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
}
.crm-modal-close:hover {
  background: #e2e8f0;
  color: #0f172a;
}

.crm-modal-body {
  padding: 24px 28px;
  overflow-y: auto;
  flex: 1;
}

/* Custom Sleek Scrollbar */
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
.crm-modal-body::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

.crm-modal-footer {
  padding: 16px 28px;
  background: #f8fafc;
  border-top: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 10px;
  position: sticky;
  bottom: 0;
  z-index: 10;
}

/* Form Controls */
.crm-form-group {
  margin-bottom: 16px;
}
.crm-form-group label {
  display: block;
  font-size: 0.82rem;
  font-weight: 700;
  color: #334155;
  margin-bottom: 6px;
}
.crm-form-input {
  width: 100%;
  height: 40px;
  padding: 8px 14px;
  border: 1px solid #cbd5e1;
  border-radius: 9px;
  font-size: 0.86rem;
  color: #0f172a;
  background: #ffffff;
  transition: all 0.2s ease;
  box-sizing: border-box;
}
.crm-form-input:focus {
  outline: none;
  border-color: #0056d6;
  box-shadow: 0 0 0 3px rgba(0, 86, 214, 0.12);
}
.crm-notes-textarea {
  width: 100%;
  padding: 10px 14px;
  border: 1px solid #cbd5e1;
  border-radius: 9px;
  font-size: 0.86rem;
  font-family: inherit;
  color: #0f172a;
  background: #ffffff;
  resize: vertical;
  transition: all 0.2s ease;
  box-sizing: border-box;
}
.crm-notes-textarea:focus {
  outline: none;
  border-color: #0056d6;
  box-shadow: 0 0 0 3px rgba(0, 86, 214, 0.12);
}

/* Pitch-Deck Dossier Modal Header */
.pf-modal-header-hero {
  background: linear-gradient(135deg, #090d16 0%, #1e293b 100%);
  color: #ffffff;
  padding: 24px 28px;
  border-radius: 20px 20px 0 0;
  position: relative;
  overflow: hidden;
}
.pf-modal-hero-glow {
  position: absolute;
  right: -50px;
  top: -50px;
  width: 220px;
  height: 220px;
  background: radial-gradient(circle, rgba(0, 162, 255, 0.22) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.pf-modal-header-hero .crm-modal-close {
  background: rgba(255, 255, 255, 0.12);
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.2);
}
.pf-modal-header-hero .crm-modal-close:hover {
  background: rgba(255, 255, 255, 0.25);
  color: #ffffff;
}
</style>

<!-- ========================================================================
     PORTFOLIO SHOWROOM MAIN VIEWPORT
     ======================================================================== -->
<div class="admin-content" style="max-width: 1440px; margin: 0 auto;">

  <!-- Flash System Feedback -->
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
  <div class="pf-hero-banner">
    <div class="pf-title-row">
      <div>
        <div class="pf-badge-pill">
          <span class="pf-pulse-dot"></span>
          <span>ENTERPRISE SHOWROOM SUITE • V3.2 LIVE</span>
        </div>
        <h1 class="pf-hero-title">Portfolio & <span>Case Studies Showroom</span></h1>
        <p class="pf-hero-desc">
          Architectural authority and commercial proof points. Curate flagship client engineering dossiers, quantifiable ROI benchmarks, cloud infrastructure diagrams, and public showcase projects.
        </p>
      </div>

      <!-- Action Buttons -->
      <div class="pf-actions-wrap">
        <a href="<?= BASE_URL ?>/portfolio" target="_blank" class="pf-btn pf-btn-glass" title="View Public Portfolio Page">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
          <span>Live Showroom ↗</span>
        </a>

        <a href="<?= BASE_URL ?>/admin/portfolio/export" class="pf-btn pf-btn-glass" title="Export All Showcases to CSV">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
          <span>Export CSV</span>
        </a>

        <button type="button" class="pf-btn pf-btn-primary" onclick="openCreatePortfolioModal()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          <span>+ Add Case Study</span>
        </button>
      </div>
    </div>
  </div>

  <!-- 2. INTERACTIVE EXECUTIVE KPI CARDS -->
  <?php
    $totalCount = (int)($portStats['total'] ?? count($caseStudies));
    $activeCount = (int)($portStats['active'] ?? 0);
    $inactiveCount = (int)($portStats['inactive'] ?? 0);
    $featuredCount = (int)($portStats['featured'] ?? 0);
    $sectorsCount = (int)($portStats['sectors'] ?? ($portStats['sectors_count'] ?? 0));
    $categoriesCount = (int)($portStats['categories'] ?? ($portStats['categories_count'] ?? count($categories)));
  ?>
  <div class="pf-kpi-grid">
    <!-- Card 1: Total Showcases -->
    <div class="pf-kpi-card" onclick="quickFilterStatus('all')" title="Click to view all projects">
      <div class="pf-kpi-top">
        <span class="pf-kpi-label">Total Showcases</span>
        <div class="pf-kpi-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
        </div>
      </div>
      <div class="pf-kpi-val" id="metricTotalCount"><?= $totalCount ?></div>
      <div class="pf-kpi-footer">
        <span class="pf-kpi-pill" style="background: rgba(0, 86, 214, 0.1); color: var(--pf-primary);">Catalog Active</span>
        <span>• Enterprise Portfolio</span>
      </div>
    </div>

    <!-- Card 2: Live & Public -->
    <div class="pf-kpi-card emerald" onclick="quickFilterStatus('active')" title="Click to filter by Live only">
      <div class="pf-kpi-top">
        <span class="pf-kpi-label">Live & Public</span>
        <div class="pf-kpi-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        </div>
      </div>
      <div class="pf-kpi-val" style="color: #059669;" id="metricActiveCount"><?= $activeCount ?></div>
      <div class="pf-kpi-footer">
        <span class="pf-kpi-pill" style="background: rgba(16, 185, 129, 0.12); color: #047857;">Published Live</span>
        <span>• <?= $inactiveCount ?> In Draft</span>
      </div>
    </div>

    <!-- Card 3: Flagship Stars -->
    <div class="pf-kpi-card amber" onclick="quickFilterFeatured('featured')" title="Click to filter by Flagship only">
      <div class="pf-kpi-top">
        <span class="pf-kpi-label">Flagship Showcases</span>
        <div class="pf-kpi-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        </div>
      </div>
      <div class="pf-kpi-val" style="color: #d97706;" id="metricFeaturedCount"><?= $featuredCount ?></div>
      <div class="pf-kpi-footer">
        <span class="pf-kpi-pill" style="background: rgba(245, 158, 11, 0.15); color: #b45309;">Homepage Stars</span>
        <span>• Curated Hero Cases</span>
      </div>
    </div>

    <!-- Card 4: Industry Sectors -->
    <div class="pf-kpi-card purple" title="Unique industry client sectors represented">
      <div class="pf-kpi-top">
        <span class="pf-kpi-label">Industry Sectors</span>
        <div class="pf-kpi-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
        </div>
      </div>
      <div class="pf-kpi-val" style="color: #7c3aed;"><?= $sectorsCount ?></div>
      <div class="pf-kpi-footer">
        <span class="pf-kpi-pill" style="background: rgba(139, 92, 246, 0.12); color: #6d28d9;">Multi-Industry</span>
        <span>• FinTech, AI, SaaS</span>
      </div>
    </div>

    <!-- Card 5: Engineering Taxonomy -->
    <div class="pf-kpi-card cyan" title="Configured engineering categories">
      <div class="pf-kpi-top">
        <span class="pf-kpi-label">Taxonomy Domains</span>
        <div class="pf-kpi-icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
        </div>
      </div>
      <div class="pf-kpi-val" style="color: #0284c7;"><?= $categoriesCount ?></div>
      <div class="pf-kpi-footer">
        <span class="pf-kpi-pill" style="background: rgba(0, 162, 255, 0.12); color: #0369a1;">Practices</span>
        <span>• Web, Mobile & Cloud</span>
      </div>
    </div>
  </div>

  <!-- 3. INTERACTIVE CATEGORY PILL STRIP -->
  <div class="pf-category-strip">
    <button type="button" class="pf-cat-tab <?= ($filters['category'] === 'all' || empty($filters['category'])) ? 'active' : '' ?>" onclick="filterByCategory('all', this)">
      <span>All Categories</span>
      <span class="pf-cat-count"><?= count($caseStudies) ?></span>
    </button>
    <?php foreach ($categories as $cat): ?>
      <?php
        $catCount = 0;
        foreach ($caseStudies as $cs) {
            if ((int)($cs['category_id'] ?? 0) === (int)$cat['id']) {
                $catCount++;
            }
        }
      ?>
      <button type="button" class="pf-cat-tab <?= ($filters['category'] === $cat['slug'] || $filters['category'] === (string)$cat['id']) ? 'active' : '' ?>" onclick="filterByCategory('<?= htmlspecialchars($cat['slug']) ?>', this)">
        <span><?= htmlspecialchars($cat['name']) ?></span>
        <span class="pf-cat-count"><?= $catCount ?></span>
      </button>
    <?php endforeach; ?>
  </div>

  <!-- 4. COMMAND TOOLBAR: SEARCH & SELECTORS & VIEW SWITCHER -->
  <div class="pf-toolbar">
    <!-- Left: Omnibox & Filters -->
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; flex: 1;">
      <!-- Search Input -->
      <div class="pf-search-wrap">
        <svg class="pf-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" id="portfolioSearchInput" class="pf-search-input" placeholder="Search client, title, stack, sector... (Press '/' to search)" value="<?= htmlspecialchars($filters['search'] ?? '') ?>" onkeyup="handleSearchKeyUp(event)" />
        <button type="button" class="pf-search-clear" id="pfSearchClearBtn" onclick="clearSearch()" title="Clear Search">✕</button>
      </div>

      <!-- Domain Category Selector -->
      <select id="portfolioCategorySelect" class="pf-select" onchange="applyFilters()">
        <option value="all">All Domains</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= htmlspecialchars($cat['slug']) ?>" <?= ($filters['category'] === $cat['slug']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <!-- Status Selector -->
      <select id="portfolioStatusSelect" class="pf-select" onchange="applyFilters()">
        <option value="all" <?= ($filters['status'] === 'all') ? 'selected' : '' ?>>All Statuses</option>
        <option value="active" <?= ($filters['status'] === 'active') ? 'selected' : '' ?>>Live & Public</option>
        <option value="inactive" <?= ($filters['status'] === 'inactive') ? 'selected' : '' ?>>Draft / Hidden</option>
      </select>

      <!-- Featured Tier Selector -->
      <select id="portfolioFeaturedSelect" class="pf-select" onchange="applyFilters()">
        <option value="all" <?= ($filters['featured'] === 'all') ? 'selected' : '' ?>>All Tiers</option>
        <option value="featured" <?= ($filters['featured'] === 'featured') ? 'selected' : '' ?>>Flagship Stars Only</option>
        <option value="standard" <?= ($filters['featured'] === 'standard') ? 'selected' : '' ?>>Standard Cases</option>
      </select>

      <!-- Reset Filters Button -->
      <button type="button" id="resetFiltersBtn" onclick="resetAllFilters()" style="display: none; padding: 7px 12px; font-size: 0.8rem; background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; border-radius: 8px; font-weight: 700; cursor: pointer;">
        ✕ Reset Filters
      </button>
    </div>

    <!-- Right Controls: View Switcher (Table vs Cards) & Results Counter -->
    <div style="display: flex; align-items: center; gap: 14px;">
      <span style="font-size: 0.82rem; color: #64748b; font-family: var(--font-mono, monospace);">
        Showing <strong style="color: #0f172a;" id="renderedCount"><?= count($caseStudies) ?></strong> projects
      </span>

      <!-- Dual View Switcher -->
      <div class="pf-view-toggle">
        <button type="button" id="btnViewTable" class="pf-toggle-btn active" onclick="switchView('table')" title="Dense Data Table">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
          <span>Table</span>
        </button>
        <button type="button" id="btnViewGrid" class="pf-toggle-btn" onclick="switchView('grid')" title="Visual Cards Showcase">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
          <span>Showcase Cards</span>
        </button>
      </div>
    </div>
  </div>

  <!-- 5. VIEW 1: MASTER DATA TABLE VIEW -->
  <div id="portfolioTableView" class="pf-table-panel">
    <div style="overflow-x: auto;">
      <table class="pf-table" id="portfolioTable">
        <thead>
          <tr>
            <th style="width: 55px; text-align: center;">Order</th>
            <th style="min-width: 320px;">Project & Client Identity</th>
            <th style="min-width: 140px;">Sector & Domain</th>
            <th style="min-width: 150px;">Result Benchmark</th>
            <th style="min-width: 220px;">Key Transformation Metrics</th>
            <th style="width: 120px; text-align: center;">Flagship Star</th>
            <th style="width: 110px; text-align: center;">Status</th>
            <th style="width: 150px; text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody id="portfolioTableBody">
          <?php if (empty($caseStudies)): ?>
            <tr id="emptyTableMessage">
              <td colspan="8" style="text-align: center; padding: 60px 24px; color: #64748b;">
                <div style="font-size: 2.5rem; margin-bottom: 12px;">💼</div>
                <div style="font-weight: 800; font-size: 1.15rem; color: #0f172a;">No case studies match your query</div>
                <p style="font-size: 0.88rem; margin-top: 6px; color: #64748b;">Adjust your category or keyword filters, or publish your first showcase deployment.</p>
                <button type="button" class="pf-btn pf-btn-primary" onclick="openCreatePortfolioModal()" style="margin-top: 16px;">
                  + Add First Case Study
                </button>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($caseStudies as $cs): ?>
              <?php
                $catName = $cs['category_name'] ?? 'Enterprise Engineering';
                $isFeatured = (int)($cs['is_featured'] ?? 0) === 1;
                $isActive = (int)($cs['is_active'] ?? 1) === 1;

                // Support both array decoded and json string gracefully
                $metrics = $cs['key_metrics_arr'] ?? (is_array($cs['key_metrics'] ?? null) ? $cs['key_metrics'] : (json_decode((string)($cs['key_metrics'] ?? ''), true) ?: []));
                $techs = $cs['technologies_arr'] ?? (is_array($cs['technologies'] ?? null) ? $cs['technologies'] : (json_decode((string)($cs['technologies'] ?? ''), true) ?: []));
                
                $thumb = !empty($cs['featured_image']) ? $cs['featured_image'] : 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=400&auto=format&fit=crop';
              ?>
              <tr id="csRow-<?= (int)$cs['id'] ?>" 
                  class="portfolio-data-row"
                  data-title="<?= htmlspecialchars(strtolower((string)$cs['title'])) ?>" 
                  data-client="<?= htmlspecialchars(strtolower((string)$cs['client_name'])) ?>" 
                  data-sector="<?= htmlspecialchars(strtolower((string)$cs['sector_industry'])) ?>"
                  data-category="<?= htmlspecialchars(strtolower((string)($cs['category_slug'] ?? ''))) ?>"
                  data-status="<?= $isActive ? 'active' : 'inactive' ?>"
                  data-featured="<?= $isFeatured ? 'featured' : 'standard' ?>">
                
                <!-- Order Num -->
                <td style="text-align: center; font-family: var(--font-mono, monospace); font-size: 0.78rem; color: #94a3b8; font-weight: 700;">
                  #<?= (int)$cs['order_num'] ?>
                </td>

                <!-- Project & Client Identity -->
                <td>
                  <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <img src="<?= htmlspecialchars($thumb) ?>" alt="<?= htmlspecialchars((string)$cs['title']) ?>" 
                         class="pf-thumb" 
                         onclick="viewPortfolioDossier(<?= (int)$cs['id'] ?>)"
                         onerror="this.src='https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=200&auto=format&fit=crop';" />
                    
                    <div style="min-width: 0;">
                      <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                        <a href="javascript:void(0)" onclick="viewPortfolioDossier(<?= (int)$cs['id'] ?>)" style="font-weight: 700; color: #0f172a; font-size: 0.94rem; text-decoration: none;" class="cap-title-link">
                          <?= htmlspecialchars((string)$cs['title']) ?>
                        </a>
                      </div>
                      
                      <div style="font-size: 0.78rem; color: #64748b; margin-top: 3px; display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                        <strong style="color: #0056d6;"><?= htmlspecialchars((string)$cs['client_name']) ?></strong>
                        <?php if (!empty($cs['client_location'])): ?>
                          <span style="color: #94a3b8;">• <?= htmlspecialchars((string)$cs['client_location']) ?></span>
                        <?php endif; ?>
                        <span style="color: #94a3b8;">•</span>
                        <code style="font-family: var(--font-mono, monospace); font-size: 0.72rem; color: #64748b; background: #f1f5f9; padding: 1px 5px; border-radius: 4px;"><?= htmlspecialchars((string)$cs['slug']) ?></code>
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Sector & Domain -->
                <td>
                  <div style="font-size: 0.85rem; font-weight: 700; color: #0f172a;">
                    <?= htmlspecialchars((string)$cs['sector_industry']) ?>
                  </div>
                  <div style="font-size: 0.72rem; color: #64748b; margin-top: 2px;">
                    <span style="background: rgba(0, 86, 214, 0.08); color: #0056d6; padding: 1px 7px; border-radius: 4px; font-weight: 700;">
                      <?= htmlspecialchars((string)$catName) ?>
                    </span>
                  </div>
                </td>

                <!-- Result Benchmark -->
                <td>
                  <?php if (!empty($cs['result_badge'])): ?>
                    <span class="pf-benchmark-badge pulse">
                      ⚡ <?= htmlspecialchars((string)$cs['result_badge']) ?>
                    </span>
                  <?php else: ?>
                    <span style="color: #94a3b8; font-size: 0.78rem;">—</span>
                  <?php endif; ?>
                  
                  <?php if (!empty($cs['timeline_duration'])): ?>
                    <div style="font-size: 0.72rem; color: #64748b; margin-top: 4px; font-family: var(--font-mono, monospace);">
                      ⏱ <?= htmlspecialchars((string)$cs['timeline_duration']) ?>
                    </div>
                  <?php endif; ?>
                </td>

                <!-- Key Transformation Metrics -->
                <td>
                  <?php if (!empty($metrics)): ?>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                      <?php foreach (array_slice($metrics, 0, 2) as $m): ?>
                        <div class="pf-metric-chip">
                          <strong><?= htmlspecialchars((string)($m['val'] ?? '')) ?></strong>
                          <span style="color: #64748b; font-size: 0.7rem; margin-left: 2px;"><?= htmlspecialchars((string)($m['lbl'] ?? '')) ?></span>
                        </div>
                      <?php endforeach; ?>
                      <?php if (count($metrics) > 2): ?>
                        <span style="font-size: 0.7rem; color: #94a3b8; align-self: center; font-weight: 700;">+<?= count($metrics) - 2 ?></span>
                      <?php endif; ?>
                    </div>
                  <?php else: ?>
                    <span style="color: #94a3b8; font-size: 0.78rem;">No metrics logged</span>
                  <?php endif; ?>
                </td>

                <!-- Flagship Star Toggle -->
                <td style="text-align: center;">
                  <button type="button" 
                          class="pf-star-toggle <?= $isFeatured ? 'featured' : '' ?>" 
                          id="btnFeatured-<?= (int)$cs['id'] ?>"
                          onclick="togglePortfolioFeatured(<?= (int)$cs['id'] ?>)" 
                          title="<?= $isFeatured ? 'Flagship Hero: Click to unfeature' : 'Click to feature on homepage' ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="<?= $isFeatured ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span><?= $isFeatured ? 'Hero Star' : 'Regular' ?></span>
                  </button>
                </td>

                <!-- Live Status Toggle -->
                <td style="text-align: center;">
                  <button type="button" 
                          class="pf-status-btn <?= $isActive ? 'active' : 'inactive' ?>" 
                          id="btnStatus-<?= (int)$cs['id'] ?>"
                          onclick="togglePortfolioStatus(<?= (int)$cs['id'] ?>)" 
                          title="Click to toggle Live/Draft state">
                    <span class="pf-status-dot"></span>
                    <span id="btnStatusText-<?= (int)$cs['id'] ?>"><?= $isActive ? 'Live' : 'Draft' ?></span>
                  </button>
                </td>

                <!-- Action Button Group -->
                <td style="text-align: right;">
                  <div style="display: inline-flex; align-items: center; gap: 5px;">
                    <!-- View Dossier -->
                    <button type="button" class="pf-action-icon" onclick="viewPortfolioDossier(<?= (int)$cs['id'] ?>)" title="Inspect Full Dossier">
                      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>

                    <!-- Edit Case Study -->
                    <button type="button" class="pf-action-icon" onclick="editPortfolio(<?= (int)$cs['id'] ?>)" title="Edit Case Study">
                      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>

                    <!-- Duplicate Showcase -->
                    <button type="button" class="pf-action-icon" onclick="duplicatePortfolio(<?= (int)$cs['id'] ?>)" title="Duplicate / Clone Showcase">
                      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    </button>

                    <!-- Delete Case Study -->
                    <button type="button" class="pf-action-icon danger" onclick="confirmDeletePortfolio(<?= (int)$cs['id'] ?>, '<?= htmlspecialchars(addslashes((string)$cs['title'])) ?>')" title="Delete Case Study">
                      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
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

  <!-- 6. VIEW 2: VISUAL SHOWCASE CARDS GRID VIEW -->
  <div id="portfolioGridView" style="display: none; margin-bottom: 30px;">
    <?php if (empty($caseStudies)): ?>
      <div class="pf-table-panel" style="text-align: center; padding: 60px 24px;">
        <div style="font-size: 2.5rem; margin-bottom: 12px;">💼</div>
        <div style="font-weight: 800; font-size: 1.15rem; color: #0f172a;">No case studies match your query</div>
        <p style="font-size: 0.88rem; margin-top: 6px; color: #64748b;">Adjust your category or keyword filters.</p>
      </div>
    <?php else: ?>
      <div class="pf-cards-grid" id="portfolioCardsContainer">
        <?php foreach ($caseStudies as $cs): ?>
          <?php
            $catName = $cs['category_name'] ?? 'Enterprise Engineering';
            $isFeatured = (int)($cs['is_featured'] ?? 0) === 1;
            $isActive = (int)($cs['is_active'] ?? 1) === 1;

            $metrics = $cs['key_metrics_arr'] ?? (is_array($cs['key_metrics'] ?? null) ? $cs['key_metrics'] : (json_decode((string)($cs['key_metrics'] ?? ''), true) ?: []));
            $techs = $cs['technologies_arr'] ?? (is_array($cs['technologies'] ?? null) ? $cs['technologies'] : (json_decode((string)($cs['technologies'] ?? ''), true) ?: []));
            $thumb = !empty($cs['featured_image']) ? $cs['featured_image'] : 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=600&auto=format&fit=crop';
          ?>
          <div class="pf-card portfolio-card-item" 
               id="csCard-<?= (int)$cs['id'] ?>"
               data-title="<?= htmlspecialchars(strtolower((string)$cs['title'])) ?>" 
               data-client="<?= htmlspecialchars(strtolower((string)$cs['client_name'])) ?>" 
               data-sector="<?= htmlspecialchars(strtolower((string)$cs['sector_industry'])) ?>"
               data-category="<?= htmlspecialchars(strtolower((string)($cs['category_slug'] ?? ''))) ?>"
               data-status="<?= $isActive ? 'active' : 'inactive' ?>"
               data-featured="<?= $isFeatured ? 'featured' : 'standard' ?>">
            
            <!-- Card Media Banner -->
            <div class="pf-card-media">
              <img src="<?= htmlspecialchars($thumb) ?>" alt="<?= htmlspecialchars((string)$cs['title']) ?>" 
                   onerror="this.src='https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=600&auto=format&fit=crop';" />
              
              <div class="pf-card-media-overlay"></div>

              <!-- Top Left Category Pill -->
              <span class="pf-card-cat-badge">
                <?= htmlspecialchars((string)$catName) ?>
              </span>

              <!-- Top Right Controls -->
              <div class="pf-card-top-controls">
                <button type="button" 
                        onclick="togglePortfolioFeatured(<?= (int)$cs['id'] ?>)" 
                        id="cardFeatured-<?= (int)$cs['id'] ?>"
                        class="pf-card-floating-btn star <?= $isFeatured ? 'featured' : '' ?>"
                        title="<?= $isFeatured ? 'Flagship Showcase' : 'Feature this study' ?>">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="<?= $isFeatured ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                </button>

                <button type="button" 
                        onclick="togglePortfolioStatus(<?= (int)$cs['id'] ?>)" 
                        id="cardStatus-<?= (int)$cs['id'] ?>"
                        class="pf-card-floating-btn status <?= $isActive ? 'live' : '' ?>"
                        title="<?= $isActive ? 'Published Live' : 'Draft' ?>">
                  <?= $isActive ? 'Live' : 'Draft' ?>
                </button>
              </div>

              <!-- Bottom Overlay Result Benchmark -->
              <?php if (!empty($cs['result_badge'])): ?>
                <div class="pf-card-bench-tag">
                  ⚡ <?= htmlspecialchars((string)$cs['result_badge']) ?>
                </div>
              <?php endif; ?>

              <?php if (!empty($cs['timeline_duration'])): ?>
                <div class="pf-card-duration-tag">
                  ⏱ <?= htmlspecialchars((string)$cs['timeline_duration']) ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Card Body Content -->
            <div class="pf-card-body">
              <div class="pf-card-client-meta">
                <span><?= htmlspecialchars((string)$cs['client_name']) ?></span>
                <?php if (!empty($cs['client_location'])): ?>
                  <span style="color: #94a3b8; font-weight: 500;">(<?= htmlspecialchars((string)$cs['client_location']) ?>)</span>
                <?php endif; ?>
              </div>

              <h3 class="pf-card-title">
                <a href="javascript:void(0)" onclick="viewPortfolioDossier(<?= (int)$cs['id'] ?>)">
                  <?= htmlspecialchars((string)$cs['title']) ?>
                </a>
              </h3>

              <?php if (!empty($cs['excerpt'])): ?>
                <p class="pf-card-excerpt">
                  <?= htmlspecialchars((string)$cs['excerpt']) ?>
                </p>
              <?php endif; ?>

              <!-- Key Metrics Highlight Strip -->
              <?php if (!empty($metrics)): ?>
                <div class="pf-card-metrics-strip">
                  <?php foreach (array_slice($metrics, 0, 3) as $m): ?>
                    <div class="metric-item">
                      <strong><?= htmlspecialchars((string)($m['val'] ?? '')) ?></strong>
                      <span><?= htmlspecialchars((string)($m['lbl'] ?? '')) ?></span>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

              <!-- Tech Stack Pills -->
              <?php if (!empty($techs)): ?>
                <div class="pf-card-tech-pills">
                  <?php foreach (array_slice($techs, 0, 3) as $t): ?>
                    <span><?= htmlspecialchars((string)$t) ?></span>
                  <?php endforeach; ?>
                  <?php if (count($techs) > 3): ?>
                    <span style="color: #94a3b8; border-style: dashed;">+<?= count($techs) - 3 ?></span>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

              <!-- Card Action Bar -->
              <div class="pf-card-footer">
                <div style="display: flex; align-items: center; gap: 6px;">
                  <button type="button" class="pf-btn pf-btn-glass" onclick="viewPortfolioDossier(<?= (int)$cs['id'] ?>)" style="padding: 5px 10px; font-size: 0.76rem; background: #f8fafc; border: 1px solid #cbd5e1; color: #1e293b;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    <span>Dossier</span>
                  </button>

                  <button type="button" class="pf-btn pf-btn-glass" onclick="editPortfolio(<?= (int)$cs['id'] ?>)" style="padding: 5px 10px; font-size: 0.76rem; background: #f8fafc; border: 1px solid #cbd5e1; color: #1e293b;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    <span>Edit</span>
                  </button>
                </div>

                <div style="display: flex; align-items: center; gap: 4px;">
                  <button type="button" class="pf-action-icon" onclick="duplicatePortfolio(<?= (int)$cs['id'] ?>)" title="Clone Case Study">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                  </button>
                  <button type="button" class="pf-action-icon danger" onclick="confirmDeletePortfolio(<?= (int)$cs['id'] ?>, '<?= htmlspecialchars(addslashes((string)$cs['title'])) ?>')" title="Delete Case Study">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</div><!-- /admin-content -->


<!-- ========================================================================
     MODAL 1: EXECUTIVE CASE STUDY DOSSIER MODAL (PITCH DECK POPUP)
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="viewPortfolioModalBackdrop" style="display: none;" onclick="closeViewPortfolioModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 880px;" onclick="event.stopPropagation()">
    
    <!-- Modal Header -->
    <div class="pf-modal-header-hero">
      <div class="pf-modal-hero-glow"></div>
      <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; position: relative; z-index: 2;">
        <div style="flex: 1;">
          <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; flex-wrap: wrap;">
            <span id="viewDossierCategory" style="font-size: 0.72rem; font-family: var(--font-mono, monospace); font-weight: 800; background: rgba(0, 162, 255, 0.2); color: #38bdf8; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">
              CATEGORY
            </span>
            <span id="viewDossierResultBadge" style="font-size: 0.72rem; font-weight: 800; background: rgba(16, 185, 129, 0.25); color: #34d399; padding: 2px 8px; border-radius: 4px;">
              RESULT
            </span>
            <span id="viewDossierFeaturedBadge" style="display: none; font-size: 0.72rem; font-weight: 800; background: rgba(245, 158, 11, 0.25); color: #fbbf24; padding: 2px 8px; border-radius: 4px;">
              ★ FLAGSHIP SHOWCASE
            </span>
          </div>

          <h2 id="viewDossierTitle" style="font-size: 1.45rem; font-weight: 800; margin: 0; color: #ffffff; line-height: 1.3;">
            Case Study Title
          </h2>

          <div style="font-size: 0.84rem; color: #cbd5e1; margin-top: 6px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
            <span id="viewDossierClient" style="font-weight: 800; color: #ffffff;">Client Name</span>
            <span>•</span>
            <span id="viewDossierLocation">Location</span>
            <span>•</span>
            <span id="viewDossierSector">Industry Sector</span>
            <span>•</span>
            <span id="viewDossierTimeline" style="font-family: var(--font-mono, monospace);">Timeline</span>
          </div>
        </div>

        <button type="button" class="crm-modal-close" onclick="closeViewPortfolioModal()" aria-label="Close dialog">✕</button>
      </div>
    </div>

    <!-- Modal Body -->
    <div class="crm-modal-body" style="padding: 26px;">
      
      <!-- Featured Image Banner with Overlaid Action Links -->
      <div style="position: relative; border-radius: 12px; overflow: hidden; margin-bottom: 24px; max-height: 280px; background: #0f172a; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
        <img id="viewDossierImage" src="" alt="Showcase Preview" style="width: 100%; height: 280px; object-fit: cover;" />
        <div style="position: absolute; bottom: 14px; right: 14px; display: flex; gap: 8px;">
          <a id="viewDossierLiveBtn" href="#" target="_blank" class="pf-btn pf-btn-primary" style="padding: 7px 14px; font-size: 0.8rem; text-decoration: none;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
            <span>Visit Live Application</span>
          </a>
          <a id="viewDossierGithubBtn" href="#" target="_blank" class="pf-btn pf-btn-glass" style="padding: 7px 14px; font-size: 0.8rem; text-decoration: none; background: rgba(15,23,42,0.85); border: 1px solid rgba(255,255,255,0.25);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
            <span>Repository</span>
          </a>
        </div>
      </div>

      <!-- Key Metrics Transformation Row -->
      <div style="margin-bottom: 24px;">
        <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
          <span>Measurable Transformation Benchmarks</span>
        </div>
        <div id="viewDossierMetricsGrid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
          <!-- Injected dynamically via JS -->
        </div>
      </div>

      <!-- Executive Synopsis -->
      <div style="margin-bottom: 24px;">
        <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin-bottom: 8px;">
          Executive Synopsis
        </div>
        <p id="viewDossierExcerpt" style="font-size: 0.94rem; color: #0f172a; line-height: 1.65; background: #f8fafc; padding: 16px 18px; border-radius: 10px; border-left: 4px solid #0056d6; border-top: 1px solid #f1f5f9; border-right: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; margin: 0;">
          Excerpt synopsis...
        </p>
      </div>

      <!-- Challenge & Architecture Solution Matrix -->
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <!-- The Challenge -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
          <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
            <div style="width: 26px; height: 26px; border-radius: 7px; background: rgba(220, 38, 38, 0.1); color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 800;">!</div>
            <h4 style="font-size: 0.88rem; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">The Engineering Challenge</h4>
          </div>
          <p id="viewDossierChallenge" style="font-size: 0.86rem; color: #475569; line-height: 1.6; white-space: pre-line; margin: 0;">
            Challenge description...
          </p>
        </div>

        <!-- The Architecture Solution -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
          <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
            <div style="width: 26px; height: 26px; border-radius: 7px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 800;">✓</div>
            <h4 style="font-size: 0.88rem; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">Architecture & Implementation</h4>
          </div>
          <p id="viewDossierSolution" style="font-size: 0.86rem; color: #475569; line-height: 1.6; white-space: pre-line; margin: 0;">
            Solution description...
          </p>
        </div>
      </div>

      <!-- Technology Stack Matrix -->
      <div style="margin-bottom: 10px;">
        <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin-bottom: 10px;">
          Production Technology Stack
        </div>
        <div id="viewDossierTechStack" style="display: flex; gap: 7px; flex-wrap: wrap;">
          <!-- Injected via JS -->
        </div>
      </div>

    </div>

    <!-- Modal Footer -->
    <div class="crm-modal-footer">
      <div style="font-size: 0.76rem; color: #94a3b8; font-family: var(--font-mono, monospace); margin-right: auto;">
        DOSSIER ID: #<span id="viewDossierId">0</span>
      </div>

      <button type="button" class="pf-btn pf-btn-glass" onclick="closeViewPortfolioModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
        Close
      </button>
      <button type="button" class="pf-btn pf-btn-primary" id="viewDossierEditBtn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        <span>Edit This Case Study</span>
      </button>
    </div>

  </div>
</div>


<!-- ========================================================================
     MODAL 2: CREATE / EDIT CASE STUDY MODAL (AUTHORING STUDIO POPUP)
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="editPortfolioModalBackdrop" style="display: none;" onclick="closeEditPortfolioModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 900px;" onclick="event.stopPropagation()">
    
    <!-- Modal Header -->
    <div class="crm-modal-header">
      <div>
        <h3 class="crm-modal-title" id="editPortfolioModalTitle">Create Flagship Case Study</h3>
        <p class="crm-modal-subtitle">Curate high-impact client engineering showcase and transformation proof points.</p>
      </div>
      <button type="button" class="crm-modal-close" onclick="closeEditPortfolioModal()" aria-label="Close dialog">✕</button>
    </div>

    <!-- Modal Form -->
    <form id="portfolioForm" class="crm-modal-form" onsubmit="submitPortfolioForm(event)">
      <input type="hidden" id="csFieldId" name="id" value="0" />

      <div class="crm-modal-body">

        <!-- SECTION 1: CORE SHOWCASE IDENTITY -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 0 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          1. Enterprise Showcase Identity & Domain
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 14px; margin-bottom: 14px;">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldTitle">Case Study Title *</label>
            <input type="text" id="csFieldTitle" name="title" class="crm-form-input" placeholder="e.g. Next-Gen Algorithmic Trading Platform Architecture" required oninput="handleTitleInput(this.value)" />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldCategory">Engineering Category *</label>
            <select id="csFieldCategory" name="category_id" class="crm-form-input" required>
              <option value="">Select Domain...</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-bottom: 14px;">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldClient">Client Enterprise Name *</label>
            <input type="text" id="csFieldClient" name="client_name" class="crm-form-input" placeholder="e.g. FinPulse Global Inc." required />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldLocation">Client HQ / Location</label>
            <input type="text" id="csFieldLocation" name="client_location" class="crm-form-input" placeholder="e.g. London & San Francisco" />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldSector">Industry / Sector</label>
            <input type="text" id="csFieldSector" name="sector_industry" class="crm-form-input" placeholder="e.g. Fintech & High-Frequency Trading" />
          </div>
        </div>

        <div class="crm-form-group" style="margin-bottom: 22px;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
            <label for="csFieldSlug" style="margin-bottom: 0;">URL Slug *</label>
            <label style="font-size: 0.74rem; color: #64748b; cursor: pointer; display: flex; align-items: center; gap: 4px;">
              <input type="checkbox" id="csAutoSlugCheck" checked onchange="toggleAutoSlug(this.checked)" />
              Auto-generate from title
            </label>
          </div>
          <div style="display: flex; align-items: center; gap: 8px;">
            <span style="font-family: var(--font-mono, monospace); font-size: 0.78rem; color: #64748b; background: #f8fafc; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px;">/portfolio/</span>
            <input type="text" id="csFieldSlug" name="slug" class="crm-form-input" placeholder="e.g. next-gen-algorithmic-trading" required style="font-family: var(--font-mono, monospace); font-size: 0.85rem;" />
          </div>
        </div>

        <!-- SECTION 2: RESULTS & TRANSFORMATION METRICS -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 24px 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          2. Measurable Transformation Metrics & Highlights
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldResultBadge">Headline Result Badge *</label>
            <input type="text" id="csFieldResultBadge" name="result_badge" class="crm-form-input" placeholder="e.g. +310% ARR Growth, 12ms Latency, 99.999% SLA" value="+150% Scalability" required />
            <span style="font-size: 0.72rem; color: #64748b; margin-top: 3px; display: block;">Displays prominently on card previews and top hero highlights.</span>
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldTimeline">Delivery Duration</label>
            <input type="text" id="csFieldTimeline" name="timeline_duration" class="crm-form-input" placeholder="e.g. 4.5 Months / 12 Sprints" value="3.5 Months" />
          </div>
        </div>

        <!-- Dynamic Key Metric Pairs Builder -->
        <div class="crm-form-group" style="margin-bottom: 22px;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <label style="margin-bottom: 0;">Key Metric Badges (Up to 4 High-Impact Quantifiable Pairs)</label>
            <button type="button" class="pf-btn pf-btn-glass" onclick="addMetricRow()" style="padding: 4px 10px; font-size: 0.74rem; background: #ffffff; border: 1px solid #cbd5e1; color: #0056d6;">
              + Add Metric
            </button>
          </div>

          <div id="metricsBuilderContainer" style="display: flex; flex-direction: column; gap: 8px;">
            <!-- Injected dynamically via JS -->
          </div>
          <span style="font-size: 0.72rem; color: #64748b; display: block; margin-top: 5px;">Format: Value (e.g. "+310%", "12ms", "$2.4M", "99.99%") and Short Label (e.g. "ARR Growth", "Latency Drop", "Cost Savings").</span>
        </div>

        <!-- SECTION 3: STORY & ARCHITECTURAL SCOPE -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 24px 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          3. Technical Narrative & Architectural Methodology
        </div>

        <div class="crm-form-group">
          <label for="csFieldExcerpt">Executive Synopsis (Excerpt) *</label>
          <textarea id="csFieldExcerpt" name="excerpt" class="crm-notes-textarea" style="min-height: 65px;" placeholder="Crisp 2-sentence summary shown on cards and search engines..." required></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldChallenge">The Engineering Bottleneck / Challenge</label>
            <textarea id="csFieldChallenge" name="challenge_overview" class="crm-notes-textarea" style="min-height: 95px;" placeholder="What business bottlenecks, scale limits, or legacy friction did the client face?"></textarea>
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldSolution">ClickCodex Architecture & Solution</label>
            <textarea id="csFieldSolution" name="architecture_solution" class="crm-notes-textarea" style="min-height: 95px;" placeholder="How did our engineering pod architect and execute the transformation?"></textarea>
          </div>
        </div>

        <!-- SECTION 4: TECH STACK MATRIX & DIGITAL ASSETS -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 24px 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          4. Technology Matrix & Public Links
        </div>

        <div class="crm-form-group" style="margin-bottom: 16px;">
          <label for="csFieldTechStack">Tech Stack Matrix (Comma-Separated)</label>
          <input type="text" id="csFieldTechStack" name="technologies" class="crm-form-input" placeholder="e.g. Next.js 15, TypeScript, Node.js, Go, PostgreSQL, Docker, AWS" />
          
          <!-- Quick Add Pills -->
          <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap; margin-top: 8px;">
            <span style="font-size: 0.72rem; color: #64748b; font-weight: 600;">Quick Add:</span>
            <?php
              $presetTechs = ['Next.js 15', 'TypeScript', 'Node.js', 'Go', 'Python', 'FastAPI', 'Docker', 'Kubernetes', 'AWS', 'PostgreSQL', 'Redis', 'GraphQL', 'Flutter', 'Swift', 'Kafka', 'TailwindCSS'];
              foreach ($presetTechs as $pt):
            ?>
              <button type="button" onclick="appendTechTag('<?= htmlspecialchars($pt) ?>')" style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #334155; cursor: pointer; transition: all 0.15s;">
                + <?= htmlspecialchars($pt) ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Featured Image URL with Live Thumbnail Preview -->
        <div class="crm-form-group" style="margin-bottom: 16px;">
          <label for="csFieldImage">Featured Image URL</label>
          <div style="display: flex; gap: 10px; align-items: center;">
            <input type="url" id="csFieldImage" name="featured_image" class="crm-form-input" placeholder="https://images.unsplash.com/..." oninput="updateImagePreview(this.value)" value="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop" />
            <img id="csImagePreview" src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop" alt="Thumbnail Preview" style="width: 52px; height: 40px; border-radius: 8px; object-fit: cover; border: 1px solid #cbd5e1; flex-shrink: 0;" />
          </div>

          <!-- Unsplash Presets -->
          <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px;">
            <span style="font-size: 0.72rem; color: #64748b; font-weight: 600;">Image Presets:</span>
            <button type="button" onclick="setImagePreset('https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">Fintech/Dashboard</button>
            <button type="button" onclick="setImagePreset('https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=800&auto=format&fit=crop')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">Mobile App</button>
            <button type="button" onclick="setImagePreset('https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=800&auto=format&fit=crop')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">E-Commerce</button>
            <button type="button" onclick="setImagePreset('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=800&auto=format&fit=crop')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">AI/Cloud</button>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldLiveUrl">Live Application URL</label>
            <input type="url" id="csFieldLiveUrl" name="live_project_url" class="crm-form-input" placeholder="https://client-demo.com" />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldGithubUrl">GitHub / Git Repository URL</label>
            <input type="url" id="csFieldGithubUrl" name="github_url" class="crm-form-input" placeholder="https://github.com/clickcodex/..." />
          </div>
        </div>

        <!-- SECTION 5: PUBLICATION & SHOWCASE VISIBILITY -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 24px 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          5. Publication Visibility & Ordering
        </div>

        <div style="display: grid; grid-template-columns: 120px 1fr 1fr; gap: 16px; align-items: center; background: #f8fafc; padding: 16px 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="csFieldOrder">Sort Order #</label>
            <input type="number" id="csFieldOrder" name="order_num" class="crm-form-input" value="1" min="0" />
          </div>

          <div style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" id="csFieldFeatured" name="is_featured" value="1" style="width: 18px; height: 18px; cursor: pointer; accent-color: #f59e0b;" />
            <label for="csFieldFeatured" style="margin-bottom: 0; cursor: pointer; font-size: 0.86rem; font-weight: 700; color: #0f172a;">
              ★ Flagship Hero Feature
              <span style="display: block; font-size: 0.72rem; color: #64748b; font-weight: 400;">Highlight prominently on homepage and public hero showcases.</span>
            </label>
          </div>

          <div style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" id="csFieldActive" name="is_active" value="1" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #10b981;" />
            <label for="csFieldActive" style="margin-bottom: 0; cursor: pointer; font-size: 0.86rem; font-weight: 700; color: #0f172a;">
              ● Live & Public
              <span style="display: block; font-size: 0.72rem; color: #64748b; font-weight: 400;">Showcase is immediately visible on the public website.</span>
            </label>
          </div>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="crm-modal-footer">
        <button type="button" class="pf-btn pf-btn-glass" onclick="closeEditPortfolioModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
          Cancel
        </button>
        <button type="submit" class="pf-btn pf-btn-primary" id="btnSubmitPortfolio">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span id="btnSubmitPortfolioText">Save Case Study</span>
        </button>
      </div>

    </form>
  </div>
</div>


<!-- ========================================================================
     MODAL 3: DELETE CONFIRMATION DIALOG (POPUP)
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="deletePortfolioModalBackdrop" style="display: none;" onclick="closeDeletePortfolioModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 440px;" onclick="event.stopPropagation()">
    <div class="crm-modal-header" style="border-bottom: none; padding-bottom: 0;">
      <div style="width: 46px; height: 46px; border-radius: 50%; background: rgba(220, 38, 38, 0.12); color: #dc2626; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
      </div>
      <h3 class="crm-modal-title" style="color: #0f172a; font-size: 1.2rem;">Delete Case Study</h3>
      <p class="crm-modal-subtitle" style="margin-top: 6px; font-size: 0.85rem;">Are you sure you want to remove <strong id="deleteTargetTitle" style="color: #0f172a;"></strong> from the ClickCodex showroom?</p>
    </div>

    <div class="crm-modal-body" style="padding: 16px 26px; font-size: 0.84rem; color: #64748b; line-height: 1.5;">
      This action will permanently delete this engineering dossier from the database. Any client testimonials linked to this project will be preserved.
    </div>

    <div class="crm-modal-footer" style="padding: 16px 26px; border-top: 1px solid #f1f5f9;">
      <button type="button" class="pf-btn pf-btn-glass" onclick="closeDeletePortfolioModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
        Cancel
      </button>
      <button type="button" class="pf-btn" id="btnConfirmDeleteAction" style="background: #dc2626; color: #ffffff; border: none; font-weight: 700;">
        Yes, Delete Record
      </button>
    </div>
  </div>
</div>


<!-- Toast Notifications Overlay -->
<div id="adminToastContainer" style="position: fixed; bottom: 24px; right: 24px; z-index: 99999; display: flex; flex-direction: column; gap: 8px; pointer-events: none;"></div>


<!-- ========================================================================
     PORTFOLIO JAVASCRIPT CONTROLLER
     ======================================================================== -->
<script>
/**
 * ClickCodex Studio - Portfolio & Case Studies Controller
 */
const BASE_URL = '<?= BASE_URL ?>';
let autoSlugEnabled = true;
let deleteTargetId = 0;
let currentViewMode = 'table'; // 'table' or 'grid'

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
  // Restore saved view mode preference
  const savedView = localStorage.getItem('cc_portfolio_view');
  if (savedView === 'grid') {
    switchView('grid');
  }

  // Keyboard shortcut '/' to focus search & Esc to close modals
  document.addEventListener('keydown', (e) => {
    if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
      e.preventDefault();
      const s = document.getElementById('portfolioSearchInput');
      if (s) { s.focus(); s.select(); }
    } else if (e.key === 'Escape') {
      closeViewPortfolioModal();
      closeEditPortfolioModal();
      closeDeletePortfolioModal();
    }
  });

  // Check if clear button should be shown
  toggleClearSearchBtn();
});

// Toast notification helper
function showToast(message, type = 'success') {
  const container = document.getElementById('adminToastContainer');
  if (!container) return;

  const toast = document.createElement('div');
  toast.style.padding = '12px 18px';
  toast.style.borderRadius = '10px';
  toast.style.fontSize = '0.85rem';
  toast.style.fontWeight = '600';
  toast.style.boxShadow = '0 10px 25px -5px rgba(0,0,0,0.18), 0 8px 10px -6px rgba(0,0,0,0.1)';
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
    toast.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg><span>${escapeHtml(message)}</span>`;
  } else if (type === 'error') {
    toast.style.background = '#991b1b';
    toast.style.color = '#ffffff';
    toast.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><span>${escapeHtml(message)}</span>`;
  } else {
    toast.style.background = '#0f172a';
    toast.style.color = '#ffffff';
    toast.innerHTML = `<span>${escapeHtml(message)}</span>`;
  }

  container.appendChild(toast);
  setTimeout(() => {
    toast.style.transform = 'translateY(0)';
    toast.style.opacity = '1';
  }, 10);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(12px)';
    setTimeout(() => toast.remove(), 300);
  }, 3500);
}

function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

// Switch between Table and Grid View
function switchView(mode) {
  currentViewMode = mode;
  localStorage.setItem('cc_portfolio_view', mode);

  const tableView = document.getElementById('portfolioTableView');
  const gridView = document.getElementById('portfolioGridView');
  const btnTable = document.getElementById('btnViewTable');
  const btnGrid = document.getElementById('btnViewGrid');

  if (mode === 'grid') {
    tableView.style.display = 'none';
    gridView.style.display = 'block';

    btnGrid.classList.add('active');
    btnTable.classList.remove('active');
  } else {
    gridView.style.display = 'none';
    tableView.style.display = 'block';

    btnTable.classList.add('active');
    btnGrid.classList.remove('active');
  }
}

// Category filter tabs
function filterByCategory(slug, btn) {
  document.querySelectorAll('.pf-category-strip .pf-cat-tab').forEach(t => t.classList.remove('active'));
  if (btn) btn.classList.add('active');

  const catSelect = document.getElementById('portfolioCategorySelect');
  if (catSelect) {
    catSelect.value = slug;
  }
  applyFilters();
}

// KPI Quick Filter triggers
function quickFilterStatus(status) {
  const statusSelect = document.getElementById('portfolioStatusSelect');
  if (statusSelect) {
    statusSelect.value = status;
    applyFilters();
  }
}

function quickFilterFeatured(featured) {
  const featSelect = document.getElementById('portfolioFeaturedSelect');
  if (featSelect) {
    featSelect.value = featured;
    applyFilters();
  }
}

// Debounced search keyup
let searchDebounceTimer = null;
function handleSearchKeyUp(event) {
  toggleClearSearchBtn();
  if (event.key === 'Enter') {
    applyFilters();
    return;
  }
  clearTimeout(searchDebounceTimer);
  searchDebounceTimer = setTimeout(() => {
    applyFilters();
  }, 200);
}

function toggleClearSearchBtn() {
  const input = document.getElementById('portfolioSearchInput');
  const clearBtn = document.getElementById('pfSearchClearBtn');
  if (input && clearBtn) {
    clearBtn.style.display = input.value.trim() ? 'block' : 'none';
  }
}

function clearSearch() {
  const input = document.getElementById('portfolioSearchInput');
  if (input) {
    input.value = '';
    toggleClearSearchBtn();
    applyFilters();
    input.focus();
  }
}

function resetAllFilters() {
  const searchInput = document.getElementById('portfolioSearchInput');
  const catSelect = document.getElementById('portfolioCategorySelect');
  const statusSelect = document.getElementById('portfolioStatusSelect');
  const featSelect = document.getElementById('portfolioFeaturedSelect');

  if (searchInput) searchInput.value = '';
  if (catSelect) catSelect.value = 'all';
  if (statusSelect) statusSelect.value = 'all';
  if (featSelect) featSelect.value = 'all';

  document.querySelectorAll('.pf-category-strip .pf-cat-tab').forEach((t, idx) => {
    t.classList.toggle('active', idx === 0);
  });

  toggleClearSearchBtn();
  applyFilters();
}

// Filter records client-side for instant 60fps UI responsiveness
function applyFilters() {
  const search = (document.getElementById('portfolioSearchInput')?.value || '').toLowerCase().trim();
  const category = (document.getElementById('portfolioCategorySelect')?.value || 'all').toLowerCase();
  const status = (document.getElementById('portfolioStatusSelect')?.value || 'all').toLowerCase();
  const featured = (document.getElementById('portfolioFeaturedSelect')?.value || 'all').toLowerCase();

  const isFiltered = search !== '' || category !== 'all' || status !== 'all' || featured !== 'all';
  const resetBtn = document.getElementById('resetFiltersBtn');
  if (resetBtn) {
    resetBtn.style.display = isFiltered ? 'inline-block' : 'none';
  }

  const rows = document.querySelectorAll('.portfolio-data-row');
  const cards = document.querySelectorAll('.portfolio-card-item');

  let visibleCount = 0;

  function matches(el) {
    const title = el.getAttribute('data-title') || '';
    const client = el.getAttribute('data-client') || '';
    const sector = el.getAttribute('data-sector') || '';
    const cat = (el.getAttribute('data-category') || '').toLowerCase();
    const st = (el.getAttribute('data-status') || '').toLowerCase();
    const feat = (el.getAttribute('data-featured') || '').toLowerCase();

    // Search query match
    if (search && !title.includes(search) && !client.includes(search) && !sector.includes(search)) {
      return false;
    }
    // Category match
    if (category !== 'all' && cat !== category) {
      return false;
    }
    // Status match
    if (status !== 'all' && st !== status) {
      return false;
    }
    // Featured match
    if (featured !== 'all' && feat !== featured) {
      return false;
    }
    return true;
  }

  rows.forEach(r => {
    if (matches(r)) {
      r.style.display = '';
      visibleCount++;
    } else {
      r.style.display = 'none';
    }
  });

  cards.forEach(c => {
    if (matches(c)) {
      c.style.display = 'flex';
    } else {
      c.style.display = 'none';
    }
  });

  const countBadge = document.getElementById('renderedCount');
  if (countBadge) {
    countBadge.textContent = visibleCount;
  }
}

// Auto-generate URL slug from Title
function handleTitleInput(val) {
  if (!autoSlugEnabled) return;
  const slugInput = document.getElementById('csFieldSlug');
  if (slugInput) {
    slugInput.value = val
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '');
  }
}

function toggleAutoSlug(checked) {
  autoSlugEnabled = checked;
  if (checked) {
    const title = document.getElementById('csFieldTitle')?.value || '';
    handleTitleInput(title);
  }
}

// Append Tech Tag to input
function appendTechTag(tag) {
  const input = document.getElementById('csFieldTechStack');
  if (!input) return;
  const current = input.value.trim();
  const tags = current ? current.split(',').map(t => t.trim()) : [];
  if (!tags.includes(tag)) {
    tags.push(tag);
    input.value = tags.join(', ');
  }
}

// Thumbnail Live Preview
function updateImagePreview(url) {
  const img = document.getElementById('csImagePreview');
  if (img) {
    img.src = url || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop';
  }
}

function setImagePreset(url) {
  const input = document.getElementById('csFieldImage');
  if (input) {
    input.value = url;
    updateImagePreview(url);
  }
}

// ============================================================================
// DYNAMIC KEY METRICS BUILDER (IN CREATE / EDIT MODAL)
// ============================================================================
function addMetricRow(val = '', lbl = '') {
  const container = document.getElementById('metricsBuilderContainer');
  if (!container) return;

  const rows = container.querySelectorAll('.metric-builder-row');
  if (rows.length >= 4) {
    showToast('Maximum 4 highlighted metrics allowed.', 'error');
    return;
  }

  const row = document.createElement('div');
  row.className = 'metric-builder-row';
  row.style.display = 'grid';
  row.style.gridTemplateColumns = '140px 1fr 34px';
  row.style.gap = '8px';
  row.style.alignItems = 'center';

  row.innerHTML = `
    <input type="text" name="metric_val[]" class="crm-form-input" placeholder="e.g. +310% / 12ms" value="${escapeHtml(val)}" style="font-weight: 700;" />
    <input type="text" name="metric_lbl[]" class="crm-form-input" placeholder="e.g. ARR Growth / Latency Drop" value="${escapeHtml(lbl)}" />
    <button type="button" onclick="this.closest('.metric-builder-row').remove()" style="width: 32px; height: 32px; border-radius: 6px; background: rgba(220, 38, 38, 0.08); color: #dc2626; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(220, 38, 38, 0.2); cursor: pointer;" title="Remove Metric">
      ✕
    </button>
  `;

  container.appendChild(row);
}

function setMetricRows(metrics = []) {
  const container = document.getElementById('metricsBuilderContainer');
  if (!container) return;
  container.innerHTML = '';

  if (Array.isArray(metrics) && metrics.length > 0) {
    metrics.forEach(m => addMetricRow(m.val || '', m.lbl || ''));
  } else {
    // Default starter pair
    addMetricRow('+100%', 'Engineering Efficiency');
  }
}

// ============================================================================
// MODAL CONTROLS: VIEW DOSSIER
// ============================================================================
async function viewPortfolioDossier(id) {
  try {
    const res = await fetch(`${BASE_URL}/admin/portfolio/detail?id=${id}`);
    const data = await res.json();

    if (!data.success || !data.case_study) {
      showToast(data.error || 'Failed to load case study.', 'error');
      return;
    }

    const cs = data.case_study;

    document.getElementById('viewDossierCategory').textContent = cs.category_name || 'ENGINEERING';
    document.getElementById('viewDossierResultBadge').textContent = cs.result_badge || 'TRANSFORMATION SUCCESS';
    document.getElementById('viewDossierTitle').textContent = cs.title;
    document.getElementById('viewDossierClient').textContent = cs.client_name;
    document.getElementById('viewDossierLocation').textContent = cs.client_location || 'Global';
    document.getElementById('viewDossierSector').textContent = cs.sector_industry || 'Enterprise';
    document.getElementById('viewDossierTimeline').textContent = cs.timeline_duration || 'Standard Sprint';
    document.getElementById('viewDossierId').textContent = cs.id;

    // Featured badge
    const featBadge = document.getElementById('viewDossierFeaturedBadge');
    if (featBadge) {
      featBadge.style.display = (parseInt(cs.is_featured, 10) === 1) ? 'inline-block' : 'none';
    }

    // Featured Image & links
    const imgEl = document.getElementById('viewDossierImage');
    imgEl.src = cs.featured_image || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop';

    const liveBtn = document.getElementById('viewDossierLiveBtn');
    if (cs.live_project_url) {
      liveBtn.href = cs.live_project_url;
      liveBtn.style.display = 'inline-flex';
    } else {
      liveBtn.style.display = 'none';
    }

    const gitBtn = document.getElementById('viewDossierGithubBtn');
    if (cs.github_url) {
      gitBtn.href = cs.github_url;
      gitBtn.style.display = 'inline-flex';
    } else {
      gitBtn.style.display = 'none';
    }

    // Parse metrics robustly
    let metrics = [];
    if (Array.isArray(cs.key_metrics)) {
      metrics = cs.key_metrics;
    } else if (typeof cs.key_metrics === 'string') {
      try { metrics = JSON.parse(cs.key_metrics) || []; } catch(e) {}
    } else if (Array.isArray(cs.key_metrics_arr)) {
      metrics = cs.key_metrics_arr;
    }

    // Metrics grid
    const metricsGrid = document.getElementById('viewDossierMetricsGrid');
    metricsGrid.innerHTML = '';
    if (metrics.length > 0) {
      metrics.forEach(m => {
        const item = document.createElement('div');
        item.style.background = '#f8fafc';
        item.style.border = '1px solid #e2e8f0';
        item.style.borderRadius = '10px';
        item.style.padding = '14px 16px';
        item.style.textAlign = 'center';
        item.innerHTML = `
          <div style="font-size: 1.35rem; font-weight: 800; color: #0056d6; font-family: var(--font-display, sans-serif);">${escapeHtml(m.val || '')}</div>
          <div style="font-size: 0.74rem; color: #64748b; font-weight: 700; margin-top: 3px;">${escapeHtml(m.lbl || '')}</div>
        `;
        metricsGrid.appendChild(item);
      });
    } else {
      metricsGrid.innerHTML = `<span style="color: #94a3b8; font-size: 0.82rem;">No numerical transformation benchmarks logged.</span>`;
    }

    // Narratives
    document.getElementById('viewDossierExcerpt').textContent = cs.excerpt || 'No synopsis provided.';
    document.getElementById('viewDossierChallenge').textContent = cs.challenge_overview || 'No challenge context documented.';
    document.getElementById('viewDossierSolution').textContent = cs.architecture_solution || 'No architecture solution documented.';

    // Parse tech stack robustly
    let techs = [];
    if (Array.isArray(cs.technologies)) {
      techs = cs.technologies;
    } else if (typeof cs.technologies === 'string') {
      try {
        const parsed = JSON.parse(cs.technologies);
        techs = Array.isArray(parsed) ? parsed : cs.technologies.split(',').map(t => t.trim());
      } catch(e) {
        techs = cs.technologies.split(',').map(t => t.trim()).filter(Boolean);
      }
    } else if (Array.isArray(cs.technologies_arr)) {
      techs = cs.technologies_arr;
    }

    // Tech Stack
    const techGrid = document.getElementById('viewDossierTechStack');
    techGrid.innerHTML = '';
    if (techs.length > 0) {
      techs.forEach(t => {
        const pill = document.createElement('span');
        pill.style.fontSize = '0.74rem';
        pill.style.fontFamily = 'var(--font-mono, monospace)';
        pill.style.background = '#eff6ff';
        pill.style.color = '#0056d6';
        pill.style.padding = '4px 10px';
        pill.style.borderRadius = '6px';
        pill.style.border = '1px solid #dbeafe';
        pill.style.fontWeight = '600';
        pill.textContent = t;
        techGrid.appendChild(pill);
      });
    } else {
      techGrid.innerHTML = `<span style="color: #94a3b8; font-size: 0.82rem;">Tech stack not populated.</span>`;
    }

    // Edit button in dossier footer
    const editBtn = document.getElementById('viewDossierEditBtn');
    editBtn.onclick = () => {
      closeViewPortfolioModal();
      editPortfolio(cs.id);
    };

    const backdrop = document.getElementById('viewPortfolioModalBackdrop');
    backdrop.style.display = 'flex';
    backdrop.classList.add('show');
    document.body.style.overflow = 'hidden';
  } catch (err) {
    showToast('Failed to load case study dossier.', 'error');
  }
}

function closeViewPortfolioModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close') && !e.target.classList.contains('crm-modal-close')) return;
  const backdrop = document.getElementById('viewPortfolioModalBackdrop');
  backdrop.style.display = 'none';
  backdrop.classList.remove('show');
  document.body.style.overflow = '';
}

// ============================================================================
// MODAL CONTROLS: CREATE & EDIT
// ============================================================================
function openCreatePortfolioModal() {
  document.getElementById('portfolioForm').reset();
  document.getElementById('csFieldId').value = '0';
  document.getElementById('editPortfolioModalTitle').textContent = 'Create Flagship Case Study';
  document.getElementById('btnSubmitPortfolioText').textContent = 'Save Case Study';
  
  autoSlugEnabled = true;
  document.getElementById('csAutoSlugCheck').checked = true;

  updateImagePreview('https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop');
  setMetricRows([
    { val: '+310%', lbl: 'ARR Growth' },
    { val: '12ms', lbl: 'Real-time Latency' }
  ]);

  const backdrop = document.getElementById('editPortfolioModalBackdrop');
  backdrop.style.display = 'flex';
  backdrop.classList.add('show');
  document.body.style.overflow = 'hidden';
}

async function editPortfolio(id) {
  try {
    const res = await fetch(`${BASE_URL}/admin/portfolio/detail?id=${id}`);
    const data = await res.json();

    if (!data.success || !data.case_study) {
      showToast(data.error || 'Failed to load case study.', 'error');
      return;
    }

    const cs = data.case_study;

    document.getElementById('csFieldId').value = cs.id;
    document.getElementById('csFieldTitle').value = cs.title || '';
    document.getElementById('csFieldSlug').value = cs.slug || '';
    document.getElementById('csFieldCategory').value = cs.category_id || '';
    document.getElementById('csFieldClient').value = cs.client_name || '';
    document.getElementById('csFieldLocation').value = cs.client_location || '';
    document.getElementById('csFieldSector').value = cs.sector_industry || '';
    document.getElementById('csFieldResultBadge').value = cs.result_badge || '';
    document.getElementById('csFieldTimeline').value = cs.timeline_duration || '';
    document.getElementById('csFieldExcerpt').value = cs.excerpt || '';
    document.getElementById('csFieldChallenge').value = cs.challenge_overview || '';
    document.getElementById('csFieldSolution').value = cs.architecture_solution || '';

    // Technologies
    let techs = cs.technologies;
    if (typeof techs === 'string') {
      try {
        const parsed = JSON.parse(techs);
        if (Array.isArray(parsed)) techs = parsed.join(', ');
      } catch(e) {}
    } else if (Array.isArray(techs)) {
      techs = techs.join(', ');
    }
    document.getElementById('csFieldTechStack').value = techs || '';

    // Image
    const imgUrl = cs.featured_image || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop';
    document.getElementById('csFieldImage').value = imgUrl;
    updateImagePreview(imgUrl);

    // Links
    document.getElementById('csFieldLiveUrl').value = cs.live_project_url || '';
    document.getElementById('csFieldGithubUrl').value = cs.github_url || '';

    // Order & Flags
    document.getElementById('csFieldOrder').value = cs.order_num || 1;
    document.getElementById('csFieldFeatured').checked = (parseInt(cs.is_featured, 10) === 1);
    document.getElementById('csFieldActive').checked = (parseInt(cs.is_active, 10) === 1);

    // Disable auto-slug on edit so user's custom slug is preserved
    autoSlugEnabled = false;
    document.getElementById('csAutoSlugCheck').checked = false;

    // Metrics rows
    let metrics = cs.key_metrics;
    if (typeof metrics === 'string') {
      try { metrics = JSON.parse(metrics) || []; } catch(e) { metrics = []; }
    }
    setMetricRows(Array.isArray(metrics) ? metrics : (cs.key_metrics_arr || []));

    document.getElementById('editPortfolioModalTitle').textContent = `Edit Case Study #${cs.id}`;
    document.getElementById('btnSubmitPortfolioText').textContent = 'Update Case Study';

    const backdrop = document.getElementById('editPortfolioModalBackdrop');
    backdrop.style.display = 'flex';
    backdrop.classList.add('show');
    document.body.style.overflow = 'hidden';
  } catch (err) {
    showToast('Failed to load case study data for editing.', 'error');
  }
}

function closeEditPortfolioModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close') && !e.target.classList.contains('crm-modal-close')) return;
  const backdrop = document.getElementById('editPortfolioModalBackdrop');
  backdrop.style.display = 'none';
  backdrop.classList.remove('show');
  document.body.style.overflow = '';
}

// Form Submit Handler via AJAX
async function submitPortfolioForm(e) {
  e.preventDefault();

  const form = document.getElementById('portfolioForm');
  const btn = document.getElementById('btnSubmitPortfolio');
  const btnText = document.getElementById('btnSubmitPortfolioText');
  const origText = btnText.textContent;

  btn.disabled = true;
  btnText.textContent = 'Saving...';

  const formData = new FormData(form);

  try {
    const res = await fetch(`${BASE_URL}/admin/portfolio/save`, {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Case study saved successfully!', 'success');
      closeEditPortfolioModal();
      // Reload page to refresh master tables and metrics
      setTimeout(() => window.location.reload(), 500);
    } else {
      showToast(data.error || 'Failed to save case study.', 'error');
    }
  } catch (err) {
    showToast('Network error while saving case study.', 'error');
  } finally {
    btn.disabled = false;
    btnText.textContent = origText;
  }
}

// ============================================================================
// AJAX TOGGLES: STATUS (LIVE / DRAFT) & FEATURED (STAR)
// ============================================================================
async function togglePortfolioStatus(id) {
  const btn = document.getElementById(`btnStatus-${id}`);
  const btnText = document.getElementById(`btnStatusText-${id}`);
  const cardBtn = document.getElementById(`cardStatus-${id}`);
  const row = document.getElementById(`csRow-${id}`);
  const card = document.getElementById(`csCard-${id}`);

  try {
    const formData = new FormData();
    formData.append('id', id);

    const res = await fetch(`${BASE_URL}/admin/portfolio/toggle-status`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      const isActive = data.is_active === 1;
      showToast(data.message, 'success');

      // Update Table button
      if (btn && btnText) {
        btnText.textContent = isActive ? 'Live' : 'Draft';
        btn.className = `pf-status-btn ${isActive ? 'active' : 'inactive'}`;
      }

      // Update Card button
      if (cardBtn) {
        cardBtn.textContent = isActive ? 'Live' : 'Draft';
        cardBtn.className = `pf-card-floating-btn status ${isActive ? 'live' : ''}`;
      }

      // Update data-status attributes for instant filtering
      if (row) row.setAttribute('data-status', isActive ? 'active' : 'inactive');
      if (card) card.setAttribute('data-status', isActive ? 'active' : 'inactive');

      // Update Active KPI count
      const activeKpi = document.getElementById('metricActiveCount');
      if (activeKpi) {
        let cur = parseInt(activeKpi.textContent, 10) || 0;
        activeKpi.textContent = isActive ? cur + 1 : Math.max(0, cur - 1);
      }
    } else {
      showToast(data.error || 'Failed to toggle status.', 'error');
    }
  } catch (err) {
    showToast('Network error toggling status.', 'error');
  }
}

async function togglePortfolioFeatured(id) {
  const btn = document.getElementById(`btnFeatured-${id}`);
  const cardBtn = document.getElementById(`cardFeatured-${id}`);
  const row = document.getElementById(`csRow-${id}`);
  const card = document.getElementById(`csCard-${id}`);

  try {
    const formData = new FormData();
    formData.append('id', id);

    const res = await fetch(`${BASE_URL}/admin/portfolio/toggle-featured`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      const isFeatured = data.is_featured === 1;
      showToast(data.message, 'success');

      // Update Table button
      if (btn) {
        btn.className = `pf-star-toggle ${isFeatured ? 'featured' : ''}`;
        const svg = btn.querySelector('svg');
        if (svg) svg.setAttribute('fill', isFeatured ? 'currentColor' : 'none');
        const span = btn.querySelector('span');
        if (span) span.textContent = isFeatured ? 'Hero Star' : 'Regular';
      }

      // Update Card button
      if (cardBtn) {
        cardBtn.className = `pf-card-floating-btn star ${isFeatured ? 'featured' : ''}`;
        const cardSvg = cardBtn.querySelector('svg');
        if (cardSvg) cardSvg.setAttribute('fill', isFeatured ? 'currentColor' : 'none');
      }

      // Update attributes
      if (row) row.setAttribute('data-featured', isFeatured ? 'featured' : 'standard');
      if (card) card.setAttribute('data-featured', isFeatured ? 'featured' : 'standard');

      // Update Featured KPI count
      const featKpi = document.getElementById('metricFeaturedCount');
      if (featKpi) {
        let cur = parseInt(featKpi.textContent, 10) || 0;
        featKpi.textContent = isFeatured ? cur + 1 : Math.max(0, cur - 1);
      }
    } else {
      showToast(data.error || 'Failed to toggle featured status.', 'error');
    }
  } catch (err) {
    showToast('Network error toggling featured status.', 'error');
  }
}

// ============================================================================
// AJAX DUPLICATE / CLONE CASE STUDY
// ============================================================================
async function duplicatePortfolio(id) {
  if (!confirm('Duplicate this case study as a new draft?')) return;

  try {
    const formData = new FormData();
    formData.append('id', id);

    const res = await fetch(`${BASE_URL}/admin/portfolio/duplicate`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Case study cloned successfully!', 'success');
      setTimeout(() => window.location.reload(), 600);
    } else {
      showToast(data.error || 'Failed to clone case study.', 'error');
    }
  } catch (err) {
    showToast('Network error while duplicating case study.', 'error');
  }
}

// ============================================================================
// DELETE CONFIRMATION & EXECUTION
// ============================================================================
function confirmDeletePortfolio(id, title) {
  deleteTargetId = id;
  document.getElementById('deleteTargetTitle').textContent = `"${title}"`;
  const backdrop = document.getElementById('deletePortfolioModalBackdrop');
  backdrop.style.display = 'flex';
  backdrop.classList.add('show');
  document.body.style.overflow = 'hidden';

  document.getElementById('btnConfirmDeleteAction').onclick = executeDeletePortfolio;
}

function closeDeletePortfolioModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close') && !e.target.classList.contains('crm-modal-close')) return;
  const backdrop = document.getElementById('deletePortfolioModalBackdrop');
  backdrop.style.display = 'none';
  backdrop.classList.remove('show');
  document.body.style.overflow = '';
  deleteTargetId = 0;
}

async function executeDeletePortfolio() {
  if (!deleteTargetId) return;

  const btn = document.getElementById('btnConfirmDeleteAction');
  btn.disabled = true;
  btn.textContent = 'Deleting...';

  try {
    const formData = new FormData();
    formData.append('id', deleteTargetId);

    const res = await fetch(`${BASE_URL}/admin/portfolio/delete`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Case study removed.', 'success');
      closeDeletePortfolioModal();

      // Remove row and card from DOM
      const row = document.getElementById(`csRow-${deleteTargetId}`);
      if (row) row.remove();
      const card = document.getElementById(`csCard-${deleteTargetId}`);
      if (card) card.remove();

      applyFilters();
    } else {
      showToast(data.error || 'Failed to delete case study.', 'error');
    }
  } catch (err) {
    showToast('Network error deleting case study.', 'error');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Yes, Delete Record';
  }
}
</script>

<?php
include __DIR__ . '/layout/footer.php';
?>
