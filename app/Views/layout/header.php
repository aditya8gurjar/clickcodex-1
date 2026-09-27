<?php
/**
 * ClickCodex Technologies - Global Header Layout
 * Reusable across all pages: Home, About Us, Services, Portfolio, Pricing, Blogs, Contact Us, Legal
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Advanced SEO Meta Tags -->
  <title><?= htmlspecialchars($seo['meta_title'] ?? 'Click Codex | Ideas to Solutions - Technology & Creative Studio') ?></title>
  <meta name="description" content="<?= htmlspecialchars($seo['meta_description'] ?? 'Click Codex is an agile technology startup and creative studio providing practical web development, mobile apps, software solutions, UI/UX design, and short-form video production.') ?>" />
  <meta name="keywords" content="<?= htmlspecialchars($seo['meta_keywords'] ?? 'Click Codex, web development startup, mobile app development, UI UX design, digital marketing, website development India, custom software') ?>" />
  <meta name="author" content="<?= htmlspecialchars($settings['site_name'] ?? 'Click Codex Technologies') ?>" />
  <meta name="robots" content="<?= !empty($seo['robots_index']) ? 'index' : 'noindex' ?>, <?= !empty($seo['robots_follow']) ? 'follow' : 'nofollow' ?>, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
  <link rel="canonical" href="<?= htmlspecialchars($seo['canonical_url'] ?? (BASE_URL ?: 'https://clickcodex.com')) ?>" />
  <meta name="theme-color" content="<?= htmlspecialchars($settings['theme_color'] ?? '#0056d6') ?>" />

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="<?= htmlspecialchars($seo['og_type'] ?? 'website') ?>" />
  <meta property="og:site_name" content="<?= htmlspecialchars($settings['site_name'] ?? 'Click Codex Technologies') ?>" />
  <meta property="og:url" content="<?= htmlspecialchars($seo['canonical_url'] ?? (BASE_URL ?: 'https://clickcodex.com')) ?>" />
  <meta property="og:title" content="<?= htmlspecialchars($seo['og_title'] ?? $seo['meta_title'] ?? 'Click Codex | Ideas to Solutions - Technology & Creative Studio') ?>" />
  <meta property="og:description" content="<?= htmlspecialchars($seo['og_description'] ?? $seo['meta_description'] ?? '') ?>" />
  <meta property="og:image" content="<?= htmlspecialchars($seo['og_image'] ?? (BASE_URL . '/public/assets/images/logo.png')) ?>" />
  <meta property="og:image:alt" content="<?= htmlspecialchars($settings['site_name'] ?? 'Click Codex') ?> Logo & Digital Solutions" />

  <!-- Twitter / X -->
  <meta name="twitter:card" content="<?= htmlspecialchars($seo['twitter_card'] ?? 'summary_large_image') ?>" />
  <meta name="twitter:site" content="@ClickCodex" />
  <meta name="twitter:creator" content="@ClickCodex" />
  <meta name="twitter:title" content="<?= htmlspecialchars($seo['twitter_title'] ?? $seo['meta_title'] ?? 'Click Codex | Ideas to Solutions') ?>" />
  <meta name="twitter:description" content="<?= htmlspecialchars($seo['twitter_description'] ?? $seo['meta_description'] ?? '') ?>" />
  <meta name="twitter:image" content="<?= htmlspecialchars($seo['twitter_image'] ?? (BASE_URL . '/public/assets/images/logo.png')) ?>" />

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>/public/assets/images/logo.png" />

  <!-- Google Fonts: Poppins (Display) & Plus Jakarta Sans (Modern Body) & Space Mono (Tech) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet" />

  <!-- Schema.org JSON-LD Structured Data Schema -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "Organization",
        "@id": "https://clickcodex.com/#organization",
        "name": "<?= addslashes($settings['site_name'] ?? 'ClickCodex Technologies') ?>",
        "url": "https://clickcodex.com",
        "logo": {
          "@type": "ImageObject",
          "url": "https://clickcodex.com/logo.png"
        },
        "sameAs": [
          "<?= addslashes($settings['social_linkedin'] ?? 'https://linkedin.com') ?>",
          "<?= addslashes($settings['social_twitter'] ?? 'https://twitter.com') ?>",
          "<?= addslashes($settings['social_instagram'] ?? 'https://instagram.com') ?>",
          "<?= addslashes($settings['social_youtube'] ?? 'https://youtube.com') ?>"
        ]
      },
      {
        "@type": "WebSite",
        "@id": "https://clickcodex.com/#website",
        "url": "https://clickcodex.com",
        "name": "ClickCodex",
        "publisher": {
          "@id": "https://clickcodex.com/#organization"
        }
      },
      {
        "@type": "WebSite",
        "@id": "https://clickcodex.com/index.html#webpage",
        "url": "https://clickcodex.com/index.html",
        "name": "<?= addslashes($seo['meta_title'] ?? 'Click Codex | Ideas to Solutions - Technology & Creative Studio') ?>",
        "description": "<?= addslashes($seo['meta_description'] ?? '') ?>",
        "isPartOf": {
          "@id": "https://clickcodex.com/#website"
        }
      },
      {
        "@type": "BreadcrumbList",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "<?= BASE_URL ?>/"
          }
          <?php if (!empty($breadcrumbs)): ?>
            <?php foreach ($breadcrumbs as $bPos => $bItem): ?>
            ,{
              "@type": "ListItem",
              "position": <?= $bPos + 2 ?>,
              "name": "<?= addslashes($bItem['name']) ?>",
              "item": "<?= addslashes($bItem['url']) ?>"
            }
            <?php endforeach; ?>
          <?php endif; ?>
        ]
      }
    ]
  }
  </script>

  <!-- Complete Exact Stylesheet -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css" />
  <?php if (!empty($extraCss)): ?>
    <link rel="stylesheet" href="<?= $extraCss ?>" />
  <?php endif; ?>
  <?php if (!empty($extraHead)): ?>
    <?= $extraHead ?>
  <?php endif; ?>
</head>
<body>

  <!-- Ambient Cursor Spotlight (active on hover across site) -->
  <div class="cursor-spotlight-orb" id="cursorSpotlight"></div>

  <!-- ==========================================================================
       1. NAVIGATION BAR (STICKY & GLASSMORPHIC)
       ========================================================================== -->
  <nav class="site-nav" id="siteNav">
    <div class="container nav-container">
      <!-- ClickCodex Logo with local logo.png -->
      <a href="<?= BASE_URL ?>/" class="brand-logo-wrap" aria-label="ClickCodex Home">
        <img src="<?= BASE_URL ?>/public/assets/images/logo.png" alt="ClickCodex Logo" class="brand-logo-img" />
        <div class="brand-name-group">
          <span class="brand-title">Click<span>codex</span></span>
          <span class="brand-subtext"><?= htmlspecialchars($settings['site_tagline'] ?? 'Ideas To Solutions') ?></span>
        </div>
      </a>

      <!-- Desktop Navigation Links -->
      <ul class="nav-menu">
        <li><a href="<?= BASE_URL ?>/" class="nav-link <?= ($activeNav ?? '') === 'home' ? 'active' : '' ?>">Home</a></li>
        <li><a href="<?= BASE_URL ?>/aboutus" class="nav-link <?= ($activeNav ?? '') === 'aboutus' ? 'active' : '' ?>">About</a></li>
        <li><a href="<?= BASE_URL ?>/services" class="nav-link <?= ($activeNav ?? '') === 'services' ? 'active' : '' ?>">Services</a></li>
        <li><a href="<?= BASE_URL ?>/service-finder" class="nav-link <?= ($activeNav ?? '') === 'service-finder' ? 'active' : '' ?>">Advisor</a></li>
        <li><a href="<?= BASE_URL ?>/portfolio" class="nav-link <?= ($activeNav ?? '') === 'portfolio' ? 'active' : '' ?>">Portfolio</a></li>
        <li><a href="<?= BASE_URL ?>/pricing" class="nav-link <?= ($activeNav ?? '') === 'pricing' ? 'active' : '' ?>">Pricing</a></li>
        <li><a href="<?= BASE_URL ?>/blogs" class="nav-link <?= ($activeNav ?? '') === 'blogs' ? 'active' : '' ?>">Blogs</a></li>
        <li><a href="<?= BASE_URL ?>/contactus" class="nav-link <?= ($activeNav ?? '') === 'contactus' ? 'active' : '' ?>">Contact</a></li>
      </ul>

      <!-- Action Buttons -->
      <div class="nav-actions">
        <!-- WhatsApp Quick Chat -->
        <?php 
          $rawPhone = preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '919876543210');
          $waMsg = urlencode($settings['whatsapp_default_message'] ?? 'Hi ClickCodex, I would like to inquire about a project');
        ?>
        <a href="https://wa.me/<?= $rawPhone ?>?text=<?= $waMsg ?>" 
           target="_blank" rel="noopener noreferrer" class="whatsapp-btn" title="Quick Chat on WhatsApp">
          <svg viewBox="0 0 24 24">
            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.698.077-1.118-.057-.26-.084-.589-.201-.989-.374-1.745-.758-2.887-2.531-2.975-2.648-.088-.116-.71-0.947-.71-1.807 0-.859.45-1.282.61-1.458.16-.176.35-.22.47-.22.12 0 .24.002.34.007.11.005.26-.042.41.319.15.362.51 1.242.55 1.33.04.088.07.191.01.308-.06.117-.09.19-.18.293-.09.103-.19.23-.27.309-.09.088-.19.183-.08.371.11.188.48.793 1.03 1.283.71.633 1.31.829 1.49.919.18.09.29.076.4-.047.11-.123.47-.549.6-.738.13-.189.26-.158.44-.092.18.066 1.14.537 1.34.636.2.099.33.147.38.232.05.085.05.495-.09.9z"/>
          </svg>
          <span>WhatsApp</span>
        </a>

        <!-- Talk to Us CTA -->
        <button class="btn-primary desktop-btn" onclick="openConsultationModal()">Talk To Us</button>

        <!-- Mobile Menu Toggle Button -->
        <button class="mobile-menu-toggle" id="mobileToggle" aria-label="Toggle Navigation">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </div>
  </nav>

  <!-- Mobile Drawer Menu -->
  <div class="mobile-drawer" id="mobileDrawer">
    <a href="<?= BASE_URL ?>/" class="nav-link <?= ($activeNav ?? '') === 'home' ? 'active' : '' ?>" onclick="closeMobileDrawer()">Home</a>
    <a href="<?= BASE_URL ?>/aboutus" class="nav-link <?= ($activeNav ?? '') === 'aboutus' ? 'active' : '' ?>" onclick="closeMobileDrawer()">About Click Codex</a>
    <a href="<?= BASE_URL ?>/services" class="nav-link <?= ($activeNav ?? '') === 'services' ? 'active' : '' ?>" onclick="closeMobileDrawer()">Our Services</a>
    <a href="<?= BASE_URL ?>/service-finder" class="nav-link <?= ($activeNav ?? '') === 'service-finder' ? 'active' : '' ?>" onclick="closeMobileDrawer()">Solution Advisor</a>
    <a href="<?= BASE_URL ?>/portfolio" class="nav-link <?= ($activeNav ?? '') === 'portfolio' ? 'active' : '' ?>" onclick="closeMobileDrawer()">Portfolio & Showcase</a>
    <a href="<?= BASE_URL ?>/pricing" class="nav-link <?= ($activeNav ?? '') === 'pricing' ? 'active' : '' ?>" onclick="closeMobileDrawer()">Pricing & Models</a>
    <a href="<?= BASE_URL ?>/blogs" class="nav-link <?= ($activeNav ?? '') === 'blogs' ? 'active' : '' ?>" onclick="closeMobileDrawer()">Blogs & Guides</a>
    <a href="<?= BASE_URL ?>/contactus" class="nav-link <?= ($activeNav ?? '') === 'contactus' ? 'active' : '' ?>" onclick="closeMobileDrawer()">Contact & Inquiries</a>
    <button class="btn-primary" style="width: 100%; margin-top: 15px;" onclick="closeMobileDrawer(); openConsultationModal();">Book Free Consultation</button>
  </div>
