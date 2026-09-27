<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\PricingModel;

class PricingController {
    public function index(): void {
        $model = new PricingModel();

        $settings = $model->getSettings();
        $seo = $model->getSeoMetadata();
        $page = $model->getPageData();
        $sections = $model->getPageSections();
        $plans = $model->getPlansWithFeatures();
        $inclusions = $model->getInclusions();
        $faqs = $model->getFaqs();

        $activeNav = 'pricing';
        $extraCss = (defined('BASE_URL') ? BASE_URL : '') . '/public/assets/css/pricing.css';
        $extraHead = '';
        $breadcrumbs = [
            [
                'name' => 'Pricing & Models',
                'url' => (defined('BASE_URL') ? BASE_URL : '') . '/pricing'
            ]
        ];

        include __DIR__ . '/../Views/pricing.php';
    }
}
