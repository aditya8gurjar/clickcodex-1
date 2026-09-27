<?php
/**
 * ClickCodex Technologies - Admin Solution Advisor & Architecture Finder Console
 * Executive enterprise management for digital architecture archetypes, interactive decision logic, and diagnostic client submissions.
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

$pageTitle = $pageTitle ?? 'Solution Advisor & Architecture Finder (6) | ClickCodex Studio Console';
$topbarTitle = 'Solution Advisor & Archetype Engine';
$activeNav = 'solution_advisor';

include __DIR__ . '/layout/header.php';
?>

<!-- ========================================================================
     SOLUTION ADVISOR DESIGN SYSTEM & SCOPED STYLES (OPEN SANS UNIFIED)
     ======================================================================== -->
<style>
:root {
  --adv-primary: #0056d6;
  --adv-primary-glow: rgba(0, 86, 214, 0.25);
  --adv-cyan: #00a2ff;
  --adv-emerald: #10b981;
  --adv-emerald-glow: rgba(16, 185, 129, 0.25);
  --adv-amber: #f59e0b;
  --adv-purple: #8b5cf6;
  --adv-indigo: #4f46e5;
  --adv-card-border: #e2e8f0;
}

/* Base Font & Container Standard */
.admin-content, .adv-admin-content, .adv-hero-banner, .crm-modal-card {
  font-family: 'Open Sans', var(--font-body), sans-serif;
}

.adv-admin-content {
  max-width: 1440px;
  margin: 0 auto;
  padding: 32px;
  width: 100%;
  box-sizing: border-box;
}

