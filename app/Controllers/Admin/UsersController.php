<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Admin\AdminModel;
use App\Middleware\AuthMiddleware;

class UsersController {
    /**
     * Render User Management & Access Control Console
     */
    public function index(): void {
        AuthMiddleware::check();

        $model = new AdminModel();

        // Sanitize GET query filters
        $filters = [
            'role'   => trim((string)($_GET['role'] ?? 'all')),
            'status' => trim((string)($_GET['status'] ?? 'all')),
            'search' => trim((string)($_GET['search'] ?? ''))
        ];

        $users       = $model->getUsersList($filters);
        $userStats   = $model->getUsersStats();
        $stats       = $model->getDashboardStats();

        $currentUser = $_SESSION['admin_user'] ?? [
            'id' => 1,
            'name' => 'Lead Architect Admin',
            'role' => 'super_admin',
            'email' => 'admin@clickcodex.com',
            'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=face'
        ];

        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError   = $_SESSION['flash_error'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);

        $pageTitle = "User Management & Role-Based Access Control | ClickCodex Studio Console";
        $topbarTitle = "User Management & Access Control";
        $activeNav = 'users';

        include __DIR__ . '/../../Views/admin/users.php';
    }

    /**
     * Fetch single user details as JSON for Profile Dossier & Edit modal
     */
    public function getDetail(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_GET['id'] ?? ($_POST['id'] ?? 0));
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid User ID.']);
            exit;
        }

        $model = new AdminModel();
        $user = $model->getUserDetail($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'User not found.']);
            exit;
        }

        echo json_encode(['success' => true, 'user' => $user]);
        exit;
    }

    /**
     * Create or update a user profile via AJAX / POST
     */
    public function save(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
            exit;
        }

        $model = new AdminModel();
        $actorId = (int)($_SESSION['admin_user']['id'] ?? 1);

        $payload = [
            'id'         => (int)($_POST['id'] ?? 0),
            'name'       => trim((string)($_POST['name'] ?? '')),
            'email'      => trim((string)($_POST['email'] ?? '')),
            'phone'      => trim((string)($_POST['phone'] ?? '')),
            'role'       => trim((string)($_POST['role'] ?? 'admin')),
            'avatar_url' => trim((string)($_POST['avatar_url'] ?? '')),
            'is_active'  => isset($_POST['is_active']) ? 1 : 0,
            'password'   => (string)($_POST['password'] ?? '')
        ];

        $result = $model->saveUser($payload, $actorId);
        if (!$result['success']) {
            http_response_code(422);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Toggle user active/suspended state
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
        $isActive = (int)($_POST['is_active'] ?? 0);
        $actorId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid User ID.']);
            exit;
        }

        $model = new AdminModel();
        $result = $model->toggleUserStatus($id, $isActive, $actorId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Reset user password
     */
    public function resetPassword(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $newPassword = (string)($_POST['new_password'] ?? '');
        $actorId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid User ID.']);
            exit;
        }

        if (strlen($newPassword) < 8) {
            http_response_code(422);
            echo json_encode(['success' => false, 'error' => 'Password must be at least 8 characters long.']);
            exit;
        }

        $model = new AdminModel();
        $result = $model->resetUserPassword($id, $newPassword, $actorId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Delete user account permanently
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
        $actorId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid User ID.']);
            exit;
        }

        $model = new AdminModel();
        $result = $model->deleteUser($id, $actorId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Export all users to CSV
     */
    public function exportCsv(): void {
        AuthMiddleware::check();

        $model = new AdminModel();
        $users = $model->getUsersList();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="clickcodex_users_' . date('Y-m-d_His') . '.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID', 'Full Name', 'Email', 'Role', 'Status', 'Phone', 'Last Login', 'Created At']);

        foreach ($users as $u) {
            fputcsv($out, [
                $u['id'],
                $u['name'],
                $u['email'],
                $u['role_label'],
                $u['is_active'] ? 'Active' : 'Suspended',
                $u['phone'] ?? '',
                $u['last_login_at'] ?? 'Never',
                $u['created_at']
            ]);
        }

        fclose($out);
        exit;
    }
}
