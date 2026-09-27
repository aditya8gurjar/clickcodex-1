<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Admin\AdminModel;
use App\Middleware\AuthMiddleware;

class DashboardController {
    /**
     * Render the Executive Dashboard
     */
    public function index(): void {
        AuthMiddleware::check();

        $model = new AdminModel();
        $stats = $model->getDashboardStats();
        $recentInquiries = $model->getRecentInquiries(6);
        $recentAudits = $model->getRecentAuditLogs(6);
        $recentAdvisors = $model->getRecentAdvisorSubmissions(5);
        $trends = $model->getInquiryTrends();

        $currentUser = $_SESSION['admin_user'] ?? [
            'name' => 'Lead Architect Admin',
            'role' => 'super_admin',
            'email' => 'admin@clickcodex.com'
        ];

        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError = $_SESSION['flash_error'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);

        $pageTitle = "Executive Studio Console | ClickCodex Admin";

        include __DIR__ . '/../../Views/admin/dashboard.php';
    }

    /**
     * Update an inquiry status via AJAX and respond with JSON
     */
    public function updateStatus(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        $id = (int)($input['id'] ?? 0);
        $status = trim((string)($input['status'] ?? ''));
        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if ($id <= 0 || empty($status)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing inquiry ID or status.']);
            exit;
        }

        $model = new AdminModel();
        $result = $model->updateInquiryStatus($id, $status, $userId);

        if (!$result['success']) {
            http_response_code(400);
        }
        echo json_encode($result);
        exit;
    }

    /**
     * Clear application cache
     */
    public function clearCache(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $cacheDir = __DIR__ . '/../../../storage/cache';
        $cleared = 0;
        if (is_dir($cacheDir)) {
            $files = glob($cacheDir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                    $cleared++;
                }
            }
        }

        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);
        $model = new AdminModel();
        $model->logAction($userId, 'clear_cache', 'system', 0, ['files_cleared' => $cleared]);

        echo json_encode([
            'success' => true,
            'message' => 'System cache flushed successfully. (' . $cleared . ' files cleared)'
        ]);
        exit;
    }
}
