<?php
/**
 * ClickCodex Technologies - Dynamic Service Detail View
 * High-Ticket Technical Capabilities, Tech Stack, Deliverables & Sprints
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

$cleanWhatsapp = preg_replace('/[^0-9]/', '', (string)($settings['whatsapp_number'] ?? '919876543210'));
$cleanPhone = preg_replace('/[^0-9+]/', '', (string)($settings['contact_phone'] ?? '+919876543210'));

require_once __DIR__ . '/layout/header.php';
?>

<main>
  <!-- ==========================================================================
       1. SERVICE HERO & SPECS STRIP
       ========================================================================== -->
  <section class="service-detail-hero">
    <div class="container">
      <!-- Breadcrumbs -->
      <nav class="service-breadcrumb-bar" aria-label="Breadcrumb">
        <a href="<?= BASE_URL ?>/">Home</a>
        <span class="service-breadcrumb-sep">/</span>
        <a href="<?= BASE_URL ?>/services">Our Services</a>
        <span class="service-breadcrumb-sep">/</span>
        <span style="color: var(--brand-blue); font-weight: 600;"><?= htmlspecialchars($service['title']) ?></span>
      </nav>

      <!-- Category / Code Pill -->
      <div class="service-category-badge">
        <span><?= htmlspecialchars($service['badge_label'] ?? '01 // CAPABILITY') ?></span>
        <?php if (!empty($service['category_name'])): ?>
          <span>• <?= htmlspecialchars($service['category_name']) ?></span>
        <?php endif; ?>
      </div>

      <!-- Main Headline -->
      <h1 class="service-detail-title">
        <?= htmlspecialchars($service['title']) ?>
      </h1>

      <!-- Lead Description -->
      <p class="service-detail-lead">
        <?= htmlspecialchars($service['short_description']) ?>
      </p>

      <!-- Quick Parameters Strip -->
      <div class="service-specs-strip">
        <div class="spec-cell">
          <span class="spec-label">Starting Investment</span>
          <span class="spec-val accent">
            ₹<?= number_format((float)$service['starting_price_inr']) ?> / $<?= number_format((float)$service['starting_price_usd']) ?>
          </span>
        </div>
        <div class="spec-cell">
          <span class="spec-label">Typical Timeline</span>
          <span class="spec-val">
            <?= htmlspecialchars($service['typical_timeline'] ?? '2 – 4 Weeks') ?>
          </span>
        </div>
        <div class="spec-cell">
          <span class="spec-label">Engagement Model</span>
          <span class="spec-val">
            <?= ucfirst(str_replace('_', ' ', (string)($service['price_model'] ?? 'Fixed Agile Sprint'))) ?>
          </span>
        </div>
        <div class="spec-cell">
          <span class="spec-label">Code Ownership</span>
          <span class="spec-val" style="color: #10b981;">
            100% Client Owned
          </span>
        </div>
      </div>

      <!-- Hero Actions -->
      <div class="service-hero-actions">
        <button class="btn-primary" onclick="openConsultationModal('<?= addslashes($service['title']) ?>')">
          <span>Request Technical Proposal</span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </button>

        <a href="https://wa.me/<?= $cleanWhatsapp ?>?text=<?= urlencode('Hi ClickCodex, I would like to inquire about ' . $service['title']) ?>" 
           target="_blank" rel="noopener noreferrer" class="whatsapp-btn" style="padding: 12px 22px; font-size: 0.92rem;">
          <svg viewBox="0 0 24 24" style="width: 17px; height: 17px;"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.698.077-1.118-.057-.26-.084-.589-.201-.989-.374-1.745-.758-2.887-2.531-2.975-2.648-.088-.116-.71-0.947-.71-1.807 0-.859.45-1.282.61-1.458.16-.176.35-.22.47-.22.12 0 .24.002.34.007.11.005.26-.042.41.319.15.362.51 1.242.55 1.33.04.088.07.191.01.308-.06.117-.09.19-.18.293-.09.103-.19.23-.27.309-.09.088-.19.183-.08.371.11.188.48.793 1.03 1.283.71.633 1.31.829 1.49.919.18.09.29.076.4-.047.11-.123.47-.549.6-.738.13-.189.26-.158.44-.092.18.066 1.14.537 1.34.636.2.099.33.147.38.232.05.085.05.495-.09.9z"/></svg>
          <span>Chat on WhatsApp</span>
        </a>

        <a href="<?= BASE_URL ?>/service-finder" class="btn-outline" style="border: 1px solid var(--border-light); padding: 11px 22px; border-radius: 9999px; font-weight: 600; font-size: 0.92rem; color: var(--text-dark);">
          <span>Compare via Solution Advisor ↗</span>
        </a>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       2. MAIN DETAIL GRID & STICKY ASIDE
       ========================================================================== -->
  <section class="service-main-section">
    <div class="container">
      <div class="service-main-grid">

        <!-- LEFT COLUMN: DEEP DIVE DOSSIER -->
        <div class="service-content-col">

          <!-- Section A: Overview & Architectural Value -->
          <div class="detail-section-block">
            <h2 class="detail-section-heading">Architectural Overview & Engineering Standard</h2>
            <p class="detail-section-desc">
              <?= nl2br(htmlspecialchars($service['full_description'] ?? $service['short_description'])) ?>
            </p>
            <p style="color: var(--text-muted); font-size: 1rem; line-height: 1.75;">
              At Click Codex, we focus on delivering clean, maintainable, and high-performance digital assets. We prioritize structured code, modern UX principles, responsive layouts, and robust security so your platform operates reliably and supports your business as you grow.
            </p>
          </div>

          <!-- Section B: Modern Architecture & Tech Stack -->
          <?php if (!empty($service['tech_stack_arr'])): ?>
            <div class="detail-section-block">
              <h2 class="detail-section-heading">Production Tech Stack & Frameworks</h2>
              <p class="detail-section-desc">
                We select reliable, modern open-source technologies with strong community support, high performance, and zero proprietary lock-in.
              </p>

              <div class="tech-stack-cards-grid">
                <?php foreach ($service['tech_stack_arr'] as $tech): ?>
                  <div class="tech-stack-card">
                    <span class="tech-badge-pill">MODERN STACK</span>
                    <h4 class="tech-card-name"><?= htmlspecialchars($tech) ?></h4>
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Clean code standards, fast responsiveness, and active developer support.</span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Section C: Key Deliverables vs Performance KPIs -->
          <div class="detail-section-block">
            <h2 class="detail-section-heading">Tangible Deliverables & Guaranteed Benchmarks</h2>
            <p class="detail-section-desc">
              Every milestone is verified against strict commercial and technical acceptance criteria prior to final handover.
            </p>

            <div class="deliverables-kpis-grid">
              <!-- Deliverables Box -->
              <div class="feature-box-panel">
                <h3 class="feature-panel-title">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--brand-blue);"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                  <span>Key Deliverables</span>
                </h3>

                <div class="feature-check-list">
                  <?php if (!empty($service['key_deliverables_arr'])): ?>
                    <?php foreach ($service['key_deliverables_arr'] as $deliv): ?>
                      <div class="feature-check-item">
                        <div class="feature-check-icon">✓</div>
                        <span><?= htmlspecialchars($deliv) ?></span>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <div class="feature-check-item">
                      <div class="feature-check-icon">✓</div>
                      <span>Full Source Code Repository (GitHub/GitLab)</span>
                    </div>
                    <div class="feature-check-item">
                      <div class="feature-check-icon">✓</div>
                      <span>Automated CI/CD Deployment Pipelines</span>
                    </div>
                    <div class="feature-check-item">
                      <div class="feature-check-icon">✓</div>
                      <span>Comprehensive API & Architecture Documentation</span>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

              <!-- KPIs Box -->
              <div class="feature-box-panel dark">
                <h3 class="feature-panel-title">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--brand-cyan);"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                  <span>Performance KPIs</span>
                </h3>

                <div class="feature-check-list">
                  <?php if (!empty($service['performance_kpis_arr'])): ?>
                    <?php foreach ($service['performance_kpis_arr'] as $kpi): ?>
                      <div class="feature-check-item">
                        <span class="feature-kpi-badge">TARGET</span>
                        <span style="color: #cbd5e1;"><?= htmlspecialchars($kpi) ?></span>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <div class="feature-check-item">
                      <span class="feature-kpi-badge">95+</span>
                      <span style="color: #cbd5e1;">Google PageSpeed Desktop & Mobile Score</span>
                    </div>
                    <div class="feature-check-item">
                      <span class="feature-kpi-badge">&lt; 0.3s</span>
                      <span style="color: #cbd5e1;">Core Web Vitals Largest Contentful Paint (LCP)</span>
                    </div>
                    <div class="feature-check-item">
                      <span class="feature-kpi-badge">100%</span>
                      <span style="color: #cbd5e1;">OWASP Security Compliance & Zero Critical CVEs</span>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Section D: 4-Phase Agile Engineering Dossier -->
          <?php if (!empty($dossierSteps)): ?>
            <div class="detail-section-block">
              <h2 class="detail-section-heading">4-Phase Agile Engineering Roadmap</h2>
              <p class="detail-section-desc">
                How we take your product from raw requirements to resilient production deployment in synchronized two-week sprints.
              </p>

              <div class="dossier-timeline-list">
                <?php foreach ($dossierSteps as $step): ?>
                  <div class="dossier-phase-card">
                    <div class="phase-card-header">
                      <h4 class="phase-card-title"><?= htmlspecialchars($step['phase_title']) ?></h4>
                      <span class="phase-timeline-pill">⏱ <?= htmlspecialchars($step['typical_timeline'] ?? 'Sprint Milestone') ?></span>
                    </div>
                    <p class="phase-card-desc"><?= htmlspecialchars($step['description']) ?></p>

                    <?php if (!empty($step['checkpoints_arr'])): ?>
                      <div class="phase-checkpoints-row">
                        <?php foreach ($step['checkpoints_arr'] as $cp): ?>
                          <div class="phase-checkpoint-item">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            <span><?= htmlspecialchars($cp) ?></span>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Section E: Related Case Studies -->
          <?php if (!empty($relatedCases)): ?>
            <div class="detail-section-block">
              <h2 class="detail-section-heading">Our Showcase Work</h2>
              <p class="detail-section-desc">
                Real projects developed by Click Codex showcasing clean code, modern design, and practical functionality.
              </p>

              <div class="service-case-cards-grid">
                <?php foreach ($relatedCases as $case): ?>
                  <div class="service-case-card">
                    <div>
                      <span class="service-case-tag"><?= htmlspecialchars($case['sector_industry'] ?? 'Showcase Project') ?></span>
                      <h4 class="service-case-title"><?= htmlspecialchars($case['title']) ?></h4>
                      <p class="service-case-excerpt"><?= htmlspecialchars($case['excerpt'] ?? '') ?></p>
                    </div>

                    <a href="<?= BASE_URL ?>/portfolio" class="channel-action-btn" style="width: fit-content; text-decoration: none;">
                      <span>Explore Case Study</span>
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </a>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Section F: Service-Specific FAQ Accordion -->
          <?php if (!empty($faqs)): ?>
            <div class="detail-section-block">
              <h2 class="detail-section-heading">Frequently Asked Questions</h2>
              <p class="detail-section-desc">
                Everything you need to know before initiating a <?= htmlspecialchars($service['title']) ?> engagement.
              </p>

              <div class="faq-accordion-wrap">
                <?php foreach ($faqs as $fIdx => $faq): ?>
                  <div class="faq-item <?= $fIdx === 0 ? 'active' : '' ?>">
                    <button type="button" class="faq-question-btn" onclick="toggleFaq(this)">
                      <span><?= htmlspecialchars($faq['question']) ?></span>
                      <div class="faq-icon-arrow">▼</div>
                    </button>
                    <div class="faq-answer-box">
                      <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Section G: High-Conversion RFQ Banner -->
          <div class="service-rfq-banner">
            <div class="rfq-banner-text">
              <h3>Ready to Start Your <?= htmlspecialchars($service['title']) ?>?</h3>
              <p>Schedule a conversation with our core team. We provide a transparent project breakdown, timeline estimate, and clear deliverables tailored to your requirements.</p>
            </div>
            <div>
              <button class="btn-primary" onclick="openConsultationModal('<?= addslashes($service['title']) ?>')">
                <span>Start Discussion</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
              </button>
            </div>
          </div>

        </div>

        <!-- RIGHT STICKY COLUMN: QUICK SWITCHER & ADVISOR -->
        <aside class="service-sidebar-sticky">

          <!-- Navigation Switcher of All 6 Services -->
          <div class="services-nav-menu-box">
            <h4 class="sidebar-box-title">Our Capabilities</h4>
            <div class="services-nav-list">
              <?php foreach ($allServicesNav as $navItem): ?>
                <?php $isCurrent = ($navItem['slug'] === $service['slug']); ?>
                <a href="<?= BASE_URL ?>/services/<?= $navItem['slug'] ?>" 
                   class="services-nav-item <?= $isCurrent ? 'active' : '' ?>">
                  <span><?= htmlspecialchars($navItem['title']) ?></span>
                  <span style="font-size: 0.75rem; opacity: 0.8;"><?= $isCurrent ? '● Current' : '→' ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Solution Advisor Widget -->
          <div class="sidebar-advisor-card">
            <span style="font-family: var(--font-mono); font-size: 0.72rem; color: var(--brand-amber); text-transform: uppercase; letter-spacing: 1px;">Interactive Tool</span>
            <h4>Need Architecture Guidance?</h4>
            <p>Unsure which platform or framework fits your budget and timeline? Take our 60-second Solution Advisor quiz.</p>
            <a href="<?= BASE_URL ?>/service-finder" class="btn-primary" style="width: 100%; justify-content: center;">
              <span>Launch Advisor Tool ↗</span>
            </a>
          </div>

          <!-- Direct Hotline & SLA Box -->
          <div class="feature-box-panel" style="padding: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
              <span class="live-status-dot" style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
              <span style="font-family: var(--font-mono); font-size: 0.78rem; font-weight: 700; color: #065f46;">TEAM ACTIVE & READY</span>
            </div>
            <h5 style="font-family: var(--font-display); font-size: 1.05rem; font-weight: 700; margin-bottom: 6px;">Speak With Our Team</h5>
            <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 14px;">Direct access to our 4-member pod. No sales middlemen.</p>
            <a href="tel:<?= $cleanPhone ?>" style="font-family: var(--font-mono); font-size: 0.95rem; font-weight: 700; color: var(--brand-blue); display: block; margin-bottom: 10px;">
              <?= htmlspecialchars($settings['contact_phone']) ?>
            </a>
            <a href="mailto:<?= htmlspecialchars($settings['contact_email']) ?>" style="font-size: 0.86rem; color: var(--text-muted); text-decoration: underline;">
              <?= htmlspecialchars($settings['contact_email']) ?>
            </a>
          </div>

        </aside>

      </div>
    </div>
  </section>
</main>

<script>
  // FAQ Accordion Toggle
  window.toggleFaq = function(button) {
    const item = button.parentElement;
    const isActive = item.classList.contains('active');

    document.querySelectorAll('.faq-item').forEach(f => f.classList.remove('active'));

    if (!isActive) {
      item.classList.add('active');
    }
  };
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
