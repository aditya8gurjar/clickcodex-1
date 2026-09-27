<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use mysqli;

class AdvisorModel {
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
     * Retrieve SEO metadata for Solution Advisor page
     */
    public function getSeoMetadata(): array {
        $stmt = $this->db->prepare("SELECT * FROM seo_metadata WHERE (entity_type = 'page' AND entity_id = 4) OR route_path IN ('/service-finder', 'service-finder', '/advisor', 'advisor') LIMIT 1");
        if ($stmt) {
            $stmt->execute();
            $res = $stmt->get_result();
            $seo = $res->fetch_assoc();
            if ($seo) {
                return $seo;
            }
        }

        return [
            'meta_title' => 'Solution Advisor & Technical Blueprint Generator | ClickCodex',
            'meta_description' => 'Not sure which digital architecture your business needs? Take our 60-second interactive Solution Advisor quiz to calculate the exact tech stack, timeline, and investment package.',
            'meta_keywords' => 'solution advisor, website cost calculator, digital architecture advisor, web app estimator, startup MVP planner, ClickCodex solution finder',
            'canonical_url' => 'https://clickcodex.com/service-finder',
            'og_type' => 'website',
            'og_title' => 'Solution Advisor & Architecture Blueprint Generator | ClickCodex',
            'og_description' => 'Match your business goals, timeline, and budget with the optimal digital architecture blueprint in 60 seconds.',
            'og_image' => 'https://clickcodex.com/logo.png',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'Solution Advisor & Architecture Blueprint Generator | ClickCodex',
            'twitter_description' => 'Find the perfect website or software architecture for your business in 60 seconds.',
            'twitter_image' => 'https://clickcodex.com/logo.png',
            'schema_type' => 'SoftwareApplication',
            'schema_json' => '{"@context":"https://schema.org","@type":"SoftwareApplication","name":"ClickCodex Solution Advisor","applicationCategory":"BusinessApplication"}',
            'robots_index' => 1,
            'robots_follow' => 1
        ];
    }

    /**
     * Retrieve page record for 'service_finder' (id = 4)
     */
    public function getPageData(): array {
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE id = 4 OR page_key = 'service_finder' LIMIT 1");
        if ($stmt) {
            $stmt->execute();
            $res = $stmt->get_result();
            $page = $res->fetch_assoc();
            if ($page) {
                return $page;
            }
        }

        return [
            'title' => 'Solution Advisor',
            'slug' => 'service-finder',
            'headline' => 'Which Website or Architecture Fits Your Business Goals?',
            'subheadline' => 'Avoid over-engineering or under-building. Take our 60-second interactive Solution Advisor quiz to match your stage, budget, and traffic targets with the ideal technical blueprint.'
        ];
    }

    /**
     * Retrieve all page sections for page_id = 4
     */
    public function getPageSections(): array {
        $sections = [];
        $stmt = $this->db->prepare("SELECT * FROM page_sections WHERE page_id = 4 AND is_active = 1 ORDER BY order_num ASC");
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
     * Retrieve the 4 interactive questions along with all their options
     */
    public function getQuestionsWithOptions(): array {
        $questions = [];
        $qQuery = "SELECT * FROM solution_advisor_questions WHERE is_active = 1 ORDER BY step_number ASC, order_num ASC";
        $qRes = $this->db->query($qQuery);

        if ($qRes && $qRes->num_rows > 0) {
            while ($q = $qRes->fetch_assoc()) {
                $qId = (int)$q['id'];
                $optStmt = $this->db->prepare("SELECT * FROM solution_advisor_options WHERE question_id = ? AND is_active = 1 ORDER BY order_num ASC");
                $optStmt->bind_param("i", $qId);
                $optStmt->execute();
                $optRes = $optStmt->get_result();
                $options = [];
                while ($opt = $optRes->fetch_assoc()) {
                    $options[] = $opt;
                }
                $q['options'] = $options;
                $questions[] = $q;
            }
        }

        return $questions;
    }

    /**
     * Retrieve the 6 digital architecture archetypes
     */
    public function getArchetypes(): array {
        $archetypes = [];
        $query = "SELECT * FROM advisor_archetypes WHERE is_active = 1 ORDER BY order_num ASC";
        $res = $this->db->query($query);

        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                // Decode checklists JSON if present
                if (!empty($row['checklists'])) {
                    $decoded = json_decode($row['checklists'], true);
                    $row['checklists_array'] = is_array($decoded) ? $decoded : [];
                } else {
                    $row['checklists_array'] = [];
                }

                // Decode recommended_stack JSON if present
                if (!empty($row['recommended_stack'])) {
                    $decodedStack = json_decode($row['recommended_stack'], true);
                    $row['recommended_stack_array'] = is_array($decodedStack) ? $decodedStack : [];
                } else {
                    $row['recommended_stack_array'] = [];
                }

                $archetypes[] = $row;
            }
        }

        return $archetypes;
    }

    /**
     * Retrieve advisor FAQs
     */
    public function getFaqs(): array {
        $faqs = [];
        $query = "SELECT * FROM faqs WHERE category = 'advisor' AND is_active = 1 ORDER BY order_num ASC";
        $res = $this->db->query($query);

        if ($res && $res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                $faqs[] = $row;
            }
        }

        // Fallback default FAQs if table returns empty
        if (empty($faqs)) {
            $faqs = [
                [
                    'question' => 'Should we build a mobile app or a responsive web app first?',
                    'answer' => 'In 85% of cases, we advise clients to launch a responsive, mobile-first Web Application first. Web apps require zero app store download friction, provide immediate access via URLs and QR codes, update instantly without app store reviews, and cost roughly 40% less to validate product-market fit. Once your core user loop is validated, we wrap the backend into a cross-platform Flutter/React Native app with push notifications.'
                ],
                [
                    'question' => 'WordPress / Shopify vs Custom Next.js: What is the real difference?',
                    'answer' => 'WordPress and basic template builders are great for hobbyists, but quickly suffer from plugin vulnerabilities, slow load times (2–5 seconds), rigid design constraints, and database bloat. Custom Next.js and modern frameworks compile to edge-cached static assets with sub-500ms global speeds, custom 3D WebGL interactions, zero plugin security flaws, and full source code ownership.'
                ],
                [
                    'question' => 'How do you protect client intellectual property and code ownership?',
                    'answer' => 'Under ClickCodex contracts, 100% of the intellectual property, design source files, Git repositories, and database schemas are transferred to you upon milestone completion. We provide a full commercial IP handover agreement with no proprietary vendor lock-in.'
                ],
                [
                    'question' => 'What happens after our website or software goes live?',
                    'answer' => 'Every ClickCodex engagement includes a complimentary 30-day warranty covering bug fixes, browser compatibility checks, and performance optimization. We also offer dedicated monthly SLA maintenance pods for feature additions, server scaling, and continuous SEO optimization.'
                ]
            ];
        }

        return $faqs;
    }
}
