<?php
/**
 * ClickCodex Technologies - Inquiries & Leads Management Console
 * Ultra-Premium Executive CRM for Lead Qualification, SLA Dispatch, and Pipeline Tracking.
 */
declare(strict_types=1);

$pageTitle = "Inquiries & Leads CRM | ClickCodex Studio Console";
$topbarTitle = "Inquiries & Leads CRM";
$activeNav = "inquiries";

$currentStatus = $filters['status'] ?? 'all';
$searchQuery = $filters['search'] ?? '';
$selectedService = $filters['service'] ?? 'all';
$selectedDate = $filters['date_range'] ?? 'all';
$selectedSort = $filters['sort'] ?? 'newest';

include __DIR__ . '/layout/header.php';
?>

      <!-- ========================================================================
           INQUIRIES & LEADS CRM CONSOLE
           ======================================================================== -->
      <div class="admin-content">

        <!-- Top Header & Actions Row -->
        <div class="crm-header-row">
          <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(0, 162, 255, 0.12); border: 1px solid rgba(0, 162, 255, 0.25); padding: 4px 12px; border-radius: 9999px; margin-bottom: 8px; font-family: var(--font-mono); font-size: 0.72rem; color: var(--admin-cyan); font-weight: 700;">
              <span class="topbar-dot-pulse"></span>
              <span>Enterprise Lead Intake & SLA Dispatch Active</span>
            </div>
            <h1 class="crm-header-title">Inquiries & Client Pipeline</h1>
            <p class="crm-header-subtitle">
              Qualify technical briefs, manage pipeline status, log CRM internal notes, and accelerate proposal dispatch under the 2-Hour SLA.
            </p>
          </div>

          <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <button type="button" class="welcome-btn primary" onclick="openAddLeadModal()">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
              <span>+ Log New Lead</span>
            </button>

            <a href="<?= BASE_URL ?>/admin/inquiries/export?<?= http_build_query($_GET) ?>" class="welcome-btn secondary" title="Export Current Filtered Dataset to CSV">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
              <span>Export CSV</span>
            </a>
          </div>
        </div>

        <!-- 5-Column CRM Metrics Bar -->
        <div class="crm-metrics-grid">
          <!-- Total Leads -->
          <div class="crm-metric-box">
            <div class="crm-metric-box-title">Total Leads Received</div>
            <div class="crm-metric-box-val"><?= (int)($crmStats['total'] ?? 0) ?></div>
            <div class="crm-metric-box-sub">
              <span>All acquisition channels</span>
            </div>
          </div>

          <!-- Pending Triage / New -->
          <div class="crm-metric-box orange">
            <div class="crm-metric-box-title">New / Pending Triage</div>
            <div class="crm-metric-box-val" style="color: var(--admin-orange);"><?= (int)($crmStats['new'] ?? 0) ?></div>
            <div class="crm-metric-box-sub">
              <span style="color: var(--admin-orange); font-weight: 700;">● High Priority</span>
              <span>• 2h SLA</span>
            </div>
          </div>

          <!-- In Review & Proposals -->
          <div class="crm-metric-box cyan">
            <div class="crm-metric-box-title">In Review & Quotes</div>
            <div class="crm-metric-box-val" style="color: var(--admin-cyan);">
              <?= (int)($crmStats['reviewing'] ?? 0) + (int)($crmStats['proposal_sent'] ?? 0) ?>
            </div>
            <div class="crm-metric-box-sub">
              <span><?= (int)($crmStats['proposal_sent'] ?? 0) ?> proposals sent</span>
            </div>
          </div>

          <!-- Closed Won -->
          <div class="crm-metric-box green">
            <div class="crm-metric-box-title">Deals Won / Contracted</div>
            <div class="crm-metric-box-val" style="color: #10b981;"><?= (int)($crmStats['closed_won'] ?? 0) ?></div>
            <div class="crm-metric-box-sub">
              <span style="color: #10b981; font-weight: 700;">✓ Active Retainers</span>
            </div>
          </div>

          <!-- Conversion Rate -->
          <div class="crm-metric-box purple">
            <div class="crm-metric-box-title">Conversion Velocity</div>
            <div class="crm-metric-box-val" style="color: #8b5cf6;"><?= htmlspecialchars((string)($crmStats['conversion_rate'] ?? '0%')) ?></div>
            <div class="crm-metric-box-sub">
              <span>Proposal-to-deal ratio</span>
            </div>
          </div>
        </div>

        <!-- Status Filter Tabs Navigation -->
        <div class="crm-tabs-bar">
          <a href="<?= BASE_URL ?>/admin/inquiries?status=all" class="crm-tab-btn <?= $currentStatus === 'all' ? 'active' : '' ?>">
            <span>All Leads</span>
            <span class="crm-tab-badge"><?= (int)($crmStats['total'] ?? 0) ?></span>
          </a>

          <a href="<?= BASE_URL ?>/admin/inquiries?status=new" class="crm-tab-btn orange <?= $currentStatus === 'new' ? 'active' : '' ?>">
            <span>New</span>
            <span class="crm-tab-badge" style="<?= $currentStatus === 'new' ? 'background: var(--admin-orange);' : '' ?>"><?= (int)($crmStats['new'] ?? 0) ?></span>
          </a>

          <a href="<?= BASE_URL ?>/admin/inquiries?status=reviewing" class="crm-tab-btn <?= $currentStatus === 'reviewing' ? 'active' : '' ?>">
            <span>In Review</span>
            <span class="crm-tab-badge"><?= (int)($crmStats['reviewing'] ?? 0) ?></span>
          </a>

          <a href="<?= BASE_URL ?>/admin/inquiries?status=contacted" class="crm-tab-btn <?= $currentStatus === 'contacted' ? 'active' : '' ?>">
            <span>Contacted</span>
            <span class="crm-tab-badge"><?= (int)($crmStats['contacted'] ?? 0) ?></span>
          </a>

          <a href="<?= BASE_URL ?>/admin/inquiries?status=proposal_sent" class="crm-tab-btn <?= $currentStatus === 'proposal_sent' ? 'active' : '' ?>">
            <span>Proposal Sent</span>
            <span class="crm-tab-badge"><?= (int)($crmStats['proposal_sent'] ?? 0) ?></span>
          </a>

          <a href="<?= BASE_URL ?>/admin/inquiries?status=closed_won" class="crm-tab-btn <?= $currentStatus === 'closed_won' ? 'active' : '' ?>">
            <span>Won</span>
            <span class="crm-tab-badge"><?= (int)($crmStats['closed_won'] ?? 0) ?></span>
          </a>

          <a href="<?= BASE_URL ?>/admin/inquiries?status=closed_lost" class="crm-tab-btn <?= $currentStatus === 'closed_lost' ? 'active' : '' ?>">
            <span>Lost</span>
            <span class="crm-tab-badge"><?= (int)($crmStats['closed_lost'] ?? 0) ?></span>
          </a>

          <a href="<?= BASE_URL ?>/admin/inquiries?status=spam" class="crm-tab-btn <?= $currentStatus === 'spam' ? 'active' : '' ?>">
            <span>Spam</span>
            <span class="crm-tab-badge"><?= (int)($crmStats['spam'] ?? 0) ?></span>
          </a>
        </div>

        <!-- Advanced Filter & Search Toolbar -->
        <form method="GET" action="<?= BASE_URL ?>/admin/inquiries" id="crmFilterForm" class="crm-toolbar">
          <input type="hidden" name="status" value="<?= htmlspecialchars($currentStatus) ?>" />

          <div class="crm-toolbar-left">
            <!-- Search input -->
            <div class="crm-search-input-wrap">
              <svg class="crm-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              <input type="text" name="search" id="crmSearchInput" class="crm-search-input" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Search client name, email, phone, company..." />
            </div>

            <!-- Service Filter -->
            <select name="service" class="crm-filter-select" onchange="document.getElementById('crmFilterForm').submit()">
              <option value="all" <?= $selectedService === 'all' ? 'selected' : '' ?>>All Disciplines</option>
              <option value="Web" <?= $selectedService === 'Web' ? 'selected' : '' ?>>Web Development</option>
              <option value="Mobile" <?= $selectedService === 'Mobile' ? 'selected' : '' ?>>Mobile Engineering</option>
              <option value="UI/UX" <?= $selectedService === 'UI/UX' ? 'selected' : '' ?>>UI/UX Architecture</option>
              <option value="AI" <?= $selectedService === 'AI' ? 'selected' : '' ?>>AI & Machine Learning</option>
              <option value="Cloud" <?= $selectedService === 'Cloud' ? 'selected' : '' ?>>Cloud & DevOps</option>
              <option value="Marketing" <?= $selectedService === 'Marketing' ? 'selected' : '' ?>>Digital Strategy</option>
            </select>

            <!-- Date Range Filter -->
            <select name="date_range" class="crm-filter-select" onchange="document.getElementById('crmFilterForm').submit()">
              <option value="all" <?= $selectedDate === 'all' ? 'selected' : '' ?>>All Timelines</option>
              <option value="today" <?= $selectedDate === 'today' ? 'selected' : '' ?>>Submitted Today</option>
              <option value="yesterday" <?= $selectedDate === 'yesterday' ? 'selected' : '' ?>>Yesterday</option>
              <option value="7days" <?= $selectedDate === '7days' ? 'selected' : '' ?>>Last 7 Days</option>
              <option value="30days" <?= $selectedDate === '30days' ? 'selected' : '' ?>>Last 30 Days</option>
              <option value="month" <?= $selectedDate === 'month' ? 'selected' : '' ?>>This Calendar Month</option>
            </select>

            <!-- Sort By -->
            <select name="sort" class="crm-filter-select" onchange="document.getElementById('crmFilterForm').submit()">
              <option value="newest" <?= $selectedSort === 'newest' ? 'selected' : '' ?>>Newest First</option>
              <option value="oldest" <?= $selectedSort === 'oldest' ? 'selected' : '' ?>>Oldest First</option>
              <option value="name" <?= $selectedSort === 'name' ? 'selected' : '' ?>>Client Name (A-Z)</option>
            </select>

            <?php if (!empty($searchQuery) || $selectedService !== 'all' || $selectedDate !== 'all' || $selectedSort !== 'newest'): ?>
              <a href="<?= BASE_URL ?>/admin/inquiries?status=<?= urlencode($currentStatus) ?>" style="font-size: 0.8rem; color: var(--admin-red); font-weight: 700; text-decoration: none; padding: 6px 10px;">
                ✕ Reset
              </a>
            <?php endif; ?>
          </div>

          <div class="crm-toolbar-right">
            <span style="font-family: var(--font-mono); font-size: 0.76rem; color: var(--text-muted);">
              Showing <strong><?= count($inquiries) ?></strong> records
            </span>
          </div>
        </form>

        <!-- Floating Bulk Action Bar (Visible when checkboxes checked) -->
        <div class="crm-bulk-bar" id="bulkActionBar">
          <div class="crm-bulk-left">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span><strong id="bulkSelectedCount">0</strong> leads selected</span>
          </div>

          <div class="crm-bulk-actions">
            <select id="bulkTargetStatus" class="crm-filter-select" style="background: #1e293b; color: #ffffff; border-color: #334155; padding: 6px 12px; font-size: 0.8rem;">
              <option value="">Move Status To...</option>
              <option value="new">● Mark as NEW</option>
              <option value="reviewing">● Mark as REVIEWING</option>
              <option value="contacted">● Mark as CONTACTED</option>
              <option value="proposal_sent">● Mark as PROPOSAL SENT</option>
              <option value="closed_won">● Mark as CLOSED WON</option>
              <option value="closed_lost">● Mark as CLOSED LOST</option>
              <option value="spam">● Mark as SPAM</option>
            </select>

            <button type="button" class="welcome-btn primary" onclick="applyBulkStatus()" style="padding: 6px 14px; font-size: 0.8rem;">
              Apply Status
            </button>

            <button type="button" class="welcome-btn danger" onclick="applyBulkDelete()" style="padding: 6px 14px; font-size: 0.8rem; background: var(--admin-red); border: none;">
              Delete Selected
            </button>

            <button type="button" onclick="clearBulkSelection()" style="background: transparent; border: none; color: #94a3b8; font-size: 0.75rem; cursor: pointer; padding: 4px 8px;">
              Cancel
            </button>
          </div>
        </div>

        <!-- Main Leads CRM Table Card -->
        <div class="dashboard-panel" style="padding: 0; overflow: hidden;">
          <?php if (!empty($inquiries)): ?>
            <div class="admin-table-wrap">
              <table class="admin-table" id="crmLeadsTable">
                <thead>
                  <tr>
                    <th style="width: 40px; text-align: center;">
                      <input type="checkbox" id="masterCheckbox" onclick="toggleSelectAll(this)" style="cursor: pointer;" title="Select all rows" />
                    </th>
                    <th>Client Dossier</th>
                    <th>Disciplines & Scope</th>
                    <th>Timeline & SLA</th>
                    <th>Current Status</th>
                    <th style="text-align: right;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($inquiries as $lead): ?>
                    <tr class="inquiry-row" id="lead-row-<?= (int)$lead['id'] ?>">
                      <!-- Checkbox -->
                      <td style="text-align: center;">
                        <input type="checkbox" class="lead-checkbox" value="<?= (int)$lead['id'] ?>" onchange="updateBulkBar()" style="cursor: pointer;" />
                      </td>

                      <!-- Client Dossier -->
                      <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                          <div class="lead-avatar-badge">
                            <?= htmlspecialchars($lead['initials'] ?? 'CL') ?>
                          </div>
                          <div>
                            <div style="font-weight: 700; color: var(--text-main); font-size: 0.94rem;">
                              <?= htmlspecialchars($lead['full_name']) ?>
                            </div>
                            <div style="font-size: 0.78rem; color: var(--text-muted); display: flex; align-items: center; gap: 6px;">
                              <span><?= htmlspecialchars($lead['email']) ?></span>
                            </div>
                            <?php if (!empty($lead['company_name'])): ?>
                              <span style="font-size: 0.74rem; color: var(--admin-blue); font-weight: 700; display: block;">
                                <?= htmlspecialchars($lead['company_name']) ?>
                              </span>
                            <?php endif; ?>

                            <?php if (!empty($lead['internal_notes'])): ?>
                              <div class="crm-note-indicator" onclick="openDossierModal(<?= (int)$lead['id'] ?>)" title="Click to view internal notes">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                <span>Note attached</span>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                      </td>

                      <!-- Disciplines & Scope -->
                      <td>
                        <?php if (!empty($lead['services_list'])): ?>
                          <div style="display: flex; flex-wrap: wrap; gap: 4px; max-width: 280px;">
                            <?php foreach ($lead['services_list'] as $srv): ?>
                              <span style="background: rgba(0, 86, 214, 0.08); color: var(--admin-blue); font-size: 0.72rem; padding: 2px 8px; border-radius: 4px; font-weight: 600;">
                                <?= htmlspecialchars($srv) ?>
                              </span>
                            <?php endforeach; ?>
                          </div>
                        <?php else: ?>
                          <span style="font-size: 0.8rem; color: var(--text-muted);">Standard Discovery Scope</span>
                        <?php endif; ?>

                        <?php if (!empty($lead['message'])): ?>
                          <div style="font-size: 0.76rem; color: var(--text-muted); margin-top: 4px; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?= htmlspecialchars($lead['message']) ?>
                          </div>
                        <?php endif; ?>
                      </td>

                      <!-- Timeline & SLA -->
                      <td>
                        <div style="font-family: var(--font-mono); font-size: 0.76rem; color: var(--text-main); font-weight: 700;">
                          <?= date('M d, Y', strtotime($lead['created_at'])) ?>
                        </div>
                        <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 2px;">
                          <?= htmlspecialchars($lead['time_ago'] ?? '') ?> • <span style="color: var(--admin-cyan);">2h SLA Active</span>
                        </div>
                      </td>

                      <!-- Current Status Dropdown -->
                      <td>
                        <select class="status-select-btn" onchange="quickUpdateStatus(<?= (int)$lead['id'] ?>, this.value, this)" title="Update pipeline status">
                          <option value="new" <?= $lead['status'] === 'new' ? 'selected' : '' ?>>● NEW</option>
                          <option value="reviewing" <?= $lead['status'] === 'reviewing' ? 'selected' : '' ?>>● REVIEWING</option>
                          <option value="contacted" <?= $lead['status'] === 'contacted' ? 'selected' : '' ?>>● CONTACTED</option>
                          <option value="proposal_sent" <?= $lead['status'] === 'proposal_sent' ? 'selected' : '' ?>>● PROPOSAL SENT</option>
                          <option value="closed_won" <?= $lead['status'] === 'closed_won' ? 'selected' : '' ?>>● WON</option>
                          <option value="closed_lost" <?= $lead['status'] === 'closed_lost' ? 'selected' : '' ?>>● LOST</option>
                          <option value="spam" <?= $lead['status'] === 'spam' ? 'selected' : '' ?>>● SPAM</option>
                        </select>
                      </td>

                      <!-- Quick Actions -->
                      <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 6px; align-items: center;">
                          <!-- Inspect Full Dossier -->
                          <button type="button" class="crm-micro-btn" onclick="openDossierModal(<?= (int)$lead['id'] ?>)" title="View Complete Dossier & Notes">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                          </button>

                          <!-- WhatsApp Chat -->
                          <?php if (!empty($lead['phone'])): ?>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $lead['phone']) ?>?text=<?= urlencode('Hello ' . $lead['full_name'] . ', thank you for reaching out to ClickCodex Technologies!') ?>" target="_blank" class="crm-micro-btn whatsapp" title="Chat WhatsApp">
                              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            </a>
                          <?php endif; ?>

                          <!-- Email -->
                          <a href="mailto:<?= htmlspecialchars($lead['email']) ?>?subject=<?= urlencode('ClickCodex Proposal Discovery • ' . $lead['full_name']) ?>" class="crm-micro-btn" title="Email Lead">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                          </a>

                          <!-- Copy Lead Info -->
                          <button type="button" class="crm-micro-btn" onclick="copyLeadSummary(<?= (int)$lead['id'] ?>)" title="Copy Dossier to Clipboard">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                          </button>

                          <!-- Delete -->
                          <button type="button" class="crm-micro-btn danger" onclick="confirmDeleteLead(<?= (int)$lead['id'] ?>, '<?= htmlspecialchars(addslashes($lead['full_name'])) ?>')" title="Remove Lead">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div style="padding: 60px 20px; text-align: center;">
              <div style="width: 56px; height: 56px; border-radius: 50%; background: #f1f5f9; display: inline-flex; align-items: center; justify-content: center; color: #94a3b8; margin-bottom: 16px;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              </div>
              <h3 style="font-family: var(--font-display); font-size: 1.15rem; color: var(--text-main); font-weight: 700; margin-bottom: 6px;">No Leads Found</h3>
              <p style="font-size: 0.86rem; color: var(--text-muted); max-width: 440px; margin: 0 auto 20px;">
                No client inquiries matched your selected status, search parameters, or date filters.
              </p>
              <a href="<?= BASE_URL ?>/admin/inquiries" class="welcome-btn secondary" style="display: inline-flex;">
                Clear Active Filters
              </a>
            </div>
          <?php endif; ?>
        </div>

      </div>

  <!-- ========================================================================
       MODAL 1: COMPLETE LEAD DOSSIER & INTERNAL CRM NOTES
       ======================================================================== -->
  <div class="admin-modal-backdrop" id="dossierModalBackdrop">
    <div class="admin-modal" style="max-width: 680px;">
      <div class="admin-modal-header">
        <div>
          <h3 class="admin-modal-title" id="dossierClientName">Lead Dossier</h3>
          <span style="font-size: 0.78rem; color: var(--text-muted);" id="dossierSubheading">ClickCodex Technical Intake</span>
        </div>
        <button type="button" class="toast-close-btn" onclick="closeDossierModal()" aria-label="Close dialog">&times;</button>
      </div>

      <div class="admin-modal-body" id="dossierModalBody">
        <!-- Contact & Telemetry Cards -->
        <div class="crm-modal-grid">
          <div class="crm-modal-card">
            <div class="crm-modal-card-label">Email Address</div>
            <div class="crm-modal-card-val" id="dossierEmail">-</div>
          </div>
          <div class="crm-modal-card">
            <div class="crm-modal-card-label">Phone Number</div>
            <div class="crm-modal-card-val" id="dossierPhone">-</div>
          </div>
          <div class="crm-modal-card">
            <div class="crm-modal-card-label">Company / Organization</div>
            <div class="crm-modal-card-val" id="dossierCompany">-</div>
          </div>
          <div class="crm-modal-card">
            <div class="crm-modal-card-label">Investment Bracket</div>
            <div class="crm-modal-card-val" style="color: var(--admin-cyan); font-family: var(--font-mono);" id="dossierBudget">-</div>
          </div>
        </div>

        <!-- Scope & Disciplines -->
        <div style="margin-bottom: 16px;">
          <div class="crm-modal-card-label">Requested Engineering Disciplines</div>
          <div id="dossierServices" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px;"></div>
        </div>

        <!-- Full Project Brief -->
        <div style="margin-bottom: 20px;">
          <div class="crm-modal-card-label">Client Technical Brief & Requirements</div>
          <div id="dossierMessage" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; margin-top: 6px; font-size: 0.88rem; color: var(--text-main); line-height: 1.6; white-space: pre-line; max-height: 180px; overflow-y: auto;">
          </div>
        </div>

        <!-- Internal CRM Notes -->
        <div style="background: #faf5ff; border: 1px solid #e9d5ff; border-radius: 12px; padding: 16px;">
          <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
            <div style="font-family: var(--font-display); font-size: 0.86rem; font-weight: 700; color: #7e22ce; display: flex; align-items: center; gap: 6px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
              <span>Internal CRM Notes & Team Comments</span>
            </div>
            <span style="font-size: 0.7rem; color: #a855f7;">Private to ClickCodex Admins</span>
          </div>

          <textarea id="dossierNotesInput" class="crm-notes-textarea" placeholder="Record discovery call notes, technical blockers, negotiated milestones, or assigned architects..."></textarea>

          <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
            <button type="button" class="welcome-btn primary" onclick="saveCurrentDossierNotes()" style="padding: 7px 16px; font-size: 0.8rem; background: #9333ea;">
              Save Internal Notes
            </button>
          </div>
        </div>

        <div style="margin-top: 14px; font-size: 0.72rem; color: var(--text-muted); font-family: var(--font-mono);" id="dossierFooterMeta">
          IP: 127.0.0.1 • Lead Origin: Validated
        </div>
      </div>

      <div class="admin-modal-footer">
        <div style="display: flex; align-items: center; gap: 8px;">
          <a href="#" id="dossierWhatsAppBtn" target="_blank" class="welcome-btn secondary" style="color: #059669; border-color: #a7f3d0; background: #ecfdf5;">
            WhatsApp
          </a>
          <a href="#" id="dossierMailBtn" class="welcome-btn secondary">
            Email
          </a>
        </div>
        <button type="button" class="welcome-btn secondary" onclick="closeDossierModal()" style="border: 1px solid #cbd5e1;">Close</button>
      </div>
    </div>
  </div>

  <!-- ========================================================================
       MODAL 2: MANUAL "+ LOG NEW LEAD" CRM ENTRY
       ======================================================================== -->
  <div class="admin-modal-backdrop" id="addLeadModalBackdrop">
    <div class="admin-modal" style="max-width: 620px;">
      <div class="admin-modal-header">
        <div>
          <h3 class="admin-modal-title">Log New Client Lead</h3>
          <span style="font-size: 0.78rem; color: var(--text-muted);">Direct phone call, LinkedIn DM, or partner referral intake</span>
        </div>
        <button type="button" class="toast-close-btn" onclick="closeAddLeadModal()" aria-label="Close dialog">&times;</button>
      </div>

      <form id="addLeadForm" onsubmit="submitManualLead(event)">
        <div class="admin-modal-body">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
            <div class="crm-form-group">
              <label for="addLeadName">Full Name *</label>
              <input type="text" id="addLeadName" name="full_name" class="crm-form-input" required placeholder="e.g. Vikram Singhania" />
            </div>
            <div class="crm-form-group">
              <label for="addLeadEmail">Email Address *</label>
              <input type="email" id="addLeadEmail" name="email" class="crm-form-input" required placeholder="vikram@enterprise.com" />
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
            <div class="crm-form-group">
              <label for="addLeadPhone">Phone / WhatsApp</label>
              <input type="text" id="addLeadPhone" name="phone" class="crm-form-input" placeholder="+91 98765 43210" />
            </div>
            <div class="crm-form-group">
              <label for="addLeadCompany">Company / Brand</label>
              <input type="text" id="addLeadCompany" name="company_name" class="crm-form-input" placeholder="e.g. Singhania Ventures" />
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
            <div class="crm-form-group">
              <label for="addLeadBudget">Investment Bracket</label>
              <select id="addLeadBudget" name="budget_bracket" class="crm-form-input">
                <option value="₹50,000 - ₹1,50,000">₹50,000 - ₹1.5L (Sprint Prototype)</option>
                <option value="₹1.5L - ₹5L">₹1.5L - ₹5L (Production MVP)</option>
                <option value="₹5L - ₹15L">₹5L - ₹15L (Enterprise Scale)</option>
                <option value="₹15L+">₹15L+ (Custom Architecture)</option>
              </select>
            </div>
            <div class="crm-form-group">
              <label for="addLeadStatus">Initial Pipeline Status</label>
              <select id="addLeadStatus" name="status" class="crm-form-input">
                <option value="new">● NEW</option>
                <option value="reviewing">● REVIEWING</option>
                <option value="contacted">● CONTACTED</option>
                <option value="proposal_sent">● PROPOSAL SENT</option>
              </select>
            </div>
          </div>

          <div class="crm-form-group">
            <label>Required Engineering Disciplines</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 8px;">
              <label style="display: flex; align-items: center; gap: 6px; font-weight: normal; font-size: 0.82rem; cursor: pointer;">
                <input type="checkbox" name="services[]" value="Custom Web Development" checked /> Web Engineering
              </label>
              <label style="display: flex; align-items: center; gap: 6px; font-weight: normal; font-size: 0.82rem; cursor: pointer;">
                <input type="checkbox" name="services[]" value="Mobile Apps (iOS/Android)" /> Mobile Apps
              </label>
              <label style="display: flex; align-items: center; gap: 6px; font-weight: normal; font-size: 0.82rem; cursor: pointer;">
                <input type="checkbox" name="services[]" value="AI & Machine Learning" /> AI / Automation
              </label>
              <label style="display: flex; align-items: center; gap: 6px; font-weight: normal; font-size: 0.82rem; cursor: pointer;">
                <input type="checkbox" name="services[]" value="UI/UX Architecture" /> UI/UX Architecture
              </label>
            </div>
          </div>

          <div class="crm-form-group">
            <label for="addLeadMessage">Project Brief & Discovery Notes</label>
            <textarea id="addLeadMessage" name="message" class="crm-notes-textarea" style="min-height: 80px;" placeholder="Summary of client's requirements, target timeline, or tech stack..."></textarea>
          </div>
        </div>

        <div class="admin-modal-footer">
          <button type="button" class="welcome-btn secondary" onclick="closeAddLeadModal()" style="border: 1px solid #cbd5e1;">Cancel</button>
          <button type="submit" class="welcome-btn primary">Save & Register Lead</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ========================================================================
       CLIENT CRM LOGIC & AJAX CONTROLLER
       ======================================================================== -->
  <script>
    let activeDossierId = null;

    // Quick Update Lead Status via AJAX
    async function quickUpdateStatus(id, newStatus, selectEl) {
      const row = document.getElementById(`lead-row-${id}`);
      window.showToast(`Updating status of lead #${id} to ${newStatus.toUpperCase()}...`, 'info', 'Updating Pipeline');

      try {
        const res = await fetch('<?= BASE_URL ?>/admin/inquiry/status', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: id, status: newStatus })
        });
        const data = await res.json();

        if (data.success) {
          window.showToast(data.message || `Lead #${id} status updated.`, 'success', 'Status Changed');
        } else {
          window.showToast(data.error || 'Failed to update status.', 'error', 'Error');
        }
      } catch (e) {
        window.showToast('Network error while updating pipeline status.', 'error', 'Network Error');
      }
    }

    // Open Full Lead Dossier Modal
    async function openDossierModal(id) {
      activeDossierId = id;
      window.showToast(`Loading lead dossier #${id}...`, 'info', 'Loading Record', 1500);

      try {
        const res = await fetch(`<?= BASE_URL ?>/admin/inquiry/detail?id=${id}`);
        const data = await res.json();

        if (data.success && data.inquiry) {
          const inq = data.inquiry;
          document.getElementById('dossierClientName').textContent = inq.full_name || 'Client Lead';
          document.getElementById('dossierSubheading').textContent = (inq.company_name || 'Independent Client') + ' • Created on ' + inq.created_at;

          document.getElementById('dossierEmail').textContent = inq.email || 'N/A';
          document.getElementById('dossierPhone').textContent = inq.phone || 'N/A';
          document.getElementById('dossierCompany').textContent = inq.company_name || 'Independent / Direct';
          document.getElementById('dossierBudget').textContent = inq.budget_bracket || 'Custom Scope';

          // Services tags
          const srvContainer = document.getElementById('dossierServices');
          srvContainer.innerHTML = '';
          if (inq.services_list && inq.services_list.length > 0) {
            inq.services_list.forEach(s => {
              const pill = document.createElement('span');
              pill.style.cssText = 'background: rgba(0, 86, 214, 0.08); color: var(--admin-blue); font-size: 0.74rem; padding: 3px 9px; border-radius: 6px; font-weight: 700;';
              pill.textContent = s;
              srvContainer.appendChild(pill);
            });
          } else {
            srvContainer.innerHTML = '<span style="font-size: 0.8rem; color: var(--text-muted);">Standard General Scope</span>';
          }

          // Message
          document.getElementById('dossierMessage').textContent = inq.message || 'No project description submitted.';

          // Notes
          document.getElementById('dossierNotesInput').value = inq.internal_notes || '';

          // Meta
          document.getElementById('dossierFooterMeta').textContent = `Submission IP: ${inq.ip_address || '127.0.0.1'} • Source: ${inq.inquiry_type || 'Discovery Form'}`;

          // Quick Action links
          const waPhone = (inq.phone || '').replace(/[^0-9]/g, '');
          document.getElementById('dossierWhatsAppBtn').href = waPhone ? `https://wa.me/${waPhone}` : '#';
          document.getElementById('dossierWhatsAppBtn').style.display = waPhone ? 'inline-flex' : 'none';
          document.getElementById('dossierMailBtn').href = `mailto:${inq.email}?subject=ClickCodex Technical Proposal Discovery`;

          document.getElementById('dossierModalBackdrop').classList.add('show');
        } else {
          window.showToast('Could not fetch lead dossier details.', 'error', 'Error');
        }
      } catch (err) {
        window.showToast('Network error loading dossier.', 'error', 'Error');
      }
    }

    function closeDossierModal() {
      document.getElementById('dossierModalBackdrop').classList.remove('show');
      activeDossierId = null;
    }

    // Save Internal CRM Notes from Modal
    async function saveCurrentDossierNotes() {
      if (!activeDossierId) return;
      const notes = document.getElementById('dossierNotesInput').value;

      try {
        const res = await fetch('<?= BASE_URL ?>/admin/inquiry/notes', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: activeDossierId, notes: notes })
        });
        const data = await res.json();
        if (data.success) {
          window.showToast(data.message, 'success', 'Notes Saved');
        } else {
          window.showToast(data.error || 'Failed to save notes.', 'error', 'Error');
        }
      } catch (e) {
        window.showToast('Error saving notes.', 'error', 'Network Error');
      }
    }

    // Add Lead Modal handlers
    function openAddLeadModal() {
      document.getElementById('addLeadForm').reset();
      document.getElementById('addLeadModalBackdrop').classList.add('show');
    }

    function closeAddLeadModal() {
      document.getElementById('addLeadModalBackdrop').classList.remove('show');
    }

    // Submit Manual Lead Form
    async function submitManualLead(e) {
      e.preventDefault();
      const form = document.getElementById('addLeadForm');
      const formData = new FormData(form);

      const payload = {
        full_name: formData.get('full_name'),
        email: formData.get('email'),
        phone: formData.get('phone'),
        company_name: formData.get('company_name'),
        budget_bracket: formData.get('budget_bracket'),
        status: formData.get('status'),
        message: formData.get('message'),
        services: formData.getAll('services[]')
      };

      try {
        const res = await fetch('<?= BASE_URL ?>/admin/inquiry/create', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const data = await res.json();

        if (data.success) {
          window.showToast(data.message, 'success', 'Lead Created');
          closeAddLeadModal();
          setTimeout(() => location.reload(), 1200);
        } else {
          window.showToast(data.error || 'Failed to log lead.', 'error', 'Error');
        }
      } catch (err) {
        window.showToast('Network error registering lead.', 'error', 'Error');
      }
    }

    // Delete single lead
    async function confirmDeleteLead(id, name) {
      if (!confirm(`Are you sure you want to permanently delete lead #${id} (${name})?`)) {
        return;
      }

      try {
        const res = await fetch('<?= BASE_URL ?>/admin/inquiry/delete', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: id })
        });
        const data = await res.json();

        if (data.success) {
          const row = document.getElementById(`lead-row-${id}`);
          if (row) {
            row.style.opacity = '0';
            setTimeout(() => row.remove(), 300);
          }
          window.showToast(data.message, 'success', 'Lead Removed');
        } else {
          window.showToast(data.error || 'Failed to delete lead.', 'error', 'Error');
        }
      } catch (e) {
        window.showToast('Network error while deleting lead.', 'error', 'Error');
      }
    }

    // Copy Lead Summary
    function copyLeadSummary(id) {
      const row = document.getElementById(`lead-row-${id}`);
      if (!row) return;

      const name = row.querySelector('.crm-modal-card-val, strong')?.textContent || `Lead #${id}`;
      const text = `ClickCodex Lead #${id}\nClient: ${name}\nDashboard URL: ${window.location.origin}<?= BASE_URL ?>/admin/inquiries?search=${encodeURIComponent(name)}`;

      navigator.clipboard.writeText(text).then(() => {
        window.showToast(`Copied dossier link for ${name} to clipboard.`, 'success', 'Copied', 2500);
      }).catch(() => {
        window.showToast('Could not copy to clipboard.', 'warning', 'Clipboard');
      });
    }

    // Checkbox & Bulk Actions Logic
    function toggleSelectAll(master) {
      const checkboxes = document.querySelectorAll('.lead-checkbox');
      checkboxes.forEach(cb => cb.checked = master.checked);
      updateBulkBar();
    }

    function updateBulkBar() {
      const selected = document.querySelectorAll('.lead-checkbox:checked');
      const count = selected.length;
      const bar = document.getElementById('bulkActionBar');
      const countEl = document.getElementById('bulkSelectedCount');

      if (count > 0) {
        countEl.textContent = count;
        bar.classList.add('show');
      } else {
        bar.classList.remove('show');
        const master = document.getElementById('masterCheckbox');
        if (master) master.checked = false;
      }
    }

    function clearBulkSelection() {
      document.querySelectorAll('.lead-checkbox').forEach(cb => cb.checked = false);
      const master = document.getElementById('masterCheckbox');
      if (master) master.checked = false;
      updateBulkBar();
    }

    function getSelectedLeadIds() {
      const ids = [];
      document.querySelectorAll('.lead-checkbox:checked').forEach(cb => ids.push(parseInt(cb.value)));
      return ids;
    }

    async function applyBulkStatus() {
      const ids = getSelectedLeadIds();
      const status = document.getElementById('bulkTargetStatus').value;
      if (!status) {
        window.showToast('Please select a target status from the dropdown.', 'warning', 'Select Status');
        return;
      }

      window.showToast(`Updating ${ids.length} leads to ${status.toUpperCase()}...`, 'info', 'Bulk Update');

      try {
        const res = await fetch('<?= BASE_URL ?>/admin/inquiry/bulk', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ ids: ids, action: 'status', value: status })
        });
        const data = await res.json();
        if (data.success) {
          window.showToast(data.message, 'success', 'Bulk Updated');
          setTimeout(() => location.reload(), 1000);
        } else {
          window.showToast(data.error || 'Failed bulk update.', 'error', 'Error');
        }
      } catch (e) {
        window.showToast('Error during bulk operation.', 'error', 'Error');
      }
    }

    async function applyBulkDelete() {
      const ids = getSelectedLeadIds();
      if (!confirm(`Are you sure you want to permanently delete these ${ids.length} leads? This action is irreversible.`)) {
        return;
      }

      try {
        const res = await fetch('<?= BASE_URL ?>/admin/inquiry/bulk', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ ids: ids, action: 'delete' })
        });
        const data = await res.json();
        if (data.success) {
          window.showToast(data.message, 'success', 'Deleted');
          setTimeout(() => location.reload(), 1000);
        } else {
          window.showToast(data.error || 'Failed bulk deletion.', 'error', 'Error');
        }
      } catch (e) {
        window.showToast('Network error during bulk delete.', 'error', 'Error');
      }
    }
  </script>

<?php
include __DIR__ . '/layout/footer.php';
?>
