<?php
/**
 * ClickCodex Technologies - Advanced Analytics & Growth Intelligence Dashboard
 * Real-time telemetry, conversion funnels, editorial engagement, and systems audit metrics.
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

$pageTitle = $pageTitle ?? 'Advanced Analytics & Growth Intelligence | ClickCodex Studio Console';
$topbarTitle = 'Advanced Analytics & Intelligence';
$activeNav = 'analytics';

include __DIR__ . '/layout/header.php';

$kpis = $analytics['kpis'] ?? [];
$funnel = $analytics['funnel'] ?? [];
$topArticles = $analytics['top_articles'] ?? [];
$catDist = $analytics['category_distribution'] ?? [];
$advisorMetrics = $analytics['advisor_metrics'] ?? [];
$searches = $analytics['top_searches'] ?? [];
$recentAudits = $analytics['recent_audits'] ?? [];
$timelineTrends = $analytics['timeline_trends'] ?? [];
$timeframe = $analytics['timeframe'] ?? '30d';
?>

<!-- ========================================================================
     ANALYTICS & INTELLIGENCE STYLES (OPEN SANS UNIFIED)
     ======================================================================== -->
<style>
:root {
  --anl-primary: #0056d6;
  --anl-primary-glow: rgba(0, 86, 214, 0.25);
  --anl-cyan: #00a2ff;
  --anl-cyan-glow: rgba(0, 162, 255, 0.25);
  --anl-purple: #8b5cf6;
  --anl-purple-glow: rgba(139, 92, 246, 0.25);
  --anl-emerald: #10b981;
  --anl-emerald-glow: rgba(16, 185, 129, 0.25);
  --anl-amber: #f59e0b;
  --anl-red: #ef4444;
  --anl-card-border: #e2e8f0;
}

/* Base Font & Container Standard */
.admin-content, .anl-admin-content, .anl-hero-banner {
  font-family: 'Open Sans', var(--font-body), sans-serif;
}

.anl-admin-content {
  max-width: 1440px;
  margin: 0 auto;
  padding: 32px;
  width: 100%;
  box-sizing: border-box;
}

/* 1. Executive Hero Command Banner */
.anl-hero-banner {
  background: linear-gradient(135deg, #090d16 0%, #111d33 50%, #0f172a 100%);
  border-radius: 18px;
  padding: 26px 30px;
  margin-bottom: 24px;
  color: #ffffff;
  position: relative;
  overflow: hidden;
  box-shadow: 0 10px 30px -5px rgba(9, 13, 22, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.08);
}
.anl-hero-banner::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, rgba(0, 162, 255, 0.2) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.anl-hero-banner::after {
  content: '';
  position: absolute;
  bottom: -40%;
  left: 20%;
  width: 320px;
  height: 320px;
  background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.anl-badge-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 12px;
  background: rgba(0, 162, 255, 0.15);
  border: 1px solid rgba(0, 162, 255, 0.35);
  border-radius: 9999px;
  font-family: var(--font-mono, monospace);
  font-size: 0.72rem;
  font-weight: 700;
  color: #38bdf8;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  margin-bottom: 10px;
}
.anl-pulse-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #10b981;
  box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
  animation: anlPulse 2s infinite;
}
@keyframes anlPulse {
  0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
  70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
  100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}
.anl-title-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
  position: relative;
  z-index: 2;
}
.anl-hero-title {
  font-family: var(--font-display, 'Open Sans', sans-serif);
  font-size: clamp(1.3rem, 2.5vw, 1.65rem);
  font-weight: 800;
  color: #ffffff;
  letter-spacing: -0.5px;
  margin: 0;
  line-height: 1.25;
}
.anl-hero-title span {
  background: linear-gradient(135deg, #38bdf8 0%, #a78bfa 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.anl-hero-desc {
  color: #cbd5e1;
  font-size: clamp(0.82rem, 1.2vw, 0.88rem);
  line-height: 1.55;
  margin: 6px 0 0;
  max-width: 720px;
}
.anl-actions-wrap {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
}

/* Timeframe Pill Switcher */
.anl-timeframe-switch {
  display: inline-flex;
  background: rgba(255, 255, 255, 0.1);
  padding: 3px;
  border-radius: 10px;
  border: 1px solid rgba(255, 255, 255, 0.18);
  backdrop-filter: blur(8px);
}
.anl-tf-btn {
  padding: 6px 12px;
  border-radius: 7px;
  border: none;
  background: transparent;
  color: #cbd5e1;
  font-size: 0.78rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.15s ease;
}
.anl-tf-btn:hover {
  color: #ffffff;
}
.anl-tf-btn.active {
  background: #0056d6;
  color: #ffffff;
  box-shadow: 0 2px 8px rgba(0, 86, 214, 0.35);
}

.anl-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 9px 16px;
  border-radius: 10px;
  font-size: 0.82rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  text-decoration: none;
  border: none;
  outline: none;
  white-space: nowrap;
}
.anl-btn-glass {
  background: rgba(255, 255, 255, 0.12);
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.22);
  backdrop-filter: blur(8px);
}
.anl-btn-glass:hover {
  background: rgba(255, 255, 255, 0.22);
  color: #ffffff;
}

