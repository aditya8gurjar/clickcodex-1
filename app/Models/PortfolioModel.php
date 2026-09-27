<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use mysqli;

class PortfolioModel {
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

        $defaults = [
            'site_name' => 'ClickCodex',
            'site_tagline' => 'Ideas To Solutions',
            'site_title' => 'ClickCodex | Ideas to Solutions - Premier Web, App & Digital Agency',
            'meta_description' => 'ClickCodex is a premier full-cycle digital agency building high-performance websites, custom web applications, mobile platforms, and result-oriented digital marketing strategies.',
            'whatsapp_number' => '+919876543210',
            'whatsapp_default_message' => "Hi ClickCodex, I'd like to discuss a new project",
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
     * Retrieve SEO metadata for Portfolio page
     */
    public function getSeoMetadata(): array {
        $stmt = $this->db->prepare("SELECT * FROM seo_metadata WHERE (entity_type = 'page' AND entity_id = 5) OR route_path IN ('/portfolio', 'portfolio') LIMIT 1");
        if ($stmt) {
            $stmt->execute();
            $res = $stmt->get_result();
            $seo = $res->fetch_assoc();
            if ($seo) {
                return $seo;
            }
        }

        return [
            'meta_title' => 'Client Case Studies & Technical Deployments | ClickCodex',
            'meta_description' => 'Explore ClickCodex flagship engineering case studies: High-concurrency fintech portals, headless Shopify Plus architectures, Flutter telehealth apps, and real-time 3D WebGL studios.',
            'meta_keywords' => 'client case studies, web development portfolio, mobile app showcase, fintech architecture, headless ecommerce case study, ClickCodex work',
            'canonical_url' => 'https://clickcodex.com/portfolio',
            'og_type' => 'website',
            'og_title' => 'Client Case Studies & Technical Deployments | ClickCodex',
            'og_description' => 'Explore proven engineering triumphs, commercial metrics, and turnkey systems shipped for high-growth enterprises.',
            'og_image' => 'https://clickcodex.com/logo.png',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'Client Case Studies & Technical Deployments | ClickCodex',
            'twitter_description' => 'Discover how ClickCodex builds high-performance web systems and market-leading mobile applications.',
            'twitter_image' => 'https://clickcodex.com/logo.png',
            'schema_type' => 'CollectionPage',
            'schema_json' => null,
            'robots_index' => 1,
            'robots_follow' => 1
        ];
    }

    /**
     * Retrieve page record for 'portfolio' (id = 5)
     */
    public function getPageData(): array {
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE id = 5 OR page_key = 'portfolio' LIMIT 1");
        if ($stmt) {
            $stmt->execute();
            $res = $stmt->get_result();
            $page = $res->fetch_assoc();
            if ($page) {
                return $page;
            }
        }

        return [
            'title' => 'Portfolio & Results',
            'slug' => 'portfolio',
            'headline' => 'Case Studies & Deployments',
            'subheadline' => 'Every product engineered by ClickCodex is crafted with precision code, strict security compliance, and measured business ROI.'
        ];
    }

    /**
     * Retrieve all page sections for page_id = 5
     */
    public function getPageSections(): array {
        $sections = [];
        $stmt = $this->db->prepare("SELECT * FROM page_sections WHERE page_id = 5 AND is_active = 1 ORDER BY order_num ASC");
        if ($stmt) {
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $sections[$row['section_key']] = $row;
            }
        }

        return $sections;
    }

    /**
     * Retrieve all active portfolio categories
     */
    public function getCategories(): array {
        $categories = [];
        $res = $this->db->query("SELECT * FROM portfolio_categories WHERE is_active = 1 ORDER BY order_num ASC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $categories[] = $row;
            }
        }

        return $categories;
    }

    /**
     * Retrieve all active case studies with category metadata and decoded JSON fields
     */
    public function getCaseStudies(?string $categorySlug = null): array {
        $caseStudies = [];
        $sql = "SELECT cs.*, pc.slug AS category_slug, pc.name AS category_name 
                FROM case_studies cs 
                LEFT JOIN portfolio_categories pc ON cs.category_id = pc.id 
                WHERE cs.is_active = 1";

        if ($categorySlug !== null && $categorySlug !== 'all') {
            $sql .= " AND pc.slug = '" . $this->db->real_escape_string($categorySlug) . "'";
        }

        $sql .= " ORDER BY cs.order_num ASC";

        $res = $this->db->query($sql);
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                // Decode key_metrics JSON
                if (!empty($row['key_metrics'])) {
                    $decodedMetrics = json_decode($row['key_metrics'], true);
                    $row['key_metrics_array'] = is_array($decodedMetrics) ? $decodedMetrics : [];
                } else {
                    $row['key_metrics_array'] = [];
                }

                // Decode technologies JSON
                if (!empty($row['technologies'])) {
                    $decodedTech = json_decode($row['technologies'], true);
                    $row['technologies_array'] = is_array($decodedTech) ? $decodedTech : [];
                } else {
                    $row['technologies_array'] = [];
                }

                $caseStudies[] = $row;
            }
        }

        return $caseStudies;
    }

    /**
     * Retrieve active testimonials
     */
    public function getTestimonials(): array {
        $testimonials = [];
        $res = $this->db->query("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY order_num ASC LIMIT 6");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $testimonials[] = $row;
            }
        }

        if (empty($testimonials)) {
            $testimonials = [
                [
                    'client_name' => 'Rohan Gupta',
                    'client_position' => 'CTO',
                    'client_company' => 'FinScale Global',
                    'client_location' => 'Singapore',
                    'testimonial_quote' => 'ClickCodex re-architected our core banking portal in 8 weeks flat. Their engineers operate like an elite SEAL team—zero fluff, pure clean modular code.',
                    'rating_stars' => 5.0
                ],
                [
                    'client_name' => 'Elena Meyer',
                    'client_position' => 'Head of Digital',
                    'client_company' => 'HyperCart',
                    'client_location' => 'London',
                    'testimonial_quote' => "Our Shopify store's load time went from 3.8s to 0.4s. Our Black Friday revenue exploded by 68% without a single server hiccup. Outstanding craftsmanship.",
                    'rating_stars' => 5.0
                ],
                [
                    'client_name' => 'Dr. Vikram Rao',
                    'client_position' => 'Founder',
                    'client_company' => 'PulseHealth',
                    'client_location' => 'Bangalore',
                    'testimonial_quote' => 'Finding mobile engineers who actually understand WebRTC and HIPAA compliance is nearly impossible. ClickCodex delivered an App Store masterpiece.',
                    'rating_stars' => 5.0
                ]
            ];
        }

        return $testimonials;
    }
}
