<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use mysqli;

class LegalModel {
    private mysqli $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Retrieve site settings
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
            'whatsapp_number' => '+919876543210',
            'contact_phone' => '+91 (987) 654-3210',
            'contact_email' => 'hello@clickcodex.com',
            'privacy_email' => 'privacy@clickcodex.com',
            'social_linkedin' => 'https://linkedin.com',
            'social_twitter' => 'https://twitter.com',
            'social_instagram' => 'https://instagram.com',
            'social_youtube' => 'https://youtube.com',
            'theme_color' => '#0056d6'
        ];

        return array_merge($defaults, $settings);
    }

    /**
     * Retrieve SEO metadata by slug
     */
    public function getSeoMetadata(string $slug): array {
        $routePath = '/' . ltrim($slug, '/');
        $stmt = $this->db->prepare("SELECT * FROM seo_metadata WHERE route_path = ? OR route_path = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param('ss', $routePath, $slug);
            $stmt->execute();
            $res = $stmt->get_result();
            $seo = $res->fetch_assoc();
            if ($seo) {
                return $seo;
            }
        }

        $isPrivacy = str_contains($slug, 'privacy');
        return [
            'meta_title' => $isPrivacy 
                ? 'Privacy Policy | ClickCodex Technologies' 
                : 'Terms of Service | ClickCodex Technologies',
            'meta_description' => $isPrivacy 
                ? 'ClickCodex Privacy Policy. Understand how we collect, process, and protect your personal and business information under global compliance standards.' 
                : 'ClickCodex Terms of Service. Understand project deliverables, client IP ownership, sprint delivery, and warranties.',
            'canonical_url' => (defined('BASE_URL') ? BASE_URL : '') . '/' . $slug,
            'robots_index' => 1,
            'robots_follow' => 1
        ];
    }

    /**
     * Retrieve page row by slug
     */
    public function getPageData(string $slug): array {
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE slug = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param('s', $slug);
            $stmt->execute();
            $res = $stmt->get_result();
            $page = $res->fetch_assoc();
            if ($page) {
                return $page;
            }
        }

        return [
            'title' => str_contains($slug, 'privacy') ? 'Privacy Policy' : 'Terms of Service',
            'slug' => $slug
        ];
    }
}
