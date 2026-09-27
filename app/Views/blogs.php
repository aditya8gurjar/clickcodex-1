<?php
/**
 * ClickCodex Technologies - Tech Dispatch & Engineering Blogs View
 * Features Category Filter Pills, Real-Time Keyword Search, Featured Spotlight Article, and Technical Cards Grid.
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

include __DIR__ . '/layout/header.php';
?>

<main>
  <!-- ==========================================================================
       BLOGS HERO SECTION
       ========================================================================== -->
  <section class="blogs-hero">
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>
    
    <div class="container">
      <div class="hero-badge-pill">
        <span class="dot"></span>
        <span>Click Codex Insights & Guides</span>
      </div>

      <h1>
        Ideas, Technology & <span class="gradient-text">Practical Guides</span>
      </h1>

      <p class="hero-desc">
        <?= htmlspecialchars($sections['blogs_hero']['subtitle'] ?? 'Practical insights on web development, digital marketing, UI/UX design, and software solutions from the Click Codex team.') ?>
      </p>

      <!-- Search & Filter Bar -->
      <div class="search-filter-wrap">
        <div class="search-bar-wrap">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          <input type="text" id="searchInput" placeholder="Search articles and guides: Website, Marketing, UI/UX, Web App, Reels..." aria-label="Search articles" />
        </div>

        <div class="filter-pills-row" id="filterPills">
          <button class="filter-pill active" data-category="all">All Insights</button>
          <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
              <button class="filter-pill" data-category="<?= htmlspecialchars($cat['slug']) ?>">
                <?= htmlspecialchars($cat['name']) ?>
              </button>
            <?php endforeach; ?>
          <?php else: ?>
            <button class="filter-pill" data-category="web-tech-insights">Web & Tech</button>
            <button class="filter-pill" data-category="design-ui-ux">Design & UI/UX</button>
            <button class="filter-pill" data-category="marketing-media">Marketing & Media</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       FEATURED FLAGSHIP ARTICLE SPOTLIGHT
       ========================================================================== -->
  <?php if (!empty($featuredPost)): 
    $featSlug = htmlspecialchars($featuredPost['slug']);
    $featDate = !empty($featuredPost['published_at']) ? date('M d, Y', strtotime($featuredPost['published_at'])) : 'Sept 18, 2026';
    $featReadTime = (int)($featuredPost['reading_time_minutes'] ?? 6);
  ?>
    <section class="featured-section">
      <div class="container">
        <article class="featured-card">
          <div class="featured-content">
            <div class="featured-badge-row">
              <span class="featured-tag"><?= htmlspecialchars($featuredPost['featured_badge'] ?: 'Featured Guide') ?></span>
              <span class="featured-readtime">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <?= $featReadTime ?> min read • <?= $featDate ?>
              </span>
            </div>

            <h2>
              <a href="<?= BASE_URL ?>/blogs/<?= $featSlug ?>"><?= htmlspecialchars($featuredPost['title']) ?></a>
            </h2>

            <p class="featured-excerpt">
              <?= htmlspecialchars($featuredPost['excerpt']) ?>
            </p>

            <div class="featured-meta-author">
              <div class="author-info">
                <div class="author-avatar"><?= htmlspecialchars($featuredPost['author_initials'] ?? 'CC') ?></div>
                <div class="author-name-group">
                  <strong><?= htmlspecialchars($featuredPost['author_name'] ?? 'Click Codex Editorial') ?></strong>
                  <span><?= htmlspecialchars($featuredPost['author_role'] ?? 'Creative & Engineering Team') ?></span>
                </div>
              </div>

              <a href="<?= BASE_URL ?>/blogs/<?= $featSlug ?>" class="featured-action-btn">
                <span>Read Full Deep Dive</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </a>
            </div>
          </div>

          <!-- Interactive Architecture Diagram Stack -->
          <div class="featured-graphic" aria-hidden="true">
            <div class="diagram-stack">
              <div class="diagram-block">
                <div class="diagram-label">
                  <span>Client Ingress (Tokyo, London, NYC)</span>
                </div>
                <span class="diagram-badge">Anycast DNS</span>
              </div>
              <div class="diagram-block highlight">
                <div class="diagram-label">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0056d6" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                  <span>ClickCodex Rust Edge Proxy</span>
                </div>
                <span class="diagram-badge" style="background: rgba(0, 86, 214, 0.12); color: var(--brand-blue);">8.4ms P99</span>
              </div>
              <div class="diagram-block">
                <div class="diagram-label">
                  <span>Distributed CRDT State Sync</span>
                </div>
                <span class="diagram-badge" style="background: rgba(255, 106, 0, 0.12); color: var(--brand-orange);">Zero Locks</span>
              </div>
              <div class="diagram-block">
                <div class="diagram-label">
                  <span>Active-Active Multi-Region DB</span>
                </div>
                <span class="diagram-badge" style="background: rgba(16, 185, 129, 0.12); color: #059669;">99.999% SLA</span>
              </div>
            </div>
          </div>
        </article>
      </div>
    </section>
  <?php endif; ?>

  <!-- ==========================================================================
       ARTICLES GRID SECTION
       ========================================================================== -->
  <section class="articles-grid-section">
    <div class="container">
      <div class="section-header-row">
        <h2>Latest Technical Articles</h2>
        <span class="article-count-badge" id="articleCount">Showing <?= count($posts) ?> articles</span>
      </div>

      <div class="articles-grid" id="articlesGrid">
        <?php if (!empty($posts)): ?>
          <?php foreach ($posts as $post): 
            $postSlug = htmlspecialchars($post['slug']);
            $catSlug = htmlspecialchars($post['category_slug'] ?? 'architecture');
            $catName = htmlspecialchars($post['category_name'] ?? 'Architecture & Scale');
            $badgeColor = htmlspecialchars($post['badge_color'] ?? 'var(--brand-blue)');
            $badgeBg = htmlspecialchars($post['badge_bg'] ?? 'rgba(0, 86, 214, 0.08)');
            $readTime = (int)($post['reading_time_minutes'] ?? 8);
            $postDate = !empty($post['published_at']) ? date('M d, Y', strtotime($post['published_at'])) : 'Aug 2026';
            $keywords = htmlspecialchars($post['search_keywords'] ?? '');
          ?>
            <article class="article-card" data-category="<?= $catSlug ?>" data-keywords="<?= $keywords ?>">
              <div>
                <div class="card-top-row">
                  <span class="category-chip" style="color: <?= $badgeColor ?>; background: <?= $badgeBg ?>; border-color: <?= $badgeColor ?>40;">
                    <?= $catName ?>
                  </span>
                  <span class="read-time"><?= $readTime ?> min read • <?= $postDate ?></span>
                </div>
                <h3>
                  <a href="<?= BASE_URL ?>/blogs/<?= $postSlug ?>"><?= htmlspecialchars($post['title']) ?></a>
                </h3>
                <p class="card-summary">
                  <?= htmlspecialchars($post['excerpt']) ?>
                </p>
              </div>
              <div class="card-footer-row">
                <div class="card-author-pill">
                  <div class="author-thumb" style="color: <?= $badgeColor ?>;">
                    <?= htmlspecialchars($post['author_initials'] ?? 'CC') ?>
                  </div>
                  <span class="author-text"><?= htmlspecialchars($post['author_name'] ?? 'Staff Engineer') ?></span>
                </div>
                <a href="<?= BASE_URL ?>/blogs/<?= $postSlug ?>" class="read-link">Read Deep Dive →</a>
              </div>
            </article>
          <?php endforeach; ?>
        <?php endif; ?>

        <!-- No results placeholder -->
        <div class="no-results-msg" id="noResultsMsg" style="display: none; grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 16px; display: block; opacity: 0.5;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          <p style="font-size: 1.1rem; color: #64748b;">No technical articles matched your search query. Try another keyword or reset the category filter.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================================================
       ENGINEERING DISPATCH NEWSLETTER
       ========================================================================== -->
  <section class="container" style="margin-bottom: 80px;">
    <div class="dispatch-newsletter">
      <span class="dispatch-badge">ClickCodex Architecture Dispatch</span>
      <h2><?= htmlspecialchars($sections['dispatch_newsletter']['title'] ?? 'Zero-Fluff Engineering Insights Delivered Monthly') ?></h2>
      <p>
        <?= htmlspecialchars($sections['dispatch_newsletter']['subtitle'] ?? 'Join 14,000+ senior engineers, tech leads, and founders who receive our curated architectural teardowns, production benchmarks, and software design principles.') ?>
      </p>

      <form class="newsletter-form" onsubmit="handleNewsletterSubmit(event)">
        <input type="email" id="newsletterEmail" placeholder="Enter your business email address..." required aria-label="Business Email" />
        <button type="submit" class="btn-primary" style="white-space: nowrap;">
          <span>Subscribe Free</span>
        </button>
      </form>
    </div>
  </section>
</main>

<!-- Page-Specific Search & Filter JavaScript -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const filterPills = document.querySelectorAll('.filter-pill');
    const articles = document.querySelectorAll('.article-card');
    const noResultsMsg = document.getElementById('noResultsMsg');
    const articleCount = document.getElementById('articleCount');

    let currentCategory = 'all';
    let currentQuery = '';

    function filterArticles() {
      let visibleCount = 0;

      articles.forEach(article => {
        const category = article.getAttribute('data-category');
        const keywords = (article.getAttribute('data-keywords') || '') + ' ' + 
                         (article.querySelector('h3') ? article.querySelector('h3').innerText.toLowerCase() : '') + ' ' + 
                         (article.querySelector('.card-summary') ? article.querySelector('.card-summary').innerText.toLowerCase() : '');
        
        const matchesCategory = (currentCategory === 'all') || (category === currentCategory);
        const matchesQuery = !currentQuery || keywords.includes(currentQuery.toLowerCase().trim());

        if (matchesCategory && matchesQuery) {
          article.style.display = 'flex';
          visibleCount++;
        } else {
          article.style.display = 'none';
        }
      });

      if (noResultsMsg && articleCount) {
        if (visibleCount === 0) {
          noResultsMsg.style.display = 'block';
          articleCount.textContent = 'Showing 0 articles';
        } else {
          noResultsMsg.style.display = 'none';
          articleCount.textContent = `Showing ${visibleCount} article${visibleCount === 1 ? '' : 's'}`;
        }
      }
    }

    filterPills.forEach(pill => {
      pill.addEventListener('click', () => {
        filterPills.forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        currentCategory = pill.getAttribute('data-category');
        filterArticles();
      });
    });

    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        currentQuery = e.target.value;
        filterArticles();
      });
    }
  });

  window.handleNewsletterSubmit = function(e) {
    e.preventDefault();
    const input = document.getElementById('newsletterEmail');
    if (!input) return;
    const email = input.value;
    if (email) {
      alert('Thank you for subscribing to ClickCodex Engineering Dispatch! Check your inbox for the latest architecture edition.');
      input.value = '';
    }
  };
</script>

<?php include __DIR__ . '/layout/footer.php'; ?>
