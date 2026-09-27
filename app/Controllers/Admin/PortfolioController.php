<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Admin\AdminModel;
use App\Middleware\AuthMiddleware;

class PortfolioController {
    /**
     * Render Portfolio & Case Studies Console
     */
    public function index(): void {
        AuthMiddleware::check();

        $model = new AdminModel();

        // Sanitize GET query filters
        $filters = [
            'category' => trim((string)($_GET['category'] ?? 'all')),
            'status'   => trim((string)($_GET['status'] ?? 'all')),
            'featured' => trim((string)($_GET['featured'] ?? 'all')),
            'search'   => trim((string)($_GET['search'] ?? ''))
        ];

        $caseStudies = $model->getPortfolioList($filters);
        $categories  = $model->getPortfolioCategoriesList();
        $portStats   = $model->getPortfolioStats();
        $stats       = $model->getDashboardStats();

        $currentUser = $_SESSION['admin_user'] ?? [
            'name' => 'Lead Architect Admin',
            'role' => 'super_admin',
            'email' => 'admin@clickcodex.com',
            'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=face'
        ];

        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError   = $_SESSION['flash_error'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);

        $pageTitle = "Portfolio & Case Studies Management | ClickCodex Studio Console";
        $activeNav = 'portfolio';

        include __DIR__ . '/../../Views/admin/portfolio.php';
    }

    /**
     * Fetch single case study dossier as JSON for View / Edit modal
     */
    public function getDetail(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_GET['id'] ?? ($_POST['id'] ?? 0));
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid case study ID.']);
            exit;
        }

        $model = new AdminModel();
        $study = $model->getPortfolioById($id);

        if (!$study) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Case study record not found.']);
            exit;
        }

        echo json_encode(['success' => true, 'case_study' => $study]);
        exit;
    }

    /**
     * Create or update case study
     */
    public function save(): void {
        AuthMiddleware::check();
        $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
               || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                http_response_code(405);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
            } else {
                header('Location: ' . BASE_URL . '/admin/portfolio');
            }
            exit;
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model  = new AdminModel();

        // Process Key Metrics from form inputs
        $metricVals = $_POST['metric_val'] ?? [];
        $metricLbls = $_POST['metric_lbl'] ?? [];
        $metrics = [];
        if (is_array($metricVals)) {
            foreach ($metricVals as $idx => $val) {
                $v = trim((string)$val);
                $l = trim((string)($metricLbls[$idx] ?? ''));
                if (!empty($v) || !empty($l)) {
                    $metrics[] = ['val' => $v, 'lbl' => $l];
                }
            }
        }

        $data = [
            'id'                    => (int)($_POST['id'] ?? 0),
            'title'                 => trim((string)($_POST['title'] ?? '')),
            'slug'                  => trim((string)($_POST['slug'] ?? '')),
            'category_id'           => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'client_name'           => trim((string)($_POST['client_name'] ?? '')),
            'client_location'       => trim((string)($_POST['client_location'] ?? '')),
            'sector_industry'       => trim((string)($_POST['sector_industry'] ?? 'Technology')),
            'timeline_duration'     => trim((string)($_POST['timeline_duration'] ?? '8-12 Weeks')),
            'result_badge'          => trim((string)($_POST['result_badge'] ?? '+100% Impact')),
            'excerpt'               => trim((string)($_POST['excerpt'] ?? '')),
            'challenge_overview'    => trim((string)($_POST['challenge_overview'] ?? '')),
            'architecture_solution' => trim((string)($_POST['architecture_solution'] ?? '')),
            'metrics_json'          => json_encode($metrics, JSON_UNESCAPED_UNICODE),
            'technologies'          => trim((string)($_POST['technologies'] ?? '')),
            'featured_image'        => trim((string)($_POST['featured_image'] ?? '')),
            'live_project_url'      => trim((string)($_POST['live_project_url'] ?? '')),
            'github_url'            => trim((string)($_POST['github_url'] ?? '')),
            'order_num'             => (int)($_POST['order_num'] ?? 0),
            'is_featured'           => !empty($_POST['is_featured']) ? 1 : 0,
            'is_active'             => isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1
        ];

        $res = $model->savePortfolio($data, $userId);

        if ($isAjax) {
            header('Content-Type: application/json; charset=utf-8');
            if (!$res['success']) {
                http_response_code(422);
            }
            echo json_encode($res);
            exit;
        }

        if ($res['success']) {
            $_SESSION['flash_success'] = $res['message'];
        } else {
            $_SESSION['flash_error'] = $res['error'];
        }

        header('Location: ' . BASE_URL . '/admin/portfolio');
        exit;
    }

    /**
     * Quick toggle active status via AJAX
     */
    public function toggleStatus(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid case study ID.']);
            exit;
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model  = new AdminModel();
        $result = $model->togglePortfolioStatus($id, $userId);

        echo json_encode($result);
        exit;
    }

    /**
     * Quick toggle featured status via AJAX
     */
    public function toggleFeatured(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid case study ID.']);
            exit;
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model  = new AdminModel();
        $result = $model->togglePortfolioFeatured($id, $userId);

        echo json_encode($result);
        exit;
    }

    /**
     * Duplicate case study
     */
    public function duplicate(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid case study ID.']);
            exit;
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model  = new AdminModel();
        $result = $model->duplicatePortfolio($id, $userId);

        echo json_encode($result);
        exit;
    }

    /**
     * Delete case study
     */
    public function delete(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid case study ID.']);
            exit;
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model  = new AdminModel();
        $result = $model->deletePortfolio($id, $userId);

        echo json_encode($result);
        exit;
    }

    /**
     * Export all case studies to CSV
     */
    public function exportCsv(): void {
        AuthMiddleware::check();

        $model = new AdminModel();
        $caseStudies = $model->getPortfolioList();

        $filename = 'clickcodex_case_studies_' . date('Y-m-d_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fputs($output, "\xEF\xBB\xBF");

        fputcsv($output, [
            'ID',
            'Title',
            'Slug',
            'Client Name',
            'Client Location',
            'Sector / Industry',
            'Category',
            'Result Badge',
            'Timeline',
            'Key Metrics',
            'Technologies',
            'Live URL',
            'Is Featured',
            'Is Active',
            'Order Num',
            'Created At'
        ]);

        foreach ($caseStudies as $cs) {
            $metricsSummary = [];
            foreach ($cs['key_metrics_arr'] ?? [] as $km) {
                $metricsSummary[] = ($km['val'] ?? '') . ' (' . ($km['lbl'] ?? '') . ')';
            }

            fputcsv($output, [
                $cs['id'],
                $cs['title'],
                $cs['slug'],
                $cs['client_name'],
                $cs['client_location'],
                $cs['sector_industry'],
                $cs['category_name'] ?? 'Uncategorized',
                $cs['result_badge'],
                $cs['timeline_duration'],
                implode(' | ', $metricsSummary),
                implode(', ', $cs['technologies_arr'] ?? []),
                $cs['live_project_url'],
                $cs['is_featured'] ? 'Yes' : 'No',
                $cs['is_active'] ? 'Active' : 'Inactive',
                $cs['order_num'],
                $cs['created_at']
            ]);
        }

        fclose($output);
        exit;
    }
}
