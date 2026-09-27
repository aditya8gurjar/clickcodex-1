<?php
/**
 * ClickCodex Technologies - Static Pages to Database Ingestion Engine
 * Extracts and injects 100% of full content, section blocks, legal policies,
 * case studies, deep articles, and individual SEO metadata into clickcodex_db.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

$conn = App\Config\Database::connect();
echo "==> Connected to ClickCodex Database\n";

// =============================================================================
// 1. UPDATE PAGES WITH FULL CONTENT
// =============================================================================
echo "--> Updating full page content...\n";

// Privacy Policy Full Content
$privacyPolicyHtml = <<<'HTML'
<div class="legal-document">
  <section class="legal-section">
    <h2>1. Commitment to Privacy</h2>
    <p>ClickCodex Technologies ("ClickCodex", "we", "us", or "our") respects your privacy and is dedicated to protecting the personal data of our website visitors, clients, and partners. This Privacy Policy outlines our practices regarding data collection, usage, and safeguarding in compliance with the Information Technology Act (India), the Digital Personal Data Protection Act (DPDP), and global privacy benchmarks including GDPR.</p>
  </section>

  <section class="legal-section">
    <h2>2. Information We Collect</h2>
    <p>When you interact with ClickCodex through our consultation forms, newsletter sign-ups, or direct correspondence, we may collect:</p>
    <ul>
      <li><strong>Personal & Contact Data:</strong> Full name, business email address, phone number, and WhatsApp contact.</li>
      <li><strong>Project Inquiries:</strong> Scope requirements, timelines, budget specifications, and technical preferences.</li>
      <li><strong>Technical Telemetry:</strong> Anonymized browser version, device category, IP address, and interaction analytics to improve website responsiveness.</li>
    </ul>
  </section>

  <section class="legal-section">
    <h2>3. How We Use Your Information</h2>
    <p>We process your information strictly for legitimate commercial and technical operations:</p>
    <ul>
      <li>To prepare project proposals, architecture estimates, and technical blueprints.</li>
      <li>To coordinate communications regarding scheduled strategy calls and development sprints.</li>
      <li>To send technical insights and architecture dispatch newsletters (only with explicit consent).</li>
      <li>We never sell, rent, or trade your personal or project data to third-party advertisers.</li>
    </ul>
  </section>

  <section class="legal-section">
    <h2>4. Data Security & Confidentiality</h2>
    <p>We implement enterprise-grade encryption (TLS 1.3 in transit and AES-256 at rest) across our servers and communication channels. Client project discussions are protected under standard non-disclosure agreements (NDAs).</p>
  </section>

  <section class="legal-section">
    <h2>5. Contact Us Regarding Privacy</h2>
    <p>If you have any questions or wish to exercise data access or deletion rights, please contact our Data Governance Officer at <strong>privacy@clickcodex.com</strong>.</p>
  </section>
</div>
HTML;

// Terms of Service Full Content
$termsOfServiceHtml = <<<'HTML'
<div class="legal-document">
  <section class="legal-section">
    <h2>1. Scope & Acceptance</h2>
    <p>By accessing the ClickCodex website or engaging ClickCodex Technologies for software engineering, design, or consulting services, you agree to comply with and be bound by these Terms of Service.</p>
  </section>

  <section class="legal-section">
    <h2>2. Intellectual Property & Ownership</h2>
    <p>ClickCodex operates on a strict "Client Owns All" model for custom client deliverables:</p>
    <ul>
      <li><strong>Assignment:</strong> Upon final milestone settlement, 100% of the intellectual property, source code, database architectures, and graphical design assets created for your engagement become your exclusive property.</li>
      <li><strong>Pre-Existing Tools:</strong> General-purpose open-source libraries or ClickCodex reusable boilerplate modules are provided under standard permissive licenses (MIT or Apache 2.0).</li>
    </ul>
  </section>

  <section class="legal-section">
    <h2>3. Sprints & Milestone Delivery</h2>
    <p>Projects are delivered in structured agile sprints with clear acceptance criteria. Each sprint includes staging server demonstrations, automated test coverage reports, and a formal review period prior to milestone sign-off.</p>
  </section>

  <section class="legal-section">
    <h2>4. Post-Launch Warranty & SLAs</h2>
    <p>Every fixed-scope engagement includes a complimentary 30-day post-launch warranty covering software defect resolution and cross-browser performance anomalies. Extended support SLAs are governed by mutual service contracts.</p>
  </section>

  <section class="legal-section">
    <h2>5. Governing Law</h2>
    <p>These terms shall be governed by and construed in accordance with the laws of India, with legal jurisdiction in the courts of Bangalore / Mumbai.</p>
  </section>
</div>
HTML;

// About Us Full Overview Narrative
$aboutUsHtml = <<<'HTML'
<div class="about-overview-doc">
  <div class="founding-ethos">
    <span class="story-tagline">// 01. The Founding Ethos</span>
    <h3 class="story-lead">"We realized businesses didn't need another generic agency. They needed engineering partners who obsessed over their bottom line."</h3>
    <p>In 2016, ClickCodex was established with a singular conviction: too many great products fail not because of flawed ideas, but due to sloppy architecture, bloated code, and uninspired design.</p>
    <p>We eliminated traditional agency fluff. No endless middle management, no outsourced compromises. Just senior architects, creative engineers, and conversion scientists working in lockstep with founders.</p>
    <div class="story-quote-box">"Ideas without flawless execution are merely wishes. At ClickCodex, we engineer those wishes into market-defining solutions."</div>
  </div>

  <div class="synergy-manifesto">
    <h3>Converging Realities: Engineering Precision & Commercial Dominance</h3>
    <p>ClickCodex unifies two powerful forces: deep distributed systems engineering that guarantees sub-second responsiveness and zero tech debt, with conversion psychology that turns visitors into high-value repeat clients.</p>
  </div>
</div>
HTML;

$stmt = $conn->prepare("UPDATE `pages` SET `content` = ? WHERE `page_key` = ?");
$stmt->bind_param("ss", $privacyPolicyHtml, $k1);
$k1 = 'privacy_policy'; $stmt->execute();

$stmt->bind_param("ss", $termsOfServiceHtml, $k2);
$k2 = 'terms_of_service'; $stmt->execute();

$stmt->bind_param("ss", $aboutUsHtml, $k3);
$k3 = 'about_us'; $stmt->execute();
echo "✓ Legal and about pages populated with full content.\n";

// =============================================================================
// 2. INSERT 4 ADDITIONAL CASE STUDIES FEATURED ON HOMEPAGE
// =============================================================================
echo "--> Adding additional case studies from homepage...\n";
$additionalCaseStudies = [
    [
        'category_id' => 4, // Fintech & SaaS
        'slug' => 'innovate-inc-analytics-dashboard',
        'title' => 'Innovate Inc. Analytics Dashboard',
        'client_name' => 'Innovate Inc.',
        'client_location' => 'United States',
        'sector_industry' => 'SaaS & Enterprise Data Visualization',
        'timeline_duration' => '6 Weeks Sprint',
        'result_badge' => '+42% LEAD CONVERSION',
        'excerpt' => 'Real-time multi-tenant dashboard with complex data visualization, fast API pipelines, and role-based permissions.',
        'challenge_overview' => 'Engineered for an analytics firm seeking lightning-fast data processing and intuitive UI for non-technical enterprise executives without dashboard stuttering.',
        'architecture_solution' => 'Constructed high-speed reactive dashboards utilizing Next.js 14 and WebGL charts, backed by Redis caching pipelines and PostgreSQL read replicas.',
        'key_metrics' => json_encode([
            ['val' => '+42%', 'lbl' => 'Lead Conversion in 90 Days'],
            ['val' => '100k+', 'lbl' => 'Active Tenant Rows'],
            ['val' => '99.9%', 'lbl' => 'Uptime Guarantee']
        ]),
        'technologies' => json_encode(['Next.js', 'React', 'TypeScript', 'Redis', 'PostgreSQL', 'Tailwind', 'Chart.js']),
        'search_tech_keywords' => 'nextjs react typescript redis postgresql analytics saas dashboard',
        'featured_image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1000&q=80',
        'order_num' => 7
    ],
    [
        'category_id' => 3, // E-Commerce
        'slug' => 'mobilego-ecommerce-app',
        'title' => 'MobileGo E-Commerce Super-App',
        'client_name' => 'MobileGo Retail',
        'client_location' => 'India & UAE',
        'sector_industry' => 'Mobile E-Commerce & Retail',
        'timeline_duration' => '8 Weeks Sprint',
        'result_badge' => '+65% REPEAT PURCHASE',
        'excerpt' => 'Cross-platform retail shopping application with 1-click UPI payments, push offers, and dynamic inventory feeds.',
        'challenge_overview' => 'High-volume shopping app built for rapid seasonal sales spikes with zero checkout latency and seamless wallet integrations across Tier-1 and Tier-2 Indian cities.',
        'architecture_solution' => 'Built with Flutter 3 and native Android/iOS payment bridges for UPI and Razorpay, achieving 60fps animations and offline cart caching.',
        'key_metrics' => json_encode([
            ['val' => '+65%', 'lbl' => 'Repeat Purchase Rate'],
            ['val' => '0ms', 'lbl' => 'Checkout Latency'],
            ['val' => '1.5M', 'lbl' => 'App Downloads']
        ]),
        'technologies' => json_encode(['Flutter', 'Dart', 'Node.js', 'Razorpay UPI', 'Firebase Cloud Messaging', 'MongoDB']),
        'search_tech_keywords' => 'flutter dart nodejs razorpay upi mobile app ecommerce',
        'featured_image' => 'https://images.unsplash.com/photo-1512428559084-b384d544962e?w=1000&q=80',
        'order_num' => 8
    ],
    [
        'category_id' => 1, // Enterprise Web
        'slug' => 'nextgen-global-corporate-site',
        'title' => 'NextGen Corporate Authority Site',
        'client_name' => 'NextGen Global',
        'client_location' => 'Singapore & UK',
        'sector_industry' => 'Brand & Corporate Authority Web',
        'timeline_duration' => '4 Weeks Sprint',
        'result_badge' => '+78% ORGANIC INQUIRIES',
        'excerpt' => 'Brand identity overhaul and multilingual corporate website with dynamic careers and case study hubs.',
        'challenge_overview' => 'Rebuilt from the ground up to establish international authority, driving top-tier enterprise leads through programmatic SEO and sleek modern typography.',
        'architecture_solution' => 'Architected a statically generated Next.js web ecosystem with automated JSON-LD schema, 3D WebGL hero canvas, and integrated CMS.',
        'key_metrics' => json_encode([
            ['val' => '+78%', 'lbl' => 'Organic Search Traffic Lift'],
            ['val' => '99/100', 'lbl' => 'Lighthouse Performance'],
            ['val' => '3 Wks', 'lbl' => 'Time to Live Domain']
        ]),
        'technologies' => json_encode(['Next.js 15', 'TypeScript', 'Three.js', 'PostgreSQL', 'Cloudflare Workers']),
        'search_tech_keywords' => 'nextjs typescript threejs corporate seo authority branding',
        'featured_image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=1000&q=80',
        'order_num' => 9
    ],
    [
        'category_id' => 5, // AI & Cloud
        'slug' => 'marketboost-crm-platform',
        'title' => 'MarketBoost Sales Automation CRM',
        'client_name' => 'MarketBoost CRM',
        'client_location' => 'Mumbai, India',
        'sector_industry' => 'Enterprise Software & Sales Automation',
        'timeline_duration' => '10 Weeks Sprint',
        'result_badge' => '-35% SALES CYCLE TIME',
        'excerpt' => 'Custom workflow CRM integrating sales outreach, lead scoring, WhatsApp automation, and revenue forecasting.',
        'challenge_overview' => 'Unified a fragmented sales department across 4 regional branches into one centralized, automated pipeline with zero lead leakage.',
        'architecture_solution' => 'Engineered with React, Node.js microservices, Meta WhatsApp Business Cloud API, and real-time WebSocket pipelines.',
        'key_metrics' => json_encode([
            ['val' => '-35%', 'lbl' => 'Pipeline Closing Time'],
            ['val' => '10,000+', 'lbl' => 'Daily WhatsApp Leads'],
            ['val' => '100%', 'lbl' => 'Audit Trail Compliance']
        ]),
        'technologies' => json_encode(['React', 'Node.js', 'WhatsApp Cloud API', 'PostgreSQL', 'Redis', 'Docker']),
        'search_tech_keywords' => 'react nodejs whatsapp api crm automation enterprise software',
        'featured_image' => 'https://images.unsplash.com/photo-1600880292210-252c72b6b627?w=1000&q=80',
        'order_num' => 10
    ]
];

$csStmt = $conn->prepare("INSERT INTO `case_studies` 
  (`category_id`, `slug`, `title`, `client_name`, `client_location`, `sector_industry`, `timeline_duration`, `result_badge`, `excerpt`, `challenge_overview`, `architecture_solution`, `key_metrics`, `technologies`, `search_tech_keywords`, `featured_image`, `order_num`, `is_featured`, `is_active`, `published_at`)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, 1, NOW())
  ON DUPLICATE KEY UPDATE `title`=VALUES(`title`), `excerpt`=VALUES(`excerpt`), `key_metrics`=VALUES(`key_metrics`)");

foreach ($additionalCaseStudies as $cs) {
    $csStmt->bind_param("issssssssssssssi",
        $cs['category_id'],
        $cs['slug'],
        $cs['title'],
        $cs['client_name'],
        $cs['client_location'],
        $cs['sector_industry'],
        $cs['timeline_duration'],
        $cs['result_badge'],
        $cs['excerpt'],
        $cs['challenge_overview'],
        $cs['architecture_solution'],
        $cs['key_metrics'],
        $cs['technologies'],
        $cs['search_tech_keywords'],
        $cs['featured_image'],
        $cs['order_num']
    );
    $csStmt->execute();
}
echo "✓ Added 4 additional case studies from homepage.\n";

// =============================================================================
// 3. FULL BLOG POST CONTENT FROM blog-detail.html
// =============================================================================
echo "--> Updating Post 1 with complete teardown content from blog-detail.html...\n";
$fullArticleContent = <<<'HTML'
<div class="article-content-wrapper">
  <div class="metrics-bar">
    <div class="metric-col">
      <div class="metric-number">8.4ms</div>
      <div class="metric-label">P99 Global Latency</div>
    </div>
    <div class="metric-col">
      <div class="metric-number">240k</div>
      <div class="metric-label">Req / Sec Capacity</div>
    </div>
    <div class="metric-col">
      <div class="metric-number">68%</div>
      <div class="metric-label">Cloud Spend Cut</div>
    </div>
    <div class="metric-col">
      <div class="metric-number">99.999%</div>
      <div class="metric-label">Production SLA</div>
    </div>
  </div>

  <h2 id="section-1">1. The Latency Bottleneck at Modern Scale</h2>
  <p>
    When dealing with distributed financial transactions, e-commerce checkouts, or real-time collaborative workspaces, physical distance is an immutable law of physics. Light in vacuum travels at approximately 300,000 kilometers per second; in glass fiber, that speed drops to roughly 200,000 km/s. A packet traversing from Singapore to a centralized AWS <code>us-east-1</code> data center in Northern Virginia incurs a theoretical minimum physical round-trip time of ~140ms before a single byte of application logic executes.
  </p>
  <p>
    In high-stakes enterprise applications, this 140ms baseline translates to cart abandonment, lost algorithmic trades, and sluggish user feedback. During our engagement with a multi-jurisdiction financial exchange, our objective was uncompromising: <strong>guarantee P99 write latency under 10ms for 95% of the globe's internet-connected population.</strong>
  </p>

  <div class="callout-box warning">
    <div class="callout-title">The Traditional "Read-Replica" Fallacy</div>
    <p class="callout-desc">
      Deploying cross-region read-replicas only solves read paths. Write operations still pay the cross-ocean round-trip penalty, and eventual consistency lag causes dirty reads and race conditions when users execute immediate follow-up mutations.
    </p>
  </div>

  <h2 id="section-2">2. Centralized Cloud vs Distributed Edge Micro-Gateways</h2>
  <p>
    Traditional API architectures route traffic through an edge CDN solely for static asset delivery, terminating TLS and forwarding API payloads upstream to a centralized cluster of containers. 
  </p>
  <p>To shatter the latency floor, we decoupled business logic into two distinct tiers:</p>
  <ul>
    <li><strong>Edge Compute Workers:</strong> Running within 280+ Points of Presence (PoPs) globally via WebAssembly (Wasm) and Rust. These workers terminate TLS, validate cryptographically signed JWTs, execute local schema validation, and evaluate business rules locally.</li>
    <li><strong>Distributed Ledger & CRDT Fabric:</strong> Mutations are accepted deterministically at the edge node nearest to the user, immediately acknowledged with an optimistic idempotency token, and synchronized asynchronously across continental data centers.</li>
  </ul>

  <h2 id="section-3">3. The Rust Micro-Proxy Architecture</h2>
  <p>
    We chose Rust for edge proxies due to zero-cost abstractions, deterministic memory safety without a Garbage Collector (GC), and tiny compiled WebAssembly artifact binaries (< 1.8MB). Unlike V8 JavaScript runtimes that suffer from intermittent GC pauses, Rust ensures consistent microsecond-level execution.
  </p>
  <pre><code>// ClickCodex Edge Proxy JWT & Rate Limiting Handler
#[derive(Serialize, Deserialize)]
pub struct IngressPayload {
    pub tenant_id: String,
    pub transaction_id: String,
    pub payload_signature: String,
}

pub async fn handle_edge_request(req: Request) -> Result<Response, Error> {
    // 1. Verify TLS & cryptographic token in sub-1ms
    let claims = verify_jwt_claims(&req)?;
    
    // 2. Execute local rate limit via in-memory atomics
    if is_rate_limited(&claims.tenant_id) {
        return Ok(Response::error(429, "Rate limit exceeded"));
    }
    
    // 3. Dispatch optimistic acknowledgment to caller
    let ack_token = generate_idempotency_token(&req);
    dispatch_async_crdt_sync(req).await;
    
    Ok(Response::ok_json(ack_token))
}</code></pre>

  <h2 id="section-4">4. Zero-Lock State Sync via Conflict-Free Replicated Data Types (CRDTs)</h2>
  <p>
    By moving from pessimistic locking (e.g. <code>SELECT ... FOR UPDATE</code>) to State-based Conflict-Free Replicated Data Types (PN-Counters and LWW-Element-Sets), regional nodes can accept financial state transitions independently. When cross-regional synchronization occurs, state merges mathematically resolve conflicts deterministically without database deadlocks.
  </p>

  <h2 id="section-5">5. Production Benchmarks Under 240,000 Req/Sec</h2>
  <p>
    During Black Friday simulation testing, our edge network sustained 240,000 continuous requests per second across 28 edge locations. The P99 global latency stabilized at 8.4ms, with P50 median latency at 3.2ms. CPU overhead on origin database clusters dropped by 68%.
  </p>

  <h2 id="section-6">6. Architectural Implementation Checklist</h2>
  <ul>
    <li>Terminate TLS 1.3 at edge nodes using Anycast DNS routing.</li>
    <li>Validate authentication tokens at edge workers without upstream auth-server lookups.</li>
    <li>Use optimistic mutations backed by CRDT state merge semantics.</li>
    <li>Implement automated fallbacks to origin databases if edge worker memory bounds exceed 128MB.</li>
  </ul>
</div>
HTML;

$updateBlog = $conn->prepare("UPDATE `blog_posts` SET `content` = ? WHERE `slug` = 'sub-10ms-global-apis-edge-rust'");
$updateBlog->bind_param("s", $fullArticleContent);
$updateBlog->execute();
echo "✓ Post 1 content updated with complete article teardown.\n";

// =============================================================================
// 4. POPULATE PAGE SECTIONS FOR ALL PAGES
// =============================================================================
echo "--> Populating page_sections for all site pages...\n";

$sectionsData = [
    // Page 3: Services (services.html)
    [
        'page_id' => 3,
        'section_key' => 'services_hero',
        'title' => 'What We Build',
        'subtitle' => 'Every deliverable is crafted in-house by senior engineers and product designers with zero outsourcing compromises.',
        'badge_text' => 'Architectural Solutions',
        'cta_primary_text' => 'Book Free Architecture Call',
        'cta_primary_url' => '#contact',
        'cta_secondary_text' => 'Explore Portfolio',
        'cta_secondary_url' => '/portfolio',
        'settings_json' => json_encode(['canvas' => 'services_3d_lattice']),
        'order_num' => 1
    ],
    [
        'page_id' => 3,
        'section_key' => 'advisor_callout_strip',
        'title' => 'Which Website or Architecture Fits Your Business Goals?',
        'subtitle' => 'Avoid over-engineering or under-building. Take our 60-second interactive Solution Advisor quiz to match your stage, budget, and traffic targets with the ideal technical blueprint.',
        'badge_text' => 'Not Sure What You Need?',
        'cta_primary_text' => 'Launch Solution Advisor',
        'cta_primary_url' => '/service-finder',
        'cta_secondary_text' => NULL,
        'cta_secondary_url' => NULL,
        'settings_json' => json_encode(['icon' => 'compass']),
        'order_num' => 2
    ],
    [
        'page_id' => 3,
        'section_key' => 'services_catalog',
        'title' => 'Flagship Capabilities Catalog',
        'subtitle' => 'Six core architectural services crafted for velocity, scalability, and measurable ROI.',
        'badge_text' => 'Core Services',
        'cta_primary_text' => 'Request Architecture Audit',
        'cta_primary_url' => '#contact',
        'cta_secondary_text' => NULL,
        'cta_secondary_url' => NULL,
        'settings_json' => json_encode(['cards_count' => 6]),
        'order_num' => 3
    ],
    [
        'page_id' => 3,
        'section_key' => 'wireframe_reality_scanner',
        'title' => 'From Wireframe To Production Reality',
        'subtitle' => 'Drag the interactive split scanner to observe how ClickCodex transforms raw blueprint specifications into high-performing production applications.',
        'badge_text' => 'Interactive Architecture Scanner',
        'cta_primary_text' => 'View Production (100%)',
        'cta_primary_url' => '#reality-scanner',
        'cta_secondary_text' => 'Split 50/50 Scanner',
        'cta_secondary_url' => '#reality-scanner',
        'settings_json' => json_encode(['default_split' => 50, 'mrr_peak' => '$148,920']),
        'order_num' => 4
    ],
    [
        'page_id' => 3,
        'section_key' => 'growth_funnel',
        'title' => 'The High-Velocity Growth Funnel',
        'subtitle' => 'Software is only as good as the revenue it generates. Explore our 4-tier funnel designed to maximize visitor-to-customer conversion.',
        'badge_text' => 'Commercial Science',
        'cta_primary_text' => NULL,
        'cta_primary_url' => NULL,
        'cta_secondary_text' => NULL,
        'cta_secondary_url' => NULL,
        'settings_json' => json_encode(['tiers_count' => 4]),
        'order_num' => 5
    ],
    [
        'page_id' => 3,
        'section_key' => 'delivery_dossier',
        'title' => 'The ClickCodex Delivery Dossier',
        'subtitle' => 'How we take projects from napkin concepts to mission-critical deployments in 4 structured sprint phases.',
        'badge_text' => 'Rigorous Methodology',
        'cta_primary_text' => NULL,
        'cta_primary_url' => NULL,
        'cta_secondary_text' => NULL,
        'cta_secondary_url' => NULL,
        'settings_json' => json_encode(['phases_count' => 4]),
        'order_num' => 6
    ],

    // Page 4: Service Finder (service-finder.html)
    [
        'page_id' => 4,
        'section_key' => 'finder_hero',
        'title' => 'Find Your Ideal Digital Architecture',
        'subtitle' => 'Answer 4 simple questions about your goals, stage, and timeline to receive an instant, custom-tailored technical blueprint and scope estimate.',
        'badge_text' => 'Interactive Technical Advisor',
        'cta_primary_text' => 'Start 60-Sec Advisor',
        'cta_primary_url' => '#advisor',
        'cta_secondary_text' => 'View Architecture Matrix',
        'cta_secondary_url' => '#matrix',
        'settings_json' => json_encode(['steps' => 4]),
        'order_num' => 1
    ],
    [
        'page_id' => 4,
        'section_key' => 'educational_archetypes',
        'title' => 'The 6 Digital Architecture Archetypes',
        'subtitle' => 'Understand the key trade-offs between speed, cost, flexibility, and scalability so you make the best investment for your enterprise.',
        'badge_text' => 'Technical Knowledge Base',
        'cta_primary_text' => NULL,
        'cta_primary_url' => NULL,
        'cta_secondary_text' => NULL,
        'cta_secondary_url' => NULL,
        'settings_json' => json_encode(['archetypes_count' => 6]),
        'order_num' => 2
    ],
    [
        'page_id' => 4,
        'section_key' => 'comparison_matrix',
        'title' => 'Architecture Trade-Off Matrix',
        'subtitle' => 'Compare delivery velocity, initial investment, scalability ceiling, and maintenance overhead across all software archetypes.',
        'badge_text' => 'Decision Matrix',
        'cta_primary_text' => NULL,
        'cta_primary_url' => NULL,
        'cta_secondary_text' => NULL,
        'cta_secondary_url' => NULL,
        'settings_json' => json_encode(['table' => 'archetype_matrix']),
        'order_num' => 3
    ],

    // Page 5: Portfolio (portfolio.html)
    [
        'page_id' => 5,
        'section_key' => 'portfolio_hero',
        'title' => 'Case Studies & Deployments',
        'subtitle' => 'Every product engineered by ClickCodex is crafted with precision code, strict security compliance, and measured business ROI.',
        'badge_text' => 'Flagship Productions',
        'cta_primary_text' => 'Explore Case Studies',
        'cta_primary_url' => '#gallery',
        'cta_secondary_text' => 'Book Architecture Call',
        'cta_secondary_url' => '#consultation',
        'settings_json' => json_encode(['webgl_lattice' => true]),
        'order_num' => 1
    ],
    [
        'page_id' => 5,
        'section_key' => 'portfolio_gallery',
        'title' => 'Production Case Studies Hub',
        'subtitle' => 'Filter by category: Enterprise Web, Mobile Apps, E-Commerce, Fintech & SaaS, or AI & Cloud.',
        'badge_text' => 'Verified Results',
        'cta_primary_text' => NULL,
        'cta_primary_url' => NULL,
        'cta_secondary_text' => NULL,
        'cta_secondary_url' => NULL,
        'settings_json' => json_encode(['filters' => ['all', 'web', 'mobile', 'ecommerce', 'fintech', 'ai']]),
        'order_num' => 2
    ],

    // Page 6: Pricing (pricing.html)
    [
        'page_id' => 6,
        'section_key' => 'pricing_hero',
        'title' => 'Transparent Engagement Models',
        'subtitle' => 'No hidden fees. No junior handoffs. Every sprint is backed by senior engineers, 100% source code ownership, and guaranteed launch milestones.',
        'badge_text' => 'Clear & Predictable Investment',
        'cta_primary_text' => 'Request Custom Estimate',
        'cta_primary_url' => '#consultation',
        'cta_secondary_text' => NULL,
        'cta_secondary_url' => NULL,
        'settings_json' => json_encode(['currency' => 'INR']),
        'order_num' => 1
    ],
    [
        'page_id' => 6,
        'section_key' => 'inclusions_guarantee',
        'title' => 'Standard Inclusions in Every ClickCodex Engagement',
        'subtitle' => 'Regardless of project tier, our clients receive enterprise-grade guarantees from day one.',
        'badge_text' => 'Enterprise Guarantees',
        'cta_primary_text' => NULL,
        'cta_primary_url' => NULL,
        'cta_secondary_text' => NULL,
        'cta_secondary_url' => NULL,
        'settings_json' => json_encode(['items_count' => 4]),
        'order_num' => 2
    ],

    // Page 8: Contact Us (contactus.html)
    [
        'page_id' => 8,
        'section_key' => 'contact_hero',
        'title' => 'Let\'s Discuss Your Next Strategic Milestone',
        'subtitle' => 'Connect directly with ClickCodex lead architects and commercial directors. Receive an actionable proposal and technical plan within 24 hours.',
        'badge_text' => 'Get In Touch',
        'cta_primary_text' => 'Start Project Discovery',
        'cta_primary_url' => '#discovery',
        'cta_secondary_text' => 'Instant WhatsApp',
        'cta_secondary_url' => 'https://wa.me/919876543210',
        'settings_json' => json_encode(['stats' => ['< 2 Hrs SLA', '100% NDA', 'Direct Lead Access']]),
        'order_num' => 1
    ],
    [
        'page_id' => 8,
        'section_key' => 'campus_locations',
        'title' => 'ClickCodex Engineering Campuses',
        'subtitle' => 'Bangalore Engineering Center & Mumbai Commercial Studio with live timezone sync and working hours.',
        'badge_text' => 'Global & Domestic Offices',
        'cta_primary_text' => NULL,
        'cta_primary_url' => NULL,
        'cta_secondary_text' => NULL,
        'cta_secondary_url' => NULL,
        'settings_json' => json_encode(['campuses' => ['Bangalore', 'Mumbai']]),
        'order_num' => 2
    ]
];

$secStmt = $conn->prepare("INSERT INTO `page_sections` 
  (`page_id`, `section_key`, `title`, `subtitle`, `badge_text`, `cta_primary_text`, `cta_primary_url`, `cta_secondary_text`, `cta_secondary_url`, `settings_json`, `order_num`, `is_active`)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
  ON DUPLICATE KEY UPDATE `title`=VALUES(`title`), `subtitle`=VALUES(`subtitle`), `settings_json`=VALUES(`settings_json`)");

foreach ($sectionsData as $s) {
    $secStmt->bind_param("isssssssssi",
        $s['page_id'],
        $s['section_key'],
        $s['title'],
        $s['subtitle'],
        $s['badge_text'],
        $s['cta_primary_text'],
        $s['cta_primary_url'],
        $s['cta_secondary_text'],
        $s['cta_secondary_url'],
        $s['settings_json'],
        $s['order_num']
    );
    $secStmt->execute();
}
echo "✓ Added/updated page_sections across all site pages.\n";

// =============================================================================
// 5. SEED INDIVIDUAL SEO METADATA FOR SERVICES, CASE STUDIES & BLOG POSTS
// =============================================================================
echo "--> Generating granular SEO metadata for all services, case studies and blogs...\n";

// 5a. Services SEO
$servicesQuery = $conn->query("SELECT id, slug, title, short_description FROM services");
$seoStmt = $conn->prepare("INSERT INTO `seo_metadata` 
  (`entity_type`, `entity_id`, `route_path`, `meta_title`, `meta_description`, `focus_keyword`, `canonical_url`, `robots_index`, `robots_follow`, `og_type`, `og_title`, `og_description`, `og_image`, `schema_type`, `search_intent`, `sitemap_priority`, `sitemap_changefreq`, `is_in_sitemap`)
  VALUES (?, ?, ?, ?, ?, ?, ?, 1, 1, 'service', ?, ?, 'https://clickcodex.com/logo.png', 'Service', 'commercial', 0.9, 'weekly', 1)
  ON DUPLICATE KEY UPDATE `meta_title`=VALUES(`meta_title`), `meta_description`=VALUES(`meta_description`)");

while ($svc = $servicesQuery->fetch_assoc()) {
    $entityType = 'service';
    $routePath = '/services/' . $svc['slug'];
    $metaTitle = $svc['title'] . ' | ClickCodex Technologies';
    $metaDesc = substr($svc['short_description'], 0, 155) . '...';
    $focusKw = strtolower($svc['title']);
    $canonicalUrl = 'https://clickcodex.com' . $routePath;

    $seoStmt->bind_param("sisssssss",
        $entityType,
        $svc['id'],
        $routePath,
        $metaTitle,
        $metaDesc,
        $focusKw,
        $canonicalUrl,
        $metaTitle,
        $metaDesc
    );
    $seoStmt->execute();
}
echo "✓ Generated granular SEO metadata for all 6 core services.\n";

// 5b. Case Studies SEO
$csQuery = $conn->query("SELECT id, slug, title, excerpt FROM case_studies");
while ($cs = $csQuery->fetch_assoc()) {
    $entityType = 'case_study';
    $routePath = '/portfolio/' . $cs['slug'];
    $metaTitle = $cs['title'] . ' Case Study | ClickCodex';
    $metaDesc = substr($cs['excerpt'], 0, 155) . '...';
    $focusKw = strtolower($cs['title']) . ' case study';
    $canonicalUrl = 'https://clickcodex.com' . $routePath;

    $seoStmt->bind_param("sisssssss",
        $entityType,
        $cs['id'],
        $routePath,
        $metaTitle,
        $metaDesc,
        $focusKw,
        $canonicalUrl,
        $metaTitle,
        $metaDesc
    );
    $seoStmt->execute();
}
echo "✓ Generated granular SEO metadata for all 10 case studies.\n";

// 5c. Blog Posts SEO
$blogQuery = $conn->query("SELECT id, slug, title, excerpt FROM blog_posts");
while ($bp = $blogQuery->fetch_assoc()) {
    $entityType = 'blog_post';
    $routePath = '/blogs/' . $bp['slug'];
    $metaTitle = $bp['title'] . ' | ClickCodex Tech Dispatch';
    $metaDesc = substr($bp['excerpt'], 0, 155) . '...';
    $focusKw = strtolower(explode(':', $bp['title'])[0]);
    $canonicalUrl = 'https://clickcodex.com' . $routePath;

    $seoStmt->bind_param("sisssssss",
        $entityType,
        $bp['id'],
        $routePath,
        $metaTitle,
        $metaDesc,
        $focusKw,
        $canonicalUrl,
        $metaTitle,
        $metaDesc
    );
    $seoStmt->execute();
}
echo "✓ Generated granular SEO metadata for all 7 technical articles.\n";

// =============================================================================
// 6. VERIFY FINAL DATABASE RECORD COUNTS
// =============================================================================
echo "\n--> FINAL DATABASE AUDIT SUMMARY:\n";
$tablesRes = $conn->query("SHOW TABLES FROM `clickcodex_db`;");
$totalTables = 0;
$totalRows = 0;
while ($row = $tablesRes->fetch_array()) {
    $tableName = $row[0];
    $countRes = $conn->query("SELECT COUNT(*) AS total FROM `{$tableName}`;");
    $rowCount = ($countRes) ? (int)$countRes->fetch_assoc()['total'] : 0;
    $totalTables++;
    $totalRows += $rowCount;
    echo sprintf("  %-30s : %4d records\n", $tableName, $rowCount);
}

echo "\n=================================================================\n";
echo sprintf("TOTAL: %d Tables | %d Active Production Records in Database!\n", $totalTables, $totalRows);
echo "=================================================================\n";

$conn->close();
