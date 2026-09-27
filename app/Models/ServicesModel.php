<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use mysqli;

class ServicesModel {
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
     * Retrieve SEO metadata for Services page
     */
    public function getSeoMetadata(): array {
        $stmt = $this->db->prepare("SELECT * FROM seo_metadata WHERE (entity_type = 'page' AND entity_id = 3) OR route_path IN ('/services', 'services') LIMIT 1");
        $stmt->execute();
        $res = $stmt->get_result();
        $seo = $res->fetch_assoc();

        if (!$seo) {
            $seo = [
                'meta_title' => 'End-to-End Digital Services & Enterprise Web Engineering | ClickCodex',
                'meta_description' => 'Explore ClickCodex flagship services: Custom Next.js web applications, Flutter mobile apps, high-converting UI/UX design systems, headless e-commerce, and dedicated developer pods.',
                'meta_keywords' => 'custom web development, mobile app development, UI UX design systems, headless e-commerce, dedicated developer pods, AI integration',
                'canonical_url' => 'https://clickcodex.com/services',
                'og_type' => 'website',
                'og_title' => 'End-to-End Digital Services & Enterprise Web Engineering | ClickCodex',
                'og_description' => 'High-performance web apps, cross-platform mobile apps, conversion-focused UI/UX, and cloud scale solutions.',
                'og_image' => 'https://clickcodex.com/logo.png',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'End-to-End Digital Services | ClickCodex',
                'twitter_description' => 'Explore ClickCodex full suite of digital engineering, design systems, and dedicated talent solutions.',
                'twitter_image' => 'https://clickcodex.com/logo.png',
                'schema_type' => 'Service',
                'schema_json' => null,
                'robots_index' => 1,
                'robots_follow' => 1
            ];
        }

        return $seo;
    }

    /**
     * Retrieve page record for 'services'
     */
    public function getPageData(): array {
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE page_key = 'services' LIMIT 1");
        $stmt->execute();
        $res = $stmt->get_result();
        $page = $res->fetch_assoc();

        return $page ?: [
            'title' => 'Our Services',
            'headline' => 'What We Build',
            'subheadline' => 'Every deliverable is crafted in-house by senior engineers and product designers with zero outsourcing compromises.'
        ];
    }