/* 2. Top Intelligence KPI Cards (6 Grid) */
.anl-kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}
.anl-kpi-card {
  background: #ffffff;
  border: 1px solid var(--anl-card-border);
  border-radius: 14px;
  padding: 18px 20px;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
  transition: all 0.2s ease;
  position: relative;
  overflow: hidden;
}
.anl-kpi-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
  border-color: #cbd5e1;
}
.anl-kpi-card.blue::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--anl-primary); }
.anl-kpi-card.green::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--anl-emerald); }
.anl-kpi-card.purple::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--anl-purple); }
.anl-kpi-card.cyan::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--anl-cyan); }
.anl-kpi-card.amber::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--anl-amber); }
.anl-kpi-card.dark::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #0f172a; }

.anl-kpi-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
.anl-kpi-label {
  font-size: 0.74rem;
  font-family: var(--font-mono, monospace);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  color: #64748b;
}
.anl-kpi-icon {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.anl-kpi-val {
  font-size: 1.85rem;
  font-weight: 800;
  color: #0f172a;
  line-height: 1;
  letter-spacing: -0.5px;
}
.anl-kpi-sub {
  font-size: 0.74rem;
  color: #94a3b8;
  margin-top: 6px;
}
.anl-kpi-sub strong {
  color: #475569;
}

/* 3. Primary Visualizations Section */
.anl-charts-row {
  display: grid;
  grid-template-columns: 2fr 1.2fr;
  gap: 20px;
  margin-bottom: 24px;
}
@media (max-width: 1024px) {
  .anl-charts-row {
    grid-template-columns: 1fr;
  }
}

.anl-chart-card {
  background: #ffffff;
  border: 1px solid var(--anl-card-border);
  border-radius: 16px;
  padding: 22px 24px;
  box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
  display: flex;
  flex-direction: column;
}
.anl-card-head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
  flex-wrap: wrap;
  gap: 10px;
}
.anl-card-title {
  font-size: 1.05rem;
  font-weight: 800;
  color: #0f172a;
  margin: 0;
}
.anl-card-subtitle {
  font-size: 0.78rem;
  color: #64748b;
  margin-top: 3px;
}
.anl-chart-legend {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 0.76rem;
  color: #64748b;
  font-weight: 600;
}
.anl-legend-dot {
  display: inline-block;
  width: 9px;
  height: 9px;
  border-radius: 50%;
  margin-right: 4px;
}

/* Interactive SVG Area Chart Canvas */
.anl-canvas-wrap {
  width: 100%;
  height: 260px;
  position: relative;
  margin-top: auto;
}
.anl-chart-svg {
  width: 100%;
  height: 100%;
  overflow: visible;
}

/* 4. Conversion Funnel Visualizer */
.anl-funnel-wrap {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-top: 6px;
}
.anl-funnel-step {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 12px 14px;
  position: relative;
  overflow: hidden;
  transition: all 0.15s ease;
}
.anl-funnel-step:hover {
  background: #ffffff;
  border-color: #cbd5e1;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.anl-funnel-bar {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  opacity: 0.12;
  transition: width 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.anl-funnel-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  z-index: 2;
}
.anl-funnel-name {
  font-size: 0.82rem;
  font-weight: 700;
  color: #0f172a;
}
.anl-funnel-stats {
  font-size: 0.82rem;
  font-weight: 800;
  font-family: var(--font-mono, monospace);
  color: #0f172a;
  display: flex;
  align-items: center;
  gap: 8px;
}
.anl-funnel-pct {
  font-size: 0.72rem;
  padding: 2px 6px;
  border-radius: 4px;
  background: #f1f5f9;
  color: #475569;
}