/* 1. Header Command Banner */
.adv-hero-banner {
  background: linear-gradient(135deg, #090d16 0%, #111a2e 50%, #0f172a 100%);
  border-radius: 18px;
  padding: 26px 30px;
  margin-bottom: 24px;
  color: #ffffff;
  position: relative;
  overflow: hidden;
  box-shadow: 0 10px 30px -5px rgba(9, 13, 22, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.08);
}
.adv-hero-banner::before {
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
.adv-hero-banner::after {
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
.adv-badge-pill {
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
.adv-pulse-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #10b981;
  box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
  animation: advPulse 2s infinite;
}
@keyframes advPulse {
  0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
  70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
  100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}
.adv-title-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
  position: relative;
  z-index: 2;
}
.adv-hero-title {
  font-family: var(--font-display, 'Open Sans', sans-serif);
  font-size: clamp(1.3rem, 2.5vw, 1.65rem);
  font-weight: 800;
  color: #ffffff;
  letter-spacing: -0.5px;
  margin: 0;
  line-height: 1.25;
}
.adv-hero-title span {
  background: linear-gradient(135deg, #38bdf8 0%, #818cf8 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.adv-hero-desc {
  color: #cbd5e1;
  font-size: clamp(0.82rem, 1.2vw, 0.88rem);
  line-height: 1.55;
  margin: 6px 0 0;
  max-width: 720px;
}
.adv-actions-wrap {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}
.adv-btn {
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
.adv-btn-primary {
  background: linear-gradient(135deg, #0056d6 0%, #00a2ff 100%);
  color: #ffffff;
  border: none;
  box-shadow: 0 4px 15px -2px rgba(0, 86, 214, 0.4);
}
.adv-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px -4px rgba(0, 86, 214, 0.6);
  color: #ffffff;
}
.adv-btn-glass {
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: #ffffff;
  backdrop-filter: blur(8px);
}
.adv-btn-glass:hover {
  background: rgba(255, 255, 255, 0.16);
  transform: translateY(-2px);
  color: #ffffff;
}

/* 2. Executive KPI Summary Cards */
.adv-kpi-row {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}
.adv-kpi-card {
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
.adv-kpi-card::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 4px;
  height: 100%;
  background: transparent;
  transition: background 0.25s ease;
}
.adv-kpi-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
  border-color: #cbd5e1;
}
.adv-kpi-card.blue:hover::after { background: var(--adv-primary); }
.adv-kpi-card.cyan:hover::after { background: var(--adv-cyan); }
.adv-kpi-card.amber:hover::after { background: var(--adv-amber); }
.adv-kpi-card.purple:hover::after { background: var(--adv-purple); }
.adv-kpi-card.green:hover::after { background: var(--adv-emerald); }

.adv-kpi-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
}
.adv-kpi-label {
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #64748b;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.adv-kpi-icon {
  width: 28px;
  height: 28px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.85rem;
  flex-shrink: 0;
}
.adv-kpi-val {
  font-family: var(--font-display, 'Open Sans', sans-serif);
  font-size: clamp(1.4rem, 2.2vw, 1.85rem);
  font-weight: 800;
  color: #0f172a;
  line-height: 1.1;
  margin-bottom: 6px;
}
.adv-kpi-sub {
  font-size: 0.72rem;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 5px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.adv-kpi-sub strong {
  font-weight: 700;
}

/* 3. Section Navigation Tabs (Blueprints vs Decision Engine vs Leads) */
.adv-tabs-bar {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
  border-bottom: 1px solid #e2e8f0;
  padding-bottom: 8px;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
.adv-tab-btn {
  padding: 8px 18px;
  border-radius: 10px;
  font-size: 0.85rem;
  font-weight: 700;
  color: #64748b;
  background: transparent;
  border: 1px solid transparent;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  white-space: nowrap;
}
.adv-tab-btn:hover {
  background: #f1f5f9;
  color: #0f172a;
}
.adv-tab-btn.active {
  background: #ffffff;
  color: #0056d6;
  border-color: #cbd5e1;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.05);
}
.adv-tab-badge {
  font-family: var(--font-mono, monospace);
  font-size: 0.7rem;
  padding: 1px 7px;
  border-radius: 9999px;
  background: #eff6ff;
  color: #0056d6;
}

/* 4. Toolbar: Search, Selectors, View Toggles */
.adv-toolbar {
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
.adv-search-wrap {
  position: relative;
  flex: 1;
  min-width: 260px;
  max-width: 440px;
}
.adv-search-icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  pointer-events: none;
}
.adv-search-input {
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
.adv-search-input:focus {
  outline: none;
  background: #ffffff;
  border-color: #0056d6;
  box-shadow: 0 0 0 3px rgba(0, 86, 214, 0.12);
}
.adv-search-kbd {
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
.adv-toolbar-controls {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}
.adv-select {
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
.adv-select:focus {
  outline: none;
  border-color: #0056d6;
  box-shadow: 0 0 0 3px rgba(0, 86, 214, 0.12);
}
.adv-view-switch {
  display: flex;
  background: #f1f5f9;
  border: 1px solid #cbd5e1;
  border-radius: 9px;
  padding: 3px;
  gap: 3px;
  flex-shrink: 0;
}
.adv-view-btn {
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
.adv-view-btn.active {
  background: #ffffff;
  color: #0056d6;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

/* ========================================================================
   VIEW A: EDITORIAL ARCHETYPE CARDS GRID (DEFAULT MASTER VIEW)
   ======================================================================== */
.adv-cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(min(100%, 360px), 1fr));
  gap: 20px;
}
.adv-card {
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
.adv-card:hover {
  transform: translateY(-4px);
  border-color: #cbd5e1;
  box-shadow: 0 12px 28px -5px rgba(15, 23, 42, 0.08);
}
.adv-card-header {
  padding: 20px 22px 16px;
  background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
  border-bottom: 1px solid #f1f5f9;
  position: relative;
}
.adv-card-meta-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
.adv-archetype-badge {
  font-family: var(--font-mono, monospace);
  font-size: 0.72rem;
  font-weight: 800;
  padding: 3px 10px;
  border-radius: 6px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.adv-archetype-badge.blue { background: rgba(0, 86, 214, 0.1); color: #0056d6; border: 1px solid rgba(0, 86, 214, 0.2); }
.adv-archetype-badge.indigo { background: rgba(79, 70, 229, 0.1); color: #4f46e5; border: 1px solid rgba(79, 70, 229, 0.2); }
.adv-archetype-badge.amber { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
.adv-archetype-badge.cyan { background: rgba(0, 162, 255, 0.1); color: #0284c7; border: 1px solid rgba(0, 162, 255, 0.2); }
.adv-archetype-badge.emerald { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
.adv-archetype-badge.purple { background: rgba(139, 92, 246, 0.1); color: #7c3aed; border: 1px solid rgba(139, 92, 246, 0.2); }

.adv-card-title {
  font-family: var(--font-display, 'Open Sans', sans-serif);
  font-size: 1.15rem;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.35;
  margin: 0 0 6px;
  cursor: pointer;
  transition: color 0.15s ease;
}
.adv-card-title:hover {
  color: #0056d6;
}
.adv-card-bestfor {
  font-size: 0.78rem;
  font-weight: 700;
  color: #0056d6;
  display: flex;
  align-items: center;
  gap: 6px;
}
.adv-card-body {
  padding: 18px 22px;
  display: flex;
  flex-direction: column;
  flex: 1;
}
.adv-card-desc {
  font-size: 0.84rem;
  color: #64748b;
  line-height: 1.55;
  margin-bottom: 16px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Metric Strip (Timeline, Investment, Scalability) */
.adv-card-metrics {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  background: #f8fafc;
  border: 1px solid #f1f5f9;
  border-radius: 10px;
  padding: 10px 12px;
  margin-bottom: 16px;
}
.adv-metric-box {
  display: flex;
  flex-direction: column;
}
.adv-metric-lbl {
  font-family: var(--font-mono, monospace);
  font-size: 0.65rem;
  font-weight: 700;
  text-transform: uppercase;
  color: #94a3b8;
  letter-spacing: 0.5px;
}
.adv-metric-val {
  font-size: 0.82rem;
  font-weight: 700;
  color: #0f172a;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Recommended Stack Pills */
.adv-stack-pills {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
  margin-bottom: 16px;
}
.adv-stack-pill {
  font-family: var(--font-mono, monospace);
  font-size: 0.68rem;
  background: #f1f5f9;
  color: #475569;
  padding: 2px 7px;
  border-radius: 5px;
  border: 1px solid #e2e8f0;
}

/* Card Footer Controls */
.adv-card-foot {
  padding: 12px 22px;
  background: #f8fafc;
  border-top: 1px solid #f1f5f9;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 8px;
  margin-top: auto;
}
.adv-toggle-switch {
  position: relative;
  display: inline-block;
  width: 38px;
  height: 22px;
}
.adv-toggle-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.adv-toggle-slider {
  position: absolute;
  cursor: pointer;
  inset: 0;
  background-color: #cbd5e1;
  transition: 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  border-radius: 34px;
}
.adv-toggle-slider:before {
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
.adv-toggle-switch input:checked + .adv-toggle-slider {
  background-color: #10b981;
}
.adv-toggle-switch input:checked + .adv-toggle-slider:before {
  transform: translateX(16px);
}
.adv-action-btn {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: #ffffff;
  border: 1px solid #e2e8f0;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: #475569;
  cursor: pointer;
  transition: all 0.15s ease;
  text-decoration: none;
}
.adv-action-btn:hover {
  background: #0056d6;
  border-color: #0056d6;
  color: #ffffff;
  transform: translateY(-1px);
}
.adv-action-btn.delete:hover {
  background: #dc2626;
  border-color: #dc2626;
  color: #ffffff;
}

/* ========================================================================
   VIEW B: MINIMAL ENTERPRISE TABLE VIEW (Clean & Non-Bloated)
   ======================================================================== */
.adv-table-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
}
.adv-table-wrap {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
.adv-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  font-size: 0.85rem;
}
.adv-table th {
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
.adv-table td {
  padding: 14px 18px;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
  color: #334155;
}
.adv-table tr:last-child td {
  border-bottom: none;
}
.adv-table tr:hover td {
  background: #fbfcfe;
}

/* ========================================================================
   TAB 2: DECISION ENGINE MATRIX ACCORDIONS
   ======================================================================== */
.adv-step-panel {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  margin-bottom: 20px;
  overflow: hidden;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
}
.adv-step-header {
  padding: 18px 24px;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
}
.adv-step-number {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: #0056d6;
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-mono, monospace);
  font-weight: 800;
  font-size: 0.85rem;
  flex-shrink: 0;
}
.adv-step-title {
  font-size: 1.05rem;
  font-weight: 800;
  color: #0f172a;
  margin: 0;
}
.adv-step-subtitle {
  font-size: 0.8rem;
  color: #64748b;
  margin-top: 2px;
}
.adv-options-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 14px;
  padding: 20px 24px;
}
.adv-option-card {
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 14px 16px;
  background: #ffffff;
  transition: all 0.2s ease;
  display: flex;
  gap: 12px;
}
.adv-option-card:hover {
  border-color: #0056d6;
  background: #f8fafc;
}
.adv-option-emoji {
  font-size: 1.4rem;
  line-height: 1;
  flex-shrink: 0;
}
.adv-option-name {
  font-weight: 700;
  font-size: 0.86rem;
  color: #0f172a;
  margin-bottom: 4px;
}
.adv-option-desc {
  font-size: 0.78rem;
  color: #64748b;
  line-height: 1.4;
}

/* ========================================================================
   MODAL OVERLAY SYSTEM (FIXED RESPONSIVE DIALOG POPUPS)
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
  padding: clamp(10px, 3vw, 24px) !important;
  box-sizing: border-box !important;
  overflow-y: auto !important;
  animation: advBackdropFade 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes advBackdropFade {
  from { opacity: 0; }
  to { opacity: 1; }
}

.crm-modal-card {
  background: #ffffff !important;
  border-radius: 20px !important;
  width: 100% !important;
  max-width: 860px !important;
  max-height: calc(100vh - 36px) !important;
  display: flex !important;
  flex-direction: column !important;
  box-shadow: 0 25px 60px -10px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.2) !important;
  position: relative !important;
  overflow: hidden !important;
  margin: auto !important;
  animation: advCardScale 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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

@keyframes advCardScale {
  from { opacity: 0; transform: scale(0.96) translateY(12px); }
  to { opacity: 1; transform: scale(1) translateY(0); }
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
}

/* Dossier Hero Header */
.adv-modal-header-hero {
  background: linear-gradient(135deg, #090d16 0%, #1e293b 100%);
  color: #ffffff;
  padding: clamp(18px, 3vw, 24px) clamp(18px, 3vw, 28px);
  border-radius: 20px 20px 0 0;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
}
.adv-modal-hero-glow {
  position: absolute;
  right: -50px;
  top: -50px;
  width: 220px;
  height: 220px;
  background: radial-gradient(circle, rgba(0, 162, 255, 0.22) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.adv-modal-header-hero .crm-modal-close {
  background: rgba(255, 255, 255, 0.12);
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.2);
}
.adv-modal-header-hero .crm-modal-close:hover {
  background: rgba(255, 255, 255, 0.25);
  color: #ffffff;
}

/* Responsive Form Grids */
.adv-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
  margin-bottom: 14px;
}
.adv-grid-3 {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 14px;
  margin-bottom: 14px;
}

/* ========================================================================
   CRITICAL RESPONSIVE RULES: MOBILE VIEW IS ALWAYS CARD VIEW
   ======================================================================== */
@media (max-width: 1280px) {
  .adv-kpi-row {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 1024px) {
  .adv-admin-content {
    padding: 22px 18px;
  }
  .adv-toolbar {
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
  }
  .adv-search-wrap {
    max-width: 100%;
    min-width: 0;
    width: 100%;
  }
  .adv-toolbar-controls {
    width: 100%;
    justify-content: flex-start;
  }
  .adv-select {
    flex: 1 1 calc(50% - 10px);
    min-width: 140px;
  }
}

@media (max-width: 860px) {
  .adv-kpi-row {
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
  }
}

/* STRICT RULE: On Mobile View (<= 768px), Table View is ALWAYS Hidden and Card View is Active */
@media (max-width: 768px) {
  .adv-admin-content {
    padding: 16px 12px;
  }
  .adv-hero-banner {
    padding: 20px 18px;
    border-radius: 14px;
  }
  .adv-title-row {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }
  .adv-actions-wrap {
    width: 100%;
  }
  .adv-actions-wrap .adv-btn {
    flex: 1 1 auto;
    justify-content: center;
    padding: 9px 12px;
  }
  .adv-actions-wrap .adv-btn-primary {
    flex: 2 1 100%;
  }

  /* Force Always Card View on Mobile */
  #advisorTableView {
    display: none !important;
  }
  #advisorCardsView {
    display: grid !important;
    grid-template-columns: 1fr;
    gap: 16px;
  }
  .adv-view-switch {
    display: none !important; /* Hide view switcher on mobile */
  }

  .adv-grid-2, .adv-grid-3 {
    grid-template-columns: 1fr;
    gap: 12px;
  }
  .crm-modal-card {
    border-radius: 16px !important;
    max-height: calc(100vh - 20px) !important;
  }
}

@media (max-width: 640px) {
  .adv-select {
    flex: 1 1 100%;
    width: 100%;
  }
  .crm-modal-footer {
    justify-content: stretch;
  }
  .crm-modal-footer .adv-btn {
    flex: 1 1 100%;
    justify-content: center;
  }
}

@media (max-width: 480px) {
  .adv-admin-content {
    padding: 12px 8px;
  }
  .adv-kpi-row {
    grid-template-columns: 1fr 1fr;
    gap: 8px;
  }
  .adv-kpi-card {
    padding: 12px 14px;
  }
  .adv-kpi-val {
    font-size: 1.45rem;
  }
  .adv-hero-banner {
    padding: 16px 14px;
  }
  .adv-badge-pill {
    font-size: 0.65rem;
    padding: 3px 8px;
  }
}
</style>

<!-- ========================================================================
     MAIN VIEWPORT CONTAINER
     ======================================================================== -->
<div class="admin-content adv-admin-content">

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
  <div class="adv-hero-banner">
    <div class="adv-title-row">
      <div>
        <div class="adv-badge-pill">
          <span class="adv-pulse-dot"></span>
          <span>SOLUTION ADVISOR • ARCHITECTURE MATRIX</span>
        </div>
        <h1 class="adv-hero-title">Solution Advisor & <span>Digital Blueprints</span></h1>
        <p class="adv-hero-desc">
          Automated diagnostic engine matching commercial objectives, business maturity, and feature requirements with optimal engineering archetypes.
        </p>
      </div>

      <!-- Action Buttons -->
      <div class="adv-actions-wrap">
        <a href="<?= BASE_URL ?>/service-finder" target="_blank" class="adv-btn adv-btn-glass" title="Test Public Solution Advisor Quiz">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
          <span>Run 60s Quiz ↗</span>
        </a>

        <a href="<?= BASE_URL ?>/admin/advisor/export" class="adv-btn adv-btn-glass" title="Export Archetypes Catalog as CSV">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
          <span>Export CSV</span>
        </a>

        <button type="button" class="adv-btn adv-btn-primary" onclick="openCreateArchetypeModal()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          <span>New Solution Archetype</span>
        </button>
      </div>
    </div>
  </div>

  <!-- 2. INTERACTIVE EXECUTIVE KPI SUMMARY CARDS -->
  <div class="adv-kpi-row">
    <!-- KPI 1: Active Archetypes -->
    <div class="adv-kpi-card blue" onclick="filterByStatus('all')">
      <div class="adv-kpi-header">
        <span class="adv-kpi-label">SOLUTION ARCHETYPES</span>
        <div class="adv-kpi-icon" style="background: rgba(0, 86, 214, 0.1); color: var(--adv-primary);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        </div>
      </div>
      <div class="adv-kpi-val" id="kpiTotalArchetypes"><?= (int)($advisorStats['total_archetypes'] ?? count($archetypes)) ?></div>
      <div class="adv-kpi-sub">
        <strong>Digital Blueprints</strong> • Master Catalog
      </div>
    </div>

    <!-- KPI 2: Active & Recommended -->
    <div class="adv-kpi-card green" onclick="filterByStatus('active')">
      <div class="adv-kpi-header">
        <span class="adv-kpi-label">ACTIVE BLUEPRINTS</span>
        <div class="adv-kpi-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--adv-emerald);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
      </div>
      <div class="adv-kpi-val" style="color: var(--adv-emerald);"><?= (int)($advisorStats['active_archetypes'] ?? 6) ?></div>
      <div class="adv-kpi-sub">
        <strong>Live in Quiz</strong> • /service-finder
      </div>
    </div>

    <!-- KPI 3: Diagnostic Decision Steps -->
    <div class="adv-kpi-card purple" onclick="switchTab('matrix')">
      <div class="adv-kpi-header">
        <span class="adv-kpi-label">DECISION STEPS</span>
        <div class="adv-kpi-icon" style="background: rgba(139, 92, 246, 0.1); color: var(--adv-purple);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
        </div>
      </div>
      <div class="adv-kpi-val" style="color: var(--adv-purple);"><?= (int)($advisorStats['total_questions'] ?? 4) ?></div>
      <div class="adv-kpi-sub">
        <strong><?= (int)($advisorStats['total_options'] ?? 22) ?> Matrix Factors</strong> • Goals & Stacks
      </div>
    </div>

    <!-- KPI 4: Fastest Delivery Velocity -->
    <div class="adv-kpi-card amber">
      <div class="adv-kpi-header">
        <span class="adv-kpi-label">RAPID VELOCITY</span>
        <div class="adv-kpi-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--adv-amber);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
        </div>
      </div>
      <div class="adv-kpi-val" style="color: var(--adv-amber); font-size: 1.55rem;"><?= htmlspecialchars($advisorStats['fastest_delivery'] ?? '1 – 2 Wks') ?></div>
      <div class="adv-kpi-sub">
        <strong>Sprint Cycles</strong> • High-Speed MVP
      </div>
    </div>

    <!-- KPI 5: Diagnostic Leads -->
    <div class="adv-kpi-card cyan" onclick="switchTab('leads')">
      <div class="adv-kpi-header">
        <span class="adv-kpi-label">DIAGNOSTIC INQUIRIES</span>
        <div class="adv-kpi-icon" style="background: rgba(0, 162, 255, 0.1); color: var(--adv-cyan);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
        </div>
      </div>
      <div class="adv-kpi-val" style="color: var(--adv-cyan);"><?= (int)($advisorStats['total_submissions'] ?? count($submissions)) ?></div>
      <div class="adv-kpi-sub">
        <strong>Quiz Leads</strong> • Scoped Inquiries
      </div>
    </div>
  </div>

  <!-- 3. SECTION NAVIGATION TABS -->
  <div class="adv-tabs-bar">
    <button type="button" class="adv-tab-btn active" id="tabBtnArchetypes" onclick="switchTab('archetypes')">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
      <span>Solution Archetypes</span>
      <span class="adv-tab-badge"><?= count($archetypes) ?></span>
    </button>

    <button type="button" class="adv-tab-btn" id="tabBtnMatrix" onclick="switchTab('matrix')">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
      <span>Interactive Decision Engine (4 Steps)</span>
      <span class="adv-tab-badge">22 Options</span>
    </button>

    <button type="button" class="adv-tab-btn" id="tabBtnLeads" onclick="switchTab('leads')">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
      <span>Diagnostic Quiz Inquiries</span>
      <span class="adv-tab-badge"><?= count($submissions) ?></span>
    </button>
  </div>

  <!-- ========================================================================
       SECTION 1: SOLUTION ARCHETYPES (DEFAULT CARDS VIEW FIRST)
       ======================================================================== -->
  <div id="sectionArchetypes">
    
    <!-- COMMAND TOOLBAR -->
    <div class="adv-toolbar">
      <!-- Search Input -->
      <div class="adv-search-wrap">
        <svg class="adv-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" id="archetypeSearchInput" class="adv-search-input" placeholder="Search solution name, best for, tech stack, keywords..." oninput="handleArchetypeSearch(this.value)" />
        <kbd class="adv-search-kbd">/</kbd>
      </div>

      <!-- Filters & Dual View Switcher -->
      <div class="adv-toolbar-controls">
        <!-- Status Filter -->
        <select id="advStatusSelect" class="adv-select" onchange="handleStatusFilter(this.value)">
          <option value="all">All Statuses</option>
          <option value="active">● Active in Quiz</option>
          <option value="inactive">○ Inactive / Hidden</option>
        </select>

        <!-- View Switcher (DEFAULT: Cards Active, Table Minimal) -->
        <div class="adv-view-switch" id="advViewSwitchWrap" title="Switch between Card View and Minimal Table View">
          <button type="button" class="adv-view-btn active" id="viewBtnCards" onclick="switchView('cards')">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span>Cards</span>
          </button>
          <button type="button" class="adv-view-btn" id="viewBtnTable" onclick="switchView('table')">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
            <span>Table</span>
          </button>
        </div>
      </div>
    </div>

    <!-- 1. VIEW A: EDITORIAL ARCHETYPE CARDS (DEFAULT VIEW FIRST!) -->
    <div id="advisorCardsView" class="adv-cards-grid">
      <?php foreach ($archetypes as $arch): ?>
        <?php
          $isActive = (int)($arch['is_active'] ?? 1) === 1;
          $badgeText = $arch['badge_text'] ?: 'Archetype 0' . $arch['id'];
          $badgeClass = match((int)$arch['id']) {
            1 => 'blue',
            2 => 'indigo',
            3 => 'amber',
            4 => 'cyan',
            5 => 'emerald',
            default => 'purple'
          };
          $iconEmoji = match((int)$arch['id']) {
            1 => '🚀',
            2 => '🏢',
            3 => '🛍️',
            4 => '⚡',
            5 => '📱',
            default => '🧠'
          };
        ?>
        <div id="archetypeCard-<?= (int)$arch['id'] ?>"
             class="adv-card archetype-item-element"
             data-id="<?= (int)$arch['id'] ?>"
             data-active="<?= $isActive ? '1' : '0' ?>"
             data-name="<?= htmlspecialchars(strtolower($arch['name'])) ?>"
             data-key="<?= htmlspecialchars(strtolower($arch['archetype_key'])) ?>"
             data-bestfor="<?= htmlspecialchars(strtolower($arch['best_for'])) ?>"
             data-desc="<?= htmlspecialchars(strtolower($arch['description'])) ?>"
             data-stack="<?= htmlspecialchars(strtolower(implode(' ', $arch['recommended_stack_arr'] ?? []))) ?>">
          
          <!-- Card Header -->
          <div class="adv-card-header">
            <div class="adv-card-meta-top">
              <span class="adv-archetype-badge <?= $badgeClass ?>">
                <?= htmlspecialchars($badgeText) ?>
              </span>
              <span style="font-size: 1.35rem; line-height: 1;"><?= $iconEmoji ?></span>
            </div>

            <h3 class="adv-card-title" onclick="viewArchetypeDossier(<?= (int)$arch['id'] ?>)">
              <?= htmlspecialchars($arch['name']) ?>
            </h3>

            <div class="adv-card-bestfor">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
              <span><?= htmlspecialchars($arch['best_for']) ?></span>
            </div>
          </div>

          <!-- Card Body -->
          <div class="adv-card-body">
            <p class="adv-card-desc">
              <?= htmlspecialchars($arch['description']) ?>
            </p>

            <!-- Metrics Strip -->
            <div class="adv-card-metrics">
              <div class="adv-metric-box">
                <span class="adv-metric-lbl">TIME TO MARKET</span>
                <span class="adv-metric-val"><?= htmlspecialchars($arch['time_to_market']) ?></span>
              </div>
              <div class="adv-metric-box">
                <span class="adv-metric-lbl">INVESTMENT TIER</span>
                <span class="adv-metric-val" style="color: #0056d6;"><?= htmlspecialchars($arch['investment_tier']) ?></span>
              </div>
            </div>

            <!-- Recommended Stack Pills -->
            <div class="adv-stack-pills">
              <?php foreach (array_slice($arch['recommended_stack_arr'] ?? [], 0, 4) as $stk): ?>
                <span class="adv-stack-pill"><?= htmlspecialchars($stk) ?></span>
              <?php endforeach; ?>
              <?php if (count($arch['recommended_stack_arr'] ?? []) > 4): ?>
                <span class="adv-stack-pill">+<?= count($arch['recommended_stack_arr']) - 4 ?> more</span>
              <?php endif; ?>
            </div>
          </div>

          <!-- Card Footer -->
          <div class="adv-card-foot">
            <div style="display: flex; align-items: center; gap: 8px;">
              <label class="adv-toggle-switch" title="Toggle Active / Inactive Status in Quiz">
                <input type="checkbox" id="cardActiveToggle-<?= (int)$arch['id'] ?>" <?= $isActive ? 'checked' : '' ?> onchange="toggleArchetypeStatus(<?= (int)$arch['id'] ?>, this.checked)" />
                <span class="adv-toggle-slider"></span>
              </label>
              <span style="font-size: 0.72rem; font-weight: 700; color: <?= $isActive ? '#10b981' : '#94a3b8' ?>;" id="cardStatusLabel-<?= (int)$arch['id'] ?>">
                <?= $isActive ? 'Active' : 'Inactive' ?>
              </span>
            </div>

            <div style="display: flex; gap: 6px;">
              <button type="button" class="adv-action-btn" onclick="viewArchetypeDossier(<?= (int)$arch['id'] ?>)" title="View Full Blueprint Dossier">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              </button>
              <button type="button" class="adv-action-btn" onclick="editArchetype(<?= (int)$arch['id'] ?>)" title="Edit Solution Archetype">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              </button>
              <button type="button" class="adv-action-btn" onclick="duplicateArchetype(<?= (int)$arch['id'] ?>)" title="Clone Archetype">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
              </button>
              <button type="button" class="adv-action-btn delete" onclick="confirmDeleteArchetype(<?= (int)$arch['id'] ?>, '<?= htmlspecialchars(addslashes($arch['name'])) ?>')" title="Delete Archetype">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
              </button>
            </div>
          </div>

        </div>
      <?php endforeach; ?>
    </div>

    <!-- 2. VIEW B: MINIMAL TABLE VIEW (Clean, 5 Essential Columns Only) -->
    <div id="advisorTableView" class="adv-table-card" style="display: none;">
      <div class="adv-table-wrap">
        <table class="adv-table">
          <thead>
            <tr>
              <th style="min-width: 220px;">Solution Archetype</th>
              <th>Best For & Target</th>
              <th>Velocity & Investment</th>
              <th style="text-align: center; width: 90px;">Status</th>
              <th style="text-align: right; width: 140px;">Actions</th>
            </tr>
          </thead>
          <tbody id="archetypesTableBody">
            <?php foreach ($archetypes as $arch): ?>
              <?php
                $isActive = (int)($arch['is_active'] ?? 1) === 1;
                $badgeText = $arch['badge_text'] ?: 'Archetype 0' . $arch['id'];
              ?>
              <tr id="archetypeRow-<?= (int)$arch['id'] ?>"
                  class="archetype-item-element"
                  data-id="<?= (int)$arch['id'] ?>"
                  data-active="<?= $isActive ? '1' : '0' ?>"
                  data-name="<?= htmlspecialchars(strtolower($arch['name'])) ?>"
                  data-key="<?= htmlspecialchars(strtolower($arch['archetype_key'])) ?>"
                  data-bestfor="<?= htmlspecialchars(strtolower($arch['best_for'])) ?>"
                  data-desc="<?= htmlspecialchars(strtolower($arch['description'])) ?>"
                  data-stack="<?= htmlspecialchars(strtolower(implode(' ', $arch['recommended_stack_arr'] ?? []))) ?>">
                
                <!-- Archetype Name & Key -->
                <td>
                  <a href="javascript:void(0)" onclick="viewArchetypeDossier(<?= (int)$arch['id'] ?>)" style="font-weight: 700; color: #0f172a; text-decoration: none; display: block; font-size: 0.9rem;">
                    <?= htmlspecialchars($arch['name']) ?>
                  </a>
                  <div style="display: flex; align-items: center; gap: 6px; margin-top: 3px;">
                    <span style="font-family: var(--font-mono, monospace); font-size: 0.7rem; color: #64748b; background: #f1f5f9; padding: 1px 6px; border-radius: 4px;">
                      <?= htmlspecialchars($arch['archetype_key']) ?>
                    </span>
                    <span style="font-size: 0.7rem; font-weight: 700; color: #0056d6;">
                      <?= htmlspecialchars($badgeText) ?>
                    </span>
                  </div>
                </td>

                <!-- Best For & Stack -->
                <td>
                  <div style="font-weight: 700; color: #334155; font-size: 0.82rem; margin-bottom: 2px;">
                    <?= htmlspecialchars($arch['best_for']) ?>
                  </div>
                  <div style="font-size: 0.72rem; color: #64748b; font-family: var(--font-mono, monospace);">
                    <?= htmlspecialchars(implode(' • ', array_slice($arch['recommended_stack_arr'] ?? [], 0, 3))) ?>
                  </div>
                </td>

                <!-- Velocity & Investment -->
                <td>
                  <div style="font-weight: 700; color: #0056d6; font-size: 0.82rem;">
                    <?= htmlspecialchars($arch['investment_tier']) ?>
                  </div>
                  <div style="font-size: 0.74rem; color: #64748b;">
                    <?= htmlspecialchars($arch['time_to_market']) ?>
                  </div>
                </td>

                <!-- Status Toggle -->
                <td style="text-align: center;">
                  <label class="adv-toggle-switch" title="Toggle Active / Inactive Status">
                    <input type="checkbox" id="tableActiveToggle-<?= (int)$arch['id'] ?>" <?= $isActive ? 'checked' : '' ?> onchange="toggleArchetypeStatus(<?= (int)$arch['id'] ?>, this.checked)" />
                    <span class="adv-toggle-slider"></span>
                  </label>
                </td>

                <!-- Quick Actions -->
                <td style="text-align: right;">
                  <div style="display: flex; justify-content: flex-end; gap: 6px;">
                    <button type="button" class="adv-action-btn" onclick="viewArchetypeDossier(<?= (int)$arch['id'] ?>)" title="View Blueprint Dossier">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                    <button type="button" class="adv-action-btn" onclick="editArchetype(<?= (int)$arch['id'] ?>)" title="Edit Solution Archetype">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>
                    <button type="button" class="adv-action-btn" onclick="duplicateArchetype(<?= (int)$arch['id'] ?>)" title="Clone Archetype">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    </button>
                    <button type="button" class="adv-action-btn delete" onclick="confirmDeleteArchetype(<?= (int)$arch['id'] ?>, '<?= htmlspecialchars(addslashes($arch['name'])) ?>')" title="Delete Archetype">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div><!-- /sectionArchetypes -->


  <!-- ========================================================================
       SECTION 2: INTERACTIVE DECISION MATRIX (4 STEPS & 22 OPTIONS)
       ======================================================================== -->
  <div id="sectionMatrix" style="display: none;">
    <?php foreach ($questions as $q): ?>
      <div class="adv-step-panel">
        <div class="adv-step-header">
          <div style="display: flex; align-items: center; gap: 14px;">
            <div class="adv-step-number"><?= (int)$q['step_number'] ?></div>
            <div>
              <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-family: var(--font-mono, monospace); font-size: 0.72rem; font-weight: 700; color: #0056d6; text-transform: uppercase;">
                  STEP <?= (int)$q['step_number'] ?> • <?= htmlspecialchars(strtoupper((string)$q['category_key'])) ?>
                </span>
                <?php if ((int)$q['is_multi_select'] === 1): ?>
                  <span style="font-size: 0.68rem; font-weight: 700; background: rgba(0, 162, 255, 0.1); color: #0284c7; padding: 1px 6px; border-radius: 4px;">
                    Multi-Select Enabled
                  </span>
                <?php else: ?>
                  <span style="font-size: 0.68rem; font-weight: 700; background: rgba(16, 185, 129, 0.1); color: #059669; padding: 1px 6px; border-radius: 4px;">
                    Single Choice
                  </span>
                <?php endif; ?>
              </div>
              <h3 class="adv-step-title"><?= htmlspecialchars($q['question_text']) ?></h3>
              <?php if (!empty($q['question_subtitle'])): ?>
                <div class="adv-step-subtitle"><?= htmlspecialchars($q['question_subtitle']) ?></div>
              <?php endif; ?>
            </div>
          </div>

          <span class="adv-tab-badge" style="background: #f1f5f9; color: #475569; font-size: 0.75rem;">
            <?= count($q['options'] ?? []) ?> Configured Options
          </span>
        </div>

        <!-- Options Grid -->
        <div class="adv-options-grid">
          <?php foreach ($q['options'] as $opt): ?>
            <div class="adv-option-card">
              <span class="adv-option-emoji"><?= $opt['icon_emoji'] ?: '🔹' ?></span>
              <div>
                <div class="adv-option-name"><?= htmlspecialchars($opt['title']) ?></div>
                <div class="adv-option-desc"><?= htmlspecialchars($opt['description']) ?></div>
                <div style="font-family: var(--font-mono, monospace); font-size: 0.68rem; color: #94a3b8; margin-top: 6px;">
                  KEY: <code><?= htmlspecialchars($opt['option_key']) ?></code>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div><!-- /sectionMatrix -->


  <!-- ========================================================================
       SECTION 3: DIAGNOSTIC QUIZ INQUIRIES & SUBMISSIONS
       ======================================================================== -->
  <div id="sectionLeads" style="display: none;">
    <div class="adv-table-card">
      <div class="adv-table-wrap">
        <table class="adv-table">
          <thead>
            <tr>
              <th>Client / Inquirer</th>
              <th>Commercial Goal & Stage</th>
              <th>Matched Architecture</th>
              <th>Target Horizon</th>
              <th>Submitted Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($submissions)): ?>
              <tr>
                <td colspan="5" style="text-align: center; padding: 48px; color: #94a3b8;">
                  <div style="font-size: 1.5rem; margin-bottom: 8px;">🧭</div>
                  <div style="font-weight: 700; color: #475569;">No Quiz Submissions Yet</div>
                  <div style="font-size: 0.8rem; margin-top: 4px;">When potential clients complete the 60-second quiz on <code>/service-finder</code>, their diagnostic parameters will populate here.</div>
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($submissions as $sub): ?>
                <tr>
                  <td>
                    <div style="font-weight: 700; color: #0f172a;"><?= htmlspecialchars($sub['client_name'] ?: 'Anonymous Inquirer') ?></div>
                    <div style="font-size: 0.74rem; color: #64748b;"><?= htmlspecialchars($sub['client_email'] ?: $sub['client_phone'] ?: 'No Contact Provided') ?></div>
                  </td>
                  <td>
                    <div style="font-weight: 700; color: #0056d6; font-size: 0.8rem; text-transform: uppercase;">Goal: <?= htmlspecialchars((string)($sub['goal_selection'] ?? 'Custom')) ?></div>
                    <div style="font-size: 0.74rem; color: #64748b;">Stage: <?= htmlspecialchars((string)($sub['stage_selection'] ?? 'Startup MVP')) ?></div>
                  </td>
                  <td>
                    <span style="font-size: 0.74rem; font-weight: 700; background: rgba(0, 86, 214, 0.1); color: #0056d6; padding: 2px 8px; border-radius: 4px;">
                      <?= htmlspecialchars($sub['recommended_archetype_name'] ?: 'Architecture Blueprint') ?>
                    </span>
                  </td>
                  <td>
                    <span style="font-family: var(--font-mono, monospace); font-size: 0.76rem; color: #475569;">
                      <?= htmlspecialchars((string)($sub['timeline_selection'] ?? 'Standard Sprint')) ?>
                    </span>
                  </td>
                  <td style="font-family: var(--font-mono, monospace); font-size: 0.76rem; color: #64748b;">
                    <?= date('M d, Y H:i', strtotime($sub['created_at'] ?? 'now')) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div><!-- /sectionLeads -->

</div><!-- /admin-content -->


<!-- ========================================================================
     MODAL 1: VIEW BLUEPRINT DOSSIER MODAL
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="viewArchetypeModalBackdrop" style="display: none;" onclick="closeViewArchetypeModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 820px;" onclick="event.stopPropagation()">
    
    <!-- Modal Header Hero -->
    <div class="adv-modal-header-hero">
      <div class="adv-modal-hero-glow"></div>
      <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; position: relative; z-index: 2;">
        <div style="flex: 1;">
          <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px; flex-wrap: wrap;">
            <span id="viewDossierBadge" style="font-size: 0.72rem; font-family: var(--font-mono, monospace); font-weight: 800; background: rgba(0, 162, 255, 0.2); color: #38bdf8; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">
              ARCHETYPE
            </span>
            <span id="viewDossierActiveBadge" style="font-size: 0.72rem; font-weight: 800; background: rgba(16, 185, 129, 0.25); color: #34d399; padding: 2px 8px; border-radius: 4px;">
              ACTIVE BLUEPRINT
            </span>
          </div>

          <h2 id="viewDossierName" style="font-size: 1.45rem; font-weight: 800; margin: 0; color: #ffffff; line-height: 1.3;">
            Solution Archetype Title
          </h2>

          <div style="font-size: 0.84rem; color: #cbd5e1; margin-top: 6px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
            <span>Best For: <strong id="viewDossierBestFor" style="color: #ffffff;">Target Category</strong></span>
            <span>•</span>
            <span id="viewDossierTimeline" style="font-family: var(--font-mono, monospace);">2 – 4 Weeks</span>
          </div>
        </div>

        <button type="button" class="crm-modal-close" onclick="closeViewArchetypeModal()" aria-label="Close dialog">✕</button>
      </div>
    </div>

    <!-- Modal Body -->
    <div class="crm-modal-body" style="padding: 24px;">
      
      <!-- Key Architecture Metrics Grid -->
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 10px; margin-bottom: 24px;">
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px;">
          <div style="font-family: var(--font-mono, monospace); font-size: 0.65rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">INVESTMENT TIER</div>
          <div id="viewDossierInvestment" style="font-size: 0.95rem; font-weight: 800; color: #0056d6; margin-top: 3px;">Starter / MVP</div>
        </div>
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px;">
          <div style="font-family: var(--font-mono, monospace); font-size: 0.65rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">SCALABILITY CEILING</div>
          <div id="viewDossierScalability" style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-top: 3px;">High (Edge)</div>
        </div>
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px;">
          <div style="font-family: var(--font-mono, monospace); font-size: 0.65rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">TYPICAL TEAM POD</div>
          <div id="viewDossierTeamPod" style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-top: 3px;">2 Engineers</div>
        </div>
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px;">
          <div style="font-family: var(--font-mono, monospace); font-size: 0.65rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">MAINTENANCE OVERHEAD</div>
          <div id="viewDossierMaintenance" style="font-size: 0.95rem; font-weight: 800; color: #10b981; margin-top: 3px;">Very Low</div>
        </div>
      </div>

      <!-- Description / Executive Angle -->
      <div style="margin-bottom: 24px;">
        <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin-bottom: 8px;">
          Executive Architecture Synopsis
        </div>
        <p id="viewDossierDesc" style="font-size: 0.92rem; color: #0f172a; line-height: 1.6; background: #f8fafc; padding: 16px 18px; border-radius: 10px; border-left: 4px solid #0056d6; border-top: 1px solid #f1f5f9; border-right: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; margin: 0;">
          Synopsis text...
        </p>
      </div>

      <!-- Recommended Technology Stack -->
      <div style="margin-bottom: 24px;">
        <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin-bottom: 10px;">
          Recommended Enterprise Technology Stack
        </div>
        <div id="viewDossierStack" style="display: flex; gap: 8px; flex-wrap: wrap;">
          <!-- Injected dynamically -->
        </div>
      </div>

      <!-- Verified Deliverable Checklist -->
      <div>
        <div style="font-size: 0.76rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin-bottom: 10px;">
          Verified Production Deliverables & SLA Guarantees
        </div>
        <div id="viewDossierChecklists" style="display: flex; flex-direction: column; gap: 8px;">
          <!-- Injected dynamically -->
        </div>
      </div>

    </div>

    <!-- Modal Footer -->
    <div class="crm-modal-footer">
      <a href="<?= BASE_URL ?>/service-finder" target="_blank" class="adv-btn adv-btn-glass" style="background: #f8fafc; color: #0056d6; border: 1px solid #cbd5e1; margin-right: auto;">
        <span>Test on Public Quiz ↗</span>
      </a>

      <button type="button" class="adv-btn adv-btn-glass" onclick="closeViewArchetypeModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
        Close
      </button>
      <button type="button" class="adv-btn adv-btn-primary" id="viewArchetypeEditBtn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        <span>Edit Blueprint</span>
      </button>
    </div>

  </div>
</div>


<!-- ========================================================================
     MODAL 2: CREATE / EDIT SOLUTION ARCHETYPE MODAL
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="editArchetypeModalBackdrop" style="display: none;" onclick="closeEditArchetypeModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 860px;" onclick="event.stopPropagation()">
    
    <!-- Modal Header -->
    <div class="crm-modal-header">
      <div>
        <h3 class="crm-modal-title" id="editArchetypeModalTitle">New Solution Archetype</h3>
        <p class="crm-modal-subtitle">Define digital architecture blueprints recommended by the interactive advisor.</p>
      </div>
      <button type="button" class="crm-modal-close" onclick="closeEditArchetypeModal()" aria-label="Close dialog">✕</button>
    </div>

    <!-- Modal Form -->
    <form id="archetypeForm" class="crm-modal-form" onsubmit="submitArchetypeForm(event)">
      <input type="hidden" id="archFieldId" name="id" value="0" />

      <div class="crm-modal-body">

        <!-- 1. Blueprint Identity -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 0 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          1. Archetype Identity & Scope
        </div>

        <div class="adv-grid-2">
          <div>
            <label for="archFieldName" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Solution Archetype Name *</label>
            <input type="text" id="archFieldName" name="name" class="adv-search-input" placeholder="e.g. High-Converting Landing Pages" required />
          </div>

          <div>
            <label for="archFieldKey" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Archetype Unique Key *</label>
            <input type="text" id="archFieldKey" name="archetype_key" class="adv-search-input" style="font-family: var(--font-mono, monospace);" placeholder="e.g. landing_page" required />
          </div>
        </div>

        <div class="adv-grid-2">
          <div>
            <label for="archFieldBadge" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Badge Label Text</label>
            <input type="text" id="archFieldBadge" name="badge_text" class="adv-search-input" placeholder="e.g. Archetype 01" value="Archetype 01" />
          </div>

          <div>
            <label for="archFieldBestFor" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Best For / Primary Fit *</label>
            <input type="text" id="archFieldBestFor" name="best_for" class="adv-search-input" placeholder="e.g. Ad Campaigns & Startups" required />
          </div>
        </div>

        <div style="margin-bottom: 18px;">
          <label for="archFieldDesc" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Executive Description (2-3 sentences) *</label>
          <textarea id="archFieldDesc" name="description" rows="3" class="adv-search-input" style="height: auto; padding: 12px; resize: vertical;" placeholder="Laser-focused single-page experience built specifically for conversion optimization..." required></textarea>
        </div>

        <!-- 2. Technology Stack & Deliverables -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 24px 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          2. Recommended Stack & SLA Deliverables
        </div>

        <div style="margin-bottom: 14px;">
          <label for="archFieldStack" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Recommended Technology Stack (Comma-Separated) *</label>
          <input type="text" id="archFieldStack" name="recommended_stack_text" class="adv-search-input" placeholder="Next.js, Tailwind CSS, GSAP, Cloudflare" required />
        </div>

        <div style="margin-bottom: 18px;">
          <label for="archFieldChecklists" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Verified Checklist Deliverables (One per line) *</label>
          <textarea id="archFieldChecklists" name="checklists_text" rows="4" class="adv-search-input" style="height: auto; padding: 12px; font-family: var(--font-mono, monospace); font-size: 0.84rem; resize: vertical;" placeholder="Sub-second load times & 99+ PageSpeed score&#10;Interactive 3D micro-animations & storytelling&#10;Direct CRM & WhatsApp lead routing" required></textarea>
        </div>

        <!-- 3. Metrics, Velocity & Investment -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono, monospace); text-transform: uppercase; letter-spacing: 1px; color: #0056d6; font-weight: 800; margin: 24px 0 14px; border-bottom: 2px solid #eff6ff; padding-bottom: 6px;">
          3. Velocity, Investment Tier & Scale
        </div>

        <div class="adv-grid-3">
          <div>
            <label for="archFieldTime" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Time to Market *</label>
            <input type="text" id="archFieldTime" name="time_to_market" class="adv-search-input" placeholder="e.g. 1 – 2 Weeks" value="2 – 4 Weeks" required />
          </div>

          <div>
            <label for="archFieldInvestment" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Investment Tier *</label>
            <input type="text" id="archFieldInvestment" name="investment_tier" class="adv-search-input" placeholder="e.g. Starter / MVP (₹1.49L)" value="Growth Tier" required />
          </div>

          <div>
            <label for="archFieldScalability" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Scalability Ceiling</label>
            <input type="text" id="archFieldScalability" name="scalability_ceiling" class="adv-search-input" placeholder="e.g. High (Static Edge)" value="High" />
          </div>
        </div>

        <div class="adv-grid-3">
          <div>
            <label for="archFieldTeamPod" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Typical Team Pod</label>
            <input type="text" id="archFieldTeamPod" name="typical_team_pod" class="adv-search-input" placeholder="e.g. 2 Engineers" value="2 Engineers" />
          </div>

          <div>
            <label for="archFieldSeo" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">SEO Dominance</label>
            <input type="text" id="archFieldSeo" name="seo_dominance" class="adv-search-input" placeholder="e.g. High Authority" value="High Authority" />
          </div>

          <div>
            <label for="archFieldOrder" style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-bottom: 6px; display: block;">Display Sequence Order</label>
            <input type="number" id="archFieldOrder" name="order_num" class="adv-search-input" value="1" min="0" />
          </div>
        </div>

        <!-- Active in Quiz Checkbox -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 18px; display: flex; align-items: center; gap: 10px; margin-top: 10px;">
          <input type="checkbox" id="archFieldActive" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: #10b981; cursor: pointer;" />
          <label for="archFieldActive" style="margin-bottom: 0; cursor: pointer; font-size: 0.86rem; font-weight: 700; color: #0f172a;">
            ● Active in Interactive Solution Advisor Quiz
            <span style="display: block; font-size: 0.72rem; color: #64748b; font-weight: 400;">Enable recommendation algorithms to match users to this digital blueprint on /service-finder.</span>
          </label>
        </div>

      </div>

      <!-- Modal Footer -->
      <div class="crm-modal-footer">
        <button type="button" class="adv-btn adv-btn-glass" onclick="closeEditArchetypeModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
          Cancel
        </button>
        <button type="submit" class="adv-btn adv-btn-primary" id="btnSubmitArchetype">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
          <span id="btnSubmitArchetypeText">Save Archetype</span>
        </button>
      </div>

    </form>
  </div>
</div>


<!-- ========================================================================
     MODAL 3: DELETE CONFIRMATION DIALOG
     ======================================================================== -->
<div class="admin-modal-backdrop crm-modal-backdrop" id="deleteArchetypeModalBackdrop" style="display: none;" onclick="closeDeleteArchetypeModal(event)">
  <div class="admin-modal crm-modal-card" style="max-width: 440px;" onclick="event.stopPropagation()">
    <div class="crm-modal-header" style="border-bottom: none; padding-bottom: 0;">
      <div style="width: 46px; height: 46px; border-radius: 50%; background: rgba(220, 38, 38, 0.12); color: #dc2626; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
      </div>
      <h3 class="crm-modal-title" style="color: #0f172a; font-size: 1.2rem;">Delete Solution Archetype</h3>
      <p class="crm-modal-subtitle" style="margin-top: 6px; font-size: 0.85rem;">Are you sure you want to remove <strong id="deleteTargetTitle" style="color: #0f172a;"></strong> from the Solution Advisor?</p>
    </div>

    <div class="crm-modal-body" style="padding: 16px 26px; font-size: 0.84rem; color: #64748b; line-height: 1.5;">
      This action will remove this blueprint from recommendation logic on the public quiz. Existing submissions will remain archived.
    </div>

    <div class="crm-modal-footer" style="padding: 16px 26px; border-top: 1px solid #f1f5f9;">
      <button type="button" class="adv-btn adv-btn-glass" onclick="closeDeleteArchetypeModal()" style="background: #ffffff; color: #334155; border: 1px solid #cbd5e1;">
        Cancel
      </button>
      <button type="button" class="adv-btn" id="btnConfirmDeleteAction" style="background: #dc2626; color: #ffffff; border: none; font-weight: 700;">
        Yes, Delete Record
      </button>
    </div>
  </div>
</div>

<!-- Universal Toast Container -->
<div id="adminToastContainer" style="position: fixed; bottom: 24px; right: 24px; z-index: 100001; display: flex; flex-direction: column; gap: 8px; pointer-events: none;"></div>


<!-- ========================================================================
     SOLUTION ADVISOR JAVASCRIPT ENGINE
     ======================================================================== -->
<script>
/**
 * ClickCodex Studio - Solution Advisor Controller
 * STRICT RULE: Default View is ALWAYS Cards View.
 * STRICT RULE: On Mobile View (<= 768px), View is Locked to Cards View.
 */
const BASE_URL = '<?= BASE_URL ?>';
let currentViewMode = 'cards'; // Cards view by default!
let activeStatusFilter = 'all';
let deleteTargetId = 0;

document.addEventListener('DOMContentLoaded', () => {
  // Mobile check: If screen <= 768px, force card view
  if (window.innerWidth <= 768) {
    currentViewMode = 'cards';
  } else {
    // Restore from localStorage if on desktop
    const saved = localStorage.getItem('cc_advisor_view');
    if (saved === 'table') {
      switchView('table');
    } else {
      switchView('cards');
    }
  }

  // Keyboard shortcut '/' to search
  document.addEventListener('keydown', (e) => {
    if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
      e.preventDefault();
      const s = document.getElementById('archetypeSearchInput');
      if (s) { s.focus(); s.select(); }
    } else if (e.key === 'Escape') {
      closeViewArchetypeModal();
      closeEditArchetypeModal();
      closeDeleteArchetypeModal();
    }
  });

  // Window resize listener to lock mobile to cards view
  window.addEventListener('resize', () => {
    if (window.innerWidth <= 768 && currentViewMode === 'table') {
      switchView('cards');
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
  } else if (type === 'info') {
    toast.style.background = '#0056d6';
    toast.style.color = '#ffffff';
    toast.innerHTML = `ℹ <span>${escapeHtml(message)}</span>`;
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
// TAB NAVIGATION (Archetypes vs Decision Matrix vs Leads)
// ============================================================================
function switchTab(tab) {
  const secArch = document.getElementById('sectionArchetypes');
  const secMat = document.getElementById('sectionMatrix');
  const secLeads = document.getElementById('sectionLeads');

  const btnArch = document.getElementById('tabBtnArchetypes');
  const btnMat = document.getElementById('tabBtnMatrix');
  const btnLeads = document.getElementById('tabBtnLeads');

  [btnArch, btnMat, btnLeads].forEach(b => b.classList.remove('active'));
  secArch.style.display = 'none';
  secMat.style.display = 'none';
  secLeads.style.display = 'none';

  if (tab === 'matrix') {
    secMat.style.display = 'block';
    btnMat.classList.add('active');
  } else if (tab === 'leads') {
    secLeads.style.display = 'block';
    btnLeads.classList.add('active');
  } else {
    secArch.style.display = 'block';
    btnArch.classList.add('active');
  }
}

// ============================================================================
// VIEW SWITCHER (CARDS VS MINIMAL TABLE)
// Strict Rule: On Mobile View, Always Cards View!
// ============================================================================
function switchView(mode) {
  if (window.innerWidth <= 768 && mode === 'table') {
    showToast('Mobile view is streamlined to Card View for best ergonomics.', 'info');
    mode = 'cards';
  }

  currentViewMode = mode;
  localStorage.setItem('cc_advisor_view', mode);

  const cardsView = document.getElementById('advisorCardsView');
  const tableView = document.getElementById('advisorTableView');
  const btnCards = document.getElementById('viewBtnCards');
  const btnTable = document.getElementById('viewBtnTable');

  if (mode === 'table' && window.innerWidth > 768) {
    cardsView.style.display = 'none';
    tableView.style.display = 'block';
    btnCards.classList.remove('active');
    btnTable.classList.add('active');
  } else {
    cardsView.style.display = 'grid';
    tableView.style.display = 'none';
    btnCards.classList.add('active');
    btnTable.classList.remove('active');
  }
}

// ============================================================================
// CLIENT-SIDE FILTERING & SEARCH
// ============================================================================
function handleArchetypeSearch(val) {
  applyFilters();
}

function handleStatusFilter(val) {
  activeStatusFilter = val;
  applyFilters();
}

function filterByStatus(val) {
  document.getElementById('advStatusSelect').value = val;
  activeStatusFilter = val;
  switchTab('archetypes');
  applyFilters();
}

function applyFilters() {
  const query = (document.getElementById('archetypeSearchInput')?.value || '').toLowerCase().trim();
  const items = document.querySelectorAll('.archetype-item-element');

  items.forEach(el => {
    const isActive = el.getAttribute('data-active');
    const name = el.getAttribute('data-name') || '';
    const key = el.getAttribute('data-key') || '';
    const bestfor = el.getAttribute('data-bestfor') || '';
    const desc = el.getAttribute('data-desc') || '';
    const stack = el.getAttribute('data-stack') || '';

    // Status filter
    if (activeStatusFilter === 'active' && isActive !== '1') {
      el.style.display = 'none';
      return;
    }
    if (activeStatusFilter === 'inactive' && isActive !== '0') {
      el.style.display = 'none';
      return;
    }

    // Search query match
    if (query !== '') {
      const matchText = `${name} ${key} ${bestfor} ${desc} ${stack}`;
      if (!matchText.includes(query)) {
        el.style.display = 'none';
        return;
      }
    }

    // Show
    if (el.tagName === 'TR') {
      el.style.display = '';
    } else {
      el.style.display = 'flex';
    }
  });
}

// ============================================================================
// MODAL 1: VIEW BLUEPRINT DOSSIER
// ============================================================================
async function viewArchetypeDossier(id) {
  try {
    const res = await fetch(`${BASE_URL}/admin/advisor/detail?id=${id}`);
    const data = await res.json();

    if (!data.success || !data.archetype) {
      showToast(data.error || 'Failed to load Solution Dossier.', 'error');
      return;
    }

    const arch = data.archetype;

    document.getElementById('viewDossierBadge').textContent = arch.badge_text || `Archetype 0${arch.id}`;
    document.getElementById('viewDossierName').textContent = arch.name;
    document.getElementById('viewDossierBestFor').textContent = arch.best_for || 'Enterprise';
    document.getElementById('viewDossierTimeline').textContent = arch.time_to_market || '2 – 4 Weeks';

    document.getElementById('viewDossierInvestment').textContent = arch.investment_tier || 'Growth Tier';
    document.getElementById('viewDossierScalability').textContent = arch.scalability_ceiling || 'High';
    document.getElementById('viewDossierTeamPod').textContent = arch.typical_team_pod || '2 Engineers';
    document.getElementById('viewDossierMaintenance').textContent = arch.maintenance_overhead || 'Low';

    document.getElementById('viewDossierDesc').textContent = arch.description || 'No description available.';

    // Render stack
    const stackBox = document.getElementById('viewDossierStack');
    stackBox.innerHTML = '';
    const stack = Array.isArray(arch.recommended_stack_arr) ? arch.recommended_stack_arr : [];
    if (stack.length > 0) {
      stack.forEach(stk => {
        const span = document.createElement('span');
        span.style.background = '#f1f5f9';
        span.style.border = '1px solid #cbd5e1';
        span.style.padding = '4px 10px';
        span.style.borderRadius = '6px';
        span.style.fontSize = '0.76rem';
        span.style.fontWeight = '700';
        span.style.color = '#334155';
        span.style.fontFamily = 'var(--font-mono, monospace)';
        span.textContent = stk;
        stackBox.appendChild(span);
      });
    } else {
      stackBox.innerHTML = '<span style="font-size:0.75rem; color:#94a3b8;">No stack items defined.</span>';
    }

    // Render checklists
    const checkListBox = document.getElementById('viewDossierChecklists');
    checkListBox.innerHTML = '';
    const checklists = Array.isArray(arch.checklists_arr) ? arch.checklists_arr : [];
    if (checklists.length > 0) {
      checklists.forEach(chk => {
        const item = document.createElement('div');
        item.style.display = 'flex';
        item.style.alignItems = 'center';
        item.style.gap = '8px';
        item.style.fontSize = '0.86rem';
        item.style.color = '#0f172a';
        item.innerHTML = `<span style="color:#10b981; font-weight:800; font-size:1rem;">✓</span> <span>${escapeHtml(chk)}</span>`;
        checkListBox.appendChild(item);
      });
    } else {
      checkListBox.innerHTML = '<span style="font-size:0.75rem; color:#94a3b8;">No deliverables configured.</span>';
    }

    // Hook up edit button
    const editBtn = document.getElementById('viewArchetypeEditBtn');
    editBtn.onclick = () => {
      closeViewArchetypeModal();
      editArchetype(arch.id);
    };

    const backdrop = document.getElementById('viewArchetypeModalBackdrop');
    backdrop.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  } catch (err) {
    showToast('Failed to load solution dossier.', 'error');
  }
}

function closeViewArchetypeModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close') && !e.target.classList.contains('crm-modal-close')) return;
  const backdrop = document.getElementById('viewArchetypeModalBackdrop');
  backdrop.style.display = 'none';
  document.body.style.overflow = '';
}

// ============================================================================
// MODAL 2: CREATE & EDIT ARCHETYPE
// ============================================================================
function openCreateArchetypeModal() {
  document.getElementById('archetypeForm').reset();
  document.getElementById('archFieldId').value = '0';
  document.getElementById('editArchetypeModalTitle').textContent = 'New Solution Archetype';
  document.getElementById('btnSubmitArchetypeText').textContent = 'Create Blueprint';

  const backdrop = document.getElementById('editArchetypeModalBackdrop');
  backdrop.style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

async function editArchetype(id) {
  try {
    const res = await fetch(`${BASE_URL}/admin/advisor/detail?id=${id}`);
    const data = await res.json();

    if (!data.success || !data.archetype) {
      showToast(data.error || 'Failed to load archetype details.', 'error');
      return;
    }

    const arch = data.archetype;

    document.getElementById('archFieldId').value = arch.id;
    document.getElementById('archFieldName').value = arch.name || '';
    document.getElementById('archFieldKey').value = arch.archetype_key || '';
    document.getElementById('archFieldBadge').value = arch.badge_text || 'Archetype 01';
    document.getElementById('archFieldBestFor').value = arch.best_for || '';
    document.getElementById('archFieldDesc').value = arch.description || '';

    // Join stack and checklists
    const stack = Array.isArray(arch.recommended_stack_arr) ? arch.recommended_stack_arr.join(', ') : '';
    document.getElementById('archFieldStack').value = stack;

    const checklists = Array.isArray(arch.checklists_arr) ? arch.checklists_arr.join("\n") : '';
    document.getElementById('archFieldChecklists').value = checklists;

    document.getElementById('archFieldTime').value = arch.time_to_market || '2 – 4 Weeks';
    document.getElementById('archFieldInvestment').value = arch.investment_tier || 'Growth Tier';
    document.getElementById('archFieldScalability').value = arch.scalability_ceiling || 'High';
    document.getElementById('archFieldTeamPod').value = arch.typical_team_pod || '2 Engineers';
    document.getElementById('archFieldSeo').value = arch.seo_dominance || 'High Authority';
    document.getElementById('archFieldOrder').value = arch.order_num || 1;
    document.getElementById('archFieldActive').checked = (parseInt(arch.is_active, 10) === 1);

    document.getElementById('editArchetypeModalTitle').textContent = `Edit Solution Archetype #${arch.id}`;
    document.getElementById('btnSubmitArchetypeText').textContent = 'Update Blueprint';

    const backdrop = document.getElementById('editArchetypeModalBackdrop');
    backdrop.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  } catch (err) {
    showToast('Failed to load archetype for editing.', 'error');
  }
}

function closeEditArchetypeModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close') && !e.target.classList.contains('crm-modal-close')) return;
  const backdrop = document.getElementById('editArchetypeModalBackdrop');
  backdrop.style.display = 'none';
  document.body.style.overflow = '';
}

async function submitArchetypeForm(e) {
  e.preventDefault();

  const form = document.getElementById('archetypeForm');
  const btn = document.getElementById('btnSubmitArchetype');
  const btnText = document.getElementById('btnSubmitArchetypeText');
  const origText = btnText.textContent;

  btn.disabled = true;
  btnText.textContent = 'Saving...';

  try {
    const formData = new FormData(form);
    const res = await fetch(`${BASE_URL}/admin/advisor/save`, {
      method: 'POST',
      body: formData
    });

    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Solution Archetype saved successfully!', 'success');
      closeEditArchetypeModal();
      setTimeout(() => window.location.reload(), 600);
    } else {
      showToast(data.error || 'Failed to save Solution Archetype.', 'error');
    }
  } catch (err) {
    showToast('Network error while saving archetype.', 'error');
  } finally {
    btn.disabled = false;
    btnText.textContent = origText;
  }
}

// ============================================================================
// AJAX TOGGLE STATUS
// ============================================================================
async function toggleArchetypeStatus(id, isActive) {
  try {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('is_active', isActive ? 1 : 0);

    const res = await fetch(`${BASE_URL}/admin/advisor/toggle-status`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message, 'success');
      const card = document.getElementById(`archetypeCard-${id}`);
      if (card) {
        card.setAttribute('data-active', isActive ? '1' : '0');
        const lbl = document.getElementById(`cardStatusLabel-${id}`);
        if (lbl) {
          lbl.textContent = isActive ? 'Active' : 'Inactive';
          lbl.style.color = isActive ? '#10b981' : '#94a3b8';
        }
      }
      const row = document.getElementById(`archetypeRow-${id}`);
      if (row) row.setAttribute('data-active', isActive ? '1' : '0');
    } else {
      showToast(data.error || 'Status update failed.', 'error');
    }
  } catch (err) {
    showToast('Network error during status update.', 'error');
  }
}

// ============================================================================
// DUPLICATE / CLONE ARCHETYPE
// ============================================================================
async function duplicateArchetype(id) {
  if (!confirm('Are you sure you want to clone this Solution Blueprint?')) return;

  try {
    const formData = new FormData();
    formData.append('id', id);

    const res = await fetch(`${BASE_URL}/admin/advisor/duplicate`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Blueprint cloned successfully!', 'success');
      setTimeout(() => window.location.reload(), 600);
    } else {
      showToast(data.error || 'Failed to duplicate archetype.', 'error');
    }
  } catch (err) {
    showToast('Network error while duplicating archetype.', 'error');
  }
}

// ============================================================================
// DELETE ARCHETYPE
// ============================================================================
function confirmDeleteArchetype(id, title) {
  deleteTargetId = id;
  document.getElementById('deleteTargetTitle').textContent = `"${title}"`;
  const backdrop = document.getElementById('deleteArchetypeModalBackdrop');
  backdrop.style.display = 'flex';
  document.body.style.overflow = 'hidden';

  document.getElementById('btnConfirmDeleteAction').onclick = executeDeleteArchetype;
}

function closeDeleteArchetypeModal(e) {
  if (e && e.target !== e.currentTarget && !e.target.closest('.crm-modal-close') && !e.target.classList.contains('crm-modal-close')) return;
  const backdrop = document.getElementById('deleteArchetypeModalBackdrop');
  backdrop.style.display = 'none';
  document.body.style.overflow = '';
  deleteTargetId = 0;
}

async function executeDeleteArchetype() {
  if (!deleteTargetId) return;

  const btn = document.getElementById('btnConfirmDeleteAction');
  btn.disabled = true;
  btn.textContent = 'Deleting...';

  try {
    const formData = new FormData();
    formData.append('id', deleteTargetId);

    const res = await fetch(`${BASE_URL}/admin/advisor/delete`, {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (data.success) {
      showToast(data.message || 'Solution Archetype removed.', 'success');
      closeDeleteArchetypeModal();

      const card = document.getElementById(`archetypeCard-${deleteTargetId}`);
      if (card) card.remove();
      const row = document.getElementById(`archetypeRow-${deleteTargetId}`);
      if (row) row.remove();

      // Decrement counter
      const kpi = document.getElementById('kpiTotalArchetypes');
      if (kpi) {
        const cur = parseInt(kpi.textContent, 10);
        if (cur > 0) kpi.textContent = cur - 1;
      }
    } else {
      showToast(data.error || 'Failed to delete archetype.', 'error');
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
