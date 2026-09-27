<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Admin\AdminModel;
use App\Middleware\AuthMiddleware;

class SolutionAdvisorController {
    /**
     * Render Solution Advisor & Architecture Finder Console
     */
    public function index(): void {
        AuthMiddleware::check();

        $model = new AdminModel();

        // Sanitize GET query filters
        $filters = [
            'status' => trim((string)($_GET['status'] ?? 'all')),
            'search' => trim((string)($_GET['search'] ?? ''))
        ];

        $archetypes   = $model->getAdvisorArchetypes($filters);
        $advisorStats = $model->getAdvisorStats();
        $questions    = $model->getAdvisorQuestionsWithOptions();
        $submissions  = $model->getAdvisorSubmissions(30);
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

        $pageTitle = "Solution Advisor & Architecture Finder (6) | ClickCodex Studio Console";
        $topbarTitle = "Solution Advisor & Archetype Engine";
        $activeNav = 'solution_advisor';

        include __DIR__ . '/../../Views/admin/solution_advisor.php';
    }

    /**
     * Fetch single archetype details as JSON for View Dossier / Edit modal
     */
    public function getDetail(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $id = (int)($_GET['id'] ?? ($_POST['id'] ?? 0));
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid Solution Archetype ID.']);
            exit;
        }

        $model = new AdminModel();
        $archetype = $model->getAdvisorArchetypeById($id);

        if (!$archetype) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Solution Archetype not found.']);
            exit;
        }

        echo json_encode(['success' => true, 'archetype' => $archetype]);
        exit;
    }

    /**
     * Create or update a Solution Archetype via AJAX
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
            'id'                     => (int)($_POST['id'] ?? 0),
            'name'                   => trim((string)($_POST['name'] ?? '')),
            'archetype_key'          => trim((string)($_POST['archetype_key'] ?? '')),
            'badge_text'             => trim((string)($_POST['badge_text'] ?? 'Archetype')),
            'description'            => trim((string)($_POST['description'] ?? '')),
            'best_for'               => trim((string)($_POST['best_for'] ?? '')),
            'checklists_text'        => trim((string)($_POST['checklists_text'] ?? '')),
            'recommended_stack_text' => trim((string)($_POST['recommended_stack_text'] ?? '')),
            'time_to_market'         => trim((string)($_POST['time_to_market'] ?? '2 – 4 Weeks')),
            'investment_tier'        => trim((string)($_POST['investment_tier'] ?? 'Growth Tier')),
            'scalability_ceiling'    => trim((string)($_POST['scalability_ceiling'] ?? 'High')),
            'seo_dominance'          => trim((string)($_POST['seo_dominance'] ?? 'High Authority')),
            'maintenance_overhead'   => trim((string)($_POST['maintenance_overhead'] ?? 'Low')),
            'typical_team_pod'       => trim((string)($_POST['typical_team_pod'] ?? '2 Engineers')),
            'order_num'              => (int)($_POST['order_num'] ?? 0),
            'is_active'              => !empty($_POST['is_active']) ? 1 : 0
        ];

        if (empty($data['name'])) {
            http_response_code(422);
            echo json_encode(['success' => false, 'error' => 'Solution Archetype name is required.']);
            exit;
        }

        $result = $model->saveAdvisorArchetype($data, $userId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Instant toggle of solution status via AJAX
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
        $userId = (int)($_SESSION['admin_user']['id'] ?? 1);

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid Solution ID.']);
            exit;
        }

        $model = new AdminModel();
        $result = $model->toggleAdvisorArchetypeStatus($id, $isActive, $userId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Duplicate / Clone an archetype
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
            echo json_encode(['success' => false, 'error' => 'Invalid Solution ID.']);
            exit;
        }

        $model = new AdminModel();
        $result = $model->duplicateAdvisorArchetype($id, $userId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Delete an archetype
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
            echo json_encode(['success' => false, 'error' => 'Invalid Solution ID.']);
            exit;
        }

        $model = new AdminModel();
        $result = $model->deleteAdvisorArchetype($id, $userId);

        if (!$result['success']) {
            http_response_code(400);
        }

        echo json_encode($result);
        exit;
    }

    /**
     * Export Archetypes Catalog as CSV
     */
    public function exportCsv(): void {
        AuthMiddleware::check();

        $model = new AdminModel();
        $archetypes = $model->getAdvisorArchetypes();

        $filename = 'clickcodex_solution_archetypes_' . date('Y-m-d_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        // UTF-8 BOM for proper Excel display
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // CSV Header
        fputcsv($output, [
            'ID',
            'Archetype Key',
            'Solution Name',
            'Badge Text',
            'Best For',
            'Time to Market',
            'Investment Tier',
            'Scalability Ceiling',
            'SEO Dominance',
            'Typical Team Pod',
            'Recommended Stack',
            'Status'
        ]);

        foreach ($archetypes as $arch) {
            $stackStr = !empty($arch['recommended_stack_arr']) ? implode(', ', $arch['recommended_stack_arr']) : '';
            fputcsv($output, [
                $arch['id'],
                $arch['archetype_key'],
                $arch['name'],
                $arch['badge_text'],
                $arch['best_for'],
                $arch['time_to_market'],
                $arch['investment_tier'],
                $arch['scalability_ceiling'],
                $arch['seo_dominance'],
                $arch['typical_team_pod'],
                $stackStr,
                ((int)$arch['is_active'] === 1) ? 'Active' : 'Inactive'
            ]);
        }

        fclose($output);
        exit;
    }
}