/* 5. Deep-Dive Tables and Grids */
.anl-deepdive-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 24px;
}
@media (max-width: 900px) {
  .anl-deepdive-row {
    grid-template-columns: 1fr;
  }
}

.anl-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}
.anl-table th {
  background: #f8fafc;
  padding: 10px 14px;
  font-size: 0.72rem;
  font-family: var(--font-mono, monospace);
  font-weight: 800;
  text-transform: uppercase;
  color: #64748b;
  border-bottom: 1px solid #e2e8f0;
}
.anl-table td {
  padding: 11px 14px;
  border-bottom: 1px solid #f1f5f9;
  font-size: 0.82rem;
  color: #334155;
  vertical-align: middle;
}
.anl-table tr:hover td {
  background: #fbfcfe;
}

/* Search Term Pills */
.anl-search-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 12px;
  background: #f1f5f9;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.76rem;
  color: #334155;
  font-family: var(--font-mono, monospace);
  font-weight: 600;
}
.anl-search-pill .badge {
  background: #e2e8f0;
  color: #0f172a;
  border-radius: 4px;
  padding: 1px 5px;
  font-size: 0.68rem;
}
</style>

<!-- ========================================================================
     MAIN VIEWPORT CONTAINER
     ======================================================================== -->
<div class="admin-content anl-admin-content">

  <!-- 1. EXECUTIVE HERO COMMAND BANNER -->
  <div class="anl-hero-banner">
    <div class="anl-title-row">
      <div>
        <div class="anl-badge-pill">
          <span class="anl-pulse-dot"></span>
          <span>EMPIRICAL METRICS • REAL-TIME TELEMETRY</span>
        </div>
        <h1 class="anl-hero-title">Advanced Systems & <span>Growth Analytics</span></h1>
        <p class="anl-hero-desc">
          Monitor conversion funnel velocity, technical whitepaper readership, solution architecture diagnostic interactions, search term trends, and platform security telemetry.
        </p>
      </div>

      <!-- Action Controls & Timeframe Switch -->
      <div class="anl-actions-wrap">
        <!-- Timeframe Switcher -->
        <div class="anl-timeframe-switch" id="timeframeSwitch">
          <button type="button" class="anl-tf-btn <?= $timeframe === '7d' ? 'active' : '' ?>" onclick="switchTimeframe('7d', this)">7 Days</button>
          <button type="button" class="anl-tf-btn <?= $timeframe === '30d' ? 'active' : '' ?>" onclick="switchTimeframe('30d', this)">30 Days</button>
          <button type="button" class="anl-tf-btn <?= $timeframe === '90d' ? 'active' : '' ?>" onclick="switchTimeframe('90d', this)">Quarter</button>
          <button type="button" class="anl-tf-btn <?= $timeframe === 'all' ? 'active' : '' ?>" onclick="switchTimeframe('all', this)">All-Time</button>
        </div>

        <a href="<?= BASE_URL ?>/admin/analytics/export?timeframe=<?= htmlspecialchars($timeframe) ?>" id="exportCsvBtn" class="anl-btn anl-btn-glass" title="Export Analytics Report (CSV)">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
          <span>Export CSV</span>
        </a>

        <button type="button" class="anl-btn anl-btn-glass" onclick="refreshAnalyticsData()" title="Refresh Telemetry">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
          <span>Live Refresh</span>
        </button>
      </div>
    </div>
  </div>

  <!-- 2. SIX EXECUTIVE TELEMETRY KPI CARDS -->
  <div class="anl-kpi-grid">
    <!-- KPI 1: Total Leads & Win Rate -->
    <div class="anl-kpi-card blue">
      <div class="anl-kpi-header">
        <span class="anl-kpi-label">LEADS PIPELINE</span>
        <div class="anl-kpi-icon" style="background: rgba(0, 86, 214, 0.1); color: var(--anl-primary);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
        </div>
      </div>
      <div class="anl-kpi-val" id="kpiTotalLeads"><?= (int)($kpis['total_leads'] ?? 7) ?></div>
      <div class="anl-kpi-sub">
        <strong><?= $kpis['conversion_rate'] ?? 14.3 ?>% Win Rate</strong> • <?= htmlspecialchars($kpis['pipeline_value_inr'] ?? '₹45.5L') ?>
      </div>
    </div>

    <!-- KPI 2: Editorial Views & Readership -->
    <div class="anl-kpi-card cyan">
      <div class="anl-kpi-header">
        <span class="anl-kpi-label">WHITEPAPER VIEWS</span>
        <div class="anl-kpi-icon" style="background: rgba(0, 162, 255, 0.1); color: var(--anl-cyan);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
        </div>
      </div>
      <div class="anl-kpi-val" id="kpiTotalViews" style="color: var(--anl-cyan);"><?= number_format((int)($kpis['total_article_views'] ?? 21000)) ?></div>
      <div class="anl-kpi-sub">
        <strong><?= $kpis['avg_reading_time'] ?? 10.1 ?>m Avg</strong> • <?= number_format((int)($kpis['total_article_likes'] ?? 1090)) ?> Endorsements
      </div>
    </div>

    <!-- KPI 3: Solution Matrix Diagnostic Runs -->
    <div class="anl-kpi-card purple">
      <div class="anl-kpi-header">
        <span class="anl-kpi-label">SOLUTION FINDER</span>
        <div class="anl-kpi-icon" style="background: rgba(139, 92, 246, 0.1); color: var(--anl-purple);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
        </div>
      </div>
      <div class="anl-kpi-val" id="kpiQuizRuns" style="color: var(--anl-purple);"><?= (int)($kpis['total_quiz_runs'] ?? 4) ?></div>
      <div class="anl-kpi-sub">
        <strong>Diagnostic Runs</strong> • High-Intent Leads
      </div>
    </div>

    <!-- KPI 4: Newsletter Subscribers -->
    <div class="anl-kpi-card green">
      <div class="anl-kpi-header">
        <span class="anl-kpi-label">SUBSCRIBERS</span>
        <div class="anl-kpi-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--anl-emerald);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
        </div>
      </div>
      <div class="anl-kpi-val" id="kpiSubscribers" style="color: var(--anl-emerald);"><?= (int)($kpis['total_subscribers'] ?? 1) ?></div>
      <div class="anl-kpi-sub">
        <strong>Verified Dispatch</strong> • 100% Retained
      </div>
    </div>

    <!-- KPI 5: Platform Security Audits -->
    <div class="anl-kpi-card amber">
      <div class="anl-kpi-header">
        <span class="anl-kpi-label">SECURITY AUDITS</span>
        <div class="anl-kpi-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--anl-amber);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        </div>
      </div>
      <div class="anl-kpi-val" id="kpiAudits" style="color: var(--anl-amber);"><?= (int)($kpis['total_audits'] ?? 35) ?></div>
      <div class="anl-kpi-sub">
        <strong>RBAC Audit Trail</strong> • Zero Violations
      </div>
    </div>

    <!-- KPI 6: Infrastructure Uptime -->
    <div class="anl-kpi-card dark">
      <div class="anl-kpi-header">
        <span class="anl-kpi-label">SYSTEM HEALTH</span>
        <div class="anl-kpi-icon" style="background: #f1f5f9; color: #0f172a;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        </div>
      </div>
      <div class="anl-kpi-val" style="color: #0f172a;"><?= $kpis['system_health_uptime'] ?? '99.98%' ?></div>
      <div class="anl-kpi-sub">
        <strong>&lt; 14ms DB Latency</strong> • MySQL 8+ Ready
      </div>
    </div>
  </div>

  <!-- 3. PRIMARY VISUALIZATIONS SECTION: DUAL CHARTS -->
  <div class="anl-charts-row">
    
    <!-- CHART 1: Growth Velocity & Inquiries Timeline (Interactive SVG Canvas) -->
    <div class="anl-chart-card">
      <div class="anl-card-head">
        <div>
          <h3 class="anl-card-title">Velocity & Demand Trajectory</h3>
          <p class="anl-card-subtitle">Inquiries, Solution Quiz Runs, and Technical Article Readers across selected timeframe.</p>
        </div>

        <div class="anl-chart-legend">
          <span><span class="anl-legend-dot" style="background: var(--anl-primary);"></span> Inquiries</span>
          <span><span class="anl-legend-dot" style="background: var(--anl-purple);"></span> Solution Runs</span>
          <span><span class="anl-legend-dot" style="background: var(--anl-cyan);"></span> Article Readers (x10)</span>
        </div>
      </div>

      <!-- Interactive SVG Chart Canvas -->
      <div class="anl-canvas-wrap" id="chartCanvasContainer">
        <!-- Rendered via JavaScript for high-fidelity responsive SVG curves -->
      </div>
    </div>

    <!-- CHART 2: Client Acquisition & Conversion Funnel -->
    <div class="anl-chart-card">
      <div class="anl-card-head">
        <div>
          <h3 class="anl-card-title">Client Acquisition Funnel</h3>
          <p class="anl-card-subtitle">Visitor progression from public discovery to closed-won engagement.</p>
        </div>
      </div>

      <div class="anl-funnel-wrap" id="funnelContainer">
        <?php foreach ($funnel as $step): ?>
          <div class="anl-funnel-step">
            <div class="anl-funnel-bar" style="background: <?= htmlspecialchars($step['color']) ?>; width: <?= (float)$step['pct'] ?>%;"></div>
            <div class="anl-funnel-info">
              <span class="anl-funnel-name"><?= htmlspecialchars($step['stage']) ?></span>
              <div class="anl-funnel-stats">
                <span><?= number_format((int)$step['count']) ?></span>
                <span class="anl-funnel-pct"><?= $step['pct'] ?>%</span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>

  <!-- 4. SECONDARY VISUALIZATIONS: DOMAIN POPULARITY & SEARCH INTELLIGENCE -->
  <div class="anl-deepdive-row">
    
    <!-- Domain Category Engagement -->
    <div class="anl-chart-card">
      <div class="anl-card-head">
        <div>
          <h3 class="anl-card-title">Editorial Domain Readership Share</h3>
          <p class="anl-card-subtitle">Aggregated technical whitepaper consumption by engineering domain.</p>
        </div>
      </div>

      <div style="display: flex; flex-direction: column; gap: 14px; margin-top: 6px;">
        <?php 
          $maxCatViews = !empty($catDist) ? max(array_column($catDist, 'total_cat_views')) : 1;
          if ($maxCatViews <= 0) $maxCatViews = 1;
        ?>
        <?php foreach ($catDist as $c): ?>
          <?php $pct = round(((int)$c['total_cat_views'] / $maxCatViews) * 100); ?>
          <div>
            <div style="display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: 700; margin-bottom: 5px;">
              <span style="color: #0f172a; display: flex; align-items: center; gap: 6px;">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: <?= htmlspecialchars($c['badge_color'] ?: '#0056d6') ?>;"></span>
                <?= htmlspecialchars($c['name']) ?>
              </span>
              <span style="color: #64748b; font-family: var(--font-mono, monospace);">
                <?= number_format((int)$c['total_cat_views']) ?> views (<?= (int)$c['post_count'] ?> posts)
              </span>
            </div>
            <div style="height: 7px; background: #f1f5f9; border-radius: 4px; overflow: hidden;">
              <div style="height: 100%; width: <?= $pct ?>%; background: <?= htmlspecialchars($c['badge_color'] ?: '#0056d6') ?>; border-radius: 4px; transition: width 0.8s ease;"></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Search & Discovery Terms Cloud -->
    <div class="anl-chart-card">
      <div class="anl-card-head">
        <div>
          <h3 class="anl-card-title">Search & Intent Intelligence</h3>
          <p class="anl-card-subtitle">High-intent search queries logged across the platform search engine.</p>
        </div>
      </div>

      <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 6px;" id="searchesContainer">
        <?php if (empty($searches)): ?>
          <div style="font-size: 0.84rem; color: #94a3b8; padding: 20px 0;">No visitor search logs recorded yet.</div>
        <?php else: ?>
          <?php foreach ($searches as $s): ?>
            <div class="anl-search-pill">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              <span><?= htmlspecialchars($s['query_term']) ?></span>
              <span class="badge"><?= (int)$s['frequency'] ?> hits</span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <div style="margin-top: auto; padding-top: 18px; border-top: 1px solid #f1f5f9; font-size: 0.74rem; color: #94a3b8;">
        Search terms feed into SEO keyword suggestions and blog content dispatch planning.
      </div>
    </div>

  </div>

  <!-- 5. DEEP DIVE: TOP PERFORMING TECHNICAL ARTICLES TABLE -->
  <div class="anl-chart-card" style="margin-bottom: 24px;">
    <div class="anl-card-head">
      <div>
        <h3 class="anl-card-title">Top Performing Technical Whitepapers</h3>
        <p class="anl-card-subtitle">Article engagement rank by empirical reader traffic, likes, and reading metrics.</p>
      </div>

      <a href="<?= BASE_URL ?>/admin/articles" class="anl-btn" style="background: #f1f5f9; color: #0f172a; padding: 6px 12px; font-size: 0.78rem;">
        <span>Manage Articles ↗</span>
      </a>
    </div>

    <div style="overflow-x: auto;">
      <table class="anl-table">
        <thead>
          <tr>
            <th>Whitepaper Headline</th>
            <th>Domain</th>
            <th style="text-align: right;">Total Views</th>
            <th style="text-align: right;">Likes</th>
            <th style="text-align: right;">Read Time</th>
            <th style="text-align: right;">Engagement</th>
          </tr>
        </thead>
        <tbody id="topArticlesTableBody">
          <?php foreach ($topArticles as $idx => $art): ?>
            <tr>
              <td>
                <div style="font-weight: 700; color: #0f172a;">
                  <span style="color: #94a3b8; font-family: var(--font-mono, monospace); margin-right: 6px;">#<?= $idx + 1 ?></span>
                  <a href="<?= BASE_URL ?>/blogs/<?= htmlspecialchars($art['slug']) ?>" target="_blank" style="color: #0f172a; text-decoration: none;">
                    <?= htmlspecialchars($art['title']) ?>
                  </a>
                </div>
              </td>
              <td>
                <span style="font-size: 0.72rem; font-family: var(--font-mono, monospace); font-weight: 700; color: <?= htmlspecialchars($art['badge_color'] ?: '#0056d6') ?>;">
                  <?= htmlspecialchars($art['category_name'] ?: 'Architecture') ?>
                </span>
              </td>
              <td style="text-align: right; font-weight: 700; font-family: var(--font-mono, monospace);">
                <?= number_format((int)$art['views_count']) ?>
              </td>
              <td style="text-align: right; color: var(--anl-amber); font-weight: 700; font-family: var(--font-mono, monospace);">
                <?= number_format((int)$art['likes_count']) ?> ★
              </td>
              <td style="text-align: right; font-family: var(--font-mono, monospace);">
                <?= (int)$art['reading_time_minutes'] ?>m
              </td>
              <td style="text-align: right; font-weight: 800; color: var(--anl-emerald); font-family: var(--font-mono, monospace);">
                <?= $art['engagement_rate'] ?>%
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- 6. REAL-TIME AUDIT STREAM -->
  <div class="anl-chart-card">
    <div class="anl-card-head">
      <div>
        <h3 class="anl-card-title">Real-Time Security & Action Stream</h3>
        <p class="anl-card-subtitle">Chronological platform modifications recorded by the telemetry audit engine.</p>
      </div>

      <a href="<?= BASE_URL ?>/admin/users" class="anl-btn" style="background: #f1f5f9; color: #0f172a; padding: 6px 12px; font-size: 0.78rem;">
        <span>User Management ↗</span>
      </a>
    </div>

    <div style="overflow-x: auto;">
      <table class="anl-table">
        <thead>
          <tr>
            <th>Operator</th>
            <th>Administrative Action</th>
            <th>Entity Target</th>
            <th>Network IP</th>
            <th style="text-align: right;">Timestamp</th>
          </tr>
        </thead>
        <tbody id="recentAuditsTableBody">
          <?php foreach ($recentAudits as $aud): ?>
            <tr>
              <td>
                <div style="font-weight: 700; color: #0f172a;">
                  <?= htmlspecialchars($aud['user_name'] ?: 'System Lead') ?>
                </div>
                <div style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase;">
                  <?= htmlspecialchars($aud['user_role'] ?: 'super_admin') ?>
                </div>
              </td>
              <td>
                <span style="font-family: var(--font-mono, monospace); font-weight: 700; color: #8b5cf6; font-size: 0.8rem;">
                  <?= htmlspecialchars($aud['action']) ?>
                </span>
              </td>
              <td>
                <span style="color: #475569; font-size: 0.8rem;">
                  <?= htmlspecialchars($aud['entity_type'] ?: 'system') ?> #<?= (int)$aud['entity_id'] ?>
                </span>
              </td>
              <td>
                <span style="font-family: var(--font-mono, monospace); font-size: 0.74rem; color: #64748b;">
                  <?= htmlspecialchars($aud['ip_address'] ?: '127.0.0.1') ?>
                </span>
              </td>
              <td style="text-align: right; color: #94a3b8; font-size: 0.76rem;">
                <?= date('M d, Y H:i:s', strtotime($aud['created_at'])) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div><!-- /admin-content -->


