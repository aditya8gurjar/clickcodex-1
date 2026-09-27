<?php
/**
 * ClickCodex Technologies - Solution Advisor / Service Finder View
 * Interactive 60-second architecture decision framework, educational matrix, and trade-off table.
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

include __DIR__ . '/layout/header.php';

// Prepare step questions mapped by step number
$qStep1 = null;
$qStep2 = null;
$qStep3 = null;
$qStep4 = null;

if (!empty($questions)) {
    foreach ($questions as $q) {
        $stepNum = (int)($q['step_number'] ?? 0);
        if ($stepNum === 1) $qStep1 = $q;
        elseif ($stepNum === 2) $qStep2 = $q;
        elseif ($stepNum === 3) $qStep3 = $q;
        elseif ($stepNum === 4) $qStep4 = $q;
    }
}

// Badge color palettes for Archetypes
$archetypePalettes = [
    1 => ['bg' => 'rgba(0, 86, 214, 0.08)', 'color' => 'var(--brand-blue, #0056d6)'],
    2 => ['bg' => 'rgba(147, 51, 234, 0.08)', 'color' => '#7c3aed'],
    3 => ['bg' => 'rgba(234, 88, 12, 0.08)', 'color' => '#c2410c'],
    4 => ['bg' => 'rgba(16, 185, 129, 0.08)', 'color' => '#059669'],
    5 => ['bg' => 'rgba(219, 39, 119, 0.08)', 'color' => '#be185d'],
    6 => ['bg' => 'rgba(0, 162, 255, 0.08)', 'color' => '#0284c7'],
];
?>

<main>
  <!-- ==========================================================================
       HERO SECTION
       ========================================================================== -->
  <section class="finder-hero">
    <div class="container">
      <div class="finder-badge">
        <span><?= htmlspecialchars($sections['finder_hero']['badge_text'] ?? '🎯 Solution & Architecture Advisor') ?></span>
      </div>
      <h1>
        Not Sure Which <span class="gradient-text">Website or Software</span> You Need?
      </h1>
      <p class="hero-desc">
        <?= htmlspecialchars($sections['finder_hero']['subtitle'] ?? 'Building the wrong digital architecture wastes months of engineering time and burns valuable budget. Take our 60-second interactive assessment to get an instant tailored digital blueprint, tech stack recommendation, and timeline estimate.') ?>
      </p>
      <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
        <a href="#advisor" class="btn-primary" style="padding: 16px 36px; font-size: 1.05rem;">
          <span><?= htmlspecialchars($sections['finder_hero']['cta_primary_text'] ?? 'Start 60-Second Assessment') ?></span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
        </a>
        <a href="#matrix" class="btn-secondary" style="padding: 16px 32px; font-size: 1.05rem;">
          <span><?= htmlspecialchars($sections['finder_hero']['cta_secondary_text'] ?? 'View Architecture Matrix') ?></span>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h18v18H3zM3 9h18M3 15h18M9 3v18M15 3v18"/></svg>
        </a>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       INTERACTIVE ADVISOR TOOL
       ========================================================================== -->
  <section class="advisor-section" id="advisor">
    <div class="container">
      <div class="advisor-container">
        
        <!-- Progress Tracker Header -->
        <div class="advisor-progress-header">
          <div class="progress-bar-bg">
            <div class="progress-bar-fill" id="progressFill" style="width: 25%;"></div>
          </div>
          <div class="step-indicator-text">
            <span id="stepLabel">Step 1 of 4: Primary Goal</span>
            <span id="percentageLabel">25% Completed</span>
          </div>
        </div>

        <!-- STEP 1: Primary Goal -->
        <div class="question-screen active" id="step1">
          <h2 class="question-title">
            <?= htmlspecialchars($qStep1['question_text'] ?? 'What is your primary commercial or technical goal?') ?>
          </h2>
          <p class="question-subtitle">
            <?= htmlspecialchars($qStep1['question_subtitle'] ?? 'Select the single outcome that matters most to your business right now.') ?>
          </p>

          <div class="options-grid">
            <?php if (!empty($qStep1['options'])): ?>
              <?php foreach ($qStep1['options'] as $opt): ?>
                <div class="option-card" onclick="selectOption('goal', '<?= htmlspecialchars($opt['option_key']) ?>', this)">
                  <div class="option-icon"><?= $opt['icon_emoji'] ?></div>
                  <div>
                    <h3 class="option-title"><?= htmlspecialchars($opt['title']) ?></h3>
                    <p class="option-desc"><?= htmlspecialchars($opt['description']) ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="option-card" onclick="selectOption('goal', 'landing', this)">
                <div class="option-icon">🚀</div>
                <div>
                  <h3 class="option-title">Generate Inquiries & Leads Fast</h3>
                  <p class="option-desc">High-converting landing page to run paid ads, validate a product, or pitch services.</p>
                </div>
              </div>
              <div class="option-card" onclick="selectOption('goal', 'corporate', this)">
                <div class="option-icon">🏢</div>
                <div>
                  <h3 class="option-title">Establish Company Credibility & SEO</h3>
                  <p class="option-desc">Comprehensive corporate website showcasing team, portfolio, blog, and authority.</p>
                </div>
              </div>
              <div class="option-card" onclick="selectOption('goal', 'ecommerce', this)">
                <div class="option-icon">🛍️</div>
                <div>
                  <h3 class="option-title">Sell Physical or Digital Products</h3>
                  <p class="option-desc">Online storefront with cart, checkout, Indian/global payment gateways, and inventory.</p>
                </div>
              </div>
              <div class="option-card" onclick="selectOption('goal', 'saas', this)">
                <div class="option-icon">⚡</div>
                <div>
                  <h3 class="option-title">Custom SaaS / Web Application</h3>
                  <p class="option-desc">Complex web app with user authentication, database logic, subscription billing, and dashboards.</p>
                </div>
              </div>
              <div class="option-card" onclick="selectOption('goal', 'mobile', this)">
                <div class="option-icon">📱</div>
                <div>
                  <h3 class="option-title">Cross-Platform Mobile App</h3>
                  <p class="option-desc">iOS and Android application with push notifications, offline storage, and app store deployment.</p>
                </div>
              </div>
              <div class="option-card" onclick="selectOption('goal', 'ai', this)">
                <div class="option-icon">🧠</div>
                <div>
                  <h3 class="option-title">AI System or Automation Engine</h3>
                  <p class="option-desc">Automated reasoning, custom LLM integration, document parsing, or internal workflow automation.</p>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <div class="advisor-actions-row">
            <span style="font-size: 0.88rem; color: #94a3b8;">Choose an option to continue</span>
            <button class="btn-primary" id="btnNext1" onclick="nextStep(2)" disabled style="opacity: 0.5;">
              <span>Continue &rarr;</span>
            </button>
          </div>
        </div>

        <!-- STEP 2: Scale & Stage -->
        <div class="question-screen" id="step2">
          <h2 class="question-title">
            <?= htmlspecialchars($qStep2['question_text'] ?? 'What stage is your business currently in?') ?>
          </h2>
          <p class="question-subtitle">
            <?= htmlspecialchars($qStep2['question_subtitle'] ?? 'This helps us scale server infrastructure and choose the right maintenance overhead.') ?>
          </p>

          <div class="options-grid">
            <?php if (!empty($qStep2['options'])): ?>
              <?php foreach ($qStep2['options'] as $opt): ?>
                <div class="option-card" onclick="selectOption('stage', '<?= htmlspecialchars($opt['option_key']) ?>', this)">
                  <div class="option-icon"><?= $opt['icon_emoji'] ?></div>
                  <div>
                    <h3 class="option-title"><?= htmlspecialchars($opt['title']) ?></h3>
                    <p class="option-desc"><?= htmlspecialchars($opt['description']) ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="option-card" onclick="selectOption('stage', 'mvp', this)">
                <div class="option-icon">🌱</div>
                <div>
                  <h3 class="option-title">Startup / Idea Stage (MVP)</h3>
                  <p class="option-desc">Speed to market is paramount. Lean, agile launch to validate product-market fit.</p>
                </div>
              </div>
              <div class="option-card" onclick="selectOption('stage', 'growth', this)">
                <div class="option-icon">📈</div>
                <div>
                  <h3 class="option-title">Growing Business / SME</h3>
                  <p class="option-desc">Existing revenue. We need higher conversions, polished design, and scalable infrastructure.</p>
                </div>
              </div>
              <div class="option-card" onclick="selectOption('stage', 'enterprise', this)">
                <div class="option-icon">🏛️</div>
                <div>
                  <h3 class="option-title">Established Enterprise</h3>
                  <p class="option-desc">High volume, multi-region compliance, enterprise security, SLA guarantees, and legacy integration.</p>
                </div>
              </div>
              <div class="option-card" onclick="selectOption('stage', 'redesign', this)">
                <div class="option-icon">🔄</div>
                <div>
                  <h3 class="option-title">Total Re-Engineering / Overhaul</h3>
                  <p class="option-desc">Current website or app is slow, outdated, or broken. Complete end-to-end modernization.</p>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <div class="advisor-actions-row">
            <button class="btn-secondary" onclick="prevStep(1)">&larr; Back</button>
            <button class="btn-primary" id="btnNext2" onclick="nextStep(3)" disabled style="opacity: 0.5;">
              <span>Continue &rarr;</span>
            </button>
          </div>
        </div>

        <!-- STEP 3: Must-Have Features (Multi-Select) -->
        <div class="question-screen" id="step3">
          <h2 class="question-title">
            <?= htmlspecialchars($qStep3['question_text'] ?? 'Which features do you anticipate needing?') ?>
          </h2>
          <p class="question-subtitle">
            <?= htmlspecialchars($qStep3['question_subtitle'] ?? 'Select all that apply to your product roadmap.') ?>
          </p>

          <div class="features-chips-grid">
            <?php if (!empty($qStep3['options'])): ?>
              <?php foreach ($qStep3['options'] as $opt): ?>
                <div class="feature-chip-card" onclick="toggleFeature('<?= htmlspecialchars($opt['title']) ?>', this)">
                  <div class="checkbox-indicator">✓</div>
                  <span class="feature-chip-text"><?= htmlspecialchars($opt['title']) ?></span>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="feature-chip-card" onclick="toggleFeature('User Authentication & Roles', this)">
                <div class="checkbox-indicator">✓</div>
                <span class="feature-chip-text">User Accounts & Logins</span>
              </div>
              <div class="feature-chip-card" onclick="toggleFeature('Payment Gateways (UPI/Cards)', this)">
                <div class="checkbox-indicator">✓</div>
                <span class="feature-chip-text">Payment Gateway (Stripe/Razorpay)</span>
              </div>
              <div class="feature-chip-card" onclick="toggleFeature('Content Management System (CMS)', this)">
                <div class="checkbox-indicator">✓</div>
                <span class="feature-chip-text">CMS (Blogs / Case Studies)</span>
              </div>
              <div class="feature-chip-card" onclick="toggleFeature('Real-time WebSockets / Chat', this)">
                <div class="checkbox-indicator">✓</div>
                <span class="feature-chip-text">Real-time Chat & WebSockets</span>
              </div>
              <div class="feature-chip-card" onclick="toggleFeature('3D WebGL Animations', this)">
                <div class="checkbox-indicator">✓</div>
                <span class="feature-chip-text">Interactive 3D / WebGL</span>
              </div>
              <div class="feature-chip-card" onclick="toggleFeature('AI Copilot / Smart Search', this)">
                <div class="checkbox-indicator">✓</div>
                <span class="feature-chip-text">AI Copilot / Semantic Search</span>
              </div>
              <div class="feature-chip-card" onclick="toggleFeature('Multi-Language Localization', this)">
                <div class="checkbox-indicator">✓</div>
                <span class="feature-chip-text">Multi-Language Support</span>
              </div>
              <div class="feature-chip-card" onclick="toggleFeature('Custom CRM & ERP Sync', this)">
                <div class="checkbox-indicator">✓</div>
                <span class="feature-chip-text">CRM / ERP Integration</span>
              </div>
            <?php endif; ?>
          </div>

          <div class="advisor-actions-row">
            <button class="btn-secondary" onclick="prevStep(2)">&larr; Back</button>
            <button class="btn-primary" onclick="nextStep(4)">
              <span>Continue &rarr;</span>
            </button>
          </div>
        </div>

        <!-- STEP 4: Timeline & Target -->
        <div class="question-screen" id="step4">
          <h2 class="question-title">
            <?= htmlspecialchars($qStep4['question_text'] ?? 'What is your target launch timeline?') ?>
          </h2>
          <p class="question-subtitle">
            <?= htmlspecialchars($qStep4['question_subtitle'] ?? 'We balance sprint velocity with rigorous QA and security audits.') ?>
          </p>

          <div class="options-grid">
            <?php if (!empty($qStep4['options'])): ?>
              <?php foreach ($qStep4['options'] as $opt): ?>
                <div class="option-card" onclick="selectOption('timeline', '<?= htmlspecialchars($opt['option_key']) ?>', this)">
                  <div class="option-icon"><?= $opt['icon_emoji'] ?></div>
                  <div>
                    <h3 class="option-title"><?= htmlspecialchars($opt['title']) ?></h3>
                    <p class="option-desc"><?= htmlspecialchars($opt['description']) ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="option-card" onclick="selectOption('timeline', 'rapid', this)">
                <div class="option-icon">⚡</div>
                <div>
                  <h3 class="option-title">Rapid Sprint (2 – 4 Weeks)</h3>
                  <p class="option-desc">Need immediate launch for upcoming funding, marketing campaign, or pilot.</p>
                </div>
              </div>
              <div class="option-card" onclick="selectOption('timeline', 'standard', this)">
                <div class="option-icon">🎯</div>
                <div>
                  <h3 class="option-title">Standard Product Build (6 – 10 Weeks)</h3>
                  <p class="option-desc">Structured UX prototyping, full engineering sprints, automated testing, and staging.</p>
                </div>
              </div>
              <div class="option-card" onclick="selectOption('timeline', 'comprehensive', this)">
                <div class="option-icon">🛡️</div>
                <div>
                  <h3 class="option-title">Enterprise Roadmap (3 – 6 Months)</h3>
                  <p class="option-desc">Extensive microservices architecture, pen-testing, compliance certification, and multi-team rollout.</p>
                </div>
              </div>
              <div class="option-card" onclick="selectOption('timeline', 'flexible', this)">
                <div class="option-icon">🗓️</div>
                <div>
                  <h3 class="option-title">Flexible / Consultative</h3>
                  <p class="option-desc">I want Click Codex team to review our scope and suggest the optimal phased release.</p>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <div class="advisor-actions-row">
            <button class="btn-secondary" onclick="prevStep(3)">&larr; Back</button>
            <button class="btn-primary" id="btnCalculate" onclick="calculateBlueprint()" disabled style="opacity: 0.5;">
              <span>Generate My Digital Blueprint &rarr;</span>
            </button>
          </div>
        </div>

        <!-- RESULT SCREEN: DYNAMIC BLUEPRINT -->
        <div class="blueprint-screen" id="blueprintResult">
          <div class="blueprint-header">
            <span class="blueprint-badge">✓ Customized Architecture Blueprint</span>
            <h2 class="blueprint-title" id="bpTitle">Next-Gen Custom Web Platform</h2>
            <p style="color: #64748b; font-size: 1.05rem;" id="bpSubtitle">Based on your business objectives, here is our recommended architecture and execution plan.</p>
          </div>

          <div class="blueprint-dossier-card">
            <div class="dossier-grid">
              <div class="dossier-col">
                <h4>Recommended Software Type</h4>
                <p id="bpTypeDesc">High-performance full-stack web application with serverless cloud infrastructure.</p>
                
                <div style="margin-top: 18px;">
                  <h4>Recommended Core Tech Stack</h4>
                  <div class="tech-pills-row" id="bpTechPills">
                    <span class="tech-pill">Next.js 15</span>
                    <span class="tech-pill">Node.js</span>
                    <span class="tech-pill">PostgreSQL</span>
                    <span class="tech-pill">Cloudflare Edge</span>
                  </div>
                </div>
              </div>

              <div class="dossier-col">
                <h4>Why This Architecture Fits You Best</h4>
                <p id="bpRationale">Provides maximum performance, zero hydration penalties, instant page loads for high conversions, and unlimited scaling flexibility without expensive third-party platform lock-in.</p>

                <div style="margin-top: 18px;">
                  <h4>Included In Scope</h4>
                  <p id="bpScope" style="font-size: 0.88rem; color: #475569;">✓ Responsive Mobile-First Design • ✓ Full Source Code Ownership • ✓ 30-Day Post-Launch Warranty • ✓ SEO & Analytics Setup</p>
                </div>
              </div>
            </div>

            <!-- Metrics Summary -->
            <div class="dossier-metrics-bar">
              <div>
                <div class="dossier-metric-val" id="bpTimeline">4 - 6 Weeks</div>
                <div class="dossier-metric-lbl">Estimated Sprint Delivery</div>
              </div>
              <div>
                <div class="dossier-metric-val" id="bpTeam">Direct Pod (4 Members)</div>
                <div class="dossier-metric-lbl">Collaborative Team Pod</div>
              </div>
              <div>
                <div class="dossier-metric-val" id="bpTier">Growth Tier</div>
                <div class="dossier-metric-lbl">Investment Package</div>
              </div>
            </div>
          </div>

          <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <button class="btn-primary" onclick="requestBlueprintProposal()" style="padding: 16px 36px; font-size: 1.05rem;">
              <span>Request Detailed Proposal For This Blueprint</span>
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
            <button class="btn-secondary" onclick="resetAdvisor()">
              <span>🔄 Restart Assessment</span>
            </button>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ==========================================================================
       EDUCATIONAL MATRIX: WEBSITE ARCHETYPES EXPLAINED
       ========================================================================== -->
  <section class="educational-section" id="archetypes">
    <div class="container">
      <div class="edu-header">
        <span class="finder-badge"><?= htmlspecialchars($sections['educational_archetypes']['badge_text'] ?? '📚 Technical Knowledge Base') ?></span>
        <h2><?= htmlspecialchars($sections['educational_archetypes']['title'] ?? 'The 6 Digital Architecture Archetypes') ?></h2>
        <p style="font-size: 1.1rem; color: #64748b; line-height: 1.7;">
          <?= htmlspecialchars($sections['educational_archetypes']['subtitle'] ?? 'Understand the key trade-offs between speed, cost, flexibility, and scalability so you make the best investment for your business.') ?>
        </p>
      </div>

      <div class="edu-grid">
        <?php if (!empty($archetypes)): ?>
          <?php foreach ($archetypes as $idx => $arch): 
            $palette = $archetypePalettes[($idx % 6) + 1] ?? ['bg' => 'rgba(0,86,214,0.08)', 'color' => '#0056d6'];
            $checklists = $arch['checklists_array'] ?? [];
          ?>
            <div class="edu-card">
              <div>
                <span class="edu-badge" style="background: <?= $palette['bg'] ?>; color: <?= $palette['color'] ?>;">
                  <?= htmlspecialchars($arch['badge_text'] ?? ('Archetype 0' . ($idx + 1))) ?>
                </span>
                <h3><?= htmlspecialchars($arch['name']) ?></h3>
                <p class="edu-desc">
                  <?= htmlspecialchars($arch['description']) ?>
                </p>
                <?php if (!empty($checklists)): ?>
                  <ul class="edu-checklist">
                    <?php foreach ($checklists as $item): ?>
                      <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <?= htmlspecialchars($item) ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </div>
              <div class="edu-stack-row">
                <span class="label">Best For:</span>
                <span class="val"><?= htmlspecialchars($arch['best_for'] ?? 'High-Growth Ventures') ?></span>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       ARCHITECTURE COMPARISON MATRIX TABLE
       ========================================================================== -->
  <section class="matrix-section" id="matrix">
    <div class="container">
      <div style="text-align: center; max-width: 750px; margin: 0 auto 50px;">
        <h2 style="font-family: var(--font-display); font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 12px;">
          <?= htmlspecialchars($sections['comparison_matrix']['title'] ?? 'Architecture Trade-Off Matrix') ?>
        </h2>
        <p style="color: #64748b;">
          <?= htmlspecialchars($sections['comparison_matrix']['subtitle'] ?? 'Compare delivery velocity, initial investment, scalability ceiling, and maintenance overhead across all digital archetypes.') ?>
        </p>
      </div>

      <div class="matrix-table-wrap">
        <table class="matrix-table">
          <thead>
            <tr>
              <th>Digital Archetype</th>
              <th>Time to Market</th>
              <th>Investment Tier</th>
              <th>Scalability Ceiling</th>
              <th>SEO Dominance</th>
              <th>Maintenance</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($archetypes)): ?>
              <?php foreach ($archetypes as $arch): ?>
                <tr>
                  <td><strong><?= htmlspecialchars($arch['name']) ?></strong></td>
                  <td><?= htmlspecialchars($arch['time_to_market']) ?></td>
                  <td><?= htmlspecialchars($arch['investment_tier']) ?></td>
                  <td><?= htmlspecialchars($arch['scalability_ceiling']) ?></td>
                  <td><?= htmlspecialchars($arch['seo_dominance']) ?></td>
                  <td><?= htmlspecialchars($arch['maintenance_overhead']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td><strong>High-Converting Landing Page</strong></td>
                <td>1 – 2 Weeks</td>
                <td>Lean / MVP</td>
                <td>High (Static Edge)</td>
                <td>Targeted Keywords</td>
                <td>Very Low</td>
              </tr>
              <tr>
                <td><strong>Corporate Authority Platform</strong></td>
                <td>3 – 5 Weeks</td>
                <td>Growth Tier</td>
                <td>Very High</td>
                <td>Maximum (Multi-Page)</td>
                <td>Low (CMS managed)</td>
              </tr>
              <tr>
                <td><strong>E-Commerce Storefront</strong></td>
                <td>4 – 8 Weeks</td>
                <td>Growth to Enterprise</td>
                <td>Massive (Multi-region)</td>
                <td>High (Product schema)</td>
                <td>Moderate (Inventory sync)</td>
              </tr>
              <tr>
                <td><strong>Custom SaaS & Web App</strong></td>
                <td>6 – 12 Weeks</td>
                <td>Enterprise Custom</td>
                <td>Unlimited (Microservices)</td>
                <td>Moderate (Auth locked)</td>
                <td>Active Monitoring</td>
              </tr>
              <tr>
                <td><strong>Mobile App (iOS & Android)</strong></td>
                <td>8 – 14 Weeks</td>
                <td>Enterprise Custom</td>
                <td>High (Store native)</td>
                <td>App Store Optimization</td>
                <td>OS Update Cycles</td>
              </tr>
              <tr>
                <td><strong>AI & Intelligent Automation</strong></td>
                <td>6 – 12 Weeks</td>
                <td>Enterprise Custom</td>
                <td>High (Distributed GPU)</td>
                <td>Application Focused</td>
                <td>Model Monitoring</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       FREQUENTLY ASKED STRATEGY QUESTIONS
       ========================================================================== -->
  <section class="faq-section">
    <div class="container">
      <div style="text-align: center; max-width: 750px; margin: 0 auto 50px;">
        <h2 style="font-family: var(--font-display); font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 12px;">Strategic Advisory FAQs</h2>
        <p style="color: #64748b;">Common questions our team answers during project discovery sessions.</p>
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

<!-- Interactive Advisor JavaScript Logic -->
<script>
  const userSelections = {
    goal: '',
    stage: '',
    features: [],
    timeline: ''
  };

  function selectOption(category, value, el) {
    userSelections[category] = value;
    const parent = el.parentElement;
    parent.querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');

    if (category === 'goal') {
      const btn = document.getElementById('btnNext1');
      if (btn) {
        btn.disabled = false;
        btn.style.opacity = '1';
      }
    } else if (category === 'stage') {
      const btn = document.getElementById('btnNext2');
      if (btn) {
        btn.disabled = false;
        btn.style.opacity = '1';
      }
    } else if (category === 'timeline') {
      const btn = document.getElementById('btnCalculate');
      if (btn) {
        btn.disabled = false;
        btn.style.opacity = '1';
      }
    }
  }

  function toggleFeature(featureName, el) {
    const idx = userSelections.features.indexOf(featureName);
    if (idx === -1) {
      userSelections.features.push(featureName);
      el.classList.add('selected');
    } else {
      userSelections.features.splice(idx, 1);
      el.classList.remove('selected');
    }
  }

  function nextStep(stepNumber) {
    document.querySelectorAll('.question-screen').forEach(s => s.classList.remove('active'));
    const nextScreen = document.getElementById('step' + stepNumber);
    if (nextScreen) nextScreen.classList.add('active');

    const progressFill = document.getElementById('progressFill');
    const stepLabel = document.getElementById('stepLabel');
    const percentageLabel = document.getElementById('percentageLabel');

    const percent = stepNumber * 25;
    if (progressFill) progressFill.style.width = percent + '%';
    if (percentageLabel) percentageLabel.textContent = percent + '% Completed';

    const labels = [
      'Step 1 of 4: Primary Goal',
      'Step 2 of 4: Business Stage',
      'Step 3 of 4: Desired Capabilities',
      'Step 4 of 4: Target Timeline'
    ];
    if (stepLabel) stepLabel.textContent = labels[stepNumber - 1] || 'Assessment Complete';
  }

  function prevStep(stepNumber) {
    nextStep(stepNumber);
  }

  function calculateBlueprint() {
    document.querySelectorAll('.question-screen').forEach(s => s.classList.remove('active'));
    const blueprint = document.getElementById('blueprintResult');
    if (blueprint) blueprint.classList.add('active');

    const progressFill = document.getElementById('progressFill');
    if (progressFill) progressFill.style.width = '100%';
    const percentageLabel = document.getElementById('percentageLabel');
    if (percentageLabel) percentageLabel.textContent = '100% Complete';
    const stepLabel = document.getElementById('stepLabel');
    if (stepLabel) stepLabel.textContent = 'Your Tailored Architecture Blueprint';

    // Custom dynamic logic based on answers
    const bpTitle = document.getElementById('bpTitle');
    const bpTypeDesc = document.getElementById('bpTypeDesc');
    const bpTechPills = document.getElementById('bpTechPills');
    const bpRationale = document.getElementById('bpRationale');
    const bpTimeline = document.getElementById('bpTimeline');
    const bpTeam = document.getElementById('bpTeam');
    const bpTier = document.getElementById('bpTier');

    if (userSelections.goal === 'landing') {
      if (bpTitle) bpTitle.textContent = 'High-Speed Conversion Microsite & Lead Engine';
      if (bpTypeDesc) bpTypeDesc.textContent = 'Ultra-lightweight, 3D WebGL-enhanced single-page landing site engineered for maximum advertising ROI and instant customer acquisition.';
      if (bpTechPills) bpTechPills.innerHTML = '<span class="tech-pill">Next.js Edge</span><span class="tech-pill">Vanilla CSS Tokens</span><span class="tech-pill">Three.js</span><span class="tech-pill">Cloudflare CDN</span>';
      if (bpRationale) bpRationale.textContent = 'Ensures 99+ Google PageSpeed score and zero bounce rates from mobile paid advertising traffic.';
      if (bpTimeline) bpTimeline.textContent = '1 - 2 Weeks';
      if (bpTeam) bpTeam.textContent = 'Collaborative Team Pod';
      if (bpTier) bpTier.textContent = 'Starter Sprint';
    } else if (userSelections.goal === 'ecommerce') {
      if (bpTitle) bpTitle.textContent = 'Headless Omnichannel E-Commerce Platform';
      if (bpTypeDesc) bpTypeDesc.textContent = 'Custom digital storefront with multi-currency cart, instant checkout, and automated inventory sync across warehouses.';
      if (bpTechPills) bpTechPills.innerHTML = '<span class="tech-pill">Next.js Commerce</span><span class="tech-pill">Shopify / Medusa Headless</span><span class="tech-pill">Stripe / Razorpay</span><span class="tech-pill">Redis Cache</span>';
      if (bpRationale) bpRationale.textContent = 'Eliminates template lock-in, handles flash sales effortlessly, and provides tailored checkout funnels with zero performance slowdowns.';
      if (bpTimeline) bpTimeline.textContent = '4 - 8 Weeks';
      if (bpTeam) bpTeam.textContent = 'Collaborative Team Pod';
      if (bpTier) bpTier.textContent = 'Commerce Scale';
    } else if (userSelections.goal === 'saas') {
      if (bpTitle) bpTitle.textContent = 'Full-Stack Multi-Tenant SaaS Platform';
      if (bpTypeDesc) bpTypeDesc.textContent = 'Scalable cloud web application with authentication, RBAC permissions, PostgreSQL database, and automated billing subscriptions.';
      if (bpTechPills) bpTechPills.innerHTML = '<span class="tech-pill">React / Next.js</span><span class="tech-pill">Node.js Microservices</span><span class="tech-pill">PostgreSQL</span><span class="tech-pill">Docker</span>';
      if (bpRationale) bpRationale.textContent = 'Architected from day one for multi-tenant security, API extensibility, and seamless user lifecycle management.';
      if (bpTimeline) bpTimeline.textContent = '6 - 12 Weeks';
      if (bpTeam) bpTeam.textContent = 'Dedicated Pod (4 Members)';
      if (bpTier) bpTier.textContent = 'Custom Application';
    } else if (userSelections.goal === 'mobile') {
      if (bpTitle) bpTitle.textContent = 'Cross-Platform Mobile Application Ecosystem';
      if (bpTypeDesc) bpTypeDesc.textContent = 'Native compiled iOS and Android application with unified cloud API backend and real-time push notification services.';
      if (bpTechPills) bpTechPills.innerHTML = '<span class="tech-pill">Flutter 3.24</span><span class="tech-pill">Dart</span><span class="tech-pill">Firebase Cloud Messaging</span><span class="tech-pill">Node.js API</span>';
      if (bpRationale) bpRationale.textContent = 'Single codebase cuts development costs by 45% while delivering 120 FPS native mobile fluid performance across iOS and Android.';
      if (bpTimeline) bpTimeline.textContent = '8 - 14 Weeks';
      if (bpTeam) bpTeam.textContent = 'Direct Development Pod';
      if (bpTier) bpTier.textContent = 'Mobile Pod';
    } else if (userSelections.goal === 'ai') {
      if (bpTitle) bpTitle.textContent = 'Autonomous AI Workflow & Intelligent Agent Engine';
      if (bpTypeDesc) bpTypeDesc.textContent = 'Customized localized LLM pipeline, vector embeddings search, and autonomous workflow automation.';
      if (bpTechPills) bpTechPills.innerHTML = '<span class="tech-pill">Python / FastAPI</span><span class="tech-pill">LangChain / LlamaIndex</span><span class="tech-pill">Qdrant Vector DB</span><span class="tech-pill">React UI</span>';
      if (bpRationale) bpRationale.textContent = 'Private enterprise data ingestion with zero cloud security leakage and sub-second reasoning speed.';
      if (bpTimeline) bpTimeline.textContent = '6 - 10 Weeks';
      if (bpTeam) bpTeam.textContent = 'Collaborative Team Pod';
      if (bpTier) bpTier.textContent = 'AI Innovation Pod';
    } else {
      if (bpTitle) bpTitle.textContent = 'Corporate Authority & Digital Platform';
      if (bpTypeDesc) bpTypeDesc.textContent = 'Multi-page digital flagship with dynamic CMS, case studies showcase, and full-funnel search engine optimization.';
      if (bpTechPills) bpTechPills.innerHTML = '<span class="tech-pill">Next.js 15</span><span class="tech-pill">Headless CMS</span><span class="tech-pill">Tailored CSS Design System</span><span class="tech-pill">Cloudflare Edge</span>';
      if (bpRationale) bpRationale.textContent = 'Positions your brand as a clear authority in your market with top-tier search visibility and client trust.';
      if (bpTimeline) bpTimeline.textContent = '3 - 5 Weeks';
      if (bpTeam) bpTeam.textContent = 'Collaborative Team Pod';
      if (bpTier) bpTier.textContent = 'Growth Tier';
    }

    // Smooth scroll to results
    if (blueprint) {
      blueprint.scrollIntoView({ behavior: 'smooth' });
    }
  }

  function resetAdvisor() {
    userSelections.goal = '';
    userSelections.stage = '';
    userSelections.features = [];
    userSelections.timeline = '';

    document.querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
    document.querySelectorAll('.feature-chip-card').forEach(c => c.classList.remove('selected'));

    const btn1 = document.getElementById('btnNext1');
    if (btn1) { btn1.disabled = true; btn1.style.opacity = '0.5'; }
    const btn2 = document.getElementById('btnNext2');
    if (btn2) { btn2.disabled = true; btn2.style.opacity = '0.5'; }
    const btnCalc = document.getElementById('btnCalculate');
    if (btnCalc) { btnCalc.disabled = true; btnCalc.style.opacity = '0.5'; }

    const blueprint = document.getElementById('blueprintResult');
    if (blueprint) blueprint.classList.remove('active');
    nextStep(1);
  }

  function requestBlueprintProposal() {
    const titleEl = document.getElementById('bpTitle');
    const title = titleEl ? titleEl.textContent : 'Solution Blueprint';
    const featuresList = userSelections.features.length > 0 ? userSelections.features.join(', ') : 'Standard Features';
    const timelineEl = document.getElementById('bpTimeline');
    const timeline = timelineEl ? timelineEl.textContent : 'Standard Delivery';
    
    if (typeof openConsultationModal === 'function') {
      openConsultationModal(title);
    }
    const detailsInput = document.getElementById('projectDetails');
    if (detailsInput) {
      detailsInput.value = 'Generated Blueprint: ' + title + '\nDesired Capabilities: ' + featuresList + '\nEstimated Sprint: ' + timeline;
    }
  }

  function toggleFaq(el) {
    const item = el.closest('.faq-item');
    if (item) {
      item.classList.toggle('open');
    }
  }
</script>

<?php include __DIR__ . '/layout/footer.php'; ?>
