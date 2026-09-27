<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use mysqli;

class AboutModel {
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
     * Retrieve SEO metadata for About Us page
     */
    public function getSeoMetadata(): array {
        $stmt = $this->db->prepare("SELECT * FROM seo_metadata WHERE (entity_type = 'page' AND entity_id = 2) OR route_path IN ('/aboutus', 'aboutus') LIMIT 1");
        $stmt->execute();
        $res = $stmt->get_result();
        $seo = $res->fetch_assoc();

        if (!$seo) {
            $seo = [
                'meta_title' => 'About ClickCodex | Architects of Digital Dominance - Who We Are',
                'meta_description' => 'Discover the story, vision, team, and engineering ethos behind ClickCodex. We bridge technical mastery and commercial growth to build high-performance digital products.',
                'meta_keywords' => 'About ClickCodex, digital agency India, software engineering team, web development company Bangalore Mumbai, tech visionaries, UI UX studio',
                'canonical_url' => 'https://clickcodex.com/aboutus',
                'og_type' => 'website',
                'og_title' => 'About ClickCodex | Architects of Digital Dominance - Who We Are',
                'og_description' => 'Discover the story, vision, team, and engineering ethos behind ClickCodex. We bridge technical mastery and commercial growth to build high-performance digital products.',
                'og_image' => 'https://clickcodex.com/logo.png',
                'twitter_card' => 'summary_large_image',
                'twitter_title' => 'About ClickCodex | Architects of Digital Dominance - Who We Are',
                'twitter_description' => 'Discover the story, vision, team, and engineering ethos behind ClickCodex. We bridge technical mastery and commercial growth to build high-performance digital products.',
                'twitter_image' => 'https://clickcodex.com/logo.png',
                'schema_type' => 'AboutPage',
                'schema_json' => null,
                'robots_index' => 1,
                'robots_follow' => 1
            ];
        }

        return $seo;
    }

    /**
     * Retrieve page record for 'about_us'
     */
    public function getPageData(): array {
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE page_key = 'about_us' LIMIT 1");
        $stmt->execute();
        $res = $stmt->get_result();
        $page = $res->fetch_assoc();

        return $page ?: [
            'title' => 'About ClickCodex',
            'headline' => "We Don't Just Write Code. We Engineer Dominance.",
            'subheadline' => 'Born from a relentless pursuit of technical elegance and commercial velocity, ClickCodex transforms ambitious business ideas into high-performance web platforms, scalable mobile apps, and dominant digital ecosystems.',
            'banner_image' => null
        ];
    }