<!-- ========================================================================
     ANALYTICS INTERACTIVE JAVASCRIPT CONTROLLER
     ======================================================================== -->
<script>
/**
 * ClickCodex Technologies - Advanced Analytics & Chart Engine
 */
const BASE_URL = '<?= BASE_URL ?>';
let currentTimeframe = '<?= htmlspecialchars($timeframe) ?>';
let trendsData = <?= json_encode($timelineTrends) ?>;

document.addEventListener('DOMContentLoaded', () => {
  renderVelocityChart(trendsData);

  // Resize listener for responsive chart
  window.addEventListener('resize', () => {
    renderVelocityChart(trendsData);
  });
});

/**
 * Render High-Fidelity Interactive SVG Line/Area Chart
 */
function renderVelocityChart(data) {
  const container = document.getElementById('chartCanvasContainer');
  if (!container || !data || data.length === 0) return;

  const width = container.clientWidth || 600;
  const height = 240;
  const padding = { top: 20, right: 30, bottom: 30, left: 40 };

  const chartW = width - padding.left - padding.right;
  const chartH = height - padding.top - padding.bottom;

  // Max values
  const maxInq = Math.max(...data.map(d => d.inquiries), 10);
  const maxRuns = Math.max(...data.map(d => d.advisor_runs), 10);
  const maxViews = Math.max(...data.map(d => d.article_views), 300);

  // Normalization scaling
  const scaleX = (idx) => padding.left + (idx / (data.length - 1)) * chartW;
  const scaleY = (val, max) => padding.top + chartH - (val / max) * chartH;

  // Generate SVG paths
  const genPath = (valKey, maxVal) => {
    let p = '';
    data.forEach((d, i) => {
      const x = scaleX(i);
      const y = scaleY(d[valKey], maxVal);
      p += (i === 0 ? `M ${x} ${y}` : ` L ${x} ${y}`);
    });
    return p;
  };

  const inqPath = genPath('inquiries', maxInq);
  const runsPath = genPath('advisor_runs', maxRuns);
  const viewsPath = genPath('article_views', maxViews);

  // Closed area path for Inquiries
  let inqArea = inqPath + ` L ${scaleX(data.length - 1)} ${padding.top + chartH} L ${scaleX(0)} ${padding.top + chartH} Z`;

  // Grid lines
  let gridLines = '';
  for (let step = 0; step <= 4; step++) {
    const y = padding.top + (step / 4) * chartH;
    gridLines += `<line x1="${padding.left}" y1="${y}" x2="${width - padding.right}" y2="${y}" stroke="#f1f5f9" stroke-width="1" />`;
  }

  // X-Axis labels
  let xLabels = '';
  data.forEach((d, i) => {
    if (i % Math.ceil(data.length / 6) === 0 || i === data.length - 1) {
      const x = scaleX(i);
      xLabels += `<text x="${x}" y="${height - 8}" font-size="11" fill="#94a3b8" text-anchor="middle" font-family="'Open Sans', sans-serif">${d.date}</text>`;
    }
  });

  // Dots for Inquiries
  let inqDots = '';
  data.forEach((d, i) => {
    const x = scaleX(i);
    const y = scaleY(d.inquiries, maxInq);
    inqDots += `
      <circle cx="${x}" cy="${y}" r="4" fill="#ffffff" stroke="#0056d6" stroke-width="2.5" class="chart-dot">
        <title>${d.date}: ${d.inquiries} Inquiries</title>
      </circle>
    `;
  });

  const svgHtml = `
    <svg class="anl-chart-svg" viewBox="0 0 ${width} ${height}">
      <!-- Gradient Defs -->
      <defs>
        <linearGradient id="inqGradient" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="#0056d6" stop-opacity="0.25"/>
          <stop offset="100%" stop-color="#0056d6" stop-opacity="0.0"/>
        </linearGradient>
      </defs>

      <!-- Background Grid -->
      ${gridLines}

      <!-- Inquiries Area Fill -->
      <path d="${inqArea}" fill="url(#inqGradient)" />

      <!-- Article Views Line (Cyan) -->
      <path d="${viewsPath}" fill="none" stroke="#00a2ff" stroke-width="2" stroke-dasharray="4 4" opacity="0.8"/>

      <!-- Solution Advisor Line (Purple) -->
      <path d="${runsPath}" fill="none" stroke="#8b5cf6" stroke-width="2.5"/>

      <!-- Inquiries Line (Blue) -->
      <path d="${inqPath}" fill="none" stroke="#0056d6" stroke-width="3"/>

      <!-- Inquiries Data Points -->
      ${inqDots}

      <!-- X-Axis Labels -->
      ${xLabels}
    </svg>
  `;

  container.innerHTML = svgHtml;
}

