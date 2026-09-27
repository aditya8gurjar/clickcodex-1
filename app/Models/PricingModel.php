<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use mysqli;

class PricingModel {
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
     * Retrieve SEO metadata for Pricing page
     */
    public function getSeoMetadata(): array {
        $stmt = $this->db->prepare("SELECT * FROM seo_metadata WHERE (entity_type = 'page' AND entity_id = 6) OR route_path IN ('/pricing', 'pricing') LIMIT 1");
        if ($stmt) {
            $stmt->execute();
            $res = $stmt->get_result();
            $seo = $res->fetch_assoc();
            if ($seo) {
                return $seo;
            }
        }

        return [
            'meta_title' => 'Transparent Pricing & Engagement Models | ClickCodex',
            'meta_description' => 'Explore ClickCodex transparent pricing packages: Starter MVP Sprint, Growth Authority Platform, and Dedicated Engineering Pods. Fixed pricing, zero hidden fees, and 100% IP ownership.',
            'meta_keywords' => 'web development cost, website pricing, software development sprint cost, hire dedicated developers India, fixed price web app',
            'canonical_url' => 'https://clickcodex.com/pricing',
            'og_type' => 'website',
            'og_title' => 'Transparent Pricing & Engagement Models | ClickCodex',
            'og_description' => 'Fixed sprint pricing, clear milestones, zero hidden costs, and 100% source code ownership.',
            'og_image' => 'https://clickcodex.com/logo.png',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'Transparent Pricing & Engagement Models | ClickCodex',
            'twitter_description' => 'Clear and predictable investment tiers for startups and enterprises.',
            'twitter_image' => 'https://clickcodex.com/logo.png',
            'schema_type' => 'PriceSpecification',
            'schema_json' => null,
            'robots_index' => 1,
            'robots_follow' => 1
        ];
    }

    /**
     * Retrieve page record for 'pricing' (id = 6)
     */
    public function getPageData(): array {
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE id = 6 OR page_key = 'pricing' LIMIT 1");
        if ($stmt) {
            $stmt->execute();
            $res = $stmt->get_result();
            $page = $res->fetch_assoc();
            if ($page) {
                return $page;
            }
        }

        return [
            'title' => 'Pricing & Models',
            'slug' => 'pricing',
            'headline' => 'Transparent Engagement Models',
            'subheadline' => 'No hidden fees. No junior handoffs. Every sprint is backed by senior engineers, 100% source code ownership, and guaranteed launch milestones.'
        ];
    }

    /**
     * Retrieve all page sections for page_id = 6
     */
    public function getPageSections(): array {
        $sections = [];
        $stmt = $this->db->prepare("SELECT * FROM page_sections WHERE page_id = 6 AND is_active = 1 ORDER BY order_num ASC");
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
     * Retrieve all active pricing plans with their respective features
     */
    public function getPlansWithFeatures(): array {
        $plans = [];
        $res = $this->db->query("SELECT * FROM pricing_plans WHERE is_active = 1 ORDER BY order_num ASC");
        if ($res && $res->num_rows > 0) {
            while ($plan = $res->fetch_assoc()) {
                $planId = (int)$plan['id'];
                $fStmt = $this->db->prepare("SELECT * FROM pricing_features WHERE plan_id = ? ORDER BY order_num ASC");
                $fStmt->bind_param("i", $planId);
                $fStmt->execute();
                $fRes = $fStmt->get_result();
                $features = [];
                while ($f = $fRes->fetch_assoc()) {
                    $features[] = $f;
                }
                $plan['features'] = $features;
                $plans[] = $plan;
            }
        }

        return $plans;
    }

    /**
     * Retrieve all guaranteed inclusions
     */
    public function getInclusions(): array {
        $inclusions = [];
        $res = $this->db->query("SELECT * FROM pricing_inclusions WHERE is_active = 1 ORDER BY order_num ASC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $inclusions[] = $row;
            }
        }

        return $inclusions;
    }

    /**
     * Retrieve pricing FAQs with defaults
     */
    public function getFaqs(): array {
        $faqs = [];
        $res = $this->db->query("SELECT * FROM faqs WHERE category = 'pricing' AND is_active = 1 ORDER BY order_num ASC");
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $faqs[] = $row;
            }
        }

        if (empty($faqs)) {
            $faqs = [
                [
                    'question' => 'How are project milestone payments structured?',
                    'answer' => 'For fixed-scope sprint tiers, billing is structured around verified deliverables: 40% initial commitment upon design and architecture signoff, 30% upon staging build deployment, and 30% final balance upon production release and code ownership transfer.'
                ],
                [
                    'question' => 'Are there any hidden costs, licensing fees, or hosting surcharges?',
                    'answer' => 'None whatsoever. All software architectures are built on open-source, vendor-neutral frameworks (Next.js, Node.js, PostgreSQL). Cloud server costs (AWS, GCP, Vercel) are billed directly through your own cloud account so you always maintain complete financial transparency.'
                ],
                [
                    'question' => 'What payment methods and currencies do you support?',
                    'answer' => 'We accept direct bank wire transfers (NEFT/RTGS/IMPS), UPI, and corporate cards via Razorpay for Indian clients. For international clients across the US, UK, Europe, and Middle East, we accept SWIFT wires and Stripe multi-currency card payments in USD, EUR, and GBP.'
                ],
                [
                    'question' => 'Can we change scope or add features midway through a sprint?',
                    'answer' => 'Yes. We operate agile two-week sprints. If you need new feature additions during an ongoing sprint, our tech lead provides a clear estimate and adjustments can either be swapped with existing items or scheduled for an immediate follow-up sprint.'
                ]
            ];
        }

        return $faqs;
    }
}
