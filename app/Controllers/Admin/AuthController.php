<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Admin\AdminModel;
use App\Middleware\AuthMiddleware;

class AuthController {
    /**
     * Display the Admin Login Portal
     */
    public function login(): void {
        AuthMiddleware::guest();

        $error = $_SESSION['flash_error'] ?? null;
        $success = $_SESSION['flash_success'] ?? null;
        unset($_SESSION['flash_error'], $_SESSION['flash_success']);

        $pageTitle = "Studio Access Console | ClickCodex Admin";
        include __DIR__ . '/../../Views/admin/login.php';
    }

    /**
     * Handle Login Submission
     */
    public function authenticate(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . (defined('BASE_URL') ? BASE_URL : '') . "/admin/login");
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = trim((string)($_POST['email'] ?? ''));
        $password = trim((string)($_POST['password'] ?? ''));

        $model = new AdminModel();
        $res = $model->authenticate($email, $password);

        if ($res['success']) {
            $_SESSION['flash_success'] = "Welcome back, " . $res['user']['name'] . "!";
            header("Location: " . (defined('BASE_URL') ? BASE_URL : '') . "/admin/dashboard");
            exit;
        }

        $_SESSION['flash_error'] = $res['error'] ?? 'Invalid credentials.';
        header("Location: " . (defined('BASE_URL') ? BASE_URL : '') . "/admin/login");
        exit;
    }

    /**
     * Secure Logout
     */
    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user = $_SESSION['admin_user'] ?? null;
        if ($user) {
            $model = new AdminModel();
            $model->logAction((int)$user['id'], 'user_logout', 'users', (int)$user['id'], [
                'logout_time' => date('Y-m-d H:i:s')
            ]);
        }

        unset($_SESSION['admin_user']);
        $_SESSION['flash_success'] = 'You have logged out successfully.';
        header("Location: " . (defined('BASE_URL') ? BASE_URL : '') . "/admin/login");
        exit;
    }
}