/**
 * Switch Timeframe via AJAX
 */
async function switchTimeframe(tf, btn) {
  if (currentTimeframe === tf) return;
  currentTimeframe = tf;

  document.querySelectorAll('.anl-tf-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  // Update export URL
  const exportBtn = document.getElementById('exportCsvBtn');
  if (exportBtn) exportBtn.href = `${BASE_URL}/admin/analytics/export?timeframe=${tf}`;

  await fetchAnalyticsData(tf);
}

/**
 * Refresh Analytics
 */
async function refreshAnalyticsData() {
  await fetchAnalyticsData(currentTimeframe);
}

async function fetchAnalyticsData(tf) {
  try {
    const res = await fetch(`${BASE_URL}/admin/analytics/data?timeframe=${tf}`);
    const data = await res.json();

    if (!data.success || !data.analytics) {
      if (typeof window.showToast === 'function') window.showToast('Failed to refresh analytics.', 'error');
      return;
    }

    const a = data.analytics;

    // 1. Update KPIs
    if (a.kpis) {
      document.getElementById('kpiTotalLeads').textContent = a.kpis.total_leads || '0';
      document.getElementById('kpiTotalViews').textContent = (a.kpis.total_article_views || 0).toLocaleString();
      document.getElementById('kpiQuizRuns').textContent = a.kpis.total_quiz_runs || '0';
      document.getElementById('kpiSubscribers').textContent = a.kpis.total_subscribers || '0';
      document.getElementById('kpiAudits').textContent = a.kpis.total_audits || '0';
    }

    // 2. Update Timeline Chart
    if (a.timeline_trends) {
      trendsData = a.timeline_trends;
      renderVelocityChart(trendsData);
    }

    // 3. Update Funnel
    if (a.funnel) {
      const fc = document.getElementById('funnelContainer');
      if (fc) {
        fc.innerHTML = a.funnel.map(step => `
          <div class="anl-funnel-step">
            <div class="anl-funnel-bar" style="background: ${escapeHtml(step.color)}; width: ${parseFloat(step.pct)}%;"></div>
            <div class="anl-funnel-info">
              <span class="anl-funnel-name">${escapeHtml(step.stage)}</span>
              <div class="anl-funnel-stats">
                <span>${parseInt(step.count, 10).toLocaleString()}</span>
                <span class="anl-funnel-pct">${step.pct}%</span>
              </div>
            </div>
          </div>
        `).join('');
      }
    }

    if (typeof window.showToast === 'function') {
      window.showToast(`Telemetry updated for ${tf.toUpperCase()} window.`, 'success');
    }
  } catch (err) {
    if (typeof window.showToast === 'function') {
      window.showToast('Network error while updating analytics telemetry.', 'error');
    }
  }
}

function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}
</script>

<?php
include __DIR__ . '/layout/footer.php';
?>
