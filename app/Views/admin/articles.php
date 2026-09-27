<?php
/**
 * ClickCodex Technologies - Admin Articles & Technical Dispatch Editorial Console
 * Executive enterprise management for technical whitepapers, architecture teardowns, research posts, and live blog dispatches.
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

$pageTitle = $pageTitle ?? 'Technical Articles & Editorial Dispatch | ClickCodex Studio Console';
$topbarTitle = 'Technical Articles & Editorial Dispatch';
$activeNav = 'articles';

include __DIR__ . '/layout/header.php';
?>

<!-- ========================================================================
     ARTICLES & EDITORIAL DISPATCH STYLES (OPEN SANS UNIFIED)
     ======================================================================== -->
<style>
:root {
  --art-primary: #0056d6;
  --art-primary-glow: rgba(0, 86, 214, 0.25);
  --art-cyan: #00a2ff;
  --art-emerald: #10b981;
  --art-emerald-glow: rgba(16, 185, 129, 0.25);
  --art-amber: #f59e0b;
  --art-amber-glow: rgba(245, 158, 11, 0.25);
  --art-purple: #8b5cf6;
  --art-red: #ef4444;
  --art-dark-surface: #0a0f1d;
  --art-card-border: #e2e8f0;
}

/* Base Font & Container Standard */
.admin-content, .art-admin-content, .art-hero-banner, .crm-modal-card {
  font-family: 'Open Sans', var(--font-body), sans-serif;
}

.art-admin-content {
  max-width: 1440px;
  margin: 0 auto;
  padding: 32px;
  width: 100%;
  box-sizing: border-box;
}

/* 1. Header Command Banner */
.art-hero-banner {
  background: linear-gradient(135deg, #090d16 0%, #111a2e 50%, #0f172a 100%);
  border-radius: 18px;
  padding: 26px 30px;
  margin-bottom: 24px;
  color: #ffffff;
  position: relative;
  overflow: hidden;
  box-shadow: 0 10px 30px -5px rgba(9, 13, 22, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.08);
}
.art-hero-banner::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 380px;
  height: 380px;
  background: radial-gradient(circle, rgba(0, 162, 255, 0.16) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.art-hero-banner::after {
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
.art-badge-pill {
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
.art-pulse-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #10b981;
  box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
  animation: artPulse 2s infinite;
}
@keyframes artPulse {
  0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
  70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
  100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}
.art-title-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
  position: relative;
  z-index: 2;
}
.art-hero-title {
  font-family: var(--font-display, 'Open Sans', sans-serif);
  font-size: clamp(1.3rem, 2.5vw, 1.65rem);
  font-weight: 800;
  color: #ffffff;
  letter-spacing: -0.5px;
  margin: 0;
  line-height: 1.25;
}
.art-hero-title span {
  background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.art-hero-desc {
  color: #cbd5e1;
  font-size: clamp(0.82rem, 1.2vw, 0.88rem);
  line-height: 1.55;
  margin: 6px 0 0;
  max-width: 720px;
}
.art-actions-wrap {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}
.art-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 9px 18px;
  border-radius: 10px;
  font-size: 0.84rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  text-decoration: none;
  white-space: nowrap;
  box-sizing: border-box;
}
.art-btn-primary {
  background: linear-gradient(135deg, #0056d6 0%, #00a2ff 100%);
  color: #ffffff;
  border: none;
  box-shadow: 0 4px 15px -2px rgba(0, 86, 214, 0.4);
}
.art-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px -4px rgba(0, 86, 214, 0.6);
  color: #ffffff;
}
.art-btn-glass {
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: #ffffff;
  backdrop-filter: blur(8px);
}
.art-btn-glass:hover {
  background: rgba(255, 255, 255, 0.16);
  transform: translateY(-2px);
  color: #ffffff;
}

/* 2. Executive KPI Summary Cards */
.art-kpi-row {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}
.art-kpi-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 16px 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
  overflow: hidden;
  cursor: pointer;
  min-width: 0;
}
.art-kpi-card::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 4px;
  height: 100%;
  background: transparent;
  transition: background 0.25s ease;
}
.art-kpi-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
  border-color: #cbd5e1;
}
.art-kpi-card.blue:hover::after { background: var(--art-primary); }
.art-kpi-card.green:hover::after { background: var(--art-emerald); }
.art-kpi-card.amber:hover::after { background: var(--art-amber); }
.art-kpi-card.purple:hover::after { background: var(--art-purple); }
.art-kpi-card.cyan:hover::after { background: var(--art-cyan); }

.art-kpi-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
}
.art-kpi-label {
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #64748b;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.art-kpi-icon {
  width: 28px;
  height: 28px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.85rem;
  flex-shrink: 0;
}
.art-kpi-val {
  font-family: var(--font-display, 'Open Sans', sans-serif);
  font-size: clamp(1.4rem, 2.2vw, 1.85rem);
  font-weight: 800;
  color: #0f172a;
  line-height: 1.1;
  margin-bottom: 6px;
}
.art-kpi-sub {
  font-size: 0.72rem;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 5px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.art-kpi-sub strong {
  font-weight: 700;
}

/* 3. Category Filter Strip */
.art-filter-bar {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 8px 12px;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 8px;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: thin;
  box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
}
.art-filter-bar::-webkit-scrollbar {
  height: 4px;
}
.art-filter-bar::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}
.art-filter-pill {
  padding: 6px 14px;
  border-radius: 9999px;
  font-size: 0.8rem;
  font-weight: 600;
  color: #475569;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  cursor: pointer;
  white-space: nowrap;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  flex-shrink: 0;
}
.art-filter-pill:hover {
  background: #f1f5f9;
  color: #0f172a;
  border-color: #cbd5e1;
}
.art-filter-pill.active {
  background: #0056d6;
  color: #ffffff;
  border-color: #0056d6;
  box-shadow: 0 4px 12px -2px rgba(0, 86, 214, 0.35);
}
.art-filter-pill .pill-cnt {
  font-family: var(--font-mono, monospace);
  font-size: 0.7rem;
  padding: 1px 6px;
  border-radius: 10px;
  background: rgba(0, 0, 0, 0.06);
}
.art-filter-pill.active .pill-cnt {
  background: rgba(255, 255, 255, 0.25);
  color: #ffffff;
}

/* 4. Toolbar: Search, Selectors, View Toggles */
.art-toolbar {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 14px 18px;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
  box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
}
.art-search-wrap {
  position: relative;
  flex: 1;
  min-width: 260px;
  max-width: 440px;
}
.art-search-icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  pointer-events: none;
}
.art-search-input {
  width: 100%;
  padding: 9px 36px 9px 36px;
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  font-size: 0.85rem;
  font-family: inherit;
  color: #0f172a;
  background: #f8fafc;
  transition: all 0.2s ease;
  box-sizing: border-box;
}
.art-search-input:focus {
  outline: none;
  background: #ffffff;
  border-color: #0056d6;
  box-shadow: 0 0 0 3px rgba(0, 86, 214, 0.12);
}
.art-search-kbd {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  font-family: var(--font-mono, monospace);
  font-size: 0.7rem;
  padding: 2px 6px;
  background: #e2e8f0;
  color: #64748b;
  border-radius: 4px;
  pointer-events: none;
}
.art-toolbar-controls {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}
.art-select {
  padding: 8px 14px;
  border: 1px solid #cbd5e1;
  border-radius: 9px;
  font-size: 0.82rem;
  font-family: inherit;
  color: #334155;
  background: #ffffff;
  cursor: pointer;
  transition: all 0.2s ease;
  box-sizing: border-box;
}
.art-select:focus {
  outline: none;
  border-color: #0056d6;
  box-shadow: 0 0 0 3px rgba(0, 86, 214, 0.12);
}
.art-view-switch {
  display: flex;
  background: #f1f5f9;
  border: 1px solid #cbd5e1;
  border-radius: 9px;
  padding: 3px;
  gap: 3px;
  flex-shrink: 0;
}
.art-view-btn {
  padding: 6px 12px;
  border-radius: 7px;
  border: none;
  background: transparent;
  color: #64748b;
  font-size: 0.78rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  gap: 5px;
}
.art-view-btn.active {
  background: #ffffff;
  color: #0056d6;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

/* 5. Enterprise Table View */
.art-scroll-indicator {
  display: none;
  font-size: 0.72rem;
  font-family: var(--font-mono, monospace);
  color: #64748b;
  text-align: center;
  padding: 8px 12px;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
}
.art-table-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
}
.art-table-wrap {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: thin;
}
.art-table-wrap::-webkit-scrollbar {
  height: 6px;
}
.art-table-wrap::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}
.art-table {
  width: 100%;
  min-width: 840px;
  border-collapse: collapse;
  text-align: left;
  font-size: 0.85rem;
}
.art-table th {
  background: #f8fafc;
  color: #475569;
  font-size: 0.74rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  padding: 14px 18px;
  border-bottom: 1px solid #e2e8f0;
  white-space: nowrap;
}
.art-table td {
  padding: 14px 18px;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
  color: #334155;
}
.art-table tr:last-child td {
  border-bottom: none;
}
.art-table tr:hover td {
  background: #fbfcfe;
}
.art-thumb-cell {
  width: 58px;
  height: 42px;
  border-radius: 8px;
  object-fit: cover;
  border: 1px solid #e2e8f0;
  background: #f1f5f9;
  flex-shrink: 0;
}
.art-title-cell {
  font-weight: 700;
  color: #0f172a;
  text-decoration: none;
  display: block;
  line-height: 1.35;
  transition: color 0.15s ease;
}
.art-title-cell:hover {
  color: #0056d6;
}
.art-slug-text {
  font-family: var(--font-mono, monospace);
  font-size: 0.72rem;
  color: #94a3b8;
  margin-top: 2px;
  display: block;
  word-break: break-all;
}
.art-cat-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 3px 9px;
  border-radius: 6px;
  font-size: 0.72rem;
  font-weight: 700;
  letter-spacing: 0.4px;
  white-space: nowrap;
}
.art-author-pill {
  display: inline-flex;
  align-items: center;
  gap: 8px;
}
.art-author-avatar {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: #0056d6;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.7rem;
  font-weight: 700;
  flex-shrink: 0;
}
.art-read-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 0.74rem;
  color: #64748b;
  font-weight: 600;
  white-space: nowrap;
}
.art-star-btn {
  background: transparent;
  border: none;
  font-size: 1.25rem;
  cursor: pointer;
  transition: transform 0.2s ease;
  padding: 4px;
  border-radius: 6px;
  color: #cbd5e1;
}
.art-star-btn.active {
  color: #f59e0b;
}
.art-star-btn:hover {
  transform: scale(1.2);
}
.art-toggle-switch {
  position: relative;
  display: inline-block;
  width: 38px;
  height: 22px;
}
.art-toggle-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.art-toggle-slider {
  position: absolute;
  cursor: pointer;
  inset: 0;
  background-color: #cbd5e1;
  transition: 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  border-radius: 34px;
}
.art-toggle-slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  border-radius: 50%;
}
.art-toggle-switch input:checked + .art-toggle-slider {
  background-color: #10b981;
}
.art-toggle-switch input:checked + .art-toggle-slider:before {
  transform: translateX(16px);
}
.art-actions-cell {
  display: flex;
  align-items: center;
  gap: 6px;
}
.art-action-btn {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: #475569;
  cursor: pointer;
  transition: all 0.15s ease;
  text-decoration: none;
}
.art-action-btn:hover {
  background: #0056d6;
  border-color: #0056d6;
  color: #ffffff;
  transform: translateY(-1px);
}
.art-action-btn.delete:hover {
  background: #dc2626;
  border-color: #dc2626;
  color: #ffffff;
}

