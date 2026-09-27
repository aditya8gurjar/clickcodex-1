-- =============================================================================
-- ClickCodex Technologies - Advanced Database Schema
-- Character Set: utf8mb4 | Collation: utf8mb4_unicode_ci | Engine: InnoDB
-- Production Ready & Advanced SEO Engineered
-- =============================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- -----------------------------------------------------------------------------
-- 1. USERS & ACCESS CONTROL (RBAC)
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `audit_logs`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('super_admin', 'admin', 'editor', 'seo_specialist') NOT NULL DEFAULT 'admin',
  `avatar_url` VARCHAR(500) NULL,
  `phone` VARCHAR(30) NULL,
  `remember_token` VARCHAR(100) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `last_login_at` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_users_role` (`role`),
  INDEX `idx_users_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `audit_logs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NULL,
  `action` VARCHAR(100) NOT NULL,
  `entity_type` VARCHAR(80) NOT NULL,
  `entity_id` INT UNSIGNED NULL,
  `old_values` JSON NULL,
  `new_values` JSON NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_audit_user` (`user_id`),
  INDEX `idx_audit_entity` (`entity_type`, `entity_id`),
  CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 2. GLOBAL SITE SETTINGS & CONFIGURATION
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `site_settings`;

CREATE TABLE `site_settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` LONGTEXT NULL,
  `setting_group` ENUM('general', 'contact', 'branding', 'seo', 'social', 'analytics', 'scripts', 'legal') NOT NULL DEFAULT 'general',
  `value_type` ENUM('string', 'text', 'boolean', 'integer', 'json') NOT NULL DEFAULT 'string',
  `description` VARCHAR(255) NULL,
  `is_public` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_settings_group` (`setting_group`),
  INDEX `idx_settings_public` (`is_public`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 3. ADVANCED UNIVERSAL SEO & STRUCTURED DATA ENGINE
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `seo_metadata`;
DROP TABLE IF EXISTS `url_redirects`;
DROP TABLE IF EXISTS `not_found_logs`;
DROP TABLE IF EXISTS `search_logs`;

CREATE TABLE `seo_metadata` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `entity_type` VARCHAR(60) NOT NULL COMMENT 'page, service, case_study, blog_post, blog_category, custom_route',
  `entity_id` INT UNSIGNED NULL COMMENT 'Null for standalone routes / pages',
  `route_path` VARCHAR(255) NULL COMMENT 'Clean relative URL e.g. /services or /blogs/sub-10ms-apis',
  `meta_title` VARCHAR(255) NOT NULL,
  `meta_description` TEXT NULL,
  `meta_keywords` TEXT NULL,
  `focus_keyword` VARCHAR(150) NULL,
  `secondary_keywords` TEXT NULL,
  `canonical_url` VARCHAR(500) NULL,
  `robots_index` TINYINT(1) NOT NULL DEFAULT 1,
  `robots_follow` TINYINT(1) NOT NULL DEFAULT 1,
  `robots_advanced` VARCHAR(255) DEFAULT 'max-snippet:-1, max-image-preview:large, max-video-preview:-1',
  `og_type` VARCHAR(60) DEFAULT 'website',
  `og_title` VARCHAR(255) NULL,
  `og_description` TEXT NULL,
  `og_image` VARCHAR(500) NULL,
  `og_image_alt` VARCHAR(255) NULL,
  `twitter_card` ENUM('summary', 'summary_large_image', 'app', 'player') DEFAULT 'summary_large_image',
  `twitter_title` VARCHAR(255) NULL,
  `twitter_description` TEXT NULL,
  `twitter_image` VARCHAR(500) NULL,
  `schema_type` VARCHAR(100) DEFAULT 'WebPage',
  `schema_json` JSON NULL,
  `search_intent` ENUM('informational', 'navigational', 'commercial', 'transactional') DEFAULT 'commercial',
  `sitemap_priority` DECIMAL(2,1) DEFAULT 0.8,
  `sitemap_changefreq` ENUM('always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never') DEFAULT 'weekly',
  `is_in_sitemap` TINYINT(1) NOT NULL DEFAULT 1,
  `seo_score` TINYINT UNSIGNED NULL DEFAULT 95,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_seo_polymorphic` (`entity_type`, `entity_id`),
  INDEX `idx_seo_route` (`route_path`),
  INDEX `idx_seo_sitemap` (`is_in_sitemap`, `sitemap_priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `url_redirects` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `source_path` VARCHAR(500) NOT NULL UNIQUE,
  `target_path` VARCHAR(500) NOT NULL,
  `status_code` SMALLINT NOT NULL DEFAULT 301 COMMENT '301 Permanent, 302 Temporary, 307, 410 Gone',
  `hits_count` INT UNSIGNED DEFAULT 0,
  `last_accessed_at` DATETIME NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `notes` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_redirect_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `not_found_logs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `url_path` VARCHAR(500) NOT NULL,
  `referer_url` VARCHAR(500) NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `hit_count` INT UNSIGNED DEFAULT 1,
  `resolved_to_redirect_id` INT UNSIGNED NULL,
  `first_seen_at` DATETIME NOT NULL,
  `last_seen_at` DATETIME NOT NULL,
  INDEX `idx_not_found_url` (`url_path`(191)),
  INDEX `idx_not_found_resolved` (`resolved_to_redirect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `search_logs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `query_term` VARCHAR(255) NOT NULL,
  `section` VARCHAR(50) DEFAULT 'blogs',
  `results_count` INT UNSIGNED DEFAULT 0,
  `ip_address` VARCHAR(45) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_search_query` (`query_term`(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 4. PAGES & SECTION BLOCKS SYSTEM
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `page_sections`;
DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `page_key` VARCHAR(60) NOT NULL UNIQUE COMMENT 'home, about_us, services, service_finder, portfolio, pricing, blogs, contact_us, privacy_policy, terms_of_service',
  `title` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(120) NOT NULL UNIQUE,
  `headline` VARCHAR(255) NULL,
  `subheadline` TEXT NULL,
  `content` LONGTEXT NULL,
  `banner_image` VARCHAR(500) NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_page_slug` (`slug`),
  INDEX `idx_page_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `page_sections` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `page_id` INT UNSIGNED NOT NULL,
  `section_key` VARCHAR(80) NOT NULL COMMENT 'hero, marquee, about_pillars, milestones, reactor_synergy, values_projector, constellation, wireframe_scanner, growth_funnel, delivery_dossier, cta_banner',
  `title` VARCHAR(255) NULL,
  `subtitle` TEXT NULL,
  `badge_text` VARCHAR(120) NULL,
  `content` LONGTEXT NULL,
  `media_url` VARCHAR(500) NULL,
  `cta_primary_text` VARCHAR(100) NULL,
  `cta_primary_url` VARCHAR(255) NULL,
  `cta_secondary_text` VARCHAR(100) NULL,
  `cta_secondary_url` VARCHAR(255) NULL,
  `settings_json` JSON NULL COMMENT 'Custom parameters like 3D model controls, stat counters, toggles',
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uniq_page_section` (`page_id`, `section_key`),
  INDEX `idx_section_order` (`order_num`),
  CONSTRAINT `fk_section_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 5. SERVICES & DELIVERY BLUEPRINT
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `service_faqs`;
DROP TABLE IF EXISTS `service_dossier_steps`;
DROP TABLE IF EXISTS `growth_funnel_tiers`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `service_categories`;

CREATE TABLE `service_categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(120) NOT NULL UNIQUE,
  `icon_svg` TEXT NULL,
  `description` TEXT NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `services` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT UNSIGNED NULL,
  `service_code` VARCHAR(60) NOT NULL UNIQUE,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `title` VARCHAR(200) NOT NULL,
  `short_description` VARCHAR(500) NOT NULL,
  `full_description` LONGTEXT NULL,
  `badge_label` VARCHAR(100) DEFAULT 'CORE SERVICE',
  `icon_svg` TEXT NULL,
  `featured_image` VARCHAR(500) NULL,
  `starting_price_inr` DECIMAL(12,2) NULL,
  `starting_price_usd` DECIMAL(10,2) NULL,
  `price_model` ENUM('fixed_sprint', 'hourly', 'monthly_pod', 'custom') DEFAULT 'fixed_sprint',
  `typical_timeline` VARCHAR(100) NULL,
  `tech_stack` JSON NULL COMMENT 'Array of technologies e.g. ["Next.js 15", "Node.js", "PostgreSQL", "Redis"]',
  `key_deliverables` JSON NULL COMMENT 'Array of deliverables e.g. ["Sub-0.3s Core Web Vitals", "Automated CI/CD"]',
  `performance_kpis` JSON NULL COMMENT 'Metrics and benchmark guarantees',
  `is_featured` TINYINT(1) NOT NULL DEFAULT 1,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `order_num` SMALLINT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_service_slug` (`slug`),
  INDEX `idx_service_active` (`is_active`, `is_featured`),
  CONSTRAINT `fk_service_cat` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `service_faqs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `service_id` INT UNSIGNED NOT NULL,
  `question` VARCHAR(500) NOT NULL,
  `answer` TEXT NOT NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_sfaq_service` (`service_id`),
  CONSTRAINT `fk_sfaq_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `service_dossier_steps` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `phase_code` VARCHAR(50) NOT NULL UNIQUE,
  `phase_number` TINYINT NOT NULL,
  `phase_title` VARCHAR(200) NOT NULL,
  `description` TEXT NOT NULL,
  `typical_timeline` VARCHAR(100) NOT NULL,
  `checkpoints` JSON NOT NULL COMMENT 'Array of milestone checkpoint items',
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `growth_funnel_tiers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `tier_code` VARCHAR(50) NOT NULL UNIQUE,
  `tier_number` TINYINT NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `subtitle` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `stat_badge` VARCHAR(50) NOT NULL,
  `metrics_json` JSON NOT NULL COMMENT 'Array of [{metric, label}]',
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 6. SOLUTION ADVISOR / SERVICE FINDER TOOL
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `advisor_submissions`;
DROP TABLE IF EXISTS `advisor_archetypes`;
DROP TABLE IF EXISTS `solution_advisor_options`;
DROP TABLE IF EXISTS `solution_advisor_questions`;

CREATE TABLE `solution_advisor_questions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `step_number` TINYINT NOT NULL,
  `step_label` VARCHAR(100) NOT NULL,
  `category_key` VARCHAR(50) NOT NULL UNIQUE COMMENT 'goal, stage, features, timeline',
  `question_text` VARCHAR(255) NOT NULL,
  `question_subtitle` VARCHAR(255) NULL,
  `is_multi_select` TINYINT(1) NOT NULL DEFAULT 0,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `solution_advisor_options` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `question_id` INT UNSIGNED NOT NULL,
  `option_key` VARCHAR(50) NOT NULL,
  `icon_emoji` VARCHAR(20) NULL,
  `title` VARCHAR(150) NOT NULL,
  `description` VARCHAR(500) NOT NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_opt_question` (`question_id`),
  CONSTRAINT `fk_opt_question` FOREIGN KEY (`question_id`) REFERENCES `solution_advisor_questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `advisor_archetypes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `archetype_key` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(150) NOT NULL,
  `badge_text` VARCHAR(60) NOT NULL,
  `description` TEXT NOT NULL,
  `best_for` VARCHAR(255) NOT NULL,
  `checklists` JSON NOT NULL,
  `recommended_stack` JSON NOT NULL,
  `time_to_market` VARCHAR(50) NOT NULL,
  `investment_tier` VARCHAR(50) NOT NULL,
  `scalability_ceiling` VARCHAR(50) NOT NULL,
  `seo_dominance` VARCHAR(50) NOT NULL,
  `maintenance_overhead` VARCHAR(50) NOT NULL,
  `typical_team_pod` VARCHAR(50) NOT NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `advisor_submissions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `session_id` VARCHAR(100) NULL,
  `goal_selection` VARCHAR(50) NULL,
  `stage_selection` VARCHAR(50) NULL,
  `features_selected` JSON NULL,
  `timeline_selection` VARCHAR(50) NULL,
  `recommended_archetype_id` INT UNSIGNED NULL,
  `client_name` VARCHAR(150) NULL,
  `client_email` VARCHAR(150) NULL,
  `client_phone` VARCHAR(50) NULL,
  `company_name` VARCHAR(150) NULL,
  `notes` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `status` ENUM('new', 'contacted', 'proposal_sent', 'closed') DEFAULT 'new',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_sub_archetype` (`recommended_archetype_id`),
  INDEX `idx_sub_status` (`status`),
  CONSTRAINT `fk_sub_archetype` FOREIGN KEY (`recommended_archetype_id`) REFERENCES `advisor_archetypes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 7. PORTFOLIO & CASE STUDIES
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `testimonials`;
DROP TABLE IF EXISTS `case_studies`;
DROP TABLE IF EXISTS `portfolio_categories`;

CREATE TABLE `portfolio_categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `slug` VARCHAR(60) NOT NULL UNIQUE,
  `name` VARCHAR(100) NOT NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `case_studies` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT UNSIGNED NULL,
  `slug` VARCHAR(150) NOT NULL UNIQUE,
  `title` VARCHAR(255) NOT NULL,
  `client_name` VARCHAR(150) NOT NULL,
  `client_location` VARCHAR(100) NULL,
  `sector_industry` VARCHAR(150) NOT NULL,
  `timeline_duration` VARCHAR(100) NOT NULL,
  `result_badge` VARCHAR(100) NOT NULL,
  `excerpt` TEXT NOT NULL,
  `challenge_overview` LONGTEXT NOT NULL,
  `architecture_solution` LONGTEXT NOT NULL,
  `key_metrics` JSON NOT NULL COMMENT 'Array of [{val, lbl}]',
  `technologies` JSON NOT NULL COMMENT 'Array of technology strings',
  `search_tech_keywords` TEXT NULL,
  `featured_image` VARCHAR(500) NOT NULL,
  `gallery_images` JSON NULL,
  `live_project_url` VARCHAR(500) NULL,
  `github_url` VARCHAR(500) NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 1,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `published_at` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_cs_slug` (`slug`),
  INDEX `idx_cs_active` (`is_active`, `is_featured`),
  CONSTRAINT `fk_cs_cat` FOREIGN KEY (`category_id`) REFERENCES `portfolio_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `testimonials` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_name` VARCHAR(150) NOT NULL,
  `client_position` VARCHAR(150) NOT NULL,
  `client_company` VARCHAR(150) NOT NULL,
  `client_avatar` VARCHAR(500) NULL,
  `rating_stars` DECIMAL(2,1) NOT NULL DEFAULT 5.0,
  `testimonial_quote` TEXT NOT NULL,
  `case_study_id` INT UNSIGNED NULL,
  `is_featured_home` TINYINT(1) NOT NULL DEFAULT 1,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `order_num` SMALLINT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_test_featured` (`is_featured_home`, `is_active`),
  CONSTRAINT `fk_test_cs` FOREIGN KEY (`case_study_id`) REFERENCES `case_studies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 8. BLOGS, ARTICLES & TECHNICAL DISPATCH
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `blog_comments`;
DROP TABLE IF EXISTS `blog_post_tags`;
DROP TABLE IF EXISTS `blog_tags`;
DROP TABLE IF EXISTS `blog_posts`;
DROP TABLE IF EXISTS `blog_authors`;
DROP TABLE IF EXISTS `blog_categories`;

CREATE TABLE `blog_categories` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(120) NOT NULL UNIQUE,
  `description` VARCHAR(255) NULL,
  `badge_color` VARCHAR(50) DEFAULT '#0056d6',
  `badge_bg` VARCHAR(50) DEFAULT 'rgba(0,86,214,0.08)',
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blog_authors` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(120) NOT NULL UNIQUE,
  `role_title` VARCHAR(150) NOT NULL,
  `initials` VARCHAR(10) NOT NULL,
  `avatar_image` VARCHAR(500) NULL,
  `bio` TEXT NULL,
  `linkedin_url` VARCHAR(255) NULL,
  `twitter_url` VARCHAR(255) NULL,
  `github_url` VARCHAR(255) NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blog_posts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT UNSIGNED NOT NULL,
  `author_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `excerpt` TEXT NOT NULL,
  `content` LONGTEXT NOT NULL,
  `reading_time_minutes` SMALLINT NOT NULL DEFAULT 8,
  `featured_badge` VARCHAR(100) NULL,
  `search_keywords` TEXT NULL,
  `featured_image` VARCHAR(500) NULL,
  `views_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `likes_count` INT UNSIGNED NOT NULL DEFAULT 0,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
  `is_published` TINYINT(1) NOT NULL DEFAULT 1,
  `published_at` DATETIME NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_blog_slug` (`slug`),
  INDEX `idx_blog_published` (`is_published`, `published_at`),
  INDEX `idx_blog_featured` (`is_featured`),
  CONSTRAINT `fk_blog_cat` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_blog_author` FOREIGN KEY (`author_id`) REFERENCES `blog_authors` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blog_tags` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(80) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blog_post_tags` (
  `post_id` INT UNSIGNED NOT NULL,
  `tag_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`post_id`, `tag_id`),
  CONSTRAINT `fk_bpt_post` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bpt_tag` FOREIGN KEY (`tag_id`) REFERENCES `blog_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blog_comments` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `post_id` INT UNSIGNED NOT NULL,
  `parent_id` INT UNSIGNED NULL,
  `author_name` VARCHAR(100) NOT NULL,
  `author_email` VARCHAR(150) NOT NULL,
  `comment_text` TEXT NOT NULL,
  `is_approved` TINYINT(1) NOT NULL DEFAULT 1,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_comment_post` (`post_id`, `is_approved`),
  CONSTRAINT `fk_comment_post` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comment_parent` FOREIGN KEY (`parent_id`) REFERENCES `blog_comments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 9. PRICING & COMMERCIAL PACKAGES
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `pricing_features`;
DROP TABLE IF EXISTS `pricing_plans`;
DROP TABLE IF EXISTS `pricing_inclusions`;

CREATE TABLE `pricing_plans` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `plan_code` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `badge_text` VARCHAR(60) NULL,
  `short_desc` TEXT NOT NULL,
  `price_inr` DECIMAL(12,2) NOT NULL,
  `price_usd` DECIMAL(10,2) NOT NULL,
  `period_label` VARCHAR(60) NOT NULL,
  `estimated_duration` VARCHAR(100) NOT NULL,
  `is_popular` TINYINT(1) NOT NULL DEFAULT 0,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_plan_active` (`is_active`, `order_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pricing_features` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `plan_id` INT UNSIGNED NOT NULL,
  `feature_text` VARCHAR(255) NOT NULL,
  `is_included` TINYINT(1) NOT NULL DEFAULT 1,
  `order_num` SMALLINT DEFAULT 0,
  INDEX `idx_pfeat_plan` (`plan_id`, `order_num`),
  CONSTRAINT `fk_pfeat_plan` FOREIGN KEY (`plan_id`) REFERENCES `pricing_plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pricing_inclusions` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `icon_symbol` VARCHAR(50) NOT NULL,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 10. COMPANY STORY, VALUES, TEAM & BRAND PARTNERS
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `company_milestones`;
DROP TABLE IF EXISTS `company_values`;
DROP TABLE IF EXISTS `team_members`;
DROP TABLE IF EXISTS `trusted_brands`;
DROP TABLE IF EXISTS `faqs`;

CREATE TABLE `company_milestones` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `year_label` VARCHAR(50) NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `description` TEXT NOT NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `company_values` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `pillar_key` VARCHAR(50) NOT NULL UNIQUE,
  `title` VARCHAR(150) NOT NULL,
  `subtitle` VARCHAR(150) NOT NULL,
  `metric_badge` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `stat1_val` VARCHAR(50) NOT NULL,
  `stat1_lbl` VARCHAR(100) NOT NULL,
  `stat2_val` VARCHAR(50) NOT NULL,
  `stat2_lbl` VARCHAR(100) NOT NULL,
  `stat3_val` VARCHAR(50) NOT NULL,
  `stat3_lbl` VARCHAR(100) NOT NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `team_members` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `role_title` VARCHAR(150) NOT NULL,
  `specialty` VARCHAR(150) NOT NULL,
  `experience_years` VARCHAR(50) NOT NULL,
  `avatar_image` VARCHAR(500) NULL,
  `bio` TEXT NULL,
  `skills` JSON NULL,
  `social_links` JSON NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `trusted_brands` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `brand_name` VARCHAR(100) NOT NULL,
  `badge_text` VARCHAR(100) NOT NULL,
  `logo_image` VARCHAR(500) NULL,
  `website_url` VARCHAR(255) NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `faqs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `category` ENUM('general', 'services', 'advisor', 'pricing', 'technical') NOT NULL DEFAULT 'general',
  `question` VARCHAR(500) NOT NULL,
  `answer` TEXT NOT NULL,
  `order_num` SMALLINT DEFAULT 0,
  `is_featured` TINYINT(1) NOT NULL DEFAULT 1,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  INDEX `idx_faq_category` (`category`, `is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 11. CONTACT INQUIRIES, LEADS CRM & NEWSLETTER SUBSCRIBERS
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `newsletter_subscribers`;
DROP TABLE IF EXISTS `contact_inquiries`;

CREATE TABLE `contact_inquiries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `inquiry_type` ENUM('consultation_modal', 'discovery_form', 'service_request', 'custom_quote') NOT NULL DEFAULT 'consultation_modal',
  `full_name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `company_name` VARCHAR(150) NULL,
  `interested_service` VARCHAR(150) NULL,
  `selected_services` JSON NULL,
  `budget_bracket` VARCHAR(100) NULL,
  `timeline` VARCHAR(100) NULL,
  `message` LONGTEXT NULL,
  `source_page` VARCHAR(255) NULL,
  `utm_source` VARCHAR(100) NULL,
  `utm_medium` VARCHAR(100) NULL,
  `utm_campaign` VARCHAR(100) NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` VARCHAR(255) NULL,
  `status` ENUM('new', 'reviewing', 'contacted', 'proposal_sent', 'closed_won', 'closed_lost', 'spam') NOT NULL DEFAULT 'new',
  `internal_notes` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_inq_status` (`status`),
  INDEX `idx_inq_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `newsletter_subscribers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `source_location` VARCHAR(100) NOT NULL DEFAULT 'blogs_dispatch',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `ip_address` VARCHAR(45) NULL,
  `subscribed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `unsubscribed_at` DATETIME NULL,
  INDEX `idx_news_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
