<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Admin\AdminModel;
use App\Middleware\AuthMiddleware;

class ArticlesController {
    /**
     * Render Articles & Technical Dispatch Editorial Console
     */
    public function index(): void {
        AuthMiddleware::check();

        $model = new AdminModel();

        // Sanitize GET query filters
        $filters = [
            'category_id' => trim((string)($_GET['category'] ?? 'all')),
            'author_id'   => trim((string)($_GET['author'] ?? 'all')),
            'status'      => trim((string)($_GET['status'] ?? 'all')),
            'featured'    => trim((string)($_GET['featured'] ?? 'all')),
            'search'      => trim((string)($_GET['search'] ?? ''))
        ];

        $articles     = $model->getArticlesList($filters);
        $categories   = $model->getArticleCategoriesList();
        $authors      = $model->getArticleAuthorsList();
        $articleStats = $model->getArticlesStats();
        $stats        = $model->getDashboardStats();

        $currentUser = $_SESSION['admin_user'] ?? [
            'name' => 'Lead Architect Admin',
            'role' => 'super_admin',
            'email' => 'admin@clickcodex.com',
            'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=face'
        ];

        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError   = $_SESSION['flash_error'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);

        $pageTitle = "Technical Articles & Editorial Dispatch | ClickCodex Studio Console";
        $topbarTitle = "Articles & Editorial Dispatch";
        $activeNav = 'articles';

        include __DIR__ . '/../../Views/admin/articles.php';
    }

    /**
     * Fetch single article details as JSON for View Dossier / Edit modal
     */
    public function getDetail(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_GET['id'] ?? ($_POST['id'] ?? 0));
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid article ID.']);
            exit;
        }

        $model = new AdminModel();
        $article = $model->getArticleById($id);

        if (!$article) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Article record not found.']);
            exit;
        }

        echo json_encode(['success' => true, 'article' => $article]);
        exit;
    }

    /**
     * Create or update an article via AJAX
     */
    public function save(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
            exit;
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model = new AdminModel();

        $data = [
            'id'                   => (int)($_POST['id'] ?? 0),
            'title'                => trim((string)($_POST['title'] ?? '')),
            'slug'                 => trim((string)($_POST['slug'] ?? '')),
            'category_id'          => (int)($_POST['category_id'] ?? 1),
            'author_id'            => (int)($_POST['author_id'] ?? 1),
            'excerpt'              => trim((string)($_POST['excerpt'] ?? '')),
            'content'              => trim((string)($_POST['content'] ?? '')),
            'reading_time_minutes' => max(1, (int)($_POST['reading_time_minutes'] ?? 8)),
            'featured_badge'       => trim((string)($_POST['featured_badge'] ?? '')),
            'search_keywords'      => trim((string)($_POST['search_keywords'] ?? '')),
            'featured_image'       => trim((string)($_POST['featured_image'] ?? '')),
            'is_featured'          => !empty($_POST['is_featured']) ? 1 : 0,
            'is_published'         => !empty($_POST['is_published']) ? 1 : 0,
            'published_at'         => !empty($_POST['published_at']) ? trim((string)$_POST['published_at']) : date('Y-m-d H:i:s'),
            'tags'                 => trim((string)($_POST['tags'] ?? ''))
        ];

        if (empty($data['title'])) {
            http_response_code(422);
            echo json_encode(['success' => false, 'error' => 'Article title cannot be empty.']);
            exit;
        }

        if (empty($data['excerpt'])) {
            http_response_code(422);
            echo json_encode(['success' => false, 'error' => 'Executive excerpt summary is required.']);
            exit;
        }

        $result = $model->saveArticle($data, $userId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Quick toggle published / draft status via AJAX
     */
    public function toggleStatus(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $status = (int)($_POST['is_published'] ?? 0);
        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid article ID.']);
            exit;
        }

        $model = new AdminModel();
        $res = $model->toggleArticleStatus($id, $status, $userId);

        echo json_encode($res);
        exit;
    }

    /**
     * Quick toggle featured spotlight flag via AJAX
     */
    public function toggleFeatured(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $featured = (int)($_POST['is_featured'] ?? 0);
        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid article ID.']);
            exit;
        }

        $model = new AdminModel();
        $res = $model->toggleArticleFeatured($id, $featured, $userId);

        echo json_encode($res);
        exit;
    }

    /**
     * Duplicate an article via AJAX
     */
    public function duplicate(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid article ID.']);
            exit;
        }

        $model = new AdminModel();
        $res = $model->duplicateArticle($id, $userId);

        echo json_encode($res);
        exit;
    }

    /**
     * Permanently delete an article via AJAX
     */
    public function delete(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid article ID.']);
            exit;
        }

        $model = new AdminModel();
        $res = $model->deleteArticle($id, $userId);

        echo json_encode($res);
        exit;
    }

    /**
     * Export all articles as CSV download with UTF-8 BOM
     */
    public function exportCsv(): void {
        AuthMiddleware::check();

        $model = new AdminModel();
        $articles = $model->getArticlesList();

        $filename = 'clickcodex_articles_catalog_' . date('Y_m_d_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        // UTF-8 BOM for MS Excel compatibility
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // CSV Header
        fputcsv($output, [
            'Article ID',
            'Title',
            'Slug',
            'Category',
            'Author Name',
            'Reading Time (Mins)',
            'Featured Badge',
            'Views Count',
            'Is Featured',
            'Is Published',
            'Published Date',
            'Tags',
            'Excerpt',
            'Live URL'
        ]);

        $baseUrl = defined('BASE_URL') ? BASE_URL : '';

        foreach ($articles as $art) {
            fputcsv($output, [
                $art['id'],
                $art['title'],
                $art['slug'],
                $art['category_name'] ?? 'Uncategorized',
                $art['author_name'] ?? 'ClickCodex Architecture',
                $art['reading_time_minutes'] . ' mins',
                $art['featured_badge'] ?? '',
                $art['views_count'],
                ((int)$art['is_featured'] === 1) ? 'Yes' : 'No',
                ((int)$art['is_published'] === 1) ? 'Published' : 'Draft',
                $art['published_at'],
                $art['tags_str'] ?? '',
                $art['excerpt'],
                $baseUrl . '/blogs/' . $art['slug']
            ]);
        }

        fclose($output);
        exit;
    }
}
