<?php
/**
 * ClickCodex Technologies - Pricing & Engagement Models View
 * Features Transparent Tiers, Real-Time Currency Switcher (INR / USD), Guaranteed Inclusions, and FAQs.
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

include __DIR__ . '/layout/header.php';
?>

<main>
  <!-- ==========================================================================
       HERO SECTION
       ========================================================================== -->
  <section class="pricing-hero">
    <div class="container">
      <span class="preview-badge" style="margin-bottom: 16px;">
        <span class="preview-pulse"></span>
        <span><?= htmlspecialchars($sections['pricing_hero']['badge_text'] ?? 'Clear & Predictable Investment') ?></span>
      </span>
      <h1>Transparent <span class="gradient-text">Engagement Models</span></h1>
      <p>
        <?= htmlspecialchars($sections['pricing_hero']['subtitle'] ?? 'No hidden fees. Clear milestones, transparent pricing, 100% source code ownership, and direct collaboration with our dedicated 4-member team.') ?>
      </p>
      
      <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-bottom: 10px;">
        <button class="btn-primary" onclick="openConsultationModal('Custom Scope Quote')">
          <span>Request Custom Estimate</span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </button>
        <a href="<?= BASE_URL ?>/service-finder" class="btn-secondary" style="border-radius: 9999px; padding: 14px 28px; font-weight: 600;">
          <span>🎯 Try Solution Advisor</span>
        </a>
      </div>

      <!-- Currency Switcher Toggle -->
      <div style="display: flex; justify-content: center;">
        <div class="currency-toggle-wrap">
          <button class="currency-btn active" id="btnInr" onclick="setCurrency('INR')">🇮🇳 INR (₹)</button>
          <button class="currency-btn" id="btnUsd" onclick="setCurrency('USD')">🌐 USD ($)</button>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       PRICING TIERS & INCLUSIONS
       ========================================================================== -->
  <section class="pricing-section">
    <div class="container">
      
      <!-- Pricing Plans Grid -->
      <div class="pricing-grid">
        <?php if (!empty($plans)): ?>
          <?php foreach ($plans as $plan): 
            $isPopular = (bool)$plan['is_popular'];
            $badge = $plan['badge_text'] ?: ($isPopular ? 'Most Requested' : '');
            $priceInrFormatted = '₹' . number_format((float)$plan['price_inr']);
            $priceUsdFormatted = '$' . number_format((float)$plan['price_usd']);
            $features = $plan['features'] ?? [];
            $ctaLabel = $isPopular ? 'Select Growth Platform' : ($plan['plan_code'] === 'ENGINEERING_POD' ? 'Hire Dedicated Team' : 'Book Starter Sprint');
          ?>
            <div class="pricing-card <?= $isPopular ? 'popular' : '' ?>">
              <?php if (!empty($badge)): ?>
                <span class="popular-pill"><?= htmlspecialchars($badge) ?></span>
              <?php endif; ?>
              <div>
                <h3 class="tier-name"><?= htmlspecialchars($plan['name']) ?></h3>
                <p class="tier-desc"><?= htmlspecialchars($plan['short_desc']) ?></p>
                
                <div class="tier-price-box">
                  <div class="tier-price" data-inr="<?= $priceInrFormatted ?>" data-usd="<?= $priceUsdFormatted ?>">
                    <span class="price-val"><?= $priceInrFormatted ?></span>
                    <span style="font-size: 1rem; font-weight: 500; color: #64748b;"><?= htmlspecialchars($plan['period_label']) ?></span>
                  </div>
                  <div class="tier-period"><?= htmlspecialchars($plan['estimated_duration']) ?></div>
                </div>

                <?php if (!empty($features)): ?>
                  <ul class="features-list">
                    <?php foreach ($features as $f): ?>
                      <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span><?= htmlspecialchars($f['feature_text']) ?></span>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </div>
              <button class="btn-primary" style="width: 100%;" onclick="openConsultationModal('<?= htmlspecialchars(addslashes($plan['name'])) ?>')">
                <span><?= $ctaLabel ?></span>
              </button>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Guaranteed Inclusions Card -->
      <div class="inclusions-card">
        <h3 style="font-family: var(--font-display); font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 8px;">
          <?= htmlspecialchars($sections['inclusions_guarantee']['title'] ?? 'Standard Inclusions in Every Click Codex Engagement') ?>
        </h3>
        <p style="color: #64748b; font-size: 1rem;">
          <?= htmlspecialchars($sections['inclusions_guarantee']['subtitle'] ?? 'Regardless of project size, our clients receive clear deliverables, clean code, and direct communication from day one.') ?>
        </p>

        <div class="inclusions-grid">
          <?php if (!empty($inclusions)): ?>
            <?php foreach ($inclusions as $inc): ?>
              <div class="inc-item">
                <div class="inc-icon"><?= htmlspecialchars($inc['icon_symbol']) ?></div>
                <div>
                  <div class="inc-title"><?= htmlspecialchars($inc['title']) ?></div>
                  <div class="inc-desc"><?= htmlspecialchars($inc['description']) ?></div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </section>

  <!-- ==========================================================================
       PRICING & BILLING STRATEGY FAQS
       ========================================================================== -->
  <section class="faq-section">
    <div class="container">
      <div style="text-align: center; max-width: 750px; margin: 0 auto 50px;">
        <span class="preview-badge" style="margin-bottom: 12px; background: rgba(0,86,214,0.06); color: var(--brand-blue); border: 1px solid rgba(0,86,214,0.18);">
          <span>Financial Transparency</span>
        </span>
        <h2 style="font-family: var(--font-display); font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 12px;">Frequently Asked Billing Questions</h2>
        <p style="color: #64748b;">Clear answers regarding payment milestones, currency handling, and code ownership.</p>
      </div>

      <div class="faq-accordion">
        <?php if (!empty($faqs)): ?>
          <?php foreach ($faqs as $i => $faq): ?>
            <div class="faq-item <?= $i === 0 ? 'open' : '' ?>">
              <div class="faq-question" onclick="toggleFaq(this)">
                <span><?= htmlspecialchars($faq['question']) ?></span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
              </div>
              <div class="faq-answer">
                <?= nl2br(htmlspecialchars($faq['answer'])) ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>

<script>
  // Real-time Currency Switcher (INR / USD)
  function setCurrency(currency) {
    const btnInr = document.getElementById('btnInr');
    const btnUsd = document.getElementById('btnUsd');
    const priceElements = document.querySelectorAll('.tier-price');

    if (currency === 'USD') {
      if (btnInr) btnInr.classList.remove('active');
      if (btnUsd) btnUsd.classList.add('active');

      priceElements.forEach(el => {
        const valEl = el.querySelector('.price-val');
        const usdVal = el.getAttribute('data-usd');
        if (valEl && usdVal) {
          valEl.textContent = usdVal;
        }
      });
    } else {
      if (btnUsd) btnUsd.classList.remove('active');
      if (btnInr) btnInr.classList.add('active');

      priceElements.forEach(el => {
        const valEl = el.querySelector('.price-val');
        const inrVal = el.getAttribute('data-inr');
        if (valEl && inrVal) {
          valEl.textContent = inrVal;
        }
      });
    }
  }

  // FAQ Accordion Toggle
  function toggleFaq(el) {
    const item = el.closest('.faq-item');
    if (item) {
      item.classList.toggle('open');
    }
  }
</script>

<?php include __DIR__ . '/layout/footer.php'; ?>
