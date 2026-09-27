<?php
/**
 * Click Codex — Add 5 Essential Industry Articles & Professional Authors
 * 
 * Articles added:
 * 1. How to Choose the Right Type of Website for Your Business in 2026 (Author: Aarav Sharma)
 * 2. Which Kind of Digital Marketing is Best for Your Business? (Author: Sneha Patel)
 * 3. Software vs Web Application vs Mobile App: What is Best for You? (Author: Rohan Verma)
 * 4. The Power of UI/UX & Logo Design: Why Visual Craftsmanship Drives Conversions (Author: Priya Nair)
 * 5. Short-Form Video & Reel Production: The Modern Blueprint for Social Reach (Author: Karan Kapoor)
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

$host = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'localhost');
$user = getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? 'root');
$pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : ($_ENV['DB_PASS'] ?? '');
$name = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'clickcodex_db');

$conn = new mysqli($host, $user, $pass, $name);
if ($conn->connect_errno) {
    die("FATAL: Failed to connect to MySQL: " . $conn->connect_error . PHP_EOL);
}
$conn->set_charset("utf8mb4");

echo "========================================================================\n";
echo "CLICK CODEX — INGESTING 5 REQUESTED ARTICLES & AUTHORS\n";
echo "========================================================================\n\n";

// -----------------------------------------------------------------------------
// STEP 1: INSERT AUTHORS
// -----------------------------------------------------------------------------
echo "--> STEP 1: Creating professional authors in blog_authors...\n";

$authors = [
    [
        'id' => 2,
        'name' => 'Aarav Sharma',
        'slug' => 'aarav-sharma',
        'role_title' => 'Lead Web Strategist & Tech Consultant',
        'initials' => 'AS',
        'avatar_image' => 'assets/images/logo.png',
        'bio' => 'Advises founders, entrepreneurs, and businesses on choosing optimal web platforms, custom architectures, and performance-first website frameworks.',
        'order_num' => 2
    ],
    [
        'id' => 3,
        'name' => 'Sneha Patel',
        'slug' => 'sneha-patel',
        'role_title' => 'Head of Digital Marketing & Growth',
        'initials' => 'SP',
        'avatar_image' => 'assets/images/logo.png',
        'bio' => 'Specializes in multi-channel digital growth, search visibility, conversion-optimized funnels, and data-driven client acquisition campaigns.',
        'order_num' => 3
    ],
    [
        'id' => 4,
        'name' => 'Rohan Verma',
        'slug' => 'rohan-verma',
        'role_title' => 'Principal Software & Systems Architect',
        'initials' => 'RV',
        'avatar_image' => 'assets/images/logo.png',
        'bio' => 'Over 5 years evaluating software tradeoffs between cloud web applications, native/cross-platform mobile apps, and custom operational software systems.',
        'order_num' => 4
    ],
    [
        'id' => 5,
        'name' => 'Priya Nair',
        'slug' => 'priya-nair',
        'role_title' => 'Lead UI/UX & Brand Identity Designer',
        'initials' => 'PN',
        'avatar_image' => 'assets/images/logo.png',
        'bio' => 'Pioneers user-centric interface design, wireframing systems, and brand visual identities that build instant trust and elevate conversion rates.',
        'order_num' => 5
    ],
    [
        'id' => 6,
        'name' => 'Karan Kapoor',
        'slug' => 'karan-kapoor',
        'role_title' => 'Creative Video Director & Reel Specialist',
        'initials' => 'KK',
        'avatar_image' => 'assets/images/logo.png',
        'bio' => 'Directs on-location reel shooting, short-form video narrative structure, hook-driven editing, and high-engagement social media media creation.',
        'order_num' => 6
    ]
];

$stmt = $conn->prepare("INSERT INTO `blog_authors` (`id`, `name`, `slug`, `role_title`, `initials`, `avatar_image`, `bio`, `order_num`, `is_active`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)
                        ON DUPLICATE KEY UPDATE `name`=VALUES(`name`), `role_title`=VALUES(`role_title`), `bio`=VALUES(`bio`)");

foreach ($authors as $auth) {
    $stmt->bind_param("issssssi", $auth['id'], $auth['name'], $auth['slug'], $auth['role_title'], $auth['initials'], $auth['avatar_image'], $auth['bio'], $auth['order_num']);
    $stmt->execute();
    echo "  [OK] Author registered: {$auth['name']} ({$auth['role_title']})\n";
}
$stmt->close();

// -----------------------------------------------------------------------------
// STEP 2: MAKE SURE POST 1 IS NOT FEATURED SO HERO SPOTLIGHT BELONGS TO POST 2
// -----------------------------------------------------------------------------
$conn->query("UPDATE `blog_posts` SET `is_featured` = 0 WHERE `id` = 1");

// -----------------------------------------------------------------------------
// STEP 3: INSERT THE 5 ARTICLES
// -----------------------------------------------------------------------------
echo "\n--> STEP 2: Ingesting the 5 comprehensive articles...\n";

$articles = [
    // ARTICLE 1: HOW TO CHOOSE WEBSITE FOR YOUR BUSINESS
    [
        'id' => 2,
        'category_id' => 1, // Web & Tech Insights
        'author_id' => 2,   // Aarav Sharma
        'title' => 'How to Choose the Right Type of Website for Your Business in 2026',
        'slug' => 'how-to-choose-the-right-website-for-your-business',
        'excerpt' => 'Choosing the right website type—whether a single-page landing page, a multi-page corporate website, or an e-commerce platform—is the most critical first step for any business. Here is how to make the right choice based on your goals, budget, and audience.',
        'reading_time' => 7,
        'badge' => "FOUNDER'S GUIDE",
        'is_featured' => 1,
        'keywords' => 'choose website business, website types, landing page vs multi page, ecommerce website, startup web development, click codex',
        'content' => <<<HTML
<h3>Why Your Website Type Dictates Your Digital Trajectory</h3>
<p>In today's competitive landscape, your website is the digital storefront of your brand. Too often, business owners invest time and capital into building either an overly complex web application when all they needed was a high-speed landing page, or a fragile template site when their business model demanded a robust multi-page corporate engine.</p>
<p>Making the right choice begins with diagnosing your primary commercial objective, your target customer persona, and your expected scale over the next 12 to 24 months.</p>

<h4>1. The High-Converting Landing Page (Single-Page Site)</h4>
<p>A landing page is a streamlined, single-scroll experience specifically engineered around a singular call-to-action (CTA). There are no secondary navigation distractions—every headline, testimonial, and visual section guides the visitor toward one specific outcome.</p>
<ul>
  <li><strong>Best Suited For:</strong> Early-stage startups validating an MVP, local service providers, product launches, event registrations, and dedicated Google/Meta ad campaigns.</li>
  <li><strong>Core Advantages:</strong> Rapid turnaround (1 to 2 weeks), cost-effective development, sub-second load times, and laser-focused conversion tracking.</li>
  <li><strong>Limitations:</strong> Limited organic SEO breadth since a single URL cannot target multiple distinct search queries.</li>
</ul>

<h4>2. The Multi-Page Corporate & Authority Website</h4>
<p>A multi-page corporate website structures your brand into distinct dedicated URLs—such as Home, About Us, Individual Service Pages, Portfolio Case Studies, and Contact.</p>
<ul>
  <li><strong>Best Suited For:</strong> Professional consulting firms, B2B agencies, healthcare providers, construction, hospitality, and established businesses seeking organic Google search authority.</li>
  <li><strong>Core Advantages:</strong> High SEO dominance with dedicated keyword landing pages, detailed trust-building, clear service breakdowns, and multi-touchpoint contact inquiries.</li>
  <li><strong>Key Deliverables:</strong> Clean information architecture, mobile-responsive grids, schema structured data, and intuitive navigation.</li>
</ul>

<h4>3. The E-Commerce Storefront & Catalog</h4>
<p>If your primary revenue stream involves selling physical products, merchandise, or digital downloads directly to consumers or wholesale buyers, an e-commerce website is required.</p>
<ul>
  <li><strong>Best Suited For:</strong> Retail brands, jewelry makers, fashion labels, electronics, and direct-to-consumer (D2C) manufacturers.</li>
  <li><strong>Essential Requirements:</strong> High-resolution product image galleries, smooth category filtering, secure payment gateways (Razorpay, Stripe, UPI), automated order confirmation notifications, and mobile checkout optimization.</li>
</ul>

<h4>4. The Custom Dynamic Web Portal / Web Application</h4>
<p>When your website requires customer logins, member dashboards, automated booking engines, or backend database management, it moves into the territory of custom web applications.</p>
<ul>
  <li><strong>Best Suited For:</strong> Membership clubs, patient booking portals, internal operations trackers, and subscription services.</li>
</ul>

<h4>The Decision Matrix: How to Choose in 3 Steps</h4>
<blockquote>
  <strong>Step 1:</strong> Identify your immediate primary goal: Leads, Direct Online Sales, or Brand Credibility?<br>
  <strong>Step 2:</strong> Evaluate your content readiness: Do you have individual pages of content, or a single compelling offer?<br>
  <strong>Step 3:</strong> Plan for longevity: Choose a clean-coded responsive foundation that can easily expand into additional pages as your business expands.
</blockquote>
<p>At Click Codex, we recommend starting with a clean, fast-loading responsive build that reflects your current business stage while leaving clear architectural pathways for future growth.</p>
HTML
    ],

    // ARTICLE 2: WHICH KIND OF DIGITAL MARKETING IS BEST FOR YOU
    [
        'id' => 3,
        'category_id' => 3, // Digital Marketing & Media
        'author_id' => 3,   // Sneha Patel
        'title' => 'Which Kind of Digital Marketing is Best for Your Business?',
        'slug' => 'which-kind-of-digital-marketing-is-best-for-your-business',
        'excerpt' => 'With dozens of digital marketing channels available—from SEO and Google Ads to Instagram Reels, LinkedIn B2B outreach, and influencer marketing—discover which channel delivers the highest return on investment for your specific business model.',
        'reading_time' => 8,
        'badge' => 'GROWTH BLUEPRINT',
        'is_featured' => 0,
        'keywords' => 'best digital marketing, digital marketing types, SEO vs social media, reel marketing, B2B marketing, marketing strategy 2026',
        'content' => <<<HTML
<h3>Navigating the Digital Marketing Spectrum</h3>
<p>One of the most frequent questions business owners ask is: <em>"Should I invest in SEO, run paid ads, or focus entirely on Instagram and reels?"</em> The truth is that there is no universal silver bullet. The most profitable marketing channel depends directly on your audience's intent, your price point, and your sales cycle length.</p>
<p>Let's demystify the four primary marketing pillars and match them with the business types that benefit most from each.</p>

<h4>1. Search Engine Optimization (SEO): The Compounding Engine</h4>
<p>SEO is the art of structuring your website's content, technical speed, and authority so that Google ranks your pages when prospective clients search for your specific services.</p>
<ul>
  <li><strong>Audience Intent:</strong> High Commercial & Transactional Intent. When someone searches <em>"commercial interior designer near me"</em> or <em>"custom jewelry website developer"</em>, they have an active problem they want solved.</li>
  <li><strong>Best For:</strong> B2B services, local contractors, healthcare clinics, hospitality, and businesses seeking sustainable, compounding customer acquisition without continuous ad spending.</li>
  <li><strong>Timeline:</strong> Medium to long-term (3 to 6 months for solid ranking traction).</li>
</ul>

<h4>2. Social Media Creatives & Visual Brand Storytelling</h4>
<p>Social media marketing on platforms like Instagram, LinkedIn, and Facebook is built around visual presence, community trust, and staying top-of-mind.</p>
<ul>
  <li><strong>Audience Intent:</strong> Discovery and Affinity. Users aren't necessarily looking to buy right this second, but high-impact visual design builds desire and brand familiarity.</li>
  <li><strong>Best For:</strong> Lifestyle brands, creative studios, restaurants, fashion, wellness, and consumer products.</li>
  <li><strong>Core Strategy:</strong> Consistent branded post templates, educational carousels, customer showcases, and aesthetic feed coherence.</li>
</ul>

<h4>3. Short-Form Video & Professional Reel Marketing</h4>
<p>Reels and short vertical videos represent the single greatest organic reach opportunity on social platforms today. Instagram and YouTube algorithms prioritize engaging video content over static posts by a factor of 10 to 1.</p>
<ul>
  <li><strong>Audience Intent:</strong> Algorithmic Discovery. Quality reels are served to non-followers who are interested in your category.</li>
  <li><strong>Best For:</strong> Any business with a visual component—food, real estate, hospitality, fashion, educational tips, and behind-the-scenes studio work.</li>
  <li><strong>Key Factor:</strong> Professional hook framing, clear lighting, kinetic typography, and audio synchronization.</li>
</ul>

<h4>4. Targeted Paid Advertising (Google Search & Meta Ads)</h4>
<p>Paid advertising delivers immediate traffic by bidding on search keywords (Google Ads) or targeting detailed audience demographics and interests (Meta Ads).</p>
<ul>
  <li><strong>Best For:</strong> Rapid product testing, seasonal promotions, flash sales, and businesses with a clearly calculated customer lifetime value (LTV).</li>
  <li><strong>Trade-off:</strong> Highly effective for fast results, but traffic stops the moment ad spend ceases.</li>
</ul>

<h4>The Click Codex Hybrid Recommendation</h4>
<p>For most emerging startups and growing businesses, the most resilient strategy is a <strong>Two-Pillar Hybrid Model</strong>:</p>
<ol>
  <li><strong>Foundation:</strong> A fast, SEO-optimized website that captures high-intent organic search traffic.</li>
  <li><strong>Engagement:</strong> Regular short-form reels and cohesive social creatives that build social proof and community trust.</li>
</ol>
<p>By pairing search authority with active visual storytelling, your business captures both the clients who are searching for you today and the clients who will remember you tomorrow.</p>
HTML
    ],

    // ARTICLE 3: SOFTWARE VS WEB APP VS MOBILE APP
    [
        'id' => 4,
        'category_id' => 1, // Web & Tech Insights
        'author_id' => 4,   // Rohan Verma
        'title' => 'Software vs Web Application vs Mobile App: What is Best for You?',
        'slug' => 'software-vs-web-app-vs-mobile-app-which-is-best',
        'excerpt' => 'Should you build custom desktop software, a cloud-based responsive web application, or a native mobile app? We break down the technical trade-offs, development costs, user adoption hurdles, and maintenance factors to help you decide.',
        'reading_time' => 9,
        'badge' => 'TECH ARCHITECTURE',
        'is_featured' => 0,
        'keywords' => 'software vs web app vs mobile app, mobile app vs web app, custom software development, web app development, tech stack choice',
        'content' => <<<HTML
<h3>The Fundamental Technology Crossroads</h3>
<p>When envisioning a new digital product or internal management system, founders and business leaders often grapple with a critical architectural question: <em>"Should we develop a mobile application, a responsive web app, or dedicated desktop software?"</em></p>
<p>Selecting the wrong deployment form factor can result in bloated development costs, lengthy app store review delays, and sluggish user adoption. Here is an objective engineering teardown of each medium.</p>

<h4>1. Responsive Web Applications: The Universal Standard</h4>
<p>A modern web application runs inside the user's web browser across any device (desktop, tablet, smartphone) without requiring them to install any files from an app store.</p>
<ul>
  <li><strong>Key Advantages:</strong>
    <ul>
      <li><strong>Zero Friction Adoption:</strong> A prospective user simply clicks a link and is immediately using your platform.</li>
      <li><strong>Cross-Device Compatibility:</strong> One codebase serves desktop monitors, laptops, and mobile screens seamlessly.</li>
      <li><strong>Instant Deployment & Updates:</strong> Code fixes, new features, and security patches roll out immediately to 100% of users with no app store approvals.</li>
      <li><strong>Lower Cost:</strong> Significantly more economical to develop and maintain compared to building two separate native mobile apps.</li>
    </ul>
  </li>
  <li><strong>When to Choose:</strong> SaaS platforms, client portals, booking systems, inventory dashboards, e-commerce, and collaborative workflows.</li>
</ul>

<h4>2. Mobile Applications (iOS & Android)</h4>
<p>Mobile applications are installed directly onto smartphones and tablets via the Apple App Store or Google Play Store.</p>
<ul>
  <li><strong>Key Advantages:</strong>
    <ul>
      <li><strong>Hardware Integration:</strong> Direct access to native camera, GPS location, push notifications, Bluetooth, and biometric face/fingerprint authentication.</li>
      <li><strong>Offline Capabilities:</strong> Can be built to function seamlessly without continuous internet connectivity.</li>
      <li><strong>Home Screen Real Estate:</strong> Your brand icon sits permanently on the user's phone, encouraging frequent daily sessions.</li>
    </ul>
  </li>
  <li><strong>When to Choose:</strong> On-demand delivery apps, fitness trackers, real-time messaging, ride-sharing, and mobile gaming.</li>
  <li><strong>Trade-offs:</strong> Higher initial development cost, 15%–30% platform store commissions on digital sales, and 24-to-72 hour delays for store update approvals.</li>
</ul>

<h4>3. Custom Software & Internal Management Tools</h4>
<p>Custom software systems are engineered specifically for operational workflows, warehouse logistics, or proprietary organizational automation.</p>
<ul>
  <li><strong>Key Advantages:</strong> Tailored 100% to your exact operational procedures, high data throughput, customized role-based security, and seamless integration with existing local hardware (barcode scanners, thermal printers, sensors).</li>
  <li><strong>When to Choose:</strong> Enterprise ERPs, hospital clinic management, specialized manufacturing tracking, and financial compliance engines.</li>
</ul>

<h4>Summary Recommendation for Founders</h4>
<blockquote>
  <strong>The Rule of Thumb:</strong> Unless your core product genuinely requires background location tracking, hardware peripherals, or offline-first sync, <strong>always start with a responsive web application first</strong>.
</blockquote>
<p>Building a responsive web app allows you to validate your workflow, gather user feedback, and reach customers across all devices at half the development cost and twice the speed.</p>
HTML
    ],

    // ARTICLE 4: THE POWER OF UI/UX AND LOGO DESIGN
    [
        'id' => 5,
        'category_id' => 2, // Design & UI/UX
        'author_id' => 5,   // Priya Nair
        'title' => 'The Power of UI/UX & Logo Design: Why Visual Craftsmanship Drives Conversions',
        'slug' => 'power-of-ui-ux-and-logo-design-for-business-growth',
        'excerpt' => 'Users form an opinion about your business within 50 milliseconds of landing on your page. Discover why investing in professional UI/UX design, intuitive user flows, and memorable logo identity directly impacts your bottom line.',
        'reading_time' => 6,
        'badge' => 'DESIGN EXCELLENCE',
        'is_featured' => 0,
        'keywords' => 'UI UX design importance, logo design business, conversion rate optimization, brand identity, graphic design startup',
        'content' => <<<HTML
<h3>The 50-Millisecond First Impression</h3>
<p>Cognitive psychology research shows that it takes a visitor approximately <strong>50 milliseconds</strong> (0.05 seconds) to form an emotional impression of your website. In that fractional blink of an eye, subconscious judgments regarding your credibility, professionalism, and reliability are cemented.</p>
<p>Design is never merely visual decoration—it is the functional bridge between a visitor's hesitation and their decision to contact, trust, or purchase from you.</p>

<h4>1. The Strategic Role of a Distinctive Logo</h4>
<p>Your logo is the foundational anchor of your company's identity. A professional logo achieves three key objectives:</p>
<ul>
  <li><strong>Memorability:</strong> Distinctive shapes and balanced proportions make your brand instantly recognizable in social media profile pictures, app headers, and packaging.</li>
  <li><strong>Versatility:</strong> A well-crafted logo scales flawlessly from a 16px browser favicon to a high-resolution outdoor billboard without losing clarity or legibility.</li>
  <li><strong>Emotional Alignment:</strong> Colors and typography convey industry character—trustworthy blues for technology and finance, vibrant energetic hues for creative media, or refined neutrals for luxury and hospitality.</li>
</ul>

<h4>2. UI vs UX: Two Sides of the Same High-Performance Coin</h4>
<p>While often grouped together, User Interface (UI) and User Experience (UX) solve distinct challenges:</p>
<ul>
  <li><strong>User Experience (UX):</strong> Focuses on the logic, structure, and emotional journey. Can a visitor find what they need in two clicks? Is the inquiry form intuitive? Is the mobile checkout frictionless?</li>
  <li><strong>User Interface (UI):</strong> Focuses on aesthetic polish—consistent typographic scales, intentional whitespace, visual button hierarchy, and cohesive color palettes.</li>
</ul>

<h4>3. The Business ROI of Thoughtful Design</h4>
<p>Investing in thoughtful design yields tangible business results:</p>
<ol>
  <li><strong>Lower Bounce Rates:</strong> Clean layouts and uncluttered typography invite users to stay, read, and explore your services.</li>
  <li><strong>Higher Conversion Rates:</strong> Clear, prominent Call-to-Action buttons with high contrast make it effortless for users to initiate contact.</li>
  <li><strong>Price Premium Perception:</strong> Premium visual presentation signals established authority, allowing businesses to command premium pricing over competitors with outdated visual collateral.</li>
</ol>
<p>At Click Codex, our design philosophy combines minimalist elegance with purposeful UX wireframing, ensuring every screen looks beautiful and performs with commercial intent.</p>
HTML
    ],

    // ARTICLE 5: SHORT-FORM VIDEO & REEL PRODUCTION
    [
        'id' => 6,
        'category_id' => 3, // Digital Marketing & Media
        'author_id' => 6,   // Karan Kapoor
        'title' => 'Short-Form Video & Reel Production: The Secret to High-Engagement Social Reach',
        'slug' => 'short-form-video-and-reel-production-guide',
        'excerpt' => 'Vertical short-form videos and reels have become the primary medium for organic algorithmic discovery on Instagram, YouTube, and Facebook. Learn the essentials of professional shooting, hooks, and video editing that capture immediate attention.',
        'reading_time' => 7,
        'badge' => 'CREATIVE MEDIA',
        'is_featured' => 0,
        'keywords' => 'reel production, short form video, Instagram reels business, video content creation, professional reel shooting, viral video editing',
        'content' => <<<HTML
<h3>The Shift to Vertical Video Culture</h3>
<p>Over the past three years, consumer attention has decisively shifted toward 9:16 vertical video formats. Platforms like Instagram Reels, YouTube Shorts, and Facebook Video are designed specifically to reward engaging video storytelling with massive organic discovery.</p>
<p>While static image posts are shown primarily to your existing followers, algorithms actively distribute compelling reels to tens of thousands of potential customers who have never heard of your brand before.</p>

<h4>1. The Critical 3-Second Hook Rule</h4>
<p>In the fast-swiping vertical feed, viewer attention is won or lost in the first three seconds. If your reel begins with a slow fade-in, an irrelevant corporate logo, or quiet hesitation, the viewer has already scrolled away.</p>
<ul>
  <li><strong>Visual Hooks:</strong> Rapid motion, unexpected camera angles, or dynamic text overlays that immediately pose an intriguing question.</li>
  <li><strong>Audio Hooks:</strong> Clear, confident voiceover delivery or rhythmically aligned trending audio cues.</li>
  <li><strong>Curiosity Gap:</strong> Promise a specific transformation or insight: <em>"Here is the single biggest mistake businesses make with their website..."</em></li>
</ul>

<h4>2. The Production Elements of a Professional Reel</h4>
<p>High-performing reels don't happen by accident. They are engineered through careful production planning:</p>
<ul>
  <li><strong>Intentional Lighting:</strong> Soft, directional key lighting ensures crisp subject definition, natural skin tones, and rich contrast even when viewed on small mobile screens.</li>
  <li><strong>Camera Stabilization:</strong> Smooth gimbal moves, precise panning, and steady framing give footage an unmistakable cinematic polish.</li>
  <li><strong>Pristine Audio Capture:</strong> Viewers will forgive slightly imperfect video, but poor, echoing audio causes instant abandonment. Dedicated lapel or shotgun microphones are essential.</li>
</ul>

<h4>3. Post-Production: Pacing, Kinetic Captions & Audio Sync</h4>
<p>The magic of modern short-form video happens in the editing suite:</p>
<ul>
  <li><strong>Kinetic Animated Subtitles:</strong> Over 70% of social media users browse videos with sound turned off in public settings. Dynamic, beat-synced captions ensure 100% message retention.</li>
  <li><strong>Micro-Cuts and Jump Cuts:</strong> Eliminating every pause and breath keeps energy tight and prevents cognitive drop-off.</li>
  <li><strong>B-Roll Cutaways:</strong> Seamlessly interweaving product close-ups, behind-the-scenes clips, and screen interactions maintains high visual interest.</li>
</ul>

<h4>How Businesses Can Start Today</h4>
<p>You don't need a Hollywood budget to succeed with video. Start by capturing the authentic reality of your craft: explain how you solve customer problems, demonstrate your products in real time, and share behind-the-scenes glimpses of your team in action.</p>
<p>With Click Codex's dedicated reel shooting sessions and video production sprints, we handle concept development, on-location shooting, and high-energy editing to produce social video assets that convert viewers into loyal clients.</p>
HTML
    ]
];

$stmt = $conn->prepare("INSERT INTO `blog_posts` 
    (`id`, `category_id`, `author_id`, `title`, `slug`, `excerpt`, `content`, `reading_time_minutes`, `featured_badge`, `search_keywords`, `featured_image`, `views_count`, `likes_count`, `is_featured`, `is_published`, `published_at`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'assets/images/logo.png', ?, ?, ?, 1, NOW())
    ON DUPLICATE KEY UPDATE 
    `category_id`=VALUES(`category_id`), `author_id`=VALUES(`author_id`), `title`=VALUES(`title`), `slug`=VALUES(`slug`),
    `excerpt`=VALUES(`excerpt`), `content`=VALUES(`content`), `reading_time_minutes`=VALUES(`reading_time_minutes`),
    `featured_badge`=VALUES(`featured_badge`), `search_keywords`=VALUES(`search_keywords`), `is_featured`=VALUES(`is_featured`),
    `is_published`=1");

$initialViews = [2 => 480, 3 => 395, 4 => 320, 5 => 415, 6 => 560];
$initialLikes = [2 => 42, 3 => 35, 4 => 28, 5 => 39, 6 => 51];

foreach ($articles as $art) {
    $views = $initialViews[$art['id']] ?? 300;
    $likes = $initialLikes[$art['id']] ?? 30;
    
    $stmt->bind_param("iiissssissiii",
        $art['id'],
        $art['category_id'],
        $art['author_id'],
        $art['title'],
        $art['slug'],
        $art['excerpt'],
        $art['content'],
        $art['reading_time'],
        $art['badge'],
        $art['keywords'],
        $views,
        $likes,
        $art['is_featured']
    );
    $stmt->execute();
    echo "  [OK] Article #{$art['id']} created: {$art['title']} (Author ID: {$art['author_id']})\n";
}
$stmt->close();

// -----------------------------------------------------------------------------
// STEP 4: TAGS & RELATIONSHIPS
// -----------------------------------------------------------------------------
echo "\n--> STEP 3: Connecting relevant tags in blog_tags & blog_post_tags...\n";

$tags = [
    ['id' => 1, 'name' => 'Web Development', 'slug' => 'web-development'],
    ['id' => 2, 'name' => 'Digital Marketing', 'slug' => 'digital-marketing'],
    ['id' => 3, 'name' => 'UI/UX Design', 'slug' => 'ui-ux-design'],
    ['id' => 4, 'name' => 'Reel Production', 'slug' => 'reel-production'],
    ['id' => 5, 'name' => 'Startup Guide', 'slug' => 'startup-guide'],
    ['id' => 6, 'name' => 'Software Architecture', 'slug' => 'software-architecture']
];

$stmt = $conn->prepare("INSERT INTO `blog_tags` (`id`, `name`, `slug`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `name`=VALUES(`name`)");
foreach ($tags as $t) {
    $stmt->bind_param("iss", $t['id'], $t['name'], $t['slug']);
    $stmt->execute();
}
$stmt->close();

$postTags = [
    2 => [1, 5],       // How to choose website: Web Development, Startup Guide
    3 => [2, 5],       // Which digital marketing: Digital Marketing, Startup Guide
    4 => [1, 6],       // Software vs Web vs App: Web Development, Software Architecture
    5 => [3, 5],       // UI/UX & Logo: UI/UX Design, Startup Guide
    6 => [4, 2]        // Reel & Short-form video: Reel Production, Digital Marketing
];

$conn->query("DELETE FROM `blog_post_tags` WHERE `post_id` IN (2, 3, 4, 5, 6)");
$ptStmt = $conn->prepare("INSERT INTO `blog_post_tags` (`post_id`, `tag_id`) VALUES (?, ?)");
foreach ($postTags as $postId => $tagIds) {
    foreach ($tagIds as $tid) {
        $ptStmt->bind_param("ii", $postId, $tid);
        $ptStmt->execute();
    }
}
$ptStmt->close();
echo "  [OK] Tags linked to all articles.\n";

// -----------------------------------------------------------------------------
// STEP 5: SEO METADATA RECORDS
// -----------------------------------------------------------------------------
echo "\n--> STEP 4: Populating SEO metadata for each article...\n";

$conn->query("DELETE FROM `seo_metadata` WHERE `entity_type` = 'blog_post'");

$seoStmt = $conn->prepare("INSERT INTO `seo_metadata` 
    (`entity_type`, `entity_id`, `route_path`, `meta_title`, `meta_description`, `focus_keyword`, `canonical_url`, `og_title`, `og_description`, `og_image`, `schema_type`, `sitemap_priority`, `is_in_sitemap`, `seo_score`) 
    VALUES ('blog_post', ?, ?, ?, ?, ?, ?, ?, ?, 'assets/images/logo.png', 'Article', 0.8, 1, 96)");

foreach ($articles as $art) {
    $route = "/blogs/{$art['slug']}";
    $seoStmt->bind_param("isssssss",
        $art['id'],
        $route,
        $art['title'],
        $art['excerpt'],
        $art['badge'],
        $route,
        $art['title'],
        $art['excerpt']
    );
    $seoStmt->execute();
}
$seoStmt->close();
echo "  [OK] SEO metadata configured for all 5 articles.\n";

// -----------------------------------------------------------------------------
// STEP 6: SYNCHRONIZE SEED.SQL
// -----------------------------------------------------------------------------
echo "\n--> STEP 5: Exporting clean state to database/seed.sql...\n";

$mysqldumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
if (file_exists($mysqldumpPath)) {
    $seedSqlFile = dirname(__DIR__) . '/database/seed.sql';
    $cmd = "\"{$mysqldumpPath}\" -u {$user} " . ($pass !== '' ? "-p\"{$pass}\" " : "") . "{$name} > \"{$seedSqlFile}\"";
    exec($cmd, $dumpOut, $dumpCode);
    if ($dumpCode === 0) {
        echo "  [SUCCESS] Updated database/seed.sql (" . number_format(filesize($seedSqlFile)) . " bytes).\n";
    }
}

echo "\n========================================================================\n";
echo "ARTICLES INGESTION COMPLETED SUCCESSFULLY!\n";
echo "========================================================================\n";

$conn->close();