/* 6. Editorial Cards View */
.art-cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(min(100%, 310px), 1fr));
  gap: 20px;
}
.art-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
  display: flex;
  flex-direction: column;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
}
.art-card:hover {
  transform: translateY(-4px);
  border-color: #cbd5e1;
  box-shadow: 0 12px 28px -5px rgba(15, 23, 42, 0.08);
}
.art-card-img-wrap {
  position: relative;
  height: clamp(160px, 22vw, 190px);
  background: #0f172a;
  overflow: hidden;
}
.art-card-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
}
.art-card:hover .art-card-img {
  transform: scale(1.04);
}
.art-card-badge-top {
  position: absolute;
  top: 12px;
  left: 12px;
  display: flex;
  gap: 6px;
  z-index: 2;
  flex-wrap: wrap;
}
.art-card-actions-top {
  position: absolute;
  top: 12px;
  right: 12px;
  display: flex;
  gap: 6px;
  z-index: 2;
}
.art-card-body {
  padding: 18px 20px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.art-card-title {
  font-family: var(--font-display, 'Open Sans', sans-serif);
  font-size: 1.05rem;
  font-weight: 700;
  color: #0f172a;
  line-height: 1.4;
  margin: 0 0 8px;
  cursor: pointer;
  transition: color 0.15s ease;
}
.art-card-title:hover {
  color: #0056d6;
}
.art-card-excerpt {
  font-size: 0.83rem;
  color: #64748b;
  line-height: 1.55;
  margin-bottom: 14px;
  flex: 1;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.art-card-foot {
  padding: 12px 20px;
  background: #f8fafc;
  border-top: 1px solid #f1f5f9;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 8px;
}

/* ========================================================================
   MODAL OVERLAY SYSTEM (FIXED RESPONSIVE DIALOG POPUPS)
   ======================================================================== */
.crm-modal-backdrop {
  position: fixed !important;
  inset: 0 !important;
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
  max-width: 880px !important;
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
.crm-modal-body::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
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

/* Modal Form Controls */
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
.crm-form-input {
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
.crm-form-input:focus {
  outline: none;
  background: #ffffff;
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
.crm-form-select {
  width: 100%;
  height: 42px;
  padding: 8px 14px;
  border: 1px solid #cbd5e1;
  border-radius: 9px;
  font-size: 0.86rem;
  color: #0f172a;
  background: #ffffff;
  cursor: pointer;
  transition: all 0.2s ease;
  box-sizing: border-box;
  font-family: inherit;
}
.crm-form-select:focus {
  outline: none;
  border-color: #0056d6;
  box-shadow: 0 0 0 3px rgba(0, 86, 214, 0.12);
}

/* 7. Pitch-Deck Dossier Modal Header */
.art-modal-header-hero {
  background: linear-gradient(135deg, #090d16 0%, #1e293b 100%);
  color: #ffffff;
  padding: clamp(18px, 3vw, 24px) clamp(18px, 3vw, 28px);
  border-radius: 20px 20px 0 0;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
}
.art-modal-hero-glow {
  position: absolute;
  right: -50px;
  top: -50px;
  width: 220px;
  height: 220px;
  background: radial-gradient(circle, rgba(0, 162, 255, 0.22) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.art-modal-header-hero .crm-modal-close {
  background: rgba(255, 255, 255, 0.12);
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.2);
}
.art-modal-header-hero .crm-modal-close:hover {
  background: rgba(255, 255, 255, 0.25);
  color: #ffffff;
}

/* Dossier Image Wrap */
.art-dossier-img-wrap {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  margin-bottom: 24px;
  height: 280px;
  background: #0f172a;
  border: 1px solid #e2e8f0;
  box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}
.art-dossier-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.art-dossier-img-overlay {
  position: absolute;
  bottom: 14px;
  right: 14px;
}

/* Responsive Form Grids */
.art-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
  margin-bottom: 14px;
}
.art-grid-2-1 {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 14px;
  margin-bottom: 14px;
}
.art-grid-3 {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 16px;
  align-items: center;
  background: #f8fafc;
  padding: 16px 20px;
  border-radius: 10px;
  border: 1px solid #e2e8f0;
}
.art-slug-wrap {
  display: flex;
  align-items: center;
  gap: 8px;
}

/* ========================================================================
   COMPREHENSIVE RESPONSIVE MEDIA QUERIES (Mobile, Tablet, Laptop)
   ======================================================================== */
@media (max-width: 1280px) {
  .art-kpi-row {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 1024px) {
  .art-admin-content {
    padding: 22px 18px;
  }
  .art-toolbar {
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
  }
  .art-search-wrap {
    max-width: 100%;
    min-width: 0;
    width: 100%;
  }
  .art-toolbar-controls {
    width: 100%;
    justify-content: flex-start;
  }
  .art-select {
    flex: 1 1 calc(33.333% - 10px);
    min-width: 140px;
  }
}

@media (max-width: 860px) {
  .art-kpi-row {
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
  }
  .art-scroll-indicator {
    display: block;
  }
}

@media (max-width: 768px) {
  .art-admin-content {
    padding: 16px 12px;
  }
  .art-hero-banner {
    padding: 20px 18px;
    border-radius: 14px;
  }
  .art-title-row {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }
  .art-actions-wrap {
    width: 100%;
  }
  .art-actions-wrap .art-btn {
    flex: 1 1 auto;
    justify-content: center;
    padding: 9px 12px;
  }
  .art-actions-wrap .art-btn-primary {
    flex: 2 1 100%;
  }
  .art-grid-2, .art-grid-2-1 {
    grid-template-columns: 1fr;
    gap: 12px;
  }
  .art-grid-3 {
    grid-template-columns: 1fr;
    gap: 14px;
    padding: 14px;
  }
  .crm-modal-card {
    border-radius: 16px !important;
    max-height: calc(100vh - 20px) !important;
  }
  .art-dossier-img-wrap {
    height: 200px;
    margin-bottom: 16px;
  }
  .art-cards-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
}

@media (max-width: 640px) {
  .art-select {
    flex: 1 1 100%;
    width: 100%;
  }
  .art-view-switch {
    width: 100%;
  }
  .art-view-btn {
    flex: 1;
    justify-content: center;
  }
  .art-slug-wrap {
    flex-direction: column;
    align-items: stretch;
  }
  .art-slug-wrap span {
    text-align: center;
  }
  .crm-modal-footer {
    justify-content: stretch;
  }
  .crm-modal-footer .art-btn {
    flex: 1 1 100%;
    justify-content: center;
  }
  .art-dossier-img-wrap {
    height: 170px;
  }
  .art-dossier-img-overlay {
    bottom: 8px;
    right: 8px;
  }
  .art-dossier-img-overlay .art-btn {
    padding: 6px 10px !important;
    font-size: 0.74rem !important;
  }
}

@media (max-width: 480px) {
  .art-admin-content {
    padding: 12px 8px;
  }
  .art-kpi-row {
    grid-template-columns: 1fr 1fr;
    gap: 8px;
  }
  .art-kpi-card {
    padding: 12px 14px;
  }
  .art-kpi-val {
    font-size: 1.45rem;
  }
  .art-hero-banner {
    padding: 16px 14px;
  }
  .art-badge-pill {
    font-size: 0.65rem;
    padding: 3px 8px;
  }
}
</style>

<!-- ========================================================================
     MAIN VIEWPORT CONTAINER
     ======================================================================== -->
<div class="admin-content art-admin-content">

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
  <div class="art-hero-banner">
    <div class="art-title-row">
      <div>
        <div class="art-badge-pill">
          <span class="art-pulse-dot"></span>
          <span>EDITORIAL ENGINE • V3.2 DISPATCH</span>
        </div>
        <h1 class="art-hero-title">Technical Articles & <span>Editorial Dispatch</span></h1>
        <p class="art-hero-desc">
          Architectural authority, empirical benchmarks, and systems teardowns. Curate full-length engineering whitepapers, code walkthroughs, and technical research for CTOs, senior engineers, and founders.
        </p>
      </div>

      <!-- Action Buttons -->
      <div class="art-actions-wrap">
        <a href="<?= BASE_URL ?>/blogs" target="_blank" class="art-btn art-btn-glass" title="View Public Blog Dispatch">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
          <span>Live Dispatch ↗</span>
        </a>

        <a href="<?= BASE_URL ?>/admin/articles/export" class="art-btn art-btn-glass" title="Download CSV Catalog">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
          <span>Export CSV</span>
        </a>

        <button type="button" class="art-btn art-btn-primary" onclick="openCreateArticleModal()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          <span>New Technical Article</span>
        </button>
      </div>
    </div>
  </div>

  <!-- 2. INTERACTIVE EXECUTIVE KPI SUMMARY CARDS -->
  <div class="art-kpi-row">
    <!-- KPI 1: Total Articles -->
    <div class="art-kpi-card blue" onclick="filterByStatus('all')">
      <div class="art-kpi-header">
        <span class="art-kpi-label">TOTAL ARTICLES</span>
        <div class="art-kpi-icon" style="background: rgba(0, 86, 214, 0.1); color: var(--art-primary);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
        </div>
      </div>
      <div class="art-kpi-val" id="kpiTotalCount"><?= (int)($articleStats['total_articles'] ?? count($articles)) ?></div>
      <div class="art-kpi-sub">
        <strong>Engine Catalog</strong> • All Dispatches
      </div>
    </div>

    <!-- KPI 2: Live & Published -->
    <div class="art-kpi-card green" onclick="filterByStatus('published')">
      <div class="art-kpi-header">
        <span class="art-kpi-label">LIVE & PUBLISHED</span>
        <div class="art-kpi-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--art-emerald);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
      </div>
      <div class="art-kpi-val" style="color: var(--art-emerald);"><?= (int)($articleStats['published_articles'] ?? 7) ?></div>
      <div class="art-kpi-sub">
        <strong>100% Live</strong> • Public on /blogs
      </div>
    </div>

    <!-- KPI 3: Flagship Spotlight -->
    <div class="art-kpi-card amber" onclick="filterByFeatured('1')">
      <div class="art-kpi-header">
        <span class="art-kpi-label">FLAGSHIP SPOTLIGHT</span>
        <div class="art-kpi-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--art-amber);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        </div>
      </div>
      <div class="art-kpi-val" style="color: var(--art-amber);"><?= (int)($articleStats['featured_articles'] ?? 1) ?></div>
      <div class="art-kpi-sub">
        <strong>Hero Spotlight</strong> • Prime Placement
      </div>
    </div>

    <!-- KPI 4: Lead Authors -->
    <div class="art-kpi-card purple">
      <div class="art-kpi-header">
        <span class="art-kpi-label">LEAD AUTHORS</span>
        <div class="art-kpi-icon" style="background: rgba(139, 92, 246, 0.1); color: var(--art-purple);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        </div>
      </div>
      <div class="art-kpi-val" style="color: var(--art-purple);"><?= (int)($articleStats['total_authors'] ?? count($authors)) ?></div>
      <div class="art-kpi-sub">
        <strong>Contributors</strong> • System Leads
      </div>
    </div>

    <!-- KPI 5: Avg Reading Time -->
    <div class="art-kpi-card cyan">
      <div class="art-kpi-header">
        <span class="art-kpi-label">AVG READING TIME</span>
        <div class="art-kpi-icon" style="background: rgba(0, 162, 255, 0.1); color: var(--art-cyan);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
        </div>
      </div>
      <div class="art-kpi-val" style="color: var(--art-cyan);"><?= (float)($articleStats['avg_reading_time'] ?? 10.1) ?>m</div>
      <div class="art-kpi-sub">
        <strong>Deep Dives</strong> • Empirical Proof
      </div>
    </div>
  </div>

  <!-- 3. INTERACTIVE CATEGORY PILL STRIP -->
  <div class="art-filter-bar">
    <button type="button" class="art-filter-pill active" data-cat-id="all" onclick="selectCategory('all', this)">
      <span>All Categories</span>
      <span class="pill-cnt"><?= count($articles) ?></span>
    </button>
    <?php foreach ($categories as $cat): ?>
      <button type="button" class="art-filter-pill" data-cat-id="<?= (int)$cat['id'] ?>" onclick="selectCategory('<?= (int)$cat['id'] ?>', this)">
        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: <?= htmlspecialchars($cat['badge_color'] ?? '#0056d6') ?>;"></span>
        <span><?= htmlspecialchars($cat['name']) ?></span>
        <span class="pill-cnt"><?= (int)($cat['post_count'] ?? 0) ?></span>
      </button>
    <?php endforeach; ?>
  </div>

  <!-- 4. COMMAND TOOLBAR: SEARCH & SELECTORS & VIEW SWITCHER -->
  <div class="art-toolbar">
    <!-- Omni-Search Bar -->
    <div class="art-search-wrap">
      <svg class="art-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
      <input type="text" id="articleSearchInput" class="art-search-input" placeholder="Search title, excerpt, slug, author, keywords..." oninput="handleArticleSearch(this.value)" />
      <kbd class="art-search-kbd">/</kbd>
    </div>

    <!-- Selectors & Dual-View Switcher -->
    <div class="art-toolbar-controls">
      <!-- Author Filter -->
      <select id="authorSelect" class="art-select" onchange="handleAuthorFilter(this.value)">
        <option value="all">All Lead Authors</option>
        <?php foreach ($authors as $author): ?>
          <option value="<?= (int)$author['id'] ?>"><?= htmlspecialchars($author['name']) ?> (<?= (int)$author['post_count'] ?>)</option>
        <?php endforeach; ?>
      </select>

      <!-- Status Filter -->
      <select id="statusSelect" class="art-select" onchange="handleStatusFilter(this.value)">
        <option value="all">All Publication Status</option>
        <option value="published">● Live & Published</option>
        <option value="draft">○ Draft Mode</option>
      </select>

      <!-- Featured Spotlight Filter -->
      <select id="featuredSelect" class="art-select" onchange="handleFeaturedFilter(this.value)">
        <option value="all">All Showcase Types</option>
        <option value="1">★ Flagship Spotlight Only</option>
        <option value="0">Standard Dispatches</option>
      </select>

      <!-- Dual-View Switcher: Table vs Cards -->
      <div class="art-view-switch">
        <button type="button" class="art-view-btn active" id="viewBtnTable" onclick="switchView('table')" title="Switch to Enterprise Table View">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
          <span>Table</span>
        </button>
        <button type="button" class="art-view-btn" id="viewBtnCards" onclick="switchView('cards')" title="Switch to Editorial Cards Grid">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
          <span>Cards</span>
        </button>
      </div>
    </div>
  </div>

  <!-- 5. VIEW A: ENTERPRISE DATA TABLE -->
  <div id="articlesTableView" class="art-table-card">
    <div class="art-scroll-indicator">
      <span>← Swipe horizontally to view full table data →</span>
    </div>
    <div class="art-table-wrap">
      <table class="art-table">
        <thead>
          <tr>
            <th style="width: 50px;">IMG</th>
            <th style="min-width: 280px;">Article Title & URL Slug</th>
            <th>Category</th>
            <th>Lead Author</th>
            <th style="text-align: center;">Spotlight</th>
            <th style="text-align: center;">Status</th>
            <th style="text-align: right; width: 140px;">Actions</th>
          </tr>
        </thead>
        <tbody id="articlesTableBody">
          <?php if (empty($articles)): ?>
            <tr>
              <td colspan="9" style="text-align: center; padding: 40px; color: #94a3b8;">
                No technical articles found matching your query criteria.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($articles as $art): ?>
              <?php
                $imgUrl = !empty($art['featured_image']) ? $art['featured_image'] : 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=400&auto=format&fit=crop';
                $isFeatured = (int)($art['is_featured'] ?? 0) === 1;
                $isPublished = (int)($art['is_published'] ?? 1) === 1;
                $catName = $art['category_name'] ?? 'Architecture';
                $catColor = $art['badge_color'] ?? '#0056d6';
                $catBg = $art['badge_bg'] ?? 'rgba(0,86,214,0.08)';
                $authorName = $art['author_name'] ?? 'ClickCodex Architecture';
                $authorInitials = $art['author_initials'] ?? 'CC';
                $authorRole = $art['author_role'] ?? 'Systems Lead';
                $readTime = (int)($art['reading_time_minutes'] ?? 8);
              ?>
              <tr id="articleRow-<?= (int)$art['id'] ?>" 
                  class="article-data-row" 
                  data-id="<?= (int)$art['id'] ?>"
                  data-cat="<?= (int)$art['category_id'] ?>"
                  data-author="<?= (int)$art['author_id'] ?>"
                  data-featured="<?= $isFeatured ? '1' : '0' ?>"
                  data-published="<?= $isPublished ? '1' : '0' ?>"
                  data-title="<?= htmlspecialchars(strtolower($art['title'])) ?>"
                  data-slug="<?= htmlspecialchars(strtolower($art['slug'])) ?>"
                  data-excerpt="<?= htmlspecialchars(strtolower($art['excerpt'])) ?>"
                  data-keywords="<?= htmlspecialchars(strtolower($art['search_keywords'] ?? '')) ?>"
                  data-author-name="<?= htmlspecialchars(strtolower($authorName)) ?>">
                
                <!-- Thumbnail -->
                <td>
                  <img src="<?= htmlspecialchars($imgUrl) ?>" alt="Thumbnail" class="art-thumb-cell" loading="lazy" />
                </td>

                <!-- Title & Slug -->
                <td>
                  <a href="javascript:void(0)" onclick="viewArticleDossier(<?= (int)$art['id'] ?>)" class="art-title-cell" id="articleTableTitle-<?= (int)$art['id'] ?>">
                    <?= htmlspecialchars($art['title']) ?>
                  </a>
                  <span class="art-slug-text">
                    /blogs/<?= htmlspecialchars($art['slug']) ?>
                    <?php if (!empty($art['featured_badge'])): ?>
                      <span style="background: rgba(0, 86, 214, 0.1); color: var(--art-primary); font-weight: 700; padding: 1px 6px; border-radius: 4px; font-size: 0.68rem; margin-left: 6px;">
                        <?= htmlspecialchars($art['featured_badge']) ?>
                      </span>
                    <?php endif; ?>
                  </span>
                </td>

                <!-- Category -->
                <td>
                  <span class="art-cat-badge" style="background: <?= htmlspecialchars($catBg) ?>; color: <?= htmlspecialchars($catColor) ?>; border: 1px solid <?= htmlspecialchars($catColor) ?>30;">
                    <?= htmlspecialchars($catName) ?>
                  </span>
                </td>

                <!-- Author -->
                <td>
                  <div class="art-author-pill">
                    <div class="art-author-avatar"><?= htmlspecialchars($authorInitials) ?></div>
                    <div>
                      <div style="font-weight: 700; color: #0f172a; font-size: 0.82rem;"><?= htmlspecialchars($authorName) ?></div>
                      <div style="font-size: 0.72rem; color: #64748b;"><?= htmlspecialchars($authorRole) ?></div>
                    </div>
                  </div>
                </td>

                <!-- Featured Star Toggle -->
                <td style="text-align: center;">
                  <button type="button" class="art-star-btn <?= $isFeatured ? 'active' : '' ?>" id="starBtn-<?= (int)$art['id'] ?>" onclick="toggleFeaturedStar(<?= (int)$art['id'] ?>, <?= $isFeatured ? 0 : 1 ?>)" title="Toggle Flagship Spotlight">
                    <?= $isFeatured ? '★' : '☆' ?>
                  </button>
                </td>

                <!-- Status Toggle Switch -->
                <td style="text-align: center;">
                  <label class="art-toggle-switch" title="Toggle Published / Draft Status">
                    <input type="checkbox" id="statusToggle-<?= (int)$art['id'] ?>" <?= $isPublished ? 'checked' : '' ?> onchange="toggleArticlePublishStatus(<?= (int)$art['id'] ?>, this.checked)" />
                    <span class="art-toggle-slider"></span>
                  </label>
                </td>

                <!-- Quick Action Buttons -->
                <td style="text-align: right;">
                  <div class="art-actions-cell" style="justify-content: flex-end;">
                    <!-- Dossier View -->
                    <button type="button" class="art-action-btn" onclick="viewArticleDossier(<?= (int)$art['id'] ?>)" title="View Whitepaper Dossier">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>

                    <!-- Edit Article -->
                    <button type="button" class="art-action-btn" onclick="editArticle(<?= (int)$art['id'] ?>)" title="Edit Technical Article">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>

                    <!-- Duplicate Article -->
                    <button type="button" class="art-action-btn" onclick="duplicateArticle(<?= (int)$art['id'] ?>)" title="Duplicate / Clone Article">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    </button>

                    <!-- Delete Article -->
                    <button type="button" class="art-action-btn delete" onclick="confirmDeleteArticle(<?= (int)$art['id'] ?>)" title="Delete Article">
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

  <!-- 6. VIEW B: EDITORIAL CARDS GRID -->
  <div id="articlesCardsView" class="art-cards-grid" style="display: none;">
    <?php foreach ($articles as $art): ?>
      <?php
        $imgUrl = !empty($art['featured_image']) ? $art['featured_image'] : 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=600&auto=format&fit=crop';
        $isFeatured = (int)($art['is_featured'] ?? 0) === 1;
        $isPublished = (int)($art['is_published'] ?? 1) === 1;
        $catName = $art['category_name'] ?? 'Architecture';
        $catColor = $art['badge_color'] ?? '#0056d6';
        $authorName = $art['author_name'] ?? 'ClickCodex Architecture';
        $authorInitials = $art['author_initials'] ?? 'CC';
        $authorRole = $art['author_role'] ?? 'Systems Lead';
        $readTime = (int)($art['reading_time_minutes'] ?? 8);
      ?>
      <div id="articleCard-<?= (int)$art['id'] ?>" 
           class="art-card article-card-item"
           data-id="<?= (int)$art['id'] ?>"
           data-cat="<?= (int)$art['category_id'] ?>"
           data-author="<?= (int)$art['author_id'] ?>"
           data-featured="<?= $isFeatured ? '1' : '0' ?>"
           data-published="<?= $isPublished ? '1' : '0' ?>"
           data-title="<?= htmlspecialchars(strtolower($art['title'])) ?>"
           data-slug="<?= htmlspecialchars(strtolower($art['slug'])) ?>"
           data-excerpt="<?= htmlspecialchars(strtolower($art['excerpt'])) ?>"
           data-keywords="<?= htmlspecialchars(strtolower($art['search_keywords'] ?? '')) ?>"
           data-author-name="<?= htmlspecialchars(strtolower($authorName)) ?>">
        
        <!-- Image Header -->
        <div class="art-card-img-wrap">
          <img src="<?= htmlspecialchars($imgUrl) ?>" alt="Article Cover" class="art-card-img" loading="lazy" />

          <!-- Top Left Badges -->
          <div class="art-card-badge-top">
            <span class="art-badge-pill" style="margin-bottom: 0; background: rgba(9, 13, 22, 0.7); backdrop-filter: blur(6px); border-color: rgba(255,255,255,0.2); color: #ffffff;">
              <?= htmlspecialchars($catName) ?>
            </span>
            <?php if ($isFeatured): ?>
              <span class="art-badge-pill" style="margin-bottom: 0; background: rgba(245, 158, 11, 0.9); color: #ffffff; border: none;">
                ★ Spotlight
              </span>
            <?php endif; ?>
          </div>

          <!-- Top Right Action Controls -->
          <div class="art-card-actions-top">
            <button type="button" class="art-action-btn" onclick="viewArticleDossier(<?= (int)$art['id'] ?>)" title="Preview Dossier" style="background: rgba(9, 13, 22, 0.75); color: #ffffff; border-color: rgba(255,255,255,0.2);">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </button>
            <button type="button" class="art-action-btn" onclick="editArticle(<?= (int)$art['id'] ?>)" title="Edit Article" style="background: rgba(9, 13, 22, 0.75); color: #ffffff; border-color: rgba(255,255,255,0.2);">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            </button>
          </div>
        </div>

        <!-- Card Body -->
        <div class="art-card-body">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
            <span style="font-family: var(--font-mono, monospace); font-size: 0.72rem; color: #94a3b8;">
              <?= $readTime ?> MIN READ
            </span>
            <span style="font-family: var(--font-mono, monospace); font-size: 0.72rem; color: #94a3b8;">
              <?= date('M d, Y', strtotime($art['published_at'] ?? 'now')) ?>
            </span>
          </div>

          <h3 class="art-card-title" onclick="viewArticleDossier(<?= (int)$art['id'] ?>)" id="articleCardTitle-<?= (int)$art['id'] ?>">
            <?= htmlspecialchars($art['title']) ?>
          </h3>

          <p class="art-card-excerpt">
            <?= htmlspecialchars($art['excerpt']) ?>
          </p>

          <!-- Author Row -->
          <div style="display: flex; align-items: center; gap: 8px; margin-top: auto; padding-top: 12px; border-top: 1px solid #f1f5f9;">
            <div class="art-author-avatar"><?= htmlspecialchars($authorInitials) ?></div>
            <div style="flex: 1;">
              <div style="font-size: 0.8rem; font-weight: 700; color: #0f172a;"><?= htmlspecialchars($authorName) ?></div>
              <div style="font-size: 0.7rem; color: #64748b;"><?= htmlspecialchars($authorRole) ?></div>
            </div>

            <!-- Instant Publish Toggle -->
            <label class="art-toggle-switch" title="Toggle Published / Draft Status">
              <input type="checkbox" id="cardStatusToggle-<?= (int)$art['id'] ?>" <?= $isPublished ? 'checked' : '' ?> onchange="toggleArticlePublishStatus(<?= (int)$art['id'] ?>, this.checked)" />
              <span class="art-toggle-slider"></span>
            </label>
          </div>
        </div>

        <!-- Card Footer -->
        <div class="art-card-foot">
          <a href="<?= BASE_URL ?>/blogs/<?= htmlspecialchars($art['slug']) ?>" target="_blank" style="font-size: 0.76rem; font-weight: 700; color: #0056d6; text-decoration: none; display: flex; align-items: center; gap: 4px;">
            <span>Public Article</span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
          </a>

          <div style="display: flex; gap: 6px;">
            <button type="button" class="art-action-btn" onclick="duplicateArticle(<?= (int)$art['id'] ?>)" title="Clone Article">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
            </button>
            <button type="button" class="art-action-btn delete" onclick="confirmDeleteArticle(<?= (int)$art['id'] ?>)" title="Delete Article">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div><!-- /admin-content -->


<!-- ========================================================================
     MODAL 1: ARTICLE DOSSIER PREVIEW MODAL (FLOATING DIALOG POPUP)
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="viewArticleModalBackdrop" style="display: none;" onclick="closeViewArticleModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 880px;" onclick="event.stopPropagation()">
    
    <!-- Modal Header Hero -->
    <div class="art-modal-header-hero">
      <div class="art-modal-hero-glow"></div>
      <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; position: relative; z-index: 2;">
        <div style="flex: 1;">
          <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; flex-wrap: wrap;">
            <span id="viewArticleCategory" style="font-size: 0.72rem; font-family: var(--font-mono, monospace); font-weight: 800; background: rgba(0, 162, 255, 0.2); color: #38bdf8; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">
              ARCHITECTURE
            </span>
            <span id="viewArticleBadge" style="font-size: 0.72rem; font-weight: 800; background: rgba(16, 185, 129, 0.25); color: #34d399; padding: 2px 8px; border-radius: 4px;">
              FEATURED
            </span>
            <span id="viewArticleSpotlightBadge" style="display: none; font-size: 0.72rem; font-weight: 800; background: rgba(245, 158, 11, 0.25); color: #fbbf24; padding: 2px 8px; border-radius: 4px;">
              ★ SPOTLIGHT ARTICLE
            </span>
          </div>

          <h2 id="viewArticleTitle" style="font-size: 1.45rem; font-weight: 800; margin: 0; color: #ffffff; line-height: 1.3;">
            Article Title Goes Here
          </h2>

          <div style="font-size: 0.84rem; color: #cbd5e1; margin-top: 6px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
            <span id="viewArticleAuthor" style="font-weight: 800; color: #ffffff;">Author Name</span>
            <span>•</span>
            <span id="viewArticleReadingTime" style="font-family: var(--font-mono, monospace);">12 Min Read</span>
            <span>•</span>
            <span id="viewArticleDate">Published Date</span>
          </div>
        </div>

        <button type="button" class="crm-modal-close" onclick="closeViewArticleModal()" aria-label="Close dialog">✕</button>
      </div>
    </div>

    <!-- Modal Body -->
    <div class="crm-modal-body" style="padding: 26px;">
      
      <!-- Featured Image Banner with Overlaid Public Link -->
      <div style="position: relative; border-radius: 12px; overflow: hidden; margin-bottom: 24px; max-height: 280px; background: #0f172a; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
        <img id="viewArticleImage" src="" alt="Article Preview" style="width: 100%; height: 280px; object-fit: cover;" />
        <div style="position: absolute; bottom: 14px; right: 14px;">
          <a id="viewArticleLiveLink" href="#" target="_blank" class="art-btn art-btn-primary" style="padding: 7px 14px; font-size: 0.8rem; text-decoration: none;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
            <span>Visit Public Article ↗</span>
          </a>
        </div>
      </div>

      <!-- Executive Excerpt Synopsis -->
      <div style="margin-bottom: 24px;">
        <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin-bottom: 8px;">
          Executive Synopsis & Lead Angle
        </div>
        <p id="viewArticleExcerpt" style="font-size: 0.94rem; color: #0f172a; line-height: 1.65; background: #f8fafc; padding: 16px 18px; border-radius: 10px; border-left: 4px solid #0056d6; border-top: 1px solid #f1f5f9; border-right: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; margin: 0;">
          Synopsis text...
        </p>
      </div>

      <!-- Full Article Content Preview -->
      <div style="margin-bottom: 24px;">
        <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin-bottom: 10px;">
          Article Full Content & Code Walkthrough
        </div>
        <div id="viewArticleContent" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; max-height: 380px; overflow-y: auto; font-size: 0.9rem; line-height: 1.7; color: #334155;">
          <!-- Injected dynamically via JS -->
        </div>
      </div>

      <!-- Keywords & Technical Tags -->
      <div>
        <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin-bottom: 10px;">
          Index Tags & Search Keywords
        </div>
        <div id="viewArticleTags" style="display: flex; gap: 7px; flex-wrap: wrap;">
          <!-- Injected via JS -->
        </div>
      </div>

    </div>

    <!-- Modal Footer -->
    <div class="crm-modal-footer">
      <div style="font-size: 0.76rem; color: #94a3b8; font-family: var(--font-mono, monospace); margin-right: auto;">
        ARTICLE ID: #<span id="viewArticleId">0</span>
      </div>

      <button type="button" class="art-btn art-btn-glass" onclick="closeViewArticleModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
        Close
      </button>
      <button type="button" class="art-btn art-btn-primary" id="viewArticleEditBtn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        <span>Edit This Article</span>
      </button>
    </div>

  </div>
</div>


<!-- ========================================================================
     MODAL 2: CREATE / EDIT ARTICLE MODAL (AUTHORING STUDIO POPUP)
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="editArticleModalBackdrop" style="display: none;" onclick="closeEditArticleModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 900px;" onclick="event.stopPropagation()">
    
    <!-- Modal Header -->
    <div class="crm-modal-header">
      <div>
        <h3 class="crm-modal-title" id="editArticleModalTitle">New Technical Article</h3>
        <p class="crm-modal-subtitle">Author high-impact engineering whitepapers, empirical benchmarks, and system teardowns.</p>
      </div>
      <button type="button" class="crm-modal-close" onclick="closeEditArticleModal()" aria-label="Close dialog">✕</button>
    </div>

    <!-- Modal Form -->
    <form id="articleForm" class="crm-modal-form" onsubmit="submitArticleForm(event)">
      <input type="hidden" id="artFieldId" name="id" value="0" />

      <div class="crm-modal-body">

        <!-- SECTION 1: EDITORIAL TAXONOMY & HEADLINE -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 0 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          1. Editorial Identity & Authorship
        </div>

        <div class="crm-form-group">
          <label for="artFieldTitle">Article Headline Title *</label>
          <input type="text" id="artFieldTitle" name="title" class="crm-form-input" placeholder="e.g. Building Sub-10ms Global APIs with Edge Computing and Rust Microservices" required oninput="handleTitleInput(this.value)" />
        </div>

        <div class="art-grid-2">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="artFieldCategory">Editorial Category *</label>
            <select id="artFieldCategory" name="category_id" class="crm-form-select" required>
              <option value="">Select Domain Category...</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="artFieldAuthor">Lead Author / Contributor *</label>
            <select id="artFieldAuthor" name="author_id" class="crm-form-select" required>
              <option value="">Select Lead Author...</option>
              <?php foreach ($authors as $author): ?>
                <option value="<?= (int)$author['id'] ?>"><?= htmlspecialchars($author['name']) ?> (<?= htmlspecialchars($author['role_title']) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- URL Slug with Auto-generate toggle -->
        <div class="crm-form-group" style="margin-bottom: 22px;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
            <label for="artFieldSlug" style="margin-bottom: 0;">URL Slug *</label>
            <label style="font-size: 0.74rem; color: #64748b; cursor: pointer; display: flex; align-items: center; gap: 4px;">
              <input type="checkbox" id="artAutoSlugCheck" checked onchange="toggleAutoSlug(this.checked)" />
              Auto-generate from title
            </label>
          </div>
          <div class="art-slug-wrap">
            <span style="font-family: var(--font-mono, monospace); font-size: 0.78rem; color: #64748b; background: #f8fafc; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px;">/blogs/</span>
            <input type="text" id="artFieldSlug" name="slug" class="crm-form-input" style="font-family: var(--font-mono, monospace); font-size: 0.85rem;" placeholder="e.g. sub-10ms-global-apis-edge-rust" required />
          </div>
        </div>

        <!-- SECTION 2: CONTENT & NARRATIVE -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 24px 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          2. Narrative, Executive Summary & Reading Metrics
        </div>

        <div class="art-grid-2-1">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="artFieldBadge">Headline Featured Badge</label>
            <input type="text" id="artFieldBadge" name="featured_badge" class="crm-form-input" placeholder="e.g. Featured Architecture Teardown, 120 FPS Benchmark" />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="artFieldReadingTime">Estimated Reading Time (Mins) *</label>
            <input type="number" id="artFieldReadingTime" name="reading_time_minutes" class="crm-form-input" value="8" min="1" max="120" required />
          </div>
        </div>

        <div class="crm-form-group">
          <label for="artFieldExcerpt">Executive Excerpt (Synopsis) *</label>
          <textarea id="artFieldExcerpt" name="excerpt" rows="3" class="crm-notes-textarea" placeholder="Crisp 2-sentence summary displayed on cards, social shares, and search engine SERPs..." required></textarea>
        </div>

        <div class="crm-form-group" style="margin-bottom: 22px;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
            <label for="artFieldContent" style="margin-bottom: 0;">Full Technical Content (HTML / Markdown supported) *</label>
            <span style="font-size: 0.72rem; color: #64748b;">Supports &lt;h2&gt;, &lt;p&gt;, &lt;pre&gt;&lt;code&gt;, &lt;table&gt;</span>
          </div>
          <textarea id="artFieldContent" name="content" rows="10" class="crm-notes-textarea" style="min-height: 200px; font-family: var(--font-mono, monospace); font-size: 0.84rem;" placeholder="<div class='article-content-wrapper'>&#10;  <h2>1. Architectural Overview</h2>&#10;  <p>Detailed analysis...</p>&#10;</div>" required></textarea>
        </div>

        <!-- SECTION 3: VISUAL ASSETS & DISCOVERY KEYWORDS -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 24px 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          3. Visual Assets & Discovery Keywords
        </div>

        <!-- Image URL with Live Thumbnail Preview -->
        <div class="crm-form-group">
          <label for="artFieldImage">Featured Cover Image URL</label>
          <div style="display: flex; gap: 10px; align-items: center;">
            <input type="url" id="artFieldImage" name="featured_image" class="crm-form-input" style="flex: 1;" placeholder="https://images.unsplash.com/..." oninput="updateImagePreview(this.value)" value="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop" />
            <img id="artImagePreview" src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop" alt="Thumbnail Preview" style="width: 52px; height: 42px; border-radius: 8px; object-fit: cover; border: 1px solid #cbd5e1; flex-shrink: 0;" />
          </div>

          <!-- Unsplash Presets -->
          <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px;">
            <span style="font-size: 0.72rem; color: #64748b; font-weight: 600;">Image Presets:</span>
            <button type="button" onclick="setImagePreset('https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">Systems/Code</button>
            <button type="button" onclick="setImagePreset('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=800&auto=format&fit=crop')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">AI/Cloud Network</button>
            <button type="button" onclick="setImagePreset('https://images.unsplash.com/photo-1504639725590-34d0984388bd?q=80&w=800&auto=format&fit=crop')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">Developer Workstation</button>
            <button type="button" onclick="setImagePreset('https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?q=80&w=800&auto=format&fit=crop')" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-size: 0.7rem; color: #64748b; cursor: pointer;">Cybersecurity/Matrix</button>
          </div>
        </div>

        <!-- Tags / Keywords -->
        <div class="art-grid-2" style="margin-bottom: 22px;">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="artFieldTags">Topic Tags (Comma-Separated)</label>
            <input type="text" id="artFieldTags" name="tags" class="crm-form-input" placeholder="e.g. Rust, Microservices, Edge Computing, Kubernetes" />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="artFieldKeywords">Search Engine Keywords</label>
            <input type="text" id="artFieldKeywords" name="search_keywords" class="crm-form-input" placeholder="e.g. rust microservices edge latency benchmarks" />
          </div>
        </div>

        <!-- SECTION 4: PUBLICATION VISIBILITY & SPOTLIGHT -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 24px 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          4. Publication Status & Spotlight Visibility
        </div>

        <div class="art-grid-3">
          <div>
            <label for="artFieldPublishedAt" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Publication Date</label>
            <input type="text" id="artFieldPublishedAt" name="published_at" class="crm-form-input" value="<?= date('Y-m-d H:i:s') ?>" />
          </div>

          <div style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" id="artFieldFeatured" name="is_featured" value="1" style="width: 18px; height: 18px; cursor: pointer; accent-color: #f59e0b;" />
            <label for="artFieldFeatured" style="margin-bottom: 0; cursor: pointer; font-size: 0.86rem; font-weight: 700; color: #0f172a;">
              ★ Flagship Spotlight
              <span style="display: block; font-size: 0.72rem; color: #64748b; font-weight: 400;">Highlight prominently in hero dispatch carousel.</span>
            </label>
          </div>

          <div style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" id="artFieldActive" name="is_published" value="1" checked style="width: 18px; height: 18px; cursor: pointer; accent-color: #10b981;" />
            <label for="artFieldActive" style="margin-bottom: 0; cursor: pointer; font-size: 0.86rem; font-weight: 700; color: #0f172a;">
              ● Live & Published
              <span style="display: block; font-size: 0.72rem; color: #64748b; font-weight: 400;">Immediately visible on /blogs.</span>
            </label>
          </div>
        </div>


      </div>

      <!-- Modal Footer -->
      <div class="crm-modal-footer">
        <button type="button" class="art-btn art-btn-glass" onclick="closeEditArticleModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
          Cancel
        </button>
        <button type="submit" class="art-btn art-btn-primary" id="btnSubmitArticle">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span id="btnSubmitArticleText">Save Article</span>
        </button>
      </div>

    </form>
  </div>
</div>


<!-- ========================================================================
     MODAL 3: DELETE CONFIRMATION DIALOG (POPUP)
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="deleteArticleModalBackdrop" style="display: none;" onclick="closeDeleteArticleModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 460px;" onclick="event.stopPropagation()">
    <div class="crm-modal-header" style="border-bottom: none; padding-bottom: 0; align-items: flex-start;">
      <div style="display: flex; gap: 14px; align-items: flex-start; flex: 1;">
        <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(220, 38, 38, 0.1); color: #dc2626; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        </div>
        <div style="flex: 1;">
          <h3 class="crm-modal-title" style="color: #0f172a; font-size: 1.15rem; margin: 0;">Delete Technical Article</h3>
          <p class="crm-modal-subtitle" style="margin-top: 4px; font-size: 0.84rem; line-height: 1.4;">Are you sure you want to remove <strong id="deleteTargetTitle" style="color: #0f172a; word-break: break-word;"></strong> from the technical dispatch?</p>
        </div>
      </div>
      <button type="button" class="crm-modal-close" onclick="closeDeleteArticleModal()" aria-label="Close dialog">✕</button>
    </div>

    <div class="crm-modal-body" style="padding: 16px 26px; font-size: 0.84rem; color: #64748b; line-height: 1.5;">
      This action will permanently delete this whitepaper and its associated comments and tags. It cannot be recovered.
    </div>

    <div class="crm-modal-footer" style="padding: 16px 26px; border-top: 1px solid #f1f5f9;">
      <button type="button" class="art-btn art-btn-glass" onclick="closeDeleteArticleModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
        Cancel
      </button>
      <button type="button" class="art-btn" id="btnConfirmDeleteAction" style="background: #dc2626; color: #ffffff; border: none; font-weight: 700;">
        Yes, Delete Record
      </button>
    </div>
  </div>
</div>


<!-- Toast Notifications Overlay -->
<div id="adminToastContainer" style="position: fixed; bottom: 24px; right: 24px; z-index: 100001; display: flex; flex-direction: column; gap: 8px; pointer-events: none;"></div>


<!-- ========================================================================
     ARTICLES JAVASCRIPT CONTROLLER
     ======================================================================== -->
<script>
/**
 * ClickCodex Studio - Articles & Technical Dispatch Controller
 */
const BASE_URL = '<?= BASE_URL ?>';
let autoSlugEnabled = true;
let deleteTargetId = 0;
let currentViewMode = 'table'; // 'table' or 'cards'

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', () => {
  // Restore view mode preference from localStorage
  const savedView = localStorage.getItem('cc_articles_view');
  if (savedView === 'cards') {
    switchView('cards');
  }

  // Keyboard shortcut '/' to focus search & Esc to close modals
  document.addEventListener('keydown', (e) => {
    if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
      e.preventDefault();
      const s = document.getElementById('articleSearchInput');
      if (s) { s.focus(); s.select(); }
    } else if (e.key === 'Escape') {
      closeViewArticleModal();
      closeEditArticleModal();
      closeDeleteArticleModal();
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
function switchView(mode) {
  currentViewMode = mode;
  localStorage.setItem('cc_articles_view', mode);

  const tableView = document.getElementById('articlesTableView');
  const cardsView = document.getElementById('articlesCardsView');
  const btnTable = document.getElementById('viewBtnTable');
  const btnCards = document.getElementById('viewBtnCards');

  if (mode === 'cards') {
    tableView.style.display = 'none';
    cardsView.style.display = 'grid';
    btnTable.classList.remove('active');
    btnCards.classList.add('active');
  } else {
    tableView.style.display = 'block';
    cardsView.style.display = 'none';
    btnTable.classList.add('active');
    btnCards.classList.remove('active');
  }
}

// ============================================================================
// DYNAMIC CLIENT-SIDE FILTERING & SEARCH
// ============================================================================
let activeCatFilter = 'all';
let activeAuthorFilter = 'all';
let activeStatusFilter = 'all';
let activeFeaturedFilter = 'all';

function selectCategory(catId, btnEl) {
  activeCatFilter = catId;
  document.querySelectorAll('.art-filter-pill').forEach(p => p.classList.remove('active'));
  btnEl.classList.add('active');
  applyFilters();
}

function handleAuthorFilter(authorId) {
  activeAuthorFilter = authorId;
  applyFilters();
}

function handleStatusFilter(status) {
  activeStatusFilter = status;
  applyFilters();
}

function handleFeaturedFilter(feat) {
  activeFeaturedFilter = feat;
  applyFilters();
}

function filterByStatus(status) {
  document.getElementById('statusSelect').value = status;
  activeStatusFilter = status;
  applyFilters();
}

function filterByFeatured(feat) {
  document.getElementById('featuredSelect').value = feat;
  activeFeaturedFilter = feat;
  applyFilters();
}

function handleArticleSearch(val) {
  applyFilters();
}

function applyFilters() {
  const query = (document.getElementById('articleSearchInput')?.value || '').toLowerCase().trim();

  const rows = document.querySelectorAll('.article-data-row');
  const cards = document.querySelectorAll('.article-card-item');

  let visibleCount = 0;

  const matches = (el) => {
    const cat = el.getAttribute('data-cat');
    const author = el.getAttribute('data-author');
    const featured = el.getAttribute('data-featured');
    const published = el.getAttribute('data-published');
    const title = el.getAttribute('data-title') || '';
    const slug = el.getAttribute('data-slug') || '';
    const excerpt = el.getAttribute('data-excerpt') || '';
    const keywords = el.getAttribute('data-keywords') || '';
    const authorName = el.getAttribute('data-author-name') || '';

    // Category match
    if (activeCatFilter !== 'all' && cat !== activeCatFilter) return false;

    // Author match
    if (activeAuthorFilter !== 'all' && author !== activeAuthorFilter) return false;

    // Status match
    if (activeStatusFilter !== 'all') {
      if (activeStatusFilter === 'published' && published !== '1') return false;
      if (activeStatusFilter === 'draft' && published !== '0') return false;
    }

    // Featured match
    if (activeFeaturedFilter !== 'all' && featured !== activeFeaturedFilter) return false;

    // Search query match
    if (query !== '') {
      const matchText = `${title} ${slug} ${excerpt} ${keywords} ${authorName}`;
      if (!matchText.includes(query)) return false;
    }

    return true;
  };

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
      c.style.display = '';
    } else {
      c.style.display = 'none';
    }
  });
}

// ============================================================================
// MODAL 1: VIEW ARTICLE DOSSIER
// ============================================================================
async function viewArticleDossier(id) {
  const backdrop = document.getElementById('viewArticleModalBackdrop');
  if (!backdrop) return;

  // 1. Immediately open modal with loading state
  backdrop.style.display = 'flex';
  backdrop.classList.add('show');
  document.body.style.overflow = 'hidden';

  // Skeletons / Initial feedback
  document.getElementById('viewArticleId').textContent = id;
  document.getElementById('viewArticleTitle').textContent = 'Loading Article Dossier...';
  document.getElementById('viewArticleCategory').textContent = 'LOADING...';
  document.getElementById('viewArticleBadge').style.display = 'none';
  document.getElementById('viewArticleSpotlightBadge').style.display = 'none';
  document.getElementById('viewArticleAuthor').textContent = 'ClickCodex Engine';
  document.getElementById('viewArticleReadingTime').textContent = '-- Min Read';
  document.getElementById('viewArticleDate').textContent = 'Fetching dispatch...';
  document.getElementById('viewArticleExcerpt').textContent = 'Loading editorial summary...';
  document.getElementById('viewArticleContent').innerHTML = `
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 20px; color: #64748b; gap: 12px;">
      <div style="width: 28px; height: 28px; border: 3px solid #e2e8f0; border-top-color: #0056d6; border-radius: 50%; animation: crmSpinner 0.8s linear infinite;"></div>
      <span style="font-size: 0.86rem; font-weight: 600;">Compiling Technical Whitepaper Dossier #${id}...</span>
    </div>
  `;
  document.getElementById('viewArticleTags').innerHTML = '<span style="font-size:0.75rem; color:#94a3b8;">Loading tags...</span>';

  try {
    const res = await fetch(`${BASE_URL}/admin/article/detail?id=${id}`);
    const data = await res.json();

    if (!data.success || !data.article) {
      showToast(data.error || 'Failed to load article dossier.', 'error');
      closeViewArticleModal();
      return;
    }

    const art = data.article;

    document.getElementById('viewArticleId').textContent = art.id;
    document.getElementById('viewArticleTitle').textContent = art.title;
    document.getElementById('viewArticleCategory').textContent = art.category_name || 'ARCHITECTURE';
    document.getElementById('viewArticleAuthor').textContent = `${art.author_name || 'ClickCodex Lead'} (${art.author_role || 'Systems Architect'})`;
    document.getElementById('viewArticleReadingTime').textContent = `${art.reading_time_minutes || 8} Min Read`;
    document.getElementById('viewArticleDate').textContent = art.published_at || 'Recently Published';

    const badgeEl = document.getElementById('viewArticleBadge');
    if (art.featured_badge) {
      badgeEl.textContent = art.featured_badge;
      badgeEl.style.display = 'inline-block';
    } else {
      badgeEl.style.display = 'none';
    }

    const spotEl = document.getElementById('viewArticleSpotlightBadge');
    spotEl.style.display = (parseInt(art.is_featured, 10) === 1) ? 'inline-block' : 'none';

    const imgEl = document.getElementById('viewArticleImage');
    imgEl.src = art.featured_image || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop';

    document.getElementById('viewArticleLiveLink').href = `${BASE_URL}/blogs/${art.slug}`;
    document.getElementById('viewArticleExcerpt').textContent = art.excerpt || 'No synopsis provided.';

    // Render full content
    const contentBox = document.getElementById('viewArticleContent');
    contentBox.innerHTML = art.content || '<p>No body content written for this article.</p>';

    // Render tags
    const tagsContainer = document.getElementById('viewArticleTags');
    tagsContainer.innerHTML = '';
    const tags = Array.isArray(art.tags_arr) ? art.tags_arr : (art.tags_str ? art.tags_str.split(',') : []);
    if (tags.length > 0) {
      tags.forEach(t => {
        const cleanT = t.trim();
        if (!cleanT) return;
        const tagSpan = document.createElement('span');
        tagSpan.style.background = '#f1f5f9';
        tagSpan.style.border = '1px solid #cbd5e1';
        tagSpan.style.padding = '3px 9px';
        tagSpan.style.borderRadius = '5px';
        tagSpan.style.fontSize = '0.74rem';
        tagSpan.style.color = '#334155';
        tagSpan.style.fontFamily = 'var(--font-mono, monospace)';
        tagSpan.textContent = `#${cleanT}`;
        tagsContainer.appendChild(tagSpan);
      });
    } else {
      tagsContainer.innerHTML = '<span style="font-size:0.75rem; color:#94a3b8;">No tags attached.</span>';
    }

    // Hook up Edit button
    const editBtn = document.getElementById('viewArticleEditBtn');
    editBtn.onclick = () => {
      closeViewArticleModal();
      editArticle(art.id);
    };
  } catch (err) {
    showToast('Failed to load article dossier.', 'error');
    closeViewArticleModal();
  }
}

function closeViewArticleModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close')) return;
  const backdrop = document.getElementById('viewArticleModalBackdrop');
  if (backdrop) {
    backdrop.classList.remove('show');
    backdrop.style.display = 'none';
  }
  document.body.style.overflow = '';
}

// ============================================================================
// MODAL 2: CREATE & EDIT ARTICLE STUDIO
// ============================================================================
function openCreateArticleModal() {
  const form = document.getElementById('articleForm');
  if (form) form.reset();

  document.getElementById('artFieldId').value = '0';
  document.getElementById('editArticleModalTitle').textContent = 'New Technical Article';
  document.getElementById('btnSubmitArticleText').textContent = 'Publish Article';
  document.getElementById('btnSubmitArticle').disabled = false;

  autoSlugEnabled = true;
  document.getElementById('artAutoSlugCheck').checked = true;

  updateImagePreview('https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop');

  const backdrop = document.getElementById('editArticleModalBackdrop');
  if (backdrop) {
    backdrop.style.display = 'flex';
    backdrop.classList.add('show');
  }
  document.body.style.overflow = 'hidden';
}

async function editArticle(id) {
  const backdrop = document.getElementById('editArticleModalBackdrop');
  if (backdrop) {
    backdrop.style.display = 'flex';
    backdrop.classList.add('show');
  }
  document.body.style.overflow = 'hidden';

  const titleEl = document.getElementById('editArticleModalTitle');
  const submitBtn = document.getElementById('btnSubmitArticle');
  const btnText = document.getElementById('btnSubmitArticleText');

  titleEl.textContent = `Loading Article #${id}...`;
  submitBtn.disabled = true;
  btnText.textContent = 'Loading...';

  try {
    const res = await fetch(`${BASE_URL}/admin/article/detail?id=${id}`);
    const data = await res.json();

    if (!data.success || !data.article) {
      showToast(data.error || 'Failed to load article.', 'error');
      closeEditArticleModal();
      return;
    }

    const art = data.article;

    document.getElementById('artFieldId').value = art.id;
    document.getElementById('artFieldTitle').value = art.title || '';
    document.getElementById('artFieldSlug').value = art.slug || '';
    document.getElementById('artFieldCategory').value = art.category_id || '';
    document.getElementById('artFieldAuthor').value = art.author_id || '';
    document.getElementById('artFieldBadge').value = art.featured_badge || '';
    document.getElementById('artFieldReadingTime').value = art.reading_time_minutes || 8;
    document.getElementById('artFieldExcerpt').value = art.excerpt || '';
    document.getElementById('artFieldContent').value = art.content || '';
    document.getElementById('artFieldTags').value = art.tags_str || '';
    document.getElementById('artFieldKeywords').value = art.search_keywords || '';
    document.getElementById('artFieldPublishedAt').value = art.published_at || '';

    const imgUrl = art.featured_image || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop';
    document.getElementById('artFieldImage').value = imgUrl;
    updateImagePreview(imgUrl);

    document.getElementById('artFieldFeatured').checked = (parseInt(art.is_featured, 10) === 1);
    document.getElementById('artFieldActive').checked = (parseInt(art.is_published, 10) === 1);

    autoSlugEnabled = false;
    document.getElementById('artAutoSlugCheck').checked = false;

    titleEl.textContent = `Edit Technical Article #${art.id}`;
    btnText.textContent = 'Update Article';
    submitBtn.disabled = false;
  } catch (err) {
    showToast('Failed to load article for editing.', 'error');
    closeEditArticleModal();
  }
}

function closeEditArticleModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close')) return;
  const backdrop = document.getElementById('editArticleModalBackdrop');
  if (backdrop) {
    backdrop.classList.remove('show');
    backdrop.style.display = 'none';
  }
  document.body.style.overflow = '';
}

function handleTitleInput(title) {
  if (autoSlugEnabled) {
    const slug = title
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
    document.getElementById('artFieldSlug').value = slug;
  }
}

function toggleAutoSlug(checked) {
  autoSlugEnabled = checked;
  if (checked) {
    handleTitleInput(document.getElementById('artFieldTitle').value);
  }
}

function updateImagePreview(url) {
  const preview = document.getElementById('artImagePreview');
  if (url && preview) {
    preview.src = url;
  }
}

function setImagePreset(url) {
  document.getElementById('artFieldImage').value = url;
  updateImagePreview(url);
}

// Form Submit Handler via AJAX
async function submitArticleForm(e) {
  e.preventDefault();

  const form = document.getElementById('articleForm');
  const btn = document.getElementById('btnSubmitArticle');
  const btnText = document.getElementById('btnSubmitArticleText');
  const origText = btnText.textContent;

  btn.disabled = true;
  btnText.textContent = 'Saving...';

  try {
    const formData = new FormData(form);
    const res = await fetch(`${BASE_URL}/admin/article/save`, {
      method: 'POST',
      body: formData
    });

    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Article saved successfully!', 'success');
      closeEditArticleModal();
      setTimeout(() => window.location.reload(), 600);
    } else {
      showToast(data.error || 'Failed to save article.', 'error');
    }
  } catch (err) {
    showToast('Network error while saving article.', 'error');
  } finally {
    btn.disabled = false;
    btnText.textContent = origText;
  }
}

// ============================================================================
// AJAX TOGGLES: STATUS & FEATURED
// ============================================================================
async function toggleArticlePublishStatus(id, isPublished) {
  try {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('is_published', isPublished ? 1 : 0);

    const res = await fetch(`${BASE_URL}/admin/article/toggle-status`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message, 'success');
      // Update data attributes in DOM
      const row = document.getElementById(`articleRow-${id}`);
      if (row) row.setAttribute('data-published', isPublished ? '1' : '0');
      const card = document.getElementById(`articleCard-${id}`);
      if (card) card.setAttribute('data-published', isPublished ? '1' : '0');
    } else {
      showToast(data.error || 'Status update failed.', 'error');
    }
  } catch (err) {
    showToast('Network error during status update.', 'error');
  }
}

async function toggleFeaturedStar(id, isFeatured) {
  try {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('is_featured', isFeatured ? 1 : 0);

    const res = await fetch(`${BASE_URL}/admin/article/toggle-featured`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message, 'success');
      const starBtn = document.getElementById(`starBtn-${id}`);
      if (starBtn) {
        if (isFeatured) {
          starBtn.classList.add('active');
          starBtn.textContent = '★';
          starBtn.setAttribute('onclick', `toggleFeaturedStar(${id}, 0)`);
        } else {
          starBtn.classList.remove('active');
          starBtn.textContent = '☆';
          starBtn.setAttribute('onclick', `toggleFeaturedStar(${id}, 1)`);
        }
      }
      const row = document.getElementById(`articleRow-${id}`);
      if (row) row.setAttribute('data-featured', isFeatured ? '1' : '0');
      const card = document.getElementById(`articleCard-${id}`);
      if (card) card.setAttribute('data-featured', isFeatured ? '1' : '0');
    } else {
      showToast(data.error || 'Featured update failed.', 'error');
    }
  } catch (err) {
    showToast('Network error during featured flag update.', 'error');
  }
}

async function duplicateArticle(id) {
  if (!confirm('Are you sure you want to clone this technical article?')) return;

  try {
    const formData = new FormData();
    formData.append('id', id);

    const res = await fetch(`${BASE_URL}/admin/article/duplicate`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Article cloned successfully!', 'success');
      setTimeout(() => window.location.reload(), 600);
    } else {
      showToast(data.error || 'Failed to duplicate article.', 'error');
    }
  } catch (err) {
    showToast('Network error while duplicating article.', 'error');
  }
}

// ============================================================================
// MODAL 3: DELETE CONFIRMATION & EXECUTION
// ============================================================================
function confirmDeleteArticle(id, title = '') {
  deleteTargetId = id;
  if (!title) {
    const tableEl = document.getElementById(`articleTableTitle-${id}`);
    const cardEl = document.getElementById(`articleCardTitle-${id}`);
    title = (tableEl ? tableEl.innerText : (cardEl ? cardEl.innerText : '')).trim();
  }
  document.getElementById('deleteTargetTitle').textContent = title ? `"${title}"` : `#${id}`;

  const backdrop = document.getElementById('deleteArticleModalBackdrop');
  if (backdrop) {
    backdrop.style.display = 'flex';
    backdrop.classList.add('show');
  }
  document.body.style.overflow = 'hidden';

  const btnConfirm = document.getElementById('btnConfirmDeleteAction');
  if (btnConfirm) {
    btnConfirm.disabled = false;
    btnConfirm.textContent = 'Yes, Delete Record';
    btnConfirm.onclick = executeDeleteArticle;
  }
}

function closeDeleteArticleModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close')) return;
  const backdrop = document.getElementById('deleteArticleModalBackdrop');
  if (backdrop) {
    backdrop.classList.remove('show');
    backdrop.style.display = 'none';
  }
  document.body.style.overflow = '';
  deleteTargetId = 0;
}

async function executeDeleteArticle() {
  if (!deleteTargetId) return;

  const btn = document.getElementById('btnConfirmDeleteAction');
  btn.disabled = true;
  btn.textContent = 'Deleting...';

  try {
    const formData = new FormData();
    formData.append('id', deleteTargetId);

    const res = await fetch(`${BASE_URL}/admin/article/delete`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Article permanently removed.', 'success');
      closeDeleteArticleModal();

      const row = document.getElementById(`articleRow-${deleteTargetId}`);
      if (row) row.remove();
      const card = document.getElementById(`articleCard-${deleteTargetId}`);
      if (card) card.remove();

      // Decrement counter
      const kpi = document.getElementById('kpiTotalCount');
      if (kpi) {
        const cur = parseInt(kpi.textContent, 10);
        if (cur > 0) kpi.textContent = cur - 1;
      }
    } else {
      showToast(data.error || 'Failed to delete article.', 'error');
    }
  } catch (err) {
    showToast('Network error during deletion.', 'error');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Yes, Delete Record';
  }
}
</script>

<?php
include __DIR__ . '/layout/footer.php';
?>
