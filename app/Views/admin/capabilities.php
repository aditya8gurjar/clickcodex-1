<?php
/**
 * ClickCodex Technologies - Admin Capabilities & Services Console
 * Complete executive management for agency capabilities, pricing models, and public tech dossiers.
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

$pageTitle = $pageTitle ?? 'Capabilities & Services Architecture | ClickCodex Studio Console';
$topbarTitle = 'Capabilities & Services Architecture';
$activeNav = 'capabilities';

include __DIR__ . '/layout/header.php';
?>

<!-- ========================================================================
     CAPABILITIES CONSOLE MAIN VIEWPORT
     ======================================================================== -->
<div class="admin-content">

  <!-- Flash Alerts -->
  <?php if (!empty($flashSuccess)): ?>
    <div class="admin-alert success" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #065f46; font-weight: 600;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
      <span><?= htmlspecialchars($flashSuccess) ?></span>
    </div>
  <?php endif; ?>

  <?php if (!empty($flashError)): ?>
    <div class="admin-alert error" style="background: rgba(220, 38, 38, 0.1); border: 1px solid rgba(220, 38, 38, 0.3); color: #991b1b; font-weight: 600;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
      <span><?= htmlspecialchars($flashError) ?></span>
    </div>
  <?php endif; ?>

  <!-- Page Header Row -->
  <div class="crm-header-row">
    <div>
      <h1 class="crm-header-title">Capabilities & Services Architecture</h1>
      <p class="crm-header-subtitle">
        Manage enterprise service offerings, sprint commercials, tech stack matrices, and customer-facing service dossiers.
      </p>
    </div>

    <!-- Executive Action Buttons -->
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
      <a href="<?= BASE_URL ?>/services" target="_blank" class="welcome-btn secondary" style="background: #ffffff; color: var(--text-main); border: 1px solid #cbd5e1;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
        <span>Live Services Page</span>
      </a>

      <a href="<?= BASE_URL ?>/admin/capabilities/export" class="welcome-btn secondary" style="background: #ffffff; color: var(--text-main); border: 1px solid #cbd5e1;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
        <span>Export CSV</span>
      </a>

      <button type="button" class="welcome-btn primary" onclick="openCreateCapabilityModal()">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        <span>+ Add New Capability</span>
      </button>
    </div>
  </div>

  <!-- 5 Executive Metric Cards Grid -->
  <div class="crm-metrics-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
    <!-- Total Capabilities -->
    <div class="crm-metric-box">
      <div class="crm-metric-box-title">Total Offerings</div>
      <div class="crm-metric-box-val" id="metricTotalCaps"><?= (int)($capStats['total'] ?? 0) ?></div>
      <div class="crm-metric-box-sub">
        <span style="color: var(--admin-blue); font-weight: 700;">Full Portfolio</span>
      </div>
    </div>

    <!-- Active Live Capabilities -->
    <div class="crm-metric-box green">
      <div class="crm-metric-box-title">Active & Public</div>
      <div class="crm-metric-box-val" id="metricActiveCaps" style="color: #059669;"><?= (int)($capStats['active'] ?? 0) ?></div>
      <div class="crm-metric-box-sub">
        <span style="color: #059669; font-weight: 700;">Published on Site</span>
      </div>
    </div>

    <!-- Featured Flagships -->
    <div class="crm-metric-box cyan">
      <div class="crm-metric-box-title">Featured Flagships</div>
      <div class="crm-metric-box-val" id="metricFeaturedCaps" style="color: var(--admin-cyan);"><?= (int)($capStats['featured'] ?? 0) ?></div>
      <div class="crm-metric-box-sub">
        <span>Hero & Nav Showcased</span>
      </div>
    </div>

    <!-- Categories Configured -->
    <div class="crm-metric-box purple">
      <div class="crm-metric-box-title">Domain Categories</div>
      <div class="crm-metric-box-val" id="metricCategoriesCount" style="color: #7c3aed;"><?= (int)($capStats['categories'] ?? 0) ?></div>
      <div class="crm-metric-box-sub">
        <span>Web, Mobile, AI & Talent</span>
      </div>
    </div>

    <!-- Avg Starting Price -->
    <div class="crm-metric-box orange">
      <div class="crm-metric-box-title">Avg Starting Sprint</div>
      <div class="crm-metric-box-val" style="color: var(--admin-orange); font-size: 1.6rem;">
        ₹<?= number_format((float)($capStats['avg_price_inr'] ?? 0) / 1000, 1) ?>k
      </div>
      <div class="crm-metric-box-sub">
        <span>INR Base Baseline</span>
      </div>
    </div>
  </div>

  <!-- Category Filter Tabs Bar -->
  <div class="crm-tabs-bar">
    <a href="?category=all" class="crm-tab-btn <?= empty($_GET['category']) || $_GET['category'] === 'all' ? 'active' : '' ?>">
      <span>All Capabilities</span>
      <span class="crm-tab-badge"><?= (int)($capStats['total'] ?? 0) ?></span>
    </a>
    <?php foreach ($categories as $cat): ?>
      <?php 
        $isActiveTab = (isset($_GET['category']) && (string)$_GET['category'] === (string)$cat['slug']) 
                    || (isset($_GET['category']) && (string)$_GET['category'] === (string)$cat['id']);
      ?>
      <a href="?category=<?= urlencode((string)$cat['slug']) ?>" class="crm-tab-btn <?= $isActiveTab ? 'active' : '' ?>">
        <span><?= htmlspecialchars((string)$cat['name']) ?></span>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- Advanced Toolbar: Search & Facet Filters -->
  <div class="crm-toolbar">
    <div class="crm-toolbar-left">
      <!-- Search Input -->
      <div class="crm-search-input-wrap">
        <svg class="crm-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" id="capSearchInput" class="crm-search-input" placeholder="Search by title, service code, tech stack..." value="<?= htmlspecialchars((string)($_GET['search'] ?? '')) ?>" onkeyup="handleCapSearch(event)" />
      </div>

      <!-- Category Dropdown -->
      <select id="filterCategorySelect" class="crm-filter-select" onchange="applyCapFilters()">
        <option value="all">All Domains</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= htmlspecialchars((string)$cat['slug']) ?>" <?= (($_GET['category'] ?? '') === (string)$cat['slug']) ? 'selected' : '' ?>>
            <?= htmlspecialchars((string)$cat['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <!-- Status Dropdown -->
      <select id="filterStatusSelect" class="crm-filter-select" onchange="applyCapFilters()">
        <option value="all">All Statuses</option>
        <option value="active" <?= (($_GET['status'] ?? '') === 'active') ? 'selected' : '' ?>>Active (Published)</option>
        <option value="inactive" <?= (($_GET['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Inactive (Draft)</option>
      </select>

      <!-- Featured Dropdown -->
      <select id="filterFeaturedSelect" class="crm-filter-select" onchange="applyCapFilters()">
        <option value="all">All Tiers</option>
        <option value="featured" <?= (($_GET['featured'] ?? '') === 'featured') ? 'selected' : '' ?>>Featured Flagships</option>
        <option value="standard" <?= (($_GET['featured'] ?? '') === 'standard') ? 'selected' : '' ?>>Standard Capabilities</option>
      </select>

      <?php if (!empty($_GET['search']) || (!empty($_GET['category']) && $_GET['category'] !== 'all') || (!empty($_GET['status']) && $_GET['status'] !== 'all') || (!empty($_GET['featured']) && $_GET['featured'] !== 'all')): ?>
        <a href="<?= BASE_URL ?>/admin/capabilities" style="font-size: 0.78rem; color: var(--admin-red); font-weight: 700; text-decoration: underline; margin-left: 6px;">
          Reset Filters
        </a>
      <?php endif; ?>
    </div>

    <!-- Right Summary Count -->
    <div class="crm-toolbar-right">
      <span style="font-size: 0.8rem; color: var(--text-muted); font-family: var(--font-mono);">
        Showing <strong style="color: var(--text-main);" id="renderedCount"><?= count($capabilities) ?></strong> capabilities
      </span>
    </div>
  </div>

  <!-- Capabilities Master Table Container -->
  <div class="dashboard-panel" style="padding: 0; overflow: hidden;">
    <div class="admin-table-wrap">
      <table class="admin-table" id="capabilitiesTable">
        <thead>
          <tr>
            <th style="width: 50px; text-align: center;">Order</th>
            <th style="min-width: 260px;">Capability & Domain</th>
            <th style="min-width: 140px;">Pricing & Model</th>
            <th style="min-width: 120px;">Timeline</th>
            <th style="min-width: 220px;">Tech Stack Matrix</th>
            <th style="width: 110px; text-align: center;">Featured</th>
            <th style="width: 110px; text-align: center;">Status</th>
            <th style="width: 140px; text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody id="capabilitiesTableBody">
          <?php if (empty($capabilities)): ?>
            <tr>
              <td colspan="8" style="text-align: center; padding: 48px 24px; color: var(--text-muted);">
                <div style="font-size: 2rem; margin-bottom: 8px;">⚙️</div>
                <div style="font-weight: 700; font-size: 1rem; color: var(--text-main);">No capabilities match your query</div>
                <p style="font-size: 0.84rem; margin-top: 4px;">Try loosening your filters or create a new capability offering.</p>
                <button type="button" class="welcome-btn primary" onclick="openCreateCapabilityModal()" style="margin-top: 14px;">
                  + Add First Capability
                </button>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($capabilities as $cap): ?>
              <?php
                $catName = $cap['category_name'] ?? 'General Engineering';
                $priceModelLabels = [
                  'fixed_sprint' => ['label' => 'Fixed Sprint', 'color' => '#0056d6', 'bg' => '#eff6ff'],
                  'hourly'       => ['label' => 'Hourly Flex', 'color' => '#7c3aed', 'bg' => '#f5f3ff'],
                  'monthly_pod'  => ['label' => 'Monthly Pod', 'color' => '#059669', 'bg' => '#ecfdf5'],
                  'custom'       => ['label' => 'Custom Scope', 'color' => '#ea580c', 'bg' => '#fff7ed']
                ];
                $pm = $priceModelLabels[$cap['price_model']] ?? $priceModelLabels['fixed_sprint'];
              ?>
              <tr id="capRow-<?= (int)$cap['id'] ?>" data-title="<?= htmlspecialchars(strtolower((string)$cap['title'])) ?>" data-code="<?= htmlspecialchars(strtolower((string)$cap['service_code'])) ?>" data-category="<?= htmlspecialchars(strtolower((string)($cap['category_slug'] ?? ''))) ?>">
                
                <!-- Order Num -->
                <td style="text-align: center; font-family: var(--font-mono); font-size: 0.76rem; color: var(--text-light); font-weight: 700;">
                  #<?= (int)$cap['order_num'] ?>
                </td>

                <!-- Capability & Category -->
                <td>
                  <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div class="lead-avatar-badge" style="background: rgba(0, 86, 214, 0.08); border: 1px solid rgba(0, 86, 214, 0.2); color: var(--admin-blue); font-size: 0.72rem;">
                      <?= htmlspecialchars(substr((string)$cap['service_code'], 0, 3) ?: 'SVC') ?>
                    </div>
                    <div>
                      <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                        <a href="javascript:void(0)" onclick="viewCapabilityDossier(<?= (int)$cap['id'] ?>)" style="font-weight: 700; color: var(--text-main); font-size: 0.92rem; text-decoration: none;" class="cap-title-link">
                          <?= htmlspecialchars((string)$cap['title']) ?>
                        </a>
                        <?php if (!empty($cap['badge_label'])): ?>
                          <span style="font-size: 0.62rem; font-family: var(--font-mono); font-weight: 800; background: rgba(0, 86, 214, 0.08); color: var(--admin-blue); padding: 1px 6px; border-radius: 4px; text-transform: uppercase;">
                            <?= htmlspecialchars((string)$cap['badge_label']) ?>
                          </span>
                        <?php endif; ?>
                      </div>
                      
                      <div style="font-size: 0.76rem; color: var(--text-muted); margin-top: 2px;">
                        <span>Domain: <strong><?= htmlspecialchars((string)$catName) ?></strong></span>
                        <span style="margin: 0 4px;">•</span>
                        <code style="font-family: var(--font-mono); font-size: 0.7rem; color: var(--admin-cyan);"><?= htmlspecialchars((string)$cap['service_code']) ?></code>
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Pricing & Model -->
                <td>
                  <div style="display: flex; flex-direction: column; gap: 3px;">
                    <span style="font-family: var(--font-mono); font-weight: 800; color: var(--text-main); font-size: 0.9rem;">
                      ₹<?= number_format((float)($cap['starting_price_inr'] ?? 0)) ?>
                    </span>
                    <div style="display: flex; align-items: center; gap: 6px;">
                      <span style="font-size: 0.68rem; font-family: var(--font-mono); padding: 1px 6px; border-radius: 4px; font-weight: 700; background: <?= $pm['bg'] ?>; color: <?= $pm['color'] ?>;">
                        <?= $pm['label'] ?>
                      </span>
                      <?php if (!empty($cap['starting_price_usd'])): ?>
                        <span style="font-size: 0.72rem; color: var(--text-light); font-family: var(--font-mono);">
                          ($<?= number_format((float)$cap['starting_price_usd']) ?>)
                        </span>
                      <?php endif; ?>
                    </div>
                  </div>
                </td>

                <!-- Timeline -->
                <td>
                  <div style="display: flex; align-items: center; gap: 4px; font-size: 0.8rem; font-weight: 600; color: #475569;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span><?= htmlspecialchars((string)($cap['typical_timeline'] ?: '2-4 Weeks')) ?></span>
                  </div>
                </td>

                <!-- Tech Stack Matrix Pills -->
                <td>
                  <div style="display: flex; flex-wrap: wrap; gap: 4px; max-width: 260px;">
                    <?php 
                      $techs = $cap['tech_stack_arr'] ?? [];
                      $visibleTechs = array_slice($techs, 0, 3);
                      $remaining = count($techs) - count($visibleTechs);
                    ?>
                    <?php foreach ($visibleTechs as $tech): ?>
                      <span style="font-size: 0.68rem; background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; padding: 1px 6px; border-radius: 4px; font-weight: 600;">
                        <?= htmlspecialchars((string)$tech) ?>
                      </span>
                    <?php endforeach; ?>
                    <?php if ($remaining > 0): ?>
                      <span style="font-size: 0.65rem; background: #f8fafc; color: var(--text-muted); border: 1px dashed #cbd5e1; padding: 1px 5px; border-radius: 4px; font-family: var(--font-mono); font-weight: 700;">
                        +<?= $remaining ?> more
                      </span>
                    <?php endif; ?>
                  </div>
                </td>

                <!-- Featured Toggle -->
                <td style="text-align: center;">
                  <button type="button" class="btn-micro-action" onclick="toggleCapabilityFeatured(<?= (int)$cap['id'] ?>)" id="featBtn-<?= (int)$cap['id'] ?>" title="Toggle Featured Flagship Showcase" style="width: auto; height: auto; padding: 4px 8px; font-size: 0.74rem; font-weight: 700; border-radius: 6px; <?= $cap['is_featured'] ? 'background: #fff7ed; color: #ea580c; border-color: #fed7aa;' : 'background: #f8fafc; color: var(--text-light);' ?>">
                    <span><?= $cap['is_featured'] ? '★ Featured' : '☆ Standard' ?></span>
                  </button>
                </td>

                <!-- Active Toggle Switch -->
                <td style="text-align: center;">
                  <button type="button" class="btn-micro-action" onclick="toggleCapabilityStatus(<?= (int)$cap['id'] ?>)" id="statusBtn-<?= (int)$cap['id'] ?>" title="Toggle Live / Draft" style="width: auto; height: auto; padding: 4px 8px; font-size: 0.72rem; font-weight: 700; border-radius: 6px; <?= $cap['is_active'] ? 'background: #ecfdf5; color: #059669; border-color: #a7f3d0;' : 'background: #f1f5f9; color: #64748b; border-color: #cbd5e1;' ?>">
                    <span><?= $cap['is_active'] ? '● Active' : '○ Draft' ?></span>
                  </button>
                </td>

                <!-- Action Buttons -->
                <td style="text-align: right;">
                  <div style="display: inline-flex; align-items: center; gap: 4px;">
                    <!-- View Dossier -->
                    <button type="button" class="crm-micro-btn" onclick="viewCapabilityDossier(<?= (int)$cap['id'] ?>)" title="View Service Dossier">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>

                    <!-- Edit -->
                    <button type="button" class="crm-micro-btn" onclick="openEditCapabilityModal(<?= (int)$cap['id'] ?>)" title="Edit Capability Architecture">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>

                    <!-- Duplicate -->
                    <button type="button" class="crm-micro-btn" onclick="duplicateCapability(<?= (int)$cap['id'] ?>)" title="Clone as New Offering">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    </button>

                    <!-- Public Link -->
                    <a href="<?= BASE_URL ?>/services/<?= urlencode((string)$cap['slug']) ?>" target="_blank" class="crm-micro-btn" title="Open Public Page">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </a>

                    <!-- Delete -->
                    <button type="button" class="crm-micro-btn danger" onclick="deleteCapability(<?= (int)$cap['id'] ?>, '<?= htmlspecialchars(addslashes((string)$cap['title'])) ?>')" title="Delete Capability">
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

</div><!-- /.admin-content -->

<!-- ========================================================================
     MODAL 1: VIEW CAPABILITY DOSSIER (READ ONLY)
     ======================================================================== -->
<div class="admin-modal-backdrop" id="capabilityDossierModalBackdrop">
  <div class="admin-modal" style="max-width: 680px;">
    <div class="admin-modal-header">
      <div>
        <h3 class="admin-modal-title" id="dossierTitle">Capability Dossier</h3>
        <span style="font-size: 0.78rem; color: var(--text-muted);" id="dossierCategorySubtitle">Enterprise Digital Service</span>
      </div>
      <button type="button" class="toast-close-btn" onclick="closeCapabilityDossierModal()" aria-label="Close dialog">&times;</button>
    </div>

    <div class="admin-modal-body" id="dossierBody">
      <!-- Injected dynamically via JS -->
      <div style="text-align: center; padding: 32px; color: var(--text-muted);">Loading capability specifications...</div>
    </div>

    <div class="admin-modal-footer">
      <button type="button" class="welcome-btn secondary" onclick="closeCapabilityDossierModal()">Close</button>
      <a href="#" id="dossierPublicLink" target="_blank" class="welcome-btn secondary" style="display: inline-flex; align-items: center; gap: 6px;">
        <span>Open Public Service Page ↗</span>
      </a>
      <button type="button" class="welcome-btn primary" id="dossierEditBtn" onclick="">
        <span>Edit Architecture</span>
      </button>
    </div>
  </div>
</div>

<!-- ========================================================================
     MODAL 2: CREATE / EDIT CAPABILITY MODAL
     ======================================================================== -->
<div class="admin-modal-backdrop" id="capabilityFormModalBackdrop">
  <div class="admin-modal" style="max-width: 760px;">
    <div class="admin-modal-header">
      <div>
        <h3 class="admin-modal-title" id="formModalTitle">Add New Capability</h3>
        <span style="font-size: 0.78rem; color: var(--text-muted);">Configure offerings, pricing tiers, and engineering parameters</span>
      </div>
      <button type="button" class="toast-close-btn" onclick="closeCapabilityFormModal()" aria-label="Close dialog">&times;</button>
    </div>

    <form id="capabilityForm" onsubmit="handleCapabilityFormSubmit(event)">
      <input type="hidden" name="id" id="capFieldId" value="0" />

      <div class="admin-modal-body" style="max-height: 72vh; overflow-y: auto;">
        
        <!-- SECTION 1: CORE IDENTIFIERS -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono); text-transform: uppercase; letter-spacing: 1px; color: var(--admin-blue); font-weight: 800; margin-bottom: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px;">
          1. Core Identification & Taxonomy
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 14px; margin-bottom: 14px;">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="capFieldTitle">Capability Title *</label>
            <input type="text" id="capFieldTitle" name="title" class="crm-form-input" placeholder="e.g. Enterprise Cloud & Kubernetes Platforms" required oninput="autoSlugifyTitle(this.value)" />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="capFieldCategory">Domain Category *</label>
            <select id="capFieldCategory" name="category_id" class="crm-form-input" required>
              <option value="">Select Domain...</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat['id'] ?>"><?= htmlspecialchars((string)$cat['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-bottom: 16px;">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="capFieldCode">Service Code *</label>
            <input type="text" id="capFieldCode" name="service_code" class="crm-form-input" placeholder="e.g. cloud-platforms" required />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="capFieldSlug">URL Slug *</label>
            <input type="text" id="capFieldSlug" name="slug" class="crm-form-input" placeholder="e.g. cloud-platforms" required />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="capFieldBadge">Badge Label</label>
            <input type="text" id="capFieldBadge" name="badge_label" class="crm-form-input" placeholder="e.g. ENTERPRISE CORE" value="CORE SERVICE" />
          </div>
        </div>

        <!-- SECTION 2: SCOPE & DESCRIPTIONS -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono); text-transform: uppercase; letter-spacing: 1px; color: var(--admin-blue); font-weight: 800; margin: 18px 0 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px;">
          2. Narrative & Scope
        </div>

        <div class="crm-form-group">
          <label for="capFieldShortDesc">Executive Summary (Short Description) *</label>
          <textarea id="capFieldShortDesc" name="short_description" class="crm-notes-textarea" style="min-height: 60px;" placeholder="Crisp 1-2 sentence description featured on cards and listings..." required></textarea>
        </div>

        <div class="crm-form-group">
          <label for="capFieldFullDesc">Comprehensive Architectural Scope (Full Description)</label>
          <textarea id="capFieldFullDesc" name="full_description" class="crm-notes-textarea" style="min-height: 90px;" placeholder="Detailed technical methodology, infrastructure blueprints, and delivery standards..."></textarea>
        </div>

        <!-- SECTION 3: COMMERCIALS & TIMELINE -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono); text-transform: uppercase; letter-spacing: 1px; color: var(--admin-blue); font-weight: 800; margin: 18px 0 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px;">
          3. Commercial Models & SLA Timelines
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 12px; margin-bottom: 16px;">
          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="capFieldPriceModel">Pricing Model</label>
            <select id="capFieldPriceModel" name="price_model" class="crm-form-input">
              <option value="fixed_sprint">Fixed Sprint</option>
              <option value="monthly_pod">Monthly Pod</option>
              <option value="hourly">Hourly Flex</option>
              <option value="custom">Custom Scope</option>
            </select>
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="capFieldPriceInr">Starting Price (INR ₹)</label>
            <input type="number" id="capFieldPriceInr" name="starting_price_inr" class="crm-form-input" placeholder="149000" step="1000" />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="capFieldPriceUsd">Starting Price (USD $)</label>
            <input type="number" id="capFieldPriceUsd" name="starting_price_usd" class="crm-form-input" placeholder="1800" step="50" />
          </div>

          <div class="crm-form-group" style="margin-bottom: 0;">
            <label for="capFieldTimeline">Typical Delivery</label>
            <input type="text" id="capFieldTimeline" name="typical_timeline" class="crm-form-input" placeholder="e.g. 2-4 Weeks" value="2-4 Weeks" />
          </div>
        </div>

        <!-- SECTION 4: STACK & DELIVERABLES -->
        <div style="font-size: 0.78rem; font-family: var(--font-mono); text-transform: uppercase; letter-spacing: 1px; color: var(--admin-blue); font-weight: 800; margin: 18px 0 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 4px;">
          4. Engineering Matrix & Deliverables
        </div>

        <div class="crm-form-group">
          <label for="capFieldTechStack">Tech Stack Matrix (Comma-Separated)</label>
          <input type="text" id="capFieldTechStack" name="tech_stack" class="crm-form-input" placeholder="e.g. Next.js 15, TypeScript, Node.js, PostgreSQL, Docker, Redis" />
          <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 4px;">Separate each framework or technology with a comma.</span>
        </div>

        <div class="crm-form-group">
          <label for="capFieldDeliverables">Key Sprint Deliverables (1 per line)</label>
          <textarea id="capFieldDeliverables" name="key_deliverables" class="crm-notes-textarea" style="min-height: 70px;" placeholder="Sub-0.3s Core Web Vitals Guaranteed&#10;Fully Automated CI/CD Pipelines&#10;High-Security JWT & OAuth 2.0 Auth"></textarea>
        </div>

        <!-- SECTION 5: VISIBILITY & ORDER -->
        <div style="display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; margin-top: 18px;">
          <div style="display: flex; align-items: center; gap: 20px;">
            <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: var(--text-main); cursor: pointer; margin-bottom: 0;">
              <input type="checkbox" id="capFieldIsActive" name="is_active" value="1" checked style="width: 16px; height: 16px; accent-color: var(--admin-blue);" />
              <span>Publish as Active (Live)</span>
            </label>

            <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 700; color: var(--text-main); cursor: pointer; margin-bottom: 0;">
              <input type="checkbox" id="capFieldIsFeatured" name="is_featured" value="1" checked style="width: 16px; height: 16px; accent-color: var(--admin-orange);" />
              <span>Flagship Showcase (Featured)</span>
            </label>
          </div>

          <div style="display: flex; align-items: center; gap: 8px;">
            <label for="capFieldOrderNum" style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0;">Order Rank:</label>
            <input type="number" id="capFieldOrderNum" name="order_num" value="0" class="crm-form-input" style="width: 70px; padding: 6px 10px;" />
          </div>
        </div>

      </div>

      <div class="admin-modal-footer">
        <button type="button" class="welcome-btn secondary" onclick="closeCapabilityFormModal()">Cancel</button>
        <button type="submit" class="welcome-btn primary" id="capFormSaveBtn">
          <span>Save Capability</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ========================================================================
     CAPABILITIES CLIENT-SIDE CONTROLLER
     ======================================================================== -->
<script>
  // 1. Live Filter & Search Trigger
  function applyCapFilters() {
    const cat = document.getElementById('filterCategorySelect').value;
    const stat = document.getElementById('filterStatusSelect').value;
    const feat = document.getElementById('filterFeaturedSelect').value;
    const search = document.getElementById('capSearchInput').value.trim();

    const params = new URLSearchParams();
    if (cat && cat !== 'all') params.set('category', cat);
    if (stat && stat !== 'all') params.set('status', stat);
    if (feat && feat !== 'all') params.set('featured', feat);
    if (search) params.set('search', search);

    window.location.href = `<?= BASE_URL ?>/admin/capabilities?${params.toString()}`;
  }

  function handleCapSearch(event) {
    if (event.key === 'Enter') {
      applyCapFilters();
    }
  }

  // 2. Auto-slugifier
  function autoSlugifyTitle(title) {
    const slugInput = document.getElementById('capFieldSlug');
    const codeInput = document.getElementById('capFieldCode');
    const currentId = document.getElementById('capFieldId').value;
    
    // Only auto-slugify if adding new record
    if (currentId === '0' || !currentId) {
      const slug = title.toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
      if (slugInput) slugInput.value = slug;
      if (codeInput && !codeInput.value) codeInput.value = slug;
    }
  }

  // 3. Quick Toggle Status (Active / Draft)
  function toggleCapabilityStatus(id) {
    const btn = document.getElementById(`statusBtn-${id}`);
    if (btn) btn.disabled = true;

    const formData = new FormData();
    formData.append('id', id);

    fetch('<?= BASE_URL ?>/admin/capability/toggle-status', {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        if (btn) {
          btn.disabled = false;
          if (data.is_active === 1) {
            btn.innerHTML = '<span>● Active</span>';
            btn.style.background = '#ecfdf5';
            btn.style.color = '#059669';
            btn.style.borderColor = '#a7f3d0';
          } else {
            btn.innerHTML = '<span>○ Draft</span>';
            btn.style.background = '#f1f5f9';
            btn.style.color = '#64748b';
            btn.style.borderColor = '#cbd5e1';
          }
        }
        window.showToast(data.message, 'success', 'Status Updated');
      } else {
        if (btn) btn.disabled = false;
        window.showToast(data.error || 'Failed to update status', 'error', 'Error');
      }
    })
    .catch(err => {
      if (btn) btn.disabled = false;
      window.showToast('Network error updating status.', 'error', 'Connection Error');
    });
  }

  // 4. Quick Toggle Featured
  function toggleCapabilityFeatured(id) {
    const btn = document.getElementById(`featBtn-${id}`);
    if (btn) btn.disabled = true;

    const formData = new FormData();
    formData.append('id', id);

    fetch('<?= BASE_URL ?>/admin/capability/toggle-featured', {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        if (btn) {
          btn.disabled = false;
          if (data.is_featured === 1) {
            btn.innerHTML = '<span>★ Featured</span>';
            btn.style.background = '#fff7ed';
            btn.style.color = '#ea580c';
            btn.style.borderColor = '#fed7aa';
          } else {
            btn.innerHTML = '<span>☆ Standard</span>';
            btn.style.background = '#f8fafc';
            btn.style.color = 'var(--text-light)';
            btn.style.borderColor = '#e2e8f0';
          }
        }
        window.showToast(data.message, 'success', 'Showcase Updated');
      } else {
        if (btn) btn.disabled = false;
        window.showToast(data.error || 'Failed to update featured flag', 'error', 'Error');
      }
    })
    .catch(err => {
      if (btn) btn.disabled = false;
      window.showToast('Network error updating featured state.', 'error', 'Connection Error');
    });
  }

  // 5. Duplicate Capability
  function duplicateCapability(id) {
    if (!confirm('Clone this capability as a new offering? All tech stacks and deliverables will be replicated.')) {
      return;
    }

    const formData = new FormData();
    formData.append('id', id);

    fetch('<?= BASE_URL ?>/admin/capability/duplicate', {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        window.showToast(data.message, 'success', 'Cloned Successfully');
        setTimeout(() => window.location.reload(), 800);
      } else {
        window.showToast(data.error || 'Failed to clone capability', 'error', 'Clone Error');
      }
    })
    .catch(err => {
      window.showToast('Network error cloning capability.', 'error', 'Connection Error');
    });
  }

  // 6. Delete Capability
  function deleteCapability(id, title) {
    if (!confirm(`Are you sure you want to permanently delete "${title}"? This cannot be undone.`)) {
      return;
    }

    const formData = new FormData();
    formData.append('id', id);

    fetch('<?= BASE_URL ?>/admin/capability/delete', {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        window.showToast(data.message, 'info', 'Capability Removed');
        const row = document.getElementById(`capRow-${id}`);
        if (row) {
          row.style.transition = 'all 0.3s ease';
          row.style.opacity = '0';
          setTimeout(() => row.remove(), 300);
        }
      } else {
        window.showToast(data.error || 'Failed to delete capability', 'error', 'Delete Error');
      }
    })
    .catch(err => {
      window.showToast('Network error deleting capability.', 'error', 'Connection Error');
    });
  }

  // 7. View Capability Dossier Modal
  function viewCapabilityDossier(id) {
    const backdrop = document.getElementById('capabilityDossierModalBackdrop');
    const body = document.getElementById('dossierBody');
    const title = document.getElementById('dossierTitle');
    const sub = document.getElementById('dossierCategorySubtitle');
    const publicLink = document.getElementById('dossierPublicLink');
    const editBtn = document.getElementById('dossierEditBtn');

    if (!backdrop) return;
    backdrop.classList.add('show');
    document.body.style.overflow = 'hidden';

    body.innerHTML = '<div style="text-align: center; padding: 32px; color: var(--text-muted);">Fetching dossier architecture...</div>';

    fetch(`<?= BASE_URL ?>/admin/capability/detail?id=${id}`)
      .then(r => r.json())
      .then(res => {
        if (!res.success || !res.capability) {
          body.innerHTML = `<div style="color: var(--admin-red); padding: 24px; text-align: center;">${res.error || 'Could not load capability record.'}</div>`;
          return;
        }

        const c = res.capability;
        title.textContent = c.title;
        sub.textContent = `${c.category_name || 'General Engineering'} • Code: ${c.service_code}`;
        publicLink.href = `<?= BASE_URL ?>/services/${encodeURIComponent(c.slug)}`;
        editBtn.setAttribute('onclick', `closeCapabilityDossierModal(); openEditCapabilityModal(${c.id});`);

        const techs = c.tech_stack_arr || [];
        const deliverables = c.key_deliverables_arr || [];

        let techPillsHtml = '';
        if (techs.length > 0) {
          techPillsHtml = techs.map(t => `<span style="font-size: 0.74rem; background: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; padding: 2px 8px; border-radius: 6px; font-weight: 600;">${t}</span>`).join(' ');
        } else {
          techPillsHtml = '<span style="color: var(--text-muted); font-size: 0.8rem;">No technologies specified</span>';
        }

        let delivHtml = '';
        if (deliverables.length > 0) {
          delivHtml = deliverables.map(d => `<li style="font-size: 0.84rem; color: #334155; margin-bottom: 6px; display: flex; align-items: flex-start; gap: 8px;"><span style="color: #10b981; font-weight: 800;">✓</span><span>${d}</span></li>`).join('');
        } else {
          delivHtml = '<li style="color: var(--text-muted); font-size: 0.8rem;">No key deliverables listed.</li>';
        }

        body.innerHTML = `
          <!-- Meta Matrix Cards -->
          <div class="crm-modal-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 16px;">
            <div class="crm-modal-card">
              <div class="crm-modal-card-label">Pricing Base</div>
              <div class="crm-modal-card-val" style="color: var(--admin-blue);">₹${Number(c.starting_price_inr).toLocaleString()}</div>
              <div style="font-size: 0.72rem; color: var(--text-muted); font-family: var(--font-mono); margin-top: 2px;">$${Number(c.starting_price_usd).toLocaleString()} USD</div>
            </div>

            <div class="crm-modal-card">
              <div class="crm-modal-card-label">Sprint Model</div>
              <div class="crm-modal-card-val" style="text-transform: capitalize;">${c.price_model ? c.price_model.replace('_', ' ') : 'Fixed Sprint'}</div>
              <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 2px;">Delivery: ${c.typical_timeline || '2-4 Weeks'}</div>
            </div>

            <div class="crm-modal-card">
              <div class="crm-modal-card-label">Publishing Status</div>
              <div class="crm-modal-card-val" style="color: ${c.is_active ? '#059669' : '#dc2626'};">
                ${c.is_active ? '● Live on Website' : '○ Inactive / Draft'}
              </div>
              <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 2px;">${c.is_featured ? '★ Featured Flagship' : 'Standard'}</div>
            </div>
          </div>

          <!-- Description -->
          <div style="margin-bottom: 18px;">
            <div style="font-size: 0.74rem; font-family: var(--font-mono); color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Executive Scope</div>
            <p style="font-size: 0.9rem; color: var(--text-main); line-height: 1.5; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; margin: 0;">
              ${c.short_description || 'No short description provided.'}
            </p>
          </div>

          ${c.full_description ? `
            <div style="margin-bottom: 18px;">
              <div style="font-size: 0.74rem; font-family: var(--font-mono); color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Technical Blueprint</div>
              <div style="font-size: 0.85rem; color: #475569; line-height: 1.55; max-height: 120px; overflow-y: auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
                ${c.full_description}
              </div>
            </div>
          ` : ''}

          <!-- Tech Stack -->
          <div style="margin-bottom: 18px;">
            <div style="font-size: 0.74rem; font-family: var(--font-mono); color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">Technology & Framework Stack</div>
            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
              ${techPillsHtml}
            </div>
          </div>

          <!-- Deliverables -->
          <div>
            <div style="font-size: 0.74rem; font-family: var(--font-mono); color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 6px;">Key Deliverables & Guarantees</div>
            <ul style="list-style: none; padding: 0; margin: 0; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 16px;">
              ${delivHtml}
            </ul>
          </div>
        `;
      })
      .catch(err => {
        body.innerHTML = '<div style="color: var(--admin-red); padding: 24px; text-align: center;">Network error loading dossier.</div>';
      });
  }

  function closeCapabilityDossierModal() {
    const backdrop = document.getElementById('capabilityDossierModalBackdrop');
    if (backdrop) backdrop.classList.remove('show');
    document.body.style.overflow = '';
  }

  // 8. Open Create / Edit Modal
  function openCreateCapabilityModal() {
    document.getElementById('capabilityForm').reset();
    document.getElementById('capFieldId').value = '0';
    document.getElementById('formModalTitle').textContent = 'Add New Capability';
    document.getElementById('capFieldBadge').value = 'CORE SERVICE';
    document.getElementById('capFieldTimeline').value = '2-4 Weeks';
    document.getElementById('capFieldOrderNum').value = '0';
    document.getElementById('capFieldIsActive').checked = true;
    document.getElementById('capFieldIsFeatured').checked = false;

    const backdrop = document.getElementById('capabilityFormModalBackdrop');
    if (backdrop) backdrop.classList.add('show');
    document.body.style.overflow = 'hidden';
  }

  function openEditCapabilityModal(id) {
    const backdrop = document.getElementById('capabilityFormModalBackdrop');
    if (!backdrop) return;

    document.getElementById('capabilityForm').reset();
    document.getElementById('formModalTitle').textContent = `Edit Capability #${id}`;

    backdrop.classList.add('show');
    document.body.style.overflow = 'hidden';

    // Fetch capability data
    fetch(`<?= BASE_URL ?>/admin/capability/detail?id=${id}`)
      .then(r => r.json())
      .then(res => {
        if (!res.success || !res.capability) {
          window.showToast('Could not load capability details.', 'error');
          closeCapabilityFormModal();
          return;
        }

        const c = res.capability;
        document.getElementById('capFieldId').value = c.id;
        document.getElementById('capFieldTitle').value = c.title || '';
        document.getElementById('capFieldCode').value = c.service_code || '';
        document.getElementById('capFieldSlug').value = c.slug || '';
        document.getElementById('capFieldCategory').value = c.category_id || '';
        document.getElementById('capFieldBadge').value = c.badge_label || '';
        document.getElementById('capFieldShortDesc').value = c.short_description || '';
        document.getElementById('capFieldFullDesc').value = c.full_description || '';
        document.getElementById('capFieldPriceModel').value = c.price_model || 'fixed_sprint';
        document.getElementById('capFieldPriceInr').value = c.starting_price_inr || '';
        document.getElementById('capFieldPriceUsd').value = c.starting_price_usd || '';
        document.getElementById('capFieldTimeline').value = c.typical_timeline || '2-4 Weeks';
        document.getElementById('capFieldTechStack').value = (c.tech_stack_arr || []).join(', ');
        document.getElementById('capFieldDeliverables').value = (c.key_deliverables_arr || []).join('\n');
        document.getElementById('capFieldOrderNum').value = c.order_num || 0;
        document.getElementById('capFieldIsActive').checked = Boolean(Number(c.is_active));
        document.getElementById('capFieldIsFeatured').checked = Boolean(Number(c.is_featured));
      })
      .catch(err => {
        window.showToast('Network error loading capability.', 'error');
        closeCapabilityFormModal();
      });
  }

  function closeCapabilityFormModal() {
    const backdrop = document.getElementById('capabilityFormModalBackdrop');
    if (backdrop) backdrop.classList.remove('show');
    document.body.style.overflow = '';
  }

  // 9. Save Capability Form Submit
  function handleCapabilityFormSubmit(event) {
    event.preventDefault();
    const btn = document.getElementById('capFormSaveBtn');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span>Saving Offering...</span>';

    const form = document.getElementById('capabilityForm');
    const formData = new FormData(form);

    fetch('<?= BASE_URL ?>/admin/capability/save', {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
      btn.disabled = false;
      btn.innerHTML = originalText;

      if (data.success) {
        closeCapabilityFormModal();
        window.showToast(data.message, 'success', 'Saved Successfully');
        setTimeout(() => window.location.reload(), 700);
      } else {
        window.showToast(data.error || 'Failed to save capability.', 'error', 'Validation Error');
      }
    })
    .catch(err => {
      btn.disabled = false;
      btn.innerHTML = originalText;
      window.showToast('Network error while saving capability.', 'error', 'Connection Error');
    });
  }

  // Close modals on Esc or backdrop click
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeCapabilityDossierModal();
      closeCapabilityFormModal();
    }
  });

  document.getElementById('capabilityDossierModalBackdrop').addEventListener('click', (e) => {
    if (e.target.id === 'capabilityDossierModalBackdrop') closeCapabilityDossierModal();
  });

  document.getElementById('capabilityFormModalBackdrop').addEventListener('click', (e) => {
    if (e.target.id === 'capabilityFormModalBackdrop') closeCapabilityFormModal();
  });
</script>

<?php include __DIR__ . '/layout/footer.php'; ?>
