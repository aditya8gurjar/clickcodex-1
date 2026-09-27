<?php
/**
 * ClickCodex Technologies - Blog Article Detail View
 * High-fidelity technical article reader with Reading Progress Bar, Sticky TOC Scrollspy, Code Copying, and Social Sharing.
 */
declare(strict_types=1);

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

include __DIR__ . '/layout/header.php';

// Prepare Table of Contents dynamically from article content
$tocItems = [];
if (!empty($post['content'])) {
    if (preg_match_all('/<h2[^>]*id=["\']([^"\']+)["\'][^>]*>(.*?)<\/h2>/is', $post['content'], $matches, PREG_SET_ORDER)) {
        foreach ($matches as $m) {
            $tocItems[] = [
                'id' => $m[1],
                'title' => strip_tags($m[2])
            ];
        }
    }
}

// Fallback TOC if no h2 with ID found
if (empty($tocItems)) {
    $tocItems = [
        ['id' => 'section-1', 'title' => '1. Overview & Problem Scope'],
        ['id' => 'section-2', 'title' => '2. Architecture & Design Principles'],
        ['id' => 'section-3', 'title' => '3. Implementation Teardown'],
        ['id' => 'section-4', 'title' => '4. Production Benchmarks'],
        ['id' => 'section-5', 'title' => '5. Key Takeaways']
    ];
}

$readTime = (int)($post['reading_time_minutes'] ?? 6);
$pubDate = !empty($post['published_at']) ? date('M d, Y', strtotime($post['published_at'])) : 'Sept 2026';
$authorName = $post['author_name'] ?? 'Click Codex Editorial Team';
$authorRole = $post['author_role'] ?? 'Engineering & Creative Studio';
$authorInitials = $post['author_initials'] ?? 'CC';
$authorBio = $post['author_bio'] ?? 'The Click Codex editorial collective shares practical guides on web development, UI/UX design, marketing, and media creation.';
$catName = $post['category_name'] ?? 'Web & Tech';
$catBadgeColor = $post['badge_color'] ?? '#0056d6';
$catBadgeBg = $post['badge_bg'] ?? 'rgba(0, 86, 214, 0.08)';
$currentUrl = (defined('BASE_URL') ? BASE_URL : '') . '/blogs/' . ($post['slug'] ?? '');
?>

<!-- Reading Progress Bar -->
<div class="reading-progress-bar" id="readingProgressBar"></div>

<main>
  <!-- ==========================================================================
       ARTICLE HERO HEADER
       ========================================================================== -->
  <header class="article-hero">
    <div class="container">
      <!-- Breadcrumbs -->
      <nav class="article-breadcrumbs" aria-label="Breadcrumb">
        <a href="<?= BASE_URL ?>/">Home</a>
        <span class="sep">/</span>
        <a href="<?= BASE_URL ?>/blogs">Blogs & Insights</a>
        <span class="sep">/</span>
        <span class="current"><?= htmlspecialchars($post['title']) ?></span>
      </nav>

      <div class="article-meta-tags">
        <span class="article-category-badge" style="color: <?= htmlspecialchars($catBadgeColor) ?>; background: <?= htmlspecialchars($catBadgeBg) ?>; border-color: <?= htmlspecialchars($catBadgeColor) ?>40;">
          <?= htmlspecialchars($catName) ?>
        </span>
        <span class="article-time-badge">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
          <?= $readTime ?> min read • Published <?= $pubDate ?>
        </span>
      </div>

      <h1><?= htmlspecialchars($post['title']) ?></h1>

      <p class="article-lead">
        <?= htmlspecialchars($post['excerpt']) ?>
      </p>

      <div class="author-share-bar">
        <div class="author-card-snippet">
          <div class="author-avatar-img"><?= htmlspecialchars($authorInitials) ?></div>
          <div class="author-details-text">
            <strong><?= htmlspecialchars($authorName) ?></strong>
            <span><?= htmlspecialchars($authorRole) ?></span>
          </div>
        </div>

        <div class="share-buttons-group">
          <button class="share-btn" onclick="copyArticleUrl()" aria-label="Copy Article Link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
            <span>Copy Link</span>
          </button>
          
          <?php 
            $shareText = urlencode($post['title'] . ' by @ClickCodex');
            $encodedUrl = urlencode($currentUrl);
          ?>
          <a href="https://twitter.com/intent/tweet?text=<?= $shareText ?>&url=<?= $encodedUrl ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Share on Twitter / X">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            <span>Post</span>
          </a>

          <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $encodedUrl ?>" target="_blank" rel="noopener noreferrer" class="share-btn" aria-label="Share on LinkedIn">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76a1.64 1.64 0 1 0 0-3.28 1.64 1.64 0 0 0 0 3.28m1.39 9.74v-8.37H5.07v8.37h2.78z"/></svg>
            <span>Share</span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- ==========================================================================
       ARTICLE MAIN CONTENT & SIDEBAR
       ========================================================================== -->
  <div class="article-main-wrap">
    <div class="container">
      <div class="article-layout-grid">
        
        <!-- Sticky Sidebar -->
        <aside class="article-sidebar">
          <div class="toc-card">
            <h3>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
              Table of Contents
            </h3>
            <ul class="toc-nav-list" id="tocNav">
              <?php foreach ($tocItems as $idx => $item): ?>
                <li>
                  <a href="#<?= htmlspecialchars($item['id']) ?>" class="toc-link <?= $idx === 0 ? 'active' : '' ?>">
                    <?= htmlspecialchars($item['title']) ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- Consultation Callout Card -->
          <div class="sidebar-cta-card">
            <h4>Need High-Scale Architecture?</h4>
            <p>Schedule a 30-minute technical whiteboarding session with our lead architects to optimize your platform latency.</p>
            <button class="sidebar-cta-btn" onclick="openConsultationModal('<?= htmlspecialchars(addslashes($post['title'])) ?> Architecture')">
              Book Technical Session
            </button>
          </div>
        </aside>

        <!-- Article Content Body -->
        <article class="article-body-content">
          
          <!-- Render Database HTML Content -->
          <div class="db-article-content">
            <?= $post['content'] ?>
          </div>

          <!-- Author Full Profile Card -->
          <div class="author-full-card">
            <div class="author-full-avatar"><?= htmlspecialchars($authorInitials) ?></div>
            <div class="author-full-content">
              <h4><?= htmlspecialchars($authorName) ?></h4>
              <div class="author-role-text"><?= htmlspecialchars($authorRole) ?></div>
              <p>
                <?= htmlspecialchars($authorBio) ?>
              </p>
              <div class="share-buttons-group">
                <a href="<?= htmlspecialchars($post['author_linkedin'] ?? 'https://linkedin.com') ?>" target="_blank" rel="noopener noreferrer" class="share-btn">LinkedIn Profile</a>
                <a href="<?= htmlspecialchars($post['author_twitter'] ?? 'https://twitter.com') ?>" target="_blank" rel="noopener noreferrer" class="share-btn">Follow on X</a>
              </div>
            </div>
          </div>

          <!-- Discussion & Comment Section -->
          <div class="discussion-card">
            <h3>Join the Engineering Discussion</h3>
            <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 20px;">
              Have questions regarding this implementation or architectural benchmarks? Leave a technical inquiry below.
            </p>

            <form class="comment-input-wrap" onsubmit="handleCommentSubmit(event)">
              <textarea id="commentText" placeholder="Write your technical comment, benchmark inquiry, or feedback..." required></textarea>
              <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-primary" style="padding: 10px 24px; font-size: 0.9rem;">
                  <span>Post Comment</span>
                </button>
              </div>
            </form>
          </div>

        </article>
      </div>
    </div>
  </div>

  <!-- ==========================================================================
       RECOMMENDED TECHNICAL READS
       ========================================================================== -->
  <?php if (!empty($recentPosts)): ?>
    <section class="related-articles-section">
      <div class="container">
        <h2>Recommended Technical Reads</h2>
        <div class="related-grid">
          <?php foreach ($recentPosts as $rPost): ?>
            <a href="<?= BASE_URL ?>/blogs/<?= htmlspecialchars($rPost['slug']) ?>" class="related-card">
              <div>
                <span class="category-chip" style="font-size: 0.72rem; padding: 3px 10px; border-radius: 9999px; margin-bottom: 10px; display: inline-block;">
                  <?= htmlspecialchars($rPost['category_name'] ?? 'Technical') ?>
                </span>
                <h3><?= htmlspecialchars($rPost['title']) ?></h3>
              </div>
              <span class="read-link">Read Deep Dive →</span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

