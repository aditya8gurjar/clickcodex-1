# ClickCodex Technologies - Advanced Database Architecture

## 1. Overview
The **ClickCodex Database** (`clickcodex_db`) is an enterprise-grade relational database engine designed to power the dynamic transformation of the ClickCodex web platform. It is engineered with **Advanced Technical SEO** as a first-class citizen, high-cadence dynamic content management, lead generation CRM tracking, and sub-millisecond query performance.

- **DBMS**: MySQL / MariaDB (InnoDB Engine)
- **Charset**: `utf8mb4`
- **Collation**: `utf8mb4_unicode_ci`
- **Total Tables**: 37 Normalized Tables
- **Seed Records**: 307 Curated Production Records

---

## 2. Quick Setup & Migration
To run migrations and seed data in any environment:
```bash
# 1. Via Migration Runner (CLI):
php database/migrate.php

# 2. Run Database Integrity & Content Audit:
php database/verify_data.php
```
Or import directly using MySQL CLI:
```bash
mysql -u root -p clickcodex_db < database/schema.sql
mysql -u root -p clickcodex_db < database/seed.sql
```

---

## 3. Database Architecture Breakdown

### Domain 1: Advanced SEO & URL Governance
1. `seo_metadata`: Polymorphic SEO engine that binds to pages, services, case studies, blogs, or custom routes. Stores:
   - Dynamic `meta_title`, `meta_description`, `meta_keywords`, `focus_keyword`, `secondary_keywords`.
   - `canonical_url` overriding.
   - Robots indexing directives (`robots_index`, `robots_follow`, `robots_advanced`).
   - OpenGraph tags (`og_type`, `og_title`, `og_description`, `og_image`, `og_image_alt`).
   - Twitter Cards (`twitter_card`, `twitter_title`, `twitter_description`, `twitter_image`).
   - Schema.org Structured Data (`schema_type`, `schema_json`) for Rich Snippets (Organization, WebSite, LocalBusiness, Service, Article, CaseStudy, FAQPage, BreadcrumbList).
   - Search intent categorization (`informational`, `navigational`, `commercial`, `transactional`).
   - XML Sitemap configurations (`sitemap_priority`, `sitemap_changefreq`, `is_in_sitemap`).
2. `url_redirects`: Manages 301, 302, 307, and 410 URL redirects dynamically to preserve search rankings and link equity.
3. `not_found_logs`: Captures 404 crawl errors, user agents, referrers, and IPs to track broken links and resolve them to redirects.
4. `search_logs`: Tracks internal search queries to discover keyword demand and content gaps.

### Domain 2: Global Configuration & System Settings
1. `site_settings`: Key-value storage for branding, contact emails, phone numbers, WhatsApp, Bangalore & Mumbai office campuses, social URLs, GA4 Measurement ID, GTM ID, Meta Pixel, Search Console verification, and custom scripts.
2. `users`: RBAC authentication for administrators, editors, and SEO specialists.
3. `audit_logs`: Audit trail tracking administrative changes and entity modifications.

### Domain 3: Dynamic Page & Section CMS
1. `pages`: Page directory mapping all 10 core views (`home`, `about_us`, `services`, `service_finder`, `portfolio`, `pricing`, `blogs`, `contact_us`, `privacy_policy`, `terms_of_service`).
2. `page_sections`: Dynamic content blocks for heroes, marquee strips, capabilities tabs, 3D WebGL toggles, and CTA banners.

### Domain 4: Flagship Services & Delivery Workflow
1. `service_categories`: Classification of service offerings.
2. `services`: Full services catalog (Next.js web apps, mobile apps, UI/UX, e-commerce, dedicated pods, AI & cloud) with deliverables, KPIs, tech stack JSON, and pricing.
3. `service_faqs`: Service-level FAQs rendered with Google FAQPage Schema.
4. `service_dossier_steps`: The 4-step execution blueprint (Blueprint, Agile Sprints, QA & Stress Test, Zero-Downtime Launch).
5. `growth_funnel_tiers`: 4-tier growth & conversion funnel metrics.

### Domain 5: Solution Advisor (Service Finder Quiz)
1. `solution_advisor_questions`: 4-step interactive quiz questions (`goal`, `stage`, `features`, `timeline`).
2. `solution_advisor_options`: Choice cards with icons, descriptions, and keys.
3. `advisor_archetypes`: The 6 Digital Architecture Archetypes with trade-off comparison matrix.
4. `advisor_submissions`: Stores customer quiz answers, calculated blueprints, and proposal leads.

### Domain 6: Portfolio & Case Studies
1. `portfolio_categories`: Filter categories (`web`, `mobile`, `ecommerce`, `fintech`, `ai`).
2. `case_studies`: In-depth project writeups (FinScale, HyperCart, PulseHealth, NexusLogix, DevSphere, Aura Luxe) with challenge, architecture, metrics, tech stack, and screenshots.
3. `testimonials`: Client reviews and star ratings for 3D carousels.

### Domain 7: Tech Dispatch (Blogs & Research)
1. `blog_categories`: Technical categories.
2. `blog_authors`: Senior engineer profiles, roles, avatars, and social links.
3. `blog_posts`: Full-length engineering teardowns, reading times, view counts, and published dates.
4. `blog_tags` & `blog_post_tags`: Topic keywords and Many-to-Many relationships for topic clusters.
5. `blog_comments`: Moderated discussion thread comments.
6. `newsletter_subscribers`: Email subscriber list.

### Domain 8: Pricing & Commercial Models
1. `pricing_plans`: Starter MVP Sprint, Growth Authority Platform, and Dedicated Engineering Pod.
2. `pricing_features`: Features checklist for each plan.
3. `pricing_inclusions`: 4 standard enterprise guarantees (100% IP Ownership, 99+ Performance, Warranty, NDA).

### Domain 9: Company Story & Brand Assets
1. `company_milestones`: Timeline of company growth from 2016 Genesis to 2026 The Next Era.
2. `company_values`: Core values with holographic projector stats (Transparency, Velocity, Craft, Founder Alignment).
3. `team_members`: Constellation team node profiles.
4. `trusted_brands`: Client brand logos for infinite marquee animation.
5. `faqs`: General and strategic advisory FAQs.

### Domain 10: Inquiries & Leads CRM
1. `contact_inquiries`: Captures consultation requests, discovery form submissions, custom quotes, UTM tracking parameters, and CRM deal stages.
