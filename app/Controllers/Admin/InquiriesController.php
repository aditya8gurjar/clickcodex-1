<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Admin\AdminModel;
use App\Middleware\AuthMiddleware;

class InquiriesController {
    /**
     * Render the Inquiries & Leads CRM Console
     */
    public function index(): void {
        AuthMiddleware::check();

        $model = new AdminModel();
        
        // Sanitize GET query filters
        $filters = [
            'status'     => trim((string)($_GET['status'] ?? 'all')),
            'search'     => trim((string)($_GET['search'] ?? '')),
            'service'    => trim((string)($_GET['service'] ?? 'all')),
            'date_range' => trim((string)($_GET['date_range'] ?? 'all')),
            'sort'       => trim((string)($_GET['sort'] ?? 'newest')),
            'limit'      => 300,
            'offset'     => 0
        ];

        $inquiries = $model->getInquiriesList($filters);
        $crmStats = $model->getInquiriesStats();
        $stats = $model->getDashboardStats();
        $recentInquiries = $model->getRecentInquiries(6);

        $currentUser = $_SESSION['admin_user'] ?? [
            'name' => 'Lead Architect Admin',
            'role' => 'super_admin',
            'email' => 'admin@clickcodex.com',
            'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=face'
        ];

        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError = $_SESSION['flash_error'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);

        $pageTitle = "Inquiries & Leads CRM | ClickCodex Studio Console";

        include __DIR__ . '/../../Views/admin/inquiries.php';
    }

    /**
     * Fetch single lead dossier as JSON
     */
    public function getDetail(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_GET['id'] ?? ($_POST['id'] ?? 0));
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid inquiry ID.']);
            exit;
        }

        $model = new AdminModel();
        $inquiry = $model->getInquiryById($id);

        if (!$inquiry) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Inquiry record not found.']);
            exit;
        }

        echo json_encode(['success' => true, 'inquiry' => $inquiry]);
        exit;
    }

    /**
     * Update inquiry status via AJAX
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
            echo json_encode(['success' => false, 'error' => 'Missing lead ID or status code.']);
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
     * Save internal CRM administrative notes
     */
    public function saveNotes(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        $id = (int)($input['id'] ?? 0);
        $notes = trim((string)($input['notes'] ?? ''));
        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing lead ID.']);
            exit;
        }

        $model = new AdminModel();
        $result = $model->updateInquiryNotes($id, $notes, $userId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Create manual lead entry
     */
    public function create(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);

        $model = new AdminModel();
        $result = $model->createInquiryManual($input, $userId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Delete an inquiry
     */
    public function delete(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        $id = (int)($input['id'] ?? 0);
        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid lead ID.']);
            exit;
        }

        $model = new AdminModel();
        $result = $model->deleteInquiry($id, $userId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Bulk Action on multiple inquiries
     */
    public function bulkAction(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        $ids = (array)($input['ids'] ?? []);
        $action = trim((string)($input['action'] ?? ''));
        $value = isset($input['value']) ? trim((string)$input['value']) : null;
        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if (empty($ids) || empty($action)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Please select at least one inquiry.']);
            exit;
        }

        $model = new AdminModel();
        $result = $model->bulkUpdateInquiries($ids, $action, $value, $userId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Stream CSV export with applied filters
     */
    public function exportCsv(): void {
        AuthMiddleware::check();

        $model = new AdminModel();
        $filters = [
            'status'     => trim((string)($_GET['status'] ?? 'all')),
            'search'     => trim((string)($_GET['search'] ?? '')),
            'service'    => trim((string)($_GET['service'] ?? 'all')),
            'date_range' => trim((string)($_GET['date_range'] ?? 'all')),
            'limit'      => 10000,
            'offset'     => 0
        ];

        $inquiries = $model->getInquiriesList($filters);

        $filename = "clickcodex_leads_" . date('Y_m_d_His') . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        // Add UTF-8 BOM for Excel compatibility
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($out, [
            'ID',
            'Full Name',
            'Email Address',
            'Phone',
            'Company Name',
            'Selected Services',
            'Investment Bracket',
            'Timeline',
            'Status',
            'Submission Date',
            'IP Address',
            'Internal CRM Notes'
        ]);

        foreach ($inquiries as $inq) {
            fputcsv($out, [
                $inq['id'],
                $inq['full_name'],
                $inq['email'],
                $inq['phone'],
                $inq['company_name'] ?: 'Independent',
                implode(', ', $inq['services_list'] ?? []),
                $inq['budget_bracket'] ?: 'Custom Scope',
                $inq['timeline'] ?: 'Flexible',
                strtoupper((string)$inq['status']),
                $inq['created_at'],
                $inq['ip_address'] ?? '127.0.0.1',
                $inq['internal_notes'] ?? ''
            ]);
        }

        fclose($out);
        exit;
    }
}