</main>

<!-- Toast element -->
<div class="copy-toast" id="copyToast">Link copied to clipboard!</div>

<!-- Page-Specific Table of Contents & Reading Progress JavaScript -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // 1. Reading Progress Bar
    const progressBar = document.getElementById('readingProgressBar');
    window.addEventListener('scroll', () => {
      const totalHeight = document.documentElement.scrollHeight - window.innerHeight;
      if (totalHeight > 0 && progressBar) {
        const progress = (window.scrollY / totalHeight) * 100;
        progressBar.style.width = Math.min(100, Math.max(0, progress)) + '%';
      }

      // 2. Scrollspy for Table of Contents
      const headings = document.querySelectorAll('.article-body-content h2[id], .article-body-content h3[id]');
      const tocLinks = document.querySelectorAll('.toc-link');

      let currentActive = '';
      headings.forEach(heading => {
        const rect = heading.getBoundingClientRect();
        if (rect.top <= 160) {
          currentActive = heading.getAttribute('id');
        }
      });

      if (currentActive) {
        tocLinks.forEach(link => {
          if (link.getAttribute('href') === '#' + currentActive) {
            link.classList.add('active');
          } else {
            link.classList.remove('active');
          }
        });
      }
    });
  });

  // Copy Article URL
  window.copyArticleUrl = function() {
    navigator.clipboard.writeText(window.location.href).then(() => {
      showToast('Article link copied to clipboard!');
    }).catch(() => {
      showToast('Article URL: ' + window.location.href);
    });
  };

  // Copy Code Snippet
  window.copyCodeSnippet = function(btn) {
    const codeBlock = btn.closest('.code-container').querySelector('code');
    if (codeBlock) {
      navigator.clipboard.writeText(codeBlock.innerText).then(() => {
        const orig = btn.innerHTML;
        btn.innerHTML = '<span>✓ Copied!</span>';
        setTimeout(() => { btn.innerHTML = orig; }, 2000);
      });
    }
  };

  // Toast Helper
  function showToast(msg) {
    const toast = document.getElementById('copyToast');
    if (toast) {
      toast.textContent = msg;
      toast.classList.add('show');
      setTimeout(() => { toast.classList.remove('show'); }, 3000);
    }
  }

  // Comment Submission
  window.handleCommentSubmit = function(e) {
    e.preventDefault();
    const txt = document.getElementById('commentText');
    if (txt && txt.value.trim()) {
      alert('Thank you for participating! Your comment has been submitted for moderation.');
      txt.value = '';
    }
  };
</script>

<?php include __DIR__ . '/layout/footer.php'; ?>
