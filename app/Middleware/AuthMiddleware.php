<?php
declare(strict_types=1);

namespace App\Middleware;

class AuthMiddleware {
    /**
     * Start session if needed
     */
    private static function initSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Ensure user is authenticated as an admin
     */
    public static function check(): void {
        self::initSession();

        if (empty($_SESSION['admin_user'])) {
            $_SESSION['flash_error'] = 'Please log in to access the Admin Console.';
            $baseUrl = defined('BASE_URL') ? BASE_URL : '';
            header("Location: " . $baseUrl . "/admin/login");
            exit;
        }
    }

    /**
     * Redirect authenticated users away from guest pages (e.g. login)
     */
    public static function guest(): void {
        self::initSession();

        if (!empty($_SESSION['admin_user'])) {
            $baseUrl = defined('BASE_URL') ? BASE_URL : '';
            header("Location: " . $baseUrl . "/admin/dashboard");
            exit;
        }
    }
}