    /**
     * Retrieve all page sections for page_key = 'about_us'
     */
    public function getPageSections(): array {
        $sections = [];
        $stmt = $this->db->prepare("SELECT ps.* FROM page_sections ps JOIN pages p ON ps.page_id = p.id WHERE p.page_key = 'about_us' AND ps.is_active = 1 ORDER BY ps.order_num ASC");
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
     * Retrieve company milestones for timeline
     */
    public function getMilestones(): array {
        $milestones = [];
        $res = $this->db->query("SELECT * FROM company_milestones WHERE is_active = 1 ORDER BY order_num ASC");
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $milestones[] = $row;
            }
        } else {
            // Fallback default milestones
            $milestones = [
                [
                    'year' => '2016',
                    'milestone_tag' => 'Genesis',
                    'title' => 'Founding & Core Engineering Blueprint',
                    'description' => 'Started in Bangalore with 4 full-stack developers specializing in high-concurrency Node.js and custom web systems. Delivered 15 MVP builds for high-growth tech startups.'
                ],
                [
                    'year' => '2019',
                    'milestone_tag' => 'Expansion',
                    'title' => 'Cross-Border Scale & Global Client Footprint',
                    'description' => 'Expanded operations to Mumbai and onboarded our first US and UAE enterprise clients. Launched our dedicated UI/UX design lab and mobile app engineering wing.'
                ],
                [
                    'year' => '2022',
                    'milestone_tag' => 'Enterprise Grade',
                    'title' => 'Zero-Downtime Microservices & Cloud Mastery',
                    'description' => 'Achieved ISO-compliant security workflows and rolled out multi-tenant SaaS architecture handling 50M+ annual transactions with 99.99% uptime.'
                ],
                [
                    'year' => '2026',
                    'milestone_tag' => 'The Next Era',
                    'title' => 'AI Integration, 3D Web & Global Leadership',
                    'description' => 'Leading the charge in intelligent AI-augmented digital platforms, spatial WebGL interfaces, and conversion engines for next-generation brands worldwide.'
                ]
            ];
        }
        return $milestones;
    }

    /**
     * Retrieve 4 core company values for holographic projector
     */
    public function getCompanyValues(): array {
        $values = [];
        $res = $this->db->query("SELECT * FROM company_values WHERE is_active = 1 ORDER BY order_num ASC");
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $values[$row['pillar_key']] = $row;
            }
        }
        return $values;
    }

    /**
     * Retrieve team members for interactive constellation
     */
    public function getTeamMembers(): array {
        $team = [];
        $res = $this->db->query("SELECT * FROM team_members WHERE is_active = 1 ORDER BY order_num ASC");
        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $row['skills_arr'] = !empty($row['skills']) ? (json_decode($row['skills'], true) ?: []) : [];
                $team[] = $row;
            }
        } else {
            $team = [
                [
                    'name' => 'Vikramaditya Roy',
                    'role_title' => 'Chief Technology Architect',
                    'specialty' => 'Distributed Cloud & Security',
                    'experience_years' => '12+ Yrs',
                    'avatar_image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&h=120&fit=crop&crop=face'
                ],
                [
                    'name' => 'Ananya Sharma',
                    'role_title' => 'VP of Product Engineering',
                    'specialty' => 'Full-Stack & Edge Infrastructure',
                    'experience_years' => '10+ Yrs',
                    'avatar_image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&h=120&fit=crop&crop=face'
                ],
                [
                    'name' => 'Karthik Raman',
                    'role_title' => 'Principal Full-Stack Engineer',
                    'specialty' => 'High-Concurrency Node & Next.js',
                    'experience_years' => '8+ Yrs',
                    'avatar_image' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=120&h=120&fit=crop&crop=face'
                ],
                [
                    'name' => 'Sneha Patel',
                    'role_title' => 'Lead Mobile Architect',
                    'specialty' => 'Flutter & Native iOS/Android Core',
                    'experience_years' => '9+ Yrs',
                    'avatar_image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=120&h=120&fit=crop&crop=face'
                ]
            ];
        }
        return $team;
    }

    /**
     * Focus areas for expanding 3D accordion
     */
    public function getFocusAreas(): array {
        return [
            [
                'number' => '01 // GLOBAL BENCHMARK',
                'title' => 'Scalable Enterprise Architecture',
                'description' => 'We design backend infrastructures that remain lightning-fast under viral traffic spikes. From automated horizontal container scaling to intelligent CDN cache layers.',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=1000&auto=format&fit=crop'
            ],
            [
                'number' => '02 // CONVERSION SCIENCE',
                'title' => 'Conversion-Focused UI/UX',
                'description' => 'Every layout, animation, and button is placed with cognitive science in mind. We guide customer attention seamlessly to purchase actions and inquiries.',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=1000&auto=format&fit=crop'
            ],
            [
                'number' => '03 // SPEED-TO-MARKET',
                'title' => 'Agile Sprint Delivery',
                'description' => 'We compress 6 months of traditional agency cycles into 4 to 8 high-octane sprints, allowing you to validate MVPs and capture market opportunities before competitors.',
                'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1000&auto=format&fit=crop'
            ],
            [
                'number' => '04 // CONTINUOUS EVOLUTION',
                'title' => 'Dedicated Growth Engineering',
                'description' => 'Launch day is merely day one. We stay alongside your team post-launch with ongoing A/B performance audits, feature iteration, and round-the-clock maintenance.',
                'image' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=1000&auto=format&fit=crop'
            ]
        ];
    }
}
