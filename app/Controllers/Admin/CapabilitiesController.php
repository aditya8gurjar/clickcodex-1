<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Admin\AdminModel;
use App\Middleware\AuthMiddleware;

class CapabilitiesController {
    /**
     * Render Capabilities & Services Management View
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

        $capabilities = $model->getCapabilitiesList($filters);
        $categories   = $model->getServiceCategoriesList();
        $capStats     = $model->getCapabilitiesStats();
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

        $pageTitle = "Capabilities & Services System | ClickCodex Studio Console";
        $activeNav = 'capabilities';

        include __DIR__ . '/../../Views/admin/capabilities.php';
    }

    /**
     * Fetch single capability dossier as JSON for View / Edit modal
     */
    public function getDetail(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_GET['id'] ?? ($_POST['id'] ?? 0));
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid capability ID.']);
            exit;
        }

        $model = new AdminModel();
        $capability = $model->getCapabilityById($id);

        if (!$capability) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Capability record not found.']);
            exit;
        }

        echo json_encode(['success' => true, 'capability' => $capability]);
        exit;
    }

    /**
     * Create or update a capability (AJAX or form POST)
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
                header('Location: ' . BASE_URL . '/admin/capabilities');
            }
            exit;
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model  = new AdminModel();

        $data = [
            'id'                 => (int)($_POST['id'] ?? 0),
            'title'              => trim((string)($_POST['title'] ?? '')),
            'service_code'       => trim((string)($_POST['service_code'] ?? '')),
            'slug'               => trim((string)($_POST['slug'] ?? '')),
            'category_id'        => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'badge_label'        => trim((string)($_POST['badge_label'] ?? 'CORE SERVICE')),
            'short_description'  => trim((string)($_POST['short_description'] ?? '')),
            'full_description'   => trim((string)($_POST['full_description'] ?? '')),
            'price_model'        => trim((string)($_POST['price_model'] ?? 'fixed_sprint')),
            'starting_price_inr' => (float)($_POST['starting_price_inr'] ?? 0),
            'starting_price_usd' => (float)($_POST['starting_price_usd'] ?? 0),
            'typical_timeline'   => trim((string)($_POST['typical_timeline'] ?? '2-4 Weeks')),
            'tech_stack'         => trim((string)($_POST['tech_stack'] ?? '')),
            'key_deliverables'   => trim((string)($_POST['key_deliverables'] ?? '')),
            'performance_kpis'   => trim((string)($_POST['performance_kpis'] ?? '')),
            'icon_svg'           => trim((string)($_POST['icon_svg'] ?? '')),
            'featured_image'     => trim((string)($_POST['featured_image'] ?? '')),
            'is_featured'        => !empty($_POST['is_featured']) ? 1 : 0,
            'is_active'          => isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1,
            'order_num'          => (int)($_POST['order_num'] ?? 0)
        ];

        $res = $model->saveCapability($data, $userId);

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

        header('Location: ' . BASE_URL . '/admin/capabilities');
        exit;
    }

    /**
     * Quick toggle active / inactive status via AJAX
     */
    public function toggleStatus(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid capability ID.']);
            exit;
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model  = new AdminModel();
        $result = $model->toggleCapabilityStatus($id, $userId);

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
            echo json_encode(['success' => false, 'error' => 'Invalid capability ID.']);
            exit;
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model  = new AdminModel();
        $result = $model->toggleCapabilityFeatured($id, $userId);

        echo json_encode($result);
        exit;
    }

    /**
     * Duplicate capability
     */
    public function duplicate(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid capability ID.']);
            exit;
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model  = new AdminModel();
        $result = $model->duplicateCapability($id, $userId);

        echo json_encode($result);
        exit;
    }

    /**
     * Delete capability
     */
    public function delete(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid capability ID.']);
            exit;
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model  = new AdminModel();
        $result = $model->deleteCapability($id, $userId);

        echo json_encode($result);
        exit;
    }

    /**
     * Export all capabilities to CSV download
     */
    public function exportCsv(): void {
        AuthMiddleware::check();

        $model = new AdminModel();
        $capabilities = $model->getCapabilitiesList();

        $filename = 'clickcodex_capabilities_' . date('Y-m-d_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        // UTF-8 BOM for Excel compatibility
        fputs($output, "\xEF\xBB\xBF");

        fputcsv($output, [
            'ID',
            'Service Code',
            'Title',
            'Slug',
            'Category',
            'Badge Label',
            'Price Model',
            'Starting Price (INR)',
            'Starting Price (USD)',
            'Typical Timeline',
            'Tech Stack',
            'Deliverables',
            'Is Featured',
            'Is Active',
            'Order Num',
            'Created At'
        ]);

        foreach ($capabilities as $c) {
            fputcsv($output, [
                $c['id'],
                $c['service_code'],
                $c['title'],
                $c['slug'],
                $c['category_name'] ?? 'Uncategorized',
                $c['badge_label'],
                $c['price_model'],
                $c['starting_price_inr'],
                $c['starting_price_usd'],
                $c['typical_timeline'],
                implode(', ', $c['tech_stack_arr'] ?? []),
                implode(' | ', $c['key_deliverables_arr'] ?? []),
                $c['is_featured'] ? 'Yes' : 'No',
                $c['is_active'] ? 'Active' : 'Inactive',
                $c['order_num'],
                $c['created_at']
            ]);
        }

        fclose($output);
        exit;
    }
}
