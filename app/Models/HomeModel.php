<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use mysqli;
use Exception;

class HomeModel {
    private mysqli $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Retrieve all public site settings as key-value array
     */
    public function getSettings(): array {
        $settings = [];
        $res = $this->db->query("SELECT setting_key, setting_value FROM site_settings WHERE is_public = 1");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }

        // Defaults fallback
        $defaults = [
            'site_name' => 'ClickCodex',
            'site_tagline' => 'Ideas To Solutions',
            'site_title' => 'ClickCodex | Ideas to Solutions - Premier Web, App & Digital Agency',
            'meta_description' => 'ClickCodex is a premier full-cycle digital agency building high-performance websites, custom web applications, mobile platforms, and result-oriented digital marketing strategies.',
            'whatsapp_number' => '+919876543210',
            'whatsapp_default_message' => 'Hi ClickCodex, I would like to inquire about a project',
            'contact_phone' => '+91 (987) 654-3210',
            'contact_email' => 'hello@clickcodex.com',
            'social_linkedin' => 'https://linkedin.com',
            'social_twitter' => 'https://twitter.com',
            'social_instagram' => 'https://instagram.com',
            'social_youtube' => 'https://youtube.com',
            'address_bangalore' => 'Tech Innovation Park, Whitefield, Bangalore, Karnataka, India - 560066',
            'address_mumbai' => 'WeWork Chromium, Powai, Mumbai, Maharashtra, India - 400076',
            'theme_color' => '#0056d6'
        ];

