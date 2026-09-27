<?php
declare(strict_types=1);

namespace App\Models;

use App\Config\Database;
use mysqli;

class BlogsModel {
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
     * Retrieve SEO metadata for Blogs page
     */
    public function getSeoMetadata(): array {
        $stmt = $this->db->prepare("SELECT * FROM seo_metadata WHERE (entity_type = 'page' AND entity_id = 7) OR route_path IN ('/blogs', 'blogs') LIMIT 1");
        if ($stmt) {
            $stmt->execute();
            $res = $stmt->get_result();
            $seo = $res->fetch_assoc();
            if ($seo) {
                return $seo;
            }
        }

        return [
            'meta_title' => 'Technical Dispatch: Systems Architecture & AI Research | ClickCodex',
            'meta_description' => 'In-depth engineering teardowns, production benchmarks, zero-runtime CSS, local LLM fine-tuning, and multi-region Kubernetes architectures from the ClickCodex engineering team.',
            'meta_keywords' => 'engineering blogs, distributed systems architecture, Next.js performance benchmarks, local LLM quantization, WebGL shaders 60fps',
            'canonical_url' => 'https://clickcodex.com/blogs',
            'og_type' => 'website',
            'og_title' => 'Technical Dispatch: Systems Architecture & AI Research | ClickCodex',
            'og_description' => 'Deep architectural teardowns and benchmarks from the ClickCodex engineering team.',
            'og_image' => 'https://clickcodex.com/logo.png',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => 'Technical Dispatch: Systems Architecture & AI Research | ClickCodex',
            'twitter_description' => 'Zero-fluff engineering insights for senior engineers, tech leads, and founders.',
            'twitter_image' => 'https://clickcodex.com/logo.png',
            'schema_type' => 'Blog',
            'schema_json' => '{"@context":"https://schema.org","@type":"Blog","name":"ClickCodex Technical Dispatch"}',
            'robots_index' => 1,
            'robots_follow' => 1
        ];
    }

    /**
     * Retrieve page record for 'blogs' (id = 7)
     */
    public function getPageData(): array {
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE id = 7 OR page_key = 'blogs' LIMIT 1");
        if ($stmt) {
            $stmt->execute();
            $res = $stmt->get_result();
            $page = $res->fetch_assoc();
            if ($page) {
                return $page;
            }
        }

        return [
            'title' => 'Blogs & Insights',
            'slug' => 'blogs',
            'headline' => 'Engineering Systems at the Frontier of Scale',
            'subheadline' => 'Architectural teardowns, real-world benchmarks, distributed systems patterns, AI engineering, and zero-runtime UI design from the ClickCodex engineering team.'
        ];
    }

    /**
     * Retrieve all page sections for page_id = 7
     */
    public function getPageSections(): array {
        $sections = [];
        $stmt = $this->db->prepare("SELECT * FROM page_sections WHERE page_id = 7 AND is_active = 1 ORDER BY order_num ASC");
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
     * Retrieve all active blog categories
     */
    public function getCategories(): array {
        $categories = [];
        $res = $this->db->query("SELECT * FROM blog_categories WHERE is_active = 1 ORDER BY order_num ASC");
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $categories[] = $row;
            }
        }

        return $categories;
    }

    /**
     * Retrieve the single featured spotlight post
     */
    public function getFeaturedPost(): ?array {
        $sql = "SELECT bp.*, bc.name AS category_name, bc.slug AS category_slug, bc.badge_color, bc.badge_bg,
                       ba.name AS author_name, ba.role_title AS author_role, ba.initials AS author_initials, ba.bio AS author_bio
                FROM blog_posts bp
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                LEFT JOIN blog_authors ba ON bp.author_id = ba.id
                WHERE bp.is_featured = 1 AND bp.is_published = 1
                ORDER BY bp.published_at DESC
                LIMIT 1";

        $res = $this->db->query($sql);
        if ($res && $res->num_rows > 0) {
            return $res->fetch_assoc();
        }

        return null;
    }

    /**
     * Retrieve all published blog posts (excluding or including featured)
     */
    public function getAllPosts(?string $categorySlug = null, bool $excludeFeatured = true): array {
        $posts = [];
        $sql = "SELECT bp.*, bc.name AS category_name, bc.slug AS category_slug, bc.badge_color, bc.badge_bg,
                       ba.name AS author_name, ba.role_title AS author_role, ba.initials AS author_initials
                FROM blog_posts bp
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                LEFT JOIN blog_authors ba ON bp.author_id = ba.id
                WHERE bp.is_published = 1";

        if ($excludeFeatured) {
            $sql .= " AND bp.is_featured = 0";
        }

        if ($categorySlug !== null && $categorySlug !== 'all') {
            $sql .= " AND bc.slug = '" . $this->db->real_escape_string($categorySlug) . "'";
        }

        $sql .= " ORDER BY bp.id ASC";

        $res = $this->db->query($sql);
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $posts[] = $row;
            }
        }

        return $posts;
    }

    /**
     * Retrieve a single post by slug
     */
    public function getPostBySlug(string $slug): ?array {
        $stmt = $this->db->prepare("
            SELECT bp.*, bc.name AS category_name, bc.slug AS category_slug, bc.badge_color, bc.badge_bg,
                   ba.name AS author_name, ba.role_title AS author_role, ba.initials AS author_initials, ba.bio AS author_bio,
                   ba.linkedin_url AS author_linkedin, ba.twitter_url AS author_twitter
            FROM blog_posts bp
            LEFT JOIN blog_categories bc ON bp.category_id = bc.id
            LEFT JOIN blog_authors ba ON bp.author_id = ba.id
            WHERE bp.slug = ? AND bp.is_published = 1
            LIMIT 1
        ");

        if ($stmt) {
            $stmt->bind_param("s", $slug);
            $stmt->execute();
            $res = $stmt->get_result();
            return $res->fetch_assoc() ?: null;
        }

        return null;
    }

    /**
     * Retrieve SEO metadata for a single blog post
     */
    public function getPostSeo(int $postId): array {
        $stmt = $this->db->prepare("SELECT * FROM seo_metadata WHERE entity_type = 'blog_post' AND entity_id = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param("i", $postId);
            $stmt->execute();
            $res = $stmt->get_result();
            $seo = $res->fetch_assoc();
            if ($seo) return $seo;
        }

        return [];
    }

    /**
     * Retrieve recent posts (for recommendations / sidebars)
     */
    public function getRecentPosts(int $limit = 3, int $excludeId = 0): array {
        $posts = [];
        $sql = "SELECT bp.id, bp.slug, bp.title, bp.reading_time_minutes, bp.published_at, bc.name AS category_name, bc.slug AS category_slug, ba.name AS author_name
                FROM blog_posts bp
                LEFT JOIN blog_categories bc ON bp.category_id = bc.id
                LEFT JOIN blog_authors ba ON bp.author_id = ba.id
                WHERE bp.is_published = 1";

        if ($excludeId > 0) {
            $sql .= " AND bp.id != " . (int)$excludeId;
        }

        $sql .= " ORDER BY bp.published_at DESC LIMIT " . (int)$limit;

        $res = $this->db->query($sql);
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $posts[] = $row;
            }
        }

        return $posts;
    }
}
