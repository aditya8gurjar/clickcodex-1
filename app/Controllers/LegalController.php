<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\LegalModel;

class LegalController {
    /**
     * Render Privacy Policy
     */
    public function privacy(): void {
        $model = new LegalModel();

        $slug = 'privacy-policy';
        $settings = $model->getSettings();
        $seo = $model->getSeoMetadata($slug);
        $page = $model->getPageData($slug);

        $activeNav = '';
        $extraCss = (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/css/legal.css';
        $extraHead = '';

        $breadcrumbs = [
            [
                'name' => 'Privacy Policy',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/privacy-policy'
            ]
        ];

        include __DIR__ . '/../Views/privacy-policy.php';
    }

    /**
     * Render Terms of Service
     */
    public function terms(): void {
        $model = new LegalModel();

        $slug = 'terms-of-service';
        $settings = $model->getSettings();
        $seo = $model->getSeoMetadata($slug);
        $page = $model->getPageData($slug);

        $activeNav = '';
        $extraCss = (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/css/legal.css';
        $extraHead = '';

        $breadcrumbs = [
            [
                'name' => 'Terms of Service',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/terms-of-service'
            ]
        ];

        include __DIR__ . '/../Views/terms-of-service.php';
    }
}