        return array_merge($defaults, $settings);
    }

    /**
     * Retrieve SEO metadata for home page
     */
    public function getSeoMetadata(): array {
        $stmt = $this->db->prepare("SELECT * FROM seo_metadata WHERE entity_type = 'page' AND (entity_id = 1 OR route_path = '/') LIMIT 1");
        $stmt->execute();
        $res = $stmt->get_result();
        $seo = $res->fetch_assoc();

        if (!$seo) {
            $seo = [
                'meta_title' => 'ClickCodex | Ideas to Solutions - Premier Web, App & Digital Agency',
                'meta_description' => 'ClickCodex is a premier full-cycle digital agency building high-performance websites, custom web applications, mobile platforms, and result-oriented digital marketing strategies.',
                'meta_keywords' => 'ClickCodex, web development company India, mobile app development, UI UX design, digital marketing agency, e-commerce development, custom software',
                'canonical_url' => 'https://clickcodex.com/index.html',
                'og_type' => 'website',
                'og_title' => 'ClickCodex | Ideas to Solutions - Premier Web, App & Digital Agency',
                'og_description' => 'ClickCodex is a premier full-cycle digital agency building high-performance websites, custom web applications, mobile platforms, and result-oriented digital marketing strategies.',
                'og_image' => 'https://clickcodex.com/logo.png',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'ClickCodex | Ideas to Solutions - Premier Web, App & Digital Agency',
                'twitter_description' => 'ClickCodex is a premier full-cycle digital agency building high-performance websites, custom web applications, mobile platforms, and result-oriented digital marketing strategies.',
                'twitter_image' => 'https://clickcodex.com/logo.png',
                'schema_type' => 'WebPage',
                'schema_json' => null
            ];
        }

        return $seo;
    }

    /**
     * Retrieve all page sections for page_key = 'home'
     */
    public function getPageSections(): array {
        $sections = [];
        $stmt = $this->db->prepare("SELECT ps.* FROM page_sections ps JOIN pages p ON ps.page_id = p.id WHERE p.page_key = 'home' AND ps.is_active = 1 ORDER BY ps.order_num ASC");
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            if (!empty($row['settings_json'])) {
                $row['settings'] = json_decode($row['settings_json'], true);
            } else {
                $row['settings'] = [];
            }
            $sections[$row['section_key']] = $row;
        }
        return $sections;
    }

    /**
     * Retrieve trusted partner brands
     */
    public function getTrustedBrands(): array {
        $brands = [];
        $res = $this->db->query("SELECT brand_name, badge_text, logo_image, website_url FROM trusted_brands WHERE is_active = 1 ORDER BY order_num ASC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $brands[] = $row;
            }
        }
        return $brands;
    }

    /**
     * Retrieve 6 core services
     */
    public function getServices(): array {
        $services = [];
        $res = $this->db->query("SELECT s.*, c.name as category_name FROM services s LEFT JOIN service_categories c ON s.category_id = c.id WHERE s.is_active = 1 ORDER BY s.order_num ASC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $row['tech_stack'] = !empty($row['tech_stack']) ? json_decode($row['tech_stack'], true) : [];
                $row['key_deliverables'] = !empty($row['key_deliverables']) ? json_decode($row['key_deliverables'], true) : [];
                $row['performance_kpis'] = !empty($row['performance_kpis']) ? json_decode($row['performance_kpis'], true) : [];
                $services[] = $row;
            }
        }
        return $services;
    }

    /**
     * Retrieve 4 featured case studies for homepage
     */
    public function getFeaturedCaseStudies(): array {
        $caseStudies = [];
        $res = $this->db->query("SELECT * FROM case_studies WHERE is_active = 1 AND is_featured = 1 ORDER BY order_num ASC LIMIT 4");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $row['key_metrics'] = !empty($row['key_metrics']) ? json_decode($row['key_metrics'], true) : [];
                $row['technologies'] = !empty($row['technologies']) ? json_decode($row['technologies'], true) : [];
                $caseStudies[] = $row;
            }
        }
        return $caseStudies;
    }

    /**
     * Retrieve 4 company core values
     */
    public function getCompanyValues(): array {
        $values = [];
        $res = $this->db->query("SELECT * FROM company_values WHERE is_active = 1 ORDER BY order_num ASC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $values[] = $row;
            }
        }
        return $values;
    }

    /**
     * Retrieve testimonials
     */
    public function getTestimonials(): array {
        $testimonials = [];
        $res = $this->db->query("SELECT * FROM testimonials WHERE is_active = 1 AND is_featured_home = 1 ORDER BY order_num ASC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $testimonials[] = $row;
            }
        }
        return $testimonials;
    }

    /**
     * Retrieve latest technical blog insights
     */
    public function getLatestBlogPosts(int $limit = 3): array {
        $posts = [];
        $stmt = $this->db->prepare("SELECT p.id, p.title, p.slug, p.excerpt, p.reading_time_minutes, p.published_at, p.featured_image,
                                           c.name as category_name, c.badge_color, c.badge_bg,
                                           a.name as author_name, a.role_title as author_role, a.initials as author_initials, a.avatar_image as author_avatar
                                    FROM blog_posts p
                                    JOIN blog_categories c ON p.category_id = c.id
                                    JOIN blog_authors a ON p.author_id = a.id
                                    WHERE p.is_published = 1
                                    ORDER BY p.published_at DESC
                                    LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $posts[] = $row;
        }
        return $posts;
    }

    /**
     * 5-Step Process Execution Blueprint
     */
    public function getBlueprintSteps(): array {
        return [
            [
                'step_id' => 'step1',
                'number' => '01',
                'title' => 'Discovery & High-Level Architecture',
                'desc' => 'We define the technical roadmap, core features, database schema, and conversion funnels. You receive an accurate, fixed sprint scope with no hidden costs.',
                'deliverable' => 'Architecture Blueprint & Wireframes',
                'timeline' => 'Week 1',
                'tags' => ['SRS Document', 'DB Schema', 'Figma Prototype']
            ],
            [
                'step_id' => 'step2',
                'number' => '02',
                'title' => 'UI/UX Craft & Interactive Prototyping',
                'desc' => 'Our design team crafts human-centered interfaces tailored to your target audience, balancing striking visual identity with frictionless user flows.',
                'deliverable' => 'Full Design System & Prototype',
                'timeline' => 'Week 1 – 2',
                'tags' => ['Design System', 'Micro-interactions', 'User Testing']
            ],
            [
                'step_id' => 'step3',
                'number' => '03',
                'title' => 'Agile Engineering & High-Cadence Sprints',
                'desc' => 'We engineer clean, modular, and performant code in 2-week agile sprints. You receive private staging access and continuous progress updates.',
                'deliverable' => 'Functional Staging Environment',
                'timeline' => 'Week 2 – 4',
                'tags' => ['Git CI/CD', 'Daily Standups', 'Type-Safe Code']
            ],
            [
                'step_id' => 'step4',
                'number' => '04',
                'title' => 'Hardening, Security & Load Testing',
                'desc' => 'Before production, our QA engineers execute comprehensive security audits, cross-device testing, and stress tests to ensure flawless performance under peak load.',
                'deliverable' => '99+ PageSpeed & Security Audit',
                'timeline' => 'Week 4 – 5',
                'tags' => ['OWASP Hardening', 'Core Web Vitals', 'Load Testing']
            ],
            [
                'step_id' => 'step5',
                'number' => '05',
                'title' => 'Zero-Downtime Deployment & Handover',
                'desc' => 'We deploy to high-availability cloud infrastructure with automated backups and monitoring. You receive 100% intellectual property, code repositories, and documentation.',
                'deliverable' => 'Production Launch & Full IP Transfer',
                'timeline' => 'Launch Day',
                'tags' => ['Full IP Handover', 'Cloud Deployment', '30-Day Warranty']
            ]
        ];
    }
}
