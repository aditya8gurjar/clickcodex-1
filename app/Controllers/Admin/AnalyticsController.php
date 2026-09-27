<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Admin\AdminModel;
use App\Middleware\AuthMiddleware;

class AnalyticsController {
    /**
     * Render the Advanced Analytics & Growth Intelligence Dashboard
     */
    public function index(): void {
        AuthMiddleware::check();

        $model = new AdminModel();
        $timeframe = trim((string)($_GET['timeframe'] ?? '30d'));
        if (!in_array($timeframe, ['7d', '30d', '90d', 'all'], true)) {
            $timeframe = '30d';
        }

        $analytics   = $model->getComprehensiveAnalytics($timeframe);
        $stats       = $model->getDashboardStats();

        $currentUser = $_SESSION['admin_user'] ?? [
            'id' => 1,
            'name' => 'Lead Architect Admin',
            'role' => 'super_admin',
            'email' => 'admin@clickcodex.com',
            'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=face'
        ];

        $pageTitle = "Advanced Analytics & Growth Intelligence | ClickCodex Studio Console";
        $topbarTitle = "Advanced Analytics & Intelligence";
        $activeNav = 'analytics';

        include __DIR__ . '/../../Views/admin/analytics.php';
    }

    /**
     * Fetch analytics data as JSON for dynamic timeframe switching via AJAX
     */
    public function getData(): void {
        AuthMiddleware::check();
        header('Content-Type: application/json; charset=utf-8');

        $timeframe = trim((string)($_GET['timeframe'] ?? '30d'));
        if (!in_array($timeframe, ['7d', '30d', '90d', 'all'], true)) {
            $timeframe = '30d';
        }

        $model = new AdminModel();
        $analytics = $model->getComprehensiveAnalytics($timeframe);

        echo json_encode(['success' => true, 'analytics' => $analytics]);
        exit;
    }

    /**
     * Export analytics metrics to CSV
     */
    public function exportCsv(): void {
        AuthMiddleware::check();

        $model = new AdminModel();
        $timeframe = trim((string)($_GET['timeframe'] ?? '30d'));
        $data = $model->getComprehensiveAnalytics($timeframe);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="clickcodex_analytics_' . date('Y-m-d_His') . '.csv"');

        $out = fopen('php://output', 'w');

        // 1. KPI Summary
        fputcsv($out, ['=== EXECUTIVE TELEMETRY KPIS ===']);
        fputcsv($out, ['Metric', 'Value']);
        foreach ($data['kpis'] as $k => $v) {
            fputcsv($out, [ucwords(str_replace('_', ' ', $k)), $v]);
        }
        fputcsv($out, []);

        // 2. Conversion Funnel
        fputcsv($out, ['=== CONVERSION FUNNEL METRICS ===']);
        fputcsv($out, ['Stage', 'Volume', 'Conversion Rate %']);
        foreach ($data['funnel'] as $f) {
            fputcsv($out, [$f['stage'], $f['count'], $f['pct'] . '%']);
        }
        fputcsv($out, []);

        // 3. Top Performing Whitepapers
        fputcsv($out, ['=== TOP TECHNICAL ARTICLES ENGAGEMENT ===']);
        fputcsv($out, ['Title', 'Category', 'Views', 'Likes', 'Read Time (Mins)', 'Engagement Rate %']);
        foreach ($data['top_articles'] as $art) {
            fputcsv($out, [
                $art['title'],
                $art['category_name'] ?? 'Architecture',
                $art['views_count'],
                $art['likes_count'],
                $art['reading_time_minutes'],
                $art['engagement_rate'] . '%'
            ]);
        }
        fputcsv($out, []);

        // 4. Timeline Trends
        fputcsv($out, ['=== TIMELINE TREND VELOCITY ===']);
        fputcsv($out, ['Date', 'Inquiries', 'Advisor Diagnostic Runs', 'Article Views']);
        foreach ($data['timeline_trends'] as $t) {
            fputcsv($out, [$t['date'], $t['inquiries'], $t['advisor_runs'], $t['article_views']]);
        }

        fclose($out);
        exit;
    }
}
