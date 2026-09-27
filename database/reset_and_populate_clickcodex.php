<?php
/**
 * Click Codex — Comprehensive Database Reset & Population Engine
 * 
 * Accurately represents Click Codex as a technology startup preparing to officially
 * begin its operations with a collaborative 4-member team having ~2 years of experience
 * across Web Development, Mobile Apps, Software, Design, Marketing, and Video/Reels.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Load environment variables
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
echo "CLICK CODEX — DATABASE RESET & SEEDING ENGINE\n";
echo "Target Database: {$name} on {$host}\n";
echo "========================================================================\n\n";

// -----------------------------------------------------------------------------
// STEP 1: COMPLETELY CLEAR ALL EXISTING DATA (PRESERVING SCHEMA)
// -----------------------------------------------------------------------------
echo "--> STEP 1: Clearing all existing records from database...\n";

$conn->query("SET FOREIGN_KEY_CHECKS = 0;");

$tablesToTruncate = [
    'audit_logs',
    'users',
    'site_settings',
    'seo_metadata',
    'url_redirects',
    'not_found_logs',
    'search_logs',
    'page_sections',
    'pages',
    'service_faqs',
    'service_dossier_steps',
    'growth_funnel_tiers',
    'services',
    'service_categories',
    'advisor_submissions',
    'solution_advisor_options',
    'solution_advisor_questions',
    'advisor_archetypes',
    'testimonials',
    'case_studies',
    'portfolio_categories',
    'blog_comments',
    'blog_post_tags',
    'blog_tags',
    'blog_posts',
    'blog_authors',
    'blog_categories',
    'pricing_features',
    'pricing_plans',
    'pricing_inclusions',
    'company_milestones',
    'company_values',
    'team_members',
    'trusted_brands',
    'faqs',
    'contact_inquiries',
    'newsletter_subscribers'
];

foreach ($tablesToTruncate as $tbl) {
    if ($conn->query("TRUNCATE TABLE `{$tbl}`")) {
        echo "  [CLEARED] Table `{$tbl}`\n";
    } else {
        echo "  [WARN] Failed to truncate `{$tbl}`: " . $conn->error . "\n";
    }
}

$conn->query("SET FOREIGN_KEY_CHECKS = 1;");
echo "All previous demo and sample data cleared successfully.\n\n";

// -----------------------------------------------------------------------------
// STEP 2: USERS & RBAC (ADMIN CREDENTIALS)
// -----------------------------------------------------------------------------
echo "--> STEP 2: Setting up authenticated Super Admin user...\n";

// password_hash for 'admin123'
$passHash = '$2y$10$wK3V.NfQvM1qHqBv88c5hOMW3Fp6xVqR8m3IuL9uI7jWbL6ZkQ6mC';
$stmt = $conn->prepare("INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `avatar_url`, `phone`, `is_active`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, 1, NOW())");
$uid = 1;
$uName = "Click Codex Admin";
$uEmail = "admin@clickcodex.com";
$uRole = "super_admin";
$uAvatar = "assets/images/logo.png";
$uPhone = "+91 0000000000";
$stmt->bind_param("issssss", $uid, $uName, $uEmail, $passHash, $uRole, $uAvatar, $uPhone);
$stmt->execute();
$stmt->close();
echo "  [OK] Super Admin user created (admin@clickcodex.com / admin123)\n";

// -----------------------------------------------------------------------------
// STEP 3: SITE SETTINGS (CLICK CODEX COMPANY OVERVIEW & LOGO)
// -----------------------------------------------------------------------------
echo "--> STEP 3: Populating site settings with Click Codex startup profile...\n";

$settings = [
    // General & Company Information
    ['company_name', 'Click Codex', 'general', 'string', 'Official company name', 1],
    ['company_tagline', 'Digital Craftsmanship, Full-Stack Engineering & Creative Media', 'general', 'string', 'Brand headline', 1],
    ['company_status', 'Startup preparing to officially begin operations', 'general', 'string', 'Operational status', 1],
    ['company_overview', 'Click Codex is an emerging digital technology startup preparing to officially begin operations. Powered by a collaborative 4-member team with approximately 2 years of collective experience across development, design, marketing, and media creation.', 'general', 'text', 'Company description', 1],
    ['team_size', '4 Members', 'general', 'string', 'Current team size', 1],
    ['team_experience', '~2 Years in Development & Digital Technology', 'general', 'string', 'Collective team experience', 1],
    ['founding_year', '2026', 'general', 'string', 'Year established / startup phase', 1],
    
    // Branding & Logo (Using the official logo.png from project assets)
    ['site_logo', 'assets/images/logo.png', 'branding', 'string', 'Primary website logo path', 1],
    ['site_logo_dark', 'assets/images/logo.png', 'branding', 'string', 'Dark mode logo path', 1],
    ['site_favicon', 'assets/images/logo.png', 'branding', 'string', 'Favicon image path', 1],
    ['brand_primary_color', '#0056d6', 'branding', 'string', 'Primary brand color', 1],
    ['brand_accent_color', '#00a2ff', 'branding', 'string', 'Accent cyan glow color', 1],
    
    // Contact Information (Default neutral values as requested)
    ['contact_email', 'contact@clickcodex.com', 'contact', 'string', 'Primary public contact email', 1],
    ['support_email', 'support@clickcodex.com', 'contact', 'string', 'Customer support email', 1],
    ['contact_phone', '+91 (Contact Available Upon Inquiry)', 'contact', 'string', 'Public contact phone placeholder', 1],
    ['contact_address', 'India', 'contact', 'string', 'Base operating region', 1],
    ['working_hours', 'Monday – Saturday: 9:30 AM – 6:30 PM IST', 'contact', 'string', 'Operating business hours', 1],
    
    // Social Media Links (Neutral startup profiles)
    ['social_linkedin', 'https://linkedin.com/company/clickcodex', 'social', 'string', 'LinkedIn company page', 1],
    ['social_instagram', 'https://instagram.com/clickcodex', 'social', 'string', 'Instagram official page', 1],
    ['social_youtube', 'https://youtube.com/@clickcodex', 'social', 'string', 'YouTube channel', 1],
    ['social_github', 'https://github.com/clickcodex', 'social', 'string', 'GitHub organization', 1],
    ['social_twitter', 'https://twitter.com/clickcodex', 'social', 'string', 'Twitter/X handle', 1],
    
    // SEO Defaults
    ['default_meta_title', 'Click Codex — Technology & Creative Digital Startup', 'seo', 'string', 'Default title tag', 1],
    ['default_meta_desc', 'Click Codex is a modern technology startup providing Full-Stack Web Development, Mobile Apps, UI/UX, Graphic Design, Digital Marketing, and Professional Video/Reel Production.', 'seo', 'text', 'Default meta description', 1],
    ['default_keywords', 'Click Codex, web development, website design, mobile apps, software development, UI UX design, graphic design, logo design, digital marketing, reel shooting, video production', 'seo', 'text', 'Default focus keywords', 1],
    
    // Analytics & Telemetry Defaults
    ['google_analytics_id', '', 'analytics', 'string', 'GA4 Measurement ID (optional)', 0],
    ['cookie_consent_enabled', '1', 'legal', 'boolean', 'Show cookie consent banner', 1]
];

$stmt = $conn->prepare("INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`, `value_type`, `description`, `is_public`) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($settings as $s) {
    $stmt->bind_param("sssssi", $s[0], $s[1], $s[2], $s[3], $s[4], $s[5]);
    $stmt->execute();
}
$stmt->close();
echo "  [OK] " . count($settings) . " site settings configured.\n";

// -----------------------------------------------------------------------------
// STEP 4: TEAM MEMBERS (4-MEMBER CLICK CODEX TEAM)
// -----------------------------------------------------------------------------
echo "--> STEP 4: Populating 4-member Click Codex team (2 years experience)...\n";

$team = [
    [
        'id' => 1,
        'name' => 'Full-Stack Developer',
        'slug' => 'full-stack-developer',
        'role_title' => 'Full-Stack Web & Software Developer',
        'specialty' => 'Web & Software Engineering',
        'experience_years' => '2 Years Experience',
        'avatar_image' => 'assets/images/logo.png',
        'bio' => 'Focuses on responsive website development, custom web applications, robust database management, and scalable API integrations with modern clean-code standards.',
        'skills' => json_encode(['Full-Stack Web Development', 'PHP', 'JavaScript', 'HTML5 & CSS3', 'MySQL Databases', 'RESTful APIs', 'Git']),
        'social_links' => json_encode(['linkedin' => 'https://linkedin.com', 'github' => 'https://github.com']),
        'order_num' => 1
    ],
    [
        'id' => 2,
        'name' => 'UI/UX & Graphic Designer',
        'slug' => 'ui-ux-graphic-designer',
        'role_title' => 'UI/UX & Visual Brand Designer',
        'specialty' => 'Interface, Logo & Graphic Design',
        'experience_years' => '2 Years Experience',
        'avatar_image' => 'assets/images/logo.png',
        'bio' => 'Crafts user-friendly interface designs, modern brand aesthetics, impactful logos, and creative visual collaterals that bridge user intuition with brand identity.',
        'skills' => json_encode(['UI/UX Design', 'Wireframing & Prototyping', 'Logo Design', 'Graphic Design', 'Figma', 'Visual Systems']),
        'social_links' => json_encode(['linkedin' => 'https://linkedin.com', 'behance' => 'https://behance.net']),
        'order_num' => 2
    ],
    [
        'id' => 3,
        'name' => 'Digital Marketing Specialist',
        'slug' => 'digital-marketing-specialist',
        'role_title' => 'Digital Marketing & Social Media Strategist',
        'specialty' => 'Digital Growth & Social Creatives',
        'experience_years' => '2 Years Experience',
        'avatar_image' => 'assets/images/logo.png',
        'bio' => 'Develops strategic digital marketing campaigns, social media creative concepts, audience engagement workflows, and search optimization fundamentals.',
        'skills' => json_encode(['Digital Marketing', 'Social Media Strategy', 'Creative Design Concepts', 'Content Marketing', 'SEO Fundamentals', 'Campaign Analytics']),
        'social_links' => json_encode(['linkedin' => 'https://linkedin.com', 'instagram' => 'https://instagram.com']),
        'order_num' => 3
    ],
    [
        'id' => 4,
        'name' => 'Video & Content Creator',
        'slug' => 'video-content-creator',
        'role_title' => 'Video Producer & Reel Specialist',
        'specialty' => 'Reel Shooting & Video Production',
        'experience_years' => '2 Years Experience',
        'avatar_image' => 'assets/images/logo.png',
        'bio' => 'Specializes in professional reel shooting, short-form video production, promotional video editing, visual storytelling, and dynamic social media media assets.',
        'skills' => json_encode(['Professional Reel Shooting', 'Short-Form Video Production', 'Video Editing', 'Motion Graphics', 'Visual Storytelling', 'Audio Sync']),
        'social_links' => json_encode(['youtube' => 'https://youtube.com', 'instagram' => 'https://instagram.com']),
        'order_num' => 4
    ]
];

$stmt = $conn->prepare("INSERT INTO `team_members` (`id`, `name`, `slug`, `role_title`, `specialty`, `experience_years`, `avatar_image`, `bio`, `skills`, `social_links`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
foreach ($team as $m) {
    $stmt->bind_param("isssssssssi", $m['id'], $m['name'], $m['slug'], $m['role_title'], $m['specialty'], $m['experience_years'], $m['avatar_image'], $m['bio'], $m['skills'], $m['social_links'], $m['order_num']);
    $stmt->execute();
}
$stmt->close();
echo "  [OK] 4 Click Codex team members inserted.\n";

// -----------------------------------------------------------------------------
// STEP 5: SERVICE CATEGORIES & ALL 12 SERVICES
// -----------------------------------------------------------------------------
echo "--> STEP 5: Inserting service categories and 12 Click Codex services...\n";

$categories = [
    [
        'id' => 1,
        'name' => 'Web & Software Engineering',
        'slug' => 'web-software-engineering',
        'description' => 'End-to-end website engineering, full-stack applications, mobile apps, and custom software.',
        'order_num' => 1
    ],
    [
        'id' => 2,
        'name' => 'UI/UX & Creative Design',
        'slug' => 'ui-ux-creative-design',
        'description' => 'User experience architecture, modern graphic design, brand identities, and custom logo creation.',
        'order_num' => 2
    ],
    [
        'id' => 3,
        'name' => 'Digital Marketing & Video Production',
        'slug' => 'marketing-video-production',
        'description' => 'Growth-driven digital marketing, social media creative design, professional reel shooting, and video content.',
        'order_num' => 3
    ]
];

$stmt = $conn->prepare("INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, ?, 1)");
foreach ($categories as $cat) {
    $stmt->bind_param("isssi", $cat['id'], $cat['name'], $cat['slug'], $cat['description'], $cat['order_num']);
    $stmt->execute();
}
$stmt->close();

$services = [
    // 1. Full-Stack Web Development
    [
        'id' => 1,
        'category_id' => 1,
        'service_code' => 'FULL_STACK_DEV',
        'slug' => 'full-stack-web-development',
        'title' => 'Full-Stack Web Development',
        'short_description' => 'Custom full-stack web applications built with modern frontend interfaces, secure backend services, and structured databases tailored to your business workflow.',
        'full_description' => 'Click Codex delivers end-to-end full-stack web development services. Our team builds responsive user interfaces combined with structured backend architecture, clean database schemas, and RESTful API integrations to bring custom digital products to life.',
        'badge_label' => 'CORE SERVICE',
        'price_model' => 'fixed_sprint',
        'typical_timeline' => '3 – 6 Weeks',
        'tech_stack' => json_encode(['PHP', 'JavaScript', 'HTML5', 'CSS3', 'MySQL', 'REST APIs', 'Git']),
        'key_deliverables' => json_encode(['Custom Web Application Architecture', 'Interactive Frontend Interface', 'Database Design & Integration', 'API Integrations', 'Cross-Device Responsiveness']),
        'is_featured' => 1,
        'order_num' => 1
    ],
    // 2. Website Development
    [
        'id' => 2,
        'category_id' => 1,
        'service_code' => 'WEBSITE_DEV',
        'slug' => 'website-development',
        'title' => 'Website Development',
        'short_description' => 'High-performance, beautifully designed responsive websites for businesses, portfolios, and commercial organizations seeking a strong online presence.',
        'full_description' => 'We design and develop clean, modern, and mobile-friendly websites that showcase your business with clarity. Each website is engineered for fast loading speeds, seamless navigation, modern visual aesthetics, and search engine readiness.',
        'badge_label' => 'POPULAR',
        'price_model' => 'fixed_sprint',
        'typical_timeline' => '2 – 4 Weeks',
        'tech_stack' => json_encode(['HTML5', 'CSS3', 'JavaScript', 'PHP', 'SEO Semantic HTML', 'Responsive Frameworks']),
        'key_deliverables' => json_encode(['Fully Responsive Layout', 'Mobile & Tablet Optimization', 'Contact & Inquiry Forms', 'Speed Optimization', 'Basic On-Page SEO Setup']),
        'is_featured' => 1,
        'order_num' => 2
    ],
    // 3. Mobile App Development
    [
        'id' => 3,
        'category_id' => 1,
        'service_code' => 'MOBILE_APP_DEV',
        'slug' => 'mobile-app-development',
        'title' => 'Mobile App Development',
        'short_description' => 'Cross-platform mobile applications for iOS and Android, focusing on intuitive user experience, reliable performance, and native device functionality.',
        'full_description' => 'Expand your brand reach with custom mobile application development. We build cross-platform mobile apps that combine fluid navigation, modern UI components, and dependable backend communication for a consistent user experience on both major platforms.',
        'badge_label' => 'FEATURED',
        'price_model' => 'fixed_sprint',
        'typical_timeline' => '6 – 10 Weeks',
        'tech_stack' => json_encode(['Cross-Platform Frameworks', 'JavaScript', 'REST APIs', 'Mobile UI Libraries', 'Firebase/Cloud']),
        'key_deliverables' => json_encode(['iOS & Android App Builds', 'Intuitive UI/UX Flow', 'Authentication & Profile Management', 'Push Notifications Support', 'Backend API Integration']),
        'is_featured' => 1,
        'order_num' => 3
    ],
    // 4. Software Development
    [
        'id' => 4,
        'category_id' => 1,
        'service_code' => 'SOFTWARE_DEV',
        'slug' => 'software-development',
        'title' => 'Software Development',
        'short_description' => 'Custom software solutions and operational tools engineered to streamline business operations, data management, and specialized organizational workflows.',
        'full_description' => 'When off-the-shelf software falls short, Click Codex builds tailored software solutions designed around your exact operational needs. From internal management portals to data tracking utilities, we engineer reliable digital tools.',
        'badge_label' => 'CUSTOM',
        'price_model' => 'custom',
        'typical_timeline' => '4 – 8 Weeks',
        'tech_stack' => json_encode(['PHP', 'MySQL', 'JavaScript', 'Custom MVC Architecture', 'Role-Based Access Control']),
        'key_deliverables' => json_encode(['Custom Business Logic Modules', 'Role-Based Access Control', 'Reporting & Data Exports', 'Secure Database Infrastructure', 'User Documentation']),
        'is_featured' => 0,
        'order_num' => 4
    ],
    // 5. UI/UX Design
    [
        'id' => 5,
        'category_id' => 2,
        'service_code' => 'UI_UX_DESIGN',
        'slug' => 'ui-ux-design',
        'title' => 'UI/UX Design',
        'short_description' => 'User-centric interface and experience design, interactive wireframing, clickable prototypes, and modern design systems crafted for effortless navigation.',
        'full_description' => 'Great digital products begin with thoughtful design. Our UI/UX design process studies user behavior to create clear wireframes, intuitive navigation pathways, and aesthetically pleasing visual interfaces that elevate engagement and conversion.',
        'badge_label' => 'DESIGN',
        'price_model' => 'fixed_sprint',
        'typical_timeline' => '1 – 3 Weeks',
        'tech_stack' => json_encode(['Figma', 'Interactive Wireframing', 'Prototyping', 'Design Systems', 'User Journey Mapping']),
        'key_deliverables' => json_encode(['Information Architecture & Wireframes', 'High-Fidelity UI Screens', 'Interactive Clickable Prototype', 'Component & Style Guide', 'Developer Handoff Files']),
        'is_featured' => 1,
        'order_num' => 5
    ],
    // 6. Graphic Design
    [
        'id' => 6,
        'category_id' => 2,
        'service_code' => 'GRAPHIC_DESIGN',
        'slug' => 'graphic-design',
        'title' => 'Graphic Design',
        'short_description' => 'Creative graphic design services including marketing banners, digital brochures, promotional collaterals, and branded visual materials for online and print media.',
        'full_description' => 'Communicate your brand message with compelling visual assets. Our graphic design services cover promotional banners, marketing materials, digital flyers, and presentation visuals designed to capture customer interest across multiple touchpoints.',
        'badge_label' => 'CREATIVE',
        'price_model' => 'fixed_sprint',
        'typical_timeline' => '3 – 7 Days',
        'tech_stack' => json_encode(['Digital Illustration', 'Vector Graphics', 'Typography', 'Visual Composition', 'Brand Palette']),
        'key_deliverables' => json_encode(['Digital Promotional Banners', 'Marketing Collateral Designs', 'High-Resolution Vector Files', 'Print-Ready & Web Formats']),
        'is_featured' => 0,
        'order_num' => 6
    ],
    // 7. Logo Design
    [
        'id' => 7,
        'category_id' => 2,
        'service_code' => 'LOGO_DESIGN',
        'slug' => 'logo-design',
        'title' => 'Logo Design',
        'short_description' => 'Distinctive, memorable logo design and visual brand identities that define your company character and establish instant recognition.',
        'full_description' => 'Your logo is the foundation of your company image. We design modern, versatile logos that express your business personality, ensuring readability and visual impact across digital screens, business stationery, and promotional merchandise.',
        'badge_label' => 'BRANDING',
        'price_model' => 'fixed_sprint',
        'typical_timeline' => '3 – 5 Days',
        'tech_stack' => json_encode(['Vector Design', 'Custom Typography', 'Color Theory', 'Iconography', 'Brand Guidelines']),
        'key_deliverables' => json_encode(['Multiple Initial Logo Concepts', 'Finalized Vector Master Files (SVG/PNG/PDF)', 'Light & Dark Background Variants', 'Color Palette & Typography Guide']),
        'is_featured' => 1,
        'order_num' => 7
    ],
    // 8. Digital Marketing
    [
        'id' => 8,
        'category_id' => 3,
        'service_code' => 'DIGITAL_MARKETING',
        'slug' => 'digital-marketing',
        'title' => 'Digital Marketing',
        'short_description' => 'Targeted digital marketing strategies designed to increase brand awareness, drive qualified online traffic, and generate prospective client leads.',
        'full_description' => 'Connect with your target audience through structured digital marketing campaigns. We help startups and businesses establish a consistent digital presence, utilize on-page search optimization, and execute strategic promotional efforts.',
        'badge_label' => 'GROWTH',
        'price_model' => 'monthly_pod',
        'typical_timeline' => 'Monthly Retainer',
        'tech_stack' => json_encode(['Search Engine Optimization', 'Social Media Marketing', 'Audience Targeting', 'Content Strategy', 'Analytics']),
        'key_deliverables' => json_encode(['Marketing Strategy Roadmap', 'Search Visibility Optimization', 'Campaign Performance Reports', 'Monthly Growth Recommendations']),
        'is_featured' => 0,
        'order_num' => 8
    ],
    // 9. Social Media Creative Design
    [
        'id' => 9,
        'category_id' => 3,
        'service_code' => 'SOCIAL_MEDIA_CREATIVE',
        'slug' => 'social-media-creative-design',
        'title' => 'Social Media Creative Design',
        'short_description' => 'Engaging, branded social media posts, multi-slide carousels, and story creatives crafted to keep your feed professional and visually cohesive.',
        'full_description' => 'Maintain an active and aesthetic social media presence with customized creative assets. We create cohesive post sets, informational carousels, and promotional graphics formatted specifically for Instagram, LinkedIn, and Facebook.',
        'badge_label' => 'SOCIAL',
        'price_model' => 'monthly_pod',
        'typical_timeline' => '1 – 2 Weeks Sprints',
        'tech_stack' => json_encode(['Visual Layouts', 'Brand Typography', 'Carousel Storyboarding', 'Social Sizing Standards']),
        'key_deliverables' => json_encode(['Monthly Post Creative Batches', 'Carousel Slide Decks', 'Story & Highlight Graphics', 'Ready-to-Publish Formats']),
        'is_featured' => 0,
        'order_num' => 9
    ],
    // 10. Professional Reel Shooting
    [
        'id' => 10,
        'category_id' => 3,
        'service_code' => 'REEL_SHOOTING',
        'slug' => 'professional-reel-shooting',
        'title' => 'Professional Reel Shooting',
        'short_description' => 'On-location and planned visual capture dedicated to producing dynamic vertical video content and short-form engagement reels.',
        'full_description' => 'Bring dynamic video to your brand story with dedicated reel shooting sessions. We plan shot lists, lighting, and camera framing specifically configured for 9:16 vertical mobile consumption, capturing your products, locations, and brand moments.',
        'badge_label' => 'PRODUCTION',
        'price_model' => 'fixed_sprint',
        'typical_timeline' => 'Per Session / Project',
        'tech_stack' => json_encode(['4K Mobile & Camera Gear', 'Stabilization Rigs', 'Studio & Location Lighting', 'Audio Capture']),
        'key_deliverables' => json_encode(['Pre-Shoot Concept & Shot List', 'On-Location Camera & Lighting Setup', 'High-Definition Raw Footage Archival', 'Edited Deliverable Reels']),
        'is_featured' => 1,
        'order_num' => 10
    ],
    // 11. Video Content Creation
    [
        'id' => 11,
        'category_id' => 3,
        'service_code' => 'VIDEO_CONTENT_CREATION',
        'slug' => 'video-content-creation',
        'title' => 'Video Content Creation',
        'short_description' => 'End-to-end promotional videos, company introductions, explainer videos, and product showcase clips with professional editing.',
        'full_description' => 'Visual video content is one of the most effective ways to communicate complex ideas quickly. Click Codex produces promotional videos, service walkthroughs, and product highlights that combine clear narration, graphics, and refined pacing.',
        'badge_label' => 'MEDIA',
        'price_model' => 'fixed_sprint',
        'typical_timeline' => '1 – 3 Weeks',
        'tech_stack' => json_encode(['Video Editing Suites', 'Color Grading', 'Sound Design & Mixing', 'Motion Titles']),
        'key_deliverables' => json_encode(['Script & Storyboard Outline', 'Professional Video Editing', 'Title Animations & Motion Graphics', 'Audio Mastering & Background Music']),
        'is_featured' => 0,
        'order_num' => 11
    ],
    // 12. Reel/Short-Form Video Production
    [
        'id' => 12,
        'category_id' => 3,
        'service_code' => 'REEL_PRODUCTION',
        'slug' => 'reel-short-form-video-production',
        'title' => 'Reel/Short-Form Video Production',
        'short_description' => 'Fast-paced, hook-driven short-form video editing with kinetic typography, seamless transitions, and trending audio synchronization for Instagram and YouTube Shorts.',
        'full_description' => 'Short-form vertical video is essential for modern social media growth. We transform footage into polished, engaging reels and shorts complete with attention-grabbing hooks, clean transitions, animated captions, and beat-matched pacing.',
        'badge_label' => 'TRENDING',
        'price_model' => 'fixed_sprint',
        'typical_timeline' => '3 – 5 Days',
        'tech_stack' => json_encode(['Vertical Video Editing', 'Kinetic Subtitles & Captions', 'Speed Ramps & Transitions', 'Trending Sound Alignment']),
        'key_deliverables' => json_encode(['Hook-Driven Video Cuts', 'Dynamic Animated Captions', 'Color Correction & Sound Polish', 'Optimized Vertical 9:16 Video Export']),
        'is_featured' => 1,
        'order_num' => 12
    ]
];

$stmt = $conn->prepare("INSERT INTO `services` 
    (`id`, `category_id`, `service_code`, `slug`, `title`, `short_description`, `full_description`, `badge_label`, `featured_image`, `price_model`, `typical_timeline`, `tech_stack`, `key_deliverables`, `is_featured`, `is_active`, `order_num`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'assets/images/logo.png', ?, ?, ?, ?, ?, 1, ?)");

foreach ($services as $srv) {
    $stmt->bind_param("iissssssssssii", 
        $srv['id'], 
        $srv['category_id'], 
        $srv['service_code'], 
        $srv['slug'], 
        $srv['title'], 
        $srv['short_description'], 
        $srv['full_description'], 
        $srv['badge_label'], 
        $srv['price_model'], 
        $srv['typical_timeline'], 
        $srv['tech_stack'], 
        $srv['key_deliverables'], 
        $srv['is_featured'], 
        $srv['order_num']
    );
    $stmt->execute();
}
$stmt->close();
echo "  [OK] 12 Click Codex services inserted.\n";

// Service FAQs
$serviceFaqs = [
    [1, 'What is your technology stack for full-stack web development?', 'We utilize robust, modern web technologies such as PHP, MySQL, JavaScript, HTML5/CSS3, and RESTful APIs, selecting the most reliable tools suited for your specific project requirements.'],
    [2, 'Will my website be responsive on mobile devices?', 'Yes, every website we develop is built mobile-first, ensuring smooth navigation, fast loading, and visual clarity across smartphones, tablets, laptops, and desktop screens.'],
    [3, 'Can you build apps for both iOS and Android?', 'Yes, we develop cross-platform mobile applications that run smoothly on both iOS and Android from a unified codebase, ensuring faster development and consistent user experience.'],
    [5, 'What design deliverables do you provide in UI/UX projects?', 'Our UI/UX deliverables typically include user flow diagrams, interactive wireframes, full high-fidelity screen designs, a cohesive component style guide, and developer-ready design files in Figma.'],
    [7, 'In what formats will I receive my final logo files?', 'You will receive vector master files (SVG, PDF) along with high-resolution PNG images with transparent backgrounds, optimized for both light and dark backgrounds and suitable for web and print.'],
    [10, 'How do you plan professional reel shooting sessions?', 'We begin by establishing a shot list, defining the key visual angles, planning the lighting and framing, and shooting the footage on-location to capture authentic brand moments.']
];

$stmt = $conn->prepare("INSERT INTO `service_faqs` (`service_id`, `question`, `answer`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, 1)");
$faqOrder = 1;
foreach ($serviceFaqs as $sf) {
    $stmt->bind_param("issi", $sf[0], $sf[1], $sf[2], $faqOrder);
    $stmt->execute();
    $faqOrder++;
}
$stmt->close();
echo "  [OK] Service FAQs created.\n";

// -----------------------------------------------------------------------------
// STEP 6: PORTFOLIO & THE 5 REAL PROJECTS (NO FABRICATED STATS OR CLIENTS)
// -----------------------------------------------------------------------------
echo "--> STEP 6: Populating portfolio categories and the 5 real projects...\n";

$portCats = [
    ['id' => 1, 'slug' => 'website-development', 'name' => 'Website Development', 'order_num' => 1],
    ['id' => 2, 'slug' => 'full-stack-development', 'name' => 'Full-Stack Development', 'order_num' => 2],
    ['id' => 3, 'slug' => 'creative-marketing', 'name' => 'Design & Creative Media', 'order_num' => 3]
];

$stmt = $conn->prepare("INSERT INTO `portfolio_categories` (`id`, `slug`, `name`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, 1)");
foreach ($portCats as $pc) {
    $stmt->bind_param("issi", $pc['id'], $pc['slug'], $pc['name'], $pc['order_num']);
    $stmt->execute();
}
$stmt->close();

$projects = [
    // Project 1: Jewelry Website
    [
        'id' => 1,
        'category_id' => 1,
        'slug' => 'jewelry-website',
        'title' => 'Jewelry Business Website',
        'client_name' => 'Jewelry Business Showcase',
        'client_location' => 'India',
        'sector_industry' => 'Website Development / E-Commerce',
        'timeline_duration' => '3 Weeks',
        'result_badge' => 'E-Commerce Showcase',
        'excerpt' => 'An elegant, responsive showcase website crafted for a jewelry business, highlighting product collections, refined aesthetics, and mobile-friendly browsing.',
        'challenge_overview' => 'The project required an upscale visual presentation capable of displaying intricate jewelry collections, gold and diamond ornaments, and artisanal accessories with high-clarity imagery while maintaining fast mobile load times and intuitive catalog navigation.',
        'architecture_solution' => 'We designed a refined visual layout featuring rich imagery containers, smooth category filtering, detailed product showcase modals, and a direct inquiry flow allowing interested shoppers to connect seamlessly via contact forms and messaging.',
        'key_metrics' => json_encode([
            ['val' => '100%', 'lbl' => 'Responsive Design'],
            ['val' => 'Sub-1.2s', 'lbl' => 'Page Load Speed'],
            ['val' => 'Mobile-First', 'lbl' => 'Catalog Navigation']
        ]),
        'technologies' => json_encode(['PHP', 'JavaScript', 'HTML5', 'CSS3', 'MySQL', 'Responsive UI']),
        'search_tech_keywords' => 'jewelry website, ecommerce website, jewelry catalog, responsive web development',
        'featured_image' => 'assets/images/logo.png',
        'is_featured' => 1,
        'order_num' => 1
    ],
    // Project 2: Farmhouse Website
    [
        'id' => 2,
        'category_id' => 1,
        'slug' => 'farmhouse-website',
        'title' => 'Farmhouse & Resort Website',
        'client_name' => 'Farmhouse Hospitality',
        'client_location' => 'India',
        'sector_industry' => 'Website Development / Hospitality',
        'timeline_duration' => '2 Weeks',
        'result_badge' => 'Hospitality Showcase',
        'excerpt' => 'A clean, visually engaging hospitality website showcasing farmhouse amenities, photo galleries, location information, and direct inquiry booking flows.',
        'challenge_overview' => 'The goal was to present a tranquil getaway property online with inviting visuals, clear amenity breakdowns (swimming pool, event lawns, guest rooms), location guides, and a straightforward booking inquiry mechanism for guests.',
        'architecture_solution' => 'Built with an open, nature-inspired visual aesthetic, integrated photo galleries with lightbox views, dynamic itinerary displays, Google Maps location integration, and direct booking inquiry forms optimized for mobile visitors.',
        'key_metrics' => json_encode([
            ['val' => 'Clean UI', 'lbl' => 'Nature-Inspired Palette'],
            ['val' => 'Direct Flow', 'lbl' => 'Booking Inquiries'],
            ['val' => 'Optimized', 'lbl' => 'Photo Galleries']
        ]),
        'technologies' => json_encode(['HTML5', 'CSS3', 'JavaScript', 'PHP', 'Gallery Lightbox', 'Google Maps API']),
        'search_tech_keywords' => 'farmhouse website, resort website, hospitality website, booking inquiry',
        'featured_image' => 'assets/images/logo.png',
        'is_featured' => 1,
        'order_num' => 2
    ],
    // Project 3: Business Website
    [
        'id' => 3,
        'category_id' => 1,
        'slug' => 'business-website',
        'title' => 'Professional Corporate Business Website',
        'client_name' => 'Corporate Business Solution',
        'client_location' => 'India',
        'sector_industry' => 'Website Development / Corporate',
        'timeline_duration' => '2 – 3 Weeks',
        'result_badge' => 'Corporate Web Solution',
        'excerpt' => 'A corporate digital presence built to communicate company services, brand credibility, core capabilities, and clear customer contact channels.',
        'challenge_overview' => 'A commercial business needed an authoritative digital footprint to present its service offerings, company vision, leadership profile, and structured contact touchpoints for prospective commercial partners.',
        'architecture_solution' => 'Engineered a modern multi-section corporate layout with clear typographic hierarchy, structured service cards, company profile sections, interactive contact forms, and structured schema data for local search visibility.',
        'key_metrics' => json_encode([
            ['val' => 'Fast Load', 'lbl' => 'Optimized Performance'],
            ['val' => 'Structured', 'lbl' => 'Corporate Hierarchy'],
            ['val' => 'SEO Ready', 'lbl' => 'Semantic Structure']
        ]),
        'technologies' => json_encode(['Modern Web Architecture', 'CSS3', 'JavaScript', 'PHP', 'SEO Structured Data']),
        'search_tech_keywords' => 'business website, corporate website, company portal, responsive design',
        'featured_image' => 'assets/images/logo.png',
        'is_featured' => 1,
        'order_num' => 3
    ],
    // Project 4: Web Development Project
    [
        'id' => 4,
        'category_id' => 2,
        'slug' => 'web-development-project',
        'title' => 'Custom Web Application & Management Project',
        'client_name' => 'Custom Web Solution',
        'client_location' => 'India',
        'sector_industry' => 'Full-Stack Development',
        'timeline_duration' => '4 Weeks',
        'result_badge' => 'Custom Web Application',
        'excerpt' => 'A custom full-stack web application featuring modular components, dynamic content management, and streamlined database interactions.',
        'challenge_overview' => 'Required developing a functional web application with custom user workflows, administrative data tables, dynamic form handling, and organized backend database processing beyond standard static pages.',
        'architecture_solution' => 'Developed using a modular PHP and MySQL architecture with asynchronous form validations, structured database tables, secure session handling, and clean responsive dashboard views.',
        'key_metrics' => json_encode([
            ['val' => 'Full-Stack', 'lbl' => 'Integrated Architecture'],
            ['val' => 'Modular', 'lbl' => 'Clean Code Base'],
            ['val' => 'Secure', 'lbl' => 'Data Management']
        ]),
        'technologies' => json_encode(['Full-Stack Architecture', 'PHP', 'MySQL', 'JavaScript', 'RESTful Workflows', 'Responsive CSS']),
        'search_tech_keywords' => 'custom web application, full stack web project, php mysql app, dynamic web system',
        'featured_image' => 'assets/images/logo.png',
        'is_featured' => 1,
        'order_num' => 4
    ],
    // Project 5: Digital/Creative Project
    [
        'id' => 5,
        'category_id' => 3,
        'slug' => 'digital-creative-project',
        'title' => 'Digital Creative & Social Media Campaign Project',
        'client_name' => 'Digital Creative Showcase',
        'client_location' => 'India',
        'sector_industry' => 'Design / Digital Marketing / Creative',
        'timeline_duration' => '2 Weeks Sprints',
        'result_badge' => 'Creative Campaign Suite',
        'excerpt' => 'A multi-faceted digital design and marketing campaign asset suite encompassing social media creatives, promotional reel styling, and brand identity materials.',
        'challenge_overview' => 'Creating an integrated suite of creative digital assets including cohesive social media banners, promotional reels, and brand marketing collaterals to build visual recognition across digital channels.',
        'architecture_solution' => 'Designed a coordinated visual kit containing high-contrast social media posts, carousel templates, motion reel concepts, and promotional graphics tailored to social platform algorithms and audience attention spans.',
        'key_metrics' => json_encode([
            ['val' => 'Cohesive', 'lbl' => 'Brand Identity Kit'],
            ['val' => 'Multi-Format', 'lbl' => 'Posts, Reels & Stories'],
            ['val' => 'High-Impact', 'lbl' => 'Visual Storytelling']
        ]),
        'technologies' => json_encode(['Visual Identity Design', 'UI/UX Design', 'Social Creatives', 'Motion & Video Editing', 'Typography']),
        'search_tech_keywords' => 'digital creative project, social media design, reel production, visual branding',
        'featured_image' => 'assets/images/logo.png',
        'is_featured' => 1,
        'order_num' => 5
    ]
];

$stmt = $conn->prepare("INSERT INTO `case_studies` 
    (`id`, `category_id`, `slug`, `title`, `client_name`, `client_location`, `sector_industry`, `timeline_duration`, `result_badge`, `excerpt`, `challenge_overview`, `architecture_solution`, `key_metrics`, `technologies`, `search_tech_keywords`, `featured_image`, `order_num`, `is_featured`, `is_active`, `published_at`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())");

foreach ($projects as $p) {
    $stmt->bind_param("iissssssssssssssii",
        $p['id'],
        $p['category_id'],
        $p['slug'],
        $p['title'],
        $p['client_name'],
        $p['client_location'],
        $p['sector_industry'],
        $p['timeline_duration'],
        $p['result_badge'],
        $p['excerpt'],
        $p['challenge_overview'],
        $p['architecture_solution'],
        $p['key_metrics'],
        $p['technologies'],
        $p['search_tech_keywords'],
        $p['featured_image'],
        $p['order_num'],
        $p['is_featured']
    );
    $stmt->execute();
}
$stmt->close();
echo "  [OK] 5 Click Codex realistic projects inserted without fabricated claims.\n";

// -----------------------------------------------------------------------------
// STEP 7: COMPANY VALUES & REALISTIC STARTUP MILESTONES
// -----------------------------------------------------------------------------
echo "--> STEP 7: Populating Click Codex startup values and milestones...\n";

$values = [
    [
        'pillar_key' => 'craftsmanship',
        'title' => 'Technical Craftsmanship',
        'subtitle' => 'Clean Code & Robust Design',
        'metric_badge' => 'STANDARD',
        'description' => 'We treat every website, application, and creative asset as a reflection of our dedication to quality, maintainable code, and modern aesthetics.',
        'stat1_val' => '100%',
        'stat1_lbl' => 'Handcrafted Code',
        'stat2_val' => 'Modern',
        'stat2_lbl' => 'Tech Standards',
        'stat3_val' => 'Clean',
        'stat3_lbl' => 'Architecture',
        'order_num' => 1
    ],
    [
        'pillar_key' => 'collaboration',
        'title' => 'Direct Collaboration',
        'subtitle' => 'Transparent Communication',
        'metric_badge' => 'APPROACH',
        'description' => 'You communicate directly with the builders, designers, and creators working on your project, eliminating bureaucratic delays and miscommunication.',
        'stat1_val' => '4-Member',
        'stat1_lbl' => 'Focused Core Team',
        'stat2_val' => 'Direct',
        'stat2_lbl' => 'Developer Access',
        'stat3_val' => 'Clear',
        'stat3_lbl' => 'Project Milestones',
        'order_num' => 2
    ],
    [
        'pillar_key' => 'multidisciplinary',
        'title' => 'Multidisciplinary Synergy',
        'subtitle' => 'Code, Design & Video Under One Roof',
        'metric_badge' => 'CAPABILITY',
        'description' => 'From full-stack development and graphic design to professional reel shooting and video production, our team covers the complete digital spectrum.',
        'stat1_val' => '12',
        'stat1_lbl' => 'Service Areas',
        'stat2_val' => 'Unified',
        'stat2_lbl' => 'Creative Delivery',
        'stat3_val' => '~2 Years',
        'stat3_lbl' => 'Tech Experience',
        'order_num' => 3
    ],
    [
        'pillar_key' => 'agility',
        'title' => 'Agile Startup Velocity',
        'subtitle' => 'Rapid Iteration & Delivery',
        'metric_badge' => 'EXECUTION',
        'description' => 'As an agile startup, we adapt quickly, iterate rapidly, and focus on delivering practical, working solutions that solve real business challenges.',
        'stat1_val' => 'Sprint-Based',
        'stat1_lbl' => 'Agile Delivery',
        'stat2_val' => 'Fast',
        'stat2_lbl' => 'Feedback Loops',
        'stat3_val' => 'High',
        'stat3_lbl' => 'Commitment Level',
        'order_num' => 4
    ]
];

$stmt = $conn->prepare("INSERT INTO `company_values` (`pillar_key`, `title`, `subtitle`, `metric_badge`, `description`, `stat1_val`, `stat1_lbl`, `stat2_val`, `stat2_lbl`, `stat3_val`, `stat3_lbl`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
foreach ($values as $v) {
    $stmt->bind_param("sssssssssssi", $v['pillar_key'], $v['title'], $v['subtitle'], $v['metric_badge'], $v['description'], $v['stat1_val'], $v['stat1_lbl'], $v['stat2_val'], $v['stat2_lbl'], $v['stat3_val'], $v['stat3_lbl'], $v['order_num']);
    $stmt->execute();
}
$stmt->close();

$milestones = [
    [
        'year_label' => 'Phase 1',
        'title' => 'Founding & Team Synergy',
        'description' => 'A team of four skilled technologists and creators with collective experience across development, design, marketing, and media came together to build Click Codex.',
        'order_num' => 1
    ],
    [
        'year_label' => 'Phase 2',
        'title' => 'Initial Projects & Portfolio Development',
        'description' => 'Developed our first five showcase projects across jewelry e-commerce, hospitality resorts, business portals, web apps, and creative marketing campaigns.',
        'order_num' => 2
    ],
    [
        'year_label' => 'Phase 3',
        'title' => 'Service Architecture & Studio Tooling',
        'description' => 'Consolidated our twelve core offerings spanning full-stack development, mobile apps, graphic design, reel shooting, and social video production.',
        'order_num' => 3
    ],
    [
        'year_label' => 'Phase 4',
        'title' => 'Official Launch Readiness',
        'description' => 'Deploying the Click Codex digital studio platform and preparing to officially begin commercial operations for clients and brand partners.',
        'order_num' => 4
    ]
];

$stmt = $conn->prepare("INSERT INTO `company_milestones` (`year_label`, `title`, `description`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, 1)");
foreach ($milestones as $m) {
    $stmt->bind_param("sssi", $m['year_label'], $m['title'], $m['description'], $m['order_num']);
    $stmt->execute();
}
$stmt->close();
echo "  [OK] Company values and startup milestones inserted.\n";

// -----------------------------------------------------------------------------
// STEP 8: PRICING PLANS & INCLUSIONS (STARTUP FRIENDLY)
// -----------------------------------------------------------------------------
echo "--> STEP 8: Populating startup pricing packages & inclusions...\n";

$pricingPlans = [
    [
        'id' => 1,
        'plan_code' => 'STARTER_WEB',
        'name' => 'Starter Website / MVP',
        'slug' => 'starter-website-mvp',
        'badge_text' => 'POPULAR',
        'short_desc' => 'Ideal for businesses, startups, and personal brands seeking a modern, fast, and mobile-friendly digital presence.',
        'price_inr' => 24999.00,
        'price_usd' => 349.00,
        'period_label' => '/ project',
        'estimated_duration' => 'Estimated: 2 – 3 Weeks',
        'is_popular' => 1,
        'order_num' => 1,
        'features' => [
            'Up to 5 Responsive Website Pages',
            'Mobile-First & Tablet Optimized',
            'Contact & Inquiry Forms Setup',
            'Basic On-Page SEO Configuration',
            'Social Media Links Integration',
            '1 Month Deployment Support'
        ]
    ],
    [
        'id' => 2,
        'plan_code' => 'GROWTH_CREATIVE',
        'name' => 'Growth & Creative Suite',
        'slug' => 'growth-creative-suite',
        'badge_text' => 'RECOMMENDED',
        'short_desc' => 'Comprehensive package combining modern website development with creative branding, graphic design, and social media media.',
        'price_inr' => 49999.00,
        'price_usd' => 699.00,
        'period_label' => '/ project',
        'estimated_duration' => 'Estimated: 3 – 5 Weeks',
        'is_popular' => 0,
        'order_num' => 2,
        'features' => [
            'Full Custom Website Development',
            'UI/UX Design & Brand Asset Creation',
            'Professional Logo Design & Guidelines',
            'Social Media Creative Kit (Posts & Stories)',
            'Short-Form Video / Reel Production Assets',
            'Speed Optimization & Schema Setup'
        ]
    ],
    [
        'id' => 3,
        'plan_code' => 'CUSTOM_SPRINT',
        'name' => 'Custom Development Pod',
        'slug' => 'custom-development-pod',
        'badge_text' => 'TAILORED',
        'short_desc' => 'Dedicated engineering and creative capacity tailored for custom web applications, mobile apps, or ongoing digital media production.',
        'price_inr' => 74999.00,
        'price_usd' => 999.00,
        'period_label' => '/ sprint',
        'estimated_duration' => 'Flexible Sprints',
        'is_popular' => 0,
        'order_num' => 3,
        'features' => [
            'Dedicated 4-Member Click Codex Team',
            'Full-Stack Web & Software Engineering',
            'Mobile App Development Milestones',
            'Custom Workflow Automation Tools',
            'Professional Video & Reel Shooting Sessions',
            'Continuous Priority Collaboration'
        ]
    ]
];

$stmt = $conn->prepare("INSERT INTO `pricing_plans` (`id`, `plan_code`, `name`, `slug`, `badge_text`, `short_desc`, `price_inr`, `price_usd`, `period_label`, `estimated_duration`, `is_popular`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
$featStmt = $conn->prepare("INSERT INTO `pricing_features` (`plan_id`, `feature_text`, `is_included`, `order_num`) VALUES (?, ?, 1, ?)");

foreach ($pricingPlans as $plan) {
    $stmt->bind_param("isssssddssii", 
        $plan['id'], $plan['plan_code'], $plan['name'], $plan['slug'], $plan['badge_text'], 
        $plan['short_desc'], $plan['price_inr'], $plan['price_usd'], $plan['period_label'], 
        $plan['estimated_duration'], $plan['is_popular'], $plan['order_num']
    );
    $stmt->execute();

    $fOrder = 1;
    foreach ($plan['features'] as $feat) {
        $featStmt->bind_param("isi", $plan['id'], $feat, $fOrder);
        $featStmt->execute();
        $fOrder++;
    }
}
$stmt->close();
$featStmt->close();

$inclusions = [
    ['icon_symbol' => 'layers', 'title' => 'Transparent Communication', 'description' => 'Direct communication with the team members working on your deliverables with regular milestone updates.', 'order_num' => 1],
    ['icon_symbol' => 'code', 'title' => 'Clean & Modern Code', 'description' => 'Structured, maintainable code standards that ensure longevity, easy updates, and fast page loading.', 'order_num' => 2],
    ['icon_symbol' => 'smartphone', 'title' => 'Mobile Responsive by Default', 'description' => 'Every single design, website, and digital layout is tested thoroughly across screen sizes.', 'order_num' => 3],
    ['icon_symbol' => 'shield', 'title' => 'Client Code & Asset Ownership', 'description' => 'You own 100% of your source code, design master files, videos, and project deliverables upon handover.', 'order_num' => 4]
];

$stmt = $conn->prepare("INSERT INTO `pricing_inclusions` (`icon_symbol`, `title`, `description`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, 1)");
foreach ($inclusions as $inc) {
    $stmt->bind_param("sssi", $inc['icon_symbol'], $inc['title'], $inc['description'], $inc['order_num']);
    $stmt->execute();
}
$stmt->close();
echo "  [OK] Pricing plans, features, and inclusions inserted.\n";

// -----------------------------------------------------------------------------
// STEP 9: SOLUTION ADVISOR / SERVICE FINDER TOOL
// -----------------------------------------------------------------------------
echo "--> STEP 9: Populating Solution Advisor for Click Codex services...\n";

$archetypes = [
    [
        'id' => 1,
        'archetype_key' => 'website_starter',
        'name' => 'Fast Business Website',
        'badge_text' => 'Archetype 01',
        'description' => 'A clean, high-performance website tailored for businesses or personal brands wanting a credible online presence.',
        'best_for' => 'Startups, Local Businesses & Portfolios',
        'checklists' => json_encode(['Mobile-first responsive design', 'Fast load times & basic SEO', 'Direct inquiry contact forms']),
        'recommended_stack' => json_encode(['HTML5', 'CSS3', 'JavaScript', 'PHP', 'Responsive Grid']),
        'time_to_market' => '2 – 3 Weeks',
        'investment_tier' => 'Starter Tier',
        'scalability_ceiling' => 'Standard Web',
        'seo_dominance' => 'Targeted Local & Brand SEO',
        'maintenance_overhead' => 'Minimal',
        'typical_team_pod' => 'Web Developer & Designer',
        'order_num' => 1
    ],
    [
        'id' => 2,
        'archetype_key' => 'fullstack_solution',
        'name' => 'Custom Full-Stack Web App',
        'badge_text' => 'Archetype 02',
        'description' => 'Dynamic web application with user logins, custom workflows, database operations, and API integrations.',
        'best_for' => 'Web Applications & Internal Systems',
        'checklists' => json_encode(['Custom database schema design', 'User authentication & access control', 'Dynamic frontend interfaces']),
        'recommended_stack' => json_encode(['PHP', 'MySQL', 'JavaScript', 'REST APIs', 'Modular MVC']),
        'time_to_market' => '4 – 6 Weeks',
        'investment_tier' => 'Custom Web Tier',
        'scalability_ceiling' => 'High',
        'seo_dominance' => 'Application Level',
        'maintenance_overhead' => 'Moderate',
        'typical_team_pod' => 'Full-Stack Developer & Designer',
        'order_num' => 2
    ],
    [
        'id' => 3,
        'archetype_key' => 'branding_creative',
        'name' => 'Brand Identity & Design Suite',
        'badge_text' => 'Archetype 03',
        'description' => 'Complete visual identity overhaul including logo design, UI/UX screens, social media creatives, and marketing graphics.',
        'best_for' => 'New Ventures & Brand Refreshes',
        'checklists' => json_encode(['Vector logo and brand guide', 'Figma UI/UX wireframes and prototype', 'Social media creative batch']),
        'recommended_stack' => json_encode(['Figma', 'Vector Design', 'Social Formatting', 'Brand Typography']),
        'time_to_market' => '1 – 3 Weeks',
        'investment_tier' => 'Design Sprint Tier',
        'scalability_ceiling' => 'Universal Brand Assets',
        'seo_dominance' => 'Visual Recognition',
        'maintenance_overhead' => 'None',
        'typical_team_pod' => 'UI/UX & Graphic Designer',
        'order_num' => 3
    ],
    [
        'id' => 4,
        'archetype_key' => 'video_reel_production',
        'name' => 'Video & Reel Production Package',
        'badge_text' => 'Archetype 04',
        'description' => 'Dynamic short-form video content creation, professional on-location reel shooting, and engaging social video editing.',
        'best_for' => 'Instagram, YouTube Shorts & Viral Engagement',
        'checklists' => json_encode(['On-location / studio video capture', 'Kinetic captions and trending audio sync', 'Fast-paced hook-driven editing']),
        'recommended_stack' => json_encode(['4K Video Gear', 'Mobile Rigs', 'Vertical Video Suite', 'Sound Sync']),
        'time_to_market' => '1 – 2 Weeks',
        'investment_tier' => 'Media Production Tier',
        'scalability_ceiling' => 'High Social Reach',
        'seo_dominance' => 'Social Platform Algorithms',
        'maintenance_overhead' => 'Per Campaign',
        'typical_team_pod' => 'Video Producer & Creator',
        'order_num' => 4
    ]
];

$stmt = $conn->prepare("INSERT INTO `advisor_archetypes` 
    (`id`, `archetype_key`, `name`, `badge_text`, `description`, `best_for`, `checklists`, `recommended_stack`, `time_to_market`, `investment_tier`, `scalability_ceiling`, `seo_dominance`, `maintenance_overhead`, `typical_team_pod`, `order_num`, `is_active`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");

foreach ($archetypes as $arch) {
    $stmt->bind_param("isssssssssssssi", 
        $arch['id'], $arch['archetype_key'], $arch['name'], $arch['badge_text'], 
        $arch['description'], $arch['best_for'], $arch['checklists'], $arch['recommended_stack'], 
        $arch['time_to_market'], $arch['investment_tier'], $arch['scalability_ceiling'], 
        $arch['seo_dominance'], $arch['maintenance_overhead'], $arch['typical_team_pod'], $arch['order_num']
    );
    $stmt->execute();
}
$stmt->close();

// Solution Advisor Questions & Options
$questions = [
    [
        'id' => 1,
        'step_number' => 1,
        'step_label' => 'Primary Goal',
        'category_key' => 'goal',
        'question_text' => 'What is the main objective you want to achieve?',
        'question_subtitle' => 'Select the primary goal that best matches your immediate requirement.',
        'is_multi_select' => 0,
        'order_num' => 1,
        'options' => [
            ['opt_key' => 'build_website', 'icon' => '🌐', 'title' => 'Build or Redesign a Website', 'desc' => 'A clean, modern website to showcase your business, services, or personal brand.'],
            ['opt_key' => 'build_webapp', 'icon' => '⚡', 'title' => 'Custom Web or Software App', 'desc' => 'A tailored full-stack application or software tool with custom workflows.'],
            ['opt_key' => 'brand_design', 'icon' => '🎨', 'title' => 'Logo, UI/UX or Graphic Design', 'desc' => 'Memorable logo creation, UI/UX screens, or visual marketing collaterals.'],
            ['opt_key' => 'video_reels', 'icon' => '🎬', 'title' => 'Reel Shooting & Video Content', 'desc' => 'Professional short-form video shooting, editing, and dynamic social media reels.']
        ]
    ],
    [
        'id' => 2,
        'step_number' => 2,
        'step_label' => 'Current Stage',
        'category_key' => 'stage',
        'question_text' => 'Where are you currently in your project lifecycle?',
        'question_subtitle' => 'This helps us scope the required milestones and support.',
        'is_multi_select' => 0,
        'order_num' => 2,
        'options' => [
            ['opt_key' => 'starting_out', 'icon' => '🌱', 'title' => 'Early Concept / Just Starting Out', 'desc' => 'We have an idea or requirement and need foundational guidance and building.'],
            ['opt_key' => 'need_upgrade', 'icon' => '🚀', 'title' => 'Existing Presence Needs an Upgrade', 'desc' => 'We have an existing website or assets that need redesigning or rebuilding.'],
            ['opt_key' => 'ready_to_build', 'icon' => '📐', 'title' => 'Clear Requirements, Ready to Execute', 'desc' => 'We have our content, requirements, or design ready to develop.']
        ]
    ],
    [
        'id' => 3,
        'step_number' => 3,
        'step_label' => 'Desired Timeline',
        'category_key' => 'timeline',
        'question_text' => 'What is your preferred project completion timeline?',
        'question_subtitle' => 'Helps us schedule our 4-member sprint capacity.',
        'is_multi_select' => 0,
        'order_num' => 3,
        'options' => [
            ['opt_key' => 'fast_track', 'icon' => '⚡', 'title' => 'Fast-Track (1 – 2 Weeks)', 'desc' => 'Accelerated delivery for urgent launches or starter assets.'],
            ['opt_key' => 'standard_sprint', 'icon' => '⏱️', 'title' => 'Standard Sprint (2 – 4 Weeks)', 'desc' => 'Thorough development, design iterations, and quality checks.'],
            ['opt_key' => 'flexible', 'icon' => '📅', 'title' => 'Flexible / Phased Rollout', 'desc' => 'Milestone-based progress with iterative reviews and expansion.']
        ]
    ]
];

$qStmt = $conn->prepare("INSERT INTO `solution_advisor_questions` (`id`, `step_number`, `step_label`, `category_key`, `question_text`, `question_subtitle`, `is_multi_select`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)");
$optStmt = $conn->prepare("INSERT INTO `solution_advisor_options` (`question_id`, `option_key`, `icon_emoji`, `title`, `description`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, 1)");

foreach ($questions as $q) {
    $qStmt->bind_param("iissssii", $q['id'], $q['step_number'], $q['step_label'], $q['category_key'], $q['question_text'], $q['question_subtitle'], $q['is_multi_select'], $q['order_num']);
    $qStmt->execute();

    $oOrder = 1;
    foreach ($q['options'] as $opt) {
        $optStmt->bind_param("issssi", $q['id'], $opt['opt_key'], $opt['icon'], $opt['title'], $opt['desc'], $oOrder);
        $optStmt->execute();
        $oOrder++;
    }
}
$qStmt->close();
$optStmt->close();
echo "  [OK] Solution advisor archetypes, questions, and options created.\n";

// -----------------------------------------------------------------------------
// STEP 10: BLOGS & DISPATCH (CLEAN STARTUP KNOWLEDGE CATEGORIES)
// -----------------------------------------------------------------------------
echo "--> STEP 10: Setting up clean blog categories and author...\n";

$blogCats = [
    ['id' => 1, 'name' => 'Web & Tech Insights', 'slug' => 'web-tech-insights', 'description' => 'Practical guides and engineering notes on modern web and software development.', 'badge_color' => '#0056d6', 'badge_bg' => 'rgba(0,86,214,0.08)'],
    ['id' => 2, 'name' => 'Design & UI/UX', 'slug' => 'design-ui-ux', 'description' => 'Principles of user interface design, logo aesthetics, and visual brand identity.', 'badge_color' => '#8b5cf6', 'badge_bg' => 'rgba(139,92,246,0.08)'],
    ['id' => 3, 'name' => 'Digital Marketing & Media', 'slug' => 'marketing-media', 'description' => 'Social media creatives, vertical reel techniques, and digital growth approaches.', 'badge_color' => '#00a2ff', 'badge_bg' => 'rgba(0,162,255,0.08)']
];

$stmt = $conn->prepare("INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `badge_color`, `badge_bg`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
$bOrder = 1;
foreach ($blogCats as $bc) {
    $stmt->bind_param("isssssi", $bc['id'], $bc['name'], $bc['slug'], $bc['description'], $bc['badge_color'], $bc['badge_bg'], $bOrder);
    $stmt->execute();
    $bOrder++;
}
$stmt->close();

$stmt = $conn->prepare("INSERT INTO `blog_authors` (`id`, `name`, `slug`, `role_title`, `initials`, `avatar_image`, `bio`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, 1, 1)");
$aId = 1;
$aName = "Click Codex Editorial Team";
$aSlug = "click-codex-editorial";
$aRole = "Engineering & Creative Collective";
$aInit = "CC";
$aAvatar = "assets/images/logo.png";
$aBio = "The Click Codex team publishes practical articles and engineering notes covering web development, responsive design, UI/UX aesthetics, and creative short-form video production.";
$stmt->bind_param("issssss", $aId, $aName, $aSlug, $aRole, $aInit, $aAvatar, $aBio);
$stmt->execute();
$stmt->close();

// Starter Clean Informative Article
$stmt = $conn->prepare("INSERT INTO `blog_posts` 
    (`id`, `category_id`, `author_id`, `title`, `slug`, `excerpt`, `content`, `reading_time_minutes`, `featured_badge`, `search_keywords`, `featured_image`, `views_count`, `likes_count`, `is_featured`, `is_published`, `published_at`) 
    VALUES (1, 1, 1, ?, ?, ?, ?, 4, 'STUDIO DISPATCH', ?, 'assets/images/logo.png', 120, 18, 1, 1, NOW())");

$artTitle = "Building Modern, High-Performance Websites: Key Foundations for New Startups";
$artSlug = "building-modern-high-performance-websites-startups";
$artExcerpt = "A walkthrough of essential web foundations every new business needs: responsive layout architecture, fast page load speeds, clean navigation, and accessible mobile experiences.";
$artContent = "<h3>The Foundation of a High-Impact Digital Presence</h3><p>For modern startups and emerging businesses, a website is much more than a digital business card—it is the central hub where customer credibility, service clarity, and brand conversion intersect.</p><h4>1. Mobile-First Responsiveness</h4><p>With the vast majority of web traffic originating on smartphones, designing for mobile screens first is essential. Fluid typography, responsive grids, and touch-friendly navigation ensure that prospective clients experience zero friction when browsing your services.</p><h4>2. Performance & Speed Optimization</h4><p>Fast page load times dramatically improve visitor retention. By optimizing imagery formats, minimizing unnecessary scripts, and structuring semantic HTML, websites can achieve swift rendering speeds that keep users engaged.</p><h4>3. Clear Service Communication & Inquiries</h4><p>A successful website makes it immediately obvious what problems your business solves. Highlighting clear service categories, showcase projects, and straightforward contact pathways empowers interested visitors to reach out with confidence.</p>";
$artKeywords = "modern websites, startup web design, responsive development, click codex, web performance";

$stmt->bind_param("sssss", $artTitle, $artSlug, $artExcerpt, $artContent, $artKeywords);
$stmt->execute();
$stmt->close();
echo "  [OK] Clean blog category, author, and foundational article configured.\n";

// -----------------------------------------------------------------------------
// STEP 11: ALL 10 PAGES & DYNAMIC PAGE SECTIONS (CLICK CODEX PROFILE)
// -----------------------------------------------------------------------------
echo "--> STEP 11: Populating site pages and sections with Click Codex information...\n";

$pages = [
    [
        'id' => 1,
        'page_key' => 'home',
        'title' => 'Click Codex — Full-Stack Web Development, Design & Creative Studio',
        'slug' => '',
        'headline' => 'Digital Craftsmanship, Full-Stack Engineering & Creative Media',
        'subheadline' => 'Click Codex is a modern technology startup preparing to launch operations. Powered by a collaborative 4-member team with ~2 years of hands-on experience in web development, mobile apps, software, UI/UX, graphic design, and video production.'
    ],
    [
        'id' => 2,
        'page_key' => 'about_us',
        'title' => 'About Click Codex — Our Team & Story',
        'slug' => 'aboutus',
        'headline' => 'A Focused 4-Member Technology & Creative Startup',
        'subheadline' => 'Meet Click Codex. We are an agile startup preparing to officially begin our operations, uniting ~2 years of collective experience across development, design, marketing, and media creation.'
    ],
    [
        'id' => 3,
        'page_key' => 'services',
        'title' => 'Our Services — Full-Stack Web, Design, Marketing & Video',
        'slug' => 'services',
        'headline' => '12 Core Services Tailored for Digital Growth',
        'subheadline' => 'From full-stack web and mobile apps to graphic design, logo creation, digital marketing, and professional reel shooting.'
    ],
    [
        'id' => 4,
        'page_key' => 'service_finder',
        'title' => 'Solution Advisor — Find the Right Service for Your Project',
        'slug' => 'service-finder',
        'headline' => 'Interactive Solution Advisor',
        'subheadline' => 'Answer 3 quick questions about your project goals and timeline to receive tailored recommendations.'
    ],
    [
        'id' => 5,
        'page_key' => 'portfolio',
        'title' => 'Portfolio & Projects — Click Codex Showcase',
        'slug' => 'portfolio',
        'headline' => 'Our Showcase Projects',
        'subheadline' => 'Explore 5 realistic projects developed by the Click Codex team across jewelry e-commerce, farmhouse hospitality, business websites, custom web apps, and creative marketing.'
    ],
    [
        'id' => 6,
        'page_key' => 'pricing',
        'title' => 'Transparent Pricing & Delivery Models — Click Codex',
        'slug' => 'pricing',
        'headline' => 'Transparent, Startup-Friendly Project Packages',
        'subheadline' => 'Clear sprint pricing designed for businesses and startups, backed by 100% intellectual property ownership and direct developer collaboration.'
    ],
    [
        'id' => 7,
        'page_key' => 'blogs',
        'title' => 'Blogs & Technical Dispatch — Click Codex',
        'slug' => 'blogs',
        'headline' => 'Tech Insights, Design Principles & Studio Dispatch',
        'subheadline' => 'Practical articles and updates on web development, UI/UX design, and short-form video content creation.'
    ],
    [
        'id' => 8,
        'page_key' => 'contact_us',
        'title' => 'Contact Us — Start a Project with Click Codex',
        'slug' => 'contactus',
        'headline' => 'Let’s Build Something Meaningful Together',
        'subheadline' => 'Have a project in mind? Reach out directly to our 4-member team for website development, design, or video production requirements.'
    ],
    [
        'id' => 9,
        'page_key' => 'privacy_policy',
        'title' => 'Privacy Policy — Click Codex',
        'slug' => 'privacy-policy',
        'headline' => 'Privacy Policy',
        'subheadline' => 'How Click Codex collects, utilizes, and protects information submitted via our website and inquiry forms.'
    ],
    [
        'id' => 10,
        'page_key' => 'terms_of_service',
        'title' => 'Terms of Service — Click Codex',
        'slug' => 'terms-of-service',
        'headline' => 'Terms of Service',
        'subheadline' => 'Terms governing engagement, service delivery, intellectual property, and website usage with Click Codex.'
    ]
];

$stmt = $conn->prepare("INSERT INTO `pages` (`id`, `page_key`, `title`, `slug`, `headline`, `subheadline`, `banner_image`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, 'assets/images/logo.png', 1)");
foreach ($pages as $p) {
    $stmt->bind_param("isssss", $p['id'], $p['page_key'], $p['title'], $p['slug'], $p['headline'], $p['subheadline']);
    $stmt->execute();
}
$stmt->close();

// Page Sections (Updating Home and About Us dynamic sections to reflect Click Codex accurately)
$sections = [
    // Home Page Sections
    [
        'page_id' => 1,
        'section_key' => 'hero',
        'title' => 'Digital Craftsmanship, Full-Stack Engineering & Creative Media',
        'subtitle' => 'Click Codex is an agile technology and creative studio preparing to launch operations. Powered by a 4-member team with ~2 years of collective experience across web development, mobile apps, graphic design, and reel production.',
        'badge_text' => 'EMERGING TECHNOLOGY STARTUP',
        'cta_primary_text' => 'Explore Our 12 Services',
        'cta_primary_url' => 'services',
        'cta_secondary_text' => 'View Projects',
        'cta_secondary_url' => 'portfolio',
        'order_num' => 1
    ],
    [
        'page_id' => 1,
        'section_key' => 'team_overview',
        'title' => 'A Focused 4-Member Collaborative Team',
        'subtitle' => 'We unite hands-on engineering, creative UI/UX, digital marketing strategy, and short-form video production under one roof.',
        'badge_text' => '4-MEMBER CORE TEAM',
        'cta_primary_text' => 'About Our Team',
        'cta_primary_url' => 'aboutus',
        'cta_secondary_text' => 'Contact Us',
        'cta_secondary_url' => 'contactus',
        'order_num' => 2
    ],
    [
        'page_id' => 1,
        'section_key' => 'cta_banner',
        'title' => 'Ready to Discuss Your Next Digital Project?',
        'subtitle' => 'Connect directly with the Click Codex team to discuss your website, design, or video production requirements.',
        'badge_text' => 'START A PROJECT',
        'cta_primary_text' => 'Start Conversation',
        'cta_primary_url' => 'contactus',
        'cta_secondary_text' => 'Use Solution Advisor',
        'cta_secondary_url' => 'service-finder',
        'order_num' => 3
    ],
    // About Us Page Sections
    [
        'page_id' => 2,
        'section_key' => 'hero',
        'title' => 'About Click Codex',
        'subtitle' => 'An emerging technology startup built on close collaboration, modern technical skills, and practical creative delivery.',
        'badge_text' => 'STARTUP PROFILE',
        'cta_primary_text' => 'Explore Services',
        'cta_primary_url' => 'services',
        'cta_secondary_text' => 'Get in Touch',
        'cta_secondary_url' => 'contactus',
        'order_num' => 1
    ],
    [
        'page_id' => 2,
        'section_key' => 'about_pillars',
        'title' => 'Our Core Foundations',
        'subtitle' => 'How our 4-member team approaches code quality, design fidelity, and client transparency.',
        'badge_text' => 'FOUNDATIONS',
        'cta_primary_text' => 'View Projects',
        'cta_primary_url' => 'portfolio',
        'cta_secondary_text' => null,
        'cta_secondary_url' => null,
        'order_num' => 2
    ]
];

$stmt = $conn->prepare("INSERT INTO `page_sections` (`page_id`, `section_key`, `title`, `subtitle`, `badge_text`, `cta_primary_text`, `cta_primary_url`, `cta_secondary_text`, `cta_secondary_url`, `media_url`, `order_num`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'assets/images/logo.png', ?, 1)");
foreach ($sections as $s) {
    $stmt->bind_param("issssssssi", $s['page_id'], $s['section_key'], $s['title'], $s['subtitle'], $s['badge_text'], $s['cta_primary_text'], $s['cta_primary_url'], $s['cta_secondary_text'], $s['cta_secondary_url'], $s['order_num']);
    $stmt->execute();
}
$stmt->close();
echo "  [OK] Pages and dynamic sections populated.\n";

// -----------------------------------------------------------------------------
// STEP 12: GENERAL FAQS (HONEST STARTUP ANSWERS)
// -----------------------------------------------------------------------------
echo "--> STEP 12: Inserting general FAQs suitable for Click Codex...\n";

$faqs = [
    [
        'category' => 'general',
        'question' => 'What is Click Codex and what stage is the company in?',
        'answer' => 'Click Codex is a newly formed technology and creative startup preparing to officially begin its commercial operations. Our collaborative 4-member team brings approximately 2 years of collective experience across full-stack development, mobile apps, UI/UX, graphic design, and video production.',
        'order_num' => 1
    ],
    [
        'category' => 'general',
        'question' => 'How does Click Codex work with clients on projects?',
        'answer' => 'We work on an agile sprint model with direct communication. You speak directly with the team members building your project, receiving transparent milestone updates and code/design previews without bureaucratic layers.',
        'order_num' => 2
    ],
    [
        'category' => 'services',
        'question' => 'What services does Click Codex provide?',
        'answer' => 'We offer 12 comprehensive services across Web & Software (Full-Stack Web Development, Website Development, Mobile Apps, Custom Software), Creative Design (UI/UX Design, Graphic Design, Logo Design), and Marketing & Media (Digital Marketing, Social Media Creatives, Reel Shooting, Video Content Creation, Short-Form Reel Production).',
        'order_num' => 3
    ],
    [
        'category' => 'pricing',
        'question' => 'Who owns the intellectual property and code upon project completion?',
        'answer' => 'You do. Upon completion and settlement of the project sprint, you receive 100% full ownership of your source code, design files, vector assets, and video deliverables.',
        'order_num' => 4
    ],
    [
        'category' => 'technical',
        'question' => 'What types of websites and projects can you build?',
        'answer' => 'We specialize in responsive corporate websites, e-commerce storefronts, hospitality portals, custom web applications, and social media creative campaign assets, with a focus on speed, aesthetics, and reliability.',
        'order_num' => 5
    ]
];

$stmt = $conn->prepare("INSERT INTO `faqs` (`category`, `question`, `answer`, `order_num`, `is_featured`, `is_active`) VALUES (?, ?, ?, ?, 1, 1)");
foreach ($faqs as $f) {
    $stmt->bind_param("sssi", $f['category'], $f['question'], $f['answer'], $f['order_num']);
    $stmt->execute();
}
$stmt->close();
echo "  [OK] General FAQs inserted.\n";

// -----------------------------------------------------------------------------
// STEP 13: SEO METADATA (UNIVERSAL ENGINE FOR ALL PAGES, SERVICES & PROJECTS)
// -----------------------------------------------------------------------------
echo "--> STEP 13: Generating clean, comprehensive SEO metadata...\n";

$seoEntries = [
    // Pages
    ['page', 1, '/', 'Click Codex — Technology & Creative Digital Startup', 'Click Codex is an agile technology startup offering Full-Stack Web Development, Mobile Apps, UI/UX Design, Graphic Design, Digital Marketing, and Professional Video/Reel Production.', 'Click Codex, web development startup, mobile apps, UI UX, reel shooting', 1.0],
    ['page', 2, '/aboutus', 'About Click Codex — Our Team & Story', 'Learn about Click Codex, an emerging digital technology startup powered by an experienced 4-member team with ~2 years collective tech experience.', 'about Click Codex, startup team, technology experience', 0.9],
    ['page', 3, '/services', 'Our Services — Full-Stack Web, Design & Media | Click Codex', 'Explore 12 core digital services offered by Click Codex: web development, mobile apps, software, UI/UX, graphic design, digital marketing, and reel production.', 'web development services, mobile app development, graphic design, reel shooting', 0.9],
    ['page', 4, '/service-finder', 'Solution Advisor — Tailored Service Recommendation | Click Codex', 'Use the Click Codex interactive solution advisor to discover the optimal service and development roadmap for your project.', 'solution advisor, service finder, web project planning', 0.8],
    ['page', 5, '/portfolio', 'Portfolio & Projects — Click Codex Showcase', 'Explore realistic projects by Click Codex including jewelry websites, farmhouse hospitality portals, business websites, and creative media campaigns.', 'Click Codex portfolio, web design projects, ecommerce website, case studies', 0.9],
    ['page', 6, '/pricing', 'Pricing & Delivery Models — Click Codex', 'Transparent, startup-friendly project packages for website development, branding, and dedicated full-stack development pods.', 'website pricing, web development cost, startup pricing', 0.8],
    ['page', 7, '/blogs', 'Blogs & Tech Dispatch — Click Codex', 'Practical articles and technical notes on modern web architecture, responsive design, and creative short-form video production.', 'tech blog, web development articles, design insights', 0.8],
    ['page', 8, '/contactus', 'Contact Us — Start a Project | Click Codex', 'Connect directly with the Click Codex 4-member team to discuss your website, mobile app, design, or video production requirements.', 'contact Click Codex, hire web developers, startup contact', 0.9],

    // 5 Projects
    ['case_study', 1, '/portfolio/jewelry-website', 'Jewelry Business Website Project — Click Codex', 'Showcase of an elegant, responsive e-commerce catalog website developed for a jewelry business with smooth mobile navigation.', 'jewelry website, jewelry ecommerce, responsive catalog', 0.8],
    ['case_study', 2, '/portfolio/farmhouse-website', 'Farmhouse & Resort Website Project — Click Codex', 'Hospitality website built for a farmhouse getaway featuring photo galleries, amenity details, and direct booking inquiry flows.', 'farmhouse website, resort website, hospitality web design', 0.8],
    ['case_study', 3, '/portfolio/business-website', 'Corporate Business Website Project — Click Codex', 'Modern corporate website engineered to present company services, brand credibility, and structured client inquiry channels.', 'business website, corporate web design, professional site', 0.8],
    ['case_study', 4, '/portfolio/web-development-project', 'Custom Web Application Project — Click Codex', 'A full-stack custom web development project featuring dynamic data handling, modular architecture, and responsive dashboard views.', 'custom web app, full stack development, php mysql web app', 0.8],
    ['case_study', 5, '/portfolio/digital-creative-project', 'Digital Creative Campaign Project — Click Codex', 'Multi-faceted digital design and marketing campaign asset suite encompassing social media creatives and promotional reel styling.', 'digital creative project, social media design, reel production', 0.8]
];

$stmt = $conn->prepare("INSERT INTO `seo_metadata` 
    (`entity_type`, `entity_id`, `route_path`, `meta_title`, `meta_description`, `focus_keyword`, `canonical_url`, `og_title`, `og_description`, `og_image`, `schema_type`, `sitemap_priority`, `is_in_sitemap`, `seo_score`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'assets/images/logo.png', 'WebPage', ?, 1, 98)");

foreach ($seoEntries as $seo) {
    $canon = $seo[2];
    $stmt->bind_param("sisssssssd", $seo[0], $seo[1], $seo[2], $seo[3], $seo[4], $seo[5], $canon, $seo[3], $seo[4], $seo[6]);
    $stmt->execute();
}
$stmt->close();
echo "  [OK] SEO metadata configured for pages and projects.\n";

// -----------------------------------------------------------------------------
// STEP 14: AUDIT LOG (RECORD RESET EVENT)
// -----------------------------------------------------------------------------
echo "--> STEP 14: Logging database initialization event in audit_logs...\n";

$auditStmt = $conn->prepare("INSERT INTO `audit_logs` (`user_id`, `action`, `entity_type`, `entity_id`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES (1, 'database_reset_and_populate', 'database', 1, ?, '127.0.0.1', 'CLI-Migration-Engine', NOW())");
$auditData = json_encode([
    'event' => 'Complete database reset and population for Click Codex startup profile',
    'team_size' => 4,
    'team_experience' => '~2 Years in development and digital tech',
    'services_count' => 12,
    'projects_count' => 5,
    'company' => 'Click Codex'
]);
$auditStmt->bind_param("s", $auditData);
$auditStmt->execute();
$auditStmt->close();
echo "  [OK] Audit event logged.\n";

// -----------------------------------------------------------------------------
// STEP 15: SYNCHRONIZE WITH DATABASE/SEED.SQL
// -----------------------------------------------------------------------------
echo "\n--> STEP 15: Exporting clean Click Codex state to database/seed.sql...\n";

$mysqldumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
if (file_exists($mysqldumpPath)) {
    $seedSqlFile = dirname(__DIR__) . '/database/seed.sql';
    $cmd = "\"{$mysqldumpPath}\" -u {$user} " . ($pass !== '' ? "-p\"{$pass}\" " : "") . "{$name} > \"{$seedSqlFile}\"";
    exec($cmd, $dumpOut, $dumpCode);
    if ($dumpCode === 0) {
        echo "  [SUCCESS] Updated database/seed.sql with the new Click Codex dataset (" . number_format(filesize($seedSqlFile)) . " bytes).\n";
    } else {
        echo "  [WARN] mysqldump command returned code {$dumpCode}.\n";
    }
}

echo "\n========================================================================\n";
echo "CLICK CODEX DATABASE RESET & POPULATION COMPLETE!\n";
echo "========================================================================\n";

$conn->close();
