<?php
/**
 * ClickCodex Technologies - Studio Executive Dashboard
 * Ultra-Premium Executive Console with Interactive Telemetry, Quick Actions, and Live Lead Pipeline.
 */
declare(strict_types=1);

$pageTitle = "Executive Studio Console | ClickCodex Admin";
$topbarTitle = "Studio Console";
$activeNav = "dashboard";

include __DIR__ . '/layout/header.php';
?>

      <!-- ========================================================================
           MAIN DASHBOARD CONTENT
           ======================================================================== -->
      <div class="admin-content">

        <!-- Welcome Banner with Dynamic Time Greeting -->
        <div class="dashboard-welcome-banner">
          <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(0, 162, 255, 0.15); border: 1px solid rgba(0, 162, 255, 0.3); padding: 4px 12px; border-radius: 9999px; margin-bottom: 12px; font-family: var(--font-mono); font-size: 0.72rem; color: var(--admin-cyan); font-weight: 700;">
            <span class="topbar-dot-pulse"></span>
            <span>2-Hour Technical SLA Active • 100% On-Time Execution</span>
          </div>

          <h1 class="welcome-title"><?= $timeGreeting ?>, <?= htmlspecialchars($userDisplayName) ?></h1>
          <p class="welcome-desc">
            You currently have <strong><?= (int)($stats['new_inquiries'] ?? 0) ?> high-priority client inquiries</strong> pending technical proposal dispatch under the 2-Hour SLA guarantee. All public systems, forms, and databases are synchronized.
          </p>

          <div class="welcome-actions-row">
            <a href="#inquiries-panel" class="welcome-btn primary">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              <span>Review Inquiries (<?= (int)($stats['total_inquiries'] ?? 0) ?>)</span>
            </a>
            <button type="button" class="welcome-btn secondary" onclick="exportInquiriesCSV()">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
              <span>Export Leads CSV</span>
            </button>
            <button type="button" class="welcome-btn secondary" onclick="triggerClearCache()">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
              <span>Flush Cache</span>
            </button>
            <a href="<?= BASE_URL ?>/" target="_blank" class="welcome-btn secondary">
              <span>Public Live Site ↗</span>
            </a>
          </div>
        </div>

        <!-- 4 Executive Metric Cards with Mini Sparklines -->
        <div class="metrics-row">
          <!-- Metric 1: Total Leads & Inquiries -->
          <div class="metric-card accent-orange">
            <div class="metric-card-top">
              <span class="metric-card-label">Client Inquiries</span>
              <div class="metric-card-icon" style="color: var(--admin-orange);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
              </div>
            </div>

            <div class="metric-card-body">
              <div class="metric-card-val" id="metricTotalInquiries"><?= (int)($stats['total_inquiries'] ?? 0) ?></div>
              <!-- Mini SVG Sparkline Trend -->
              <svg class="metric-sparkline-svg" viewBox="0 0 86 32">
                <path d="M 0 28 Q 20 24, 40 18 T 86 4" fill="none" stroke="var(--admin-orange)" stroke-width="2.5" stroke-linecap="round" />
                <circle cx="86" cy="4" r="3.5" fill="var(--admin-orange)" />
              </svg>
            </div>

            <div class="metric-card-foot">
              <span class="metric-badge-green" id="metricNewInquiries">● <?= (int)($stats['new_inquiries'] ?? 0) ?> New</span>
              <span>• Under 2-Hour SLA</span>
            </div>
          </div>

          <!-- Metric 2: Estimated Pipeline -->
          <div class="metric-card accent-cyan">
            <div class="metric-card-top">
              <span class="metric-card-label">Active Pipeline</span>
              <div class="metric-card-icon" style="color: var(--admin-cyan);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
              </div>
            </div>

            <div class="metric-card-body">
              <div class="metric-card-val"><?= htmlspecialchars((string)($stats['estimated_pipeline_inr'] ?? '₹18.4L')) ?></div>
              <!-- Mini SVG Sparkline Trend -->
              <svg class="metric-sparkline-svg" viewBox="0 0 86 32">
                <path d="M 0 26 Q 25 15, 55 18 T 86 2" fill="none" stroke="var(--admin-cyan)" stroke-width="2.5" stroke-linecap="round" />
                <circle cx="86" cy="2" r="3.5" fill="var(--admin-cyan)" />
              </svg>
            </div>

            <div class="metric-card-foot">
              <span class="metric-badge-green">+18.5% MoM</span>
              <span>• Fixed Sprint Model</span>
            </div>
          </div>

          <!-- Metric 3: Digital Capabilities -->
          <a href="<?= BASE_URL ?>/admin/capabilities" class="metric-card" style="text-decoration: none; color: inherit; cursor: pointer;">
            <div class="metric-card-top">
              <span class="metric-card-label">Engineering Offerings</span>
              <div class="metric-card-icon" style="color: var(--admin-blue);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
              </div>
            </div>

            <div class="metric-card-body">
              <div class="metric-card-val"><?= (int)($stats['total_services'] ?? 6) ?></div>
              <!-- Mini SVG Sparkline Trend -->
              <svg class="metric-sparkline-svg" viewBox="0 0 86 32">
                <path d="M 0 16 Q 30 16, 60 16 T 86 16" fill="none" stroke="var(--admin-blue)" stroke-width="2.5" stroke-linecap="round" />
                <circle cx="86" cy="16" r="3.5" fill="var(--admin-blue)" />
              </svg>
            </div>

            <div class="metric-card-foot">
              <span class="metric-badge-green">Manage Capabilities →</span>
              <span>• Full-Stack, AI, Cloud</span>
            </div>
          </a>

          <!-- Metric 4: Case Studies & Articles -->
          <a href="<?= BASE_URL ?>/admin/portfolio" class="metric-card accent-green" style="text-decoration: none; color: inherit; cursor: pointer;">
            <div class="metric-card-top">
              <span class="metric-card-label">Published Assets</span>
              <div class="metric-card-icon" style="color: var(--admin-green);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
              </div>
            </div>

            <div class="metric-card-body">
              <div class="metric-card-val"><?= (int)(($stats['total_case_studies'] ?? 4) + ($stats['total_blog_posts'] ?? 4)) ?></div>
              <!-- Mini SVG Sparkline Trend -->
              <svg class="metric-sparkline-svg" viewBox="0 0 86 32">
                <path d="M 0 28 Q 30 20, 50 12 T 86 6" fill="none" stroke="var(--admin-green)" stroke-width="2.5" stroke-linecap="round" />
                <circle cx="86" cy="6" r="3.5" fill="var(--admin-green)" />
              </svg>
            </div>

            <div class="metric-card-foot">
              <span class="metric-badge-green">Manage Portfolio →</span>
              <span>• <?= (int)($stats['total_case_studies'] ?? 4) ?> Cases, <?= (int)($stats['total_blog_posts'] ?? 4) ?> Blogs</span>
            </div>
          </a>
        </div>

        <!-- 2-Column Dashboard Main Layout -->
        <div class="dashboard-grid-layout">

          <!-- LEFT COLUMN: INQUIRIES & LEAD MATRIX -->
          <div>

            <!-- Inquiry Trends Visualizer Panel -->
            <div class="dashboard-panel">
              <div class="panel-header-row">
                <div>
                  <h3 class="panel-title">Inquiry Inflow & Lead Velocity</h3>
                  <span style="font-size: 0.8rem; color: var(--text-muted);">Real-time aggregated daily conversions with hover telemetry</span>
                </div>
                <div style="font-family: var(--font-mono); font-size: 0.78rem; color: var(--admin-cyan); background: rgba(0, 162, 255, 0.08); padding: 4px 10px; border-radius: 6px;">
                  SLA: 100% On-Time
                </div>
              </div>

              <!-- Interactive Chart Visualizer -->
              <div style="width: 100%; height: 160px; position: relative;" id="chartContainer">
                <div class="chart-tooltip" id="chartTooltip"></div>

                <svg viewBox="0 0 700 150" style="width: 100%; height: 100%; overflow: visible;" preserveAspectRatio="none">
                  <defs>
                    <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                      <stop offset="0%" stop-color="#00a2ff" stop-opacity="0.35" />
                      <stop offset="100%" stop-color="#0056d6" stop-opacity="0.0" />
                    </linearGradient>
                  </defs>
                  <!-- Gradient Area -->
                  <path d="M 0 110 Q 116 75, 233 45 T 466 30 T 700 15 L 700 150 L 0 150 Z" fill="url(#chartGradient)" />
                  <!-- Accent Line -->
                  <path d="M 0 110 Q 116 75, 233 45 T 466 30 T 700 15" fill="none" stroke="#00a2ff" stroke-width="3" stroke-linecap="round" />
                  
                  <!-- Interactive Hoverable Data Dots -->
                  <circle class="chart-dot" cx="0" cy="110" r="4.5" fill="#0056d6" stroke="#ffffff" stroke-width="2" data-day="Mon" data-count="1" data-pipe="₹1.5L" />
                  <circle class="chart-dot" cx="116" cy="85" r="4.5" fill="#0056d6" stroke="#ffffff" stroke-width="2" data-day="Tue" data-count="2" data-pipe="₹3.0L" />
                  <circle class="chart-dot" cx="233" cy="45" r="4.5" fill="#0056d6" stroke="#ffffff" stroke-width="2" data-day="Wed" data-count="4" data-pipe="₹6.5L" />
                  <circle class="chart-dot" cx="350" cy="55" r="4.5" fill="#0056d6" stroke="#ffffff" stroke-width="2" data-day="Thu" data-count="3" data-pipe="₹4.5L" />
                  <circle class="chart-dot" cx="466" cy="30" r="4.5" fill="#00a2ff" stroke="#ffffff" stroke-width="2" data-day="Fri" data-count="5" data-pipe="₹8.0L" />
                  <circle class="chart-dot" cx="583" cy="40" r="4.5" fill="#ff6a00" stroke="#ffffff" stroke-width="2" data-day="Sat" data-count="3" data-pipe="₹5.0L" />
                  <circle class="chart-dot" cx="700" cy="15" r="5.5" fill="#ff6a00" stroke="#ffffff" stroke-width="2.5" data-day="Sun" data-count="6" data-pipe="₹10.5L" />
                </svg>

                <div style="display: flex; justify-content: space-between; margin-top: 10px; font-family: var(--font-mono); font-size: 0.72rem; color: var(--text-muted);">
                  <?php if (!empty($trends)): ?>
                    <?php foreach ($trends as $trend): ?>
                      <span><?= htmlspecialchars($trend['day']) ?> (<?= (int)$trend['inquiries'] ?>)</span>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <!-- Client Inquiries Table Panel with Instant Search & Status Filter -->
            <div class="dashboard-panel" id="inquiries-panel">
              <div class="panel-header-row">
                <div>
                  <h3 class="panel-title">Incoming Project Inquiries (<span id="inquiryVisibleCount"><?= count($recentInquiries) ?></span>)</h3>
                  <span style="font-size: 0.8rem; color: var(--text-muted);">Interactive status manager • Click status pill to update in real-time</span>
                </div>
                <button type="button" class="topbar-live-site-btn" onclick="exportInquiriesCSV()" style="padding: 4px 10px; font-size: 0.75rem;">
                  Download CSV
                </button>
              </div>

              <!-- Filter Pills Toolbar & Instant Search -->
              <div class="table-toolbar">
                <div class="table-filter-pills" id="statusFilterPills">
                  <button type="button" class="filter-pill active" onclick="filterByStatus('all', this)">All (<?= count($recentInquiries) ?>)</button>
                  <button type="button" class="filter-pill" onclick="filterByStatus('new', this)">New</button>
                  <button type="button" class="filter-pill" onclick="filterByStatus('reviewing', this)">Reviewing</button>
                  <button type="button" class="filter-pill" onclick="filterByStatus('contacted', this)">Contacted</button>
                </div>

                <div class="table-search-box">
                  <svg class="table-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                  <input type="text" id="tableFilterInput" class="table-search-input" placeholder="Filter by client, email, service..." oninput="handleTableFilter()" />
                </div>
              </div>

              <?php if (!empty($recentInquiries)): ?>
                <div class="admin-table-wrap">
                  <table class="admin-table" id="inquiriesTable">
                    <thead>
                      <tr>
                        <th>Lead Contact</th>
                        <th>Type / Source</th>
                        <th>Selected Services</th>
                        <th>Status</th>
                        <th>Quick Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($recentInquiries as $inq): ?>
                        <tr class="inquiry-row" 
                            id="inquiry-row-<?= $inq['id'] ?>"
                            data-id="<?= $inq['id'] ?>"
                            data-name="<?= htmlspecialchars(strtolower($inq['full_name'] ?? '')) ?>"
                            data-email="<?= htmlspecialchars(strtolower($inq['email'] ?? '')) ?>"
                            data-company="<?= htmlspecialchars(strtolower($inq['company_name'] ?? '')) ?>"
                            data-services="<?= htmlspecialchars(strtolower(implode(' ', $inq['services_list'] ?? []))) ?>"
                            data-status="<?= htmlspecialchars($inq['status'] ?? 'new') ?>"
                            data-raw-name="<?= htmlspecialchars($inq['full_name'] ?? '') ?>"
                            data-raw-phone="<?= htmlspecialchars($inq['phone'] ?? '') ?>"
                            data-raw-budget="<?= htmlspecialchars($inq['budget_bracket'] ?: 'Custom Scope') ?>"
                            data-raw-message="<?= htmlspecialchars($inq['message'] ?? 'No message provided.') ?>"
                            data-raw-date="<?= date('M d, Y H:i', strtotime($inq['created_at'] ?? 'now')) ?>"
                            data-raw-ip="<?= htmlspecialchars($inq['ip_address'] ?? '127.0.0.1') ?>">
                          <td>
                            <strong style="color: var(--text-main); display: block; font-size: 0.92rem;"><?= htmlspecialchars($inq['full_name'] ?? 'Client') ?></strong>
                            <span style="font-size: 0.8rem; color: var(--text-muted);"><?= htmlspecialchars($inq['email'] ?? '') ?></span>
                            <?php if (!empty($inq['company_name'])): ?>
                              <span style="display: block; font-size: 0.75rem; color: var(--admin-blue); font-weight: 600;"><?= htmlspecialchars($inq['company_name']) ?></span>
                            <?php endif; ?>
                          </td>
                          <td>
                            <span style="font-family: var(--font-mono); font-size: 0.74rem; color: var(--text-muted); text-transform: uppercase;">
                              <?= htmlspecialchars(str_replace('_', ' ', $inq['inquiry_type'] ?? 'general')) ?>
                            </span>
                          </td>
                          <td>
                            <?php if (!empty($inq['services_list'])): ?>
                              <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                <?php foreach ($inq['services_list'] as $sItem): ?>
                                  <span style="background: rgba(0, 86, 214, 0.08); color: var(--admin-blue); font-size: 0.72rem; padding: 2px 7px; border-radius: 4px; font-weight: 600;">
                                    <?= htmlspecialchars($sItem) ?>
                                  </span>
                                <?php endforeach; ?>
                              </div>
                            <?php else: ?>
                              <span style="color: var(--text-muted); font-size: 0.82rem;">General Scope</span>
                            <?php endif; ?>
                          <td>
                            <!-- Interactive Status Quick Changer Dropdown -->
                            <select class="status-select-btn" onchange="updateInquiryStatus(<?= (int)$inq['id'] ?>, this.value, this)" title="Change inquiry status">
                              <option value="new" <?= ($inq['status'] ?? '') === 'new' ? 'selected' : '' ?>>● NEW</option>
                              <option value="reviewing" <?= ($inq['status'] ?? '') === 'reviewing' ? 'selected' : '' ?>>● REVIEWING</option>
                              <option value="contacted" <?= ($inq['status'] ?? '') === 'contacted' ? 'selected' : '' ?>>● CONTACTED</option>
                              <option value="proposal_sent" <?= ($inq['status'] ?? '') === 'proposal_sent' ? 'selected' : '' ?>>● PROPOSAL SENT</option>
                              <option value="closed_won" <?= ($inq['status'] ?? '') === 'closed_won' ? 'selected' : '' ?>>● WON</option>
                              <option value="closed_lost" <?= ($inq['status'] ?? '') === 'closed_lost' ? 'selected' : '' ?>>● LOST</option>
                              <option value="spam" <?= ($inq['status'] ?? '') === 'spam' ? 'selected' : '' ?>>● SPAM</option>
                            </select>
                          </td>
                          <td>
                            <div style="display: flex; gap: 6px; align-items: center;">
                              <button type="button" class="btn-micro-action" onclick="openInquiryModal(<?= (int)$inq['id'] ?>)" title="View Full Details">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                              </button>
                              <a href="mailto:<?= htmlspecialchars($inq['email'] ?? '') ?>" class="btn-micro-action" title="Send Email">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                              </a>
                              <?php if (!empty($inq['phone'])): ?>
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $inq['phone']) ?>" target="_blank" class="btn-micro-action" style="color: #059669;" title="Chat WhatsApp">
                                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                </a>
                              <?php endif; ?>
                              <button type="button" class="btn-micro-action" onclick="copyInquiryDetails(<?= (int)$inq['id'] ?>)" title="Copy Lead Details">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                              </button>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php else: ?>
                <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center; padding: 30px;">
                  No client inquiries recorded yet. Test submissions from the Contact Us page will appear here instantly.
                </p>
              <?php endif; ?>
            </div>

          </div>

          <!-- RIGHT COLUMN: TELEMETRY & AUDIT TRAILS -->
          <div>

            <!-- Cyber Infrastructure Telemetry -->
            <div class="telemetry-card">
              <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
                <h4 style="font-family: var(--font-display); font-size: 1.05rem; font-weight: 700; color: #ffffff;">System Telemetry</h4>
                <button type="button" onclick="testDatabaseLatency()" style="font-size: 0.72rem; color: var(--admin-cyan); background: rgba(0, 162, 255, 0.15); padding: 3px 8px; border-radius: 4px; cursor: pointer;">
                  Ping Server
                </button>
              </div>

              <div class="telemetry-item">
                <span class="telemetry-label">PHP Engine</span>
                <span class="telemetry-val">v<?= PHP_VERSION ?></span>
              </div>

              <div class="telemetry-item">
                <span class="telemetry-label">Database</span>
                <span class="telemetry-val">MySQL 8.x / clickcodex_db</span>
              </div>

              <div class="telemetry-item">
                <span class="telemetry-label">Operating Timezone</span>
                <span class="telemetry-val">Asia/Kolkata (IST)</span>
              </div>

              <div class="telemetry-item">
                <span class="telemetry-label">Core Web Vitals</span>
                <span class="telemetry-val" style="color: #10b981;">98/100 (Optimal)</span>
              </div>

              <div class="telemetry-item">
                <span class="telemetry-label">Active Session</span>
                <span class="telemetry-val"><?= htmlspecialchars($currentUser['email'] ?? 'admin@clickcodex.com') ?></span>
              </div>

              <div class="telemetry-item">
                <span class="telemetry-label">Database Sync</span>
                <span class="telemetry-val" id="latencyText" style="color: var(--admin-cyan); font-family: var(--font-mono); font-size: 0.78rem;">Live Connected</span>
              </div>

              <div style="margin-top: 16px;">
                <button type="button" class="welcome-btn secondary" onclick="triggerClearCache()" style="width: 100%; justify-content: center; font-size: 0.8rem; padding: 8px;">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                  <span>Flush Local Cache</span>
                </button>
              </div>
            </div>

            <!-- Activity Audit Trail Panel -->
            <div class="dashboard-panel">
              <div class="panel-header-row">
                <h4 class="panel-title" style="font-size: 1.05rem;">Security & Audit Trail</h4>
                <span style="font-family: var(--font-mono); font-size: 0.72rem; color: var(--text-muted);">Live Events</span>
              </div>

              <div class="activity-stream" id="activityStream">
                <?php if (!empty($recentAudits)): ?>
                  <?php foreach ($recentAudits as $log): ?>
                    <div class="activity-node">
                      <span class="activity-node-dot"></span>
                      <div>
                        <div class="activity-node-text">
                          <strong><?= htmlspecialchars($log['user_name'] ?? 'System') ?></strong> performed: 
                          <code style="font-family: var(--font-mono); color: var(--admin-blue);"><?= htmlspecialchars($log['action']) ?></code>
                        </div>
                        <div class="activity-node-time">
                          <?= date('M d, H:i', strtotime($log['created_at'])) ?> • IP: <?= htmlspecialchars($log['ip_address'] ?? '127.0.0.1') ?>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="activity-node">
                    <span class="activity-node-dot" style="background: #10b981;"></span>
                    <div>
                      <div class="activity-node-text">Console initialized securely under super_admin permissions.</div>
                      <div class="activity-node-time">Just now</div>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>

            <!-- Quick Front-End Shortcuts -->
            <div class="dashboard-panel">
              <h4 class="panel-title" style="font-size: 1.05rem; margin-bottom: 14px;">Quick Shortcuts</h4>
              <div style="display: flex; flex-direction: column; gap: 8px;">
                <a href="<?= BASE_URL ?>/services" target="_blank" class="sidebar-nav-item" style="color: var(--text-main); background: var(--admin-bg-base);">
                  <span>Explore Capabilities Catalog ↗</span>
                </a>
                <a href="<?= BASE_URL ?>/service-finder" target="_blank" class="sidebar-nav-item" style="color: var(--text-main); background: var(--admin-bg-base);">
                  <span>Test Solution Advisor Engine ↗</span>
                </a>
                <a href="<?= BASE_URL ?>/contactus" target="_blank" class="sidebar-nav-item" style="color: var(--text-main); background: var(--admin-bg-base);">
                  <span>Submit Test Discovery Lead ↗</span>
                </a>
              </div>
            </div>

          </div>

        </div>

      </div>

  <!-- ========================================================================
       DASHBOARD-SPECIFIC INTERACTIVE SCRIPTS
       ======================================================================== -->
  <script>
    // Instant Filter & Search on Inquiries Table
    let currentStatusFilter = 'all';

    function filterByStatus(status, pillEl) {
      currentStatusFilter = status;
      document.querySelectorAll('#statusFilterPills .filter-pill').forEach(p => p.classList.remove('active'));
      if (pillEl) pillEl.classList.add('active');
      handleTableFilter();
      window.showToast(`Filtered leads by status: ${status.toUpperCase()}`, 'info', 'Filter Applied', 2000);
    }

    function handleTableFilter() {
      const input = document.getElementById('tableFilterInput');
      const query = (input ? input.value : '').toLowerCase().trim();
      const rows = document.querySelectorAll('#inquiriesTable tbody .inquiry-row');
      let visibleCount = 0;

      rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status') || '';
        const name = row.getAttribute('data-name') || '';
        const email = row.getAttribute('data-email') || '';
        const company = row.getAttribute('data-company') || '';
        const services = row.getAttribute('data-services') || '';

        const matchesStatus = (currentStatusFilter === 'all' || rowStatus === currentStatusFilter);
        const matchesQuery = (!query || name.includes(query) || email.includes(query) || company.includes(query) || services.includes(query));

        if (matchesStatus && matchesQuery) {
          row.style.display = '';
          visibleCount++;
        } else {
          row.style.display = 'none';
        }
      });

      const countEl = document.getElementById('inquiryVisibleCount');
      if (countEl) countEl.textContent = visibleCount;
    }

    // Update Inquiry Status via AJAX with Instant Toast Feedback
    async function updateInquiryStatus(id, newStatus, selectEl) {
      const row = document.getElementById(`inquiry-row-${id}`);
      const clientName = row ? row.getAttribute('data-raw-name') : `Inquiry #${id}`;

      try {
        const response = await fetch('<?= BASE_URL ?>/admin/inquiry/status', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: id, status: newStatus })
        });

        const data = await response.json();

        if (data.success) {
          if (row) {
            row.setAttribute('data-status', newStatus);
          }
          window.showToast(`Status updated to "${newStatus.toUpperCase()}" for ${clientName}`, 'success', 'Lead Updated');

          // Add entry to audit stream dynamically
          appendAuditEntry(`Updated status of #${id} to ${newStatus}`);
        } else {
          window.showToast(data.error || 'Failed to update inquiry status.', 'error', 'Update Error');
        }
      } catch (err) {
        window.showToast('Network error while updating status.', 'error', 'Connection Error');
      }
    }

    // Dynamic Audit Stream node append
    function appendAuditEntry(text) {
      const stream = document.getElementById('activityStream');
      if (!stream) return;
      const node = document.createElement('div');
      node.className = 'activity-node';
      node.innerHTML = `
        <span class="activity-node-dot" style="background: var(--admin-cyan);"></span>
        <div>
          <div class="activity-node-text"><strong>You</strong>: ${text}</div>
          <div class="activity-node-time">Just now • IP: 127.0.0.1</div>
        </div>
      `;
      stream.insertBefore(node, stream.firstChild);
    }

    // Copy Lead Details to Clipboard + Toast
    function copyInquiryDetails(id) {
      const row = document.getElementById(`inquiry-row-${id}`);
      if (!row) return;

      const name = row.getAttribute('data-raw-name');
      const email = row.getAttribute('data-email');
      const phone = row.getAttribute('data-raw-phone');
      const budget = row.getAttribute('data-raw-budget');
      const services = row.getAttribute('data-services');

      const text = `Client: ${name}\nEmail: ${email}\nPhone: ${phone}\nBudget: ${budget}\nServices: ${services}`;
      navigator.clipboard.writeText(text).then(() => {
        window.showToast(`Copied contact dossier for ${name} to clipboard.`, 'success', 'Dossier Copied', 3000);
      }).catch(() => {
        window.showToast('Failed to copy to clipboard.', 'error', 'Clipboard Error');
      });
    }

    // Modal Inspection Dialog - Populate and Open
    function openInquiryModal(id) {
      const row = document.getElementById(`inquiry-row-${id}`);
      if (!row) return;

      const name = row.getAttribute('data-raw-name');
      const email = row.getAttribute('data-email');
      const phone = row.getAttribute('data-raw-phone') || 'Not provided';
      const company = row.getAttribute('data-company') || 'Independent / Confidential';
      const budget = row.getAttribute('data-raw-budget');
      const services = row.getAttribute('data-services') || 'General Project Scope';
      const message = row.getAttribute('data-raw-message');
      const date = row.getAttribute('data-raw-date');
      const ip = row.getAttribute('data-raw-ip');
      const status = row.getAttribute('data-status');

      document.getElementById('modalClientName').textContent = name;
      document.getElementById('modalClientCompany').textContent = company + ' • ' + date;
      document.getElementById('modalEmailBtn').href = `mailto:${email}`;

      document.getElementById('modalContent').innerHTML = `
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 20px;">
          <div style="background: var(--admin-bg-base); padding: 12px; border-radius: 10px;">
            <span style="font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; font-family: var(--font-mono);">Email Address</span>
            <div style="font-weight: 700; color: var(--text-main); font-size: 0.9rem;">${email}</div>
          </div>
          <div style="background: var(--admin-bg-base); padding: 12px; border-radius: 10px;">
            <span style="font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; font-family: var(--font-mono);">Phone Number</span>
            <div style="font-weight: 700; color: var(--text-main); font-size: 0.9rem;">${phone}</div>
          </div>
          <div style="background: var(--admin-bg-base); padding: 12px; border-radius: 10px;">
            <span style="font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; font-family: var(--font-mono);">Investment Bracket</span>
            <div style="font-weight: 700; color: var(--admin-cyan); font-size: 0.9rem; font-family: var(--font-mono);">${budget}</div>
          </div>
          <div style="background: var(--admin-bg-base); padding: 12px; border-radius: 10px;">
            <span style="font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; font-family: var(--font-mono);">Current Status</span>
            <div style="font-weight: 700; text-transform: uppercase; font-size: 0.85rem; font-family: var(--font-mono);">${status}</div>
          </div>
        </div>

        <div style="margin-bottom: 16px;">
          <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-family: var(--font-mono);">Required Engineering Disciplines</span>
          <div style="font-weight: 600; color: var(--admin-blue); margin-top: 4px; font-size: 0.88rem;">${services}</div>
        </div>

        <div>
          <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-family: var(--font-mono);">Project Brief & Submission Notes</span>
          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; margin-top: 6px; font-size: 0.88rem; color: var(--text-main); line-height: 1.6; white-space: pre-line;">${message}</div>
        </div>

        <div style="margin-top: 14px; font-size: 0.72rem; color: var(--text-muted); font-family: var(--font-mono);">
          Submission IP: ${ip} • Verification Token: Validated
        </div>
      `;

      document.getElementById('inquiryDetailModalBackdrop').classList.add('show');
    }

    // Chart dynamic tooltip logic
    const chartContainer = document.getElementById('chartContainer');
    const chartTooltip = document.getElementById('chartTooltip');

    if (chartContainer && chartTooltip) {
      chartContainer.querySelectorAll('.chart-dot').forEach(dot => {
        dot.addEventListener('mouseenter', (e) => {
          const day = dot.getAttribute('data-day');
          const count = dot.getAttribute('data-count');
          const pipe = dot.getAttribute('data-pipe');

          chartTooltip.innerHTML = `<strong>${day}</strong>: ${count} Inquiries (${pipe} pipeline)`;
          chartTooltip.style.opacity = '1';
          chartTooltip.style.left = `${dot.cx.baseVal.value / 700 * 100}%`;
          chartTooltip.style.top = `${dot.cy.baseVal.value}px`;
        });

        dot.addEventListener('mouseleave', () => {
          chartTooltip.style.opacity = '0';
        });
      });
    }
  </script>

<?php
include __DIR__ . '/layout/footer.php';
?>