    /**
     * Retrieve all page sections for page_key = 'services'
     */
    public function getPageSections(): array {
        $sections = [];
        $stmt = $this->db->prepare("SELECT ps.* FROM page_sections ps JOIN pages p ON ps.page_id = p.id WHERE p.page_key = 'services' AND ps.is_active = 1 ORDER BY ps.order_num ASC");
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            if (!empty($row['settings_json'])) {
                $row['settings'] = json_decode($row['settings_json'], true) ?: [];
            } else {
                $row['settings'] = [];
            }
            $sections[$row['section_key']] = $row;
        }
        return $sections;
    }

    /**
     * Retrieve 6 flagship capabilities from services table
     */
    public function getAllServices(): array {
        $services = [];
        $res = $this->db->query("SELECT s.*, c.name as category_name 
                                 FROM services s 
                                 LEFT JOIN service_categories c ON s.category_id = c.id 
                                 WHERE s.is_active = 1 
                                 ORDER BY s.order_num ASC");
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $row['tech_stack_arr'] = !empty($row['tech_stack']) ? (json_decode($row['tech_stack'], true) ?: []) : [];
                $row['key_deliverables_arr'] = !empty($row['key_deliverables']) ? (json_decode($row['key_deliverables'], true) ?: []) : [];
                $row['performance_kpis_arr'] = !empty($row['performance_kpis']) ? (json_decode($row['performance_kpis'], true) ?: []) : [];
                $services[] = $row;
            }
        }
        return $services;
    }

    /**
     * 3D Card Deck cards data for the hero
     */
    public function getCardDeck(): array {
        return [
            [
                'tag' => 'WEB DEVELOPMENT',
                'title' => 'Websites & Web Applications',
                'description' => 'Responsive corporate websites, portfolio portals, and custom full-stack web applications with clean code and zero vendor lock-in.',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=800&auto=format&fit=crop',
                'link_text' => 'Explore Web Capabilities'
            ],
            [
                'tag' => 'MOBILE APPS',
                'title' => 'Cross-Platform Mobile Apps',
                'description' => 'Cross-platform mobile applications for iOS and Android with unified logic, modern UX, and clean API integration.',
                'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=800&auto=format&fit=crop',
                'link_text' => 'Explore Mobile Apps'
            ],
            [
                'tag' => 'DESIGN & MEDIA',
                'title' => 'UI/UX, Branding & Video Reels',
                'description' => 'Intuitive Figma interfaces, unique logo designs, social media graphics, and professional short-form video reel production.',
                'image' => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?q=80&w=800&auto=format&fit=crop',
                'link_text' => 'Explore Creative Studio'
            ]
        ];
    }

    /**
     * 4-Tier Growth & Conversion Funnel data
     */
    public function getGrowthFunnel(): array {
        return [
            'tier1' => [
                'tag' => 'FUNNEL STAGE 01',
                'tab_num' => '01',
                'tab_title' => 'Clean Web & Local SEO',
                'tab_desc' => 'Semantic HTML, mobile responsiveness & search visibility',
                'tab_stat' => 'Clean UI',
                'title' => 'Search Visibility & Clean Foundations',
                'desc' => 'We build websites with structured semantic HTML5, clear meta tags, and mobile-friendly layouts that ensure your business looks professional and gets found by potential clients.',
                'm1' => 'Mobile', 'l1' => 'First Responsive Design',
                'm2' => 'Clean', 'l2' => 'Semantic HTML Code',
                'm3' => 'Fast', 'l3' => 'Optimized Assets'
            ],
            'tier2' => [
                'tag' => 'FUNNEL STAGE 02',
                'tab_num' => '02',
                'tab_title' => 'Intuitive User Experience',
                'tab_desc' => 'Clear visual hierarchy & frictionless navigation',
                'tab_stat' => 'Modern',
                'title' => 'Intuitive Design & Visual Clarity',
                'desc' => 'Once visitors arrive, clear design and structure make all the difference. We craft intuitive navigation, balanced typography, and tasteful aesthetics to hold visitor attention.',
                'm1' => '100%', 'l1' => 'Responsive Layout',
                'm2' => 'Modern', 'l2' => 'UI/UX Principles',
                'm3' => 'Smooth', 'l3' => 'Micro-Interactions'
            ],
            'tier3' => [
                'tag' => 'FUNNEL STAGE 03',
                'tab_num' => '03',
                'tab_title' => 'Direct Inquiry & Conversion',
                'tab_desc' => 'Clear call-to-actions, WhatsApp & contact forms',
                'tab_stat' => 'Direct',
                'title' => 'Inquiry Generation & Actionable CTAs',
                'desc' => 'We eliminate barriers to customer contact. Easy-to-use inquiry forms, direct WhatsApp chat links, and prominent call buttons help convert visits into real conversations.',
                'm1' => 'Direct', 'l1' => 'WhatsApp Connect',
                'm2' => 'Simple', 'l2' => 'Inquiry Forms',
                'm3' => 'Clear', 'l3' => 'Call-to-Action Flow'
            ],
            'tier4' => [
                'tag' => 'FUNNEL STAGE 04',
                'tab_num' => '04',
                'tab_title' => 'Long-Term Support & Evolution',
                'tab_desc' => 'Milestone handovers, updates & direct support',
                'tab_stat' => '100% IP',
                'title' => 'Collaborative Support & Long-Term Partnership',
                'desc' => 'We hand over full source code ownership upon project completion and stay available for ongoing feature enhancements, site updates, and creative media sprints.',
                'm1' => '100%', 'l1' => 'Code & Asset Ownership',
                'm2' => 'Agile', 'l2' => 'Ongoing Sprints',
                'm3' => 'Direct', 'l3' => 'Team Support'
            ]
        ];
    }

    /**
     * 4-Phase Delivery Dossier data
     */
    public function getDeliveryDossier(): array {
        return [
            'phase1' => [
                'label' => 'PHASE 01',
                'tab_title' => 'Blueprint & Architecture',
                'title' => 'Phase 01: Architectural Blueprint & Scope Mapping',
                'desc' => 'Before writing a line of code, our systems architects interview your product team, evaluate API integrations, map database schemas, and create high-fidelity user journeys. You receive an unshakeable roadmap.',
                'badge' => '⏱ Typical Timeline: Week 1',
                'points' => [
                    'Comprehensive API & Database Architecture Document',
                    'Interactive Figma Wireframes & User Journey Flows',
                    'Fixed Sprint Milestones & Transparent Deliverable Deadlines'
                ]
            ],
            'phase2' => [
                'label' => 'PHASE 02',
                'tab_title' => 'Rapid Agile Sprints',
                'title' => 'Phase 02: Rapid Agile Sprints & Daily Staging',
                'desc' => 'We execute in two-week agile sprint cycles. You get private access to our Git repositories, daily standup summaries on Slack, and live staging URLs pushed every 24 hours.',
                'badge' => '⏱ Typical Timeline: Weeks 2 to 6',
                'points' => [
                    'Clean, Modular Full-Stack Codebase Commits',
                    'Daily Automated CI/CD Staging Builds',
                    'Bi-Weekly Interactive Demo & Stakeholder Review'
                ]
            ],
            'phase3' => [
                'label' => 'PHASE 03',
                'tab_title' => 'QA, Security & Stress Test',
                'title' => 'Phase 03: Security Hardening, QA & Stress Testing',
                'desc' => 'We subject the build to aggressive automated unit tests, OWASP security scans, and simulate synthetic traffic surges to ensure uncompromised speed under real-world load.',
                'badge' => '⏱ Typical Timeline: Week 7',
                'points' => [
                    'OWASP Top-10 Vulnerability Audit',
                    'Synthetic Load Testing up to 100k Simultaneous Users',
                    'Cross-Device & Cross-Browser Pixel Compatibility Check'
                ]
            ],
            'phase4' => [
                'label' => 'PHASE 04',
                'tab_title' => 'Zero-Downtime Launch',
                'title' => 'Phase 04: Zero-Downtime Launch & Scale Operations',
                'desc' => 'We manage DNS cutovers, CDN cache pre-warming, and live database migrations with zero downtime. Post-launch, our team remains actively embedded to monitor uptime and user feedback.',
                'badge' => '⏱ Typical Timeline: Week 8 & Ongoing',
                'points' => [
                    'Zero-Downtime Blue/Green Deployment Cutover',
                    'Real-Time Telemetry & Error Tracking Integration',
                    '24/7 Priority Emergency Bugfix SLA'
                ]
            ]
        ];
    }

    /**
     * Retrieve single service by slug (or fallback to first service)
     */
    public function getServiceBySlug(string $slug = ''): ?array {
        $slug = trim($slug);
        if (!empty($slug)) {
            $stmt = $this->db->prepare("SELECT s.*, c.name as category_name, c.slug as category_slug
                                         FROM services s 
                                         LEFT JOIN service_categories c ON s.category_id = c.id 
                                         WHERE s.slug = ? AND s.is_active = 1 LIMIT 1");
            if ($stmt) {
                $stmt->bind_param('s', $slug);
                $stmt->execute();
                $res = $stmt->get_result();
                $service = $res->fetch_assoc();
                if ($service) {
                    return $this->formatServiceData($service);
                }
            }
        }

        // Fallback to first active service
        $res = $this->db->query("SELECT s.*, c.name as category_name, c.slug as category_slug
                                 FROM services s 
                                 LEFT JOIN service_categories c ON s.category_id = c.id 
                                 WHERE s.is_active = 1 
                                 ORDER BY s.order_num ASC LIMIT 1");
        if ($res && $row = $res->fetch_assoc()) {
            return $this->formatServiceData($row);
        }

        return null;
    }

    /**
     * Format and expand service JSON arrays
     */
    private function formatServiceData(array $service): array {
        $service['tech_stack_arr'] = !empty($service['tech_stack']) ? (json_decode($service['tech_stack'], true) ?: []) : [];
        $service['key_deliverables_arr'] = !empty($service['key_deliverables']) ? (json_decode($service['key_deliverables'], true) ?: []) : [];
        $service['performance_kpis_arr'] = !empty($service['performance_kpis']) ? (json_decode($service['performance_kpis'], true) ?: []) : [];
        return $service;
    }

    /**
     * Retrieve FAQs specific to this service, falling back to general FAQs
     */
    public function getServiceFaqs(int $serviceId): array {
        $faqs = [];
        $stmt = $this->db->prepare("SELECT * FROM service_faqs WHERE service_id = ? AND is_active = 1 ORDER BY order_num ASC");
        if ($stmt) {
            $stmt->bind_param('i', $serviceId);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $faqs[] = $row;
            }
        }

        if (empty($faqs)) {
            $res = $this->db->query("SELECT question, answer FROM faqs WHERE category IN ('services', 'general') AND is_active = 1 ORDER BY order_num ASC LIMIT 4");
            if ($res) {
                while ($row = $res->fetch_assoc()) {
                    $faqs[] = $row;
                }
            }
        }

        return $faqs;
    }

    /**
     * Retrieve 4-phase agile engineering delivery dossier from database
     */
    public function getDossierSteps(): array {
        $steps = [];
        $res = $this->db->query("SELECT * FROM service_dossier_steps WHERE is_active = 1 ORDER BY order_num ASC");
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $row['checkpoints_arr'] = !empty($row['checkpoints']) ? (json_decode($row['checkpoints'], true) ?: []) : [];
                $steps[] = $row;
            }
            return $steps;
        }

        // Fallback to model defaults if table empty
        $defaults = $this->getDeliveryDossier();
        $formatted = [];
        foreach ($defaults as $item) {
            $formatted[] = [
                'phase_title' => $item['title'],
                'description' => $item['desc'],
                'typical_timeline' => str_replace('⏱ Typical Timeline: ', '', $item['badge']),
                'checkpoints_arr' => $item['points']
            ];
        }
        return $formatted;
    }

    /**
     * Retrieve related case studies for the service category
     */
    public function getRelatedCaseStudies(int $categoryId, int $limit = 2): array {
        $cases = [];
        $stmt = $this->db->prepare("SELECT * FROM case_studies WHERE category_id = ? AND is_active = 1 ORDER BY is_featured DESC, order_num ASC LIMIT ?");
        if ($stmt) {
            $stmt->bind_param('ii', $categoryId, $limit);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $row['technologies_arr'] = !empty($row['technologies']) ? (json_decode($row['technologies'], true) ?: []) : [];
                $cases[] = $row;
            }
        }

        if (count($cases) < $limit) {
            $needed = $limit - count($cases);
            $res = $this->db->query("SELECT * FROM case_studies WHERE is_active = 1 ORDER BY is_featured DESC, order_num ASC LIMIT $needed");
            if ($res) {
                while ($row = $res->fetch_assoc()) {
                    $row['technologies_arr'] = !empty($row['technologies']) ? (json_decode($row['technologies'], true) ?: []) : [];
                    $cases[] = $row;
                }
            }
        }

        return $cases;
    }

    /**
     * Retrieve lightweight navigation list of all 6 services
     */
    public function getAllServicesNav(): array {
        $list = [];
        $res = $this->db->query("SELECT id, slug, title, badge_label, starting_price_inr, starting_price_usd, typical_timeline 
                                 FROM services 
                                 WHERE is_active = 1 
                                 ORDER BY order_num ASC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $list[] = $row;
            }
        }
        return $list;
    }

    /**
     * Retrieve SEO metadata for a single service
     */
    public function getServiceSeo(array $service): array {
        $routePath = '/services/' . $service['slug'];
        $stmt = $this->db->prepare("SELECT * FROM seo_metadata WHERE route_path = ? OR (entity_type = 'service' AND entity_id = ?) LIMIT 1");
        if ($stmt) {
            $stmt->bind_param('si', $routePath, $service['id']);
            $stmt->execute();
            $res = $stmt->get_result();
            $seo = $res->fetch_assoc();
            if ($seo) {
                return $seo;
            }
        }

        $keywords = !empty($service['tech_stack_arr']) ? implode(', ', $service['tech_stack_arr']) : 'web, app, design';
        return [
            'meta_title' => $service['title'] . ' | Technical Capabilities & Sprints - ClickCodex',
            'meta_description' => substr(strip_tags((string)$service['short_description']), 0, 160),
            'meta_keywords' => $service['title'] . ', ' . $keywords . ', ClickCodex services',
            'canonical_url' => (defined('BASE_URL') ? BASE_URL : '') . '/services/' . $service['slug'],
            'og_title' => $service['title'] . ' | ClickCodex Engineering',
            'og_description' => $service['short_description'],
            'og_image' => (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/images/logo.png',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $service['title'] . ' | ClickCodex Engineering',
            'twitter_description' => $service['short_description'],
            'twitter_image' => (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/images/logo.png',
            'robots_index' => 1,
            'robots_follow' => 1
        ];
    }
}
